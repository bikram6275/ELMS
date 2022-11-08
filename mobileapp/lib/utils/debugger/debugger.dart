// ignore_for_file: avoid_print

const bool isProduction = bool.fromEnvironment('dart.vm.product');

debugger({error, data, dataName, stacktrace}) {
  if (!isProduction) {
    if (error != null) {
      print("* error => $error");
    }
    if (data != null) {
      print("* name => ${dataName ?? "variable"} , value => $data");
    }
    if (stacktrace != null) {
      print("* stacktrace => $stacktrace");
    }
  }
}
