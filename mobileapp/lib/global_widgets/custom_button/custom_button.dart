import 'package:elms/constant/app_dimens.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';

class CustomButton extends StatelessWidget {
  CustomButton({
    Key? key,
    required this.child,
    required this.color,
    required this.onPressed,
    this.elevation,
    this.height,
    this.width,
    this.radius,
  }) : super(key: key);

  final Widget child;
  final Color color;
  final VoidCallback onPressed;
  final double? elevation, height, width, radius;

  final AppDimens dimens = Get.find();

  @override
  Widget build(BuildContext context) {
    return SizedBox(
      width: width,
      height: height,
      child: ElevatedButton(
        onPressed: onPressed,
        child: child,
        style: ElevatedButton.styleFrom(
          primary: color,
          shape: RoundedRectangleBorder(
            borderRadius: BorderRadius.circular(radius ?? dimens.borderRadius),
          ),
          elevation: elevation,
        ),
      ),
    );
  }
}
