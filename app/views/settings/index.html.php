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
				
				<div class="alert alert-success"><?= flash('success') ?></div>
				<div class="alert alert-danger"><?= flash('errors') ?></div>
				
				<form action="<?= url_for('/settings') ?>" method="POST">
					
					<div class="form-group">
						<label for="awsKey">AWS KEY</label>
						<input type="text" class="form-control" id="awsKey" name="settings[aws_key]" placeholder="AWS KEY" />
					</div>
					
					<div class="form-group">
						<label for="awsSecret">AWS Secret</label>
						<input type="text" class="form-control" id="awsSecret" name="settings[aws_secret]" placeholder="AWS Secret" />
					</div>
					
					<button type="submit" class="btn btn-primary pull-right">Submit</button>
				</form>
			</div>
			<div class="col-md-6">
				<h4>What is this?</h4>
				<p>Your Amazon Web Services credentials are used to store all the reports downloaded from your integrations.</p>
				<p>Here you can see how to <a target="blank" href="https://aws.amazon.com/blogs/security/wheres-my-secret-access-key/">obtain you AWS Key and Secret Access from AWS <span class="glyphicon glyphicon-new-window" aria-hidden="true"></span></a>.</p>
			</div>
		</div>
	</div>
</div>