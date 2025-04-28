import 'package:get/get.dart';

import '../controllers/detailrecipe_controller.dart';

class DetailrecipeBinding extends Bindings {
  @override
  void dependencies() {
    Get.lazyPut<DetailrecipeController>(
      () => DetailrecipeController(),
    );
  }
}
