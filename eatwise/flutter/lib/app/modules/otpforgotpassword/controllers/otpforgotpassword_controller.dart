import 'dart:async';

import 'package:get/get.dart';
import 'package:http/http.dart' as http;
import 'dart:convert';

import '../../../routes/app_pages.dart';

class OtpforgotpasswordController extends GetxController {
  RxBool isLoading = false.obs;
  String? email;
  var countdown = 60.obs;
  Timer? _resendTimer;
  var isResendAvailable = true.obs;
  Timer? _countdownTimer;

  @override
  @override
  void onInit() {
    super.onInit();
    final arguments = Get.arguments;

    print("Arguments in OTP Page: $arguments");

    if (arguments != null && arguments is Map && arguments.containsKey('email')) {
      email = arguments['email'];
      print("Email received: $email");
    } else {
      print("ERROR: Email is null or not provided properly");
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
        Get.toNamed(Routes.NEWPASSWORDFORGOTPASSWORD, arguments: {'email': email});

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

  void resendOtp(String email) async {
    if (!isResendAvailable.value) return;

    isResendAvailable.value = false; // Disable resend
    countdown.value = 60; // Reset countdown to 60 seconds
    _startResendCooldown(); // Start cooldown timer
    _startCountdownTimer(); // Start countdown timer

    try {
      final response = await http.post(
        Uri.parse('http://10.0.2.2:8000/api/send-otp'),
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
        },
        body: jsonEncode({'email': email}),
      );

      if (response.statusCode == 200) {
        Get.snackbar("OTP Sent", "Kode OTP berhasil dikirim ulang ke email Anda.");
      } else {
        final error = jsonDecode(response.body);
        Get.snackbar("Gagal", error['message'] ?? "Gagal mengirim ulang OTP.");
      }
    } catch (e) {
      Get.snackbar("Error", "Terjadi kesalahan: $e");
    }
  }

  void _startResendCooldown() {
    _resendTimer?.cancel();
    _resendTimer = Timer(const Duration(minutes: 1), () {
      isResendAvailable.value = true;
    });
  }

  void _startCountdownTimer() {
    _countdownTimer?.cancel();
    _countdownTimer = Timer.periodic(const Duration(seconds: 1), (timer) {
      if (countdown.value > 0) {
        countdown.value--;
      } else {
        _countdownTimer?.cancel(); // Stop countdown once it reaches 0
      }
    });
  }

  @override
  void onClose() {
    _resendTimer?.cancel();
    _countdownTimer?.cancel();
    super.onClose();
  }


}

