@extends("layout.admin")

@section("content")
    <div ng-controller="IndexCtrl">

        @section('left_nav')
            <div layout="row" flex>

                <md-sidenav class="md-sidenav-left" md-component-id="left"
                            md-disable-backdrop md-whiteframe="4">

                    <md-toolbar class="md-theme-indigo">
                        <h1 class="md-toolbar-tools">功能
                            <md-button class="md-icon-button" aria-label="More"  ng-click="toggleLeft()"style="margin-left: 10px" >
                                <md-icon md-svg-icon="/img/back.svg" ></md-icon>
                            </md-button>

                        </h1>
                    </md-toolbar>

                    <md-content layout-margin>
                        <p>
                            左边侧边栏
                        </p>
                        <md-button ng-click="toggleLeft()" class="md-accent">
                            Close this Sidenav
                        </md-button>
                        <a href=""></a>
                    </md-content>

                </md-sidenav>

                <md-toolbar class="md-menu-toolbar md-whiteframe-4dp" flex>
                    <div layout="row">
                        <md-toolbar-filler layout layout-align="center center">

                        </md-toolbar-filler>

                        <div>

                            <h2 class="md-toolbar-tools">Admin 主页
                                <md-button class="md-icon-button" aria-label="More"  ng-click="toggleLeft()" style="margin-left: 10px" >
                                    <md-icon md-svg-icon="/img/menu.svg" ></md-icon>
                                </md-button>
                                <md-button class="md-icon-button" aria-label="More"  ng-click="toggleLeft()" >
                                    <md-icon md-svg-icon="/img/back.svg" ></md-icon>
                                </md-button>
                            </h2>
                            <md-menu-bar>


                                <md-button  ng-repeat="single in headerNav.navList" ui-sref="@{{ single.url }}">
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

        <script src="/app/controller/basic/index.js"></script>

        <script src="/app/service/header_nav.js"></script>

@append