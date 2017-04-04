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
            name: 'shop_detail',
            url: '/shop_detail',
            controller: 'ShopDetailCtrl',
            templateUrl: '/app/template/goods/shop_detail.html'
        },
        {
            name: 'goods',
            url: '/goods',
            controller: 'GoodsCtrl',
            templateUrl: '/app/template/goods/goods.html'
        },
        {
            name: 'goods_detail',
            url: '/goods_detail/:id',
            controller: 'GoodsDetailCtrl',
            templateUrl: '/app/template/goods/goods_detail.html'
        },
        {
            name: 'monitor',
            url: '/monitor',
            controller: 'MonitorCtrl',
            templateUrl: '/app/template/goods/monitor.html'
        },
        {
            name: 'monitor_detail',
            url: '/monitor_detail',
            controller: 'MonitorDetailCtrl',
            templateUrl: '/app/template/goods/monitor_detail.html'
        }
    ];

    for (var i in first)
    {
        $stateProvider.state(first[i]);
    }

    $mdThemingProvider.theme('default').primaryPalette('teal').accentPalette('brown');
});

adminApp.controller("IndexCtrl", function ($scope, $mdSidenav, HeaderNav, $http,$mdMenu,leftNav) {
    $scope.welcome = "hellow";

    $scope.getUserInfo = function(){
        $http.get("./getUserinfo",{}).then(function(res){
            console.log(res)
            if(res.status == 200)
            {
                $scope.leftMenu = {
                    username:res.data.data.shop_name,
                    userhead:"/img/matthew.png",
                    title:"用户信息",
                    lastLogin:res.data.data.updated_at,
                    origin:res.data.data
                }
            }
            else
            {
                console.log("error for getUserinfo")
            }
        });
    };
    $scope.getUserInfo()

    $scope.leftMenu = {
            username: "用户名",
            userhead:"/img/matthew.png",
            title: "标题",
            lastLogin: "上次登录",
            menu: [
                {"name":"用户管理","icon":"add user icon","url":"ss"}
            ]
        };
    $scope.toggleLeft = leftNav.toggleLeft;

    $scope.toModule =function(url)
    {
        window.location=url
    };
    $scope.leftNav = [
        {
            name:"基本",
            url:"/admin",
            icon:"file icon"
        },
        {
            name:"商品和店铺",
            url:"/goods",
            icon:"cubes icon"
        },
        {
            name:"任务",
            url:"/task",
            icon:"spinner icon"
        },
        {
            name:"统计和日志",
            url:"/task",
            icon:"bar chart icon"
        }
    ];

    var nav_list = [

        {
            name: '店铺',
            url: 'shop_detail'
        },
        {
            name: '商品',
            url: 'goods'

        },
        {
            name: '监控',
            url: 'monitor'

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

adminApp.controller("ShopDetailCtrl",function($scope, $http, SelectPage, $state,$stateParams,GoodsService){
    $scope.loaded = false;

    $scope.result = {};
    $scope.shopData = {}
       $scope.getDetail = function(){
           GoodsService.api.getShopDetail($scope,"shopData")
       }

    $scope.toggleResetPassModal=function (status) {
        $('.reset_password').modal(status);
    };
    $scope.submitResetPassword = function(data)
    {
        GoodsService.api.resetShopPasswd(data)
    }

    $scope.getDetail();
});
adminApp.controller("GoodsCtrl",function($scope, $http, SelectPage, $state,toaster){
    $scope.onload = false;

    $scope.result = {};

    $scope.selectPage = SelectPage;
    $scope.selectPage.limit = {start: 0, num: 10, desc: true, status: '',group_id:"",group_name:""};
    $scope.selectPage.getDataUrl = "./goods/get";
    $scope.selectPage.getDataMethod = "GET";
    $scope.selectPage.getData();
    $scope.selectPage.successCallback = function (response) {
        console.log(response.data);
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
        "goods_name": "按名称搜索",
        "goods_id": "请输入id"
    };

    $scope.toDetail = function(id)
    {
        console.log(id)
        $state.go('goods_detail', {id: id});
    }

});
adminApp.controller("GoodsDetailCtrl",function($scope,$state,GoodsService,$stateParams){
    $scope.goods_id = $stateParams.id;

    $scope.goodsData = {};
    $scope.getGoodsDetail = function(){
        GoodsService.api.getGoodsDetail($scope,"goodsData" ,$scope.goods_id,$scope.spiltAppear)
    };

    $scope.spiltAppear =function(){
        appear = $scope.goodsData.appear;
        first = [];
        second = [];
        if(appear.length!=0){
            var mid =appear.length/2;
            var i = 0;

            while (i<mid)
            {
                first.push(appear[i]);
                i++;
            }
            while(i<appear.length)
            {
                second.push(i);
                i++;
            }
        }
        $scope.showAppear = [first ,second]
        console.log($scope.showAppear)
    };
    $scope.getGoodsDetail()
});
adminApp.controller("MonitorCtrl",function($scope,$state,GoodsService,$stateParams,SelectPage){
    $scope.onload = false;

    $scope.result = {};

    $scope.selectPage = SelectPage;
    $scope.selectPage.limit = {start: 0, num: 10, desc: true,shop_name:""};
    $scope.selectPage.getDataUrl = "./monitor/get";
    $scope.selectPage.getData();
    $scope.selectPage.successCallback = function (response) {
        console.log(response.data);
        $scope.onload = true;
        console.log($scope.selectPage.data)
    };
    $scope.inputList = {
        ":watch_index": "按名称搜索"
    };

    $scope.toggleDetailModal = function(status,single){
        $scope.detail = single;
        $('#monitor_detail').modal(status);
    };
    $scope.toggleAddModal = function(status,id){
        $('#monitor_add').modal(status);
    };
    $scope.add =  function(tmp){
        GoodsService.api.addMonitor(tmp, $scope.selectPage.getData)
    };
    $scope.delete =  function(id){
        GoodsService.api.deleteMonitor(id, $scope.selectPage.getData)
    };



});

