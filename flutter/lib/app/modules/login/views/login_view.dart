import 'package:eatwise/app/routes/app_pages.dart';
import 'package:flutter/material.dart';

import 'package:get/get.dart';
import 'package:google_fonts/google_fonts.dart';

import '../controllers/login_controller.dart';

class LoginView extends StatefulWidget {
  @override
  _LoginViewState createState() => _LoginViewState();
}

class _LoginViewState extends State<LoginView> {
  bool isPasswordVisible = false;
  bool isRememberMeChecked = false;
  final controller = Get.put(LoginController());

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: Container(
        decoration: const BoxDecoration(
          color: Color(0xffCE181B)
        ),
        child: GestureDetector(
          onTap: () => FocusScope.of(context).unfocus(),
          child: SingleChildScrollView(
            keyboardDismissBehavior: ScrollViewKeyboardDismissBehavior.onDrag,
            child: Column(
              children: [
                const SizedBox(height: 100),
                Image.asset(
                  'assets/images/eatwiselogo.png',
                  height: 60,
                ),
                const SizedBox(height: 35),
                Text(
                  "Let's log in",
                  style: GoogleFonts.poppins(
                    fontSize: 24,
                    fontWeight: FontWeight.w700,
                    color: Colors.white,
                  ),
                ),
                SizedBox(height: 16),
                Center(
                  child: Text(
                    'Please provide your information to personalize\n'
                    'your experience and start exploring the full\n'
                    'potential of the app',
                    textAlign: TextAlign.center,
                    style: GoogleFonts.poppins(
                      fontSize: 12.5,
                      fontWeight: FontWeight.w300,
                      color: Colors.white,
                    ),
                  ),
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
                      buildInputField("Email", "Enter your email...",
                          controller.emailController),
                      buildPasswordField(),
                      Row(
                        children: [
                          Transform.scale(
                            scale: 0.85,
                            child: Checkbox(
                              value: isRememberMeChecked,
                              onChanged: (value) {
                                setState(() {
                                  isRememberMeChecked = value ?? false;
                                });
                              },
                              visualDensity: VisualDensity.compact,
                              activeColor: const Color(0xffCE181B),
                            ),
                          ),
                          const SizedBox(width: 6),
                          Text(
                            'Ingat saya',
                            style: GoogleFonts.poppins(
                              fontSize: 12,
                              fontWeight: FontWeight.w500,
                              color: Colors.grey,
                            ),
                          ),
                          const Spacer(),
                          TextButton(
                            onPressed: () {
                              Get.toNamed(Routes.EMAILFORGOTPASSWORD);
                            },
                            style: TextButton.styleFrom(
                              padding: EdgeInsets.zero,
                              minimumSize: const Size(0, 0),
                            ),
                            child: Text(
                              'Forgot Password?',
                              style: GoogleFonts.poppins(
                                color: const Color(0xffCE181B),
                                fontSize: 12,
                                fontWeight: FontWeight.w600,
                              ),
                            ),
                          ),
                        ],
                      ),
                      const SizedBox(height: 35),
                      SizedBox(
                        width: double.infinity,
                        child: ElevatedButton(
                          onPressed: () {
                            controller.login(); // Call API
                          },
                          style: ElevatedButton.styleFrom(
                            backgroundColor: const Color(0xffCE181B),
                            padding: const EdgeInsets.symmetric(vertical: 20),
                            shape: RoundedRectangleBorder(
                              borderRadius: BorderRadius.circular(30),
                            ),
                          ),
                          child: Text(
                            "Login",
                            style: GoogleFonts.poppins(
                              fontSize: 18,
                              fontWeight: FontWeight.bold,
                              color: Colors.white,
                            ),
                          ),
                        ),
                      ),
                      const SizedBox(height: 15),
                      Center(
                        child: GestureDetector(
                          onTap: () => Get.toNamed('/signup'),
                          child: Text.rich(
                            TextSpan(
                              text: "Don’t Have an Account? ",
                              style: GoogleFonts.poppins(fontSize: 14),
                              children: [
                                TextSpan(
                                  text: "Sign Up",
                                  style: GoogleFonts.poppins(
                                    color: const Color(0xffCE181B),
                                    fontWeight: FontWeight.bold,
                                  ),
                                ),
                              ],
                            ),
                          ),
                        ),
                      ),
                      SizedBox(
                          height: MediaQuery.of(context).viewInsets.bottom),
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

  Widget buildInputField(
      String label, String hint, TextEditingController controller,
      {bool obscureText = false}) {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        Text(label, style: GoogleFonts.poppins(fontSize: 15)),
        const SizedBox(height: 7),
        TextField(
          controller: controller,
          obscureText: obscureText,
          decoration: InputDecoration(
            filled: true,
            fillColor: const Color(0xffFFF3F3),
            border: OutlineInputBorder(
              borderRadius: BorderRadius.circular(10),
              borderSide: BorderSide.none,
            ),
            hintText: hint,
            hintStyle: GoogleFonts.poppins(
              fontWeight: FontWeight.w400,
              color: Colors.grey,
              fontSize: 14,
            ),
          ),
        ),
        const SizedBox(height: 18),
      ],
    );
  }

  Widget buildPasswordField() {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        Text("Password", style: GoogleFonts.poppins(fontSize: 15)),
        const SizedBox(height: 7),
        TextField(
          controller: controller.passwordController,
          obscureText: !isPasswordVisible,
          decoration: InputDecoration(
            filled: true,
            fillColor: const Color(0xffFFF3F3),
            border: OutlineInputBorder(
              borderRadius: BorderRadius.circular(10),
              borderSide: BorderSide.none,
            ),
            hintText: "Enter your password...",
            hintStyle: GoogleFonts.poppins(
              fontWeight: FontWeight.w400,
              color: Colors.grey,
              fontSize: 14,
            ),
            suffixIcon: IconButton(
              icon: Icon(
                isPasswordVisible ? Icons.visibility : Icons.visibility_off,
                color: Colors.grey,
              ),
              onPressed: () {
                setState(() {
                  isPasswordVisible = !isPasswordVisible;
                });
              },
            ),
          ),
        ),
        const SizedBox(height: 4),
      ],
    );
  }
}
