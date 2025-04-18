import 'package:get/get.dart';
import 'package:http/http.dart' as http;
import 'dart:convert';

import '../../../routes/app_pages.dart';

class OtpforgotpasswordController extends GetxController {
  RxBool isLoading = false.obs;
  String? email;

  @override
  @override
  void onInit() {
    super.onInit();
    final arguments = Get.arguments;
    print("Arguments in OTP Page: $arguments");

    if (arguments != null && arguments is String) {
      email = arguments;
      print("Email received: $email");
    } else {
      print("ERROR: Email is null or not a string");
    }
  }

  Future<bool> sendOtp(String email) async {
    isLoading.value = true;

    final url = Uri.parse('http://10.0.2.2:8000/api/send-otp');
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
        Get.snackbar('Success', data['message'] ?? 'OTP verified successfully');

        // Navigasi ke halaman buat password baru, bawa email
        Get.toNamed(Routes.NEWPASSWORDFORGOTPASSWORD,
            arguments: {'email': email});

        return true;
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


  // late String email;
  //
  // @override
  // void onInit() {
  //   super.onInit();
  //   email = Get.arguments; // Ambil email dari argument
  //   print('Email untuk verifikasi OTP: $email'); // Debug log
  // }
  // void verifyOtp(String otpCode) {
  //   const correctOtp = "1234";
  //
  //   if (otpCode == correctOtp) {
  //     Get.snackbar("Success", "Verification successful!",
  //         snackPosition: SnackPosition.BOTTOM);
  //     Get.toNamed(Routes.NEWPASSWORDFORGOTPASSWORD, arguments: email);
  //   } else {
  //     Get.snackbar("Error", "Invalid OTP code. Please try again.",
  //         snackPosition: SnackPosition.BOTTOM);
  //   }
  // }
  // // void verifyOtp(String otpCode) async {
  // //   const correctOtp = "1234";    final response = await http.post(
  // //     Uri.parse('http://10.0.2.2:8000/api/verify-otp'),
  // //     headers: {'Content-Type': 'application/json'},
  // //     body: jsonEncode({'email': email, 'otp': otpCode}),
  // //   );
  // //
  // //   if (response.statusCode == 200) {
  // //     Get.snackbar("Success", "Verification successful!",
  // //         snackPosition: SnackPosition.BOTTOM);
  // //     Get.toNamed("/reset-password", arguments: email); // Lanjut ke halaman reset password
  // //   } else {
  // //     Get.snackbar("Error", "Invalid OTP code. Please try again.",
  // //         snackPosition: SnackPosition.BOTTOM);
  // //   }
  // // }
