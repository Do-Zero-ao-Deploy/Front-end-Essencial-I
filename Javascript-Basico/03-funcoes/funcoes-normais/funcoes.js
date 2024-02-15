function valor1() {
    return document.querySelector('[name="valor1"')?.value;
}

function valor2() {
    return document.querySelector('[name="valor2"')?.value;
}

function operador() {
    return document.querySelector('[name="operador"')?.value;
}

function resultado() {
    let _valor1 = isNaN(parseFloat(valor1())) ? 0 : parseFloat(valor1());
    let _valor2 = isNaN(parseFloat(valor2())) ? 0 : parseFloat(valor2());

    let result = 0;

    switch (operador()) {
        case 'soma':
        result = _valor1 + _valor2;
            break;

        case 'subt':
        result = _valor1 - _valor2;
            break;

        case 'mult':
        result = _valor1 * _valor2;
            break;

        case 'divi':
        result = _valor1 / _valor2;
            break;

        default:
            break;
    };

    return result;
}

function mostraResultado() {
    validaNumerico(document.querySelector('[name="valor1"'));
    validaNumerico(document.querySelector('[name="valor2"'));
    let displayEl = document.querySelector('[data-element-id="resultado"]');

    if (!displayEl) {
        return;
    }

    displayEl.innerHTML = resultado();
}

function validaNumerico(input) {
    if (!input || !isNaN(Number(input?.value))) {
        return;
    }

    input.value = '';
}

function minhaFuncao1() {

}

function minhaFuncao2(par1, par2, meuParametro3) {
    numeros(par1, par2, meuParametro3);
}

function numeros(...valores) {
    console.log({
        total: valores.length,
        valores: valores,
    })
}

let soma = function(valor1, valor2) {
    return Number(valor1) + Number(valor2);
}

console.log('1 soma(5, 3):', soma(5, 3));

soma = function(valor1, valor2) { // Tudo certo pois é uma variável
    return Number(valor1) + Number(valor2) + 7;
}

const subtrai = function(valor1, valor2) {
    return Number(valor1) - Number(valor2);
}

console.log('1 subtrai(5, 3):', subtrai(5, 3));

// subtrai = function(valor1, valor2) { // Vai dar erro
//     return Number(valor1) - Number(valor2) - 9;
// }

// console.log('2 subtrai(5, 3):', subtrai(5, 3));

window.abc = function() {
    console.log('window abc');
};

(function() {
    console.log('Olá alunos da F2');
})();

(() => {
    console.log('Olá alunos do Tiago');
})();

xyz = function() {
    //
};

xyz = function(abc) {
    //
};

xyz = function(abc, def) {
    //
};

xyz = () => {
    //
};

xyz = (abc) => {
    //
};

xyz = (abc, def) => {
    //
};

valor2 = function () {
    return document.querySelector('[name="valor2"')?.value;
};

valor2 = () => {
    return document.querySelector('[name="valor2"')?.value;
};

valor2 = () => document.querySelector('[name="valor2"')?.value;



let cliente = {
    nome: 'Tiago',
    idade: 58,
    estadoFisico: 'dormindo',
    dormindo () {
        return this.estadoFisico === 'dormindo'
    },
    acordar() {
        this.estadoFisico = 'acordado';
    }
}

console.log(
    `O ${cliente.nome} está dormindo? ` + (cliente.dormindo() ? 'Sim' : 'Não')
);

cliente.acordar();
console.log(
    `O ${cliente.nome} está dormindo? ` + (cliente.dormindo() ? 'Sim' : 'Não')
)
