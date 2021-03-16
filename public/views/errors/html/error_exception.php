<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Error Exception</title>
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
		<section class="height-100 bg--dark text-center">
			<div class="container pos-vertical-center">
				<div class="row">
					<div class="col-md-12">
						<h4>An uncaught Exception was encountered</h4>

						<p>Type: <?php echo get_class($exception); ?></p>
						<p>Message: <?php echo $message; ?></p>
						<p>Filename: <?php echo $exception->getFile(); ?></p>
						<p>Line Number: <?php echo $exception->getLine(); ?></p>

						<?php if (defined('SHOW_DEBUG_BACKTRACE') && SHOW_DEBUG_BACKTRACE === TRUE): ?>

							<p>Backtrace:</p>
							<?php foreach ($exception->getTrace() as $error): ?>

								<?php if (isset($error['file'])):// && strpos($error['file'], realpath(BASEPATH)) !== 0): ?>

								<p style="margin-left:10px">
									File: <?php echo $error['file']; ?><br />
									Line: <?php echo $error['line']; ?><br />
									Function: <?php echo $error['function']; ?>
								</p>
							<?php endif ?>

						<?php endforeach ?>

					<?php endif ?>
				</div>
			</div>
		</div>
	</section>
</div>

</body>

</html>