<?php
    include "conexao.php";
    session_start();

    if ( $conexao && $_SESSION ) {
        if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
            $id = $_POST['id_produto'];

            $apagar_produto = mysqli_query($conexao, "DELETE FROM produtos WHERE id_produto = $id");

            if ( $apagar_produto ) {
                header("location:index.php");
            }

            else {
                echo "Erro na exclusão do produto...";
            }
        }

        else {
            echo "Nenhum dado foi enviado por post...";
        }
    }

    else {
        echo "Nada para exibir.";
    }
?>