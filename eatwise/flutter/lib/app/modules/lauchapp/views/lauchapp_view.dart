import 'package:eatwise/app/routes/app_pages.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:google_fonts/google_fonts.dart';
import '../controllers/lauchapp_controller.dart';

class LauchappView extends GetView<LauchappController> {
  const LauchappView({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Color(0xffCE181B),
      body: Stack(
        fit: StackFit.expand,
        children: [
         Positioned(
            top: 220,
            left: 0,
            right: 0,
            child: Image.asset(
              'assets/images/launchappimage.png',
              fit: BoxFit.cover,
            ),
          ),

          SafeArea(
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start, 
              mainAxisAlignment: MainAxisAlignment.center,
              children: [
                Padding(
                  padding: const EdgeInsets.symmetric(horizontal: 20), 
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.start, 
                    children: [
                      SizedBox(height: 50),
                      Text(
                        'Food',
                        style: GoogleFonts.poppins(
                          color: Colors.white,
                          fontSize: 45,
                          fontWeight: FontWeight.w700,
                          height: 1.1, 
                        ),
                      ),
                      Text(
                        'For Everyone',
                        style: GoogleFonts.poppins(
                          color: Colors.white,
                          fontSize: 45,
                          fontWeight: FontWeight.w700,
                          height: 1.1, 
                        ),
                      ),
                    ],
                  ),
                ),
                SizedBox(height: 5),
                Padding(
                  padding: const EdgeInsets.symmetric(horizontal: 20, vertical: 10),
                  child: Image.asset(
                    'assets/images/eatwise.png',
                    height: 50,
                  ),
                ),
                
                Spacer(),
                Padding(
                  padding: const EdgeInsets.symmetric(horizontal: 20),
                  child: ElevatedButton(
                    onPressed: () {
                      Get.toNamed(Routes.ONBOARDING1);
                    },
                    style: ElevatedButton.styleFrom(
                      backgroundColor: Colors.white,
                      minimumSize: const Size(double.infinity, 90),
                      shape: RoundedRectangleBorder(
                        borderRadius: BorderRadius.circular(40),
                      ),
                    ),
                    child: Text(
                      'Get started',
                      style: GoogleFonts.poppins(
                        color: Color(0xffCE181B),
                        fontSize: 18,
                        fontWeight: FontWeight.bold,
                      ),
                    ),
                  ),
                ),
                SizedBox(height: 70),
              ],
            ),
          ),
        ],
      ),
    );
  }
}