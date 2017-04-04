/**
 * Created by keith on 17-3-31.
 */
adminApp.directive('leftNav', function () {
    return {
        restrict: "EA",
        scope: {
            data:"="
        },
        templateUrl: "/app/directives/LeftNav/LeftNav.html",
        controller: function ($scope, $mdSidenav) {
            // $scope.data = {
            //     username: "用户名",
            //     userhead:"/img/matthew.png",
            //     title: "标题",
            //     lastLogin: "上次登录",
            //     menu: [
            //         {"name":"用户管理","icon":"add user icon","url":"ss"}
            //     ]
            // };
            $scope.toggleLeft = function () {

                $mdSidenav('left').toggle();
            };

        },
        link: function ($scope, element, attrs) {

        }
    }
});

adminApp.service('leftNav', function ($mdSidenav) {
    var self = {};
    self.toggleLeft = function () {
        console.log("saas");
        $mdSidenav('left').toggle();
    };
    return self;
});