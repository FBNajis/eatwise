import 'dart:convert';
import 'dart:io';
import 'dart:async';
import 'package:flutter/foundation.dart';
import 'package:get/get.dart';
import 'package:flutter/material.dart';
import 'package:eatwise/app/routes/app_pages.dart';
import 'package:get_storage/get_storage.dart';
import 'package:http/http.dart' as http;
import 'package:image_picker/image_picker.dart';
import 'package:http_parser/http_parser.dart';
import '../../addrecipe/controllers/addrecipe_controller.dart';

class ProfileController extends GetxController {
  final usernameController = TextEditingController();
  final nameController = TextEditingController();
  final phoneController = TextEditingController();
  final emailController = TextEditingController();
  final passwordController = TextEditingController();
  final confirmPasswordController = TextEditingController();

  final box = GetStorage();
  final RxBool obscurePassword = true.obs;
  final RxBool obscureConfirmPassword = true.obs;
  final ImagePicker picker = ImagePicker();
  Rx<XFile?> selectedImage = Rx<XFile?>(null);

  String? userEmail;
  RxBool isLoading = false.obs;

  RxString imageUrl = ''.obs;

  void updateImageUrl(String url) {
    imageUrl.value = url;
  }

  @override
  void onInit() {
    super.onInit();
    userEmail = box.read('email');
    print('EMAIL DARI BOX: $userEmail');

    if (userEmail != null) {
      fetchUserProfile(userEmail!);
    } else {
      Get.snackbar('Error', 'Email not found in session');
    }
  }

  void fetchUserProfile(String email) async {
    try {
      isLoading.value = true;

      final response = await http.get(
        Uri.parse('http://10.20.30.228:8000/api/user?email=$email'),
        headers: {
          'Accept': 'application/json',
        },
      );

      if (response.statusCode == 200) {
        final responseBody = jsonDecode(response.body);
        final data = responseBody['user'];

        if (data != null) {
          usernameController.text = data['username'] ?? '';
          nameController.text = data['name'] ?? '';
          phoneController.text = data['phone'] ?? '';
          emailController.text = data['email'] ?? '';
          imageUrl.value = data['image'] ?? '';

          passwordController.text = '';
          confirmPasswordController.text = '';
        } else {
          Get.snackbar('Error', 'No user data received');
        }
      } else {
        Get.snackbar('Error', 'Failed to fetch profile data');
      }
    } catch (e) {
      print(e);
      Get.snackbar('Error', 'Something went wrong while fetching profile');
    } finally {
      isLoading.value = false;
    }
  }

  void togglePasswordVisibility() {
    obscurePassword.value = !obscurePassword.value;
  }

  void toggleConfirmPasswordVisibility() {
    obscureConfirmPassword.value = !obscureConfirmPassword.value;
  }

  void updateUserProfile() async {
    try {
      isLoading.value = true;
      final token = box.read('token');
      var uri = Uri.parse('http://10.20.30.228:8000/api/user/update');
      var request = http.MultipartRequest('POST', uri);

      request.headers.addAll({
        'Accept': 'application/json',
        'Authorization': 'Bearer $token',
      });

      request.fields['email'] = emailController.text;
      request.fields['username'] = usernameController.text;
      request.fields['fullname'] = nameController.text;
      request.fields['phone_number'] = phoneController.text;
      request.fields['password'] = passwordController.text;

      if (selectedImage.value != null) {
        File imageFile = File(selectedImage.value!.path);

        Uint8List imageBytes =
            await compute(optimizeImage, await imageFile.readAsBytes());

        request.files.add(
          http.MultipartFile.fromBytes(
            'image',
            imageBytes,
            filename: 'user_image.jpg',
            contentType: MediaType('image', 'jpeg'),
          ),
        );
      }

      var streamedResponse = await request.send();
      var response = await http.Response.fromStream(streamedResponse);

      if (response.statusCode == 200) {
        Get.snackbar('Success', 'Profile updated successfully');
      } else {
        debugPrint(response.body);
        Get.snackbar('Error', 'Failed to update profile');
      }
    } catch (e) {
      debugPrint(e.toString());
      Get.snackbar('Error', 'Something went wrong');
    } finally {
      isLoading.value = false;
    }
  }

  void logout() {
    box.remove('token');
    box.remove('email');
    Get.offAllNamed(Routes.LOGIN);
  }

  bool validateProfile() {
    if (nameController.text.isEmpty) {
      Get.snackbar('Error', 'Name cannot be empty',
          backgroundColor: Colors.red, colorText: Colors.white);
      return false;
    }
    if (phoneController.text.isEmpty) {
      Get.snackbar('Error', 'Phone number cannot be empty',
          backgroundColor: Colors.red, colorText: Colors.white);
      return false;
    }
    if (emailController.text.isEmpty ||
        !GetUtils.isEmail(emailController.text)) {
      Get.snackbar('Error', 'Please enter a valid email',
          backgroundColor: Colors.red, colorText: Colors.white);
      return false;
    }
    return true;
  }

  Future<void> uploadImageWithData({
    required Uri uri,
    required String token,
    required File imageFile,
    required Map<String, String> fields,
    required void Function(http.Response response) onSuccess,
    required void Function(Object error)? onError,
  }) async {
    try {
      final fileSize = await imageFile.length();
      debugPrint("Ukuran file asli: ${fileSize} bytes");

      final request = http.MultipartRequest('POST', uri)
        ..headers['Accept'] = 'application/json'
        ..headers['Authorization'] = 'Bearer $token'
        ..fields.addAll(fields);

      Uint8List optimizedImageBytes =
          await compute(optimizeImage, await imageFile.readAsBytes());

      debugPrint(
          "Ukuran gambar setelah kompresi: ${optimizedImageBytes.length} bytes");

      request.files.add(
        http.MultipartFile.fromBytes(
          'image',
          optimizedImageBytes,
          filename: 'upload_image.jpg',
          contentType: MediaType('image', 'jpeg'),
        ),
      );

      final client = http.Client();
      try {
        final streamedResponse = await client.send(request);
        final response = await http.Response.fromStream(streamedResponse);

        debugPrint("Status code: ${response.statusCode}");
        debugPrint("Response body: ${response.body}");

        onSuccess(response);
      } finally {
        client.close();
      }
    } catch (e) {
      if (onError != null) onError(e);
    }
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
    final image = await picker.pickImage(
      source: ImageSource.camera,
      imageQuality: 85,
      maxWidth: 854,
      maxHeight: 480,
    );
    selectedImage.value = image;
    debugPrint("Gambar diambil dari kamera: ${image?.path}");
  }

  @override
  void onClose() {
    usernameController.dispose();
    nameController.dispose();
    phoneController.dispose();
    emailController.dispose();
    passwordController.dispose();
    confirmPasswordController.dispose();
    super.onClose();
  }
}
