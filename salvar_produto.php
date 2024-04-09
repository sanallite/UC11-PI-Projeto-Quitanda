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

                /* echo "Foi detecado um upload.";
                if ( $arquivo['error'] ) {
                    die ("Ocorreu uma falha ao enviar o arquivo...");
                } */

                /* if ( $arquivo['size'] > 10000000 )
                    die ("O arquivo enviado é muito grande! Tamanho máximo: 10MB"); */

                $pasta = "Conteudo/Uploads/";
                $nome_arquivo = $arquivo['name'];
                $novo_nome_arq = uniqid();

                $extensao = strtolower( pathinfo($nome_arquivo, PATHINFO_EXTENSION));

                /* if ( $extensao != "jpg" && $extensao != "png" && $extensao != "jpeg" ) {
                    die ("Tipo de arquivo não aceito.");
                } */

                // else {
                    /* $mover_arquivo = move_uploaded_file(
                        $arquivo['tmp_name'], $pasta.$novo_nome_arq.".".$extensao
                    ); */

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
                // }
            }

            else {
                $response = array(
                    'sucesso' => false,
                    'mensagem' => "Não foi detectado um upload, ou ocorreu um erro ao enviar o arquivo."
                );
                // Tenho que testar se essa mensagem realmente aparece ou se a mensagem de sucesso a subscreve.

                $produtos = mysqli_query($conexao,
                    "INSERT INTO produtos (nome_produto, quantidade, estado, id_categoria, data_adicao, preco)
                    VALUES ('$nomevar', '$quantidadevar', '$estadovar', '$categoriavar', '$datavar', '$precovar')"
                );
                /* Não se esqueça das aspas por favor... */

                // Se salvar aparecerá uma mensagem
                if ($produtos) {
                /*  echo "<br>A fruta foi salva";
                    header ('location:index.php'); */

                    $response = array(
                        'sucesso' => true,
                        'mensagem' => "Produto adicionado com sucesso!"
                    );
                }
            }

            if ( $arquivo_enviado || !isset($_FILES['foto']) ) {
                /* var_dump($arquivo_enviado); */

                if ( $arquivo_enviado == true ) {
                    $produtos = mysqli_query($conexao,
                    "INSERT INTO produtos (nome_produto, quantidade, estado, id_categoria, data_adicao, preco, foto_produto)
                    VALUES ('$nomevar', '$quantidadevar', '$estadovar', '$categoriavar', '$datavar', '$precovar', '$link_arquivo')"
                    );
                    /* Não se esqueça das aspas por favor... */
        
                    // Se salvar aparecerá uma mensagem
                    if ($produtos) {
                        /* echo "<br>A fruta foi salva";
                        header ('location:index.php'); */
        
                        $response = array(
                            'sucesso' => true,
                            'mensagem' => "Produto adicionado com sucesso!"
                        );
                    }
                }

                else if ( $arquivo_enviado = false ) {
                    /*  echo "Variável de upload não definida"; */
                    
                    $response = array(
                        'sucesso' => false,
                        'mensagem' => "O processo de upload não foi finalizado..."
                    );
                }
            }
            // Queries para salvar as informações no banco de dados
        }

        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }

    else {
        echo "Nada para exibir.";
    }
?>
