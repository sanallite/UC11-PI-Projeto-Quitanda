let form_cadastro = document.querySelector("#cadastro");
let form_atualizacao = document.querySelector("#atualizacao");

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

function obterDadosAtualizar(form_atualizacao) {
    let valores = {
        nome_produto: form_atualizacao.edit_nome.value,
        quantidade: form_atualizacao.edit_quantidade.value,
        estado: form_atualizacao.edit_estado.value,
        data: form_atualizacao.edit_data.value,
        categoria: form_atualizacao.edit_categoria.value,
        preco: form_atualizacao.edit_preco.value
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

function validarTipoArquivo(file) {
    let tiposPermitidos = ['image/jpeg', 'image/png', 'image/jpg'];

    return tiposPermitidos.includes(file.type);
}

function validarTamanhoArquivo(file) {
    let tamanhoMaximo = 5 * 1024 * 1024;
    return file.size <= tamanhoMaximo;
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

    let foto_produto = form_cadastro.foto.files[0];

    if ( foto_produto ) {
        if ( !validarTipoArquivo(foto_produto) ) {
            erros.push("Tipo de arquivo não suportado!");
        }

        if ( !validarTamanhoArquivo(foto_produto) ) {
            erros.push("O tamanho do arquivo é muito grande!");
        }
    }

    if ( erros.length > 0 ) {
		exibirErros(erros);
		return;
	}

    let formData = new FormData(form_cadastro);
    fetch('salvar_produto.php', {
        method: 'POST',
        body: formData
    })
    .then( resposta => resposta.json() )
    .then( data => {
        console.log(data);
        form_cadastro.reset();
        let mensagens = document.querySelector("#mensagem-erro");
        mensagens.innerHTML = "";
    })
    .catch( error => {
        console.error("Erro: ", error)
    } );

    /* form_cadastro.reset();
    let mensagens = document.querySelector("#mensagem-erro");
    mensagens.innerHTML = ""; */
} );

form_atualizacao.addEventListener("submit", (event) => {
    event.preventDefault();

    let edit_produto = obterDadosAtualizar(form_atualizacao);
    let erros = [];

    validarDados(edit_produto, erros);

    let foto_produto = form_atualizacao.edit_foto.files[0];

    if ( foto_produto ) {
        if ( !validarTipoArquivo(foto_produto) ) {
            erros.push("Tipo de arquivo não suportado!");
        }

        if ( !validarTamanhoArquivo(foto_produto) ) {
            erros.push("O tamanho do arquivo é muito grande!");
        }
    }

    if ( erros.length > 0 ) {
		exibirErros(erros);
		return;
	}

    let formData = new FormData(form_atualizacao);
    fetch('editar_produto.php', {
        method: 'POST',
        body: formData
    })
    .then( resposta => resposta.json() )
    .then( data => {
        console.log(data);
        form_atualizacao.reset();
        let mensagens = document.querySelector("#mensagem-erro");
        mensagens.innerHTML = "";
    })
    .catch( error => {
        console.error("Erro: ", error)
    } );
});