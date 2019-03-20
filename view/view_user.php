<?php $titre = 'User Account'; ?>

<?php ob_start(); ?>

<h1>User Account</h1>

<div>
<form action='index.php?page=user' method='post'>
    <fieldset>
        <legend>Personal Information: </legend><br/>
        <div><p>Username:</p></div>
        <div><input type='text' name='username' value='<?php echo $_SESSION['logged_on_user'] ?>' /></div>
        <div><p>Mail:</p></div>
        <div><input type='email' name='mail' value='<?php echo $_SESSION['mail'] ?>' /></div>
        <br/>
        <div><input type='submit' name='submit' value='Editer'></div><br/>
    </fieldset>
</form>
</div>
<br/>
<div>
<form action='index.php?page=user' method='post'>
    <fieldset>
        <legend>Change password:</legend><br/>
        <div><p>Old pasword:</p></div>
        <div><input type='password' name='oldpwd' value='' /></div>
        <div><p>New password:</p></div>
        <div><input type='password' name='newpwd' value='' /></div>
        <br/>
        <div><input type='submit' name='submit' value='Change'></div>
        <br/>
    </fieldset>
</form>
</div>
<br/>
<div>
<form action='index.php?page=user' method='post'>
    <fieldset>
        <legend>Options</legend>
        <div><p>Email notifications:</p></div><br>
        <div><input type='radio' name='notif' value=1 <?php if ($_SESSION['notif'] == 1) echo 'checked' ?>>Yes</div><br>
        <div><input type='radio' name='notif' value=0 <?php if ($_SESSION['notif'] == 0) echo 'checked' ?>>No</div><br>
        <div><input type='submit' name='submit' value='Submit'></div>
    </fieldset>
</form>
</div>

<?php $content = ob_get_clean(); ?>

<?php require 'view/layout.php' ?>