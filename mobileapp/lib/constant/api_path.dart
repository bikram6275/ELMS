class ApiPath {
  // todo : check for baseurl
  // test
  // String baseUrl = "https://teamym.com/projects/elms_test/public/api/v1";

  // test
  // String baseUrl = "http://elms.teamym.com/api/v1";

  String baseUrl = "http://admin.elms.com.np:5180/api/v1";
  String login = "/login";
  String recentSurvey = "/recent-survey";
  String organizations = "/{{survey_id}}/organizations";
  String startSurvey = "/start-survey";
  String questions = "/{{survey_id}}/questions/{{pivot_id}}";
  String productAndService = "/product-and-service";
  String me = "/me";
  String pradesh = "/pradesh";
  String district = "/district/16";
  String answer = "/answer";
  String forgetPassword = "/forget-password";
  String subSectors = "/sub-sector";
  String occupation = "/occupation";
  String about = "/about";
  String finishSurvey = "/finish-survey";
  String surveyStatus = "/survey_status";
  String nepaliYears = "/nepali-years";
  String nepaliMonth = "/nepali-months";
  String organizationsIncludeFeedback = "/feedback";
  String feedbacks = "/feedback/{{pivot_id}}/view";
  String pradeshFilter = "/pradesh";
  String districtFilter = "/district?pradesh_id=#";
  String sectorFilter = "/sector";
}
