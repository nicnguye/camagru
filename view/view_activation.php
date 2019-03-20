<?php $titre = 'Activation'; ?>

<?php ob_start(); ?>

<h1>Account activated</h1>

<div><p>Your account has been activated successfully. You can now login !</p></div>

<?php $content = ob_get_clean(); ?>

<?php require 'view/layout.php' ?>