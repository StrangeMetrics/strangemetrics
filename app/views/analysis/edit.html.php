<h1 class="page-header">Edit Analysis</h1>

<ol class="breadcrumb">
  <li><a href="<?= url_for('/analysis') ?>">Analysis</a></li>
  <li class="active"><?= $analysis['name'] ?></li>
</ol>

<div class="row">
	<form class="col-md-6" method="POST" action="<?= url_for('/analysis/'.$analysis['id']) ?>">
	
		<div class="alert alert-success"><?= flash('success') ?></div>
		<div class="alert alert-danger"><?= flash('errors') ?></div>
	
		<div class="row">
			<div class="form-group col-md-9">
				<label for="analysisName">Name</label>
				<input type="text" class="form-control" id="analysisName" name="analysis[name]" value="<?= $analysis['name'] ?>" placeholder="CR above 5%" />
			</div>
	
			<div class="form-group col-md-3">
				<label for="analysisOn" class="pull-right">Status</label>
				<div class="btn-group pull-right" data-toggle="buttons">
					<label class="btn btn-default btn-sm<?php if($analysis['status']=='on'){ echo ' active'; } ?>">
						<input type="radio" name="analysis[status]" id="analysisOn" value="on"<?php if($analysis['status']=='on'){ echo ' checked'; } ?>> ON
					</label>
					<label class="btn btn-default btn-sm<?php if($analysis['status']=='off'){ echo ' active'; } ?>">
						<input type="radio" name="analysis[status]" id="analysisOff" value="off"<?php if($analysis['status']=='off'){ echo ' checked'; } ?>> OFF
					</label>
				</div>
			</div>
		</div>
	
		<div class="row">
			<div class="form-group col-md-4">
				<label for="analysisTP">Integration</label>
				<select class="form-control" id="analysisTP" name="analysis[tracking_platform_id]">
					<?php foreach($tps as $tp): ?>
						<option value="<?= $tp['id'] ?>"<?php if ($analysis['tracking_platform_id']==$tp['id']) { echo ' selected'; } ?>><?= $tp['name'] ?> #<?= $tp['id'] ?></option>
					<?php endforeach; ?>
				</select>
			</div>
	
			<div class="form-group col-md-4">
				<label for="analysisRT">Report</label>
				<select class="form-control" id="analysisRT" name="analysis[settings][report_type]">
					<option value="get_stats"<?php if ($analysis['settings']['report_type']=='get_stats') { echo ' selected'; } ?>>Get Stats</option>
					<option value="get_conversions"<?php if ($analysis['settings']['report_type']=='get_conversions') { echo ' selected'; } ?>>Get Conversions</option>
				</select>
			</div>
	
			<div class="form-group col-md-4">
				<label for="analysisRun">Run every</label>
				<div class="input-group">
					<input type="number" class="form-control" id="analysisRun" name="analysis[run_every_hours]" value="<?= $analysis['run_every_hours'] ?>" placeholder="1" />
					<span class="input-group-addon">hours</span>
				</div>
			</div>
						
		</div>
		
		<div class="row">
			<div class="form-group col-md-6">
				<label for="analysisFilterCategory">Categories IDs</label>
				<input type="text" class="form-control" id="analysisFilterCategory" name="analysis[settings][filter_categories]" value="<?= $analysis['settings']['filter_categories'] ?>" placeholder="2,4,6" />
				<p class="help-block">Category IDs you want to analyse</p>
			</div>
	
			<div class="form-group col-md-6">
				<label for="analysisOfferCategory">Offers IDs</label>
				<input type="text" class="form-control" id="analysisOfferCategory" name="analysis[settings][filter_offers]" value="<?= $analysis['settings']['filter_offers'] ?>" placeholder="2,4,6" />
				<p class="help-block">Offer IDs you want to analyse</p>
			</div>
		</div>
		
		<div class="form-group">
			<label for="analysisFormula">Formula</label>
			<input type="text" class="form-control" id="analysisFormula" name="analysis[formula]" value="<?= $analysis['formula'] ?>" placeholder="{conversions} > 10 &amp;&amp; {cr} > 5" />
			<p class="help-block">A case will be created for the conversions matching these conditions.</p>
			<p class="help-block">
				<strong>Macros</strong>
				<code>{impressions}</code>
				<code>{ctr}</code>
				<code>{clicks}</code>
				<code>{conversions}</code>
				<code>{cr}</code>
				<br />
				<strong>Operators:</strong>
				<code>&lt;</code>
				<code>==</code>
				<code>&gt;</code>
				<code>&amp;&amp;</code>
				<code>||</code>
			</p>
		</div>
	
		<button class="btn btn-primary pull-right" type="submit">Submit</button>
	</form>
	
	<div class="col-md-6">
		
		<h4>Tips on creating analysis</h4>
		
		<p>There are two types of reports in HasOffers, Get Stats and Get Conversions.</p>
		
		<p>In Get Stats you will be able to analyse aggregated metrics like clicks, conversions, revenue and cost and apply operators like <em>more than</em> or <em>equals</em>.</p>
		<p>With the conversion report, you will be able to analyse conversion by conversion, grouped by Offer, Affiliate and every other metric you select in the form like <em>aff_sub2</em>, <em>source</em> or <em>session_ip</em>.</p>
	</div>
	
</div>