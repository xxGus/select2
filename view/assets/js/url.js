//criar função para ajax
//reutiliza-la para carregar as informações do canal e da campanha
//passar parametros pela URL, utilizar o window.onload
function funcXhr(url, input) {
    var re = new XMLHttpRequest();
    var aws;

    return new Promise(function(resolve, reject) {
        re.onload = function () {

            list = JSON.parse(re.responseText).map(function (i) {
                return i.nome;
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

var awsCanal, awsCampanha;

function carregar() {
    canal = document.getElementById("canal");
    campanha = document.getElementById("campanha");
    termo = document.getElementById("termo");
    conteudo = document.getElementById("conteudo");
    copiar = document.getElementById("copiar");
    funcXhr("../php/JsonCanal.php", canal).then(function(re) {
        awsCanal = re;
    });

    awsCampanha = funcXhr("../php/JsonCampanha.php", campanha).then(function (re) {
        awsCampanha = re;
    });
}

canal.addEventListener("awesomplete-selectcomplete", function (evt) {
    var req = new XMLHttpRequest();

    req.open("get", "../php/JsonCanal.php", true);

    req.onloadend = function () {

        jsn = JSON.parse(req.responseText).find(function (canal) {
            return canal.nome == evt.text.value;
        });

        canal.dataset.source = jsn.source;
        canal.dataset.medium = jsn.medium;
    };

    req.send();
});

campanha.onfocusout = function () {

    formUrl = new FormData(document.getElementById('form-gerencia'));

    var xhr = new XMLHttpRequest();

    xhr.open("post", "ViewProduto.php", true);

    xhr.onreadystatechange = function () {
        //awsCampanha.destroy();
        var re = new XMLHttpRequest();

        re.onload = function () {

            list = JSON.parse(re.responseText).map(function (i) {
                return i.nome;
            });
            awsCampanha.list=list;
        };

        re.open("get", '../php/JsonCampanha.php', true);
        re.send();
    };

    xhr.send(formUrl);
};

fmr_gerencia = document.getElementById("form-gerencia");
url = document.getElementById('url');
//canal.value != "" && (canal.dataset.source != "" || canal.dataset.medium != "")
fmr_gerencia.onkeyup = function () {

    url = document.getElementById('url').value.split('\n');
    url_final = document.getElementById('url-final');
    u_f = "";
    url.forEach(function (u) {
        if (u != "") {

            u_f += u + "?";

            if (awsCanal._list.includes(canal.value)) {
                u_f += "utm_source=" + canal.dataset.source;
                u_f += "&utm_medium=" + canal.dataset.medium;
            }

            if (campanha.value != "") {
                u_f += "&utm_campaign=" + campanha.value;
            }

            if (termo.value != "") {
                u_f += "&utm_term=" + termo.value;
            }

            if (conteudo.value != "") {
                u_f += "&utm_content=" + conteudo.value;
            }

        }
        u_f += '\n';
    });

    url_final.innerHTML = u_f.toLocaleLowerCase();
};

fmr_gerencia.onsubmit = function () {

    event.preventDefault();

    document.getElementById('msgErro').style.display = "block";

    if(awsCanal._list.includes(canal.value)){
        url_final.select();
        document.execCommand('Copy');
        document.getElementById('msgErro').style.display = "none";
    }
};

document.addEventListener('DOMContentLoaded', function () {
    carregar();
});

function noSpace() {
    if (event.keyCode == 32) {
        event.returnValue = false;
        event.keyCode = 0;
        return false
    }
}

