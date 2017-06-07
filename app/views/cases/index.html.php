<h1 class="page-header">Cases</h1>

<table class="table table-hover">
	<thead>
		<tr>
			<th>ID</th>
			<th>Offer ID</th>
			<th>Affiliate ID</th>
			<th>Sub IDs</th>
			<th>Detections</th>
			<th>Status</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($cases as $c): ?>
			<tr>
				<td><code>#<?= $c['id'] ?></code></td>
				<td><?= $c['offer_id'] ?></td>
				<td><?= $c['affiliate_id'] ?></td>
				<td><?= $c['sub_ids'] ?></td>
				<td></td>
				<td><?= $c['status'] ?></td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>