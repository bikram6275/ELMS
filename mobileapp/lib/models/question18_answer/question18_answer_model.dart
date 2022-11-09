import 'dart:convert';

Question18AnswerModel question18AnswerModelFromJson(String str) =>
    Question18AnswerModel.fromJson(json.decode(str));

String question18AnswerModelToJson(Question18AnswerModel data) =>
    json.encode(data.toJson());

class Question18AnswerModel {
  Question18AnswerModel({
    required this.id,
    required this.sectorId,
    required this.occupationId,
    required this.level,
    required this.requiredNumber,
    required this.incorporatePossible,
    required this.otherOccupationValue,
  });

  final int? id;
  final int sectorId;
  final int occupationId;
  final String level;
  final String requiredNumber;
  final String incorporatePossible;
  final String? otherOccupationValue;

  factory Question18AnswerModel.fromJson(json) => Question18AnswerModel(
        id: json["id"],
        sectorId: json["sector_id"],
        occupationId: json["occupation_id"],
        level: json["level"],
        requiredNumber: json["required_number"].toString(),
        incorporatePossible: json["incorporate_possible"],
        otherOccupationValue: json["other_occupation_value"],
      );

  Map<String, dynamic> toJson() => {
        "id": id,
        "sector_id": sectorId,
        "occupation_id": occupationId,
        "level": level,
        "required_number": requiredNumber,
        "incorporate_possible": incorporatePossible,
        "other_occupation_value": otherOccupationValue,
      };
}
