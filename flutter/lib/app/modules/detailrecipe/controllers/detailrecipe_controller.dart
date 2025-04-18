import 'dart:convert';
import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:http/http.dart' as http;
import 'package:get_storage/get_storage.dart';

class RecipeModel {
  final int id;
  final String name;
  final String description;
  final int costEstimation;
  final int cookingTime;
  final String ingredients;
  final String instructions;
  final String tag;
  final String? imagePath;
  final String createdAt;
  int favoritesCount;
  final String creatorName;
  bool isLiked;

  RecipeModel({
    required this.id,
    required this.name,
    required this.description,
    required this.costEstimation,
    required this.cookingTime,
    required this.ingredients,
    required this.instructions,
    required this.tag,
    this.imagePath,
    required this.createdAt,
    required this.favoritesCount,
    required this.creatorName,
    this.isLiked = false,
  });

  factory RecipeModel.fromJson(Map<String, dynamic> json) {
    return RecipeModel(
      id: json['id'],
      name: json['name'],
      description: json['description'],
      costEstimation: json['cost_estimation'],
      cookingTime: json['cooking_time'],
      ingredients: json['ingredients'],
      instructions: json['instructions'],
      tag: json['tag'],
      imagePath: json['image_path'],
      createdAt: json['created_at'],
      favoritesCount: json['favorites_count'],
      creatorName: json['creator_name'],
    );
  }
}

class CommentModel {
  final int id;
  final String username;
  final String comment;
  final String createdAt;
  final String? userImagePath;

  CommentModel({
    required this.id,
    required this.username,
    required this.comment,
    required this.createdAt,
    this.userImagePath,
  });

  factory CommentModel.fromJson(Map<String, dynamic> json) {
    String? imagePath = json['user_image_path'];

    if (imagePath != null &&
        imagePath.isNotEmpty &&
        !imagePath.startsWith('http')) {
      imagePath = 'http://10.0.2.2:8000/storage/$imagePath';
    }

    return CommentModel(
      id: json['id'],
      username: json['username'],
      comment: json['comment'],
      createdAt: json['created_at'],
      userImagePath: imagePath,
    );
  }
}

class DetailrecipeController extends GetxController {
  late int recipeId;
  final baseUrl = 'http://10.0.2.2:8000/api';
  final isLoading = true.obs;
  final isCommentsLoading = true.obs;
  final recipe = Rx<RecipeModel?>(null);
  final comments = <CommentModel>[].obs;
  final isLiked = false.obs;
  final isSendingComment = false.obs;
  final commentText = ''.obs;
  final TextEditingController commentController = TextEditingController();
  final box = GetStorage();

  // Add client for connection reuse
  final http.Client _client = http.Client();

  @override
  void onInit() {
    super.onInit();
    final args = Get.arguments;
    if (args is Map<String, dynamic> && args.containsKey('id')) {
      recipeId = args['id'];

      // Use separate API endpoint for single recipe instead of fetching all recipes
      getRecipeDetails();

      // Load comments and check if liked in parallel
      Future.wait([
        getComments(),
        checkIfLiked(),
      ]);
    } else {
      Future.delayed(Duration.zero, () {
        Get.snackbar(
          'Error',
          'No recipe ID provided',
          snackPosition: SnackPosition.BOTTOM,
        );
        Get.back();
      });
    }
  }

  @override
  void onClose() {
    commentController.dispose();
    _client.close(); // Close HTTP client to prevent resource leaks
    super.onClose();
  }

  Future<void> getRecipeDetails() async {
    isLoading.value = true;
    try {
      // Use specific endpoint for single recipe instead of fetching all recipes
      final response =
          await _client.get(Uri.parse('$baseUrl/recipes/$recipeId'));

      if (response.statusCode == 200) {
        final responseData = jsonDecode(response.body);
        recipe.value = RecipeModel.fromJson(responseData['data']);
      } else {
        throw Exception('Failed to load recipe data: ${response.statusCode}');
      }
    } catch (e) {
      print('Error fetching recipe details: $e');
      Get.snackbar(
        'Error',
        'Failed to load recipe. Please try again.',
        snackPosition: SnackPosition.BOTTOM,
        duration: const Duration(seconds: 3),
      );
    } finally {
      isLoading.value = false;
    }
  }

  Future<void> getComments() async {
    isCommentsLoading.value = true;
    try {
      final response =
          await _client.get(Uri.parse('$baseUrl/recipes/$recipeId/comments'));

      if (response.statusCode == 200) {
        final responseData = jsonDecode(response.body);
        final commentsData =
            List<Map<String, dynamic>>.from(responseData['data']);
        comments.value =
            commentsData.map((c) => CommentModel.fromJson(c)).toList();
      } else {
        throw Exception('Failed to load comments: ${response.statusCode}');
      }
    } catch (e) {
      print('Error fetching comments: $e');
      // Don't show error to user as comments are not critical
    } finally {
      isCommentsLoading.value = false;
    }
  }

  Future<void> checkIfLiked() async {
    try {
      final token = box.read('token');

      if (token != null) {
        // Add specific endpoint to check if this recipe is liked instead of getting all liked recipes
        final response = await _client.get(
          Uri.parse('$baseUrl/recipes/$recipeId/check-like'),
          headers: {'Authorization': 'Bearer $token'},
        );

        print('Check Like Response: ${response.body}');

        if (response.statusCode == 200) {
          final responseData = jsonDecode(response.body);
          isLiked.value = responseData['is_liked'] ?? false;
        } else if (response.statusCode == 404) {
          // Recipe not liked
          isLiked.value = false;
        }
      }
    } catch (e) {
      print('Error checking if recipe is liked: $e');
      // Not critical, so no need to show error to user
    }
  }

  Future<void> toggleLike() async {
    try {
      final token = box.read('token');

      if (token == null) {
        Get.toNamed('/login');
        return;
      }

      if (isLiked.value) {
        // Unlike
        final response = await _client.delete(
          Uri.parse('$baseUrl/recipes/$recipeId/unlike'),
          headers: {'Authorization': 'Bearer $token'},
        );

        if (response.statusCode == 200 && recipe.value != null) {
          recipe.value!.favoritesCount--;
          recipe.refresh();
        }
      } else {
        // Like
        final response = await _client.post(
          Uri.parse('$baseUrl/recipes/$recipeId/like'),
          headers: {'Authorization': 'Bearer $token'},
        );

        if (response.statusCode == 200 && recipe.value != null) {
          recipe.value!.favoritesCount++;
          recipe.refresh();
        }
      }

      // After successful toggle, update the `isLiked` value
      isLiked.toggle();
    } catch (e) {
      print('Error toggling like: $e');
      Get.snackbar(
        'Error',
        'Failed to ${isLiked.value ? 'unlike' : 'like'} recipe',
        snackPosition: SnackPosition.BOTTOM,
      );
    }
  }

  Future<void> addComment() async {
    if (commentController.text.trim().isEmpty) return;

    isSendingComment.value = true;
    try {
      final token = box.read('token');

      if (token == null) {
        Get.toNamed('/login');
        return;
      }

      final response = await _client.post(
        Uri.parse('$baseUrl/recipes/$recipeId/comments'),
        body: {'comment': commentController.text},
        headers: {
          'Authorization': 'Bearer $token',
          'Content-Type': 'application/x-www-form-urlencoded'
        },
      );

      if (response.statusCode == 200 || response.statusCode == 201) {
        final responseData = jsonDecode(response.body);

        // Clear the input field first
        commentController.clear();

        // Instead of just adding the comment, refresh all comments to ensure user images are loaded
        await getComments();
      } else {
        throw Exception('Failed to add comment: ${response.statusCode}');
      }
    } catch (e) {
      print('Error adding comment: $e');
      Get.snackbar(
        'Error',
        'Failed to add comment. Please try again.',
        snackPosition: SnackPosition.BOTTOM,
      );
    } finally {
      isSendingComment.value = false;
    }
  }

  List<String> getIngredientsList() {
    if (recipe.value == null) return [];
    return recipe.value!.ingredients
        .split('\n')
        .where((line) => line.trim().isNotEmpty)
        .toList();
  }

  List<String> getCookingStepsList() {
    if (recipe.value == null) return [];
    return recipe.value!.instructions
        .split('\n')
        .where((line) => line.trim().isNotEmpty)
        .toList();
  }

  String formatCookingTime(int minutes) {
    if (minutes < 60) {
      return '$minutes Minutes';
    } else {
      final hours = minutes ~/ 60;
      final remainingMinutes = minutes % 60;
      if (remainingMinutes == 0) {
        return '$hours ${hours == 1 ? 'Hour' : 'Hours'}';
      } else {
        return '$hours ${hours == 1 ? 'Hour' : 'Hours'} $remainingMinutes Minutes';
      }
    }
  }

  String formatPrice(int price) {
    final formatted = price
        .toStringAsFixed(0)
        .replaceAllMapped(RegExp(r'\B(?=(\d{3})+(?!\d))'), (match) => ',');
    return 'IDR $formatted';
  }
}
