import 'package:flutter/material.dart';
import 'package:get/get.dart';

snackBar(title, message, {required error}) => Get.snackbar(
      title,
      message,
      backgroundColor: error ? Colors.red.shade400 : null,
      colorText: error ? Colors.white : null,
    );
