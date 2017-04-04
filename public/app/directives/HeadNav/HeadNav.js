/**
 * Created by keith on 17-3-31.
 */
adminApp.directive('headNav', function () {
    /*
     {
     name:"File",
     func:function(){}

     son:[{name:"Edit",func:function(){}]
     }
     */
    return {
        restrict: "EA",
        scope: {
            data: "="
        },
        templateUrl: "/static/app/directives/HeadNav/HeadNav.html",
        controller: function ($scope) {
            console.log($scope.data)
        }
    }
});

