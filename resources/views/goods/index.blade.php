@extends("layout.admin")

@section("content")
    <div ng-controller="IndexCtrl">

        <div layout="row" flex>

            <left-nav data="leftMenu"></left-nav>

            <md-toolbar class="md-menu-toolbar md-whiteframe-4dp" flex>
                <div layout="row">
                    <md-toolbar-filler layout layout-align="center center">

                    </md-toolbar-filler>

                    <div>

                        <h2 class="md-toolbar-tools">Spider


                            <button class="circular ui icon button" style="margin-left: 15px"
                                    ng-click="toggleLeft()">
                                <i class="list layout icon"></i>
                            </button>
                        </h2>

                        <md-button ng-repeat="single in headerNav.navList" ui-sref="@{{ single.url }}">
                            @{{ single.name }}
                        </md-button>
                    </div>


                </div>
            </md-toolbar>

        </div>

        <md-content flex="100" layout-padding ui-view>


        </md-content>

    </div>

@overwrite

@section('scripts')
    @parent


    <script src="/app/controller/goods/index.js"></script>
    <script src="/app/service/goods_service.js"></script>
    <script src="/app/directives/HeadNav/HeadNav.js"></script>
    <script src="/app/directives/LeftNav/LeftNav.js"></script>
    <script src="/app/directives/TableList/TableList.js"></script>


    <script src="/app/service/header_nav.js"></script>
    <script src="/app/service/SelectPageService.js"></script>
    <script src="/app/service/goods_service.js"></script>

    <script src="/app/directives/SelectPageDirectives.js"></script>
    <script src="/app/directives/LoadingMan.js"></script>



@append