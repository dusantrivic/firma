<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<h1>Your code is {{$kod}}  </h1>
<h5>To Actiate clikc on this link: <a href="{{ route('user.verificate.form', [$user->id, $kod]) }}" target="__blank">CLICK HERE</a></h5>

</body>
</html>
