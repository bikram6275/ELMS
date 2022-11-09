class SyncAnswerModel {
  final dynamic formData;
  final int questionId;
  final String questionNumber;

  SyncAnswerModel(
      {required this.formData,
      required this.questionId,
      required this.questionNumber});

  factory SyncAnswerModel.toModel(doc) => SyncAnswerModel(
      formData: doc["formData"],
      questionId: doc["questionId"],
      questionNumber: doc["questionNumber"]);

  static toJsonList(List<SyncAnswerModel> list) {
    List<dynamic> dynamicList = [];
    for (var element in list) {
      dynamicList.add({
        "formData": element.formData,
        "questionId": element.questionId,
        "questionNumber": element.questionNumber
      });
    }
    return dynamicList;
  }

  static toModelList(List<dynamic> list) {
    List<SyncAnswerModel> modelList = [];
    for (var element in list) {
      modelList.add(SyncAnswerModel.toModel(element));
    }
    return modelList;
  }
}
