class Question6AModel {
  Question6AModel({
    required this.id,
    required this.qsnNumber,
    required this.qsnName,
    required this.ansType,
    required this.qsnStatus,
    required this.requireda,
    required this.instruction,
    required this.workingHour,
    required this.natureOfWork,
    required this.training,
    required this.educationalQualificationGeneral,
    required this.educationalQualificationTvet,
  });

  final int id;
  final String qsnNumber;
  final String qsnName;
  final String ansType;
  final String qsnStatus;
  final String requireda;
  final String instruction;
  final List<String> workingHour;
  final List<String> natureOfWork;
  final List<String> training;
  final List<EducationalQualification> educationalQualificationGeneral;
  final List<EducationalQualification> educationalQualificationTvet;

  factory Question6AModel.fromJson(Map<String, dynamic> json) =>
      Question6AModel(
        id: json["id"],
        qsnNumber: json["qsn_number"],
        qsnName: json["qsn_name"],
        ansType: json["ans_type"],
        qsnStatus: json["qsn_status"],
        requireda: json["required"],
        instruction: json["instruction"],
        workingHour: List<String>.from(json["working_hour"].map((x) => x)),
        natureOfWork: List<String>.from(json["nature_of_work"].map((x) => x)),
        training: List<String>.from(json["training"].map((x) => x)),
        educationalQualificationGeneral: List<EducationalQualification>.from(
            json["educational_qualification_general"]
                .map((x) => EducationalQualification.fromJson(x))),
        educationalQualificationTvet: List<EducationalQualification>.from(
            json["educational_qualification_tvet"]
                .map((x) => EducationalQualification.fromJson(x))),
      );

  Map<String, dynamic> toJson() => {
        "id": id,
        "qsn_number": qsnNumber,
        "qsn_name": qsnName,
        "ans_type": ansType,
        "qsn_status": qsnStatus,
        "required": requireda,
        "instruction": instruction,
        "working_hour": List<dynamic>.from(workingHour.map((x) => x)),
        "nature_of_work": List<dynamic>.from(natureOfWork.map((x) => x)),
        "training": List<dynamic>.from(training.map((x) => x)),
        "educational_qualification_general": List<dynamic>.from(
            educationalQualificationGeneral.map((x) => x.toJson())),
        "educational_qualification_tvet": List<dynamic>.from(
            educationalQualificationTvet.map((x) => x.toJson())),
      };
}

class EducationalQualification {
  EducationalQualification({
    required this.id,
    required this.name,
    required this.type,
  });

  final int id;
  final String name;
  final Type type;

  factory EducationalQualification.fromJson(Map<String, dynamic> json) =>
      EducationalQualification(
        id: json["id"],
        name: json["name"],
        type: json["type"],
      );

  Map<String, dynamic> toJson() => {
        "id": id,
        "name": name,
        "type": type,
      };
}
