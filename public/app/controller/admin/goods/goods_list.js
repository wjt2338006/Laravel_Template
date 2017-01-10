/**
 * Created by keith on 17-1-9.
 */
adminApp.controller('goods_list', function ($scope) {
    console.log('hi');
    $scope.goods_list = [
        {
            "data_name": "巨大号",
            "data_price": "19.0",
            "dara_detail_url": "www.sss.com"
        },
        {
            "data_name": "巨大号",
            "data_price": "19.0",
            "dara_detail_url": "www.sss.com"
        },
        {
            "data_name": "巨大号",
            "data_price": "19.0",
            "dara_detail_url": "www.sss.com"
        },
        {
            "data_name": "巨大号",
            "data_price": "19.0",
            "dara_detail_url": "www.sss.com"
        }
    ];

    $scope.currentNavItem = 'page1';
});