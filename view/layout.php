<!doctype html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" charset="UTF-8" />
        <link rel="stylesheet" href="style/style.css" />
        <link rel="stylesheet" href="style/menu.css" />
        <link rel="stylesheet" href="style/form.css" />
        <title><?php echo $titre ?></title>
    </head>
    <body>
        <div>
            <div id="menu"><?php require 'view/view_menu.php'; ?></div>
            <div><?php echo $content ?></div>
            <div id="footer">&copy; nicnguye</div>
        </div>
    </body>
</html>