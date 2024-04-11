<?php
    include "conexao.php";
    session_start();

    if ( $conexao && $_SESSION ) {
        if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {

            // Vamos receber as informações do formulário por post e criaremos as variáveis para receber a informação.
            $nomevar = $_POST['nome'];
            $quantidadevar = $_POST['quantidade'];
            $estadovar = $_POST['estado'];
            $categoriavar = $_POST['categoria'];
            $datavar = $_POST['data'];
            $precovar = $_POST['preco'];
            
            $arquivo_enviado = false;

            if ( isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK ) {
                $arquivo = $_FILES['foto'];

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
                // A verificação dos arquivos é feita por um script que executa antes de os dados serem processados pelo php.
            }
            // Processando a foto enviada, movendo o arquivo para uma pasta e o renomeando.

            else {
                $produtos = mysqli_query($conexao,
                    "INSERT INTO produtos (nome_produto, quantidade, estado, id_categoria, data_adicao, preco)
                    VALUES ('$nomevar', '$quantidadevar', '$estadovar', '$categoriavar', '$datavar', '$precovar')"
                );
                /* Não se esqueça das aspas por favor... */

                // Se o produto for salvo, uma mensagem será salva no arquivo json.
                if ($produtos) {
                    $response = array(
                        'sucesso' => true,
                        'mensagem' => "Produto adicionado com sucesso!"
                    );
                }
            }
            // Query para salvar as informações no banco de dados, caso uma foto não foi carregada.

            if ( $arquivo_enviado || !isset($_FILES['foto']) ) {
                if ( $arquivo_enviado == true ) {
                    $produtos = mysqli_query($conexao,
                    "INSERT INTO produtos (nome_produto, quantidade, estado, id_categoria, data_adicao, preco, foto_produto)
                    VALUES ('$nomevar', '$quantidadevar', '$estadovar', '$categoriavar', '$datavar', '$precovar', '$link_arquivo')"
                    );
                    /* Não se esqueça das aspas por favor... */

                    if ($produtos) {
                        $response = array(
                            'sucesso' => true,
                            'mensagem' => "Produto adicionado com sucesso!"
                        );
                    }
                }

                else if ( $arquivo_enviado = false ) {
                    $response = array(
                        'sucesso' => false,
                        'mensagem' => "O processo de upload não foi finalizado..."
                    );
                }
            }
            // Query para salvar as informações no banco de dados, caso uma foto foi carregada.
        }

        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }

    else {
        echo "Nada para exibir.";
    }
?>
