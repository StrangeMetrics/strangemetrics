<div class="row">

	<div class="main">
		
		<h3>Please Sign Up, or <a href="<?= url_for('/login') ?>">Log In</a></h3>

		<div class="alert alert-success" role="alert"><?= flash_now('success') ?></div>
		<div class="alert alert-warning" role="alert"><?= flash('errors') ?></div>
			
		<form action="<?= url_for('/signup') ?>" method="POST" role="form">
			<div class="form-group">
				<label for="uEmail">Your email</label>
				<input class="form-control" type="email" name="user[email]" id="uEmail" placeholder="your@email.com" value="<?= $user['email'] ?>" required autofocus />
			</div>
			<div class="form-group">
				<a class="pull-right" href="<?= url_for('/reset_password') ?>">Forgot password?</a>
				<label for="uPassword">Password</label>
				<input class="form-control" type="password" name="user[password]" id="uPassword" required />
				<p>At least 6 characters.</p>
			</div>
			<button type="submit" class="btn btn btn-primary">
				Sign Up
			</button>
		</form>
	</div>
</div>