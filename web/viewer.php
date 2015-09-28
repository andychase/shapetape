<!doctype html>
<html class="no-js" lang="">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Shapetape - Viewer</title>
    <link rel="stylesheet" type="text/css"
          href="https://cdnjs.cloudflare.com/ajax/libs/normalize/3.0.3/normalize.min.css">
    <style type='text/css'>
        html, body, img {
            -webkit-touch-callout: none;
            -webkit-user-select: none;
            -khtml-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        body {
            height: 100%;
            width: 100%;
            margin: 0;
        }

        .small-logo {
            width: 300px;
            padding-left: 10px;
            padding-right: 10px;
            padding-bottom: 5px;
            padding-top: 5px;
        }

        #img-container {
            position: absolute;
            width: 90%;
            left: 0;
            top: 61px;
        }

        #img-container img {
            display: block;
            width: 100%;
            height: 100%;
        }

        .top {
            z-index: 300;
            background-color: rgba(255, 255, 255, 1);
            position: absolute;
            left: 0;
            top: 0;
            padding-right: 10px;
            margin: 10px;
            height: 60px;
            border: 1px solid black;
        }

        .top label {
            position: relative;
            bottom: 18%;
        }
    </style>
</head>
<body>
<div class="top">
    <a href="/"><img src="img/small_logo.svg" class='small-logo'></a>
    <label>Zoom:<input class="slider" type="range" min="70" max="200" step="1" value="100"/></label>
</div>

<div id="img-container">
    <img src="vec/<?php echo($_GET['v']); ?>.svg" id='placeholder'>
    <img src="vec/<?php echo($_GET['v']); ?>.svg" id='vector'>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="js/viewer.js"></script>
</body>
</html>
