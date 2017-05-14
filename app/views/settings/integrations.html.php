<h1 class="page-header">Settings</h1>

<ol class="breadcrumb">
  <li><a href="<?= url_for('/settings') ?>">Settings</a></li>
  <li class="active">Integrations</li>
</ol>

<div class="row">

	<?php require_once(__DIR__.'/menu.html.php'); ?>
	
	<div class="col-md-10">
		
		<a class="pull-right btn btn-primary" href="<?= url_for('/settings/integrations/add') ?>">New integration</a>
		<h3>Integrations</h3>
		
		<?php if (isset($integrations)): ?>
			<table class="table table-hover">
				<thead>
					<th style="width:30px">#</th>
					<th>Name</th>
					<th>Platform</th>
					<th></th>
				</thead>
				<tbody>
					<?php foreach ($integrations as $i): ?>
						<tr>
							<td><?= $i['id']; ?></td>
							<td>
								<strong><?= $i['name'] ?></strong>
								<?php if ($i['status']=='on'): ?>
									<span class="label label-success">ON</span>
								<?php else: ?>
									<span class="label label-danger">OFF</span>
								<?php endif; ?>
							</td>
							<td><?= $i['platform'] ?></td>
							<td>
								<a class="btn btn-default btn-xs" href="<?= url_for('/settings/integrations/'.$i['id']) ?>">Edit</a>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		<?php else: ?>
		<div class="alert alert-info">
			<p>There are no integrations yet. Add one now.</p>
		</div>
		<?php endif; ?>
		
	</div>
</div>