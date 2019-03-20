<?php $titre = 'Gallery'; ?>

<?php ob_start(); ?>

<h1>My Gallery</h1>

<div class='gallery-container'>
<?php foreach ($gallery as $val) :?>
    <div id='gallery-img'>
        <div><img src=<?php echo $val['photo_path'] ?> alt='photo'></div>
        <div id='gallery-section'>
            <div id='com'>
            <form action='index.php?page=comment' method='post'>
                <input type='submit' name='submit' value='Comment' />
                <input type='submit' name='submit' value='Delete' />
                <input type='hidden' name='id_photo' value='<?php echo $val['id_photo']?>' />
                <input type='hidden' name='photo_path' value='<?php echo $val['photo_path']?>' />
            </form>
        </div>
        <div><?php echo $val['nb_like']?></div>
            <form action='index.php?page=mygallery' method='post'>
                <div id='lik'>
                    <button type='submit' name='submit_like' value='submit_like' style='background-color: transparent; border: none;'>
                    <img src=<?php if ($user) echo get_like($val['id_photo'], $_SESSION['id_user']); else echo 'img/heart-empty.png';?>>
                    </button>
                    <input type='hidden' name='id_photo' value='<?php echo $val['id_photo']?>' />
                </div>
            </form>
        </div>
    </div>
<?php endforeach; ?>
</div>

<?php $content = ob_get_clean(); ?>

<?php require 'view/layout.php' ?>