// // To parse this JSON data, do
// //
// //     final fullAnswerModel = fullAnswerModelFromJson(jsonString);

// import 'package:meta/meta.dart';
// import 'dart:convert';

// FullAnswerModel fullAnswerModelFromJson(String str) =>
//     FullAnswerModel.fromJson(json.decode(str));

// String fullAnswerModelToJson(FullAnswerModel data) =>
//     json.encode(data.toJson());

// class FullAnswerModel {
//   FullAnswerModel({
//     required this.data,
//   });

//   final List<Datum> data;

//   factory FullAnswerModel.fromJson(Map<String, dynamic> json) =>
//       FullAnswerModel(
//         data: List<Datum>.from(json["data"].map((x) => Datum.fromJson(x))),
//       );

//   Map<String, dynamic> toJson() => {
//         "data": List<dynamic>.from(data.map((x) => x.toJson())),
//       };
// }

// class Datum {
//   Datum({
//     required this.id,
//     required this.qsnNumber,
//     required this.qsnName,
//     required this.ansType,
//     required this.qsnStatus,
//     required this.required,
//     required this.instruction,
//     required this.answer,
//     required this.questionOptions,
//     required this.subQuestions,
//     required this.sector,
//     required this.subSectors,
//     required this.humanResource,
//     required this.workers,
//     required this.occupations,
//     required this.workingHour,
//     required this.natureOfWork,
//     required this.training,
//     required this.educationalQualificationGeneral,
//     required this.educationalQualificationTvet,
//     required this.occupation,
//     required this.conditionalQuestion,
//     required this.workerSkills,
//   });

//   final int id;
//   final String qsnNumber;
//   final String qsnName;
//   final String ansType;
//   final Status qsnStatus;
//   final Required required;
//   final String instruction;
//   final dynamic answer;
//   final List<DatumQuestionOption> questionOptions;
//   final List<Question> subQuestions;
//   final dynamic sector;
//   final List<SectorElement> subSectors;
//   final List<String> humanResource;
//   final List<String> workers;
//   final List<Occupation> occupations;
//   final List<String> workingHour;
//   final List<String> natureOfWork;
//   final List<String> training;
//   final List<EducationalQualification> educationalQualificationGeneral;
//   final List<EducationalQualification> educationalQualificationTvet;
//   final List<Occupation> occupation;
//   final List<Question> conditionalQuestion;
//   final WorkerSkills workerSkills;

//   factory Datum.fromJson(Map<String, dynamic> json) => Datum(
//         id: json["id"],
//         qsnNumber: json["qsn_number"],
//         qsnName: json["qsn_name"],
//         ansType: json["ans_type"],
//         qsnStatus: json["qsn_status"],
//         required: json["required"],
//         instruction: json["instruction"],
//         answer: json["answer"],
//         questionOptions: json["question_options"],
//         subQuestions: json["sub_questions"],
//         sector: json["sector"],
//         subSectors: json["sub_sectors"] ,
//         humanResource: json["human_resource"] == null
//             ? null
//             : List<String>.from(json["human_resource"].map((x) => x)),
//         workers: json["workers"] == null
//             ? null
//             : List<String>.from(json["workers"].map((x) => x)),
//         occupations: json["occupations"] == null
//             ? null
//             : List<Occupation>.from(
//                 json["occupations"].map((x) => Occupation.fromJson(x))),
//         workingHour: json["working_hour"] == null
//             ? null
//             : List<String>.from(json["working_hour"].map((x) => x)),
//         natureOfWork: json["nature_of_work"] == null
//             ? null
//             : List<String>.from(json["nature_of_work"].map((x) => x)),
//         training: json["training"] == null
//             ? null
//             : List<String>.from(json["training"].map((x) => x)),
//         educationalQualificationGeneral:
//             json["educational_qualification_general"] == null
//                 ? null
//                 : List<EducationalQualification>.from(
//                     json["educational_qualification_general"]
//                         .map((x) => EducationalQualification.fromJson(x))),
//         educationalQualificationTvet:
//             json["educational_qualification_tvet"] == null
//                 ? null
//                 : List<EducationalQualification>.from(
//                     json["educational_qualification_tvet"]
//                         .map((x) => EducationalQualification.fromJson(x))),
//         occupation: json["occupation"] == null
//             ? null
//             : List<Occupation>.from(
//                 json["occupation"].map((x) => Occupation.fromJson(x))),
//         conditionalQuestion: json["conditional_question"] == null
//             ? null
//             : List<Question>.from(
//                 json["conditional_question"].map((x) => Question.fromJson(x))),
//         workerSkills: json["worker_skills"] == null
//             ? null
//             : WorkerSkills.fromJson(json["worker_skills"]),
//       );

//   Map<String, dynamic> toJson() => {
//         "id": id,
//         "qsn_number": qsnNumber,
//         "qsn_name": qsnName,
//         "ans_type": ansType,
//         "qsn_status": statusValues.reverse[qsnStatus],
//         "required": requiredValues.reverse[required],
//         "instruction": instruction == null ? null : instruction,
//         "answer": answer,
//         "question_options": questionOptions == null
//             ? null
//             : List<dynamic>.from(questionOptions.map((x) => x.toJson())),
//         "sub_questions": subQuestions == null
//             ? null
//             : List<dynamic>.from(subQuestions.map((x) => x.toJson())),
//         "sector": sector,
//         "sub_sectors": subSectors == null
//             ? null
//             : List<dynamic>.from(subSectors.map((x) => x.toJson())),
//         "human_resource": humanResource == null
//             ? null
//             : List<dynamic>.from(humanResource.map((x) => x)),
//         "workers":
//             workers == null ? null : List<dynamic>.from(workers.map((x) => x)),
//         "occupations": occupations == null
//             ? null
//             : List<dynamic>.from(occupations.map((x) => x.toJson())),
//         "working_hour": workingHour == null
//             ? null
//             : List<dynamic>.from(workingHour.map((x) => x)),
//         "nature_of_work": natureOfWork == null
//             ? null
//             : List<dynamic>.from(natureOfWork.map((x) => x)),
//         "training": training == null
//             ? null
//             : List<dynamic>.from(training.map((x) => x)),
//         "educational_qualification_general":
//             educationalQualificationGeneral == null
//                 ? null
//                 : List<dynamic>.from(
//                     educationalQualificationGeneral.map((x) => x.toJson())),
//         "educational_qualification_tvet": educationalQualificationTvet == null
//             ? null
//             : List<dynamic>.from(
//                 educationalQualificationTvet.map((x) => x.toJson())),
//         "occupation": occupation == null
//             ? null
//             : List<dynamic>.from(occupation.map((x) => x.toJson())),
//         "conditional_question": conditionalQuestion == null
//             ? null
//             : List<dynamic>.from(conditionalQuestion.map((x) => x.toJson())),
//         "worker_skills": workerSkills == null ? null : workerSkills.toJson(),
//       };
// }

// class AnswerClass {
//   AnswerClass();

//   factory AnswerClass.fromJson(Map<String, dynamic> json) => AnswerClass();

//   Map<String, dynamic> toJson() => {};
// }

// class Question {
//   Question({
//     required this.id,
//     required this.parentId,
//     required this.qsnNumber,
//     required this.qsnName,
//     required this.ansType,
//     required this.qstStatus,
//     required this.required,
//     required this.instruction,
//     required this.qsnModify,
//     required this.qsnOrder,
//     required this.createdAt,
//     required this.updatedAt,
//     required this.answer,
//     required this.questionOption,
//   });

//   final int id;
//   final int parentId;
//   final String qsnNumber;
//   final String qsnName;
//   final String ansType;
//   final Status qstStatus;
//   final Required required;
//   final dynamic instruction;
//   final Required qsnModify;
//   final int qsnOrder;
//   final DateTime createdAt;
//   final DateTime updatedAt;
//   final List<dynamic> answer;
//   final List<ConditionalQuestionQuestionOption> questionOption;

//   factory Question.fromJson(Map<String, dynamic> json) => Question(
//         id: json["id"],
//         parentId: json["parent_id"],
//         qsnNumber: json["qsn_number"],
//         qsnName: json["qsn_name"],
//         ansType: json["ans_type"],
//         qstStatus: statusValues.map[json["qst_status"]],
//         required: requiredValues.map[json["required"]],
//         instruction: json["instruction"],
//         qsnModify: requiredValues.map[json["qsn_modify"]],
//         qsnOrder: json["qsn_order"],
//         createdAt: DateTime.parse(json["created_at"]),
//         updatedAt: DateTime.parse(json["updated_at"]),
//         answer: json["answer"] == null
//             ? null
//             : List<dynamic>.from(json["answer"].map((x) => x)),
//         questionOption: json["question_option"] == null
//             ? null
//             : List<ConditionalQuestionQuestionOption>.from(
//                 json["question_option"]
//                     .map((x) => ConditionalQuestionQuestionOption.fromJson(x))),
//       );

//   Map<String, dynamic> toJson() => {
//         "id": id,
//         "parent_id": parentId,
//         "qsn_number": qsnNumber,
//         "qsn_name": qsnName,
//         "ans_type": ansType,
//         "qst_status": statusValues.reverse[qstStatus],
//         "required": requiredValues.reverse[required],
//         "instruction": instruction,
//         "qsn_modify": requiredValues.reverse[qsnModify],
//         "qsn_order": qsnOrder,
//         "created_at": createdAt.toIso8601String(),
//         "updated_at": updatedAt.toIso8601String(),
//         "answer":
//             answer == null ? null : List<dynamic>.from(answer.map((x) => x)),
//         "question_option": questionOption == null
//             ? null
//             : List<dynamic>.from(questionOption.map((x) => x.toJson())),
//       };
// }

// class ConditionalQuestionQuestionOption {
//   ConditionalQuestionQuestionOption({
//     required this.id,
//     required this.parentId,
//     required this.qsnId,
//     required this.optionNumber,
//     required this.optionName,
//     required this.optionOrder,
//     required this.optionType,
//     required this.options,
//     required this.remarks,
//     required this.createdAt,
//     required this.updatedAt,
//   });

//   final int id;
//   final int parentId;
//   final int qsnId;
//   final String optionNumber;
//   final OptionName optionName;
//   final int optionOrder;
//   final OptionType optionType;
//   final dynamic options;
//   final dynamic remarks;
//   final DateTime createdAt;
//   final DateTime updatedAt;

//   factory ConditionalQuestionQuestionOption.fromJson(
//           Map<String, dynamic> json) =>
//       ConditionalQuestionQuestionOption(
//         id: json["id"],
//         parentId: json["parent_id"],
//         qsnId: json["qsn_id"],
//         optionNumber: json["option_number"],
//         optionName: optionNameValues.map[json["option_name"]],
//         optionOrder: json["option_order"],
//         optionType: optionTypeValues.map[json["option_type"]],
//         options: json["options"],
//         remarks: json["remarks"],
//         createdAt: DateTime.parse(json["created_at"]),
//         updatedAt: DateTime.parse(json["updated_at"]),
//       );

//   Map<String, dynamic> toJson() => {
//         "id": id,
//         "parent_id": parentId,
//         "qsn_id": qsnId,
//         "option_number": optionNumber,
//         "option_name": optionNameValues.reverse[optionName],
//         "option_order": optionOrder,
//         "option_type": optionTypeValues.reverse[optionType],
//         "options": options,
//         "remarks": remarks,
//         "created_at": createdAt.toIso8601String(),
//         "updated_at": updatedAt.toIso8601String(),
//       };
// }

// enum OptionName { YEAR, MONTH }

// final optionNameValues =
//     EnumValues({"Month": OptionName.MONTH, "Year": OptionName.YEAR});

// enum OptionType { INPUT, CHECKBOX, OTHERS, RADIO, COND_RADIO }

// final optionTypeValues = EnumValues({
//   "checkbox": OptionType.CHECKBOX,
//   "cond_radio": OptionType.COND_RADIO,
//   "input": OptionType.INPUT,
//   "others": OptionType.OTHERS,
//   "radio": OptionType.RADIO
// });

// class EducationalQualification {
//   EducationalQualification({
//     required this.id,
//     required this.name,
//     required this.type,
//     required this.createdAt,
//     required this.updatedAt,
//   });

//   final int id;
//   final String name;
//   final Type type;
//   final DateTime createdAt;
//   final DateTime updatedAt;

//   factory EducationalQualification.fromJson(Map<String, dynamic> json) =>
//       EducationalQualification(
//         id: json["id"],
//         name: json["name"],
//         type: typeValues.map[json["type"]],
//         createdAt: DateTime.parse(json["created_at"]),
//         updatedAt: DateTime.parse(json["updated_at"]),
//       );

//   Map<String, dynamic> toJson() => {
//         "id": id,
//         "name": name,
//         "type": typeValues.reverse[type],
//         "created_at": createdAt.toIso8601String(),
//         "updated_at": updatedAt.toIso8601String(),
//       };
// }

// enum Type { GENERAL, TVET }

// final typeValues = EnumValues({"general": Type.GENERAL, "tvet": Type.TVET});

// class Occupation {
//   Occupation({
//     required this.id,
//     required this.sectorId,
//     required this.occupationName,
//     required this.createdAt,
//     required this.updatedAt,
//   });

//   final int id;
//   final int sectorId;
//   final String occupationName;
//   final dynamic createdAt;
//   final dynamic updatedAt;

//   factory Occupation.fromJson(Map<String, dynamic> json) => Occupation(
//         id: json["id"],
//         sectorId: json["sector_id"],
//         occupationName: json["occupation_name"],
//         createdAt: json["created_at"],
//         updatedAt: json["updated_at"],
//       );

//   Map<String, dynamic> toJson() => {
//         "id": id,
//         "sector_id": sectorId,
//         "occupation_name": occupationName,
//         "created_at": createdAt,
//         "updated_at": updatedAt,
//       };
// }

// class DatumQuestionOption {
//   DatumQuestionOption({
//     required this.id,
//     required this.qsnId,
//     required this.optionNumber,
//     required this.optionName,
//     required this.optionOrder,
//     required this.optionType,
//     required this.options,
//   });

//   final int id;
//   final int qsnId;
//   final String optionNumber;
//   final String optionName;
//   final int optionOrder;
//   final OptionType optionType;
//   final dynamic options;

//   factory DatumQuestionOption.fromJson(Map<String, dynamic> json) =>
//       DatumQuestionOption(
//         id: json["id"],
//         qsnId: json["qsn_id"],
//         optionNumber: json["option_number"],
//         optionName: json["option_name"],
//         optionOrder: json["option_order"],
//         optionType: optionTypeValues.map[json["option_type"]],
//         options: json["options"],
//       );

//   Map<String, dynamic> toJson() => {
//         "id": id,
//         "qsn_id": qsnId,
//         "option_number": optionNumber,
//         "option_name": optionName,
//         "option_order": optionOrder,
//         "option_type": optionTypeValues.reverse[optionType],
//         "options": options,
//       };
// }

// class SectorElement {
//   SectorElement({
//     required this.id,
//     required this.parentId,
//     required this.sectorName,
//     required this.createdAt,
//     required this.updatedAt,
//     required this.detail,
//   });

//   final int id;
//   final int parentId;
//   final String sectorName;
//   final DateTime createdAt;
//   final DateTime updatedAt;
//   final String detail;

//   factory SectorElement.fromJson(Map<String, dynamic> json) => SectorElement(
//         id: json["id"],
//         parentId: json["parent_id"],
//         sectorName: json["sector_name"],
//         createdAt: DateTime.parse(json["created_at"]),
//         updatedAt: DateTime.parse(json["updated_at"]),
//         detail: json["detail"] == null ? null : json["detail"],
//       );

//   Map<String, dynamic> toJson() => {
//         "id": id,
//         "parent_id": parentId,
//         "sector_name": sectorName,
//         "created_at": createdAt.toIso8601String(),
//         "updated_at": updatedAt.toIso8601String(),
//         "detail": detail == null ? null : detail,
//       };
// }

// class WorkerSkills {
//   WorkerSkills({
//     required this.communication,
//     required this.punctuality,
//     required this.teamWork,
//     required this.leadership,
//     required this.interpersonal,
//   });

//   final String communication;
//   final String punctuality;
//   final String teamWork;
//   final String leadership;
//   final String interpersonal;

//   factory WorkerSkills.fromJson(Map<String, dynamic> json) => WorkerSkills(
//         communication: json["communication"],
//         punctuality: json["punctuality"],
//         teamWork: json["team_work"],
//         leadership: json["leadership"],
//         interpersonal: json["interpersonal"],
//       );

//   Map<String, dynamic> toJson() => {
//         "communication": communication,
//         "punctuality": punctuality,
//         "team_work": teamWork,
//         "leadership": leadership,
//         "interpersonal": interpersonal,
//       };
// }

// class EnumValues<T> {
//   Map<String, T> map;
//   Map<T, String> reverseMap;

//   EnumValues(this.map);

//   Map<T, String> get reverse {
//     if (reverseMap == null) {
//       reverseMap = map.map((k, v) => new MapEntry(v, k));
//     }
//     return reverseMap;
//   }
// }
