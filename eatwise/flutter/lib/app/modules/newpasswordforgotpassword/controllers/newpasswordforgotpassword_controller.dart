import 'dart:convert';

import 'package:eatwise/app/routes/app_pages.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:http/http.dart' as http;

class NewpasswordforgotpasswordController extends GetxController {
  final newPasswordController = TextEditingController();
  final confirmPasswordController = TextEditingController();
  RxBool isLoading = false.obs;
  RxBool isPasswordVisible = true.obs;
  late String email;

  @override
  void onInit() {
    super.onInit();
    if (Get.arguments is Map<String, dynamic>) {
      final args = Get.arguments as Map<String, dynamic>;
      email = args['email'] ?? '';
      print("Email diterima untuk reset password: $email");
    } else {
      email = '';
      print("Error: arguments bukan Map<String, dynamic>");
    }
  }

  bool validatePasswords() {
    final newPassword = newPasswordController.text.trim();
    final confirmPassword = confirmPasswordController.text.trim();

    if (newPassword.isEmpty || confirmPassword.isEmpty) {
      Get.snackbar('Error', 'Please enter both passwords',
          snackPosition: SnackPosition.BOTTOM);
      return false;
    }

    if (newPassword != confirmPassword) {
      Get.snackbar('Error', 'Passwords do not match',
          snackPosition: SnackPosition.BOTTOM);
      return false;
    }

    if (newPassword.length < 6) {
      Get.snackbar('Error', 'Password must be at least 6 characters',
          snackPosition: SnackPosition.BOTTOM);
      return false;
    }

    return true;
  }

  void resetPassword() async {
    final newPassword = newPasswordController.text.trim();
    final confirmPassword = confirmPasswordController.text.trim();

    // Validasi
    if (newPassword.isEmpty || confirmPassword.isEmpty) {
      Get.snackbar('Error', 'Please enter both passwords',
          snackPosition: SnackPosition.BOTTOM);
      return;
    }

    if (newPassword != confirmPassword) {
      Get.snackbar('Error', 'Passwords do not match',
          snackPosition: SnackPosition.BOTTOM);
      return;
    }

    if (newPassword.length < 6) {
      Get.snackbar('Error', 'Password must be at least 6 characters',
          snackPosition: SnackPosition.BOTTOM);
      return;
    }

    try {
      isLoading.value = true;

      final url = Uri.parse('http://10.0.2.2:8000/api/reset-password');
      final response = await http.post(
        url,
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json', // ✅ Tambahkan ini
        },
        body: jsonEncode({
          'email': email,
          'new_password': newPassword,
        }),
      );

      final responseData = jsonDecode(response.body);

      if (response.statusCode == 200) {
        Get.defaultDialog(
          title: 'Password Reset',
          middleText: 'Your password has been successfully reset',
          confirmTextColor: Colors.white,
          buttonColor: const Color(0xffCE181B),
          textConfirm: 'Login',
          onConfirm: () {
            Get.offNamed(Routes.LOGIN);
          },
        );
      } else {
        Get.snackbar(
          'Failed',
          responseData['message'] ?? 'Failed to reset password',
          snackPosition: SnackPosition.BOTTOM,
        );
      }
    } catch (e) {
      print(e);
      Get.snackbar(
        'Error',
        'Something went wrong. Please try again.',
        snackPosition: SnackPosition.BOTTOM,
      );
    } finally {
      isLoading.value = false;
    }
  }

  void togglePasswordVisibility() {
    isPasswordVisible.value = !isPasswordVisible.value;
  }

  @override
  void onClose() {
    newPasswordController.dispose();
    confirmPasswordController.dispose();
    super.onClose();
  }
}
