<?php if ($detections==false): ?>
	
	<h1 class="page-header">Welcome</h1>

	<p class="lead">To get started you will first need to integrate your tracking platform.</p>
	<p><a class="btn btn-primary" href="<?= url_for('/settings') ?>"><span class="glyphicon glyphicon-cog"></span> Go to Settings</a></p>

	<hr />
	<p>You can find more information in our <a target="blank" href="https://github.com/StrangeMetrics/strangemetrics/wiki">Wiki <span class="glyphicon glyphicon-new-window"></span></a>.</p>

<?php else: ?>

<h1>Detections</h1>

<div class="alert alert-info"><?= flash_now('info') ?></div>
<div class="alert alert-success"><?= flash_now('success') ?></div>

<table class="table table-hover">
	<thead>
		<tr>
			<th>Formula</th>
			<th>Offer ID</th>
			<th>Affiliate ID</th>
			<th>Sub IDs</th>
			<th>Impressions</th>
			<th><abbr title="Click Through Rate">CTR %</abbr></th>
			<th>Clicks</th>
			<th><abbr title="Conversion Rate">CR %</abbr></th>
			<th>Conversions</th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($detections as $d): ?>
			<tr>
				<td><code><?= $d['formula_used'] ?></code></td>
				<td><?= $d['offer_id'] ?></td>
				<td><?= $d['affiliate_id'] ?></td>
				<td><?= $d['sub_ids'] ?></td>
				<td><?= number_format($d['impressions'], 0) ?></td>
				<td><?php
					if ($d['impressions']==0) { echo 0; }
					else { echo number_format(($d['clicks']*100/$d['impressions']), 2); }
				?></td>
				<td><?= number_format($d['clicks'], 0) ?></td>
				<td><?php
					if ($d['clicks']==0) { echo 0; }
					else { echo number_format(($d['conversions']*100/$d['clicks']), 2); }
				?></td>
				<td><?= number_format($d['conversions'], 0) ?></td>
				<td>
					<a class="btn btn-xs btn-default" href="<?= url_for('/detections/ignore/'.$d['id']) ?>">Ignore</a>
					<a class="btn btn-xs btn-primary" href="<?= url_for('/cases/create/'.$d['id']) ?>">Create Case</a>
				</td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<nav aria-label="...">
  <ul class="pagination">
	  <?php if ($page==0) { ?>
		  <li class="disabled"><a href="<?= url_for('/') ?>" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>
	  <?php } else { ?>
		  <li><a href="<?= url_for('/page/'.($page-1)) ?>" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>
	  <?php } ?>
	 <?php for ($i=0; $i < round($total_items/$limit); $i++) { ?>
		 <?php if ($i==$page) { ?>
		    <li class="active"><a href="<?= url_for('/page/'.$i) ?>"><?= $i ?> <span class="sr-only">(current)</span></a></li>
		 <?php } else { ?>
			 <li><a href="<?= url_for('/page/'.$i) ?>"><?= $i ?></a></li>
		 <?php } ?>
	 <?php } ?>
	 <?php if ((($page+1)*$limit)>=$total_items) { ?>
		 <li class="disabled"><a href="<?= url_for('/page/'.$page) ?>" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>
	 <?php } else { ?>
		 <li><a href="<?= url_for('/page/'.($page+1)) ?>" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>
	 <?php } ?>
  </ul>
</nav>

<?php endif; ?>