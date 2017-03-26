/**
 * Created by jedi on 17-3-25.
 */
adminApp
    .factory("AdminService", function ($http, toaster) {
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

        var basicUrl = "/admin";
        $scope = {
            constVal: {
                powerGroupStatus: {
                    "normal": "正常",
                    "forbid": "限制"
                }
            },
            api: {
                getPowerDetail: function (scope, bindval, params) {
                    scope.loaded = false;
                    var callback = function (res) {
                        handle_result(res)
                        if (res.data.status == 200) {
                            scope[bindval] = res.data.data
                            scope.loaded = true;
                        }

                    };

                    $http.get(basicUrl + "/powerGroup/detail/" + params.group_id).then(callback);
                },
                getPowerPermit: function (scope, bindvar,before) {
                    var callback = function (res) {
                        // handle_result(res)
                        if (res.data.status == 200) {
                            scope[bindvar] = res.data.data
                            if(before!=undefined)
                            {
                                before()
                            }

                        }

                    };
                    $http.get(basicUrl + "/powerGroup/permit").then(callback);
                },
                getAdmin:function (scope, bindvar,params) {
                    var callback = function (res) {
                        // handle_result(res)
                        if (res.data.status == 200) {
                            scope[bindvar] = res.data.data
                        }


                    };
                    $http.get(basicUrl + "/get?params=" + JSON.stringify(params)).then(callback);
                },
                updatePowerPermit:function(params,before)
                {
                    var callback = function (res) {
                        handle_result(res);
                        if (res.data.status == 200) {
                            before()
                        }
                    };
                    $http.post(basicUrl+"/powerGroup/update",{params:params}).then(callback)
                }
            }
        }
        return $scope


    })