import 'dart:convert';
import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:get_storage/get_storage.dart';
import 'package:http/http.dart' as http;

class HomeController extends GetxController {
  final storage = GetStorage();
  final username = ''.obs;
  final isLoading = false.obs;

  final allRecipes = <dynamic>[].obs;
  final topLikedRecipes = <dynamic>[].obs;
  final filteredRecipes = <dynamic>[].obs;

  final searchController = TextEditingController();

  final String baseUrl = 'http://192.168.27.30:8000/api';

  @override
  void onInit() {
    super.onInit();
    fetchUsername();
    fetchAllRecipes();
    fetchTopLikedRecipes();
  }

  Future<void> refreshData() async {
    isLoading(true);
    try {
      fetchUsername();
      await fetchAllRecipes(); // tunggu dulu sampai selesai

      // filter berdasarkan keyword
      final currentKeyword = searchController.text.trim();
      if (currentKeyword.isNotEmpty) {
        searchRecipes(currentKeyword);
      } else {
        filteredRecipes.assignAll(allRecipes);
      }

      fetchTopLikedRecipes(); // ini tidak harus ditunggu
    } finally {
      isLoading(false);
    }
  }

  void fetchUsername() {
    username.value = storage.read('username') ?? 'User';
    print("Fetched Username: ${username.value}"); // Debug log
  }

  // Fetch all recipes with error handling and authentication token
  Future<void> fetchAllRecipes() async {
    try {
      final token = storage.read('token');
      final response = await http.get(
        Uri.parse('$baseUrl/recipes/all'),
        headers: {
          'Accept': 'application/json',
          'Authorization': 'Bearer $token',
        },
      );

      if (response.statusCode == 200) {
        final responseData = json.decode(response.body);
        final data = responseData['data'];
        allRecipes.assignAll(data);

        final keyword = searchController.text.trim();
        if (keyword.isNotEmpty) {
          searchRecipes(keyword);
        } else {
          filteredRecipes.assignAll(data);
        }
      } else {
        print('Gagal mengambil semua resep: ${response.body}');
        Get.snackbar("Error", "Gagal mengambil resep",
            snackPosition: SnackPosition.TOP);
      }
    } catch (e) {
      print('Error fetchAllRecipes: $e');
    }
  }

  void fetchTopLikedRecipes() async {
    try {
      isLoading(true);
      final token = storage.read('token');
      final response = await http.get(
        Uri.parse('$baseUrl/recipes/top?limit=2'),
        headers: {
          'Accept': 'application/json',
          'Authorization': 'Bearer $token',
        },
      );

      if (response.statusCode == 200) {
        final responseData = json.decode(response.body);
        final data = responseData['data'];

        print('Top Recipes Data: $data');

        if (data.isEmpty) {
          fetchRandomRecipes(); // fallback if empty
        } else {
          topLikedRecipes.assignAll(data);
        }
      } else {
        print('Gagal mengambil resep teratas: ${response.body}');
        Get.snackbar("Error", "Gagal mengambil resep teratas",
            snackPosition: SnackPosition.TOP);
      }
    } catch (e) {
      print('Error fetchTopLikedRecipes: $e');
    } finally {
      isLoading(false);
    }
  }

  // Fetch random recipes with error handling and authentication token
  void fetchRandomRecipes() async {
    try {
      final token = storage.read('token');
      final response = await http.get(
        Uri.parse('$baseUrl/recipes/random'),
        headers: {
          'Accept': 'application/json',
          'Authorization': 'Bearer $token', // Adding token for authentication
        },
      );

      if (response.statusCode == 200) {
        final responseData = json.decode(response.body);
        final data = responseData['data'];
        if (data.isNotEmpty) {
          topLikedRecipes.assignAll(data.take(2).toList());
        }
      } else {
        print('Gagal mengambil resep acak: ${response.body}');
        Get.snackbar("Error", "Gagal mengambil resep acak",
            snackPosition: SnackPosition.BOTTOM);
      }
    } catch (e) {
      print('Error fetchRandomRecipes: $e');
      Get.snackbar("Error", "Terjadi masalah saat menghubungi server",
          snackPosition: SnackPosition.BOTTOM);
    }
  }

  // Search function for filtering recipes
  void searchRecipes(String query) {
    if (query.isEmpty) {
      filteredRecipes.assignAll(allRecipes);
    } else {
      filteredRecipes.assignAll(
        allRecipes.where((recipe) {
          final name = recipe['name'].toString().toLowerCase();
          return name.contains(query.toLowerCase());
        }).toList(),
      );
    }
  }
}
