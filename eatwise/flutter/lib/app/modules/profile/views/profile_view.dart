import 'dart:io';

import 'package:eatwise/app/modules/bottomnavigation/views/bottomnavigation_view.dart';
import 'package:eatwise/app/routes/app_pages.dart';
import 'package:flutter/material.dart';
import 'package:google_fonts/google_fonts.dart';
import 'package:get/get.dart';
import 'package:image_picker/image_picker.dart';
import '../controllers/profile_controller.dart';

class ProfileView extends StatefulWidget {
  const ProfileView({Key? key}) : super(key: key);

  @override
  _ProfileViewState createState() => _ProfileViewState();
}

class _ProfileViewState extends State<ProfileView> {
  final profileController = Get.put(ProfileController());
  bool _obscurePassword = true;
  bool _obscureConfirmPassword = true;

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        leading: IconButton(
          icon: const Icon(Icons.chevron_left, size: 33),
          onPressed: () => Navigator.pop(context),
        ),
        title: Text(
          "Profile",
          style: GoogleFonts.poppins(fontSize: 20, fontWeight: FontWeight.w600),
        ),
        centerTitle: true,
      ),
      body: SingleChildScrollView(
        child: Padding(
          padding: const EdgeInsets.symmetric(horizontal: 25),
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.center,
            children: [
              const SizedBox(height: 15),
              Stack(
                alignment: Alignment.center,
                children: [
                  Obx(() {
                    return CircleAvatar(
                      radius: 50,
                      backgroundColor: Colors.grey.shade200,
                      backgroundImage: profileController.selectedImage.value !=
                              null
                          ? FileImage(
                              File(profileController.selectedImage.value!.path))
                          : (profileController.imageUrl.value.isNotEmpty
                              ? NetworkImage(profileController.imageUrl.value)
                              : null) as ImageProvider?,
                      child: profileController.imageUrl.value.isEmpty &&
                              profileController.selectedImage.value == null
                          ? Icon(Icons.person, size: 50, color: Colors.grey)
                          : null,
                    );
                  }),
                  Positioned(
                    right: 0,
                    bottom: 0,
                    child: GestureDetector(
                      onTap: () async {
                        // Show a dialog to pick an image source (camera or gallery)
                        await showDialog(
                          context: context,
                          builder: (context) => AlertDialog(
                            title: Text('Select Image Source'),
                            actions: [
                              TextButton(
                                onPressed: () async {
                                  Navigator.pop(context);
                                  final picker = ImagePicker();
                                  final pickedFile = await picker.pickImage(
                                      source: ImageSource.gallery);
                                  if (pickedFile != null) {
                                    profileController.selectedImage.value =
                                        pickedFile;
                                  }
                                },
                                child: Text('Gallery'),
                              ),
                              TextButton(
                                onPressed: () async {
                                  Navigator.pop(context);
                                  final picker = ImagePicker();
                                  final pickedFile = await picker.pickImage(
                                      source: ImageSource.camera);
                                  if (pickedFile != null) {
                                    profileController.selectedImage.value =
                                        pickedFile;
                                  }
                                },
                                child: Text('Camera'),
                              ),
                            ],
                          ),
                        );
                      },
                      child: Obx(() => Container(
                            width: 100,
                            height: 100,
                            decoration: BoxDecoration(
                              border: Border.all(color: Colors.grey),
                              borderRadius: BorderRadius.circular(10),
                            ),
                            child: profileController.selectedImage.value == null
                                ? Column(
                                    mainAxisAlignment: MainAxisAlignment.center,
                                    crossAxisAlignment:
                                        CrossAxisAlignment.center,
                                    children: [
                                      Container(
                                        width: 28,
                                        height: 28,
                                        decoration: BoxDecoration(
                                          color: Colors.white,
                                          shape: BoxShape.circle,
                                          boxShadow: [
                                            BoxShadow(
                                              color:
                                                  Colors.black.withOpacity(0.1),
                                              spreadRadius: 1,
                                              blurRadius: 3,
                                              offset: Offset(0, 1),
                                            ),
                                          ],
                                        ),
                                        child: const Icon(
                                          Icons.edit,
                                          size: 16,
                                          color: Color(0xffCE181B),
                                        ),
                                      ),
                                    ],
                                  )
                                : ClipRRect(
                                    borderRadius: BorderRadius.circular(10),
                                    child: Image.file(
                                      File(profileController
                                          .selectedImage.value!.path),
                                      fit: BoxFit.cover,
                                    ),
                                  ),
                          )),
                    ),
                  ),
                ],
              ),
              const SizedBox(height: 30),
              buildProfileField(
                context,
                label: "Username",
                controller: profileController.usernameController,
              ),
              buildProfileField(context,
                  label: "Full Name",
                  controller: profileController.nameController),
              buildProfileField(context,
                  label: "Phone Number",
                  controller: profileController.phoneController,
                  keyboardType: TextInputType.phone),
              buildProfileField(context,
                  label: "Email",
                  controller: profileController.emailController,
                  keyboardType: TextInputType.emailAddress),
              buildPasswordField(context,
                  label: "Password",
                  controller: profileController.passwordController,
                  obscureText: _obscurePassword, onToggleVisibility: () {
                setState(() {
                  _obscurePassword = !_obscurePassword;
                });
              }),
              buildPasswordField(context,
                  label: "Confirm Password",
                  controller: profileController.confirmPasswordController,
                  obscureText: _obscureConfirmPassword, onToggleVisibility: () {
                setState(() {
                  _obscureConfirmPassword = !_obscureConfirmPassword;
                });
              }),
              const SizedBox(height: 50),
              ElevatedButton(
                onPressed: () {
                  profileController.updateUserProfile();
                },
                style: ElevatedButton.styleFrom(
                  backgroundColor: const Color(0xffCE181B),
                  minimumSize: const Size(double.infinity, 60),
                ),
                child: Text(
                  "Update Profile",
                  style: GoogleFonts.poppins(
                    color: Colors.white,
                    fontWeight: FontWeight.w600,
                  ),
                ),
              ),
              const SizedBox(height: 10),
              ElevatedButton(
                onPressed: () {
                  showDialog(
                    context: context,
                    builder: (BuildContext context) {
                      return Dialog(
                        shape: RoundedRectangleBorder(
                          borderRadius: BorderRadius.circular(20),
                        ),
                        child: Container(
                          padding: const EdgeInsets.all(20),
                          child: Column(
                            mainAxisSize: MainAxisSize.min,
                            children: [
                              Image.asset(
                                'assets/images/hambuger.png',
                                width: 150,
                                height: 150,
                              ),
                              const SizedBox(height: 20),
                              Text(
                                'Are you sure you want to exit the application?',
                                textAlign: TextAlign.center,
                                style: GoogleFonts.poppins(
                                  fontSize: 18,
                                  fontWeight: FontWeight.w600,
                                ),
                              ),
                              const SizedBox(height: 20),
                              Row(
                                mainAxisAlignment: MainAxisAlignment.center,
                                children: [
                                  ElevatedButton(
                                    onPressed: () {
                                      Navigator.of(context).pop();
                                      profileController.logout();
                                    },
                                    style: ElevatedButton.styleFrom(
                                      backgroundColor: const Color(0xffCE181B),
                                      minimumSize: const Size(100, 50),
                                    ),
                                    child: Text(
                                      'Yes',
                                      style: GoogleFonts.poppins(
                                        color: Colors.white,
                                        fontWeight: FontWeight.w600,
                                      ),
                                    ),
                                  ),
                                  const SizedBox(width: 20),
                                  ElevatedButton(
                                    onPressed: () {
                                      Navigator.of(context).pop();
                                    },
                                    style: ElevatedButton.styleFrom(
                                      backgroundColor: Colors.white,
                                      side: const BorderSide(
                                          color: Color(0xffCE181B)),
                                      minimumSize: const Size(100, 50),
                                    ),
                                    child: Text(
                                      'No',
                                      style: GoogleFonts.poppins(
                                        color: const Color(0xffCE181B),
                                        fontWeight: FontWeight.w600,
                                      ),
                                    ),
                                  ),
                                ],
                              ),
                            ],
                          ),
                        ),
                      );
                    },
                  );
                },
                style: ElevatedButton.styleFrom(
                  backgroundColor: const Color(0xffCE181B),
                  minimumSize: const Size(double.infinity, 60),
                ),
                child: Text(
                  "Logout",
                  style: GoogleFonts.poppins(
                    color: Colors.white,
                    fontWeight: FontWeight.w600,
                  ),
                ),
              ),
              const SizedBox(height: 30),
            ],
          ),
        ),
      ),
      bottomNavigationBar: BottomnavigationView(
        currentIndex: 3,
        onTap: (index) {
          switch (index) {
            case 0:
              Get.offNamed(Routes.HOME,
                  arguments: profileController.emailController.text);
              break;
            case 1:
              Get.offNamed(Routes.RECIPE,
                  arguments: profileController.emailController.text);
              break;
            case 2:
              Get.offNamed(Routes.CHATBOT,
                  arguments: profileController.emailController.text);
              break;
            case 3:
              break;
          }
        },
      ),
    );
  }

  Widget buildProfileField(
    BuildContext context, {
    required String label,
    required TextEditingController controller,
    TextInputType keyboardType = TextInputType.text,
  }) {
    return Padding(
      padding: const EdgeInsets.symmetric(vertical: 10),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Text(
            label,
            style: GoogleFonts.poppins(
              fontSize: 14,
              fontWeight: FontWeight.w600,
              color: const Color(0xff667085),
            ),
          ),
          const SizedBox(height: 8),
          TextField(
            controller: controller,
            keyboardType: keyboardType,
            decoration: InputDecoration(
              filled: true,
              fillColor: const Color(0xffFFF3F3),
              border: OutlineInputBorder(
                borderRadius: BorderRadius.circular(10),
                borderSide: BorderSide.none,
              ),
              contentPadding: const EdgeInsets.all(12),
            ),
            style: GoogleFonts.poppins(
              fontSize: 14,
              color: const Color(0xff667085),
            ),
          ),
        ],
      ),
    );
  }

  Widget buildPasswordField(
    BuildContext context, {
    required String label,
    required TextEditingController controller,
    required bool obscureText,
    required VoidCallback onToggleVisibility,
  }) {
    return Padding(
      padding: const EdgeInsets.symmetric(vertical: 10),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Text(
            label,
            style: GoogleFonts.poppins(
              fontSize: 14,
              fontWeight: FontWeight.w600,
              color: const Color(0xff667085),
            ),
          ),
          const SizedBox(height: 8),
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
              contentPadding: const EdgeInsets.all(12),
              suffixIcon: IconButton(
                icon: Icon(
                  obscureText ? Icons.visibility_off : Icons.visibility,
                  color: Colors.grey,
                ),
                onPressed: onToggleVisibility,
              ),
            ),
            style: GoogleFonts.poppins(
              fontSize: 14,
              color: const Color(0xff667085),
            ),
          ),
        ],
      ),
    );
  }
}
