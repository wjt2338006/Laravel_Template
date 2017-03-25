/**
 * Created by jedi on 17-3-25.
 */
var adminApp = angular.module('adminApp', ['ui.router', 'ngMaterial', 'ngAnimate',"toaster"]).config(function ($stateProvider, $mdThemingProvider) {
    var first = [
        {
            name: 'index',
            url: '/index',
            controller: 'IndexDetailCtrl',
            templateUrl: '/app/template/admin/index.html'
        },

        {
            name: 'power_group',
            url: '/power_group',
            controller: 'PowerGroupCtrl',
            templateUrl: '/app/template/admin/power_group.html'
        },
        {
            name: 'power_group_detail',
            url: '/power_group/:id',
            controller: 'PowerGroupDetailCtrl',
            templateUrl: '/app/template/admin/power_group_detail.html'
        }
    ];

    for (var i in first) {
        $stateProvider.state(first[i]);
    }

    $mdThemingProvider.theme('default').primaryPalette('teal').accentPalette('brown');
});

adminApp.controller("IndexCtrl", function ($scope, $mdSidenav, HeaderNav, $http) {
    $scope.welcome = "hellow";

    $scope.toggleLeft = function () {
        $mdSidenav('left').toggle();
    };
    $scope.toggleRight = function () {
        $mdSidenav('right').toggle();
    };


    var nav_list = [

        {
            name: '权限',
            url: 'power_group_detail'
        },
        {
            name: '基本信息管理',
            url: 'power_group'

        }
    ];
    HeaderNav.flush(nav_list);
    $scope.headerNav = HeaderNav;


    $scope.logout = function(){
        $http.get("/logout").then(function(res){
            if(res.data.status == true)
            {
                window.location="/";
            }

        })
    }


});

adminApp.controller("PowerGroupCtrl", function ($scope, $http, SelectPage, $state,toaster) {

    $scope.onload = false;

    $scope.result = {};

    $scope.selectPage = SelectPage;
    $scope.selectPage.limit = {start: 0, num: 10, desc: true, status: '',group_id:"",group_name:""};
    $scope.selectPage.getDataUrl = "./powerGroup/get";
    $scope.selectPage.getDataMethod = "GET";
    $scope.selectPage.getData();
    $scope.selectPage.successCallback = function (response) {
        console.log(response.data)
        $scope.onload = true;

    };

    // $scope.selectList = {
    //     "status": [
    //         {key: "", value: "选择所有状态"},
    //         {key: "key", value: "买了"},
    //         {key:"ss",value:"12132"}
    //     ],
    //     "ssss":[{key:"",value:"所有人"}]
    // };

    $scope.inputList = {
        "group_name": "按名称搜索",
        "group_id": "请输入id"
    };


    $scope.toGroupDetail = function (id) {
        $scope.isDetail = true;
        $state.go('power_group_detail', {id: id});
    };


    $scope.toggleAddModal = function (status) {
        $('.add_group').modal(status);
    };
    $scope.addGroupSubmit = function (data) {
        $http.post("./powerGroup/add",{params:data}).then(function(response){
           if(response.status == 200)
           {
               console.log(response.data)
               toaster.pop({
                   type: 'success',
                   title: '成功',
                   body: res.data.message,
                   timeout: 3000
               });
               $scope.toGroupDetail(response.data.data)
           }
            toaster.pop({
                type: 'error',
                title: '错误',
                body: res.data.message,
                timeout: 3000
            });
        });
    };




});

adminApp.controller("PowerGroupDetailCtrl",function($scope, $http, SelectPage, $state,$stateParams,AdminService){
    $scope.group_id = $stateParams.id;
    $scope.loaded=false;
    $scope.toList = function () {
        $scope.isDetail = false;
        $state.go('power_detail');
    };

    $scope.groupData = {}
    $scope.permitData = {}
    $scope.adminData = {}

    $scope.groupStatus=AdminService.constVal.powerGroupStatus

    $scope.getDetail = function(){
        AdminService.api.getPowerDetail($scope,"groupData" ,{group_id:$scope.group_id})
    };
    $scope.getPermit =  function(){
        AdminService.api.getPowerPermit($scope,"permitData",$scope.filterHave)
    };
    $scope.getAdmin = function(){
        AdminService.api.getAdmin($scope,"adminData",{group_id:$scope.group_id})
    };

    $scope.toReady = function(k){
        var data  = $scope.groupData.permit[k]
        $scope.groupData.permit.splice(k,1)
        $scope.permitData.push(data)
        $scope.filterHave()
    };
    $scope.toHave = function(v){
        $scope.groupData.permit.push(v)
        $scope.filterHave()
    };
    $scope.filterHave = function(){
        willDel = [];
        $.each($scope.permitData,function(k,v){
            $.each( $scope.groupData.permit,function(k1,v1){
                if(v1.permission_id == v.permission_id)
                {
                    willDel.push(k)
                }
            });
        });
        $.each(willDel,function(k,v){
            $scope.permitData.splice(v,1)
        });
    };

    $scope.getDetail()
    $scope.getPermit()
    $scope.getAdmin()


});
