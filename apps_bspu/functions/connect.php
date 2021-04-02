<?php

    function connectFunc(){

        $host = 'localhost';
	    $login = 'root2';
	    $pass ='41R0V8RfyCQOm2om';
	    // $pass ='45xq2EcnnCQD0XVJ';
	    $db = 'service_desk';

	    $connection =new mysqli ($host,$login,$pass,$db);

	    return $connection;

        if(!$connection){
            echo 'Проблемы при соединении с базой данных';
        }

    }

?>