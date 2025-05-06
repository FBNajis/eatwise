import 'dart:convert';
import 'dart:io';
import 'package:flutter/widgets.dart';
import 'package:get/get.dart';
import 'package:get_storage/get_storage.dart';
import 'package:http/http.dart' as http;

class RecipeController extends GetxController with WidgetsBindingObserver {
  final box = GetStorage();
  final groupedRecipes = {}.obs;
  final isLoading = false.obs;
  final searchQuery = ''.obs;

  @override
  void onInit() {
    super.onInit();
    WidgetsBinding.instance.addObserver(this);
    fetchUserRecipes(); // initial fetch
  }

  @override
  void onClose() {
    WidgetsBinding.instance.removeObserver(this);
    super.onClose();
  }

  @override
  void didChangeAppLifecycleState(AppLifecycleState state) {
    if (state == AppLifecycleState.resumed) {
      fetchUserRecipes(); // refresh when coming back from background
    }
  }

  Future<void> fetchUserRecipes() async {
    try {
      isLoading(true);
      final token = box.read('token');
      print('TOKEN = $token');

      // Add timeout to prevent long waiting times
      final response = await http.get(
        Uri.parse('http://192.168.27.30:8000/api/user/recipes'),
        headers: {
          'Authorization': 'Bearer $token',
          'Accept': 'application/json',
        },
      ).timeout(
        const Duration(seconds: 10),
        onTimeout: () {
          return http.Response(
              '{"data":{}}', 200); // Return an empty response on timeout
        },
      );

      if (response.statusCode == 200) {
        final body = json.decode(response.body);
        final data = body['data'] as Map<String, dynamic>;
        groupedRecipes.assignAll(data);
      } else {
        // Handle errors for other status codes
        Get.snackbar('Error', 'Failed to fetch recipes');
      }
    } catch (e) {
      // Handle SocketException or HttpException for connection issues
      if (!(e is SocketException || e is HttpException)) {
        print('Recipe fetch error: ${e.toString()}');
      }
    } finally {
      isLoading(false);
    }
  }

  List<Map<String, dynamic>> getFilteredRecipes(String dateKey) {
    final list = groupedRecipes[dateKey];
    if (list == null) return [];

    if (searchQuery.value.isEmpty) {
      return List<Map<String, dynamic>>.from(list);
    }

    return List<Map<String, dynamic>>.from(list).where((recipe) {
      return recipe['name']
          .toString()
          .toLowerCase()
          .contains(searchQuery.value.toLowerCase());
    }).toList();
  }

  String formatCost(dynamic cost) {
    if (cost is num) {
      return cost
          .toStringAsFixed(0)
          .replaceAllMapped(RegExp(r'\B(?=(\d{3})+(?!\d))'), (match) => '.');
    }
    return cost.toString();
  }

  void setSearchQuery(String query) {
    searchQuery.value = query;
  }
}
