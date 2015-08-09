<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Wydupcaj</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
    <link href='http://fonts.googleapis.com/css?family=Kaushan+Script&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="http://local.dev/wydupcaj/public/css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>

<div class="container">
    <div class="row" style="margin-top: 50px; margin-bottom: 100px;">
        <div class="col-md-12 text-center">
            <span class="glyphicon glyphicon-plus-sign" data-toggle="tooltip" data-placement="bottom" title="Dodaj nowe hasło!"></span>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-md-offset-3 text-center">
            <div class="row">
                <div class="col-md-5"><hr /></div>
                <div class="col-md-2 quota">"</div>
                <div class="col-md-5"><hr /></div>
            </div>
            @yield('content')
            <div class="row" style="margin-top: 30px;">
                <div class="col-md-5"><hr /></div>
                <div class="col-md-2 quota">"</div>
                <div class="col-md-5"><hr /></div>
            </div>
        </div>
    </div>
    <div class="row" style="margin-top: 100px;">
        <div class="col-md-12 text-center">
            <span class="brandico-facebook-rect" data-toggle="tooltip" data-placement="bottom" title="Wrzuć na fejsa!"></span>
            <span class="brandico-twitter-bird" data-toggle="tooltip" data-placement="bottom" title="Twitnij to!"></span>
            <span class="brandico-googleplus-rect" data-toggle="tooltip" data-placement="bottom" title="Udostępnij na G+!"></span>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>
</body>
</html>