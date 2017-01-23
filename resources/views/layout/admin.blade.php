<!DOCTYPE html>
<html >
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration</title>
    @section('styles')
        @include("lib.angular_css")
    @show
</head>
<body ng-app="adminApp">

    @section("content")

    @show
    @section('scripts')
        @include("lib.jquery")
        @include("lib.angular_js")
        @include("lib.semantic")
    @show
</body>
</html>