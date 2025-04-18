import 'dart:convert';
import 'package:get/get.dart';
import 'package:get_storage/get_storage.dart';
import 'package:http/http.dart' as http;

class RecipebasedonlikesController extends GetxController {
  final recipesByLiked = <dynamic>[].obs;
  final isLoading = false.obs;
  final String baseUrl = 'http://10.0.2.2:8000/api';

  @override
  void onInit() {
    super.onInit();
    fetchRecipesByLikes();
  }

  void fetchRecipesByLikes() async {
    try {
      isLoading(true);
      final token = GetStorage().read('token');

      final response = await http.get(
        Uri.parse('$baseUrl/recipes/liked'),
        headers: {
          'Accept': 'application/json',
          'Authorization': 'Bearer $token',
        },
      );

      if (response.statusCode == 200) {
        final responseData = json.decode(response.body);
        final data = responseData['data'];

        // Assign data ke observable
        recipesByLiked.assignAll(data);
      } else {
        Get.snackbar("Error", "Gagal mengambil resep berdasarkan likes",
            snackPosition: SnackPosition.TOP);
      }
    } catch (e) {
      print('Error fetchRecipesByLikes: $e');
      Get.snackbar("Error", "Terjadi masalah saat menghubungi server",
          snackPosition: SnackPosition.TOP);
    } finally {
      isLoading(false);
    }
  }
}
