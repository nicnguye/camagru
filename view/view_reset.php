<?php $titre = 'Reset password'; ?>

<?php ob_start(); ?>

<h1>Reset password</h1>

<form action='index.php?page=reset' method='post'>
    <label for='mail'>Enter your mail: </label>
    <input id='mail' name='mail' type='email'/>
    <input id='submit' name='submit' type='submit' value='OK'/>
</form>

<?php $content = ob_get_clean(); ?>

<?php require 'view/layout.php' ?>