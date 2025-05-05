import 'dart:io';
import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'package:get/get.dart';
import 'package:google_fonts/google_fonts.dart';
import '../controllers/addrecipe_controller.dart';

class AddrecipeView extends StatelessWidget {
  final AddrecipeController controller = Get.put(AddrecipeController());

  TextStyle _labelStyle() {
    return GoogleFonts.poppins(fontSize: 14, color: Color(0xff667085));
  }

  InputDecoration _inputDecoration(String hint) {
    return InputDecoration(
      hintText: hint,
      hintStyle: GoogleFonts.poppins(color: Color(0xff667085), fontSize: 14),
      filled: true,
      fillColor: Color(0xffFFF3F3),
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
    return WillPopScope(
      onWillPop: () async {
        controller.clearForm(); 
        return true;
      },
      child: Scaffold(
        appBar: AppBar(
          title: const Text('Add Recipe',
              style: TextStyle(fontWeight: FontWeight.bold)),
          centerTitle: true,
          leading: IconButton(
            icon: Icon(Icons.chevron_left, size: 33),
            onPressed: () {
              controller.clearForm(); 
              Get.back();
            },
          ),
        ),
        body: Obx(() => Stack(
              children: [
                SingleChildScrollView(
                  padding: const EdgeInsets.all(18),
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      Text("Dish name", style: _labelStyle()),
                      SizedBox(height: 4),
                      _buildTextField(controller.dishNameController,
                          "Insert the name of the dish...",
                          maxLines: 1),
                      SizedBox(height: 12),
                      Text("Description", style: _labelStyle()),
                      SizedBox(height: 4),
                      _buildTextField(controller.descriptionController,
                          "Insert the description...",
                          maxLines: 3),
                      SizedBox(height: 12),
                      Text("Cost estimation", style: _labelStyle()),
                      SizedBox(height: 4),
                      _buildTextField(
                        controller.costController,
                        "Insert a cost estimation...",
                        maxLines: 1,
                        keyboardType: TextInputType.number,
                        inputFormatters: [
                          FilteringTextInputFormatter.digitsOnly
                        ],
                      ),
                      SizedBox(height: 12),
                      Text("Cooking time (in minutes)", style: _labelStyle()),
                      SizedBox(height: 4),
                      _buildTextField(
                        controller.timeController,
                        "Insert a cooking time...",
                        maxLines: 1,
                        keyboardType: TextInputType.number,
                        inputFormatters: [
                          FilteringTextInputFormatter.digitsOnly
                        ],
                      ),
                      SizedBox(height: 12),
                      Text("Ingredients", style: _labelStyle()),
                      SizedBox(height: 4),
                      _buildTextField(
                        controller.ingredientsController,
                        "Enter ingredients...",
                        maxLines: 4,
                        keyboardType: TextInputType.multiline,
                      ),
                      SizedBox(height: 12),
                      Text("Category", style: _labelStyle()),
                      SizedBox(height: 4),
                      DropdownButtonFormField<String>(
                        value: controller.selectedCategory?.value == ""
                            ? null
                            : controller.selectedCategory?.value,
                        decoration: InputDecoration(
                          border: OutlineInputBorder(
                            borderRadius: BorderRadius.circular(12),
                            borderSide:
                                BorderSide(color: Color(0xffCE181B), width: 1),
                          ),
                          enabledBorder: OutlineInputBorder(
                            borderRadius: BorderRadius.circular(12),
                            borderSide:
                                BorderSide(color: Color(0xffCE181B), width: 1),
                          ),
                          focusedBorder: OutlineInputBorder(
                            borderRadius: BorderRadius.circular(12),
                            borderSide: BorderSide(
                                color: Color(0xffCE181B), width: 1.5),
                          ),
                        ),
                        style: GoogleFonts.poppins(
                            fontSize: 16, color: Colors.black),
                        dropdownColor: Colors.white,
                        hint: Text("Select a category",
                            style: GoogleFonts.poppins(
                                fontSize: 16, color: Colors.black54)),
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
                                  child: Text(category,
                                      style: GoogleFonts.poppins(
                                          fontSize: 14, color: Colors.black)),
                                ))
                            .toList(),
                        onChanged: (value) {
                          controller.selectedCategory?.value = value!;
                        },
                      ),
                      SizedBox(height: 16),
                      Text("Food image", style: _labelStyle()),
                      SizedBox(height: 4),
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
                                    Image.asset(
                                        'assets/images/upload_image.png',
                                        height: 40),
                                    SizedBox(height: 8),
                                    Row(
                                      mainAxisAlignment:
                                          MainAxisAlignment.center,
                                      children: [
                                        Text("Click to Upload",
                                            style: GoogleFonts.poppins(
                                                fontSize: 12,
                                                color: Color(0xffCE181B),
                                                fontWeight: FontWeight.w600)),
                                        SizedBox(width: 4),
                                        Text("or drag and drop",
                                            style: GoogleFonts.poppins(
                                                fontSize: 12,
                                                color: Colors.black)),
                                      ],
                                    ),
                                    SizedBox(height: 4),
                                    Text("(Max. File size: 25 MB)",
                                        style: GoogleFonts.poppins(
                                            fontSize: 12, color: Colors.grey)),
                                  ],
                                )
                              : Image.file(
                                  File(controller.selectedImage.value!.path),
                                  fit: BoxFit.cover),
                        ),
                      ),
                      SizedBox(height: 10),
                      GestureDetector(
                        onTap: () async {
                          try {
                            // Tampilkan loading indicator
                            Get.dialog(
                              Center(
                                child: CircularProgressIndicator(
                                  valueColor: AlwaysStoppedAnimation<Color>(Color(0xffCE181B)),
                                ),
                              ),
                              barrierDismissible: false,
                            );
                            
                            // Panggil fungsi untuk mengambil gambar
                            await controller.pickImageFromCamera();
                            
                            // Tutup dialog loading setelah selesai
                            Get.back();
                            } catch (e) {
                              // Tutup dialog loading jika terjadi error
                              Get.back();
                              // Tampilkan pesan error
                              Get.snackbar('Error', 'Gagal mengambil gambar: ${e.toString()}');
                            }
                          },
                          child: Container(
                            width: double.infinity,
                            height: 100,
                            decoration: BoxDecoration(
                              border: Border.all(color: Colors.grey),
                              borderRadius: BorderRadius.circular(10),
                            ),
                            child: Obx(() => controller.selectedImage.value == null
                              ? Column(
                                  mainAxisAlignment: MainAxisAlignment.center,
                                  children: [
                                    Image.asset(
                                      'assets/images/upload_camera.png',
                                      height: 43,
                                    ),
                                    SizedBox(height: 8),
                                    Text(
                                      "Open Camera",
                                      style: GoogleFonts.poppins(
                                        fontSize: 12,
                                        color: Color(0xffCE181B),
                                        fontWeight: FontWeight.w600,
                                      ),
                                    ),
                                  ],
                                )
                              : ClipRRect(
                                  borderRadius: BorderRadius.circular(9),
                                  child: Image.file(
                                    File(controller.selectedImage.value!.path),
                                    fit: BoxFit.cover,
                                    frameBuilder: (context, child, frame, wasSynchronouslyLoaded) {
                                      if (wasSynchronouslyLoaded || frame != null) {
                                        return child;
                                      }
                                      return Center(child: CircularProgressIndicator());
                                    },
                                  ),
                                ),
                            ),
                          ),
                        ),
                      SizedBox(height: 16),
                      Text("Instructions", style: _labelStyle()),
                      SizedBox(height: 4),
                      _buildTextField(
                        controller.instructionsController,
                        "Provide step-by-step instructions...",
                        maxLines: 5,
                        keyboardType: TextInputType.multiline,
                      ),
                      SizedBox(height: 16),
                      SizedBox(
                        width: double.infinity,
                        child: Obx(() => ElevatedButton(
                              style: ElevatedButton.styleFrom(
                                  backgroundColor: Color(0xffCE181B),
                                  padding: EdgeInsets.symmetric(vertical: 18)),
                              onPressed: controller.isLoading.value
                                  ? null
                                  : controller.submitRecipe,
                              child: controller.isLoading.value
                                  ? CircularProgressIndicator(
                                      color: Colors.white, strokeWidth: 2)
                                  : Text(
                                      "Send",
                                      style: GoogleFonts.poppins(
                                          fontSize: 16,
                                          fontWeight: FontWeight.w600,
                                          color: Colors.white),
                                    ),
                            )),
                      ),
                    ],
                  ),
                ),
              ],
            )),
      ),
    );
  }
}
