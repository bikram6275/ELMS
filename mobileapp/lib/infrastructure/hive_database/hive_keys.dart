class HiveKeys {
  static String productsServicesKey = "products";
  static String surveysKey = "surveys";
  static String organizationKey = "organization";
  static String subSectorKey = "subSector";
  static String occupationKey = "occupation";
  static String updateListKey = "updateList";
  static String aboutUsKey = "aboutUs";
  static String nMonthKey = "nepaliMonth";
  static String nYearKey = "nepaliYear";

  static String getQuestionKey(surveyId, pivotId) {
    var survey = surveyId.toString();
    var pivot = pivotId.toString();
    return "questions$survey$pivot";
  }

  static String getFinishSurveyKey() {
    return "finishSurveyList";
  }

  static String getStartSurveyKey() {
    return "startSurveyList";
  }
}
