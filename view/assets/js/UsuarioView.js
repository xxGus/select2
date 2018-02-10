function remover() {
    confirmou = confirm("Você realmente deseja remover este usuário?");
    if (confirmou) {
        msgRemove.classList.add("alert-success");
        msgRemove.innerHTML = "Usuário removido com sucesso!";

    } else {
        msgRemove.classList.add("alert-warning");
        msgRemove.innerHTML = "Operação cancelada.";
    }
}

function verificaOpcs() {
    var nivel = document.getElementById('nivel').value;

    var text = document.getElementById('msgCadastro');

    if (nivel == '') {
        document.getElementById('nivel').style.borderColor = 'red';
        text.className = "text text-danger";
        text.textContent = "Informe um nível de acesso válido."
    } else {
        document.getElementById('nivel').style.borderColor = '';
        text.className = "";
        text.textContent = ""
    }
}
div_senhas = document.getElementById('alt-senha');
lb_senha = document.getElementById('lb-alt-senha');
chk_senha = document.getElementById('chk-alt-senha');

lb_senha.style.cursor = "pointer";
chk_senha.style.cursor = "pointer";

function habilitarAltSenha (div, chk) {
    div.style.display = "none";
    document.getElementById('senha-antiga').required = false;
    document.getElementById('nova-senha').required = false;

    if(chk.checked){
        div.style.display = "block";
        document.getElementById('senha-antiga').required = true;
        document.getElementById('nova-senha').required = true;
    }
}

img = document.getElementById('img-alt').src;
//criar requisição para mandar nome da img
console.log("teste========>" + img);