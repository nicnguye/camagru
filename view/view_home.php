<?php $titre = 'Homepage'; ?>

<?php ob_start(); ?>

<h1>Homepage</h1>

<?php $content = ob_get_clean(); ?>

<?php require 'view/layout.php' ?>