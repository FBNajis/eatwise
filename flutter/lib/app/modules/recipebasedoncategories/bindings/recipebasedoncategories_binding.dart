import 'package:get/get.dart';

import '../controllers/recipebasedoncategories_controller.dart';

class RecipebasedoncategoriesBinding extends Bindings {
  @override
  void dependencies() {
    Get.lazyPut<RecipebasedoncategoriesController>(
      () => RecipebasedoncategoriesController(),
    );
  }
}
