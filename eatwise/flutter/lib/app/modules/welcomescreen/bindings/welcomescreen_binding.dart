import 'package:get/get.dart';

import '../controllers/welcomescreen_controller.dart';

class WelcomescreenBinding extends Bindings {
  @override
  void dependencies() {
    Get.lazyPut<WelcomescreenController>(
      () => WelcomescreenController(),
    );
  }
}
