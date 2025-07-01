# Projeto Integrador Desenvolvimento Back-End - Quitandão Senac

## Descrição Técnica
Este é um site feito com PHP que utiliza um servidor MySQL/MariaDB para armazenar seu banco de dados, com os recursos de consulta, escrita, edição e exclusão de dados. Este projeto foi baseado em um outro site trabalhado no curso, criado pelo professor, durante a unidade curricular sobre banco de dados.

Este foi o segundo projeto integrador do meu curso técnico no Senac, finalizando o módulo de desenvolvimento web back-end, com seu objetivo de aplicação e partes da documentação não sendo relevantes fora desse contexto. Este README foi escrito um ano após do projeto ter ocorrido, enquanto o arquivo [Documentação.docx](Documentação.docx) é o que foi apresentado à turma.

## Objetivo da Aplicação
Administrar o estoque de uma quitanda fictícia, onde o responsável pela quitanda adicionará os produtos que estão disponíveis, através de uma interface bonita e intuitiva, que será a mesma exibida para os seus clientes.

## Página Inicial

## Funcionalidades
* Filtro de resultados por categorias.
* Paginação dos resultados, com nove em cada página.
* Upload de imagens no cadastro e edição dos produtos.
* Cores de decoração dos elementos dinâmicas, de acordo com a categoria e o estado dos produtos.

## Executando o Projeto 
1. Instale, caso necessário, o PHP 8.2 ou superior, pelo repositório da sua distribuição Linux ou [pelo site oficial](https://www.php.net/downloads.php);
2. Se estiver usando Linux, instale também o pacote ``php8.x-mysqli``. Caso estiver usando Windows, certifique-se que a extensão mysqli esteja ativada no arquivo ``php.ini``;
3. Instale e configure, caso necessário, o [MariaDB](https://mariadb.com/docs/server/mariadb-quickstart-guides/installing-mariadb-server-guide) ou o [MySQL](https://dev.mysql.com/downloads/);
4. No seu servidor local crie a database ``quitanda``;
5. Na pasta raiz do projeto, importe as tabelas e dados já criados. Exemplo do comando com o MariaDB: ``mariadb -u usuario -p quitanda < quitanda.sql``.
6. Edite o arquivo [conexao.php](conexao.php) para que a variável ``$conexão`` contenha os dados corretos para conectar ao servidor de banco de dados;
7. Inicie um servidor web local para o site com o comando ``php -S localhost:8000``
8.  Também é possível usar o [XAMPP](https://www.apachefriends.org/pt_br/index.html) para criar um servidor web local e lidar com o banco de dados através do PHPMyAdmin incluido.
