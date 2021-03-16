<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Error General</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.0/css/bootstrap.min.css" rel="stylesheet" type="text/css" media="all" />
        <link href="https://www.codepolitan.com/themes/belajarcoding/assets/css/stack-interface.css" rel="stylesheet" type="text/css" media="all" />
        <link href="https://www.codepolitan.com/themes/belajarcoding/assets/css/theme-serpent.css" rel="stylesheet" type="text/css" media="all" />
        <link href="https://www.codepolitan.com/themes/belajarcoding/assets/css/custom.css" rel="stylesheet" type="text/css" media="all" />
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:200,300,400,400i,500,600,700" rel="stylesheet">

    </head>
    <body data-smooth-scroll-offset="77">
        <div class="nav-container"> </div>
        <div class="main-container">
            <section class="height-100 bg--info text-center">
                <div class="container pos-vertical-center">
                    <div class="row">
                        <div class="col-md-12">
                        	<h1><?php echo $heading; ?></h1>
							<p><?php echo $message; ?></p>
						</div>
                    </div>
                </div>
            </section>
        </div>

    </body>

</html>