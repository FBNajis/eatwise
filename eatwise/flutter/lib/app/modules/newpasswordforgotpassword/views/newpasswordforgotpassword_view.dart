import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:google_fonts/google_fonts.dart';
import '../controllers/newpasswordforgotpassword_controller.dart';

class NewpasswordforgotpasswordView extends StatelessWidget {
  NewpasswordforgotpasswordView({Key? key}) : super(key: key);

  final controller = Get.put(NewpasswordforgotpasswordController());

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: Container(
        decoration: const BoxDecoration(color: Color(0xffCE181B)),
        child: GestureDetector(
          onTap: () => FocusScope.of(context).unfocus(),
          child: SingleChildScrollView(
            child: Column(
              children: [
                const SizedBox(height: 100),
                Image.asset('assets/images/eatwiselogo.png',
                    height: 60, color: Colors.white),
                const SizedBox(height: 35),
                Text("Forgot Password",
                    style: GoogleFonts.poppins(
                        fontSize: 24,
                        fontWeight: FontWeight.w700,
                        color: Colors.white)),
                const SizedBox(height: 16),
                Text(
                  'Please enter your new password',
                  textAlign: TextAlign.center,
                  style: GoogleFonts.poppins(
                      fontSize: 12.5,
                      fontWeight: FontWeight.w300,
                      color: Colors.white),
                ),
                const SizedBox(height: 50),
                Container(
                  padding: const EdgeInsets.all(28),
                  decoration: const BoxDecoration(
                    color: Colors.white,
                    borderRadius:
                        BorderRadius.vertical(top: Radius.circular(30)),
                  ),
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      const SizedBox(height: 15),
                      _buildPasswordField(
                          "New Password",
                          "Enter new password...",
                          controller.newPasswordController),
                      const SizedBox(height: 20),
                      _buildPasswordField(
                          "Confirm Password",
                          "Confirm new password...",
                          controller.confirmPasswordController),
                      const SizedBox(height: 30),
                      Obx(() => SizedBox(
                            width: double.infinity,
                            child: ElevatedButton(
                              onPressed: controller.isLoading.value
                                  ? null
                                  : controller.resetPassword,
                              style: ElevatedButton.styleFrom(
                                backgroundColor: const Color(0xffCE181B),
                                padding:
                                    const EdgeInsets.symmetric(vertical: 20),
                                shape: RoundedRectangleBorder(
                                    borderRadius: BorderRadius.circular(30)),
                              ),
                              child: controller.isLoading.value
                                  ? const CircularProgressIndicator(
                                      color: Colors.white)
                                  : Text(
                                      "Send",
                                      style: GoogleFonts.poppins(
                                          fontSize: 18,
                                          fontWeight: FontWeight.bold,
                                          color: Colors.white),
                                    ),
                            ),
                          )),
                      const SizedBox(height: 170),
                    ],
                  ),
                ),
              ],
            ),
          ),
        ),
      ),
    );
  }

  Widget _buildPasswordField(
      String label, String hint, TextEditingController controllerText) {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        Text(label, style: GoogleFonts.poppins(fontSize: 15)),
        const SizedBox(height: 7),
        Obx(() => TextField(
              controller: controllerText,
              obscureText: controller.isPasswordVisible.value,
              decoration: InputDecoration(
                filled: true,
                fillColor: const Color(0xffFFF3F3),
                border: OutlineInputBorder(
                    borderRadius: BorderRadius.circular(10),
                    borderSide: BorderSide.none),
                hintText: hint,
                hintStyle: GoogleFonts.poppins(
                    fontWeight: FontWeight.w400,
                    color: Colors.grey,
                    fontSize: 14),
                suffixIcon: IconButton(
                  icon: Icon(
                    controller.isPasswordVisible.value
                        ? Icons.visibility_off
                        : Icons.visibility,
                    color: Colors.grey,
                  ),
                  onPressed: controller.togglePasswordVisibility,
                ),
              ),
            )),
        const SizedBox(height: 18),
      ],
    );
  }
}
