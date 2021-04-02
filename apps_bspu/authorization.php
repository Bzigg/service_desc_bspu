<?php
    include_once('functions/functions_signin.php');
    include_once('functions/common_functions.php');

    head( 'Авторизация' );
?>


    <div class="container">
        <div class="main_inner">
            <div class="login_window">
                <form class="form_login" action="authorization.php" method="post">
                    <p>Авторизация</p>
                    <input type="text" name="login" placeholder="login">
                    <input type="password" name="password" placeholder="password">
                    <input type="submit" name="submit" value="Войти" id="submit">
                </form>
            </div>
        </div>
    </div>

<?php
    sign_in_func();
    footer();
?>