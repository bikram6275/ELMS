import 'package:equatable/equatable.dart';

class DropDownModel extends Equatable {
  final String name;
  final int id;

  const DropDownModel(this.name, this.id);

  @override
  List<Object?> get props => [name, id];
}
