<form class="form-signin" method="POST">
    <h2 class="form-signin-heading"><?=l('Registration')?></h2>
    <input name="Email" type="text" class="input-block-level" placeholder="<?=l('Email')?>">
    <input name="Login" type="text" class="input-block-level" placeholder="<?=l('Login')?>">
    <input name="Password" type="password" class="input-block-level" placeholder="<?=l('Password')?>">
    <input type="password" class="input-block-level" placeholder="<?=l('Re-Password')?>">
    <div align="right">
        <button class="btn btn-large btn-primary" type="submit"><?=l('Proceed')?></button>
    </div>
</form>