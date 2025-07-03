<?php
    define("ENDERECO",'localhost');
    define("USER",'root');
    define("PASSWORD",'');
    define("BASE",'db_burgatto');

    $con = mysqli_connect(ENDERECO,USER,PASSWORD,BASE);

    mysqli_query($con, "SET NAMES utf8");