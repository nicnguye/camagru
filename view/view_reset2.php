<?php $titre = 'Reset password'; ?>

<?php ob_start(); ?>

<h1>Reset password</h1>

<form action='<?php echo 'index.php?page=reset2&code='.$token ?>' method='post'>
    <label for='pwd1'>Enter your new password: </label>
    <input id='pwd1' name='pwd1' type='password'/>
    <label for='pwd2'>Confirmed your new password: </label>
    <input id='pwd2' name='pwd2' type='password'/>
    <input id='submit' name='submit' type='submit' value='Validate'/>
</form>

<?php $content = ob_get_clean(); ?>

<?php require 'view/layout.php' ?>