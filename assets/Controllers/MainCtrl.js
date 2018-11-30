var fishApp = angular.module('fishApp', []);

fishApp.controller('MainCtrl',function($scope,$rootScope) {
    $scope.isLoggedIn= false;
    console.log("Page Load");

    $scope.init = function (isLoggedIn) {
        $scope.isLoggedIn = isLoggedIn;
    }
});