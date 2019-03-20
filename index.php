<?php
define('WEBROOT', dirname(__FILE__));

require('controller/controller.php');

session_start();

try {
    if (isset($_GET['page']))
    {
        if ($_GET['page'] == 'gallery')
            gallery();
        else if ($_GET['page'] == 'montage')
            montage();
        else if ($_GET['page'] == 'mygallery')
            mygallery();
        else if ($_GET['page'] == 'upload')
            upload();
        else if ($_GET['page'] == 'register')
            register();
        else if ($_GET['page'] == 'activation')
            activation();
        else if ($_GET['page'] == 'login')
            login();
        else if ($_GET['page'] == 'reset')
            reset_password();
        else if ($_GET['page'] == 'reset2')
            reset_password_validate();
        else if ($_GET['page'] == 'user')
            user();
        else if ($_GET['page'] == 'logout')
            logout();
        else if ($_GET['page'] == 'comment')
            comment();
    }
    else
        homepage();
}
catch (Exception $e) {
    error($e->getMessage());
}
?>
