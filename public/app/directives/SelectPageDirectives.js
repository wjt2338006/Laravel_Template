/**
 * Created by keith on 17-1-23.
 */
adminApp.directive('selectPage', function () {

    return {
        restrict: "EA",
        scope: {

            limit:"=",
            getData:"&",
            selectList:"=",
            inputList:"="

        },
        templateUrl: "/app/directives/SelectPage.html",
        controller: function ($scope) {
            $scope.PageClass = function (limit,getData) {
                var self = {};
                self.limit = limit;
                self.getData = getData;
                // self.selectPage = selectPage;
                self.setInputList = function(list)
                {

                    // self.inputList = {
                    //     "some_value":"说明"
                    // };
                    self.inputList = list;

                };
                self.setSelectList = function(list)
                {
                    // self.selectList = {
                    //     "name": [
                    //         {key: "", value: "选择所有类型"},
                    //         {key: "key", value: "啊啊啊啊"}
                    //     ],
                    //     "smakk": [
                    //         {key: "o_name", value: "o_value"},
                    //         {key: "key", value: "啊啊啊啊"}
                    //     ]
                    // };
                    self.selectList = list;
                };

                return self;
            }
        },
        link: function ($scope, element, attrs) {

            $scope.page = $scope.PageClass($scope.limit,$scope.$eval($scope.getData));

            $scope.page.setInputList($scope.inputList);
            $scope.page.setSelectList($scope.selectList);
            console.log($scope)
        }
    }
});