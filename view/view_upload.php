<?php $titre = 'Montage'; ?>

<?php ob_start(); ?>

<h1>Montage</h1>

<form method='post' name='form2'>
<div id='main-montage'>
    <div id='filter1'>
        <div><img id="img1" src='img/kappapride.png'></div>
        <div><img id="img2" src='img/cmonbruh.png'></div>
        <div><img id="img3" src='img/lul.png'></div>
        <div><img id="img4" src='img/monkas.png'></div>
    </div>
    <div>
        <div id='upload-img'>
            <img id='picture' src='img/img-upload.png' style="display:block;">
            <input name='hidden_data' id='hidden_data' type='hidden'>
        </div>
        <div id='upload-filter'>
            <img id='img-filter' src="">
            <input name='hidden_filter' id='hidden_filter' type='hidden'>
        </div>
        <div>
            <button id="startbutton">Take photo</button>
        </div>
    </div>
    <div>
        <label for='pic'>Upload a .png file first !!! </label>
        <input type='file' name='pic' id='pic' accept='.png'>
    </div>
</div>
</form>

<script src='view/upload.js'></script>

<?php $content = ob_get_clean(); ?>

<?php require 'view/layout.php' ?>