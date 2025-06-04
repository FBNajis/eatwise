import 'dart:ui';
import 'package:eatwise/app/modules/bottomnavigation/views/bottomnavigation_view.dart';
import 'package:eatwise/app/routes/app_pages.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:google_fonts/google_fonts.dart';
import 'package:iconsax/iconsax.dart';
import '../controllers/home_controller.dart';

class HomeView extends GetView<HomeController> {
  const HomeView({super.key});

  @override
  Widget build(BuildContext context) {
    // Ensure data is loaded when the view is built
    WidgetsBinding.instance.addPostFrameCallback((_) {
      if (controller.topLikedRecipes.isEmpty && !controller.isLoading.value) {
        controller.refreshData();
      }
    });

    return Scaffold(
      backgroundColor: Colors.white,
      body: RefreshIndicator(
        onRefresh: () async {
          await controller.refreshData();
        },
        child: SafeArea(
          child: SingleChildScrollView(
            physics: AlwaysScrollableScrollPhysics(),
            child: Column(
              children: [
                Container(
                  height: 320,
                  width: double.infinity,
                  decoration: BoxDecoration(
                    image: DecorationImage(
                      image: AssetImage('assets/images/home_background.png'),
                      fit: BoxFit.cover,
                    ),
                  ),
                  child: Padding(
                    padding: const EdgeInsets.all(16.0),
                    child: Column(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      mainAxisSize: MainAxisSize.min,
                      children: [
                        Padding(
                          padding: EdgeInsets.symmetric(horizontal: 16),
                          child: Row(
                            crossAxisAlignment: CrossAxisAlignment.start,
                            children: [
                              Expanded(
                                flex: 3,
                                child: Column(
                                  crossAxisAlignment: CrossAxisAlignment.start,
                                  children: [
                                    SizedBox(height: 50),
                                    Row(
                                      children: [
                                        Obx(() => Text(
                                              'Hello, ${controller.username.value}!',
                                              style: GoogleFonts.poppins(
                                                fontSize: 24,
                                                fontWeight: FontWeight.bold,
                                                color: Colors.white,
                                              ),
                                            )),
                                        SizedBox(width: 5),
                                        Icon(Icons.waving_hand,
                                            color: Colors.amber)
                                      ],
                                    ),
                                    SizedBox(height: 17),
                                    Text(
                                      'Unleash Your Culinary \nCreativity And Start \nCooking Today!',
                                      style: GoogleFonts.poppins(
                                        fontSize: 15,
                                        fontWeight: FontWeight.w500,
                                        color: Colors.white,
                                      ),
                                    ),
                                  ],
                                ),
                              ),
                            ],
                          ),
                        ),
                        Spacer(),
                        Container(
                          padding: EdgeInsets.symmetric(horizontal: 13),
                          child: Row(
                            children: [
                              Expanded(
                                child: Container(
                                  padding: EdgeInsets.symmetric(horizontal: 12),
                                  decoration: BoxDecoration(
                                    color: Colors.white,
                                    borderRadius: BorderRadius.circular(30),
                                    boxShadow: [
                                      BoxShadow(
                                        color: Colors.grey.withOpacity(0.3),
                                        spreadRadius: 4,
                                        blurRadius: 8,
                                        offset: Offset(0, 2),
                                      ),
                                    ],
                                  ),
                                  child: Row(
                                    children: [
                                      Icon(Icons.search, color: Colors.grey),
                                      SizedBox(width: 10),
                                      Expanded(
                                        child: Obx(() => TextField(
                                              controller:
                                                  controller.searchController,
                                              style: GoogleFonts.poppins(),
                                              onChanged: (value) {
                                                // Only search if data is loaded
                                                if (!controller
                                                    .isLoading.value) {
                                                  controller
                                                      .searchRecipes(value);
                                                }
                                              },
                                              decoration: InputDecoration(
                                                hintText:
                                                    controller.isLoading.value
                                                        ? 'Loading recipes...'
                                                        : 'Search recipe...',
                                                border: InputBorder.none,
                                                hintStyle: GoogleFonts.poppins(
                                                  color: Colors.grey,
                                                  fontSize: 14,
                                                ),
                                              ),
                                              enabled:
                                                  !controller.isLoading.value,
                                              textInputAction:
                                                  TextInputAction.done,
                                              onSubmitted: (value) {
                                                // Refresh the page when done is pressed
                                                controller.refreshData();
                                              },
                                            )),
                                      ),
                                    ],
                                  ),
                                ),
                              ),
                              SizedBox(width: 10),
                              Container(
                                decoration: BoxDecoration(
                                  color: Colors.white,
                                  shape: BoxShape.circle,
                                  boxShadow: [
                                    BoxShadow(
                                      color: Colors.grey.withOpacity(0.2),
                                      spreadRadius: 4,
                                      blurRadius: 8,
                                      offset: Offset(0, 2),
                                    ),
                                  ],
                                ),
                                child: IconButton(
                                  icon: Icon(Iconsax.setting_4,
                                      color: Colors.grey, size: 20),
                                  onPressed: () {
                                    _showFilterPopup(context);
                                  },
                                  padding: EdgeInsets.all(12),
                                ),
                              ),
                            ],
                          ),
                        ),
                      ],
                    ),
                  ),
                ),
                Container(
                  color: Colors.white,
                  padding: EdgeInsets.all(16),
                  child: Obx(() {
                    // If data is still loading and this is the first load
                    if (controller.isLoading.value &&
                        controller.topLikedRecipes.isEmpty) {
                      return Center(
                        child: Padding(
                          padding: const EdgeInsets.all(32.0),
                          child: Column(
                            children: [
                              CircularProgressIndicator(
                                color: Color(0xffCE181B),
                              ),
                              SizedBox(height: 16),
                              Text(
                                'Loading recipes...',
                                style: GoogleFonts.poppins(
                                  fontSize: 16,
                                  fontWeight: FontWeight.w500,
                                ),
                              ),
                            ],
                          ),
                        ),
                      );
                    }

                    // Cek apakah search sedang aktif
                    bool isSearchActive =
                        controller.searchController.text.isNotEmpty;

                    if (isSearchActive) {
                      // Menampilkan hasil pencarian
                      if (controller.filteredRecipes.isEmpty) {
                        return Center(
                          child: Padding(
                            padding: const EdgeInsets.all(32.0),
                            child: Text(
                              'No recipes found',
                              style: GoogleFonts.poppins(
                                fontSize: 16,
                                fontWeight: FontWeight.w500,
                              ),
                            ),
                          ),
                        );
                      }

                      return Column(
                        crossAxisAlignment: CrossAxisAlignment.start,
                        children: [
                          Padding(
                            padding: const EdgeInsets.symmetric(vertical: 8.0),
                            child: Text(
                              'Search Results',
                              style: GoogleFonts.poppins(
                                fontSize: 16,
                                fontWeight: FontWeight.bold,
                              ),
                            ),
                          ),
                          GridView.builder(
                            shrinkWrap: true,
                            physics: NeverScrollableScrollPhysics(),
                            gridDelegate:
                                SliverGridDelegateWithFixedCrossAxisCount(
                              crossAxisCount: 2,
                              crossAxisSpacing: 10,
                              mainAxisSpacing: 10,
                              childAspectRatio: 0.75,
                            ),
                            itemCount: controller.filteredRecipes.length,
                            itemBuilder: (context, index) {
                              final recipe = controller.filteredRecipes[index];
                              return _buildRecipeCard(recipe);
                            },
                          ),
                        ],
                      );
                    } else {
                      // Tampilan normal dengan kategori dan rekomendasi
                      return Column(
                        crossAxisAlignment: CrossAxisAlignment.start,
                        children: [
                          GridView.count(
                            crossAxisCount: 4,
                            shrinkWrap: true,
                            physics: NeverScrollableScrollPhysics(),
                            childAspectRatio: 0.8,
                            children: [
                              _buildCategoryItem(
                                  'Snack', 'assets/images/snack.png'),
                              _buildCategoryItem(
                                  'Drink', 'assets/images/drink.png'),
                              _buildCategoryItem(
                                  'Dessert', 'assets/images/dessert.png'),
                              _buildCategoryItem(
                                  'Rice', 'assets/images/rice.png'),
                              _buildCategoryItem(
                                  'Seafood', 'assets/images/seafood.png'),
                              _buildCategoryItem(
                                  'Salad', 'assets/images/salad.png'),
                              _buildCategoryItem(
                                  'Bread', 'assets/images/bread.png'),
                              _buildCategoryItem(
                                  'Noodle', 'assets/images/noodle.png'),
                            ],
                          ),
                          SizedBox(height: 3),
                          Row(
                            mainAxisAlignment: MainAxisAlignment.spaceBetween,
                            children: [
                              Text(
                                'Recommendation',
                                style: GoogleFonts.poppins(
                                  fontSize: 16,
                                  fontWeight: FontWeight.bold,
                                ),
                              ),
                              TextButton(
                                onPressed: () {
                                  Get.toNamed(
                                      Routes.RECIPEBASEDONRECOMMENDATION);
                                },
                                child: Text(
                                  'View All',
                                  style: GoogleFonts.poppins(
                                    color: Color(0xffCE181B),
                                    fontWeight: FontWeight.w600,
                                    fontSize: 13,
                                  ),
                                ),
                              ),
                            ],
                          ),
                          SizedBox(height: 8),
                          _buildRecommendations(),
                        ],
                      );
                    }
                  }),
                ),
              ],
            ),
          ),
        ),
      ),
      bottomNavigationBar: BottomnavigationView(
        currentIndex: 0,
        onTap: (index) {
          switch (index) {
            case 0:
              break;
            case 1:
              Get.offNamed(Routes.RECIPE);
              break;
            case 2:
              Get.offNamed(Routes.CHATBOT);
              break;
            case 3:
              Get.offNamed(Routes.PROFILE);
              break;
          }
        },
      ),
    );
  }

  Widget _buildRecommendations() {
    if (controller.isLoading.value) {
      return Padding(
        padding: const EdgeInsets.symmetric(vertical: 32.0),
        child: Center(
            child: CircularProgressIndicator(
          color: Color(0xffCE181B),
        )),
      );
    }
    if (controller.topLikedRecipes.isEmpty) {
      return Center(
        child: Column(
          children: [
            SizedBox(height: 16),
            Text(
              "No recommendations available",
              style: GoogleFonts.poppins(
                fontSize: 14,
              ),
            ),
            SizedBox(height: 8),
            ElevatedButton(
              onPressed: () {
                controller.refreshData();
              },
              style: ElevatedButton.styleFrom(
                backgroundColor: Color(0xffCE181B),
                shape: RoundedRectangleBorder(
                  borderRadius: BorderRadius.circular(10),
                ),
              ),
              child: Text(
                'Refresh',
                style: GoogleFonts.poppins(
                  color: Colors.white,
                  fontWeight: FontWeight.w500,
                ),
              ),
            ),
          ],
        ),
      );
    } else {
      return Row(
        children: [
          // Card pertama (selalu muncul kalau ada data)
          Expanded(
            child: _buildRecommendationCard(
              controller.topLikedRecipes[0]['name'],
              controller.topLikedRecipes[0]['creator_name'],
              controller.topLikedRecipes[0]['cost_estimation'].toString(),
              controller.topLikedRecipes[0]['favorites_count'].toString(),
              controller.topLikedRecipes[0]['image_url'],
              controller.topLikedRecipes[0],
            ),
          ),
          SizedBox(width: 10),
          Expanded(
            child: controller.topLikedRecipes.length > 1
                ? _buildRecommendationCard(
                    controller.topLikedRecipes[1]['name'],
                    controller.topLikedRecipes[1]['creator_name'],
                    controller.topLikedRecipes[1]['cost_estimation'].toString(),
                    controller.topLikedRecipes[1]['favorites_count'].toString(),
                    controller.topLikedRecipes[1]['image_url'],
                    controller.topLikedRecipes[1],
                  )
                : Container(),
          ),
        ],
      );
    }
  }

  Widget _buildCategoryItem(String title, String imagePath) {
    return GestureDetector(
      onTap: () {
        Get.toNamed(Routes.RECIPEBASEDONCATEGORIES, arguments: title);
      },
      child: Column(
        children: [
          Container(
            padding: EdgeInsets.all(10),
            decoration: BoxDecoration(
              color: Colors.pink[50],
              borderRadius: BorderRadius.circular(15),
            ),
            child: Image.asset(
              imagePath,
              height: 54,
              width: 54,
            ),
          ),
          SizedBox(height: 5),
          Text(
            title,
            textAlign: TextAlign.center,
            style: GoogleFonts.poppins(
              fontSize: 12,
            ),
          ),
        ],
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
          mainAxisSize: MainAxisSize.min,
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
              padding: const EdgeInsets.all(12.0),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Text(
                    author,
                    style: GoogleFonts.poppins(
                      fontSize: 10,
                      color: Colors.grey,
                    ),
                  ),
                  SizedBox(height: 5),
                  Text(
                    title,
                    style: GoogleFonts.poppins(
                      fontSize: 14,
                      fontWeight: FontWeight.bold,
                    ),
                    overflow: TextOverflow.ellipsis,
                  ),
                  SizedBox(height: 5),
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

  // Widget untuk menampilkan kartu resep di hasil pencarian
  Widget _buildRecipeCard(Map<String, dynamic> recipe) {
    String formatCost(dynamic cost) {
      if (cost is num) {
        return cost
            .toStringAsFixed(0)
            .replaceAllMapped(RegExp(r'\B(?=(\d{3})+(?!\d))'), (match) => '.');
      }
      return cost.toString();
    }

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
          mainAxisSize: MainAxisSize.min,
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            ClipRRect(
              borderRadius: BorderRadius.vertical(top: Radius.circular(15)),
              child: Image.network(
                recipe['image_url'] ?? '',
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
                    color: Colors.grey.shade200,
                    child: Center(
                      child: CircularProgressIndicator(
                        value: loadingProgress.expectedTotalBytes != null
                            ? loadingProgress.cumulativeBytesLoaded /
                                loadingProgress.expectedTotalBytes!
                            : null,
                      ),
                    ),
                  );
                },
              ),
            ),
            Padding(
              padding: const EdgeInsets.all(12.0),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Text(
                    recipe['creator_name'] ?? 'Unknown',
                    style: GoogleFonts.poppins(
                      fontSize: 10,
                      color: Colors.grey,
                    ),
                  ),
                  SizedBox(height: 5),
                  Text(
                    recipe['name'] ?? '',
                    style: GoogleFonts.poppins(
                      fontSize: 13,
                      fontWeight: FontWeight.bold,
                    ),
                    maxLines: 2,
                    overflow: TextOverflow.ellipsis,
                  ),
                  SizedBox(height: 3),
                  Row(
                    children: [
                      Image.asset('assets/images/sack.png', height: 14),
                      SizedBox(width: 4),
                      Text(
                        'IDR ${formatCost(recipe['cost_estimation'] ?? 0)}',
                        style: GoogleFonts.poppins(fontSize: 10),
                      ),
                      Spacer(),
                      Image.asset('assets/images/like.png', height: 16),
                      SizedBox(width: 4),
                      Text(
                        '${recipe['favorites_count'] ?? 0} Likes',
                        style: GoogleFonts.poppins(fontSize: 10),
                      ),
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

  void _showFilterPopup(BuildContext context) {
    String? selectedPriceRange;

    showDialog(
      context: context,
      builder: (BuildContext context) {
        return BackdropFilter(
          filter: ImageFilter.blur(sigmaX: 5, sigmaY: 5),
          child: Dialog(
            shape: RoundedRectangleBorder(
              borderRadius: BorderRadius.circular(20),
            ),
            child: Container(
              padding: EdgeInsets.all(20),
              child: Column(
                mainAxisSize: MainAxisSize.min,
                crossAxisAlignment: CrossAxisAlignment.stretch,
                children: [
                  Text(
                    'Filter',
                    textAlign: TextAlign.center,
                    style: GoogleFonts.poppins(
                      fontSize: 20,
                      fontWeight: FontWeight.bold,
                    ),
                  ),
                  SizedBox(height: 20),
                  Text(
                    'Price',
                    style: GoogleFonts.poppins(
                      fontSize: 16,
                      fontWeight: FontWeight.w600,
                    ),
                  ),
                  SizedBox(height: 10),
                  StatefulBuilder(
                    builder: (context, setState) {
                      return Wrap(
                        spacing: 10,
                        runSpacing: 10,
                        children: [
                          _buildPriceFilterChip('<15K',
                              isSelected: selectedPriceRange == '<15K',
                              onSelected: () {
                            setState(() {
                              selectedPriceRange = '<15K';
                            });
                          }),
                          _buildPriceFilterChip('15K - 30K',
                              isSelected: selectedPriceRange == '15K - 30K',
                              onSelected: () {
                            setState(() {
                              selectedPriceRange = '15K - 30K';
                            });
                          }),
                          _buildPriceFilterChip('30K - 50K',
                              isSelected: selectedPriceRange == '30K - 50K',
                              onSelected: () {
                            setState(() {
                              selectedPriceRange = '30K - 50K';
                            });
                          }),
                          _buildPriceFilterChip('50K - 100K',
                              isSelected: selectedPriceRange == '50K - 100K',
                              onSelected: () {
                            setState(() {
                              selectedPriceRange = '50K - 100K';
                            });
                          }),
                          _buildPriceFilterChip('>100K',
                              isSelected: selectedPriceRange == '>100K',
                              onSelected: () {
                            setState(() {
                              selectedPriceRange = '>100K';
                            });
                          }),
                        ],
                      );
                    },
                  ),
                  SizedBox(height: 20),
                  ElevatedButton(
                    onPressed: () {
                      if (selectedPriceRange != null) {
                        Navigator.of(context).pop();
                        Get.toNamed(Routes.RECIPEBASEDONBUDGET,
                            arguments: selectedPriceRange);
                      } else {
                        Get.snackbar(
                          'Error',
                          'Please select a price range',
                          snackPosition: SnackPosition.BOTTOM,
                          backgroundColor: Colors.red,
                          colorText: Colors.white,
                        );
                      }
                    },
                    style: ElevatedButton.styleFrom(
                      backgroundColor: Color(0xffCE181B),
                      shape: RoundedRectangleBorder(
                        borderRadius: BorderRadius.circular(10),
                      ),
                    ),
                    child: Text(
                      'Send',
                      style: GoogleFonts.poppins(
                        color: Colors.white,
                        fontWeight: FontWeight.bold,
                      ),
                    ),
                  ),
                ],
              ),
            ),
          ),
        );
      },
    );
  }

  Widget _buildPriceFilterChip(
    String label, {
    required bool isSelected,
    required VoidCallback onSelected,
  }) {
    return ChoiceChip(
      label: Text(
        label,
        style: GoogleFonts.poppins(
          color: isSelected ? Colors.white : Colors.black,
        ),
      ),
      selected: isSelected,
      onSelected: (_) => onSelected(),
      selectedColor: Color(0xffCE181B),
      backgroundColor: Colors.grey[200],
    );
  }
}
