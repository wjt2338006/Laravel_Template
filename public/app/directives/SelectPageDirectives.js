/**
 * Created by keith on 17-1-23.
 */
adminApp.directive('selectPage', function () {

    return {
        restrict: "EA",
        scope: {

            spObj:"=spObj",
            selectList:"=selectList",
            inputList:"=inputList"

        },
        templateUrl: "/app/directives/SelectPage.html",
        controller: function ($scope) {
            $scope.PageClass = function (selectPage) {
                var self = {};
                self.selectPage = selectPage;
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





                // self.selectPage.limit = {};
                // self.selectPage.limit.name = '';
                return self;
            }
        },
        link: function ($scope, element, attrs) {

            /*
            參數
             sp-obj  => spObj selectPage实例
             input-list => 可输入框列表
             select-list => 下拉列表

             */
            var selectPage =$scope.$eval(attrs.spObj);
            var selectList =$scope.$eval(attrs.selectList);
            var inputList =$scope.$eval(attrs.inputList);

            console.log(selectPage)
            $scope.page = $scope.PageClass(selectPage);

            $scope.page.setInputList(inputList);
            $scope.page.setSelectList(selectList);

        }
    }
});