<!doctype html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <title><?= APP_NAME ?></title>

      <link rel="icon" type="image/gif" href="<?= url_for('/webroot/favicon.ico') ?>" />	
			<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
			<style type="text/css" media="screen">
			  body {
			    padding-top: 45px;
			    font-size: 12px
			  }
				h1 { text-align:center; }
				h1 img { width:140px; padding:10px; border:1px solid #eee; background:#f6f6f6; border-radius:50%; }
			  .main {
			    max-width: 320px;
			    margin: 0 auto;
			  }
			  h3 {
			    text-align: center;
			    line-height: 300%;
			  }
				.alert:empty {
					display:none;
				}
			</style>

   </head>
   <body id="login">

      <div id="top">
         <h1><img src="<?= url_for('/') ?>/webroot/images/strangemetrics_iso.png" alt="<?= APP_NAME ?>" /></h1>
      </div><!-- #top -->

			<div class="container">
			
         <?php echo $content; ?>

      </div>
			
			<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
   </body>
</html>
