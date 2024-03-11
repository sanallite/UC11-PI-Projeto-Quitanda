<?php
    include "conexao.php";

    // Pegando a ação pela url e o valor que será usado nessa ação, apenas se tiver uma ação definida.
    if ( isset( $_GET['acao'] ) ) {
        $acao = $_GET['acao'];

        if ( $acao == "delete" ) {
            $id = $_GET['id'];
            $deletarFrutas = mysqli_query($conexao, "DELETE FROM frutas WHERE id = $id");
            
            if ( $deletarFrutas ) { echo "<br>A linha foi apagada.";
                header ('location:index.php');
            }
        }

        else if ( $acao == "atualizar" ) {
            $id = $_GET['id'];

            $nomevar = $_POST['nome'];
            $quantidadevar = $_POST['quantidade'];
            $estadovar = $_POST['estado'];
            $categoriavar = $_POST['categoria'];
            $datavar = $_POST['data'];
            $precovar = $_POST['preco'];
            $corvar = $_POST['cor'];

            $atualizar = mysqli_query($conexao,
            "UPDATE frutas 
            SET nome = '$nomevar', 
            quantidade = '$quantidadevar',
             estado = '$estadovar',
              categoria_id = '$categoriavar',
               data = '$datavar',
                preco = '$precovar',
                 cor = '$corvar'
                 WHERE id = '$id'");

            if ( $atualizar ) {
                echo "<br>A linha foi alterada.";
                /* header ('location:index.php'); */
            }
        }
    }

    // Vamos receber as informações do formulário por post e criaremos as variáveis para receber a informação.
    else {  
        $nomevar = $_POST['nome'];
        $quantidadevar = $_POST['quantidade'];
        $estadovar = $_POST['estado'];
        $categoriavar = $_POST['categoria'];
        $datavar = $_POST['data'];
        $precovar = $_POST['preco'];
        $corvar = $_POST['cor'];

        // Query para salvar as informações no banco de dados
        $frutas = mysqli_query($conexao,
            "INSERT INTO frutas (nome, quantidade, estado, categoria_id, data, preco, cor)
            VALUES ('$nomevar', '$quantidadevar', '$estadovar', '$categoriavar', '$datavar', '$precovar', '$corvar')"
        );
        /* Não se esqueça das aspas por favor... */

        // Se salvar aparecerá uma mensagem
        if ($frutas) {
            echo "<br>A fruta foi salva";
            header ('location:index.php');
        }
    }
?>
