<?php 

    function Connect()
    {
        $server     = "localhost";
        $user       = "root";
        $password   = "";
        $db_name    = "toxicbase";

        $con = mysqli_connect($server,$user,$password,$db_name);

        if (!$con)
        {
            die("Nem sikeült csatlakozni az adatbázishoz!");
        }

        return $con;
    }

?>