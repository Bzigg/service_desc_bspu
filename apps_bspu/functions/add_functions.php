<?php

$errorMessage = '';

include_once('connect.php');
include_once('common_functions.php');

function add_structural(){
    if ( isset ( $_POST[ 'structural_button' ] ) ){
        $connection = connectFunc();

        if ( isset( $_POST['structural_name'], $_POST['structural_email'], $_POST['structural_tel'], $_POST['structural_login'], $_POST['structural_password'] ) ){

            $structural_name = securityMySQL( $connection,$_POST['structural_name']);
            $structural_email = securityMySQL( $connection,$_POST['structural_email']);
            $structural_tel = securityMySQL( $connection,$_POST['structural_tel']);
            $structural_login = securityMySQL( $connection,$_POST['structural_login']);
            $structural_password = securityMySQL( $connection,$_POST['structural_password']);
            $structural_password2 = securityMySQL( $connection,$_POST['structural_password2']);

            if ( $structural_password === $structural_password2 ){

                $structural_info = array(
                    "structural_name" => $structural_name,
                    "structural_email" => $structural_email,
                    "structural_tel" => $structural_tel,
                    "structural_login" => $structural_login,
                    "structural_password" => $structural_password
                );

                checkStructural( $structural_info );
                #отправить на проверку
            }
            else {
                echo '
                    <script>
                        alert("Пароли не совподают");
                    </script>
                ';
            }
        }
        // else {
        //     echo '
        //         <script>
        //             alert("Заполните поля");
        //         </script>
        //     '; 
        // }
    }

}

function checkStructural( $structural_info ){
    global $errorMessage;
    if ( check_ru( $structural_info['structural_name'] ) && check_email( $structural_info['structural_email'] ) && check_login( $structural_info['structural_login'] ) && check_tel( $structural_info['structural_tel'] ) && check_password( $structural_info['structural_password'] ) ){

        switch ( true ) {
            case ( indentityFunction( $structural_info['structural_name'], $structural_info['structural_login'] ) ):
                add_structural_function( $structural_info );
                break;
            
            default:
                echo '
                        login или структура уже существует
                     ';
                break;
        }

    }
}

function check_ru( $element ){
    global $errorMessage;
    // как задать длинну поля? [а-яА-ЯЁё]{2,25}
    if ( preg_match( '/^([а-яА-ЯЁё\s]{2,75}+)$/u', $element ) ){
        return true;
    }
    else {
        $errorMessage .= 'Ошибка в наименовании структуры';
        return false;
    }

}

function check_email( $element ){
    global $errorMessage;

    if ( preg_match( '/^(?:[a-z0-9]+(?:[-_.]?[a-z0-9]+)?@[a-z0-9_.-]+(?:\.?[a-z0-9]+)?\.[a-z]{2,5})$/i', $element ) ){
        return true;
    }
    else {
        $errorMessage .= ', почте';
        return false;
    }
    
}

function check_login( $element ){
    global $errorMessage;

    if ( preg_match( '/^[a-zA-Z0-9]{3,30}$/', $element ) ){
        return true;
    }
    else {
        $errorMessage .= ', логине';
        return false;
    }
    
}

function check_tel( $element ){
    global $errorMessage;

    if ( preg_match( '/^[0-9+]{3,30}$/', $element ) ){
        return true;
    }
    else {
        $errorMessage .= ', телефонет';
        return false;
    }
}

function check_password( $element ){
    global $errorMessage;

    if ( preg_match( '/^[a-zA-Z0-9]{3,30}$/', $element ) ){
        return true;
    }
    else {
        $errorMessage .= ', пароле';
        return false;
    }
}

function indentityFunction( $structural_name, $structural_login ){
    $connection = connectFunc();

    $query_indentity = "SELECT * FROM `service_desk`.`structurals` WHERE `structural_name` = '$structural_name' AND `structural_login` = '$structural_login' ";
    $result_query = $connection->query( $query_indentity );
    $row = $result_query -> fetch_array(MYSQLI_ASSOC);

    @$indentity_name = $row['structural_name'];
    @$indentity_login = $row['structural_login'];

    if ( ($indentity_name===$structural_name) || ($indentity_login===$structural_login) ){
        echo '<div class="indentity">Такой login и / или структура существует.</div><br>';
        return false;
    }
    else{
        return true;
    }
}

function add_structural_function( $structural_info ) {
    $connection = connectFunc();

    $structural_info['structural_password'] = password_hash( $structural_info['structural_password'], PASSWORD_DEFAULT );
    $structural_status = true;

    $structural_name = $structural_info['structural_name'];
    $structural_email = $structural_info['structural_email'];
    $structural_tel = $structural_info['structural_tel'];
    $structural_login = $structural_info['structural_login'];
    $structural_password = $structural_info['structural_password'];

    $query_structural_add = "INSERT INTO `service_desk`.`structurals` (`structural_name`,`structural_email`,`structural_tel`,`structural_login`,`structural_password`,`structural_status` ) VALUES ( '$structural_name','$structural_email','$structural_tel','$structural_login','$structural_password','$structural_status' ) ";
    $result_query = $connection -> query( $query_structural_add );

    // НЕ НУЖНО
    // if ( $result_query ) {
    //     $query_indentity = "SELECT * FROM `service_desk`.`structurals` WHERE `structural_login` = '$structural_login'";
    //     $result_query = $connection->query( $query_indentity );
    //     $row = $result_query -> fetch_array(MYSQLI_ASSOC);
    //     $id_structural = $row['id_structural'];
     
    //     #додумать таблицу заявок
    //     #$query_structural_db = "CREATE TABLE `service_desk`.`structural_$id_structural` ( `id` INT NOT NULL AUTO_INCREMENT , `id_apps` INT NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;";
    //     #$result_query = $connection -> query( $query_user_db );
    //     if ($result_query){
    //         echo 'успешно добавленно';
    //         echo '<meta http-equiv="refresh" content="0; url=authorization.php">';
            
    //     }

    // }
    // else {
    //     echo $result_query;
        
    // }
}

