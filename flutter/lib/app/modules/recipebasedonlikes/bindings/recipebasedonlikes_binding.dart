import 'package:get/get.dart';

import '../controllers/recipebasedonlikes_controller.dart';

class RecipebasedonlikesBinding extends Bindings {
  @override
  void dependencies() {
    Get.lazyPut<RecipebasedonlikesController>(
      () => RecipebasedonlikesController(),
    );
  }
}
