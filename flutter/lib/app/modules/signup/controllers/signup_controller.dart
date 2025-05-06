import 'dart:convert';
import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:http/http.dart' as http;
import 'package:eatwise/app/routes/app_pages.dart';

class SignupController extends GetxController {
  final usernameController = TextEditingController();
  final fullNameController = TextEditingController();
  final phoneController = TextEditingController();
  final emailController = TextEditingController();
  final passwordController = TextEditingController();
  final confirmPasswordController = TextEditingController();
  var isPasswordHidden = true.obs;
  var isConfirmPasswordHidden = true.obs;

  Future<void> signUp() async {
    final username = usernameController.text.trim();
    final fullName = fullNameController.text.trim();
    final phone = phoneController.text.trim();
    final email = emailController.text.trim();
    final password = passwordController.text;
    final confirmPassword = confirmPasswordController.text;

    if (username.isEmpty ||
        fullName.isEmpty ||
        phone.isEmpty ||
        email.isEmpty ||
        password.isEmpty ||
        confirmPassword.isEmpty) {
      Get.snackbar("Error", "Please fill all fields");
      return;
    }

    if (password.length < 8) {
      Get.snackbar("Error", "Password must be at least 8 characters long");
      return;
    }

    if (password != confirmPassword) {
      Get.snackbar("Error", "Passwords do not match");
      return;
    }

    try {
      // 1. Check username and email availability
      final checkResponse = await http.post(
        Uri.parse('http://192.168.27.30:8000/api/check-availability'),
        headers: {
          'Accept': 'application/json',
          'Content-Type': 'application/json',
        },
        body: jsonEncode({
          'username': username,
          'email': email,
        }),
      );

      if (checkResponse.statusCode != 200) {
        final error = jsonDecode(checkResponse.body);
        Get.snackbar("Unavailable",
            error['message'] ?? "Username or Email already taken");
        return;
      }

      // 2. Send OTP
      final otpResponse = await http.post(
        Uri.parse('http://192.168.27.30:8000/api/send-otp'),
        headers: {
          'Accept': 'application/json',
          'Content-Type': 'application/json',
        },
        body: jsonEncode({
          'email': email,
          'fullname': fullName,
          'username': username,
        }),
      );

      if (otpResponse.statusCode == 200) {
        Get.snackbar("OTP Sent", "Please check your email");

        final userData = {
          'username': username,
          'fullname': fullName,
          'phone_number': phone,
          'email': email,
          'password': password,
        };

        Get.offNamed(Routes.OTPCODE,
            arguments: {'email': email, 'userData': userData});
      } else {
        final error = jsonDecode(otpResponse.body);
        Get.snackbar("Failed", error['message'] ?? "Failed to send OTP");
      }
    } catch (e) {
      Get.snackbar("Error", "Exception: $e");
    }
  }

  @override
  void onClose() {
    usernameController.dispose();
    fullNameController.dispose();
    phoneController.dispose();
    emailController.dispose();
    passwordController.dispose();
    confirmPasswordController.dispose();
    super.onClose();
  }
}
