<md-sidenav class="md-sidenav-left" md-component-id="left"
            md-disable-backdrop md-whiteframe="4">

    <md-toolbar class="md-theme-indigo">
        <h1 class="md-toolbar-tools">功能模块
            <md-button class="md-icon-button" aria-label="More" ng-click="toggleLeft()"
                       style="margin-left: 10px">
                <md-icon md-svg-icon="/img/back.svg"></md-icon>
            </md-button>

        </h1>
    </md-toolbar>

    <md-content >
        <md-card>
            <img ng-src="/img/elyse.png" class="md-card-image" alt="Washed Out">
            <md-card-title>
                <md-card-title-text>
                    <span class="md-headline">RagPanda</span>
                </md-card-title-text>
            </md-card-title>
            <md-card-content>
                <p>
                    店铺: 京东世纪店

                </p>
                <p>
                    最近登录时间: 2017-01-02 19:02:22
                </p>
            </md-card-content>
            <md-card-actions layout="row" layout-align="end center">
                <md-button class="md-icon-button" aria-label="Share">
                    <i class="power icon"></i>
                </md-button>
            </md-card-actions>
        </md-card>
        <md-list flex>


            <md-list-item class="md-1-line" ng-repeat="p in leftNav"
                          ng-click="toModule(p.url)">
                <md-button class="md-secondary md-icon-button"  aria-label="call">
                    <i class="@{{ p.icon }}"></i>
                </md-button>

                <div class="md-list-item-text" layout="column">
                    <h3>@{{ p.name }}</h3>
                </div>
            </md-list-item>

        </md-list>

        {{--<md-button ng-click="toggleLeft()" class="md-accent">--}}
        {{--Close this Sidenav--}}
        {{--</md-button>--}}

    </md-content>

</md-sidenav>