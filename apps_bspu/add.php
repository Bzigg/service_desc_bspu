<?php
    include_once('functions/add_functions.php');
    include_once('functions/common_functions.php');

    head( 'Добавить подразделение' );
?>

    <div class="container">
        <div class="main_inner">
            <div class="login_window">
                <form class="form_login" action="add.php" method="post">
                    <p>Новое структурное подразделение</p>
                    <input type="text" name="structural_name" placeholder="Наименование">
                    <input type="email" name="structural_email" placeholder="email">
                    <input type="tel" name="structural_tel" placeholder="телефон">
                    <input type="login" name="structural_login" placeholder="login">
                    <input type="password" name="structural_password" placeholder="пароль">
                    <input type="password" name="structural_password2" placeholder="повторите пароль">
                    <input type="submit" name="structural_button" value="Добавить" id="submit">
                </form>
            </div>
        </div>
    </div>

<?php
    add_structural();

    footer();
?>