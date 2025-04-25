import 'package:eatwise/app/routes/app_pages.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:google_fonts/google_fonts.dart';
import 'package:flutter/gestures.dart';
import '../controllers/otpcode_controller.dart';

class OtpcodeView extends StatefulWidget {
  @override
  _OtpcodeViewState createState() => _OtpcodeViewState();
}

class _OtpcodeViewState extends State<OtpcodeView> {
  final controller = Get.put(OtpcodeController());
  final List<TextEditingController> otpControllers =
      List.generate(4, (index) => TextEditingController());
  final List<FocusNode> focusNodes = List.generate(4, (index) => FocusNode());
  late TapGestureRecognizer _resendTap;

  @override
  void initState() {
    super.initState();
    _resendTap = TapGestureRecognizer()
      ..onTap = () {
        final email = Get.arguments['email'];
        controller.resendOtp(email);
      };
  }

  @override
  void dispose() {
    _resendTap.dispose(); // ini penting!
    for (var controller in otpControllers) {
      controller.dispose();
    }
    for (var node in focusNodes) {
      node.dispose();
    }
    super.dispose();
  }

  void handleOtpInput(int index, String value) {
    if (value.isNotEmpty && index < 3) {
      FocusScope.of(context).requestFocus(focusNodes[index + 1]);
    } else if (value.isEmpty && index > 0) {
      FocusScope.of(context).requestFocus(focusNodes[index - 1]);
    }
  }

  void showAccountCreatedPopup() {
    showDialog(
      context: context,
      barrierDismissible: false,
      builder: (BuildContext context) {
        Future.delayed(Duration(seconds: 2), () {
          Navigator.of(context).pop();
          Get.toNamed(Routes.LOGIN);
        });

        return Dialog(
          shape: RoundedRectangleBorder(
            borderRadius: BorderRadius.circular(20),
          ),
          child: Container(
            padding: const EdgeInsets.all(50),
            decoration: BoxDecoration(
              color: Colors.white,
              borderRadius: BorderRadius.circular(20),
            ),
            child: Column(
              mainAxisSize: MainAxisSize.min,
              children: [
                Image.asset(
                  'assets/images/noodle.png',
                  height: 160,
                  width: 160,
                ),
                const SizedBox(height: 20),
                Text(
                  "Account Successfully Created!",
                  style: GoogleFonts.poppins(
                    fontSize: 18,
                    fontWeight: FontWeight.bold,
                    color: Colors.black,
                  ),
                  textAlign: TextAlign.center,
                ),
                const SizedBox(height: 10),
                Text(
                  "Please log in with the email and password you have set up.",
                  style: GoogleFonts.poppins(
                    fontSize: 12,
                    color: Colors.grey,
                  ),
                  textAlign: TextAlign.center,
                ),
              ],
            ),
          ),
        );
      },
    );
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: Container(
        decoration: const BoxDecoration(
          gradient: LinearGradient(
            colors: [Color(0xffCE181B), Colors.white],
            begin: Alignment.topCenter,
            end: Alignment.bottomCenter,
            stops: [0.70, 0.30],
          ),
        ),
        child: SingleChildScrollView(
          child: Column(
            children: [
              const SizedBox(height: 80),
              Image.asset(
                'assets/images/eatwiselogo.png',
                height: 60,
              ),
              const SizedBox(height: 45),
              Text(
                "OTP Code",
                style: GoogleFonts.poppins(
                  fontSize: 24,
                  fontWeight: FontWeight.w700,
                  color: Colors.white,
                ),
              ),
              const SizedBox(height: 16),
              Center(
                child: Text(
                  'Please enter code verification from your email',
                  textAlign: TextAlign.center,
                  style: GoogleFonts.poppins(
                    fontSize: 12.5,
                    fontWeight: FontWeight.w300,
                    color: Colors.white,
                  ),
                ),
              ),
              const SizedBox(height: 75),
              Container(
                padding: const EdgeInsets.all(28),
                decoration: const BoxDecoration(
                  color: Colors.white,
                  borderRadius: BorderRadius.vertical(top: Radius.circular(30)),
                ),
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.center,
                  children: [
                    const SizedBox(height: 30),
                    Text(
                      "Enter Verification Code",
                      style: GoogleFonts.poppins(
                        fontSize: 18,
                        fontWeight: FontWeight.bold,
                      ),
                    ),
                    const SizedBox(height: 30),
                    Row(
                      mainAxisAlignment: MainAxisAlignment.center,
                      children: List.generate(4, (index) {
                        return Container(
                          margin: const EdgeInsets.symmetric(horizontal: 10),
                          width: 50,
                          height: 50,
                          decoration: BoxDecoration(
                            border: Border.all(color: Colors.black, width: 1),
                            shape: BoxShape.circle,
                          ),
                          child: Center(
                            child: TextField(
                              controller: otpControllers[index],
                              focusNode: focusNodes[index],
                              keyboardType: TextInputType.number,
                              textAlign: TextAlign.center,
                              maxLength: 1,
                              style: GoogleFonts.poppins(
                                fontSize: 20,
                                fontWeight: FontWeight.bold,
                              ),
                              onChanged: (value) =>
                                  handleOtpInput(index, value),
                              decoration: const InputDecoration(
                                counterText: '',
                                border: InputBorder.none,
                              ),
                            ),
                          ),
                        );
                      }),
                    ),
                    const SizedBox(height: 20),
                    Obx(() {
                      final isAvailable = controller.isResendAvailable.value;
                      final countdownValue = controller.countdown.value;

                      return Text.rich(
                        TextSpan(
                          text: "If you didn’t receive a code, ",
                          style: GoogleFonts.poppins(fontSize: 12),
                          children: [
                            TextSpan(
                              text: isAvailable
                                  ? "Resend"
                                  : "Resend in $countdownValue s", // Show countdown
                              style: GoogleFonts.poppins(
                                fontWeight: FontWeight.bold,
                                color: isAvailable
                                    ? const Color(0xffCE181B)
                                    : Colors.grey,
                              ),
                              recognizer: isAvailable ? _resendTap : null,
                            ),
                          ],
                        ),
                      );
                    }),
                    const SizedBox(height: 25),
                    SizedBox(
                        width: double.infinity,
                        child: ElevatedButton(
                          onPressed: () async {
                            String otpCode =
                                otpControllers.map((e) => e.text).join();

                            if (otpCode.length < 4) {
                              Get.snackbar("Error",
                                  "Please enter the full 4-digit OTP code");
                              return;
                            }

                            bool isVerified =
                                await controller.verifyOtp(otpCode);

                            if (isVerified) {
                              showAccountCreatedPopup();
                            } else {
                              Get.snackbar("Error", "Invalid OTP code");
                            }
                          },
                          style: ElevatedButton.styleFrom(
                            backgroundColor: const Color(0xffCE181B),
                            padding: const EdgeInsets.symmetric(vertical: 18),
                            shape: RoundedRectangleBorder(
                              borderRadius: BorderRadius.circular(30),
                            ),
                          ),
                          child: Text(
                            "Send",
                            style: GoogleFonts.poppins(
                              fontSize: 16,
                              fontWeight: FontWeight.bold,
                              color: Colors.white,
                            ),
                          ),
                        )),
                    const SizedBox(height: 160),
                  ],
                ),
              ),
            ],
          ),
        ),
      ),
    );
  }
}
