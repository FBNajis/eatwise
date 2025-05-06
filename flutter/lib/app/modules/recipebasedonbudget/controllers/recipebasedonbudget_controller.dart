import 'dart:convert';
import 'package:get/get.dart';
import 'package:get_storage/get_storage.dart';
import 'package:http/http.dart' as http;

class RecipebasedonbudgetController extends GetxController {
  final recipesByBudget = <dynamic>[].obs;
  final isLoading = false.obs;
  final budget = ''.obs;
  final String baseUrl = 'http://192.168.27.30:8000/api';

  @override
  void onInit() {
    super.onInit();
    final bud = Get.arguments as String;
    budget.value = bud;
    fetchRecipesByBudget(bud);
  }

  void fetchRecipesByBudget(String budget) async {
    try {
      isLoading(true);
      final token = GetStorage().read('token');

      final response = await http.get(
        Uri.parse('$baseUrl/recipes/budget?budget=$budget'),
        headers: {
          'Accept': 'application/json',
          'Authorization': 'Bearer $token',
        },
      );

      if (response.statusCode == 200) {
        final responseData = json.decode(response.body);
        final data = responseData['data'];

        // Assign data ke observable
        recipesByBudget.assignAll(data);
      } else {
        Get.snackbar("Error", "Gagal mengambil resep berdasarkan budget",
            snackPosition: SnackPosition.TOP);
      }
    } catch (e) {
      print('Error fetchRecipesByBudget: $e');
      Get.snackbar("Error", "Terjadi masalah saat menghubungi server",
          snackPosition: SnackPosition.TOP);
    } finally {
      isLoading(false);
    }
  }
}
