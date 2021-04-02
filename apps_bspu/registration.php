<?php
    include_once('functions/functions_signup.php');
    include_once('functions/common_functions.php');

    head( 'Регистрация' );
?>
<div class="container">
    <div class="main_inner">
        <div class="reg_window">
            <form class="form_login" action="registration.php" method="post">
                <p>Регистрация</p>
                <input type="text" name="first_name" placeholder="Имя">
                <input type="text" name="last_name" placeholder="Фамилия">
                <input type="text" name="middle_name" placeholder="Отчество">
                <input type="email" name="email" placeholder="email">
                <input type="text" name="login" placeholder="login">
                <input type="password" name="password" placeholder="пароль">
                <input type="password" name="password2" placeholder="повторите пароль">
                    <p><input type="radio" name="person_post" value="pc" checked>ПК</p>
                    <p><input type="radio" name="person_post" value="poe">Оргтехника и переферия</p>
                    <p><input type="radio" name="person_post" value="net">Сети</p>
                    <p><input type="radio" name="person_post" value="soft">Софт</p>
                    <p><input type="radio" name="person_post" value="all">Всё</p>
                <input type="submit" name="submit" value="Регистрация" id="submit">
            </form>
        </div>
    </div>
</div>

<?php
    inputInfo();
    //


    //
    footer();
?>