const txtLogin = document.getElementById('txtLogin');
const txtSenha = document.getElementById('txtSenha');
const btnEntrar = document.getElementById('btnEntrar');

if (txtLogin && txtSenha && btnEntrar) {
    btnEntrar.addEventListener('click', function(e) {
        e.preventDefault();

        txtLogin.value = txtLogin.value.trim();
        if (txtLogin.value == '') {
            Mensagem('Login é obrigatório', 'erro');
            txtLogin.focus();
            return;
        }

        txtSenha.value = txtSenha.value.trim();
        if (txtSenha.value == '') {
            Mensagem('Senha é obrigatória', 'erro');
            txtSenha.focus();
            return;
        }

        fetch(`api/usuarios.php?l=${txtLogin.value.trim()}&s=${txtSenha.value.trim()}`)
        .then(function(respostaRequisicao) {
            return respostaRequisicao.json();
        })
        .then(function(dadosJSON) {
            console.log(dadosJSON);
        })
        .catch(function(erro) {
            console.error(erro);
        })
        
        // console.log('Usuario OK');
    })
}

function Mensagem(texto, tipo) {
    const localMsg = document.createElement('div');
    localMsg.id='local-msg';
    localMsg.classList.add(tipo);
    localMsg.textContent = texto;
    document.querySelector('form').appendChild(localMsg);
    setTimeout(() => {
        localMsg.remove();
    }, 2000);
}







