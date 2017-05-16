<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">

		<title><?= APP_NAME ?></title>

		<link rel="icon" type="image/gif" href="<?= url_for('/webroot/favicon.ico') ?>" />
		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		<link href="<?= url_for('/webroot/css/sm.css') ?>" rel="stylesheet">
	</head>
	<body>

		<div class="container">
			<div class="row">
				<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
					<div class="container-fluid">
						<div class="navbar-header">
							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-admin">
								<span class="sr-only">Toggle Menu</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
							<a class="navbar-brand" href="<?= url_for('/') ?>">
								<img src="<?= url_for('/') ?>/webroot/images/strangemetrics_iso.png" alt="<?= APP_NAME ?>" />
							</a>
						</div><!--/.navbar-header -->
						<div class="collapse navbar-collapse" id="navbar-admin">
							<ul class="nav navbar-nav">
								<li<?php if($section=='dashboard') { echo ' class="active"'; } ?>><a href="<?= url_for('/') ?>"><span class="glyphicon glyphicon-dashboard"></span> Dashboard</a></li>
								<li<?php if($section=='settings') { echo ' class="active"'; } ?>><a href="<?= url_for('/settings') ?>"><span class="glyphicon glyphicon-cog"></span> Settings</a></li>
								<li<?php if($section=='analysis') { echo ' class="active"'; } ?>><a href="<?= url_for('/analysis') ?>"><span class="glyphicon glyphicon-stats"></span> Analysis</a></li>
								<li<?php if($section=='cases') { echo ' class="active"'; } ?>><a href="<?= url_for('/cases') ?>"><span class="glyphicon glyphicon-list"></span> Cases <span class="badge">4</span></a></li>
							</ul>
                    
							<ul class="nav navbar-nav navbar-right">
								<li class="hidden-sm hidden-xs">
									<a href="<?= url_for('/signout') ?>"><span class="glyphicon glyphicon-log-out"></span> Sign Out</a>
								</li>
							</ul>
                    
						</div>
					</div><!--/.container-fluid -->
				</nav><!--/.navbar -->
			</div><!-- /.row -->
			
			<?php echo $content; ?>
		
		</div><!-- /.container -->
		<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
   </body>
</html>