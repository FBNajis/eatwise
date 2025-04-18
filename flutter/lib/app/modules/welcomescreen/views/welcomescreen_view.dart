import 'package:flutter/material.dart';

import 'package:get/get.dart';

import '../controllers/welcomescreen_controller.dart';

class WelcomescreenView extends GetView<WelcomescreenController> {
  const WelcomescreenView({super.key});
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('WelcomescreenView'),
        centerTitle: true,
      ),
      body: const Center(
        child: Text(
          'WelcomescreenView is working',
          style: TextStyle(fontSize: 20),
        ),
      ),
    );
  }
}
