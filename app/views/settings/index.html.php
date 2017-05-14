<h1 class="page-header">Settings</h1>

<ol class="breadcrumb">
  <li><a href="<?= url_for('/settings') ?>">Settings</a></li>
  <li class="active">General</li>
</ol>

<div class="row">

	<?php require_once(__DIR__.'/menu.html.php'); ?>
	
	<div class="col-md-10">
		
		<div class="row">
			<div class="col-md-6">
				<h3>General settings</h3>
				
				<form action="<?= url_for('/settings') ?>" method="POST">
					<div class="form-group">
						<label for="appName">Instalation name</label>
						<input type="text" class="form-control" id="appName" name="app[name]" placeholder="Strange Metrics" />
					</div>
					<button type="submit" class="btn btn-default">Submit</button>
				</form>
			</div>
			<div class="col-md-6">
			</div>
		</div>
	</div>
</div>