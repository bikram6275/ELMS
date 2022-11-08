import 'package:elms/models/answer/drop_down_model.dart';
import 'package:flutter/material.dart';
import 'package:flutter_dropdown/flutter_dropdown.dart';

class CustomDropDown extends StatefulWidget {
  const CustomDropDown(
      {Key? key, required this.list, required this.onChange, this.hint})
      : super(key: key);

  final List<DropDownModel> list;
  final ValueChanged<DropDownModel> onChange;
  final String? hint;

  @override
  _CustomDropDownState createState() => _CustomDropDownState();
}

class _CustomDropDownState extends State<CustomDropDown> {
  DropDownModel? selectedItem;

  @override
  void initState() {
    super.initState();
  }

  Text buildDropDownRow(DropDownModel item) {
    return Text(item.name);
  }

  @override
  Widget build(BuildContext context) {
    return DropDown<DropDownModel>(
      items: widget.list,
      customWidgets:
          widget.list.map<Widget>((p) => buildDropDownRow(p)).toList(),
      initialValue: selectedItem,
      isExpanded: true,
      hint: Text(widget.hint ?? "Please select"),
      onChanged: (value) {
        setState(() {});
        selectedItem = value!;
        widget.onChange(value);
      },
    );
  }
}
