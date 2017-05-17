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
				
				<div class="alert alert-success"><?= flash('success') ?></div>
				<div class="alert alert-danger"><?= flash('errors') ?></div>
				
				<form class="" action="<?= url_for('/settings/emails') ?>" method="POST">
					<div class="row">
						<div class="form-group col-md-4">
							<label for="mailgunApiSecret">Mailgun Secret API Key</label>
							<input type="text" class="form-control" id="mailgunApiSecret" placeholder="Secret Key" name="settings[api_secret]" value="<?= $settings['api_secret'] ?>" />
						</div>
						<div class="form-group col-md-4">
							<label for="mailgunDomain">Mailgun Domain</label>
							<input type="text" class="form-control" id="mailgunDomain" placeholder="example.com" name="settings[domain]" value="<?= $settings['domain'] ?>" />
						</div>
						<div class="form-group col-md-4">
							<label for="mailgunEmail">Mailgun Address</label>
							<input type="email" class="form-control" id="mailgunEmail" placeholder="you@example.com" name="settings[email]" value="<?= $settings['email'] ?>" />
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
						<button class="btn btn-default btn-xs" type="button" data-toggle="modal" data-target="#email_signup">Preview</button>
					</td>
				</tr>
				<tr>
					<td><code>reset.txt</code></td>
					<td>Reset your password</td>
					<td>
						<button class="btn btn-default btn-xs" type="button" data-toggle="modal" data-target="#email_reset">Preview</button>
					</td>
				</tr>
				<tr>
					<td><code>password_updated.txt</code></td>
					<td>Your password has been updated</td>
					<td>
						<button class="btn btn-default btn-xs" type="button" data-toggle="modal" data-target="#email_password">Preview</button>
					</td>
				</tr>
			</tbody>
		</table>
		
		<?php
		// TODO: This should be done better.
		?>
		
		<div class="modal fade" id="email_signup" tabindex="-1" role="dialog">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">Welcome to <?= APP_NAME ?></h4>
					</div>
					<div class="modal-body">
						<?= str_replace("\n", '<br />', $emails['signup.txt']) ?>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="email_reset" tabindex="-1" role="dialog">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">Reset your password</h4>
					</div>
					<div class="modal-body">
						<?= str_replace("\n", '<br />', $emails['reset.txt']) ?>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="email_password" tabindex="-1" role="dialog">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">Your password has been updated</h4>
					</div>
					<div class="modal-body">
						<?= str_replace("\n", '<br />', $emails['password_updated.txt']) ?>
					</div>
				</div>
			</div>
		</div>
		
	</div>
</div>