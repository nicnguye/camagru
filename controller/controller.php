<?php

require 'model/model.php';

    function check_user() {
        if (isset($_SESSION['logged_on_user']) && $_SESSION['logged_on_user'] != "")
            $user = 1;
        else
            $user = 0;
        return $user;
    }

    function error($error) {
        $user = check_user();
        require 'view/view_error.php';
    }

    function homepage() {
        $user = check_user();
        require 'config/setup.php';
        require 'view/view_home.php';
    }

    function register() {
        $user = check_user();
        if (isset($_POST['login']) && isset($_POST['passwd']) && isset($_POST['mail']) && isset($_POST['submit']) && $_POST['submit'] == "OK")
        {
            if (ctype_alnum($_POST['login']) && ctype_alnum($_POST['passwd']))
            {
                if (strlen($_POST['passwd']) > 5)
                {
                    if (preg_match("/[A-Z]/", $_POST['passwd']))
                    {                
                        if (!check_user_exist($_POST['login']) && !check_mail_exist($_POST['mail']))
                        {
                            $login = htmlspecialchars($_POST['login']);
                            $passwd = htmlspecialchars($_POST['passwd']);
                            $mail = htmlspecialchars($_POST['mail']);
                            register_pending_user($login, $passwd, $mail);
                        }
                    }
                    else
                        echo "Password not secured (min 1 uppercase letter)";
                }
                else
                    echo 'Error password! (min 6 characters !)';
            }
            else
                echo 'Username and Password must only contain digits and letters';
        }
        require 'view/view_register.php';
    }

    function activation() {
        $user = check_user();
        if (isset($_GET['page']) && isset($_GET['code']))
        {
            if ($_GET['page'] === 'activation' && check_activation($_GET['code']))
            require 'view/view_activation.php';
        }
        else
            homepage();
    }

    function login() {
        $user = check_user();
        if (isset($_POST['login']) && isset($_POST['passwd']) && auth($_POST['login'], $_POST['passwd']) && isset($_POST['submit']) && $_POST['submit'] == "OK")
        {
            $login = htmlspecialchars($_POST['login']);
            $info = get_user_info($login);
            $_SESSION['id_user'] = $info['id_user'];
            $_SESSION['logged_on_user'] = $info['username'];
            $_SESSION['mail'] = $info['mail'];
            $_SESSION['notif'] = $info['notif'];
            homepage();
        }
        else
            require 'view/view_login.php';
    }

    function reset_password(){
        $user = check_user();
        if (isset($_POST['mail']) && isset($_POST['submit']) && $_POST['submit'] == 'OK')
        {
            $mail = htmlspecialchars($_POST['mail']);
            mail_password($mail);
        }
        else
            require 'view/view_reset.php';
    }

    function reset_password_validate(){
        $user = check_user();
        if ($_GET['page'] === 'reset2' && isset($_GET['code']) && check_reset_password($_GET['code']))
        {
            $token = $_GET['code'];
            if (isset($_POST['pwd1']) && isset($_POST['pwd2']) && isset($_POST['submit']) && $_POST['submit'] == "Validate")
            {
                if (ctype_alnum($_POST['pwd1']) && ctype_alnum($_POST['pwd2'])) 
                {
                    if (strcmp($_POST['pwd1'], $_POST['pwd2']) == 0)
                    {
                        if (strlen($_POST['pwd1']) > 5)
                        {
                            if (preg_match("/[A-Z]/", $_POST['pwd1']))
                            {
                                $pwd = htmlspecialchars($_POST['pwd1']);
                                new_password_reset($pwd, $token);
                                echo "Password changed!";
                            }
                            else
                                echo "Password not secured (min 1 uppercase letter)";
                        }
                        else
                            echo 'Error password! (min 6 characters !)';
                    }
                    else
                        echo "Password must be the same !";
                }
                else
                    echo "Password must only contain digits and letters";
            }
            require 'view/view_reset2.php';
        }
        else
            error('Wrong activation code !');
    }

    function user(){
        $user = check_user();
        if ($user && isset($_SESSION['logged_on_user']) && isset($_SESSION['id_user']))
        {
            if (isset($_POST['username']) && isset($_POST['mail']) && isset($_POST['submit']) && $_POST['submit'] == 'Editer')
            {
                if (ctype_alnum($_POST['username']))
                {
                    if (!check_user_exist2($_POST['username'], $_SESSION['id_user']) && !check_mail_exist2($_POST['mail'], $_SESSION['id_user']))
                    {
                        $username = htmlspecialchars($_POST['username']);
                        $mail = htmlspecialchars($_POST['mail']);
                        edit_info($username, $mail, $_SESSION['id_user']);
                        $_SESSION['logged_on_user'] = $_POST['username'];
                        $_SESSION['mail'] = $mail;
                    }
                }
                else
                    echo 'Username must only contain digits and letters';
            }
            else if (isset($_POST['oldpwd']) && isset($_POST['newpwd']) && isset($_POST['submit']) && $_POST['submit'] == 'Change')
            {
                if (strlen($_POST['newpwd']) > 5)
                {
                    if (preg_match("/[A-Z]/", $_POST['newpwd']))
                    {
                        $oldpwd = htmlspecialchars($_POST['oldpwd']);
                        $newpwd = htmlspecialchars($_POST['newpwd']);
                        change_password($oldpwd, $newpwd, $_SESSION['id_user']);
                    }
                    else
                        echo "Password not secured (min 1 uppercase letter)";
                }
                else
                    echo 'Error password! (min 6 characters !)';
            }
            else if (isset($_POST['notif']) && isset($_POST['submit']) && $_POST['submit'] == 'Submit')
            {
                notif_change($_SESSION['id_user'], $_POST['notif']);
                $_SESSION['notif'] = $_POST['notif'];
            }
            require 'view/view_user.php';
        }
        else
            login();
    }

    function logout(){
        $user = check_user();
        if ($user)
        {
            $_SESSION['logged_on_user'] = "";
            $_SESSION['id_user'] = "";
            $_SESSION['mail'] = "";
            $_SESSION['notif'] = "";
            homepage();
        }
        else
            error("You must be logged first !");
    }

    function gallery() {
        $user = check_user();

        $db = db_connect();
        $req = $db->prepare('SELECT COUNT(id_photo) AS total FROM photo');
        $req->execute();
        $result = $req->fetch();
        $total = $result['total'];
        $perPage = 6;
        $nbPage = ceil($total/$perPage);
        if(isset($_GET['p']) && $_GET['p']>0 && $_GET['p']<=$nbPage){
            $cPage = $_GET['p'];
        } else {
            $cPage = 1;
        }

        $gallery = get_gallery($cPage, $perPage);
        if ($user && isset($_POST['id_photo']) && isset($_POST['submit_like']) && $_POST['submit_like'] == "submit_like")
        {
            add_like($_POST['id_photo'], $_SESSION['id_user']);
            header("Location: index.php?page=gallery");
        }
        require 'view/view_gallery.php';
    }

    function montage() {
        $user = check_user();
        if ($user)
        {
            $montage = previous_montage($_SESSION['id_user']);
            if (isset($_POST['hidden_data']) && isset($_POST['hidden_filter']))
            {
                savepicture($_POST['hidden_data'], $_POST['hidden_filter'], $_SESSION['id_user']);
                header("Location: index.php?page=montage");
            }
            require 'view/view_montage.php';
        }
        else
            login();
    }

    function mygallery() {
        $user = check_user();
        if ($user)
        {
            $gallery = get_mygallery($_SESSION['id_user']);
            if (isset($_POST['id_photo']) && isset($_POST['submit_like']) && $_POST['submit_like'] == "submit_like")
            {
                add_like($_POST['id_photo'], $_SESSION['id_user']);
                header("Location: index.php?page=mygallery");
            }
            require 'view/view_mygallery.php';
        }
        else
            login();
    }

    function upload(){
        $user = check_user();
        if ($user)
        {
            if (isset($_POST['hidden_data']) && isset($_POST['hidden_filter']) && isset($_FILES['pic']))
                savepicture($_POST['hidden_data'], $_POST['hidden_filter'], $_SESSION['id_user']);
            require 'view/view_upload.php';
        }
        else
            login();
    }

    function comment() {
        $user = check_user();
        if ($user && isset($_POST['id_photo']) && isset($_POST['photo_path']) && isset($_POST['submit']) && $_POST['submit'] == "Comment")
        {
            $_SESSION['id_photo'] = $_POST['id_photo'];
            $_SESSION['photo_path'] = $_POST['photo_path'];
            $photo_path = $_SESSION['photo_path'];
            $comment = get_comment($_SESSION['id_photo']);
            require 'view/view_comment.php';
        }
        else if ($user && isset($_POST['commentaire']) && strlen($_POST['commentaire']) != 0 && isset($_POST['submit']) && $_POST['submit'] == "Submit")
        {
            $com = htmlspecialchars($_POST['commentaire']);
            if (strlen($com) < 255)
            {
                insert_comment($_SESSION['id_photo'], $_SESSION['id_user'], $com);
                send_notif($_SESSION['id_photo'], $_SESSION['logged_on_user']);
            }
            else
                echo "Commentaire trop long !";
            $photo_path = $_SESSION['photo_path'];
            $comment = get_comment($_SESSION['id_photo']);
            require 'view/view_comment.php';
        }
        else if ($user && isset($_POST['commentaire']) && !strlen($_POST['commentaire']) && isset($_POST['submit']) && $_POST['submit'] == "Submit")
        {
            error("Le champ de commentaire est vide!");
        }
        else if ($user && isset($_POST['id_photo']) && isset($_POST['photo_path']) && isset($_POST['submit']) && $_POST['submit'] == "Delete")
        {
            delete_photo($_POST['id_photo']);
            mygallery();
        }
        else
            error("You must be logged to comment !");
    }
?>