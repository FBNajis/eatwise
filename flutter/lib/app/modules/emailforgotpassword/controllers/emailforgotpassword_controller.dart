import 'package:get/get.dart';
import 'package:http/http.dart' as http;
import 'dart:convert';

import '../../../routes/app_pages.dart';

class EmailforgotpasswordController extends GetxController {
  var email = ''.obs;
  var isLoading = false.obs;
  var isEmailValid = false.obs;
  var message = ''.obs;

  Future<void> checkEmail() async {
    isLoading.value = true;

    final url = Uri.parse('http://10.0.2.2:8000/api/check-email');
    try {
      final response = await http.post(
        url,
        headers: {'Content-Type': 'application/json'},
        body: jsonEncode({'email': email.value}),
      );

      if (response.statusCode == 200) {
        isEmailValid.value = true;
        message.value = "Email ditemukan, OTP telah dikirim ke email.";

        Get.snackbar("OTP Sent", "Please check your email");
        Get.toNamed(Routes.OTPFORGOTPASSWORD,
            arguments: {'email': email.value});
      } else if (response.statusCode == 404) {
        isEmailValid.value = false;
        message.value = "Email tidak ditemukan di sistem kami.";
      } else {
        isEmailValid.value = false;
        message.value = "Terjadi kesalahan. Coba lagi nanti.";
      }
    } catch (e) {
      isEmailValid.value = false;
      message.value = "Gagal terhubung ke server.";
    } finally {
      isLoading.value = false;
    }
  }
}
