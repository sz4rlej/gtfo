<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Wydupcaj</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
    <link href='http://fonts.googleapis.com/css?family=Kaushan+Script&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="/css/style.css">
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
        <div class="col-md-8 col-md-offset-2 text-center">
            <div class="row">
                <div class="col-md-1"><span class="glyphicon glyphicon-chevron-left changeQuote" data-direction="previous" id="previusQuote"></span></div>
                <div class="col-md-10">
                    <div class="row">
                        <div class="col-md-5"><hr /></div>
                        <div class="col-md-2 quota">"</div>
                        <div class="col-md-5"><hr /></div>
                    </div>
                    <div class="row" id="quota">
                        <div class="quota-text" id="line_1">{{$line_1}}</div>
                        <div class="quota-text" id="line_2">{{$line_2}}</div>
                        <div class="quota-author" id="author">• {{$author}} •</div>
                        <div class="quota-hash" id="hash" data-hash="{{$hash}}"></div>
                    </div>
                    <div class="row" style="margin-top: 30px;">
                        <div class="col-md-5"><hr /></div>
                        <div class="col-md-2 quota">"</div>
                        <div class="col-md-5"><hr /></div>
                    </div>
                    <div class="row">
                        <div class="col-md-5 text-right">
                            <span class="glyphicon glyphicon-thumbs-up vote" data-vote="1"></span>
                        </div>
                        <div class="col-md-2">
                            <span class="votes">{{$votes}}</span>
                        </div>
                        <div class="col-md-5 text-left">
                            <span class="glyphicon glyphicon-thumbs-down vote" data-vote="0""></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <input type="text" value="http://wydupcaj.pl/{{$hash}}" class="link" onClick="this.select();"/>
                        </div>
                    </div>
                </div>
                <div class="col-md-1"><span class="glyphicon glyphicon-chevron-right changeQuote" data-direction="next" id="nextQuote"></span></div>
            </div>
        </div>
    </div>
    <div class="row" style="margin-top: 100px;">
        <div class="col-md-12 text-center">
        </div>
    </div>
</div>
<div class="modal fade" id="addNew">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="form-horizontal" method="post" action="/">
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
        $('[data-toggle="tooltip"]').tooltip();

        $('.changeQuote').click(function() {

            var direction = $(this).data('direction');

            $.ajax({
                url: '/json/' + direction + '/' + $('#hash').data('hash'),
                data: {
                    format: 'json'
                },
                error: function() {
                    console.log('error :/');
                },
                success: function(data) {

                    if(data.status == 'ok')
                    {
                        $('#quota, .votes').fadeOut(function() {
                            $('#line_1').text(data.data.line_1);
                            $('#line_2').text(data.data.line_2);
                            $('#author').text(data.data.author);
                            $('#hash').data('hash', data.data.hash);
                            $('.votes').text(data.data.votes);
                            $('.link').val('http://wydupcaj.pl/' + data.data.hash);
                        });
                    }
                    $('#quota, .votes').fadeIn();
                },
                type: 'GET'
            });
        });

        $('.vote').click(function() {

            var vote = $(this).data('vote');

            $.ajax({
                url: '/vote/' + $('#hash').data('hash')  + '/' + vote,
                data: {
                    format: 'json'
                },
                error: function() {

                },
                success: function(data) {

                    if(data.status == 'ok')
                    {
                        $('.votes').fadeOut(function() {
                            $('.votes').text(data.data.votes);
                        });
                    }
                    $('.votes').fadeIn();

                    if(data.status == 'error') {

                        $('.votes')
                                .animate({ marginLeft: "+=4" }, 100 )
                                .animate({ marginLeft: "-=8" }, 100 )
                                .animate({ marginLeft: "+=4" }, 100 );
                    }
                },
                type: 'GET'
            });
        });

    })
</script>
<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-68207115-1', 'auto');
    ga('send', 'pageview');

</script>
</body>
</html>