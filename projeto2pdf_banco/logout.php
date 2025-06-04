<?php
require_once 'config.php';

//destrói a sessão
session_destroy();

//redireciona para a página de login
header('Location: login.php');
exit();
?>