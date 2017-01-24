/**
 * Created by keith on 17-1-24.
 */
adminApp.directive('loadingMan', function () {

    return {
        restrict: "EA",
        scope: {
            onload:"=onload"
        },
        templateUrl: "/app/directives/LoadingMan.html",
        controller: function ($scope)
        {
            $scope.show=true;
            // $scope.show = function(){
            //     $(".ui.dimmable").dimmer('show');
            // };
            // $scope.hide = function(){
            //     $(".ui.dimmable").dimmer('hide');
            // };
        },
        link: function ($scope, element, attrs) {

            /*
             參數
             onload => onload 监控的值,是否已经加载好了

             */
            $scope.onload =$scope.$eval(attrs.onload);


            $scope.$watch("onload",function(nv,ov){
                console.log(nv);
                if(nv == true)
                {
                    $scope.show = false;
                }
                else
                {
                    $scope.show = true;
                }
            });

        }
    }
});