// To parse this JSON data, do
//
//     final question6BModel = question6BModelFromJson(jsonString);

import 'dart:convert';

Question6BModel question6BModelFromJson(String str) =>
    Question6BModel.fromJson(json.decode(str));

String question6BModelToJson(Question6BModel data) =>
    json.encode(data.toJson());

class Question6BModel {
  Question6BModel({
    required this.id,
    required this.qsnNumber,
    required this.qsnName,
    required this.ansType,
    required this.qsnStatus,
    required this.requiredb,
    required this.instruction,
    required this.sector,
    required this.occupations,
    required this.answer,
  });

  final int id;
  final String qsnNumber;
  final String qsnName;
  final String ansType;
  final String qsnStatus;
  final String requiredb;
  final dynamic instruction;
  final Sector sector;
  final List<Occupation> occupations;
  final List<Answer> answer;

  factory Question6BModel.fromJson(Map<String, dynamic> json) =>
      Question6BModel(
        id: json["id"],
        qsnNumber: json["qsn_number"],
        qsnName: json["qsn_name"],
        ansType: json["ans_type"],
        qsnStatus: json["qsn_status"],
        requiredb: json["required"],
        instruction: json["instruction"],
        sector: Sector.fromJson(json["sector"]),
        occupations: List<Occupation>.from(
            json["occupations"].map((x) => Occupation.fromJson(x))),
        answer:
            List<Answer>.from(json["answer"].map((x) => Answer.fromJson(x))),
      );

  Map<String, dynamic> toJson() => {
        "id": id,
        "qsn_number": qsnNumber,
        "qsn_name": qsnName,
        "ans_type": ansType,
        "qsn_status": qsnStatus,
        "required": requiredb,
        "instruction": instruction,
        "sector": sector.toJson(),
        "occupations": List<dynamic>.from(occupations.map((x) => x.toJson())),
        "answer": List<dynamic>.from(answer.map((x) => x.toJson())),
      };
}

class Answer {
  Answer({
    required this.id,
    required this.name,
  });

  final int id;
  final int name;

  factory Answer.fromJson(Map<String, dynamic> json) => Answer(
        id: json["id"],
        name: json["name"],
      );

  Map<String, dynamic> toJson() => {
        "id": id,
        "name": name,
      };
}

class Occupation {
  Occupation({
    required this.id,
    required this.sectorId,
    required this.occupationName,
    required this.createdAt,
    required this.updatedAt,
  });

  final int id;
  final int sectorId;
  final String occupationName;
  final dynamic createdAt;
  final dynamic updatedAt;

  factory Occupation.fromJson(Map<String, dynamic> json) => Occupation(
        id: json["id"],
        sectorId: json["sector_id"],
        occupationName: json["occupation_name"],
        createdAt: json["created_at"],
        updatedAt: json["updated_at"],
      );

  Map<String, dynamic> toJson() => {
        "id": id,
        "sector_id": sectorId,
        "occupation_name": occupationName,
        "created_at": createdAt,
        "updated_at": updatedAt,
      };
}

class Sector {
  Sector({
    required this.id,
    required this.parentId,
    required this.sectorName,
    required this.createdAt,
    required this.updatedAt,
    required this.detail,
  });

  final int id;
  final int parentId;
  final String sectorName;
  final DateTime createdAt;
  final DateTime updatedAt;
  final dynamic detail;

  factory Sector.fromJson(Map<String, dynamic> json) => Sector(
        id: json["id"],
        parentId: json["parent_id"],
        sectorName: json["sector_name"],
        createdAt: DateTime.parse(json["created_at"]),
        updatedAt: DateTime.parse(json["updated_at"]),
        detail: json["detail"],
      );

  Map<String, dynamic> toJson() => {
        "id": id,
        "parent_id": parentId,
        "sector_name": sectorName,
        "created_at": createdAt.toIso8601String(),
        "updated_at": updatedAt.toIso8601String(),
        "detail": detail,
      };
}
