import 'package:flutter/material.dart';

import 'package:get/get.dart';
import 'package:get_storage/get_storage.dart';
import 'app/routes/app_pages.dart';
import 'package:flutter_dotenv/flutter_dotenv.dart';

void main() async {
  await GetStorage.init();
  await dotenv.load();
  runApp(
    GetMaterialApp(
      title: "eatwise",
      initialRoute: AppPages.INITIAL,
      getPages: AppPages.routes,
    ),
  );
}
