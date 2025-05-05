import 'dart:io';
import 'dart:async';
import 'package:flutter/foundation.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:image_picker/image_picker.dart';
import 'package:http/http.dart' as http;
import 'package:http_parser/http_parser.dart';
import 'package:image/image.dart' as img;
import 'package:get_storage/get_storage.dart';

class AddrecipeController extends GetxController {
  final TextEditingController dishNameController = TextEditingController();
  final TextEditingController ingredientsController = TextEditingController();
  final TextEditingController descriptionController = TextEditingController();
  final TextEditingController costController = TextEditingController();
  final TextEditingController timeController = TextEditingController();
  final TextEditingController instructionsController = TextEditingController();

  final ImagePicker picker = ImagePicker();
  Rx<XFile?> selectedImage = Rx<XFile?>(null);
  RxString? selectedCategory = RxString("");
  var isLoading = false.obs;

  final box = GetStorage();
  bool _isCancelled = false;

  @override
  void onClose() {
    _isCancelled = true;
    debugPrint("Upload dibatalkan karena keluar dari halaman");
    super.onClose();
  }

  Future<void> pickImageFromGallery() async {
    final image = await picker.pickImage(
      source: ImageSource.gallery,
      imageQuality: 85,
      maxWidth: 854,
      maxHeight: 480,
    );
    selectedImage.value = image;
    debugPrint("Gambar diambil dari galeri: ${image?.path}");
  }

  Future<void> pickImageFromCamera() async {
    try {
      // Gunakan kompres kualitas untuk mengurangi ukuran file
      final XFile? image = await ImagePicker().pickImage(
        source: ImageSource.camera,
        imageQuality: 70, // Kompresi kualitas gambar
        maxWidth: 800,    // Batasi lebar maksimum
        maxHeight: 800,   // Batasi tinggi maksimum
      );
      
      if (image != null) {
        // Proses gambar di background untuk menghindari UI freeze
        await _processImageInBackground(image);
      }
    } catch (e) {
      print('Error saat mengambil gambar: $e');
      rethrow; // Lempar kembali error untuk ditangani di UI
    }
  }

  Future<void> _processImageInBackground(XFile image) async {
    try {
      selectedImage.value = image;
    } catch (e) {
      print('Error saat memproses gambar: $e');
      throw e;
    }
  }

  bool validateInputs() {
    if (dishNameController.text.trim().isEmpty ||
        ingredientsController.text.trim().isEmpty ||
        descriptionController.text.trim().isEmpty ||
        costController.text.trim().isEmpty ||
        timeController.text.trim().isEmpty ||
        instructionsController.text.trim().isEmpty ||
        selectedCategory?.value == null ||
        selectedCategory!.value.isEmpty ||
        selectedImage.value == null) {
      Get.snackbar("Validation", "Please complete all fields.",
          snackPosition: SnackPosition.BOTTOM);
      return false;
    }
    return true;
  }

  void clearForm() {
    dishNameController.clear();
    ingredientsController.clear();
    descriptionController.clear();
    costController.clear();
    timeController.clear();
    instructionsController.clear();
    selectedCategory?.value = "";
    selectedImage.value = null;
  }

  Future<void> submitRecipe() async {
    if (!validateInputs()) return;

    try {
      isLoading.value = true;
      _isCancelled = false;
      _showLoadingDialog();

      final token = box.read('token');
      if (token == null) {
        Get.back(); // close loading
        Get.snackbar("Error", "User token not found");
        return;
      }

      final uri = Uri.parse('http://10.20.30.228:8000/api/recipes');

      final recipeData = {
        'name': dishNameController.text.trim(),
        'description': descriptionController.text.trim(),
        'cost_estimation': costController.text.trim(),
        'cooking_time': timeController.text.trim(),
        'ingredients': ingredientsController.text.trim(),
        'instructions': instructionsController.text.trim(),
        'tag': selectedCategory?.value ?? "",
      };

      debugPrint("Mengirim data resep: $recipeData");

      await _uploadRecipeWithOptimizedImage(uri, token, recipeData);
    } catch (e) {
      if (!_isCancelled) {
        Get.back();
        Get.snackbar("Error", "Something went wrong.",
            snackPosition: SnackPosition.BOTTOM,
            backgroundColor: Colors.red,
            colorText: Colors.white);
        debugPrint("Error saat submit: $e");
      }
    } finally {
      isLoading.value = false;
    }
  }

  Future<void> _uploadRecipeWithOptimizedImage(
      Uri uri, String token, Map<String, String> recipeData) async {
    try {
      if (_isCancelled) return;

      final File imageFile = File(selectedImage.value!.path);
      final fileSize = await imageFile.length();
      debugPrint("Ukuran file asli: ${fileSize} bytes");

      final request = http.MultipartRequest('POST', uri)
        ..headers['Accept'] = 'application/json'
        ..headers['Authorization'] = 'Bearer $token'
        ..fields.addAll(recipeData);

      Uint8List optimizedImageBytes =
          await compute(optimizeImage, await imageFile.readAsBytes());

      debugPrint(
          "Ukuran gambar setelah kompresi: ${optimizedImageBytes.length} bytes");
      debugPrint(
          "Persentase penurunan: ${((fileSize - optimizedImageBytes.length) / fileSize * 100).toStringAsFixed(2)}%");

      request.files.add(
        http.MultipartFile.fromBytes(
          'image',
          optimizedImageBytes,
          filename: 'recipe_image.jpg',
          contentType: MediaType('image', 'jpeg'),
        ),
      );

      final client = http.Client();
      try {
        final streamedResponse = await client.send(request);
        final response = await http.Response.fromStream(streamedResponse);
        Get.back(); // close loading

        debugPrint("Status code: ${response.statusCode}");
        debugPrint("Response body: ${response.body}");

        if (response.statusCode == 201) {
          _showSuccessDialog();
        } else {
          Get.snackbar("Error", "Failed to upload recipe",
              snackPosition: SnackPosition.BOTTOM,
              backgroundColor: Colors.red,
              colorText: Colors.white);
        }
      } finally {
        client.close();
      }
    } catch (e) {
      if (!_isCancelled) {
        Get.back();
        Get.snackbar("Error", "Failed to upload image",
            snackPosition: SnackPosition.BOTTOM,
            backgroundColor: Colors.red,
            colorText: Colors.white);
        debugPrint("Error saat upload gambar: $e");
      }
    }
  }

  void _showSuccessDialog() {
    clearForm();
    Get.dialog(
      Dialog(
        shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(20)),
        child: Container(
          padding: EdgeInsets.all(24),
          child: Column(
            mainAxisSize: MainAxisSize.min,
            children: [
              Image.asset('assets/images/hambuger.png',
                  width: 140, height: 140),
              SizedBox(height: 15),
              Text(
                'Recipe Successfully Created!',
                style: TextStyle(fontSize: 18, fontWeight: FontWeight.bold),
                textAlign: TextAlign.center,
              ),
              SizedBox(height: 10),
              Text(
                'Your recipe has been created.\nCheck your recipe now!',
                style: TextStyle(fontSize: 12, color: Colors.grey),
                textAlign: TextAlign.center,
              ),
            ],
          ),
        ),
      ),
      barrierDismissible: false,
    );
    Future.delayed(Duration(seconds: 2), () {
      Get.offAllNamed(
          '/recipe'); 
    });
  }

  void _showLoadingDialog() {
    Get.dialog(
      Dialog(
        shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(20)),
        child: Padding(
          padding: const EdgeInsets.all(24),
          child: Column(
            mainAxisSize: MainAxisSize.min,
            children: [
              Image.asset('assets/images/hambuger.png',
                  width: 100, height: 100),
              const SizedBox(height: 20),
              const Text(
                'Uploading Recipe...',
                style: TextStyle(fontSize: 16, fontWeight: FontWeight.bold),
              ),
              const SizedBox(height: 16),
              const CircularProgressIndicator(),
              const SizedBox(height: 12),
              const Text(
                'Please wait a moment',
                style: TextStyle(fontSize: 12, color: Colors.grey),
              ),
            ],
          ),
        ),
      ),
      barrierDismissible: false,
    );
  }
}

// Metode optimasi gambar untuk 480p
Uint8List optimizeImage(Uint8List bytes) {
  final image = img.decodeImage(bytes);
  if (image == null) throw Exception("Failed to decode image");

  // Mengatur resolusi 480p
  int targetHeight = 480;
  int targetWidth = (targetHeight * image.width / image.height).round();

  // Batasi lebar maksimum ke 854 (480p standard)
  if (targetWidth > 854) {
    targetWidth = 854;
    targetHeight = (targetWidth * image.height / image.width).round();
  }

  // Menggunakan Interpolation.average untuk hasil terbaik
  final resized = img.copyResize(
    image,
    width: targetWidth,
    height: targetHeight,
    interpolation: img.Interpolation.average,
  );

  // Menggunakan quality 80 untuk keseimbangan ukuran dan kualitas yang baik
  return img.encodeJpg(resized, quality: 80);
}
