/**
 * Created by keith on 17-1-5.
 */

var adminApp = angular.module('adminApp', ['ui.router', 'ngMaterial', 'ngAnimate']).config(function ($stateProvider) {
    var first = [
        {
            name: 'auth',
            url: '/auth',
            controller: 'AuthCtrl',
            templateUrl: '/app/template/basic/auth/index.html'
        },

        {
            name: 'auth.user',
            url: '/user',
            controller: 'UserCtrl',
            templateUrl: '/app/template/basic/auth/user.html'
        },
        {
            name: 'auth.admin',
            url: '/admin',
            controller: 'AdminCtrl',
            templateUrl: '/app/template/basic/auth/admin.html'
        },
        {
            name: 'goods',
            url: '/goods',
            controller: 'GoodsIndexCtrl',
            templateUrl: '/app/template/basic/goods/index.html'
        },
        {
            name: 'goods.detail',
            url: '/goods_detail/:id',
            controller: 'GoodsDetailCtrl',
            templateUrl: '/app/template/basic/goods/detail.html'
        }
    ];

    for (var i in first) {
        // console.log(first[i]);
        $stateProvider.state(first[i]);
    }

});

adminApp.controller("IndexCtrl", function ($scope, $mdSidenav,HeaderNav,$http) {
    $scope.welcome = "hellow";

    $scope.toggleLeft = function () {
        $mdSidenav('left').toggle();
    };
    $scope.toggleRight = function () {
        $mdSidenav('right').toggle();
    };


    var nav_list = [{
            name: '权限',
            url: 'auth'

        },
        {
            name: '交易',
            url: 'order'
        },
        {
            name: '商品',
            url: 'goods'
        }
        ];
    HeaderNav.flush(nav_list);
    $scope.headerNav = HeaderNav;





});



adminApp.controller("AuthCtrl", function ($scope, $mdSidenav) {

    $scope.welcome = "this is Auth";


});
adminApp.controller("UserCtrl", function ($scope, $mdSidenav) {
    $scope.goods_list = [
        {
            data_name: "xx",
            data_price: "xs",
            data_url: "xs"
        }
    ];
    $scope.welcome = "this is user";


});
adminApp.controller("AdminCtrl", function ($scope, $mdSidenav) {
    $scope.welcome = "this is admin";


});