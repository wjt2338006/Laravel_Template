/**
 * Created by keith on 17-1-5.
 */
adminApp.controller("IndexCtrl", function ($scope,$mdSidenav) {
    $scope.welcome="hellow";

    $scope.toggleLeft = function(){
        $mdSidenav('left').toggle();
    };
    $scope.toggleRight = function(){
        $mdSidenav('right').toggle();
    };
});