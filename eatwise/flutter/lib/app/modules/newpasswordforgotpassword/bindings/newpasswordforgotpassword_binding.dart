import 'package:get/get.dart';

import '../controllers/newpasswordforgotpassword_controller.dart';

class NewpasswordforgotpasswordBinding extends Bindings {
  @override
  void dependencies() {
    Get.lazyPut<NewpasswordforgotpasswordController>(
      () => NewpasswordforgotpasswordController(),
    );
  }
}
