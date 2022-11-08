import 'dart:convert';

Question8AnswerModel question8AnswerModelFromJson(String str) =>
    Question8AnswerModel.fromJson(json.decode(str));

String question8AnswerModelToJson(Question8AnswerModel data) =>
    json.encode(data.toJson());

class Question8AnswerModel {
  Question8AnswerModel({
    required this.id,
    required this.occupationId,
    required this.presentDemand,
    required this.demandTwoYear,
    required this.demandFiveYear,
  });

  final int? id;
  final int occupationId;
  final String presentDemand;
  final String demandTwoYear;
  final String demandFiveYear;

  factory Question8AnswerModel.fromJson(json) => Question8AnswerModel(
        id: json["id"],
        occupationId: json["occupation_id"],
        presentDemand: json["present_demand"].toString(),
        demandTwoYear: json["demand_two_year"].toString(),
        demandFiveYear: json["demand_five_year"].toString(),
      );

  Map<String, dynamic> toJson() => {
        "id": id,
        "occupation_name": occupationId,
        "present_demand": presentDemand,
        "demand_two_year": demandTwoYear,
        "demand_five_year": demandFiveYear,
      };
}
