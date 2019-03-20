<?php $titre = 'Montage'; ?>

<?php ob_start(); ?>

<h1>Montage</h1>

<form method='post' name='form1'>
<div id='montage'> 
    <div id='main-montage'>
        <div id='filter1'>
            <div><img id="img1" src='img/kappapride.png'></div>
            <div><img id="img2" src='img/cmonbruh.png'></div>
            <div><img id="img3" src='img/lul.png'></div>
            <div><img id="img4" src='img/monkas.png'></div>
        </div>
        <div>
            <div id='div-video'>
                <video id="video">Video stream not available.</video>
            </div>
            <div id='div-filter'>
                <img id='img-filter' src="">
                <input name='hidden_filter' id='hidden_filter' type='hidden'>
            </div>
            <div id='crop-overlay'>
            </div>
            <div><p>Centrez votre tête a l'interieur du cadre rouge!!</p></div>
            <div>
                <button id="startbutton">Take photo</button>
            </div>
            <canvas id="canvas"></canvas>
            <input name="hidden_data" id='hidden_data' type="hidden">
        </div>
    </div>
</form>
    <div id='div-upload'>
        <form action='index.php?page=upload' method='post'>
            <input id='upload-button' type='submit' name='submit' value='Upload Image'>
        </form>
    </div>
    <div id='side-montage'>
        <?php foreach ($montage as $val):?>
        <div id='previous-montage'><img id='thumbnail' src=<?php echo $val['photo_path']?> alt='photo'></div>
        <?php endforeach; ?>
    </div>
</div>

<script src='view/photo.js'></script>

<?php $content = ob_get_clean(); ?>

<?php require 'view/layout.php' ?>