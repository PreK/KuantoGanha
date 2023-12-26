document.addEventListener('DOMContentLoaded', function() {
    // Carregar conteúdo dinâmico para login e registro
    bindDynamicContentLoader('loginLink', 'login.php');
    bindDynamicContentLoader('registerLink', 'register.php');
    // Adicione mais binds conforme necessário
});

// Função para vincular links para carregar conteúdo
function bindDynamicContentLoader(linkId, page) {
    var link = document.getElementById(linkId);
    if (link) {
        link.addEventListener('click', function() {
            loadContent(page);
        });
    }
}

// Carregar conteúdo na div mainContent
function loadContent(page) {
    const xhr = new XMLHttpRequest();
    xhr.onload = function() {
        if (this.status === 200) {
            document.getElementById('mainContent').innerHTML = this.responseText;
            bindFormSubmit(); // Vincula os eventos de submit dos formulários carregados
        } else {
            document.getElementById('mainContent').innerHTML = 'Erro ao carregar a página';
        }
    };
    xhr.open('GET', 'modules/' + page, true);
    xhr.send();
}

// Vincular eventos de submit dos formulários
function bindFormSubmit() {
    document.querySelectorAll('form').forEach(function(form) {
        form.addEventListener('submit', function(event) {
            event.preventDefault();
            var formType = form.classList.contains('login-form') ? 'login' : 'register';
            var actionUrl = formType === 'login' ? 'modules/login.php' : 'modules/register.php';
            submitForm(form, actionUrl, formType === 'login');
        });
    });
}

// Submeter formulário e tratar resposta
function submitForm(form, url, isLogin) {
    const formData = new FormData(form);
    fetch(url, {
        method: 'POST',
        body: formData
    })
        .then(response => response.json()) // assumindo que a resposta é JSON
        .then(data => {
            if (isLogin && data.success) {
                window.location.reload(); // Recarregar a página após login bem-sucedido
            } else {
                // Atualizar mainContent com a resposta (por exemplo, mensagens de erro)
                document.getElementById('mainContent').innerHTML = data.message;
                bindFormSubmit(); // Vincular novamente para os novos formulários
            }
        })
        .catch(error => console.error('Error:', error));
}
