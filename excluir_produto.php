<?php
    include "conexao.php";
    session_start();

    if ( $conexao && $_SESSION ) {
        if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
            $id = $_POST['id_produto'];

            $apagar_produto = mysqli_query($conexao, "DELETE FROM produtos WHERE id_produto = $id");

            if ( $apagar_produto ) {
                $response = array(
                    'sucesso' => true,
                    'mensagem' => "Produto removido com sucesso!"
                );
            }

            else {
                $response = array(
                    'sucesso' => false,
                    'mensagem' => "Erro ao remover o produto..."
                );
                json_encode($response);
                exit;
            }
        }

        else {
            echo "Nenhum dado foi enviado por post...";
        }

        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }

    else {
        echo "Nada para exibir.";
    }
?>