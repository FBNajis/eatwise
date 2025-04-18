import 'package:get/get.dart';
import '../controllers/recipebasedonrecommendation_controller.dart';

class RecipebasedonrecommendationBinding extends Bindings {
  @override
  void dependencies() {
    Get.lazyPut<RecipebasedonrecommendationController>(
      () => RecipebasedonrecommendationController(),
    );
  }
}
