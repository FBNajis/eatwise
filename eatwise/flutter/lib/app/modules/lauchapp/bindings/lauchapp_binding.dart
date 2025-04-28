import 'package:get/get.dart';

import '../controllers/lauchapp_controller.dart';

class LauchappBinding extends Bindings {
  @override
  void dependencies() {
    Get.lazyPut<LauchappController>(
      () => LauchappController(),
    );
  }
}
