<?php

function securityString( $value ){
    $value = stripslashes ( $value );
    $value = htmlentities ( $value );
    $value = strip_tags ( $value );
    return $value;
}

function securityMySQL( $connection, $value ){
    include_once('connect.php');
    $connection = connectFunc();
    $value = $connection->real_escape_string( $value );
    $value = securityString( $value );
    return $value;
}

function head( $title ){
    echo'
    <!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>'.$title.'</title>
<link rel="stylesheet" href="style/core.css">
</head>
<body>
<div class="wrapper">
<header>
    <div class="container">
        <div class="header_inner">
            <div class="title_logo">
                <img class="logo" src="images/logo-bspu-blue.png" alt="logo-bspu">
                <div class="title_txt">
                    БГПУ<br>им. М. Акмуллы
                </div>
            </div>
            <nav class="nav">
            ';
            nav( $title );
            echo '
            </nav>
        </div>
    </div>
</header>
<main>
    ';
}

function nav( $title ){
    if ( ($title === 'Регистрация') || ($title === 'Авторизация') ){
        echo '
        <ul>
             <li><a href="#">Войти</a></li>
        </ul>
        ';
    }
    else{

        echo '
            <ul>
                <li><a href="#">Главная</a></li>
                <li><a href="#">Все заявки</a></li>
                <li><a href="#">Добавить подразделение</a></li>
                <li><a href="#">Выход</a></li>
            </ul>
        ';
    }
}

function footer(){
echo '
</main>

<footer>
    <div class="container">
        <div class="footer_inner">
            <div class="official">
                <a href="#" class="off_site">
                    <img src="images/logo-bspu-w.png" alt="logo-bspu" class="logo_footer">
                    <div class="official_txt">
                        Официальный сайт <br>
                        БГПУ им. М. Акмуллы
                    </div>
                </a>
            </div>
            <div class="support">
                <a href="mailto:openedu@bspu.ru" class="support_link">
                    Написать администраторам
                </a>
            </div>
        </div>
    </div>
</footer>
</div>
</body>
</html>
';
}

?>