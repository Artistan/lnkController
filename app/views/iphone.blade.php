<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel PHP Framework</title>
    <script src="https://code.jquery.com/jquery-2.1.4.min.js" crossorigin="anonymous"></script>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" integrity="sha256-7s5uDGW3AHqw6xtJmNNtr+OBRJUlgkNJEo78P4b0yRw= sha512-nNo+yCHEyn0smMxSswnf/OnX6/KwJuZTlNZBjauKhTK0c+zT+q5JOCx0UFhXQ6rJR9jg6Es8gPuD2uZcYDLqSw==" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha256-KXn5puMvxCw+dAYznun+drMdG1IFl3agK0p/pqT9KAo= sha512-2e8qq0ETcfWRI4HJBzQiA3UoyFk6tbNyG+qSaIBZLyW9Xf3sWZHN/lxe9fTh1U45DpPf07yj94KsUHHWe4Yk1A==" crossorigin="anonymous"></script>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha256-3dkvEK0WLHRJ7/Csr0BZjAWxERc5WH7bdeUya2aXxdU= sha512-+L4yy6FRcDGbXJ9mPG8MT/3UCDzwR9gPeyFNMCtInsol++5m3bk2bXWKdZjvybmohrAsn3Ua5x8gfLnbE1YkOg==" crossorigin="anonymous">
    <link href="https://maxcdn.bootstrapcdn.com/bootswatch/3.3.6/yeti/bootstrap.min.css" rel="stylesheet" integrity="sha256-daEYF2SGTkiPl4cmxH06AOMnZ+Hb8wBpvs7DqvceszY= sha512-xmSDqcgDrroCG8Sp/p0IArjjB3lO0m0Yde0tm1mOFD4BwmsvZnVNfHgw7icU6q4ScrTCQKCokxnYMy/hUUfGrg==" crossorigin="anonymous">

    <script type="text/javascript" src="js/jsqrcode/src/bitmat.js"></script>
    <script type="text/javascript" src="js/jsqrcode/src/grid.js"></script>
    <script type="text/javascript" src="js/jsqrcode/src/qrcode.js"></script>
    <script type="text/javascript" src="js/jsqrcode/src/findpat.js"></script>
    <script type="text/javascript" src="js/jsqrcode/src/detector.js"></script>
    <script type="text/javascript" src="js/jsqrcode/src/gf256poly.js"></script>
    <script type="text/javascript" src="js/jsqrcode/src/gf256.js"></script>
    <script type="text/javascript" src="js/jsqrcode/src/rsdecoder.js"></script>
    <script type="text/javascript" src="js/jsqrcode/src/decoder.js"></script>
    <script type="text/javascript" src="js/jsqrcode/src/version.js"></script>
    <script type="text/javascript" src="js/jsqrcode/src/formatinf.js"></script>
    <script type="text/javascript" src="js/jsqrcode/src/errorlevel.js"></script>
    <script type="text/javascript" src="js/jsqrcode/src/datablock.js"></script>
    <script type="text/javascript" src="js/jsqrcode/src/bmparser.js"></script>
    <script type="text/javascript" src="js/jsqrcode/src/datamask.js"></script>
    <script type="text/javascript" src="js/jsqrcode/src/alignpat.js"></script>
    <script type="text/javascript" src="js/jsqrcode/src/databr.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

    <![endif]-->
    <script>
        qrcode.callback = function(data){
            jQuery('#qrdata').html(data);
        }
        var loadFile = function(event) {
            var url = URL.createObjectURL(event.target.files[0]);
            qrcode.decode(url);
        };
    </script>
    <style>

        body {
            color: #4a4a4a;
            padding-top: 70px;
        }

        .search {
            margin: 10px 100px;
        }

        a, a:visited {
            text-decoration:none;
        }

        h1 {
            font-size: 32px;
            margin: 16px 0 0 0;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">qrcode - iphone</a>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li>
                    <a data-toggle="collapse" href="/" aria-expanded="false" aria-controls="collapseForm">
                        HOME
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="jumbotron">
    <div class="container">

        <form action="">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Select Images:
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="imagex">Image</label>
                                <input type="file" id="imagex" accept="image/*" onchange="loadFile(event)">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">
                    QRCode Data:
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-12" id="qrdata">

                        </div>
                    </div>
                </div>
            </div>

        </form>

    </div>
</div>
</body>
</html>
