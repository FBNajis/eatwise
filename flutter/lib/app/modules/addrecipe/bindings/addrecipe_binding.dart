import 'package:get/get.dart';

import '../controllers/addrecipe_controller.dart';

class AddrecipeBinding extends Bindings {
  @override
  void dependencies() {
    Get.lazyPut<AddrecipeController>(
      () => AddrecipeController(),
    );
  }
}
