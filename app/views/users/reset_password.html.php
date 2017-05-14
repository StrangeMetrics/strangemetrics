<div class="row">

	<div class="main">
		
		<h3>Reset password, or <a href="<?= url_for('/login') ?>">Log In</a></h3>

		<div class="alert alert-success" role="alert"><?= flash('success') ?></div>
		<div class="alert alert-warning" role="alert"><?= flash('errors') ?></div>
			
		<form action="<?= url_for('/reset_password') ?>" method="POST" role="form">
			<div class="form-group">
				<label for="uEmail">Your email</label>
				<input class="form-control" type="email" name="user[email]" id="uEmail" placeholder="your@email.com" value="<?= $user['email'] ?>" required autofocus />
			</div>
			<button type="submit" class="btn btn btn-primary">
				Reset Password
			</button>
		</form>
	</div>
</div>