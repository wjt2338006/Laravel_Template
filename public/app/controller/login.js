/**
 * Created by jedi on 17-3-13.
 */

angular.module('adminApp',['ui.router', 'ngMaterial', 'ngAnimate',"toaster"]).controller("LoginCtrl", function ($scope, $timeout,$http,toaster) {


    $scope.login = function()
    {
        $http.post("./login",{params:{username:$scope.username,password:$scope.password}}).then(function (res) {
            if (res.data.status == 200) {
                toaster.pop({
                    type: 'success',
                    title: '登陆成功',
                    body: '即将进入',
                    timeout: 3000
                });
                $timeout(function(){
                    console.log(res.data)
                    window.location = "/";
                }, 500);

            }
            else
            {
                toaster.pop({
                    type: 'error',
                    title: '错误',
                    body: res.data.message,
                    timeout: 3000
                });
            }

        });

    };



});
