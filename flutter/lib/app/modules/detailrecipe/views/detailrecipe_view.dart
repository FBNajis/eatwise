import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:google_fonts/google_fonts.dart';
import 'package:iconsax/iconsax.dart';
import 'package:eatwise/app/modules/detailrecipe/controllers/detailrecipe_controller.dart';
import 'package:cached_network_image/cached_network_image.dart';

class DetailrecipeView extends GetView<DetailrecipeController> {
  const DetailrecipeView({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return const DetailRecipePage();
  }
}

class DetailRecipePage extends StatefulWidget {
  const DetailRecipePage({Key? key}) : super(key: key);

  @override
  _DetailRecipePageState createState() => _DetailRecipePageState();
}

class _DetailRecipePageState extends State<DetailRecipePage> {
  final ScrollController _scrollController = ScrollController();
  bool _isImageVisible = true;
  final DetailrecipeController controller = Get.find<DetailrecipeController>();

  @override
  void initState() {
    super.initState();
    _scrollController.addListener(_onScroll);
  }

  void _onScroll() {
    if (_scrollController.offset > 200 && _isImageVisible) {
      setState(() => _isImageVisible = false);
    } else if (_scrollController.offset <= 200 && !_isImageVisible) {
      setState(() => _isImageVisible = true);
    }
  }

  @override
  void dispose() {
    _scrollController.removeListener(_onScroll);
    _scrollController.dispose();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: SafeArea(
        child: Obx(() {
          if (controller.isLoading.value) {
            return const Center(child: CircularProgressIndicator());
          }
          if (controller.recipe.value == null) {
            return const Center(
                child: Text('Recipe failed to load, try again'));
          }

          final recipe = controller.recipe.value!;

          return Stack(
            children: [
              // Recipe header image - loaded independently with improved caching
              if (_isImageVisible)
                Positioned(
                  top: 0,
                  left: 0,
                  right: 0,
                  child: recipe.imagePath != null
                      ? CachedNetworkImage(
                          imageUrl: recipe.imagePath!,
                          height: 250,
                          fit: BoxFit.cover,
                          // Improved caching settings for faster loading
                          memCacheHeight: 500,
                          maxHeightDiskCache: 500,
                          fadeInDuration: const Duration(milliseconds: 200),
                          placeholderFadeInDuration:
                              const Duration(milliseconds: 100),
                          // Use memory cache first
                          useOldImageOnUrlChange: true,
                          cacheKey: 'recipe_header_${recipe.id}',
                          placeholder: (context, url) => Container(
                            height: 250,
                            color: Colors.grey[300],
                            child: const Icon(Icons.restaurant,
                                size: 50, color: Colors.grey),
                          ),
                          errorWidget: (context, url, error) => Container(
                            height: 250,
                            color: Colors.grey[300],
                            child: const Icon(Icons.restaurant, size: 50),
                          ),
                        )
                      : Container(
                          height: 250,
                          color: Colors.grey[300],
                          child: const Icon(Icons.restaurant, size: 50),
                        ),
                ),
              Padding(
                padding: const EdgeInsets.only(bottom: 70),
                child: ListView(
                  controller: _scrollController,
                  padding: const EdgeInsets.only(top: 200),
                  physics:
                      const BouncingScrollPhysics(), // More responsive scrolling
                  children: [
                    _buildMainInfoCard(recipe),
                    if (recipe.imagePath != null)
                      _buildSectionTitle('Photo of ${recipe.name}'),
                    if (recipe.imagePath != null) _buildImageGallery(recipe),
                    _buildSectionTitle('Ingredients'),
                    _buildIngredientList(controller.getIngredientsList()),
                    _buildSectionTitle('How to Cook'),
                    _buildCookingSteps(controller.getCookingStepsList()),
                    _buildSectionTitle('Category'),
                    _buildCategoryChips(recipe.tag),
                    _buildSectionTitle(
                        '${controller.comments.length} Comments'),
                    // Comments section with separate loading state
                    Obx(() {
                      if (controller.isCommentsLoading.value) {
                        return const Padding(
                          padding: EdgeInsets.all(20),
                          child: Center(
                            child: SizedBox(
                              height: 30,
                              width: 30,
                              child: CircularProgressIndicator(strokeWidth: 2),
                            ),
                          ),
                        );
                      }

                      return Column(
                        children: controller.comments
                            .map((comment) => Padding(
                                  padding: const EdgeInsets.symmetric(
                                      horizontal: 20, vertical: 10),
                                  child: CommentItem(
                                    username: comment.username,
                                    comment: comment.comment,
                                    userImagePath: comment.userImagePath,
                                  ),
                                ))
                            .toList(),
                      );
                    }),
                    const SizedBox(height: 20),
                  ],
                ),
              ),
              _buildTopBar(context),
              _buildLikeButton(),
              _buildCommentInput(),
            ],
          );
        }),
      ),
    );
  }

  Widget _buildMainInfoCard(RecipeModel recipe) {
    return Container(
      margin: const EdgeInsets.symmetric(horizontal: 20, vertical: 10),
      padding: const EdgeInsets.all(16),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(13),
        boxShadow: [
          BoxShadow(
            color: Colors.black.withOpacity(0.1),
            blurRadius: 10,
            spreadRadius: 1,
          ),
        ],
      ),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Text(recipe.name,
              style: GoogleFonts.poppins(
                  fontSize: 18, fontWeight: FontWeight.bold)),
          const SizedBox(height: 8),
          Text(recipe.description,
              style:
                  GoogleFonts.poppins(fontSize: 14, color: Colors.grey[700])),
          const SizedBox(height: 16),
          _buildInfoRow('assets/images/sack.png',
              controller.formatPrice(recipe.costEstimation)),
          _buildInfoRow('assets/images/clock.png',
              controller.formatCookingTime(recipe.cookingTime)),
          _buildInfoRow(
              'assets/images/like.png', '${recipe.favoritesCount} Likes'),
          _buildInfoRow('assets/images/profile_red.png', recipe.creatorName),
        ],
      ),
    );
  }

  Widget _buildInfoRow(String icon, String text) {
    return Padding(
      padding: const EdgeInsets.only(bottom: 8.0),
      child: Row(
        children: [
          Image.asset(icon, width: 16, height: 16),
          const SizedBox(width: 8),
          Text(
            text,
            style:
                GoogleFonts.poppins(fontSize: 14, fontWeight: FontWeight.w500),
          ),
        ],
      ),
    );
  }

  Widget _buildSectionTitle(String title) {
    return Padding(
      padding: const EdgeInsets.fromLTRB(20, 20, 20, 10),
      child: Text(
        title,
        style: GoogleFonts.poppins(fontSize: 16, fontWeight: FontWeight.bold),
      ),
    );
  }

  Widget _buildImageGallery(RecipeModel recipe) {
    return Padding(
      padding: const EdgeInsets.symmetric(horizontal: 20),
      child: ClipRRect(
        borderRadius: BorderRadius.circular(12),
        child: CachedNetworkImage(
          imageUrl: recipe.imagePath!,
          height: 150,
          width: double.infinity,
          fit: BoxFit.cover,
          // Optimized caching for better performance
          memCacheHeight: 300,
          maxHeightDiskCache: 300,
          fadeInDuration: const Duration(milliseconds: 200),
          placeholderFadeInDuration: const Duration(milliseconds: 100),
          useOldImageOnUrlChange: true,
          cacheKey: 'recipe_gallery_${recipe.id}',
          placeholder: (context, url) => Container(
            height: 150,
            color: Colors.grey[300],
            child: const Icon(Icons.restaurant, size: 40, color: Colors.grey),
          ),
          errorWidget: (context, url, error) => Container(
            color: Colors.grey[300],
            child: const Icon(Icons.restaurant, size: 50),
          ),
        ),
      ),
    );
  }

  Widget _buildIngredientList(List<String> ingredients) {
    return Container(
      margin: const EdgeInsets.fromLTRB(20, 0, 20, 20),
      padding: const EdgeInsets.all(16),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(15),
        boxShadow: [
          BoxShadow(color: Colors.black.withOpacity(0.1), blurRadius: 10)
        ],
      ),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: ingredients.map((ingredient) {
          return IngredientItem(ingredient);
        }).toList(),
      ),
    );
  }

  Widget _buildCookingSteps(List<String> steps) {
    return Container(
      margin: const EdgeInsets.symmetric(horizontal: 20),
      padding: const EdgeInsets.all(16),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(15),
        boxShadow: [
          BoxShadow(color: Colors.black.withOpacity(0.1), blurRadius: 10)
        ],
      ),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: steps
            .map((step) => Padding(
                  padding: const EdgeInsets.only(bottom: 10),
                  child: _buildCookingStep(step),
                ))
            .toList(),
      ),
    );
  }

  Widget _buildCookingStep(String text) {
    return Row(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        const Text('• ', style: TextStyle(fontSize: 14)),
        Expanded(
          child: Text(
            text,
            style: GoogleFonts.poppins(fontSize: 14, color: Colors.grey[800]),
          ),
        ),
      ],
    );
  }

  Widget _buildCategoryChips(String category) {
    return Padding(
      padding: const EdgeInsets.symmetric(horizontal: 20),
      child: Wrap(
        spacing: 8,
        children: [category]
            .map((tag) => Container(
                  padding:
                      const EdgeInsets.symmetric(horizontal: 12, vertical: 8),
                  decoration: BoxDecoration(
                    color: const Color(0xffCE181B),
                    borderRadius: BorderRadius.circular(20),
                  ),
                  child: Text('#$tag',
                      style: GoogleFonts.poppins(
                          fontSize: 14, color: Colors.white)),
                ))
            .toList(),
      ),
    );
  }

  Widget _buildTopBar(BuildContext context) {
    return Positioned(
      top: MediaQuery.of(context).padding.top + 10,
      left: 15,
      child: Container(
        decoration: const BoxDecoration(
          color: Colors.white,
          shape: BoxShape.circle,
          boxShadow: [BoxShadow(color: Colors.black26, blurRadius: 5)],
        ),
        child: IconButton(
          icon: const Icon(Iconsax.arrow_left_2),
          onPressed: () => Get.back(),
        ),
      ),
    );
  }

  Widget _buildLikeButton() {
    return Positioned(
      top: MediaQuery.of(context).padding.top + 10,
      right: 15,
      child: CircleAvatar(
        backgroundColor: Colors.white,
        child: IconButton(
          icon: Obx(() => Icon(
                controller.isLiked.value
                    ? Icons.favorite
                    : Icons.favorite_border,
                color: controller.isLiked.value ? Colors.red : Colors.black,
              )),
          onPressed: () => controller.toggleLike(),
        ),
      ),
    );
  }

  Widget _buildCommentInput() {
    return Positioned(
      bottom: 0,
      left: 0,
      right: 0,
      child: Container(
        color: Colors.white,
        padding: const EdgeInsets.symmetric(horizontal: 20, vertical: 10),
        child: Row(
          children: [
            Expanded(
              child: Container(
                decoration: BoxDecoration(
                  color: Colors.grey[100],
                  borderRadius: BorderRadius.circular(30),
                  border: Border.all(color: Colors.grey.shade400),
                ),
                child: TextField(
                  controller: controller.commentController,
                  decoration: InputDecoration(
                    hintText: 'Write your comment here...',
                    hintStyle: GoogleFonts.poppins(color: Colors.grey),
                    border: InputBorder.none,
                    contentPadding: const EdgeInsets.symmetric(
                        horizontal: 20, vertical: 12),
                  ),
                ),
              ),
            ),
            const SizedBox(width: 10),
            Container(
              decoration: const BoxDecoration(
                color: Color(0xffCE181B),
                shape: BoxShape.circle,
              ),
              child: IconButton(
                icon: Obx(() => controller.isSendingComment.value
                    ? const SizedBox(
                        width: 24,
                        height: 24,
                        child: CircularProgressIndicator(
                          color: Colors.white,
                          strokeWidth: 2,
                        ),
                      )
                    : const Icon(Icons.send, color: Colors.white)),
                onPressed: () => controller.addComment(),
              ),
            ),
          ],
        ),
      ),
    );
  }
}

class IngredientItem extends StatelessWidget {
  final String text;

  const IngredientItem(this.text, {Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return Padding(
      padding: const EdgeInsets.symmetric(vertical: 4.0),
      child: Row(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          const Text('• ', style: TextStyle(fontSize: 14)),
          Expanded(child: Text(text, style: GoogleFonts.poppins(fontSize: 14))),
        ],
      ),
    );
  }
}

class CommentItem extends StatelessWidget {
  final String username;
  final String comment;
  final String? userImagePath;

  const CommentItem({
    Key? key,
    required this.username,
    required this.comment,
    this.userImagePath,
  }) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return Row(
      children: [
        // Profile image with improved caching for better performance
        ClipRRect(
          borderRadius: BorderRadius.circular(20),
          child: userImagePath != null
              ? CachedNetworkImage(
                  imageUrl: userImagePath!,
                  width: 40,
                  height: 40,
                  fit: BoxFit.cover,
                  // Optimized caching settings
                  memCacheWidth: 80,
                  maxWidthDiskCache: 80,
                  fadeInDuration: const Duration(milliseconds: 200),
                  placeholderFadeInDuration: const Duration(milliseconds: 100),
                  // Ensure we don't use stale cache for user images
                  cacheKey: 'user_${userImagePath!.hashCode}',
                  // Avoid transparency for better performance
                  filterQuality: FilterQuality.low,
                  placeholder: (context, url) => Container(
                    width: 40,
                    height: 40,
                    color: Colors.grey[300],
                    child: const Icon(Icons.person, color: Colors.grey),
                  ),
                  errorWidget: (context, url, error) => Container(
                    width: 40,
                    height: 40,
                    color: Colors.grey[300],
                    child: const Icon(Icons.person, color: Colors.grey),
                  ),
                )
              : Container(
                  width: 40,
                  height: 40,
                  color: Colors.grey[300],
                  child: const Icon(Icons.person, color: Colors.grey),
                ),
        ),
        const SizedBox(width: 10),
        Expanded(
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              Text(username,
                  style: GoogleFonts.poppins(fontWeight: FontWeight.bold)),
              Text(comment, style: GoogleFonts.poppins()),
            ],
          ),
        ),
      ],
    );
  }
}
