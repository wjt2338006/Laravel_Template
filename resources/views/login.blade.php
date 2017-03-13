@extends("layout.admin")

@section('content')
    <md-card ng-controller="LoginCtrl">
        <md-card-title>

            <h1>登录</h1>
        </md-card-title>
        <md-card-content >

            <form class="ui form">
                <div class="field">
                    <label>用户名</label>
                    <input type="text"  ng-model="username" placeholder="Username">
                </div>
                <div class="field">
                    <label>密码</label>
                    <input type="password" ng-model="password" placeholder="Password">
                </div>

                <button class="ui button" type="submit" ng-click="login()">提交</button>
            </form>
        </md-card-content>
    </md-card>

@endsection

@section('scripts')
    @parent
    <script src="/app/controller/login.js"></script>
@endsection
