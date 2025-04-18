import 'dart:io';
import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'package:get/get.dart';
import 'package:google_fonts/google_fonts.dart';
import 'package:iconsax/iconsax.dart';

import '../controllers/editdeleterecipe_controller.dart';

class EditdeleterecipeView extends GetView<EditdeleterecipeController> {
  const EditdeleterecipeView({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return const EditdeleterecipePage();
  }
}

class EditdeleterecipePage extends StatefulWidget {
  const EditdeleterecipePage({Key? key}) : super(key: key);

  @override
  _EditdeleterecipePageState createState() => _EditdeleterecipePageState();
}

class _EditdeleterecipePageState extends State<EditdeleterecipePage> {
  final EditdeleterecipeController controller =
      Get.find<EditdeleterecipeController>();

  TextStyle _labelStyle() {
    return GoogleFonts.poppins(fontSize: 14, color: const Color(0xff667085));
  }

  InputDecoration _inputDecoration(String hint) {
    return InputDecoration(
      hintText: hint,
      hintStyle:
          GoogleFonts.poppins(color: const Color(0xff667085), fontSize: 14),
      filled: true,
      fillColor: const Color(0xffFFF3F3),
      border: OutlineInputBorder(
        borderRadius: BorderRadius.circular(10),
        borderSide: BorderSide.none,
      ),
    );
  }

  Widget _buildTextField(
    TextEditingController ctrl,
    String hint, {
    int maxLines = 2,
    TextInputType keyboardType = TextInputType.text,
    List<TextInputFormatter>? inputFormatters,
  }) {
    return TextField(
      controller: ctrl,
      maxLines: maxLines,
      keyboardType: keyboardType,
      inputFormatters: inputFormatters,
      decoration: _inputDecoration(hint),
    );
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Edit Recipe',
            style: TextStyle(fontWeight: FontWeight.bold)),
        centerTitle: true,
        leading: IconButton(
          icon: const Icon(Iconsax.arrow_left_2, size: 22),
          onPressed: () => Get.back(),
        ),
      ),
      body: Obx(() {
        return Stack(
          children: [
            SingleChildScrollView(
              padding: const EdgeInsets.all(18),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Text("Dish name", style: _labelStyle()),
                  const SizedBox(height: 4),
                  _buildTextField(controller.dishNameController,
                      "Insert the name of the dish...",
                      maxLines: 1),
                  const SizedBox(height: 12),
                  Text("Description", style: _labelStyle()),
                  const SizedBox(height: 4),
                  _buildTextField(controller.descriptionController,
                      "Insert the description...",
                      maxLines: 3),
                  const SizedBox(height: 12),
                  Text("Cost estimation", style: _labelStyle()),
                  const SizedBox(height: 4),
                  _buildTextField(
                    controller.costController,
                    "Insert a cost estimation...",
                    maxLines: 1,
                    keyboardType: TextInputType.number,
                    inputFormatters: [FilteringTextInputFormatter.digitsOnly],
                  ),
                  const SizedBox(height: 12),
                  Text("Cooking time (in minutes)", style: _labelStyle()),
                  const SizedBox(height: 4),
                  _buildTextField(
                    controller.timeController,
                    "Insert a cooking time...",
                    maxLines: 1,
                    keyboardType: TextInputType.number,
                    inputFormatters: [FilteringTextInputFormatter.digitsOnly],
                  ),
                  const SizedBox(height: 12),
                  Text("Ingredients", style: _labelStyle()),
                  const SizedBox(height: 4),
                  _buildTextField(
                      controller.ingredientsController, "Enter ingredients...",
                      maxLines: 4, keyboardType: TextInputType.multiline),
                  const SizedBox(height: 12),
                  Text("Category", style: _labelStyle()),
                  const SizedBox(height: 4),
                  DropdownButtonFormField<String>(
                    value: controller.selectedCategory.value.isEmpty
                        ? null
                        : controller.selectedCategory.value,
                    decoration: InputDecoration(
                      border: OutlineInputBorder(
                        borderRadius: BorderRadius.circular(12),
                        borderSide: const BorderSide(
                            color: Color(0xffCE181B), width: 1),
                      ),
                      enabledBorder: OutlineInputBorder(
                        borderRadius: BorderRadius.circular(12),
                        borderSide: const BorderSide(
                            color: Color(0xffCE181B), width: 1),
                      ),
                      focusedBorder: OutlineInputBorder(
                        borderRadius: BorderRadius.circular(12),
                        borderSide: const BorderSide(
                            color: Color(0xffCE181B), width: 1.5),
                      ),
                    ),
                    style:
                        GoogleFonts.poppins(fontSize: 16, color: Colors.black),
                    dropdownColor: Colors.white,
                    hint: Text(
                      "Select a category",
                      style: GoogleFonts.poppins(
                          fontSize: 16, color: Colors.black54),
                    ),
                    items: [
                      "Snack",
                      "Drink",
                      "Dessert",
                      "Rice",
                      "Seafood",
                      "Salad",
                      "Bread",
                      "Noodle"
                    ]
                        .map((category) => DropdownMenuItem(
                              value: category,
                              child: Text(
                                category,
                                style: GoogleFonts.poppins(
                                    fontSize: 14, color: Colors.black),
                              ),
                            ))
                        .toList(),
                    onChanged: (value) {
                      controller.selectedCategory.value = value!;
                    },
                  ),
                  const SizedBox(height: 16),
                  Text("Current Food Image", style: _labelStyle()),
                  const SizedBox(height: 8),
                  Container(
                    width: double.infinity,
                    height: 200,
                    decoration: BoxDecoration(
                      borderRadius: BorderRadius.circular(10),
                      image: DecorationImage(
                        image: NetworkImage(controller.existingImageUrl ?? ''),
                        fit: BoxFit.cover,
                      ),
                    ),
                  ),
                  const SizedBox(height: 16),
                  Text("Upload New Food Image", style: _labelStyle()),
                  const SizedBox(height: 4),
                  GestureDetector(
                    onTap: controller.pickImageFromGallery,
                    child: Container(
                      width: double.infinity,
                      height: 150,
                      decoration: BoxDecoration(
                        border: Border.all(color: Colors.grey),
                        borderRadius: BorderRadius.circular(10),
                      ),
                      child: controller.selectedImage.value == null
                          ? Column(
                              mainAxisAlignment: MainAxisAlignment.center,
                              children: [
                                Image.asset('assets/images/upload_image.png',
                                    height: 40),
                                const SizedBox(height: 8),
                                Row(
                                  mainAxisAlignment: MainAxisAlignment.center,
                                  children: [
                                    Text("Click to Upload",
                                        style: GoogleFonts.poppins(
                                            fontSize: 12,
                                            color: const Color(0xffCE181B),
                                            fontWeight: FontWeight.w600)),
                                    const SizedBox(width: 4),
                                    Text("or drag and drop",
                                        style: GoogleFonts.poppins(
                                            fontSize: 12, color: Colors.black)),
                                  ],
                                ),
                                const SizedBox(height: 4),
                                Text("(Max. File size: 25 MB)",
                                    style: GoogleFonts.poppins(
                                        fontSize: 12, color: Colors.grey)),
                              ],
                            )
                          : ClipRRect(
                              borderRadius: BorderRadius.circular(10),
                              child: Image.file(
                                File(controller.selectedImage.value!.path),
                                fit: BoxFit.cover,
                                width: double.infinity,
                                height: 150,
                              ),
                            ),
                    ),
                  ),
                  const SizedBox(height: 10),
                  GestureDetector(
                    onTap: controller.pickImageFromCamera,
                    child: Container(
                      width: double.infinity,
                      height: 100,
                      decoration: BoxDecoration(
                        border: Border.all(color: Colors.grey),
                        borderRadius: BorderRadius.circular(10),
                      ),
                      child: controller.selectedImage.value == null
                          ? Column(
                              mainAxisAlignment: MainAxisAlignment.center,
                              children: [
                                Image.asset('assets/images/upload_camera.png',
                                    height: 43),
                                const SizedBox(height: 8),
                                Text("Open Camera",
                                    style: GoogleFonts.poppins(
                                        fontSize: 12,
                                        color: const Color(0xffCE181B),
                                        fontWeight: FontWeight.w600)),
                              ],
                            )
                          : ClipRRect(
                              borderRadius: BorderRadius.circular(10),
                              child: Image.file(
                                File(controller.selectedImage.value!.path),
                                fit: BoxFit.cover,
                                width: double.infinity,
                                height: 100,
                              ),
                            ),
                    ),
                  ),
                  const SizedBox(height: 16),
                  Text("Instructions", style: _labelStyle()),
                  const SizedBox(height: 4),
                  _buildTextField(controller.instructionsController,
                      "Provide step-by-step instructions...",
                      maxLines: 5, keyboardType: TextInputType.multiline),
                  const SizedBox(height: 30),
                  Row(
                    mainAxisAlignment: MainAxisAlignment.center,
                    children: [
                      Expanded(
                        child: ElevatedButton(
                          onPressed: controller.isLoading.value
                              ? null
                              : controller.updateRecipe,
                          style: ElevatedButton.styleFrom(
                            backgroundColor: const Color(0xffCE181B),
                            shape: RoundedRectangleBorder(
                              borderRadius: BorderRadius.circular(30),
                            ),
                            padding: const EdgeInsets.symmetric(vertical: 15),
                          ),
                          child: controller.isLoading.value
                              ? const CircularProgressIndicator(
                                  color: Colors.white)
                              : Text(
                                  'Update',
                                  style: GoogleFonts.poppins(
                                      fontSize: 16,
                                      fontWeight: FontWeight.w500,
                                      color: Colors.white),
                                ),
                        ),
                      ),
                      const SizedBox(width: 15),
                      Expanded(
                        child: ElevatedButton(
                          onPressed: controller.isLoading.value
                              ? null
                              : controller.deleteRecipe,
                          style: ElevatedButton.styleFrom(
                            backgroundColor: const Color(0xffCE181B),
                            shape: RoundedRectangleBorder(
                              borderRadius: BorderRadius.circular(30),
                            ),
                            padding: const EdgeInsets.symmetric(vertical: 15),
                          ),
                          child: controller.isLoading.value
                              ? const CircularProgressIndicator(
                                  color: Colors.white)
                              : Text(
                                  'Delete',
                                  style: GoogleFonts.poppins(
                                      fontSize: 16,
                                      fontWeight: FontWeight.w500,
                                      color: Colors.white),
                                ),
                        ),
                      ),
                    ],
                  ),
                  const SizedBox(height: 30),
                ],
              ),
            ),
          ],
        );
      }),
    );
  }
}
