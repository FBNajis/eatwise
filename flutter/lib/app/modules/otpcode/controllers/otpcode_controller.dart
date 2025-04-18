import 'package:get/get.dart';
import 'package:http/http.dart' as http;
import 'dart:convert';

class OtpcodeController extends GetxController {
  RxBool isLoading = false.obs;
  String? email;

  @override
  @override
  void onInit() {
    super.onInit();
    final arguments = Get.arguments;
    print("Arguments in OTP Page: $arguments");

    if (arguments != null && arguments['email'] != null) {
      email = arguments['email'];
      print("Email received: $email");
    } else {
      print("ERROR: Email is null in Get.arguments");
    }
  }

  Future<bool> sendOtp(String email) async {
    isLoading.value = true;

    final url = Uri.parse(
        'http://10.0.2.2:8000/api/send-otp'); // Ganti sesuai URL backend kamu
    try {
      final response = await http.post(
        url,
        headers: {'Content-Type': 'application/json'},
        body: jsonEncode({'email': email}),
      );

      final data = jsonDecode(response.body);
      if (response.statusCode == 200) {
        Get.snackbar('Success', data['message'] ?? 'OTP Sent');
        return true;
      } else {
        Get.snackbar('Error', data['message'] ?? 'Failed to send OTP');
        return false;
      }
    } catch (e) {
      Get.snackbar('Error', 'Failed to send OTP');
      return false;
    } finally {
      isLoading.value = false;
    }
  }

  Future<bool> verifyOtp(String otpCode) async {
    if (email == null) {
      Get.snackbar("Error", "Email is not available for verification.");
      isLoading.value = false;
      return false;
    }

    print("Calling verifyOtp with OTP: $otpCode and email: $email");
    isLoading.value = true;

    final url = Uri.parse('http://10.0.2.2:8000/api/verify-otp');
    try {
      final response = await http.post(
        url,
        headers: {'Content-Type': 'application/json'},
        body: jsonEncode({'email': email, 'otp': otpCode}),
      );

      final data = jsonDecode(response.body);
      if (response.statusCode == 200) {
        final userData = Get.arguments['userData'];

        final signupResponse = await http.post(
          Uri.parse('http://10.0.2.2:8000/api/signup'),
          headers: {'Content-Type': 'application/json'},
          body: jsonEncode(userData),
        );

        if (signupResponse.statusCode == 200) {
          Get.snackbar('Success', 'Account created successfully');
          return true;
        } else {
          final signupError = jsonDecode(signupResponse.body);
          Get.snackbar(
              'Signup Failed', signupError['message'] ?? 'Unknown error');
          return false;
        }
      } else {
        Get.snackbar('Error', data['message'] ?? 'Invalid OTP');
        return false;
      }
    } catch (e) {
      Get.snackbar('Error', 'Failed to verify OTP');
      return false;
    } finally {
      isLoading.value = false;
    }
  }
}
