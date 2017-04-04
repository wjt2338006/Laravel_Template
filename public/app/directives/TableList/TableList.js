/**
 * Created by keith on 17-3-31.
 */
adminApp.directive('tableList', function () {
        /*
         {
         method:"GET",
         url:"/sss",
         inputFilter:[{type:"text","key":"group_name","name":"按照名字"}]
         selectFilter:[{key: "", option:[{name: "选择所有类型",value=""},{name: "高级权限",value:2]}]
         table:{"数据1":"admin_group","数据2":"admin_id"},
         add:[{"type":"text","key":"group_id",name:"组id"}]
         add_url:"",
         update:function(id){},
         detail:function(id){},
         delete:function(id){},
         pk:"goods_id"
         ,     }
         */
        return {
            restrict: "EA",
            scope: {
                params: "="
            },
            templateUrl: "/static/app/directives/TableList/TableList.html",
            controller: function ($scope, SelectPage,$http,toaster) {

                $scope.page = SelectPage;
                $scope.page.onload = false;
                $scope.page.limit = {$start: 0, $num: 10, $desc: true};
                $scope.page.getDataUrl = $scope.params.url;
                $scope.page.getDataMethod = "GET";
                $scope.page.successCallback = function (response) {
                    $scope.page.onload = true;
                };
                $scope.getData = function () {
                    $scope.page.onload = false;
                    $scope.page.getData();
                };
                console.log($scope.params)
                $scope.getData()

                $scope.toggleAdd = function (status) {
                    $('#add_modal').modal(status);
                };
                $scope.toggleDel = function (status, id) {
                    $scope.willDelId = id
                    $('#del_modal').modal(status);
                };

                $scope.add_data = {}
                $scope.addRequest = function () {
                    $http.post($scope.params.add_url, $scope.add_data).then(function (res) {
                        if (res.data.status === 0) {
                            toaster.pop({
                                type: 'success',
                                title: '成功',
                                body: res.data.message,
                                timeout: 1000
                            });
                            $scope.params.detail(res.data.data)
                        }
                        else {
                            toaster.pop({
                                type: 'error',
                                title: '失败',
                                body: res.data.message,
                                timeout: 3000
                            });
                        }

                    });
                };
                $scope.delete = function(id){
                    $http.get($scope.params.delete_url+"/"+id).then(function(res){
                        if (res.data.status === 0) {
                            toaster.pop({
                                type: 'success',
                                title: '成功',
                                body: res.data.message,
                                timeout: 1000
                            });
                        }
                        else {
                            toaster.pop({
                                type: 'error',
                                title: '失败',
                                body: res.data.message,
                                timeout: 3000
                            });
                        }

                        $scope.getData()
                    })
                }


            },
            link: function ($scope, element, attrs) {

            }
        }
    }
);

adminApp.service('tableList', function ($mdSidenav) {
    var self = {};
    self.toggleLeft = function () {
        $mdSidenav('left').toggle();
    };
    return self;
});