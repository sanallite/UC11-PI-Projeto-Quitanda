let form_cadastro = document.querySelector("#cadastro");

function ObterDadosCadastrar(form_cadastro) {
    let valores = {
        nome_produto: form_cadastro.nome.value,
        quantidade: form_cadastro.quantidade.value,
        estado: form_cadastro.estado.value,
        data: form_cadastro.data.value,
        categoria: form_cadastro.categoria.value,
        preco: form_cadastro.preco.value
    }

    return valores;
}

function validarDados(produto, erros) {
    if ( produto.nome === "" ) {
        erros.push("O campo nome não pode estar vazio.");
    }

    if ( produto.quantidade.trim() === "" ) {
        erros.push("O campo quantidade não pode estar vazio.");
    }

    else if ( produto.quantidade <= 0 || produto.quantidade >= 100 ) {
        erros.push("Valor Inválido de quantidade.");
    }

    if ( produto.estado.trim() === "" ) {
        erros.push("Selecione uma opção para o estado.");
    }

    if ( produto.data.trim() === "" ) {
        erros.push("O campo data de adição não pode estar vazio.");
    }

    if ( produto.categoria.trim() === "" ) {
        erros.push("Selecione uma opção para a categoria.");
    }

    if ( produto.preco.trim() === "" ) {
        erros.push("O campo preço não pode estar vazio.");
    }

    else if ( produto.preco <= 0 || produto.preco >= 100.00 ) {
        erros.push("Valor inválido de preço.")
    }

    return erros;
}

function exibirErros(erros) {
    let mensagem = document.querySelector("#mensagem-erro");
    mensagem.innerHTML = "";

    erros.forEach( erro => {
		let li = document.createElement("li");
		li.textContent = erro;
		mensagem.appendChild(li);
	} );
}

form_cadastro.addEventListener("submit", (event) => {
    event.preventDefault();
   
    let produto = ObterDadosCadastrar(form_cadastro);
    let erros = [];

    validarDados(produto, erros);

    if ( erros.length > 0 ) {
		exibirErros(erros);
		return;
	}

    let formData = new FormData(form_cadastro);
    fetch('salvar.php', {
        method: 'POST',
        body: formData
    }).then( resposta => response.json() )
    .then( data => {
        
    })

    form_cadastro.reset();
    let mensagens = document.querySelector("#mensagem-erro");
    mensagens.innerHTML = "";
} )