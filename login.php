<?php
include "conexao.php";

if ( isset($_POST['entrar']) && $_SERVER['REQUEST_METHOD'] === 'POST' ) {
    $nome = $_POST['nome_us'];
    $senha = $_POST['senha_us'];

    $query = $conexao -> query("SELECT * FROM administradores");

    if ( !empty($nome) && !empty($senha) ) {   
        while ( $adms = mysqli_fetch_assoc($query) ) {
            if ( $adms['nome_usuario'] == $nome && $adms['senha'] == $senha ) {
                session_start();

                $_SESSION['id_adm'] = $adms['id_adm'];
                $_SESSION['nome_adm'] = $adms['nome_usuario'];

                header("location:index.php");
            }

            else {
                echo "Usuário não encontrado ou dados incorretos.";
            }
        }
    }

    else {
        echo "Preencha todos os campos.";
    }
}

else {
    echo "Nada para exibir.";
}