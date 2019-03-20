<?php $titre = 'Signup'; ?>

<?php ob_start(); ?>

<div class='form-div'>
    <header class='form-header'>
        <h1>Registration</h1>
        <p><em>Fill out this form for registration.</em></p>
    </header>
    <form action='index.php?page=register' method='post' class='form-input'>
        <div class='form-row'>
            <label for='login'>Login</label>
            <input id='login' name='login' type='text' required />
        </div>
        <div class='form-row'>
            <label for='passwd'>Password</label>
            <input id='passwd' name='passwd' type='password' required />
        </div>
        <div class='form-row'>
            <label for='mail'>Email</label>
            <input id='mail' name='mail' type='email' placeholder='joe@example.com' required />
        </div>
        <div class='form-row'>
            <input id='submit' name='submit' type='submit' value='OK'/>
        </div>
    </form>
</div>

<?php $content = ob_get_clean(); ?>

<?php require 'view/layout.php' ?>