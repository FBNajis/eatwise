import 'package:get/get.dart';

import '../controllers/loginorsignup_controller.dart';

class LoginorsignupBinding extends Bindings {
  @override
  void dependencies() {
    Get.lazyPut<LoginorsignupController>(
      () => LoginorsignupController(),
    );
  }
}
