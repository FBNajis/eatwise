import 'dart:async';
import 'dart:io';
import 'dart:convert';
import 'package:flutter/foundation.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:http/http.dart' as http;
import 'package:http_parser/http_parser.dart';
import 'package:image_picker/image_picker.dart';
import 'package:get_storage/get_storage.dart';
import 'package:image/image.dart' as img;

class EditdeleterecipeController extends GetxController {
  final TextEditingController dishNameController = TextEditingController();
  final TextEditingController ingredientsController = TextEditingController();
  final TextEditingController descriptionController = TextEditingController();
  final TextEditingController costController = TextEditingController();
  final TextEditingController timeController = TextEditingController();
  final TextEditingController instructionsController = TextEditingController();

  final ImagePicker picker = ImagePicker();
  Rx<XFile?> selectedImage = Rx<XFile?>(null);
  RxString selectedCategory = "".obs;
  var isLoading = false.obs;
  final box = GetStorage();

  int? recipeId;
  String? existingImageUrl;
  bool _isCancelled = false;

  @override
  void onClose() {
    _isCancelled = true;
    super.onClose();
  }

  @override
  void onInit() {
    super.onInit();
    final recipe = Get.arguments as Map<String, dynamic>;
    setRecipeData(recipe);
  }

  void setRecipeData(Map<String, dynamic> recipe) {
    recipeId = recipe['id'];
    dishNameController.text = recipe['name'] ?? '';
    descriptionController.text = recipe['description'] ?? '';
    costController.text = recipe['cost_estimation'].toString();
    timeController.text = recipe['cooking_time'].toString();
    ingredientsController.text = recipe['ingredients'] ?? '';
    instructionsController.text = recipe['instructions'] ?? '';
    selectedCategory.value = recipe['tag'] ?? '';
    existingImageUrl = recipe['image_path'];
  }

  Future<void> pickImageFromGallery() async {
    final image = await picker.pickImage(source: ImageSource.gallery);
    if (image != null) selectedImage.value = image;
  }

  Future<void> pickImageFromCamera() async {
    final image = await picker.pickImage(source: ImageSource.camera);
    if (image != null) selectedImage.value = image;
  }

  bool validateInputs() {
    if (dishNameController.text.trim().isEmpty ||
        ingredientsController.text.trim().isEmpty ||
        descriptionController.text.trim().isEmpty ||
        costController.text.trim().isEmpty ||
        timeController.text.trim().isEmpty ||
        instructionsController.text.trim().isEmpty ||
        selectedCategory.value.isEmpty) {
      Get.snackbar("Validation", "Please complete all fields.",
          snackPosition: SnackPosition.BOTTOM);
      return false;
    }
    return true;
  }

  Future<void> updateRecipe() async {
    if (!validateInputs()) return;

    isLoading.value = true;
    _isCancelled = false;
    _showLoadingDialog();

    final token = box.read('token');
    if (token == null || recipeId == null) {
      Get.back();
      Get.snackbar("Error", "Missing token or recipe ID");
      return;
    }

    final uri = Uri.parse('http://10.20.30.228:8000/api/recipes/$recipeId');
    final recipeData = {
      'name': dishNameController.text.trim(),
      'description': descriptionController.text.trim(),
      'cost_estimation': costController.text.trim(),
      'cooking_time': timeController.text.trim(),
      'ingredients': ingredientsController.text.trim(),
      'instructions': instructionsController.text.trim(),
      'tag': selectedCategory.value
    };

    try {
      final request = http.MultipartRequest('POST', uri)
        ..fields.addAll(recipeData)
        ..headers['Accept'] = 'application/json'
        ..headers['Authorization'] = 'Bearer $token'
        ..headers['X-HTTP-Method-Override'] = 'PUT';

      if (selectedImage.value != null) {
        final imageFile = File(selectedImage.value!.path);
        final optimized =
            await compute(optimizeImage, await imageFile.readAsBytes());

        request.files.add(
          http.MultipartFile.fromBytes(
            'image',
            optimized,
            filename: 'updated.jpg',
            contentType: MediaType('image', 'jpeg'),
          ),
        );
      }

      final client = http.Client();
      final streamedResponse = await client.send(request);
      final response = await http.Response.fromStream(streamedResponse);
      Get.back(); // close loading

      if (response.statusCode == 200) {
        _showUpdateSuccessDialog();
      } else {
        final responseJson = jsonDecode(response.body);
        if (responseJson is Map && responseJson.containsKey('errors')) {
          final errors = responseJson['errors'] as Map<String, dynamic>;
          final firstError = errors.values.first[0];
          Get.snackbar("Validation Error", firstError.toString());
        } else {
          Get.snackbar(
              "Error", responseJson['message'] ?? "Failed to update recipe",
              snackPosition: SnackPosition.BOTTOM,
              backgroundColor: Colors.red,
              colorText: Colors.white);
        }
      }
    } catch (e) {
      Get.back();
      Get.snackbar("Error", "Something went wrong");
      debugPrint("Update error: $e");
    } finally {
      isLoading.value = false;
    }
  }

  Future<void> deleteRecipe() async {
    final token = box.read('token');
    if (token == null || recipeId == null) {
      Get.snackbar("Error", "Missing token or recipe ID");
      return;
    }

    isLoading.value = true;
    final uri = Uri.parse('http://10.20.30.228:8000/api/recipes/$recipeId');

    try {
      final response = await http.delete(uri, headers: {
        'Accept': 'application/json',
        'Authorization': 'Bearer $token',
      });

      if (response.statusCode == 200) {
        _showDeleteSuccessDialog();
      } else {
        Get.snackbar("Error", "Failed to delete recipe");
      }
    } catch (e) {
      Get.snackbar("Error", "Something went wrong during delete");
      debugPrint("Delete error: $e");
    } finally {
      isLoading.value = false;
    }
  }

  void _showLoadingDialog() {
    Get.dialog(
      Dialog(
        shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(20)),
        child: Padding(
          padding: const EdgeInsets.all(24),
          child: Column(
            mainAxisSize: MainAxisSize.min,
            children: const [
              CircularProgressIndicator(),
              SizedBox(height: 16),
              Text("Please wait a moment"),
            ],
          ),
        ),
      ),
      barrierDismissible: false,
    );
  }

  void _showUpdateSuccessDialog() {
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
                'Recipe Successfully Updated!',
                style: TextStyle(fontSize: 18, fontWeight: FontWeight.bold),
                textAlign: TextAlign.center,
              ),
              SizedBox(height: 10),
              Text(
                'Your changes have been saved.\nCheck your updated recipe now!',
                style: TextStyle(fontSize: 12, color: Colors.grey),
                textAlign: TextAlign.center,
              ),
            ],
          ),
        ),
      ),
      barrierDismissible: false,
    );
    Future.delayed(Duration(seconds: 2), () => Get.offNamed('/recipe'));
  }

  void _showDeleteSuccessDialog() {
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
                'Recipe Deleted!',
                style: TextStyle(
                    fontSize: 18,
                    fontWeight: FontWeight.bold,
                    color: Colors.red),
                textAlign: TextAlign.center,
              ),
              SizedBox(height: 10),
              Text(
                'The recipe has been successfully deleted.',
                style: TextStyle(fontSize: 12, color: Colors.grey),
                textAlign: TextAlign.center,
              ),
            ],
          ),
        ),
      ),
      barrierDismissible: false,
    );

    // Navigate to recipe page with a forced reload after a 2-second delay
    Future.delayed(Duration(seconds: 2), () {
      Get.offAllNamed(
          '/recipe'); // This will remove all previous routes and create a fresh instance
      // Alternatively, if you want to keep navigation history but still refresh the page:
      // Get.offNamed('/recipe', preventDuplicates: false);
    });
  }
}

Uint8List optimizeImage(Uint8List bytes) {
  final image = img.decodeImage(bytes);
  if (image == null) throw Exception("Failed to decode image");

  int targetHeight = 480;
  int targetWidth = (targetHeight * image.width / image.height).round();
  if (targetWidth > 854) {
    targetWidth = 854;
    targetHeight = (targetWidth * image.height / image.width).round();
  }

  final resized = img.copyResize(image,
      width: targetWidth,
      height: targetHeight,
      interpolation: img.Interpolation.average);

  return img.encodeJpg(resized, quality: 80);
}