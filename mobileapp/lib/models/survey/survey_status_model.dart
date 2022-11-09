class SurveyStatusModel {
  final int? assigned;
  final int? started;
  final int? completed;

  factory SurveyStatusModel.fromJson(doc) => SurveyStatusModel(
        assigned: doc["data"]["assigned"] ?? 0,
        started: doc["data"]["started"] ?? 0,
        completed: doc["data"]["completed"] ?? 0,
      );

  SurveyStatusModel({this.assigned, this.started, this.completed});
}
