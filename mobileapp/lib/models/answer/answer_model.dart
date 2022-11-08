class AnswerModel {
  final int questionId;
  final String? fieldValue;
  final String questionType;
  final Map? extraData;

  AnswerModel(
      {required this.questionId,
      this.fieldValue,
      required this.questionType,
      this.extraData});
}
