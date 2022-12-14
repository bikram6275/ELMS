import 'package:elms/constant/app_colors.dart';
import 'package:elms/utils/custom_text/custom_text.dart';
import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'package:get/get.dart';

class CustomFormField extends StatefulWidget {
  const CustomFormField({
    Key? key,
    this.editController,
    this.textInputType,
    this.onChanged,
    this.validatorsType,
    this.hint,
    this.justNumber,
    this.isRating,
    this.maxLength,
    this.isPasswordField = false,
    this.formatter,
  }) : super(key: key);

  final TextEditingController? editController;
  final TextInputType? textInputType;
  final ValueChanged<String>? onChanged;
  final String? validatorsType, hint;
  final bool? justNumber, isRating;
  final int? maxLength;
  final bool isPasswordField;
  final List<TextInputFormatter>? formatter;

  @override
  _CustomFormFieldState createState() => _CustomFormFieldState();
}

class _CustomFormFieldState extends State<CustomFormField> {
  final AppColors _colors = Get.find();

  bool obscure = true;

  @override
  Widget build(BuildContext context) {
    return TextFormField(
      autovalidateMode: AutovalidateMode.onUserInteraction,
      autofocus: false,
      controller: widget.editController,
      obscureText: obscure && widget.isPasswordField,
      maxLength: widget.maxLength,
      decoration: InputDecoration(
          suffixIcon: widget.isPasswordField
              ? GestureDetector(
                  onTap: () {
                    obscure = !obscure;
                    setState(() {});
                  },
                  child: Icon(
                    obscure ? Icons.visibility_off : Icons.visibility,
                    color: _colors.primaryColor,
                  ),
                )
              : null,
          focusedBorder: OutlineInputBorder(
            borderSide: BorderSide(color: _colors.buttonColor, width: 1.0),
          ),
          enabledBorder: OutlineInputBorder(
            borderSide: BorderSide(color: _colors.buttonColor, width: 1.0),
          ),
          errorBorder: OutlineInputBorder(
            borderSide: BorderSide(color: _colors.buttonColor, width: 1.0),
          ),
          focusedErrorBorder: OutlineInputBorder(
            borderSide: BorderSide(color: _colors.buttonColor, width: 1.0),
          ),
          label: CustomText(
            widget.hint ?? "",
            textAlign: TextAlign.left,
            colorOption: TextColorOptions.hint,
            sizeOption: TextSizeOptions.caption,
          )),
      onChanged: (value) {
        if (widget.onChanged != null) {
          widget.onChanged!(value);
        }
      },
      inputFormatters: (widget.formatter != null)
          ? widget.formatter
          : (widget.justNumber == true)
              ? <TextInputFormatter>[
                  FilteringTextInputFormatter.allow(RegExp(r'[0-9]')),
                ]
              : (widget.isRating == true)
                  ? <TextInputFormatter>[
                      FilteringTextInputFormatter.allow(RegExp(r'[1-5]')),
                    ]
                  : null,
      validator: (value) {
        if (widget.validatorsType == "email") {
          if (!GetUtils.isEmail(value!)) {
            return "Email is not valid";
          } else {
            return null;
          }
        } else if (widget.validatorsType == "length") {
          if (value!.length < 6) {
            return "Minimum size 6 character";
          } else {
            return null;
          }
        }
      },
      cursorColor: _colors.primaryColor,
      keyboardType: widget.textInputType,
    );
  }
}
