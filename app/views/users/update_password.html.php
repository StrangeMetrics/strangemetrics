<h2>Update password</h2>

<p class="flash success"><?= flash('success') ?></p>
<p class="flash warn"><?= flash('errors') ?></p>

<form action="<?= url_for('/update_password/'.$user['token']) ?>" method="POST">

   <div class="group">
      <div class="control"><label for="uEmail">Your Email</label></div>
      <div class="def">
         <input class="text lg" type="email" name="user[email]" id="uEmail" placeholder="your@email.com" value="<?= $user['email'] ?>" required autofocus />
      </div>
   </div>

   <div class="group">
      <div class="control"><label for="uPassword">New Password</label></div>
      <div class="def">
         <input class="text" type="password" name="user[password]" id="uPassword" required />
      </div>
   </div>

   <div class="submit">
      <button class="btn" type="submit">Update password</button>
   </div>

</form>
<div class="clear"></div>
