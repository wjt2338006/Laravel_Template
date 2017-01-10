@extends("layout.admin")

@section("content")
    <div ng-controller="IndexCtrl">

        <div layout="row" flex>

            <md-sidenav class="md-sidenav-left" md-component-id="left"
                        md-disable-backdrop md-whiteframe="4" >

                <md-toolbar class="md-theme-indigo">
                    <h1 class="md-toolbar-tools">功能</h1>
                </md-toolbar>

                <md-content layout-margin>
                    <p>
                        左边侧边栏
                    </p>
                    <md-button ng-click="toggleLeft()" class="md-accent">
                        Close this Sidenav
                    </md-button>
                </md-content>

            </md-sidenav>

            <md-toolbar class="md-menu-toolbar md-whiteframe-4dp" flex>
                <div layout="row">
                    <md-toolbar-filler layout layout-align="center center">

                    </md-toolbar-filler>

                    <div>

                        <h2 class="md-toolbar-tools">主页</h2>
                        <md-menu-bar>
                            <md-button aria-label="Go Back">
                                Go Back
                            </md-button>
                            <md-button ng-click="toggleLeft()">
                                Toggle Left Sidenav
                            </md-button>
                            <md-button ui-sref="goods_list" ui-sref-active="active">GoodsList</md-button>
                        </md-menu-bar>
                    </div>


                </div>
            </md-toolbar>

        </div>
        <md-content flex="100" layout-padding>


            <ui-view flex="100"></ui-view>

            {{--<div layout="row" layout-align="top center">--}}


                {{--<div flex="30"  >--}}
                    {{--1--}}
                {{--</div>--}}
                {{--<div flex="30" flex-offset="15" flex-order="0">--}}
                    {{--2--}}
                {{--</div>--}}
                {{--<div >--}}
                    {{--3--}}
                {{--</div>--}}

            {{--</div>--}}

        </md-content>
        <style>.active { color: red; font-weight: bolder; }</style>
    </div>

@overwrite

@section('scripts')
    @parent
    <script src="/app/app.js"></script>
    <script src="/app/router/admin.js"></script>
    <script src="/app/controller/admin/index.js"></script>
    <script src="/app/controller/admin/goods/goods_list.js"></script>
    {{--<script src="/app/components/admin/goods_list.js"></script>--}}

@append