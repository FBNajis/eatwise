import 'package:get/get.dart';

import '../controllers/emailforgotpassword_controller.dart';

class EmailforgotpasswordBinding extends Bindings {
  @override
  void dependencies() {
    Get.lazyPut<EmailforgotpasswordController>(
      () => EmailforgotpasswordController(),
    );
  }
}
