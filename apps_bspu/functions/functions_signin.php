<?php

include_once('connect.php');
include_once('common_functions.php');

function sign_in_func(){
    if ( isset( $_POST['submit'] ) ){
        $connection = connectFunc();

        if ( isset( $_POST['login'], $_POST['password'] ) ){
            $login_user = securityMySQL( $connection,$_POST['login']);
            $password_user = securityMySQL( $connection,$_POST['password']);

            $query_user = "SELECT * FROM `service_desk`.`users` WHERE `login` = '$login_user'";

            $result_query = $connection -> query( $query_user );

            if( !$result_query ) die ("пользователь не найден");
            else if ( $result_query -> num_rows ){
                $row = $result_query -> fetch_array ( MYSQLI_NUM );


                if ( password_verify( $password_user, $row[6] ) ){
                    session_start();
                    $_SESSION['username'] = $login_user;
                    $_SESSION['userpass'] = $password_user;

                    $result_query -> close();
                    echo '<meta http-equiv="refresh" content="0; url=admin.html">';
                }
                else{
                    echo 'неверный пароль';

                }
            }
        }

    }
}

function sign_out_func(){
    if ( @$_GET['sign_out'] ){  #Warning: Undefined array key "close" in D:\xampp\htdocs\regapp\admin.php on line 67
        session_destroy();
    }
}








?>