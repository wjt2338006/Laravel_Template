@extends("layout.admin")

@section('content')




    {{--<div class="ui three column grid" ng-controller="LoginCtrl" >--}}
        {{--<div class="row" style="position: absolute;width: 100%;height:100%;z-index: -1;"> <img src="/img/login_back.jpg" alt="" style="width:100%;height:100%"></div>--}}
        {{--<div class="row" style="height:200px"> </div>--}}

        {{--<div class="column"></div>--}}
        {{--<div class="column">--}}
            {{--<div class="ui fluid card" style="padding: 10px">--}}
                {{--<h1 class="centered">登录</h1>--}}
                {{--<form class="ui form ">--}}
                    {{--<div class="field">--}}
                        {{--<label>用户名</label>--}}
                        {{--<input type="text"  ng-model="username" placeholder="Username">--}}
                    {{--</div>--}}
                    {{--<div class="field">--}}
                        {{--<label>密码</label>--}}
                        {{--<input type="password" ng-model="password" placeholder="Password">--}}
                    {{--</div>--}}

                    {{--<button class="ui button" type="submit" ng-click="login()">提交</button>--}}
                {{--</form>--}}
            {{--</div>--}}


        {{--</div>--}}
        {{--<div class="column"></div>--}}
    {{--</div>--}}

    <div ng-controller="LoginCtrl"  layout="column" style="background:url('/img/login_back.jpg');height: 100%; background-repeat: no-repeat;background-size: cover;ackground-attachment: fixed;" >
        <div flex="25" ></div>
        <div flex="60" class="row" layout="row" >
            <div flex="33"></div>
            <div flex="33">
                <md-card>
                    <md-card-title>
                        <md-card-title-text>
                            <span class="md-headline">Login</span>
                        </md-card-title-text>
                    </md-card-title>
                    <md-card-content>
                        <md-input-container class="md-block">
                            <label>用户名</label>
                            <input  ng-model="username" >
                        </md-input-container>

                        <md-input-container  class="md-block">
                            <label>密码</label>
                            <input type="password" ng-model="password" >
                        </md-input-container>
                        <md-input-container  class="md-block">
                            <md-button class="md-raised md-primary" ng-click="login()" >提交</md-button>
                        </md-input-container>


                    </md-card-content>
                </md-card>
            </div>
            <div flex="33"></div>
        </div>
        <div flex="15" ></div>
    </div>


@endsection

@section('scripts')
    @parent
    <script src="/app/controller/login.js"></script>
@endsection
