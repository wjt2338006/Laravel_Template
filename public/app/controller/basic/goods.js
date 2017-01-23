/**
 * Created by keith on 17-1-23.
 */
adminApp.controller("GoodsIndexCtrl", function ($scope,$http,SelectPage,$state) {

    var url= "/Basic/Goods/getData";
    $scope.result = {};
    // $scope.get = function(){
    //     $http.post(url,null).then(function(result){
    //         $scope.result  = result.data.data;
    //         console.log($scope.result );
    //     });
    // };

    $scope.selectPage = SelectPage;
    $scope.selectPage.limit = {start: 0, num: 10, desc: true,status:''};
    $scope.selectPage.getDataUrl = url;
    $scope.selectPage.getDataMethod = "GET";
    $scope.selectPage.getData();


    $scope.selectList = {
        "status": [
            {key: "", value: "选择所有状态"},
            {key: "key", value: "买了"}
        ]
    };
    $scope.inputList = {
        "data_name":"按名称搜索"
    };


    $scope.toGoodsDetail = function(id)
    {
        $scope.isDetail = true;
        $state.go('.detail',{id:id});
    };

    $scope.isDetail = false;


});
adminApp.controller("GoodsDetailCtrl", function ($scope,$http,SelectPage,$stateParams,$state) {
    console.log($stateParams.id);

    $scope.toList = function(){
        $scope.isDetail = false;
        $state.go('goods');

    }

});
