var selectPizza = document.getElementById('select-pizza');
var selectProduto = document.getElementById('select-produto');

var resumoPizza = document.getElementById('resumo-pizza');
var resumoProduto = document.getElementById('resumo-produto');

var qtdPizza = document.getElementById('qtd-pizza');
var qtdProduto = document.getElementById('qtd-produto');

var comentario = document.getElementById('comentario');

var totalPagar = document.getElementById('total-pagar');
var valor = 0;
var subValor = 0;

function adicionar(slct, table, qtd) {
    if (slct.value != 0) {

        var newId = Math.floor((Math.random() * 99999) + 1);
        var newRow = document.createElement('tr');
        newRow.id = 'linha' + newId;

        var button = document.createElement('button');
        button.name = 'btn-remover';
        button.textContent = 'remover';

        newRow.insertCell(0).innerHTML = slct.options[slct.selectedIndex].text;
        newRow.insertCell(1).innerHTML = slct.value;
        newRow.insertCell(2).innerHTML = qtd.value;
        newRow.insertCell(3).appendChild(button);

        table.appendChild(newRow);

        // console.log(totalPagar.textContent);

        if (totalPagar.textContent == '') valor = 0;
        valor = valor + (slct.value * qtd.value);

        button.onclick = function (ev) {
            btn = document.getElementById('linha' + newId);
            if (valor > 0) {
                valor = valor - (btn.childNodes[1].textContent * btn.childNodes[2].textContent);
                totalPagar.innerHTML = parseFloat(valor.toFixed(2));
                document.getElementById('linha' + newId).remove();
            }
        };

        totalPagar.innerHTML = parseFloat(valor.toFixed(2));
    }
}

var tipoPagamento = document.getElementById('tipo-pagamento');
var pagSelected = document.getElementById('tipo-pag-selected');

tipoPagamento.onclick = function (ev) {
    pagSelected.innerHTML = "";
    if (tipoPagamento.value != '') {
        pagSelected.innerHTML = tipoPagamento.options[tipoPagamento.selectedIndex].text;
    }
};

document.getElementById('comentario').onkeyup = function (ev) {
    document.getElementById('coment').innerHTML = document.getElementById('comentario').value;
};

function funcXhr(url, input) {
    var re = new XMLHttpRequest();
    var aws;

    return new Promise(function (resolve, reject) {
        re.onload = function () {

            list = JSON.parse(re.responseText).map(function (i) {
                return i.telefone;
            });

            aws = new Awesomplete(input, {
                'autoFirst': true
            });

            aws.list = list;
            resolve(aws);
        };

        re.open("get", url, true);
        re.send();
    });
}

var awsCliente;


function carregar() {
    telefone = document.getElementById("telefone");
    nome_cliente = document.getElementById("nome-cliente");
    endereco = document.getElementById("endereco");

    res_tel = document.getElementById('res-tel');
    res_nome = document.getElementById('res-nome');
    res_local = document.getElementById('res-local');

    awsCliente = funcXhr("../php/JsonCliente.php", telefone).then(function (re) {
        awsCliente = re;
    });
}

telefone.addEventListener("awesomplete-selectcomplete", function (evt) {
    var req = new XMLHttpRequest();

    req.open("get", "../php/JsonCliente.php", true);

    req.onloadend = function () {

        jsn = JSON.parse(req.responseText).find(function (cliente) {
            return cliente.telefone == evt.text.value;
        });

        nome_cliente.value = jsn.nome;
        endereco.value = jsn.endereco;

        telefone.dataset.telefone = jsn.telefone;
        nome_cliente.dataset.nome = jsn.nome;
        endereco.dataset.endereco = jsn.endereco;
    };

    req.send();
});

document.getElementById('add-cliente').onclick = function (ev) {

    res_tel.innerHTML = "Telefone: " + telefone.value;
    if (telefone.dataset.telefone != "" && telefone.dataset.telefone == telefone.value)
        res_tel.innerHTML = "Telefone: " + telefone.dataset.telefone;

    res_nome.innerHTML = "Nome do Cliente: " + nome_cliente.value;
    if(nome_cliente.dataset.nome != "" && nome_cliente.dataset.nome == nome_cliente.value){
        res_nome.innerHTML = "Nome do Cliente: "+ nome_cliente.dataset.nome;
    }

    res_local.innerHTML = "Local de entrega: " + endereco.value;
    if(endereco.dataset.nome != "" && endereco.dataset.nome == endereco.value){
        res_local.innerHTML = "Local de entrega: "+ endereco.dataset.endereco;
    }

};

form_pedido = document.getElementById('form-pedido');

form_pedido.onsubmit = function (ev) {
    event.preventDefault();
};

document.addEventListener('DOMContentLoaded', function () {
    carregar();
});
