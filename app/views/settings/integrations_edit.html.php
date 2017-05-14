<h1 class="page-header">Settings</h1>

<ol class="breadcrumb">
  <li><a href="<?= url_for('/settings') ?>">Settings</a></li>
  <li><a href="<?= url_for('/settings/integrations') ?>">Integrations</a></li>
  <li class="active">Edit integration #<?= $integration['id'] ?></li>
</ol>

<div class="row">

	<?php require_once(__DIR__.'/menu.html.php'); ?>
	
	<div class="col-md-10">
		
		<div class="row">
			<div class="col-md-6">
				<h3>Edit integration #<?= $integration['id'] ?></h3>
				
				<div class="alert alert-success"><?= flash('success') ?></div>
				<div class="alert alert-danger"><?= flash('errors') ?></div>
				
				<form action="<?= url_for('/settings/integrations/'.$integration['id']) ?>" method="POST">
					
					<div class="row">
						<div class="col-md-9">
							<div class="form-group">
								<label for="appName">Name</label>
								<input type="text" class="form-control" id="appName" name="app[name]" placeholder="Strange Metrics" value="<?= $integration['name'] ?>" />
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label for="appOn" class="pull-right">Status</label>
								<div class="btn-group pull-right" data-toggle="buttons">
									<label class="btn btn-default btn-sm<?php if($integration['status']=='on'){ echo ' active'; } ?>">
										<input type="radio" name="app[status]" id="appOn" value="on"<?php if($integration['status']=='on'){ echo ' checked'; } ?>> ON
									</label>
									<label class="btn btn-default btn-sm<?php if($integration['status']=='off'){ echo ' active'; } ?>">
										<input type="radio" name="app[status]" id="appOff" value="off"<?php if($integration['status']=='off'){ echo ' checked'; } ?>> OFF
									</label>
								</div>
							</div>
						</div>
					</div>
						
					<div class="form-group">
						<label for="appPlatform">Platform</label>
						<select class="form-control" name="app[platform]" id="appPlatform">
							<option value="hasoffers"<?php if($integration['platform']=='hasoffers'){ echo ' selected'; } ?>>HasOffers</option>
						</select>
					</div>
					
					<div class="form-group">
						<label for="appNetwork">HasOffers Network ID</label>
						<input type="text" class="form-control" name="app[settings][network_id]" id="appNetwork" value="<?= $integration['settings']['network_id'] ?>" />
					</div>
					
					<div class="form-group">
						<label for="appAPI">HasOffers API KEY</label>
						<input type="text" class="form-control" name="app[settings][api_key]" id="appAPI" value="<?= $integration['settings']['api_key'] ?>" />
					</div>

					<button type="submit" class="btn btn-primary pull-right">Save</button>
					
				</form>
			</div>
			<div class="col-md-6">
				<h3>Tips</h3>
				
				<h4>HasOffers setup</h4>
				<p>You will now be asked to set up some information from your HasOffers account.</p>
				<p>Here is the <a target="blank" href="https://developers.tune.com/network-docs/setting-up-api-authentication/">HasOffers documentation <span class="glyphicon glyphicon-new-window"></span></a> on how to get this information.</p>
				<h4><?= APP_NAME ?> IPs</h4>
				<p>You will also need to whitelist this IP in HasOffers: <code><?= $_SERVER['REMOTE_ADDR'] ?></code></p>
			</div>
		</div>
	</div>
</div>
