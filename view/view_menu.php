<div class='logo'><a href='index.php'><img src='img/logo.png' alt='Camagru'></a></div>
<div class='menu-container'>
    <div class='menu'>
        <div class='gallery'><a href='index.php?page=gallery'>Gallery</a></div>
        <?php if ($user == 1) :?>
        <div class= 'gallery'><a href='index.php?page=montage'>Take a Picture</a></div>
        <div class= 'gallery'><a href='index.php?page=mygallery'>My Gallery</a></div>
        <?php endif;?>
        <div class='sign'>
        <?php if ($user == 0) :?>
            <div><a href='index.php?page=register'>Signup</a></div>
            <div class='login'><a href='index.php?page=login'>Login</a></div>
        <?php else :?>
            <div><a href='index.php?page=user'><?php echo $_SESSION['logged_on_user']; ?></a></div>
            <div class='logout'><a href='index.php?page=logout'>Logout</a></div>
        <?php endif;?>
        </div>
    </div>
</div>