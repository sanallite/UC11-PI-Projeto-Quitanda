<?php
    session_start();
    include "conexao.php";

    if ( isset($_GET['id_cat']) ) {
        $id_cat = $_GET['id_cat'];

        $inicio = 0;
        $produtosPorPagina = 9;

        $todosProdutos = mysqli_query($conexao, "SELECT * FROM produtos INNER JOIN categorias WHERE produtos.id_categoria = categorias.id_categoria AND produtos.id_categoria = $id_cat");

        $numeroProdutos = mysqli_num_rows($todosProdutos);
        $paginas = ceil($numeroProdutos / $produtosPorPagina);

        if ( isset($_GET['nr_pag']) ) {
            $pagina_atual = $_GET['nr_pag'] - 1;

            $inicio = $pagina_atual * $produtosPorPagina;
        }

        else {
            $pagina_atual = 0;
        }
    }

    else {
        header("location:index.php");
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quitandão Senac - Todos os Produtos em:</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <header>
        <a href="index.php"><img src="Layout/logoquitanda-01 1.png" alt="Logotipo Quitandão"></a>

        <h1>
            Quitandão Senac<br>
            As Melhores Frutas Da Estação!
        </h1>
    </header>

    <nav>
        <div class="categoria catalogo">
            <a class="categoria" href="#" onclick="aparecerMain('categorias'), aparecerSumir('cadastroCat')">Categorias</a>
            <a class="catalogo" href="#" onclick="aparecerMain('catalogo'), aparecerSumir('cadastro')">Catálogo</a>  
        </div>

        <div class="paginas" >
            <a class="paginas">Página Atual: <?= $pagina_atual + 1?></a>

            <a href="?nr_pag=1" class="paginas">Primeira Página</a>
        <?php
            if ( isset($_GET['nr_pag']) && $_GET['nr_pag'] > 1) { ?>
                <a href="?nr_pag=<?= $_GET['nr_pag'] - 1 ?>" class="paginas">Anterior</a>
        <?php }

            if ( isset($_GET['nr_pag']) && $_GET['nr_pag'] < $paginas ) { ?>
                <a href="?nr_pag=<?= $_GET['nr_pag'] + 1 ?>" class="paginas">Próxima</a>
        <?php } 
            
            else if ( !isset($_GET['nr_pag']) ) { ?>
                <a href="?nr_pag=2" class="paginas">Próxima</a>
        <?php } ?>
            
            <a href="?nr_pag=<?= $paginas ?>" class="paginas">Última Página</a>
        </div>

        <div class="cadastro">
        <?php
            if ( $_SESSION ) { ?> 

            <a class="cadastro" href="#cadastro" onclick="aparecerSumir('cadastro')">Cadastro de produtos</a>

            <a class="sessao" href="sair_sessao.php">Encerrar sessão</a>
        <?php } ?>
        </div>
    </nav>

    <main id="catalogo">
    <?php
        $produtos = mysqli_query($conexao, "SELECT * FROM produtos INNER JOIN categorias WHERE produtos.id_categoria = categorias.id_categoria AND produtos.id_categoria = $id_cat");

        $quantBloco = 0;
        $numBloco = 0;

        // Estrutura de repetição que traz todos as produtos cadastradas.
        while ( $produto = mysqli_fetch_assoc($produtos) ) { 
            $quantBloco++;
            $numBloco++; if ( $quantBloco>9 ) {
                break;
            }
            
            if ( $produto['nome_categoria'] === "Frutas" ) {
                $corCat = "cor-frutas";
            }

            else if ( $produto['nome_categoria'] === "Verduras" ) {
                $corCat = "cor-verduras";
            }

            else if ( $produto['nome_categoria'] === "Legumes" ) {
                $corCat = "cor-legumes";
            }

            else if ( $produto['nome_categoria'] === "Grãos" ) {
                $corCat = "cor-graos";
            }

            else {
                $corCat = "cor-padrao";
            }

            if ( $produto['estado'] == "Ótimo" ) {
                $estadoP = "estado-otimo";
            }

            else if ( $produto['estado'] == "Bom" ) {
                $estadoP = "estado-bom";
            }

            else if ( $produto['estado'] == "Ruim" ) {
                $estadoP = "estado-ruim";
            }

            if ( $_SESSION ) { ?>

        <div class="f<?= $numBloco." ".$corCat ?> editavel">
            <div class="<?= $estadoP ?>"></div>
            <a class="edit" href="index.php?id=<?= $produto['id_produto'] ?>#atualizacao" onclick="aparecerSumir('atualizacao')">
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                </svg>
            </a>

            <form action="excluir_produto.php" method="post" id="exclusao">
                <input type="hidden" name="id_produto" value="<?= $produto['id_produto'] ?>">

                <button type="submit" class="delete" id="botao_deletar">
                    <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                    </svg>
                </button>
            </form>

            <p class="produto">
                <?= $produto['nome_produto']; ?>
            </p>

            <?php if ( $produto['foto_produto'] !== "Sem Foto" ) { ?>
                <p class="foto">
                    <img src="<?= $produto['foto_produto']?>">
                </p>
            <?php }

                else { ?>
                <p class="foto sem_foto">
                    Sem foto do produto.
                </p>
            <?php } ?>

            <p class="quant">Quantidade em kg.
                <br><?= $produto['quantidade']; ?>
            </p>

            <p class="data">Data de aquisição
                <br><?= $produto['data_adicao']; ?>
            </p>
        </div>

    <?php }

        else { ?>
        <div class="f<?= $numBloco." ".$corCat ?> visualizavel">
                <div class="<?= $estadoP ?>"></div>

                <p class="produto">
                    <?= $produto['nome_produto']; ?>
                </p>

                <?php if ( $produto['foto_produto'] !== "Sem Foto" ) { ?>
                    <p class="foto">
                        <img src="<?= $produto['foto_produto']?>">
                    </p>
                <?php }

                    else { ?>
                    <p class="foto sem_foto">
                        Sem foto do produto.
                    </p>
                <?php } ?>

                <p class="quant">Quantidade em kg
                    <br><?= $produto['quantidade']; ?>
                </p>

                <p class="data">Data de aquisição
                    <br><?= $produto['data_adicao']; ?>
                </p>
            </div>
        <?php }
        } ?>
    </main>

    <aside id="formularios">
    <?php
            if ( $_SESSION ) {
        ?>
        <form action="salvar_produto.php" id="cadastro" method="post" enctype="multipart/form-data">
            <h2>Cadastre um produto</h2>

            <p>
                <label for="nome">Nome:</label>
                <input type="text" name="nome" id="nome">
            </p>

            <p>
                <label for="quantidade">Quantidade em kg:</label>
                <input type="number" name="quantidade" id="quantidade">
            </p>

            <p>
                <label for="estado">Estado:</label>
                <select name="estado" id="estado">
                    <option value="">Selecione</option>
                    <option value="Ótimo">Ótimo</option>
                    <option value="Bom">Bom</option>
                    <option value="Ruim">Ruim</option>
                </select>
            </p>

            <p>
                <label for="data">Data de aquisição:</label>
                <input type="date" name="data" id="data">
            </p>

            <p>
                <label for="categoria">Categoria:</label>
                <select name="categoria" id="categoria">
                    <option value="">Selecione</option>
                    <?php
                        $categorias = mysqli_query($conexao, "SELECT * FROM categorias");

                        while ($cat = mysqli_fetch_assoc($categorias)) {
                            echo "<option value=" . $cat["id_categoria"] . ">" . $cat["nome_categoria"] . "</option>";
                        }
                    ?>
                </select>
            </p>

            <p>
                <label for="foto">Foto do produto:</label>
                <input type="file" name="foto" id="foto">
            </p>

            <p>
                <label>Preço:</label>
                <input type="number" name="preco" step="0.01">
                <!-- Input number só permite números inteiros, por isso se usa o step, que irá controlar quais números são válidos -->
            </p>

            <p>
                <button type="submit" id="botao_cadastrar">Salvar</button>
            </p>
        </form>

        <?php
            }

            else { ?>
            <form action="login.php" method="post" id="login">
                <h2>Entrada de administradores</h2>

                <label for="nome_us">Nome de usuário:</label>
                <input type="text" name="nome_us" id="nome_us">

                <label for="senha_us">Senha:</label>
                <input type="password" name="senha_us" id="senha_us">

                <input type="submit" value="Entrar" name="entrar" id="botao_entrar">
            </form>
        <?php }

            if ( isset($_GET['id']) ) {
                $id = $_GET['id'];
                $selecionada = mysqli_query($conexao, "SELECT * FROM produtos WHERE id_produto = $id");
                @$dadosSelecionados = mysqli_fetch_assoc($selecionada);
            }
        ?>

        <form action="editar_produto.php" id="atualizacao" method="post" enctype="multipart/form-data">
            <h2>Edite um produto</h2>

            <input type="hidden" name="id_produto" value="<?= @$dadosSelecionados['id_produto']; ?>">

            <p>
                <label for="edit_nome">Nome:</label>
                <input type="text" name="edit_nome" id="edit_nome" value="<?= @$dadosSelecionados['nome_produto']; ?>">
            </p>

            <p>
                <label for="edit_quantidade">Quantidade em kg:</label>
                <input type="number" name="edit_quantidade" id="edit_quantidade" value="<?= @$dadosSelecionados['quantidade']; ?>">
            </p>

            <p>
                <label for="edit_estado">Estado:</label>
                <select name="edit_estado" id="edit_estado">
                    <option value="<?= @$dadosSelecionados['estado']; ?>">Não alterar</option>
                    <option value="Ótimo">Ótimo</option>
                    <option value="Bom">Bom</option>
                    <option value="Ruim">Ruim</option>
                </select>
            </p>

            <p>
                <label for="edit_data">Data de aquisição:</label>
                <input type="date" name="edit_data" id="edit_data" value="<?= @$dadosSelecionados['data_adicao']; ?>">
            </p>

            <p>
                <label for="edit_categoria">Categoria:</label>
                <select name="edit_categoria" id="edit_categoria">
                    <option value="<?= @$dadosSelecionados['id_categoria']; ?>">Não alterar</option>
                    
                    <?php
                        $categorias = mysqli_query($conexao, "SELECT * FROM categorias");
                        
                        while ($categoria = mysqli_fetch_assoc($categorias)) {
                            echo "<option value=" . $categoria["id_categoria"] . ">" . $categoria["nome_categoria"] . "</option>";
                        }
                    ?>
                </select>
            </p>

            <p>
                <label for="edit_foto">Foto do Produto:</label>
                <input type="file" name="edit_foto" id="edit_foto">
            </p>

            <p>
                <label for="edit_preco">Preço:</label>
                <input type="number" name="edit_preco" id="edit_preco" step="0.01" value="<?= @$dadosSelecionados['preco']; ?>">
                <!-- Input number só permite números inteiros, por isso se usa o step, que irá controlar quais números são válidos -->
            </p>

            <p>
                <button type="submit" id="botao_atualizar">Alterar</button>
            </p>
        </form>

        <ul id="mensagem-erro"></ul>
    </aside>

    <script src="js/divs.js"></script>
</body>
</html>