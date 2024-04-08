<?php
    include "conexao.php";

    if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
        $id = "Não definida ainda";
        $nome = $_POST['edit_nome'];
        $quantidade = $_POST['edit_quantidade'];
        $estado = $_POST['edit_estado'];
        $categoria = $_POST['edit_categoria'];
        $data = $_POST['edit_data'];
        $preco = $_POST['edit_preco'];
        $arquivo_enviado = false;

        if ( isset($_FILES['edit_foto']) && $_FILES['edit_foto']['error'] == 0 ) {
            $arquivo = $_FILES['edit_foto'];
        }

        else {
            $atualizar = mysqli_query($conexao,
                "UPDATE produtos 
                SET nome_produto = '$nomevar', 
                quantidade = '$quantidadevar',
                estado = '$estadovar',
                id_categoria = '$categoriavar',
                data_adicao = '$datavar',
                preco = '$precovar'
                WHERE id_produto = '$id'"
            );
        }
    }

    else {
        $response = array(
            'sucesso' => false,
            'mensagem' => "Nenhum dado enviado por post..."
        );
    }

    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
?>