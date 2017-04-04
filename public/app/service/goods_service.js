/**
 * Created by jedi on 17-3-25.
 */
adminApp
    .factory("GoodsService", function ($http, toaster) {
        function handle_result(response) {
            if (response.data.status == 200) {
                toaster.pop({
                    type: 'success',
                    title: '成功',
                    body: response.data.message,
                    timeout: 1000
                });
            }
            else {
                toaster.pop({
                    type: 'error',
                    title: '失败',
                    body: response.data.message,
                    timeout: 3000
                });

            }
        }

        var basicUrl = "/goods";
        $scope = {
            constVal: {

            },
            api: {
                getShopDetail: function (scope, bindval) {
                    scope.loaded = false;
                    var callback = function (res) {
                        // handle_result(res)
                        if (res.data.status == 200) {
                            scope[bindval] = res.data.data
                            scope.loaded = true;
                        }

                    };

                    $http.get(basicUrl + "/shop/detail").then(callback);
                },
                resetShopPasswd: function (data) {

                    var callback = function (res) {
                        handle_result(res);

                    };

                    $http.post(basicUrl + "/shop/resetPassword",{params:data}).then(callback);
                },
                getGoodsDetail:function(scope, bindval,id,before){
                    scope.loaded = false;
                    var callback = function (res) {
                        // handle_result(res)
                        if (res.data.status == 200) {
                            scope[bindval] = res.data.data
                            scope.loaded = true;
                            before()

                        }

                    };

                    $http.get(basicUrl + "/goods/detail/"+id).then(callback);
                },
                addMonitor:function(data,back){

                    $http.post(basicUrl + "/monitor/add",{params:data}).then(handle_result);
                    back();
                },
                deleteMonitor:function(id,back){
                    $http.get(basicUrl + "/monitor/delete/"+id).then(handle_result);
                    back();
                }

            }
        }
        return $scope


    })