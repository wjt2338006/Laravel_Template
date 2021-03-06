/**
 * Created by keith on 17-1-23.
 */
adminApp.controller("GoodsIndexCtrl", function ($scope,$http,SelectPage,$state) {

    //noinspection JSUnresolvedFunction

    $scope.onload = false;

    $scope.result = {};
    // $scope.get = function(){
    //     $http.post(url,null).then(function(result){
    //         $scope.result  = result.data.data;
    //         console.log($scope.result );
    //     });
    // };

    $scope.selectPage = SelectPage;
    $scope.selectPage.limit = {start: 0, num: 10, desc: true,status:''};
    $scope.selectPage.getDataUrl =  "/Basic/Goods/getData";
    $scope.selectPage.getDataMethod = "GET";
    $scope.selectPage.getData();
    $scope.selectPage.successCallback = function (response) {
        $scope.onload = true;
    };

    $scope.selectList = {
        "status": [
            {key: "", value: "选择所有状态"},
            {key: "key", value: "买了"},
            {key:"ss",value:"12132"}
        ],
        "ssss":[{key:"",value:"所有人"}]
    };
    $scope.inputList = {
        "data_name":"按名称搜索",
        "data_id":"请输入id"
    };


    $scope.toGoodsDetail = function(id)
    {
        $scope.isDetail = true;
        $state.go('^.goods_detail',{id:id});
    };


});
adminApp.controller("GoodsDetailCtrl", function ($scope,$http,SelectPage,$stateParams,$state) {
    console.log($stateParams.id);

    $scope.toList = function(){
        $scope.isDetail = false;
        $state.go('goods');

    }

});
