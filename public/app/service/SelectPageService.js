/**
 * Created by RagPanda on 2016/3/15.
 */
adminApp
    .factory("SelectPage", function ($http) {

        var func = function () {
            var $scope = {};
            //限制
            $scope.limit = {start: 0, num: 10, desc: true};
            $scope.getDataUrl = "";
            $scope.getDataMethod = "GET";
            $scope.getTime = 0;

            //失败和成功的回调函数
            $scope.successCallback = function (response) {
            };
            $scope.errorCallback = function (response) {
            };
            $scope.pageOverflowCallback = function (topOverflow) {
            };//超页触发 false是前溢出，true是后溢出
            $scope.beforeSubmit = function (limit) {

            }

            //接收数据
            $scope.data = [];
            $scope.message = "";
            $scope.status = null;
            $scope.total = null;
            $scope.fixedPage = 0;

            $scope.page = {};

            //缓存
            $scope.lastCache = [];
            $scope.lastCacheMaxLength = 5;
            $scope.nextCache = [];
            $scope.nextCacheMaxLength = 5;


            //获取数据
            $scope.getData = function () {
                $limit = jQuery.extend(true, {}, $scope.limit);

                $scope.promise = {};
                $scope.beforeSubmit($limit)
                //更换请求方法
                if ($scope.getDataMethod == "GET") {
                    //var url = $scope.getDataUrl;
                    //url+="?";
                    //for(var i in $scope.limit)
                    //{
                    //    url += "&" + i + "=";
                    //    url += $scope.limit[i] ;//+ "&";
                    //
                    //};
                    var url = $scope.getDataUrl + "?params=" + JSON.stringify($limit);
                    var promise = $http.get(url);
                }
                if ($scope.getDataMethod == "POST") {
                    var promise = $http.post($scope.getDataUrl, {params: $limit});
                }

                //完成请求的回调
                promise.then(function (response) {
                    if (response.status == 200) {

                        response = response.data;
                        $scope.data = response.data;
                        if(response.resetStart){
                            $limit.start = 0;
                            $scope.limit.start = 0;
                        }

                        $scope.message = response.message;
                        $scope.status = response.status;
                        $scope.total = response.total;
                        $scope.sourceResponse = response;
                        $scope.page.nowPage = parseInt($limit.start / $limit.num + 1);
                        $scope.page.totalPage = parseInt($scope.total / $limit.num);
                        $scope.fixedPage = $scope.page.nowPage;
                        $scope.sourceResponse = response;
                        if ($scope.total % $limit.num != 0) {
                            $scope.page.totalPage += 1;
                        }
                        $scope.getTime += 1;
                        $scope.successCallback(response);
                    }
                    else {
                        $scope.status = false;
                        $scope.errorCallback(response);
                    }

                });

            };

            //改变限制条件
            $scope.changeLimit = function (key, value) {
                if (value == null) {
                    delete $scope.limit[key];
                }
                else {
                    $scope.limit[key] = value;
                }

                $scope.getData();
            };


            //切换正序反序
            $scope.toggleSort = function () {
                if ($scope.limit["desc"] == true) {
                    delete  $scope.limit["desc"];
                }
                else {
                    $scope.limit["desc"] = true;
                }
                ;
                $scope.getData();
            };

            //切换审核和未审核 zc 增加
            $scope.toggleCheck = function () {
                if ($scope.limit["check"] == true) {
                    delete  $scope.limit["check"];
                }
                else {
                    $scope.limit["check"] = true;
                }
                ;
                $scope.getData();
            };


            //下一页
            $scope.nextPage = function () {
                $scope.limit.start += $scope.limit.num;
                if ($scope.limit.start >= $scope.total) {
                    $scope.pageOverflowCallback(true);
                }
                $scope.getData();
            };
            //上一页
            $scope.previousPage = function () {
                $scope.limit.start -= $scope.limit.num;
                if ($scope.limit.start < 0) {
                    $scope.pageOverflowCallback(false);
                }
                $scope.getData();
            };

            $scope.jumpFixedPage = function () {
                var fixedPage = parseInt($scope.fixedPage);

                if (fixedPage == fixedPage) {
                    if (fixedPage < 1) {
                        fixedPage = 1
                    }

                    if (fixedPage > $scope.page.totalPage) {
                        fixedPage = $scope.page.totalPage
                    }

                    $scope.limit.start = $scope.limit.num * (fixedPage - 1);
                }

                if ($scope.limit.start >= $scope.total) {
                    $scope.pageOverflowCallback(true);
                }

                if ($scope.limit.start < 0) {
                    $scope.pageOverflowCallback(false);
                }

                $scope.getData();
            };

            // //存储到 前队列
            // $scope.saveLastData = function () {
            //     if ($scope.getTime > 0) {
            //         var obj = {};
            //         obj.data = jQuery.extend(true, {}, $scope.data);
            //         obj.limit = jQuery.extend(true, {}, $scope.limit);
            //         obj.page = jQuery.extend(true, {}, $scope.page);
            //         obj.total = $scope.total;
            //         $scope.lastCache.push(obj);
            //         if ($scope.lastCache.length > $scope.lastCacheMaxLength) {
            //             $scope.lastCache.splice(0, 1);
            //         }
            //     }
            // };
            // //取出缓存从 前队列
            // $scope.getLastData = function () {
            //     if ($scope.lastCache.length > 0) {
            //         $scope.saveNextData();
            //         $obj = $scope.lastCache.pop();
            //         $scope.data = $obj.data;
            //         $scope.limit = $obj.limit;
            //         $scope.page = $obj.page;
            //         $scope.total = $obj.total;
            //     }
            // };
            // //存储到 后队列
            // $scope.saveNextData = function () {
            //     var obj = {};
            //     obj.data = jQuery.extend(true, {}, $scope.data);
            //     obj.limit = jQuery.extend(true, {}, $scope.limit);
            //     obj.page = jQuery.extend(true, {}, $scope.page);
            //     obj.total = $scope.total;
            //     $scope.nextCache.push(obj);
            //     if ($scope.nextCache.length > $scope.nextCacheMaxLength) {
            //         $scope.nextCache.splice(0, 1);
            //     }
            // };
            // //从后队列 取出
            // $scope.getNextData = function () {
            //     if ($scope.nextCache.length > 0) {
            //         $scope.saveLastData();
            //         $obj = $scope.nextCache.pop();
            //         $scope.data = $obj.data;
            //         $scope.limit = $obj.limit;
            //         $scope.page = $obj.page;
            //         $scope.total = $obj.total;
            //     }
            // };
            return $scope;
        };
        return func();

    });