<?php

$dbHost = 'LocalHost';
$dbUsername = 'root';
$dbPassword = '';
$dbName = 'projeto';

$conexao = new mysqli($dbHost, $dbUsername,$dbPassword, $dbName )

if($conexao->connect_errno)
{
    echo "erro";
}
else
{
    echo "conexao c sucesso";
}


?>