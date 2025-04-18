import 'package:get/get.dart';

import '../controllers/recipebasedonbudget_controller.dart';

class RecipebasedonbudgetBinding extends Bindings {
  @override
  void dependencies() {
    Get.lazyPut<RecipebasedonbudgetController>(
      () => RecipebasedonbudgetController(),
    );
  }
}
