<?php
	include_once('connect.php');
	include_once('common_functions.php');
    // $connection = connectFunc();

    $errorMessage = '';
    global $errorMessage;


function inputInfo(  ){
    
    if ( isset( $_POST['submit'] ) ){
        // include_once('connect.php');
        $connection = connectFunc();

        if ( isset( $_POST['first_name'], $_POST['last_name'], $_POST['middle_name'], $_POST['email'], $_POST['login'], $_POST['password'], $_POST['password2'], $_POST['person_post'] ) ){

            $first_name = securityMySQL( $connection,$_POST['first_name']);
            $last_name = securityMySQL( $connection,$_POST['last_name']);
            $middle_name = securityMySQL( $connection,$_POST['middle_name']);
            $email = securityMySQL( $connection,$_POST['email']);
            $login = securityMySQL( $connection,$_POST['login']);
            $password = securityMySQL( $connection,$_POST['password']);
            $password2 = securityMySQL( $connection,$_POST['password2']);
            $person_post = securityMySQL( $connection,$_POST['person_post']);

            if ( $password === $password2 ) {
                $user_info = array(
                    "first_name" => $first_name,
                    "last_name" => $last_name,
                    "middle_name" => $middle_name,
                    "email" => $email,
                    "login" => $login,
                    "password" => $password,
                    "person_post" => $person_post
                );
                checkInfo( $user_info );
                
            }
            else {
                echo '
                        <script>
                            alert("Пароли не совподают");
                        </script>
                     ';
            }

        }
        else{
            echo '<script>
                    alert("заполните форму");
                  </script>';
            // echo '<div class="error_reg">Заполните форму</div>';
        }
    }

}

function checkInfo( $user_info ){
    //придумаь с foreach
    global $errorMessage;
    if ( check_ru( $user_info['first_name'] ) && check_ru( $user_info['last_name'] ) && check_ru( $user_info['middle_name'] ) && check_email( $user_info['email'] ) && check_login( $user_info['login'] ) && check_password( $user_info['password'] ) ){
        // responsibility( $user_info['person_post'] );
        // echo $user_info['person_post'];
        // свич: если тру пишем в бд, если фолс сообщение об ошибке

        switch ( true ) {
            case ( indentityFunction( $user_info['login'], $user_info['email'] ) ):
                signUp_function( $user_info );
                break;
            
            default:
                echo '
                        Почта или логин уже существует
                     ';
                break;
        }

    }
    else{
        echo $errorMessage;
    }

}

function check_ru( $element ){
    global $errorMessage;
    // как задать длинну поля? [а-яА-ЯЁё]{2,25}
    if ( preg_match( '/^([а-яА-ЯЁё]{2,25}+)$/u', $element ) ){
        return true;
    }
    else {
        $errorMessage .= 'Ошибка в ФИО';
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

function indentityFunction( $login, $email ){
    $connection = connectFunc();

    $query_indentity = "SELECT * FROM `service_desk`.`users` WHERE `login` = '$login' AND `email` = '$email' ";
    $result_query = $connection->query( $query_indentity );
    $row = $result_query -> fetch_array(MYSQLI_ASSOC);

    @$indentity_email = $row['email'];
    @$indentity_login = $row['login'];

    if ( ($indentity_email===$email) || ($indentity_login===$login) ){
        echo '<div class="indentity">Такой email и / или login существует.</div><br>';
        echo '<a class="autorizacion" href="#">Авторизация</a>';
        return false;
    }
    else{
        return true;
    }
}

function signUp_function( $user_info ){
    $connection = connectFunc();

    $user_info['password'] = password_hash( $user_info['password'], PASSWORD_DEFAULT );
    $status_user = true;

    $first_name = $user_info['first_name'];
    $last_name = $user_info['last_name'];
    $middle_name = $user_info['middle_name'];
    $email = $user_info['email'];
    $login = $user_info['login'];
    $password = $user_info['password'];
    $person_post = $user_info['person_post'];
    
    $query_signUp = "INSERT INTO `service_desk`.`users` (`first_name`,`last_name`,`middle_name`,`email`,`login`,`password`,`person_post`,`status_user`) VALUES ( '$first_name','$last_name','$middle_name','$email','$login','$password','$person_post','$status_user' ) ";
    $result_query = $connection -> query( $query_signUp );
    if ( $result_query ) {
        $query_indentity = "SELECT * FROM `service_desk`.`users` WHERE `login` = '$login'";
        $result_query = $connection->query( $query_indentity );
        $row = $result_query -> fetch_array(MYSQLI_ASSOC);
        $user_id = $row['user_id'];
     
        $query_user_db = "CREATE TABLE `service_desk`.`user_$user_id` ( `id` INT NOT NULL AUTO_INCREMENT , `id_apps` INT NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;";
        $result_query = $connection -> query( $query_user_db );
        if ($result_query){
            // echo 'успешно зарегистрировались';
            echo '<meta http-equiv="refresh" content="0; url=authorization.php">';
            
        }

    }
    else {
        echo $result_query;
        
    }
}

?>