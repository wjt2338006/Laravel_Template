/**
 * Created by keith on 17-1-6.
 */
adminApp.config(function($stateProvider){
    var goods_list = {
        name: 'goods_list',
        url: '/goods_list',
        controller:'goods_list',
        templateUrl:'/app/template/admin/goods_list.html'
    };

    $stateProvider.state(goods_list);
});