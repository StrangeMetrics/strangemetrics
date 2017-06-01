<h1 class="page-header">Analysis</h1>

<ol class="breadcrumb">
  <li><a href="<?= url_for('/analysis') ?>">Analysis</a></li>
  <li class="active">List</li>
</ol>

<div class="alert alert-success"><?= flash('success') ?></div>
<div class="alert alert-danger"><?= flash('errors') ?></div>

<?php if ($analysis): ?>
<table class="table">
	<thead>
		<tr>
			<th>ID</th>
			<th>Name</th>
			<th>Runs every</th>
			<th>Status</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($analysis as $a): ?>
			<tr>
				<td><code><?= $a['id'] ?></code></td>
				<td>
					<strong><?= $a['name'] ?></strong>
					on <a href="<?= url_for('/settings/integrations/'.$a['tracking_platform_id']) ?>"><?= $a['tracking_platform'] ?></a>
				</td>
				<td>
					<?= $a['run_every_hours'] ?> hours
				</td>
				<td>
					<?php if ($a['status']=='on'): ?>
						<span class="label label-success">ON</span>
					<?php else: ?>
						<span class="label label-default">OFF</span>
					<?php endif; ?>
					<?php if ($a['last_run']): ?>
						<small>Last run <?= $a['last_run'] ?></small>
					<?php else: ?>
						<small>Never run yet</small>
					<?php endif; ?>
				</td>
				<td><a class="btn btn-default btn-xs" href="<?= url_for('/analysis/'.$a['id']) ?>">Edit</a></td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<a class="btn btn-primary" href="<?= url_for('/analysis/new') ?>">New analysis</a>

<?php else: ?>
	<div class="alert alert-info">
		<h4>There are no analysis yet</h4>
		<p>Create your first analysis by <a href="<?= url_for('/analysis/new') ?>">clicking here</a>.</p>
	</div>
<?php endif; ?>