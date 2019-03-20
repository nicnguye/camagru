<?php $titre = 'Login'; ?>

<?php ob_start(); ?>

<div class='form-div'>
    <header class='form-header'>
        <h1>Sign In</h1>
        <p><em>Enter your login and password.</em></p>
    </header>
    <form action='index.php?page=login' method='post' class='form-input'>
        <div class='form-row'>
            <label for='login'>Login</label>
            <input id='login' name='login' type='text'/>
        </div>
        <div class='form-row'>
            <label for='passwd'>Password</label>
            <input id='passwd' name='passwd' type='password'/>
        </div>
        <div class='form-row'>
            <input id='submit' name='submit' type='submit' value='OK'/>
        </div>
    </form>
    <form action='index.php?page=reset' method='post'>
        <input type="submit" name="reset" value="Réinitialiser le mot de passe">
    </form>
</div>

<?php $content = ob_get_clean(); ?>

<?php require 'view/layout.php' ?>