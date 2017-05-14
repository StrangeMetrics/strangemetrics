<h2>My information</h2>

<div class="right">
   <div class="tips">
      <h3>On passwords</h3>
      <p>
         Please be sure to set up a secure password. You can create secure and random passwords in sites like <a target="blank" href="https://www.random.org/passwords/">random.org</a>.
      </p>
      <div class="hr"><hr /></div>
      <h3>Your information</h3>
      <p>According to our records your last login was on <span class="label"><?= $user['last_login'] ?></span> from the IP <code><?= $user['last_login_ip'] ?></code>.</p>
   </div>
</div>

<form action="<?= url_for('/account/me') ?>" method="POST" class="left">

   <p class="flash success"><?= flash('success') ?></p>
   <p class="flash warn"><?= flash('errors') ?></p>

   <div class="group">
      <div class="control"><label for="uEmail">Your Email</label></div>
      <div class="def">
         <input class="text lg" type="email" name="user[email]" id="uEmail" value="<?= $user['email'] ?>" disabled />
      </div>
   </div>

   <div class="group">
      <div class="control"><label for="uPassword">Password</label></div>
      <div class="def">
         <input class="text" type="password" name="user[password]" id="uPassword" />
         <p class="fb">If you leave it empty it won't be changed.</p>
      </div>
   </div>

   <div class="submit">
      <button class="btn" type="submit">Update information</button>
      <a href="javascript:history.go(-1)">or cancel</a>
   </div>

</form>
