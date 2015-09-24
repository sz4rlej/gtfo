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
            <span class="glyphicon glyphicon-plus-sign" data-toggle="modal" data-placement="bottom" title="Dodaj nowe hasło!"  data-toggle="modal" data-target="#addNew"></span>
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
<div class="modal fade" id="addNew">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="form-horizontal" method="post">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Dodaj nowego ignora!</h4>
            </div>
            <div class="modal-body">


                    <div class="form-group">
                        <div class="col-sm-12">
                            <input type="text" name="line_1" class="form-control" id="line1" placeholder="Wiersz #1" style="text-align:center">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <input type="text" name="line_2" class="form-control" id="line2" placeholder="Wiersz #2" style="text-align:center">
                        </div>
                    </div>
                <div class="form-group">
                        <div class="col-sm-12">
                            <input type="text" name="author" class="form-control" id="line3" placeholder="Podpis" style="text-align:center">
                        </div>
                    </div>


            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-default">Dodaj!</button>
            </div>

            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>
</body>
</html>