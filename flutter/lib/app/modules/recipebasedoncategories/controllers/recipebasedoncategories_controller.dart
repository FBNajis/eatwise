import 'dart:convert';
import 'package:get/get.dart';
import 'package:get_storage/get_storage.dart';
import 'package:http/http.dart' as http;

class RecipebasedoncategoriesController extends GetxController {
  final recipesByCategories = <dynamic>[].obs;
  final isLoading = false.obs;
  final category = ''.obs;
  final String baseUrl = 'http://192.168.27.30:8000/api';

  @override
  void onInit() {
    super.onInit();
    final cat = Get.arguments as String;
    category.value = cat;
    fetchRecipesByCategories(cat);
  }

  Future<void> refreshData() async {
    isLoading(true);
    try {
      fetchRecipesByCategories(category.value);
    } finally {
      isLoading(false);
    }
  }

  void fetchRecipesByCategories(String category) async {
    try {
      isLoading(true);
      final token = GetStorage().read('token');

      final response = await http.get(
        Uri.parse('$baseUrl/recipes/category?category=$category'),
        headers: {
          'Accept': 'application/json',
          'Authorization': 'Bearer $token',
        },
      );

      if (response.statusCode == 200) {
        final responseData = json.decode(response.body);
        final data = responseData['data'];

        // Assign data ke observable
        recipesByCategories.assignAll(data);
      } else {
        Get.snackbar("Error", "Gagal mengambil resep berdasarkan kategori",
            snackPosition: SnackPosition.TOP);
      }
    } catch (e) {
      print('Error fetchRecipesByCategories: $e');
      Get.snackbar("Error", "Terjadi masalah saat menghubungi server",
          snackPosition: SnackPosition.TOP);
    } finally {
      isLoading(false);
    }
  }
}
