import 'package:get/get.dart';

import '../controllers/editdeleterecipe_controller.dart';

class EditdeleterecipeBinding extends Bindings {
  @override
  void dependencies() {
    Get.lazyPut<EditdeleterecipeController>(
      () => EditdeleterecipeController(),
    );
  }
}
