function aparecerSumir(escolhido) {
    let formA = document.getElementById(escolhido);
    formA.style.display = "block";

    let formularios = ["atualizacao", "cadastro", 'login'];
    let erros = document.getElementById("mensagem-erro");

    formularios.forEach ( formId => {
        if ( formId != escolhido ) {
            let formC = document.getElementById(formId);
            formC.style.display = "none";

            erros.innerHTML = "";
        }
    }
    );
}
// Essa função tem um parâmetro que receberá um valor na hora que a função for chamada, nesse caso o parâmetro "escolhido" receberá uma string com o id do formulário que eu quero fazer aparecer.

// Depois foi criado um array com o id de todos os formulários na página, e esse array será percorrido pelo loop forEach, que iterará a variável "formId" cada item do array, nesse caso os ids dos formulários, e se o valor desse item for diferente do valor que foi carregado na variável "escolhido" o sistema criará uma variável que pegará no documento o elemento com o id que está carregado na variável "formId" e fará esse elemento desaparecer.

// Assim cada vez que um formulário for escolhido, através das chamadas da função, ele exibirá o escolhido e ocultará o resto.

function aparecerMain(escolhido) {
    let main1 = document.getElementById(escolhido);
    main1.style.display = "grid";

    let mainDivs = ["catalogo", "categorias"];

    mainDivs.forEach ( mainId => {
        if ( mainId != escolhido ) {
            let main2 = document.getElementById(mainId);
            main2.style.display = "none";
        }
    }
    );
}