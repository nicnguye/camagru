<?php $titre = 'Error' ?>
<?php ob_start(); ?>
<p>ERROR : <?php echo $error ?></p>
<?php $content = ob_get_clean(); ?>

<?php require 'view/layout.php'; ?>