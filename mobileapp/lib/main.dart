// ignore_for_file: unrelated_type_equality_checks

import 'package:elms/infrastructure/dependency_injection/dependency_injection.dart';
import 'package:elms/infrastructure/global_controller/global_controller.dart';
import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'package:get/get.dart';
import 'package:get_storage/get_storage.dart';

import 'constant/app_pages.dart';
import 'constant/app_routes.dart';
import 'constant/app_strings.dart';
import 'constant/app_theme.dart';

void main() async {
  WidgetsFlutterBinding.ensureInitialized();
  await SystemChrome.setPreferredOrientations(
      [DeviceOrientation.portraitUp, DeviceOrientation.portraitDown]);

  await GetStorage.init();
  await DependencyInjection.injectDependencies();

  AppStrings _strings = Get.find();
  AppRoutes _routes = Get.find();
  AppPages _pages = Get.find();
  AppTheme _theme = Get.find();
  GlobalController _globalController = Get.find();

  runApp(
    Obx(
      () => GetMaterialApp(
        debugShowCheckedModeBanner: false,
        builder: (context, child) => MediaQuery(
          data: MediaQuery.of(context).copyWith(textScaleFactor: 1.0),
          child: child!,
        ),
        title: _strings.appTitle,
        initialRoute: (_globalController.authState == Auth.authenticated)
            ? _routes.dashboard
            : _routes.login,
        getPages: _pages.pages,
        defaultTransition: Transition.fadeIn,
        theme: _theme.theme,
      ),
    ),
  );
}
