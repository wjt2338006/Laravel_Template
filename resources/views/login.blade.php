@extends("layout.admin")

@section('content')


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
