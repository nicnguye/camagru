<?php
/* DATABASE CONNECTION */
function db_connect()
{
    require 'config/database.php';
    try {
        $bdd = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $bdd;
    } catch (PDOException $e) {
        die('Échec: ' . $e->getMessage());
    }
}

function get_user_info($login)
{
    $db = db_connect();
    $req = $db->prepare('SELECT id_user, username, mail, notif FROM user WHERE username = :log');
    $req->bindParam(':log', $login);
    $req->execute();
    $result = $req->fetch();
    return ($result);
}

function check_user_exist($login)
{
    $db = db_connect();
    $req = $db->prepare('SELECT * FROM user WHERE username = :log');
    $req->bindParam(':log', $login);
    $req->execute();
    if ($req->rowCount() == 1)
    {
        echo "Username already taken !";
        return (TRUE);
    }
    else
        return (FALSE);
}

function check_mail_exist($mail)
{
    $db = db_connect();
    $req = $db->prepare('SELECT * FROM user WHERE mail = :mail');
    $req->bindParam(':mail', $mail);
    $req->execute();
    if ($req->rowCount() == 1)
    {
        echo "Mail already taken !";
        return (TRUE);
    }
    else
        return (FALSE);
}

function check_user_exist2($login, $id_user)
{
    $db = db_connect();
    $req = $db->prepare('SELECT * FROM user WHERE username = :log AND id_user != :id');
    $req->bindParam(':log', $login);
    $req->bindParam(':id', $id_user);
    $req->execute();
    if ($req->rowCount() == 1)
    {
        echo "Username already taken !";
        return (TRUE);
    }
    else
        return (FALSE);
}

function check_mail_exist2($mail, $id_user)
{
    $db = db_connect();
    $req = $db->prepare('SELECT * FROM user WHERE mail = :mail AND id_user != :id');
    $req->bindParam(':mail', $mail);
    $req->bindParam(':id', $id_user);
    $req->execute();
    if ($req->rowCount() == 1)
    {
        echo "Mail already taken !";
        return (TRUE);
    }
    else
        return (FALSE);
}

/* REGISTRATION */
function mail_to_user($login, $mail, $token)
{
    $to = $mail;
    $subject = "Camagru: Activate your account now !";
    $message = $login."! Please use this link to start your journey on Camagru !\n".
    "http://localhost:8080/camagru/index.php?page=activation&code=".$token;
    $headers = "From: camagru@42.fr";
    if (mail($to, $subject, $message, $headers))
        echo "Activation code has been sent to your email !";
    else
        echo "Oups... sending error";
}

function register_pending_user($login, $passwd, $mail)
{
    $db = db_connect();
    $pass = hash('whirlpool', $passwd);
    $token = hash('sha1', mt_rand(1000000, 9999999));
    $req = $db->prepare('INSERT INTO pending_user (username, password, mail, token, creation_date) VALUES (:log, :pwd, :mail, :tok, CURRENT_TIMESTAMP())');
    $req->bindParam(':log', $login);
    $req->bindParam(':pwd', $pass);
    $req->bindParam(':mail', $mail);
    $req->bindParam(':tok', $token);
    $req->execute();
    mail_to_user($login, $mail, $token);
}

function check_activation($token)
{
    $db = db_connect();
    $req = $db->prepare('SELECT token FROM pending_user WHERE token = :tok');
    $req->bindParam(':tok', $token);
    $req->execute();
    if ($req->rowCount() == 1)
    {
        $req = $db->prepare('INSERT INTO user (username, password, mail, creation_date) SELECT username, password, mail, creation_date FROM pending_user');
        $req->execute();
        $req = $db->prepare('DELETE FROM pending_user WHERE token = :tok');
        $req->bindParam(':tok', $token);
        $req->execute();
        return (TRUE);
    }
    else
    {
        error('Wrong activation code !');
        return (FALSE);
    }
}

/* LOGIN */
function check_reset($passwd, $db)
{
    $req = $db->prepare('SELECT password FROM user WHERE password = :pwd');
    $req->bindParam(':pwd', $passwd);
    $req->execute();
    if ($req->rowCount() == 1)
        return (TRUE);
    else
        return (FALSE);
}

function auth($login, $passwd)
{
    $db = db_connect();
    if (check_reset($passwd, $db))
        $pass = $passwd;
    else
        $pass = hash('whirlpool', $passwd);
    $req = $db->prepare('SELECT username, password FROM user WHERE username = :log AND password = :pwd');
    $req->bindParam(':log', $login);
    $req->bindParam(':pwd', $pass);
    $req->execute();
    if ($req->rowCount() == 1)
    {
        echo "Connected";
        return (TRUE);
    }
    else
    {
        echo "Wrong Username/Password !";
        return (FALSE);
    }
}

/* RESET PASSWORD */
function check_reset_password($token)
{
    $db = db_connect();
    $req = $db->prepare('SELECT password FROM user WHERE password = :tok');
    $req->bindParam(':tok', $token);
    $req->execute();
    if ($req->rowCount() == 1)
        return (TRUE);
    else
        return (FALSE);
}

function mail_password($mail){
    $db = db_connect();
    $req = $db->prepare('SELECT mail FROM user WHERE mail = :mail');
    $req->bindParam(':mail', $mail);
    $req->execute();
    if ($req->rowCount() == 1)
    {
        $token = hash('sha1', mt_rand(1000000, 9999999));
        $req = $db->prepare('UPDATE user SET password = :tok WHERE mail = :mail');
        $req->bindParam(':tok', $token);
        $req->bindParam(':mail', $mail);
        $req->execute();
        $to = $mail;
        $subject = "Camagru: Password reset !";
        $message = "Please use this link to use your account !\n".
        "http://localhost:8080/camagru/index.php?page=reset2&code=".$token;
        $headers = "From: camagru@42.fr";
        mail($to, $subject, $message, $headers);
        echo "Mail has been sent!";
        homepage();
    }
    else
        error("Mail doesn't exist!");
}

function new_password_reset($pwd, $token)
{
    $newpass = hash('whirlpool', $pwd);
    $db = db_connect();
    $req = $db->prepare('UPDATE user SET password = :new WHERE password = :tok');
    $req->bindParam(':new', $newpass);
    $req->bindParam(':tok', $token);
    $req->execute();
}

/* USER INFO */
function edit_info($login, $mail, $id_user)
{
    $db = db_connect();
    $req = $db->prepare('UPDATE user SET username = :log, mail = :mail WHERE id_user = :id');
    $req->bindParam(':log', $login);
    $req->bindParam(':mail', $mail);
    $req->bindParam(':id', $id_user);
    $req->execute();
    echo "User info updated !";
}

function change_password($oldpwd, $newpwd, $id_user)
{
    $oldpass = hash('whirlpool', $oldpwd);
    $newpass = hash('whirlpool', $newpwd);
    $db = db_connect();
    $req = $db->prepare('SELECT password FROM user WHERE password = :old');
    $req->bindParam(':old', $oldpass);
    $req->execute();
    if ($req->rowCount() == 1)
    {
        $req = $db->prepare('UPDATE user SET password = :new WHERE id_user = :id');
        $req->bindParam(':new', $newpass);
        $req->bindParam(':id', $id_user);
        $req->execute();
        echo "Password changed!!";
    }
    else
        echo "Wrong pasword ! Try Again !";
}

function notif_change($id_user, $notif)
{
    $db = db_connect();
    if ($notif == 0)
        $req = $db->prepare('UPDATE user SET notif = 0 WHERE id_user = :id');
    else
        $req = $db->prepare('UPDATE user SET notif = 1 WHERE id_user = :id');
    $req->bindParam(':id', $id_user);
    $req->execute();
    echo "Email notifications updated !";
}

/* GALLERY */
function get_gallery($cPage, $perPage) {
    $db = db_connect();
    $req = $db->prepare('SELECT id_photo, id_user, nb_like, photo_path FROM photo ORDER BY creation_date DESC LIMIT '.(($cPage-1)*$perPage).",$perPage");
    $req->execute();
    $result = $req->fetchAll();
    return ($result);
}

function get_mygallery($id_user){
    $db = db_connect();
    $req = $db->prepare('SELECT id_photo, id_user, nb_like, photo_path FROM photo WHERE id_user = :id ORDER BY creation_date DESC');
    $req->bindParam(':id', $id_user);
    $req->execute();
    $result = $req->fetchAll();
    return ($result);
}

function get_like($id_photo, $id_user)
{
    $db = db_connect();
    $req = $db->prepare('SELECT liked FROM photo_like WHERE id_photo = :pho AND id_user = :usr');
    $req->bindParam(':pho', $id_photo);
    $req->bindParam(':usr', $id_user);
    $req->execute();
    $result = $req->fetch();
    if ($req->rowCount() == 1)
    {
        if ($result['liked'] == 1)
            $src = 'img/heart-full.png';
        else
            $src = 'img/heart-empty.png';
        return($src);
    }
    else 
    {
        $src = 'img/heart-empty.png';
        return($src);
    }
}

function add_like($id_photo, $id_user)
{
    $db = db_connect();
    $req = $db->prepare('SELECT liked FROM photo_like WHERE id_photo = :pho AND id_user = :usr');
    $req->bindParam(':pho', $id_photo);
    $req->bindParam(':usr', $id_user);
    $req->execute();
    if ($req->rowCount() == 1)
    {
        $result= $req->fetch();
        if ($result['liked'] == 0)
        {
            $req = $db->prepare('UPDATE photo_like SET liked = 1 WHERE id_photo = :pho AND id_user = :usr');
            $req->bindParam(':pho', $id_photo);
            $req->bindParam(':usr', $id_user);
            $req->execute();
            $req = $db->prepare('UPDATE photo SET nb_like = nb_like + 1 WHERE id_photo = :pho');
            $req->bindParam(':pho', $id_photo);
            $req->execute();
        }
        else
        {
            $req = $db->prepare('UPDATE photo_like SET liked = 0 WHERE id_photo = :pho AND id_user = :usr');
            $req->bindParam(':pho', $id_photo);
            $req->bindParam(':usr', $id_user);
            $req->execute();
            $req = $db->prepare('UPDATE photo SET nb_like = nb_like - 1 WHERE id_photo = :pho');
            $req->bindParam(':pho', $id_photo);
            $req->execute();
        }
    }
    else
    {
        $req = $db->prepare('INSERT INTO photo_like (id_photo, id_user, liked) VALUES (:pho, :usr, 1)');
        $req->bindParam(':pho', $id_photo);
        $req->bindParam(':usr', $id_user);
        $req->execute();
        $req = $db->prepare('UPDATE photo SET nb_like = nb_like + 1 WHERE id_photo = :pho');
        $req->bindParam(':pho', $id_photo);
        $req->execute();
    }
}

function delete_photo($id_photo)
{
    $db = db_connect();
    $req = $db->prepare('DELETE FROM photo WHERE id_photo = :id');
    $req->bindParam(':id', $id_photo);
    $req->execute();
    echo "Photo deleted !!!";
}

/* COMMENT */
function get_comment($id_photo){
    $db = db_connect();
    $req = $db->prepare('SELECT * FROM comment WHERE id_photo = :id');
    $req->bindParam(':id', $id_photo);
    $req->execute();
    $result = $req->fetchAll();
    return ($result);
}

function insert_comment($id_photo, $id_user, $content)
{
    $db = db_connect();
    $req = $db->prepare('INSERT INTO comment (id_photo, id_user, content, creation_date) VALUES (:pho, :usr, :cont, CURRENT_TIMESTAMP())');
    $req->bindParam(':pho', $id_photo);
    $req->bindParam(':usr', $id_user);
    $req->bindParam(':cont', $content);
    $req->execute();
}

function send_notif($id_photo, $username)
{
    $db = db_connect();
    $req = $db->prepare('SELECT user.id_user, user.username, user.mail, user.notif FROM user 
                        INNER JOIN photo ON user.id_user = photo.id_user
                        WHERE id_photo = :id');
    $req->bindParam(':id', $id_photo);
    $req->execute();
    $result = $req->fetch();
    if ($result['notif'] == 1)
    {
        $to = $result['mail'];
        $subject = "Camagru: New comment !";
        $message = $username." has commented your photo";
        $headers = "From : camagru@42.fr";
        mail($to, $subject, $message, $headers);
    }
}

function get_username($id_user)
{
    $db = db_connect();
    $req = $db->prepare('SELECT username FROM user WHERE id_user = :id');
    $req->bindParam(':id', $id_user);
    $req->execute();
    $result = $req->fetchColumn();
    return ($result);
}

/* MONTAGE */
function previous_montage($id_user){
    $db = db_connect();
    $req = $db->prepare('SELECT photo_path FROM photo WHERE id_user = :id ORDER BY creation_date DESC LIMIT 3');
    $req->bindParam(':id', $id_user);
    $req->execute();
    $result = $req->fetchAll();
    return ($result);
}

function insert_photo($id_user, $file)
{
    $db = db_connect();
    $req = $db->prepare('INSERT INTO photo (id_user, nb_like, photo_path, creation_date) VALUES (:id, "0", :pat, NOW())');
    $req->bindParam(':id', $id_user);
    $req->bindParam(':pat', $file);
    $req->execute();
}

function savepicture($hidden_data, $hidden_filter, $id_user){
    if (file_exists('upload/') === FALSE)
        mkdir('upload/');
    $upload_dir = "upload/";
    $img = $hidden_data;
    $img = str_replace('data:image/png;base64,', '', $img);
    $img = str_replace(' ', '+', $img);
    $data = base64_decode($img);

    // On charge d'abord les images
    $source = imagecreatefrompng($hidden_filter); // Le logo est la source
    $destination = imagecreatefromstring($data); // La photo est la destination

    //REDIMENSION CAMERA OU IMAGE (300x300)
    $thumb_width = 300;
    $thumb_height = 300;
    $largeur_destination = imagesx($destination);
    $hauteur_destination = imagesy($destination);
    $original_aspect = $largeur_destination / $hauteur_destination;
    $thumb_aspect = $thumb_width / $thumb_height;

    if ( $original_aspect >= $thumb_aspect )
    {
        // If image is wider than thumbnail (in aspect ratio sense)
        $new_height = $thumb_height;
        $new_width = $largeur_destination / ($hauteur_destination / $thumb_height);
    }
    else
    {
        // If the thumbnail is wider than the image
        $new_width = $thumb_width;
        $new_height = $hauteur_destination / ($largeur_destination / $thumb_width);
    }
    $thumb = imagecreatetruecolor($thumb_width, $thumb_height);
    // Resize and crop
    imagecopyresampled($thumb,
    $destination,
    0 - ($new_width - $thumb_width) / 2, // Center the image horizontally
    0 - ($new_height - $thumb_height) / 2, // Center the image vertically
    0, 0,
    $new_width, $new_height,
    $largeur_destination, $hauteur_destination);
    $file = $upload_dir . mktime(). ".png";
    imagepng($thumb, $file);

    //Localisation des coordonnees pour le collage
    $destination = imagecreatefrompng($file);
    $largeur_source = imagesx($source);
    $hauteur_source = imagesy($source);
    $largeur_destination = imagesx($destination);
    $hauteur_destination = imagesy($destination);
    $destination_x = ($largeur_destination / 2) - $largeur_source;
    $destination_y = ($hauteur_destination / 2) - $hauteur_source;

    // On met le logo (source) dans l'image de destination (la photo)
    imagecopy($destination, $source, $destination_x, $destination_y, 0, 0, $largeur_source, $hauteur_source);
    imagepng($destination, $file);
    insert_photo($id_user, $file);
}
?>