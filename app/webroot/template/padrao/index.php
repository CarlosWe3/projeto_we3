<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
		Remove this if you use the .htaccess -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<title><?php echo $this->titulo ?></title>
		<meta name="description" content="" />
		<meta name="author" content="Ricardo" />
		<meta name="viewport" content="width=device-width; initial-scale=1.0" />
		<!-- Replace favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->
		<link rel="shortcut icon" href="/favicon.ico" />
		<link rel="apple-touch-icon" href="/apple-touch-icon.png" />
	</head>
	<body>
		<div>
			<header>
				<h1><?php echo $this->titulo ?></h1>
			</header>

			<div>
				<?php require($path_view) ?>
			</div>
			
			<footer>
				<p>
					&copy; Copyright  by Carlos
				</p>
			</footer>
		</div>
	</body>
</html>