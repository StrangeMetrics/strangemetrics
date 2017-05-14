<h1 class="page-header">Settings</h1>

<ol class="breadcrumb">
  <li><a href="<?= url_for('/settings') ?>">Settings</a></li>
  <li class="active">Emails</li>
</ol>

<div class="row">
	
	<?php require_once(__DIR__.'/menu.html.php'); ?>
	
	<div class="col-md-10">
		
		<div class="panel panel-warning">
			<div class="panel-body">
				
				<h4>Mailgun API</h4>
		
				<form class="" action="<?= url_for('/settings/mails') ?>" method="POST">
					<div class="row">
						<div class="form-group col-md-4">
							<label for="mailgunApiKey">Mailgun API Key</label>
							<input type="text" class="form-control" id="mailgunApiKey" placeholder="API KEY" />
						</div>
						<div class="form-group col-md-4">
							<label for="mailgunDomain">Mailgun Domain</label>
							<input type="text" class="form-control" id="mailgunDomain" placeholder="example.com" />
						</div>
						<div class="form-group col-md-4">
							<label for="mailgunEmail">Mailgun address</label>
							<input type="email" class="form-control" id="mailgunEmail" placeholder="you@example.com" />
						</div>
					</div>
					<a href="https://app.mailgun.com/app/dashboard" class="btn btn-default pull-right" target="blank">
						Mailgun
						<span class="glyphicon glyphicon-new-window" aria-hidden="true"></span>
					</a>
					<button type="submit" class="btn btn-warning">Submit</button>
				</form>
				
			</div>
		</div>
		
		<a class="pull-right btn btn-primary" href="<?= url_for('/settings/emails/add') ?>">New email</a>
		<h3>Emails</h3>
		
		<table class="table table-hover">
			<thead>
				<th style="width:200px">File</th>
				<th>Subject</th>
				<th></th>
			</thead>
			<tbody>
				<tr>
					<td><code>signup.txt</code></td>
					<td>Welcome to <?= APP_NAME ?></td>
					<td>
						<a class="btn btn-default btn-xs" href="<?= url_for('/settings/emails/signup.txt') ?>">Edit</a>
					</td>
				</tr>
				<tr>
					<td><code>reset.txt</code></td>
					<td>Reset your password</td>
					<td>
						<a class="btn btn-default btn-xs" href="<?= url_for('/settings/emails/reset.txt') ?>">Edit</a>
					</td>
				</tr>
				<tr>
					<td><code>password_updated.txt</code></td>
					<td>Your password has been updated</td>
					<td>
						<a class="btn btn-default btn-xs" href="<?= url_for('/settings/emails/password_updated.txt') ?>">Edit</a>
					</td>
				</tr>
			</tbody>
		</table>
		
	</div>
</div>