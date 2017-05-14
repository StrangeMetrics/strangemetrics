	<div class="col-md-2">
		<ul class="nav nav-pills nav-stacked">
		  <li role="presentation"<?php if($sub=='index') { echo ' class="active"'; } ?>><a href="<?= url_for('/settings') ?>">General</a></li>
		  <li role="presentation"<?php if(strpos($sub,'integrations')!==false) { echo ' class="active"'; } ?>><a href="<?= url_for('/settings/integrations') ?>">Integrations</a></li>
		  <li role="presentation"<?php if($sub=='emails') { echo ' class="active"'; } ?>><a href="<?= url_for('/settings/emails') ?>">Emails</a></li>
		</ul>
	</div>
