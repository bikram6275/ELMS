import 'package:elms/constant/app_colors.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';

customDivider({color}) => Divider(
      color: color ?? Get.find<AppColors>().primaryColor,
    );
