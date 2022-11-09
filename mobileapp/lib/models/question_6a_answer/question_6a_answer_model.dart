// To parse this JSON data, do
//
//     final question6AAnswerModel = question6AAnswerModelFromJson(jsonString);

class Question6AAnswerModel {
  Question6AAnswerModel({
    required this.id,
    required this.empName,
    required this.gender,
    required this.occupationId,
    required this.workingTime,
    required this.otherOccupationValue,
    required this.workNature,
    required this.training,
    required this.ojtApprentice,
    required this.eduQuaGeneralId,
    required this.eduQuaTvetId,
    required this.workExp1,
    required this.workExp2,
  });

  final int? id;
  final String empName;
  final String gender;
  final int occupationId;
  final String workingTime;
  final String workNature;
  final String otherOccupationValue;
  final String training;
  final String ojtApprentice;
  final int eduQuaGeneralId;
  final int eduQuaTvetId;
  final String workExp1;
  final String workExp2;

  factory Question6AAnswerModel.fromJson(json) {
    return Question6AAnswerModel(
      id: json["id"],
      empName: json["emp_name"],
      gender: json["gender"],
      occupationId: json["occupation_id"],
      otherOccupationValue: json["other_occupation_value"] ?? "-",
      workingTime: json["working_time"],
      workNature: json["work_nature"],
      training: json["training"],
      ojtApprentice: json["ojt_apprentice"] ?? " ",
      eduQuaGeneralId: json["edu_qua_general"],
      eduQuaTvetId: json["edu_qua_tvet"],
      workExp1: json["work_exp1"],
      workExp2: json["work_exp2"],
    );
  }
}
