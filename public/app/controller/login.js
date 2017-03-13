/**
 * Created by jedi on 17-3-13.
 */

angular.module('adminApp',['ui.router', 'ngMaterial', 'ngAnimate']).controller("LoginCtrl", function ($scope, $http) {

    $scope.login = function()
    {
        $http.post("./login",{params:{username:$scope.username,password:$scope.password}}).then(function (res) {
            if (res.data.status == 200) {
                console.log(res.data)
                window.location = "/";
            }
        });
    };



});
