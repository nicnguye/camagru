<?php
    require 'database.php';

    function create_user($bdd){
        $req = "CREATE TABLE `db_camagru`.`user`
        (
            `id_user` int PRIMARY KEY AUTO_INCREMENT NOT NULL , 
            `username` VARCHAR(25) NOT NULL UNIQUE, 
            `password` VARCHAR(255) NOT NULL , 
            `mail` VARCHAR(255) NOT NULL , 
            `notif` BIT DEFAULT 1 , 
            `creation_date` DATETIME NOT NULL
        )";
        $sql = $bdd->prepare($req);
        $sql->execute();

        $db = new PDO('mysql:host=127.0.0.1;dbname=db_camagru;charset=utf8', 'root', 'root');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pass = hash('whirlpool', 'root');
        $new = $db->prepare('INSERT INTO user (username, password, mail, creation_date) VALUES ("root", :pwd, "root@gmail.com", "2018-10-01")');
        $new->bindParam(':pwd', $pass);
        $new->execute();
        $pass = hash('whirlpool', 'test');
        $new = $db->prepare('INSERT INTO user (username, password, mail, creation_date) VALUES ("test", :pwd, "test@gmail.com", "2018-10-04")');
        $new->bindParam(':pwd', $pass);
        $new->execute();
    }

    function create_pending_user($bdd){
        $req = "CREATE TABLE `db_camagru`.`pending_user`
        (
            `id_user` int PRIMARY KEY AUTO_INCREMENT NOT NULL , 
            `username` VARCHAR(25) NOT NULL UNIQUE, 
            `password` VARCHAR(255) NOT NULL , 
            `mail` VARCHAR(255) NOT NULL ,
            `token` VARCHAR(40) NOT NULL,
            `creation_date` DATETIME NOT NULL
        )";
        $sql = $bdd->prepare($req);
        $sql->execute();
    }

    function create_photo($bdd){
        $req = "CREATE TABLE `db_camagru`.`photo` 
        (
            `id_photo` INT PRIMARY KEY AUTO_INCREMENT NOT NULL, 
            `id_user` INT NOT NULL , 
            `nb_like` INT NULL DEFAULT NULL, 
            `photo_path` VARCHAR(255) NOT NULL ,
            `creation_date` DATETIME NOT NULL
        )";
        $sql = $bdd->prepare($req);
        $sql->execute();

        $db = new PDO('mysql:host=127.0.0.1;dbname=db_camagru;charset=utf8', 'root', 'root');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $new = $db->prepare('INSERT INTO photo (id_user, nb_like, photo_path, creation_date) VALUES ("1", "2", "img/test1.png", "2018-10-01")');
        $new->execute();
        $new = $db->prepare('INSERT INTO photo (id_user, nb_like, photo_path, creation_date) VALUES ("1", "5", "img/test2.png", "2018-10-02")');
        $new->execute();
        $new = $db->prepare('INSERT INTO photo (id_user, nb_like, photo_path, creation_date) VALUES ("1", "0", "img/test3.png", "2018-10-03")');
        $new->execute();
        $new = $db->prepare('INSERT INTO photo (id_user, nb_like, photo_path, creation_date) VALUES ("1", "3", "img/test4.png", "2018-10-04")');
        $new->execute();
        $new = $db->prepare('INSERT INTO photo (id_user, nb_like, photo_path, creation_date) VALUES ("2", "10", "img/test5.png", "2018-10-05")');
        $new->execute();
        $new = $db->prepare('INSERT INTO photo (id_user, nb_like, photo_path, creation_date) VALUES ("2", "6", "img/test6.png", "2018-10-06")');
        $new->execute();
        $new = $db->prepare('INSERT INTO photo (id_user, nb_like, photo_path, creation_date) VALUES ("2", "7", "img/test7.png", "2018-10-07")');
        $new->execute();
        $new = $db->prepare('INSERT INTO photo (id_user, nb_like, photo_path, creation_date) VALUES ("2", "1", "img/test8.png", "2018-10-10")');
        $new->execute();
    }

    function create_like($bdd){
        $req = "CREATE TABLE `db_camagru`.`photo_like` 
        (
            `id_photo` INT NOT NULL, 
            `id_user` INT NOT NULL , 
            `liked` BIT DEFAULT 0
        )";
        $sql = $bdd->prepare($req);
        $sql->execute();
    }

    function create_comment($bdd){
        $req = "CREATE TABLE `db_camagru`.`comment` 
        ( 
            `id_comment` INT PRIMARY KEY AUTO_INCREMENT NOT NULL, 
            `id_photo` INT NOT NULL ,
            `id_user` INT NOT NULL , 
            `content` VARCHAR(255) NOT NULL, 
            `creation_date` DATE NOT NULL
        )";
        $sql = $bdd->prepare($req);
        $sql->execute();
        $db = new PDO('mysql:host=127.0.0.1;dbname=db_camagru;charset=utf8', 'root', 'root');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $new = $db->prepare('INSERT INTO comment (id_photo, id_user, content, creation_date) VALUES ("1", "2", "woah", "2018-10-04")');
        $new->execute();
        $new = $db->prepare('INSERT INTO comment (id_photo, id_user, content, creation_date) VALUES ("2", "2", "c bo", "2018-10-04")');
        $new->execute();
        $new = $db->prepare('INSERT INTO comment (id_photo, id_user, content, creation_date) VALUES ("3", "2", "cool cool!", "2018-10-04")');
        $new->execute();
        $new = $db->prepare('INSERT INTO comment (id_photo, id_user, content, creation_date) VALUES ("4", "2", "ligma", "2018-10-05")');
        $new->execute();
        $new = $db->prepare('INSERT INTO comment (id_photo, id_user, content, creation_date) VALUES ("4", "2", "ballz", "2018-10-06")');
        $new->execute();
        $new = $db->prepare('INSERT INTO comment (id_photo, id_user, content, creation_date) VALUES ("5", "2", "...", "2018-10-06")');
        $new->execute();
        $new = $db->prepare('INSERT INTO comment (id_photo, id_user, content, creation_date) VALUES ("6", "2", "bof", "2018-10-07")');
        $new->execute();
    }

    try {
        $bdd = new PDO('mysql:host=127.0.0.1;charset=utf8', $DB_USER, $DB_PASSWORD);
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $req = "SHOW DATABASES LIKE '$DB_NAME'";
        $sql = $bdd->prepare($req);
        $sql->execute();
        if ($sql->rowCount() != 1)
        {
            $req = "CREATE DATABASE $DB_NAME";
            $sql = $bdd->prepare($req);
            $sql->execute();
            create_user($bdd);
            create_pending_user($bdd);
            create_photo($bdd);
            create_comment($bdd);
            create_like($bdd);
        }
    } catch (PDOException $e) {
        die('Échec: ' . $e->getMessage());
    }
?>