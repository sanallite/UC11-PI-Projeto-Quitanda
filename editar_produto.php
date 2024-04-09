<?php
    include "conexao.php";
    session_start();

    if ( $conexao && $_SESSION ) {
    if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
        $id = $_POST['id_produto'];
        $nome = $_POST['edit_nome'];
        $quantidade = $_POST['edit_quantidade'];
        $estado = $_POST['edit_estado'];
        $categoria = $_POST['edit_categoria'];
        $data = $_POST['edit_data'];
        $preco = $_POST['edit_preco'];
        $arquivo_enviado = false;

        if ( isset($_FILES['edit_foto']) && $_FILES['edit_foto']['error'] === UPLOAD_ERR_OK ) {
            $arquivo = $_FILES['edit_foto'];

            $pasta = "Conteudo/Uploads/";
            $nome_arquivo = $arquivo['name'];
            $novo_nome_arq = uniqid();

            $extensao = strtolower( pathinfo($nome_arquivo, PATHINFO_EXTENSION));

            if ( !move_uploaded_file( $arquivo['tmp_name'], $pasta.$novo_nome_arq.".".$extensao ) ) {
                $response = array(
                    'sucesso' => false,
                    'mensagem' => "Falha ao mover o arquivo para a pasta de destino."
                );

                echo json_encode($response);
                exit;
            }

            $link_arquivo = "Conteudo/Uploads/$novo_nome_arq.$extensao";
            $arquivo_enviado = true;
            
            $response = array(
                'sucesso' => true,
                'mensagem' => "Arquivo movido para a pasta de destino."
            );
        }

        else {
            $atualizar = mysqli_query($conexao,
                "UPDATE produtos 
                SET nome_produto = '$nome', 
                quantidade = '$quantidade',
                estado = '$estado',
                id_categoria = '$categoria',
                data_adicao = '$data',
                preco = '$preco'
                WHERE id_produto = '$id'"
            );

            if ( $atualizar ) {
                $response = array(
                    'sucesso' => true,
                    'mensagem' => "Dados do produto atualizados com sucesso!"
                );
            }

            else {
                $response = array(
                    'sucesso' => false,
                    'mensagem' => "Erro ao atualizar os dados do produto!"
                );

                json_encode($response);
                exit;
            }
        }

        if ( $arquivo_enviado ) {
            if ( $arquivo_enviado == true ) {
                $atualizar = mysqli_query($conexao,
                    "UPDATE produtos 
                    SET nome_produto = '$nome', 
                        quantidade = '$quantidade',
                        estado = '$estado',
                        id_categoria = '$categoria',
                        data_adicao = '$data',
                        preco = '$preco',
                        foto_produto = '$link_arquivo'
                    WHERE id_produto = '$id'"
                );

                if ( $atualizar ) {
                    $response = array(
                        'sucesso' => true,
                        'mensagem' => "Dados do produto atualizados com sucesso!"
                    );
                }

                else {
                    $response = array(
                        'sucesso' => false,
                        'mensagem' => "Erro ao atualizar os dados do produto!"
                    );

                    json_encode($response);
                    exit;
                }
            }

            else if ( $arquivo_enviado == false ) {
                $response = array(
                    'sucesso' => false,
                    'mensagem' => "O processo de upload não foi finalizado..."
                );

                json_encode($response);
                exit;
            }
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
    }
    
    else {
        echo "Nada para exibir.";
    }
?>