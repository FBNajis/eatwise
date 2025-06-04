import 'package:eatwise/app/routes/app_pages.dart';
import 'package:flutter/material.dart';

import 'package:get/get.dart';

import '../controllers/recipebasedoncategories_controller.dart';
import 'package:google_fonts/google_fonts.dart';
import 'package:iconsax/iconsax.dart';

class RecipebasedoncategoriesView
    extends GetView<RecipebasedoncategoriesController> {
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        backgroundColor: Colors.white,
        elevation: 0,
        leading: Container(
          margin: EdgeInsets.all(8),
          decoration: BoxDecoration(
            shape: BoxShape.circle,
            color: Colors.white,
            boxShadow: [
              BoxShadow(
                color: Colors.black26,
                blurRadius: 4,
                offset: Offset(0, 2),
              ),
            ],
          ),
          child: IconButton(
            icon: Icon(Iconsax.arrow_left_2, color: Colors.black),
            onPressed: () => Navigator.pop(context),
          ),
        ),
        centerTitle: true,
        title: Obx(() => Text(
              controller.category.value,
              style: GoogleFonts.poppins(
                fontSize: 18,
                fontWeight: FontWeight.bold,
                color: Colors.black,
              ),
            )),
      ),
      body: Padding(
        padding: const EdgeInsets.all(16.0),
        child: RefreshIndicator(
          onRefresh: () async {
            await controller.refreshData();
          },
          child: Obx(() {
            if (controller.isLoading.value) {
              return Center(child: CircularProgressIndicator());
            }

            if (controller.recipesByCategories.isEmpty) {
              return ListView(
                physics: const AlwaysScrollableScrollPhysics(),
                children: [
                  SizedBox(
                    height: MediaQuery.of(context).size.height / 2.5,
                    child: Center(
                        child: Text('No recipes found for this category')),
                  ),
                ],
              );
            }

            return GridView.builder(
              physics: const AlwaysScrollableScrollPhysics(),
              gridDelegate: SliverGridDelegateWithFixedCrossAxisCount(
                crossAxisCount: 2,
                childAspectRatio: 0.76,
                crossAxisSpacing: 10,
                mainAxisSpacing: 10,
              ),
              itemCount: controller.recipesByCategories.length,
              itemBuilder: (context, index) {
                var recipe = controller.recipesByCategories[index];
                return _buildRecommendationCard(
                  recipe['name'],
                  recipe['creator_name'],
                  recipe['cost_estimation'].toString(),
                  recipe['favorites_count'].toString(),
                  recipe['image_url'],
                  recipe,
                );
              },
            );
          }),
        ),
      ),
    );
  }

  Widget _buildRecommendationCard(String title, String author, String price,
      String likes, String imagePath, final Map<String, dynamic> recipe) {
    String formatCost(dynamic cost) {
      if (cost is num) {
        return cost
            .toStringAsFixed(0)
            .replaceAllMapped(RegExp(r'\B(?=(\d{3})+(?!\d))'), (match) => '.');
      }
      return cost.toString();
    }

    String formattedPrice = formatCost(double.parse(price));
    return GestureDetector(
      onTap: () {
        Get.toNamed(Routes.DETAILRECIPE, arguments: recipe);
      },
      child: Container(
        decoration: BoxDecoration(
          color: Colors.white,
          borderRadius: BorderRadius.circular(15),
          boxShadow: [
            BoxShadow(
              color: Colors.grey.withOpacity(0.2),
              spreadRadius: 1,
              blurRadius: 4,
              offset: Offset(0, 2),
            ),
          ],
        ),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            ClipRRect(
              borderRadius: BorderRadius.vertical(top: Radius.circular(15)),
              child: Image.network(
                imagePath,
                height: 120,
                width: double.infinity,
                fit: BoxFit.cover,
                errorBuilder: (context, error, stackTrace) {
                  return Container(
                    height: 120,
                    width: double.infinity,
                    color: Colors.red[100],
                    child: Center(
                      child: Icon(
                        Icons.restaurant,
                        size: 50,
                        color: Colors.red,
                      ),
                    ),
                  );
                },
                loadingBuilder: (context, child, loadingProgress) {
                  if (loadingProgress == null) return child;
                  return Container(
                    height: 120,
                    width: double.infinity,
                    child: Center(child: CircularProgressIndicator()),
                  );
                },
              ),
            ),
            Padding(
              padding:
                  const EdgeInsets.symmetric(horizontal: 12.0, vertical: 10.0),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Text(
                    author,
                    style: GoogleFonts.poppins(
                      fontSize: 10,
                      color: Colors.grey,
                    ),
                    maxLines: 1,
                    overflow: TextOverflow.ellipsis,
                  ),
                  SizedBox(height: 4),
                  Text(
                    title,
                    style: GoogleFonts.poppins(
                      fontSize: 14,
                      fontWeight: FontWeight.bold,
                    ),
                    maxLines: 1,
                    overflow: TextOverflow.ellipsis,
                  ),
                  SizedBox(height: 4),
                  Row(
                    children: [
                      Image.asset('assets/images/sack.png', height: 16),
                      SizedBox(width: 4),
                      Text('IDR $formattedPrice',
                          style: GoogleFonts.poppins(fontSize: 10)),
                      Spacer(),
                      Image.asset('assets/images/like.png', height: 16),
                      SizedBox(width: 4),
                      Text('$likes Likes',
                          style: GoogleFonts.poppins(fontSize: 10)),
                    ],
                  ),
                ],
              ),
            ),
          ],
        ),
      ),
    );
  }
}
