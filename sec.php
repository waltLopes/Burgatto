<?php
@session_start();

if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true || $_SESSION['tipo_usuario'] !== 'admin') {
    $_SESSION['msg'] = "<p style='color: red;'>Esta página é exclusiva para administradores.</p>";
    header("location: login.php");
    exit;
}
