import 'package:flutter/material.dart';
import 'package:get/get.dart';

import 'app_colors.dart';

class AppTheme {
  static final AppColors colors = Get.find();

  final theme = ThemeData(
    brightness: Brightness.light,
    primaryColor: colors.primaryColor,
    appBarTheme: AppBarTheme(
      backgroundColor: colors.primaryColor,
    ),
    scaffoldBackgroundColor: colors.scaffoldBackgroundColor,
  );
}
