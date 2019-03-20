<?php $titre = 'Gallery'; ?>

<?php ob_start(); ?>

<h1>Gallery</h1>

<div class='gallery-container'>
<?php foreach ($gallery as $val) :?>
    <div id='gallery-img'>
        <div>
            <img src=<?php echo $val['photo_path'] ?> alt='photo'>
        </div>
        <div id='gallery-section'>
            <div id='com'>
                <form action='index.php?page=comment' method='post'>
                    <input type='submit' name='submit' value='Comment' />
                    <input type='hidden' name='id_photo' value='<?php echo $val['id_photo']?>' />
                    <input type='hidden' name='photo_path' value='<?php echo $val['photo_path']?>' />
                </form>
            </div>
            <div>
                <?php echo $val['nb_like']?>
            </div>
            <div id='lik'>
                <form action='index.php?page=gallery' method='post'>
                    <button type='submit' name='submit_like' value='submit_like' style='background-color: transparent; border: none;'>
                    <img src=<?php if ($user) echo get_like($val['id_photo'], $_SESSION['id_user']); else echo 'img/heart-empty.png';?>>
                    </button>
                    <input type='hidden' name='id_photo' value='<?php echo $val['id_photo']?>' />
                </form>
            </div>
        </div>
    </div>
<?php endforeach; ?>
</div>

<div id='pagination'>
        <?php
        for($i = 1; $i <= $nbPage; $i++) {
            if ($i == $cPage){
                echo "$i /";
            }
            else {
                echo "<a href=\"index.php?page=gallery&p=$i\">$i</a> /";
            }
        }
        ?>
</div>

<?php $content = ob_get_clean(); ?>

<?php require 'view/layout.php' ?>