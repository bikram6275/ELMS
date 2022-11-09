part of 'answer_hive_object.dart';

class AnswerHiveObjectAdapter extends TypeAdapter<AnswerHiveObject> {
  @override
  final int typeId = 0;

  @override
  AnswerHiveObject read(BinaryReader reader) {
    final numOfFields = reader.readByte();
    final fields = <int, dynamic>{
      for (int i = 0; i < numOfFields; i++) reader.readByte(): reader.read(),
    };
    return AnswerHiveObject()
      ..questionId = fields[0] as int?
      ..fieldValue = fields[1] as String?
      ..questionType = fields[2] as String?
      ..extraData = (fields[3] as Map?)?.cast<String, dynamic>();
  }

  @override
  void write(BinaryWriter writer, AnswerHiveObject obj) {
    writer
      ..writeByte(4)
      ..writeByte(0)
      ..write(obj.questionId)
      ..writeByte(1)
      ..write(obj.fieldValue)
      ..writeByte(2)
      ..write(obj.questionType)
      ..writeByte(3)
      ..write(obj.extraData);
  }

  @override
  int get hashCode => typeId.hashCode;

  @override
  bool operator ==(Object other) =>
      identical(this, other) ||
      other is AnswerHiveObjectAdapter &&
          runtimeType == other.runtimeType &&
          typeId == other.typeId;
}
