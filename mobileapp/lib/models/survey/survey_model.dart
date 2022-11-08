import 'dart:convert';

List<SurveyModel> surveyModelFromJson(data) =>
    List<SurveyModel>.from(data.map((x) => SurveyModel.fromJson(x)));

String surveyModelToJson(List<SurveyModel> data) =>
    json.encode(List<dynamic>.from(data.map((x) => x.toJson())));

class SurveyModel {
  SurveyModel({
    required this.id,
    required this.surveyName,
    required this.startDate,
    required this.endDate,
  });

  final int id;
  final String surveyName;
  final String startDate;
  final String endDate;

  factory SurveyModel.fromJson(json) => SurveyModel(
        id: json["id"],
        surveyName: json["survey_name"],
        startDate: json["start_date"],
        endDate: json["end_date"],
      );

  Map<String, dynamic> toJson() => {
        "id": id,
        "survey_name": surveyName,
        "start_date": startDate,
        "end_date": endDate,
      };
}
