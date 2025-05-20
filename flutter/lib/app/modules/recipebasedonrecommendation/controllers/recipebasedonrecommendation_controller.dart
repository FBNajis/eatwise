import 'dart:convert';
import 'package:get/get.dart';
import 'package:get_storage/get_storage.dart';
import 'package:http/http.dart' as http;

class RecipebasedonrecommendationController extends GetxController {
  final topRecommendedRecipes = <dynamic>[].obs;
  final isLoading = false.obs;
  final String baseUrl = 'http://192.168.27.30:8000/api';

  void fetchTopRecommendedRecipes() async {
    try {
      isLoading(true);
      final token = GetStorage().read('token');

      final response = await http.get(
        Uri.parse('$baseUrl/recipes/top'),
        headers: {
          'Accept': 'application/json',
          'Authorization': 'Bearer $token',
        },
      );

      if (response.statusCode == 200) {
        final responseData = json.decode(response.body);
        final data = responseData['data'];

        // Assign data ke observable
        topRecommendedRecipes.assignAll(data);
      } else {
        Get.snackbar("Error", "Gagal mengambil resep teratas",
            snackPosition: SnackPosition.TOP);
      }
    } catch (e) {
      print('Error fetchTopRecommendedRecipes: $e');
      Get.snackbar("Error", "Terjadi masalah saat menghubungi server",
          snackPosition: SnackPosition.TOP);
    } finally {
      isLoading(false);
    }
  }

  Future<void> refreshData() async {
    isLoading(true);
    try {
      fetchTopRecommendedRecipes();
    } finally {
      isLoading(false);
    }
  }
}
