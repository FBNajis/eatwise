import 'package:get/get.dart';

import '../controllers/otpforgotpassword_controller.dart';

class OtpforgotpasswordBinding extends Bindings {
  @override
  void dependencies() {
    Get.lazyPut<OtpforgotpasswordController>(
      () => OtpforgotpasswordController(),
    );
  }
}
