import 'package:hive/hive.dart';

part 'answer_hive_object.g.dart';

@HiveType(typeId: 0)
class AnswerHiveObject extends HiveObject {
  @HiveField(0)
  int? questionId;

  @HiveField(1)
  String? fieldValue;

  @HiveField(2)
  String? questionType;

  @HiveField(3)
  Map<String, dynamic>? extraData;
}
