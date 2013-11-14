var app;

app = angular.module("qpmApp", []);

app.controller("web", function($scope) {
  $scope.username = null;
  $scope.password = null;
  $scope.remember = false;
  $scope.toggle_remember = function() {
    return $scope.remember = !$scope.remember;
  };
  return $scope.login = function() {
    if (!($scope.username && $scope.password)) {
      return;
    }
    return UserSvc.login($scope.username, $scope.password);
  };
});

/*
//@ sourceMappingURL=qpm.js.map
*/