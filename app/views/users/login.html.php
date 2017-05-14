<div class="row">
	<div class="main">
		
		<h3>Please Log In, or <a href="<?= url_for('/signup') ?>">Sign Up</a></h3>

		<div class="alert alert-success" role="alert"><?= flash_now('success') ?></div>
		<div class="alert alert-warning" role="alert"><?= flash('errors') ?></div>
			
		<form action="<?= url_for('/login') ?>" method="POST" role="form">
			<div class="form-group">
				<label for="uEmail">Your email</label>
				<input class="form-control" type="email" name="user[email]" id="uEmail" placeholder="your@email.com" value="<?= $login['email'] ?>" required autofocus />
			</div>
			<div class="form-group">
				<a class="pull-right" href="<?= url_for('/reset_password') ?>">Forgot password?</a>
				<label for="uPassword">Password</label>
				<input class="form-control" type="password" name="user[password]" id="uPassword" required />
			</div>
			<button type="submit" class="btn btn btn-primary">
				Log In
			</button>
		</form>
	</div>
</div>