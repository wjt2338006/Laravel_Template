@extends("layout.admin")

@section("content")
    <div ng-controller="IndexCtrl">

        @section('left_nav')
            <div layout="row" flex>

              @include("components.left_nav")

                <md-toolbar class="md-menu-toolbar md-whiteframe-4dp" flex>
                    <div layout="row">
                        <md-toolbar-filler layout layout-align="center center">

                        </md-toolbar-filler>

                        <div>

                            <h2 class="md-toolbar-tools">商品和店铺

                                <button class="circular ui icon button" ng-click="logout()"
                                        style="margin-left: 15px">
                                    <i class="erase icon"></i>
                                </button>
                                <button class="circular ui icon button" ng-click="toggleLeft()">
                                    <i class="reply icon"></i>
                                </button>
                                {{--<div class="ui breadcrumb" style="margin-left: 15px">--}}
                                    {{--<a class="section">Home</a>--}}
                                    {{--<i class="right angle icon divider"></i>--}}
                                    {{--<a class="section">Store</a>--}}
                                    {{--<i class="right angle icon divider"></i>--}}
                                    {{--<div class="active section">T-Shirt</div>--}}
                                {{--</div>--}}


                            </h2>

                            <md-menu-bar layout="row">


                                <md-button ng-repeat="single in headerNav.navList" ui-sref="@{{ single.url }}">
                                    @{{ single.name }}
                                </md-button>


                            </md-menu-bar>
                        </div>


                    </div>
                </md-toolbar>

            </div>
        @show
        <md-content flex="100" layout-padding ui-view>


        </md-content>

    </div>

@overwrite

@section('scripts')
    @parent
    <script src="/app/controller/goods/index.js"></script>


    <script src="/app/service/header_nav.js"></script>
    <script src="/app/service/SelectPageService.js"></script>
    <script src="/app/service/admin_service.js"></script>

    <script src="/app/directives/SelectPageDirectives.js"></script>
    <script src="/app/directives/LoadingMan.js"></script>



@append