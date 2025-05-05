import 'dart:convert';
import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:http/http.dart' as http;
import 'package:eatwise/app/routes/app_pages.dart';
import 'package:get_storage/get_storage.dart';

class LoginController extends GetxController {
  final emailController = TextEditingController();
  final passwordController = TextEditingController();
  final box = GetStorage();

  Future<void> login() async {
    final email = emailController.text.trim();
    final password = passwordController.text;

    if (email.isEmpty || password.isEmpty) {
      Get.snackbar("Error", "Please fill in all fields");
      return;
    }

    try {
      final response = await http.post(
        Uri.parse('http://10.20.30.228:8000/api/login'),
        headers: {
          'Accept': 'application/json',
          'Content-Type': 'application/json',
        },
        body: jsonEncode({
          'email': email,
          'password': password,
        }),
      );

      if (response.statusCode == 200) {
        final data = jsonDecode(response.body);
        box.write('email', email);
        if (data['token'] != null) {
          String token = data['token'];
          box.write('token', token);
        } else {
          Get.snackbar("Error", "Token tidak ditemukan di response");
          return;
        }
        Get.snackbar("Success", data['message']);
        Get.offNamed(Routes.HOME, arguments: email);
      } else {
        final error = jsonDecode(response.body);
        Get.snackbar("Login Failed", error['message'] ?? 'Unknown error');
      }
    } catch (e) {
      Get.snackbar("Error", "Exception: $e");
    }
  }

  @override
  void onClose() {
    super.onClose();
  }
}
