import 'dart:convert';
import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:get_storage/get_storage.dart';
import 'package:http/http.dart' as http;

class HomeController extends GetxController {
  final storage = GetStorage();

  final username = ''.obs;
  final email = ''.obs;
  final isLoading = false.obs;

  final allRecipes = <dynamic>[].obs;
  final topLikedRecipes = <dynamic>[].obs;
  final filteredRecipes = <dynamic>[].obs;

  final searchController = TextEditingController();
  final String baseUrl = 'http://10.0.2.2:8000/api';

  bool _usernameFetched = false;
  final isUsernameReady = false.obs;

  @override
  void onInit() {
    super.onInit();

    // Ambil email dari argument (hanya email yang dikirim)
    final argumentEmail = Get.arguments;
    print("Email from arguments: $argumentEmail");

    if (argumentEmail != null && argumentEmail is String) {
      email.value = argumentEmail;
      fetchUserData(email.value);
    } else {
      fetchUsername(); // fallback dari GetStorage
    }

    fetchAllRecipes();
    fetchTopLikedRecipes();
  }

  /// Digunakan saat login untuk menyet username langsung dan menyimpan ke storage
  void setUsernameDirectly(String name) {
    username.value = name;
    _usernameFetched = true;
    storage.write('username', name);
  }

  /// Ambil user data berdasarkan email, simpan username ke storage
  void fetchUserData(String email) async {
    try {
      final response = await http.get(
        Uri.parse('$baseUrl/user?email=$email'),
        headers: {'Accept': 'application/json'},
      );

      if (response.statusCode == 200) {
        final data = jsonDecode(response.body);
        final fetchedUsername = data['user']['username'] ?? 'User';
        username.value = fetchedUsername;
        _usernameFetched = true;
        storage.write('username', fetchedUsername);
      } else {
        fetchUsername(); // fallback
      }
    } catch (e) {
      fetchUsername(); // fallback
    } finally {
      isUsernameReady.value = true; // ✅ tandai username sudah siap
    }
  }

  /// Ambil username dari local storage
  Future<void> fetchUsername() async {
    await GetStorage().initStorage;
    final storedUsername = storage.read('username');
    username.value = storedUsername ?? 'User';
    _usernameFetched = true;
    isUsernameReady.value = true; // ✅ tandai username sudah siap
  }

  /// Refresh semua data (biasanya saat tarik untuk refresh)
  Future<void> refreshData() async {
    isLoading(true);
    try {
      if (email.value.isEmpty) {
        await fetchUsername();
      }
      await fetchAllRecipes();

      final currentKeyword = searchController.text.trim();
      if (currentKeyword.isNotEmpty) {
        searchRecipes(currentKeyword);
      } else {
        filteredRecipes.assignAll(allRecipes);
      }

      fetchTopLikedRecipes();
    } finally {
      isLoading(false);
    }
  }

  /// Ambil semua resep
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
        final data = json.decode(response.body)['data'];
        allRecipes.assignAll(data);

        final keyword = searchController.text.trim();
        if (keyword.isNotEmpty) {
          searchRecipes(keyword);
        } else {
          filteredRecipes.assignAll(data);
        }
      } else {
        print('Gagal mengambil semua resep: ${response.body}');
        Get.snackbar("Error", "Gagal mengambil resep");
      }
    } catch (e) {
      print('Error fetchAllRecipes: $e');
    }
  }

  /// Ambil dua resep dengan like terbanyak
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
        final data = json.decode(response.body)['data'];
        if (data.isEmpty) {
          fetchRandomRecipes(); // fallback jika kosong
        } else {
          topLikedRecipes.assignAll(data);
        }
      } else {
        print('Gagal mengambil resep teratas: ${response.body}');
        Get.snackbar("Error", "Gagal mengambil resep teratas");
      }
    } catch (e) {
      print('Error fetchTopLikedRecipes: $e');
    } finally {
      isLoading(false);
    }
  }

  /// Ambil resep acak sebagai fallback dari top-liked
  void fetchRandomRecipes() async {
    try {
      final token = storage.read('token');
      final response = await http.get(
        Uri.parse('$baseUrl/recipes/random'),
        headers: {
          'Accept': 'application/json',
          'Authorization': 'Bearer $token',
        },
      );

      if (response.statusCode == 200) {
        final data = json.decode(response.body)['data'];
        if (data.isNotEmpty) {
          topLikedRecipes.assignAll(data.take(2).toList());
        }
      } else {
        print('Gagal mengambil resep acak: ${response.body}');
        Get.snackbar("Error", "Gagal mengambil resep acak");
      }
    } catch (e) {
      print('Error fetchRandomRecipes: $e');
    }
  }

  /// Filter resep berdasarkan keyword
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
