/**
 * Created by keith on 17-1-5.
 */

var adminApp = angular.module('adminApp', ['ui.router', 'ngMaterial', 'ngAnimate']).config(function ($stateProvider, $mdThemingProvider) {
    var first = [
        {
            name: 'index',
            url: '/index',
            controller: 'IndexDetailCtrl',
            templateUrl: '/app/template/admin/index.html'
        },

        {
            name: 'staff',
            url: '/staff',
            controller: 'StaffCtrl',
            templateUrl: '/app/template/admin/staff.html'
        },
        {
            name: 'staff_detail',
            url: '/staff_detail/:id',
            controller: 'StaffDetailCtrl',
            templateUrl: '/app/template/admin/staff_detail.html'
        },
        {
            name: 'position',
            url: '/position',
            controller: 'PositionCtrl',
            templateUrl: '/app/template/admin/position.html'
        },
        {
            name: 'position_detail',
            url: '/position_detail/:id',
            controller: 'PositionDetailCtrl',
            templateUrl: '/app/template/admin/position_detail.html'
        }
    ];

    for (var i in first) {
        // console.log(first[i]);
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


    var nav_list = [{
        name: '员工',
        url: 'staff'

    },
        {
            name: '职位',
            url: 'position'
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


adminApp.controller("StaffCtrl", function ($scope, $http, SelectPage, $state) {

    $scope.onload = false;

    $scope.result = {};

    $scope.selectPage = SelectPage;
    $scope.selectPage.limit = {start: 0, num: 10, desc: true, status: ''};
    $scope.selectPage.getDataUrl = "./staff";
    $scope.selectPage.getDataMethod = "GET";
    $scope.selectPage.getData();
    $scope.selectPage.successCallback = function (response) {
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
        "staff_name": "按名称搜索",
        "staff_id": "请输入id"
    };


    $scope.toGoodsDetail = function (id) {
        $scope.isDetail = true;
        $state.go('staff_detail', {id: id});
    };


    $scope.toggleAddModal = function (status) {
        $('.add_staff').modal(status);
    };

    $scope.addStaff = function (name) {
        $http.post("./addStaff", {
            staff_sex: "男",
            staff_age: "0",
            staff_birth: "1970-01-01",
            staff_cid: "",
            staff_basic_price: 0.0
        }).then(function (res) {
            if (res.data.status == 200) {
                $scope.toGoodsDetail(res.data.data);
            }
        });
    }


});
adminApp.controller("StaffDetailCtrl", function ($scope, $http, SelectPage, $stateParams, $state) {
    console.log($stateParams.id);

    $scope.staff_id = $stateParams.id

    $scope.toList = function () {
        $scope.isDetail = false;
        $state.go('staff');
    };

    $scope.staffData = {}
    $scope.tmp_item = {}
    $scope.getDetail = function () {
        $http.post("./getStaffDetail/" + $scope.staff_id, {}).then(function (res) {
            if (res.data.status == 200) {
                $scope.staffData = res.data.data.staff;
                $scope.staffData.staff_birth = new Date($scope.staffData.staff_birth )

                $scope.position = res.data.data.position;
                $scope.performance = res.data.data.performance;
            }

        });


    };

    $scope.submit = function () {
        // console.log($scope.staffData.staff_birth.valueOf())
        $scope.staffData.staff_birth = $scope.staffData.staff_birth.valueOf() /1000
        $http.post("./updateStaff/" + $scope.staff_id, {params: $scope.staffData}).then(function (res) {
            if (res.data.status == 200) {
                $scope.getDetail();
            }

        });
    };


    $scope.calPerformance = function (date, item) {
        $http.post("./generatePerformance", {
            params: {
                performance_date: date,
                performance_staff: $scope.staff_id,
                item: item
            }
        }).then(function (res) {
            console.log(res)
            if (res.data.status != 500) {
                $scope.getDetail();
            }

        });
    };



    $scope.toggleCalModal = function (status) {
        $('.cal_performance').modal(status);
    };


    $scope.getDetail();

});


adminApp.controller("PositionCtrl", function ($scope, $http, SelectPage, $state) {

    $scope.onload = false;

    $scope.result = {};

    $scope.selectPage = SelectPage;
    $scope.selectPage.limit = {start: 0, num: 10, desc: true, status: ''};
    $scope.selectPage.getDataUrl = "./position";
    $scope.selectPage.getDataMethod = "GET";
    $scope.selectPage.getData();
    $scope.selectPage.successCallback = function (response) {
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
        "position_name": "按名称搜索",
        "position_id": "请输入id"
    };


    // $scope.toGoodsDetail = function (id) {
    //     $scope.isDetail = true;
    //     $state.go('position_detail', {id: id});
    // };


    $scope.toggleModal = function (status,k) {
        if(k!=undefined)
        {
            $scope.tmp_position = $scope.selectPage.data[k]
            console.log($scope.tmp_position)
        }
        else
        {
            $scope.tmp_position = {"items":[],"position_name":""};
        }
        $('.position_manage').modal(status);
    };

    $scope.addItem= function()
    {
        $scope.tmp_position.items.push({
            "item_name":"",
            "item_price":0.0
        })
    };
    $scope.delItem = function(k)
    {
        $scope.tmp_position.items.splice(k,1);
    };

    $scope.submit = function()
    {
        $http.post("./updatePosition",{params:$scope.tmp_position}).then(function (res) {
            console.log(res)
            if (res.data.status != 500) {
                $scope.selectPage.getData();
            }

        });

    };

    $scope.tmp_position = {"items":[],"position_name":""};




});
