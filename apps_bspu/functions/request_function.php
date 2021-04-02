<?php

include_once('connect.php');
include_once('common_functions.php');

function add_request(){
    if ( isset ( $_POST[ 'request_button' ] ) ){
        $connection = connectFunc();

        if ( isset( $_POST['request_name'], $_POST['request_tel'], $_POST['request_building'], $_POST['request_cabinet'], $_POST['request_problem'], $_POST['request_comment'] ) ){

            $request_name = securityMySQL( $connection,$_POST['request_name']);
            $request_tel = securityMySQL( $connection,$_POST['request_tel']);
            $request_building = securityMySQL( $connection,$_POST['request_building']);
            $request_cabinet = securityMySQL( $connection,$_POST['request_cabinet']);
            $request_problem = securityMySQL( $connection,$_POST['request_problem']);
            $request_comment = securityMySQL( $connection,$_POST['request_comment']);

            if ( $request_problem != 1 ){
                add_request_function( $request_name, $request_tel, $request_building, $request_cabinet, $request_problem, $request_comment );
            }
            else{
                echo 'Выберите Вашу проблему';
            }

        }


    }
}

function add_request_function( $request_name, $request_tel, $request_building, $request_cabinet, $request_problem, $request_comment ) {
    $connection = connectFunc();
    #До делать запрос. id искать по переменной сессии
    $date_request = ;
    $id_structural = ;

    $query_add_request = "INSERT INTO `service_desk`.`requests` (`request_name`,`request_tel`,`request_building`,`request_cabinet`,`request_problem`,`request_comment` ) VALUES ( '$request_name','$request_tel','$request_building','$request_cabinet','$request_problem','$request_comment' ) ";
    $result_query = $connection -> query( $query_structural_add );
}





?>