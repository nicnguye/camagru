<?php $titre = 'Commentaire'; ?>

<?php ob_start(); ?>

<h1>Commentaire</h1>

<div id='comment-container'>
    <div id='img_comment'><img src=<?php echo $photo_path ?> alt='photo'></div>
    <br/>
    <div><form action='index.php?page=comment' method='post'>
        <div><label for='commentaire:'>Write a comment</label></div>
        <textarea id='commentaire' name='commentaire' placeholder='Write something...'></textarea>
        <input type='submit' name='submit' value='Submit'></form>
    </div>
    <br/>
    <div><p><em>Commented by:</em></p></div>
    <div>
        <table>
        <?php foreach ($comment as $var) :?>
            <tr>
                <td><b><?php echo get_username($var['id_user'])?></b> :</td>
                <td><?php echo $var['content']?></td>
                <td><?php echo $var['creation_date']?></td>
            </tr>
        <?php endforeach; ?>
        </table>
    </div>
</div>
<?php $content = ob_get_clean(); ?>

<?php require 'view/layout.php' ?>