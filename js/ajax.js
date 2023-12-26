document.addEventListener('DOMContentLoaded', function() {
    // Adicione aqui os listeners para os links da sua sidebar
    var loginLink = document.getElementById('loginLink');
    if (loginLink) {
        loginLink.addEventListener('click', function() {
            loadContent('login.php');
        });
    }

    var registerLink = document.getElementById('registerLink');
    if (registerLink) {
        registerLink.addEventListener('click', function() {
            loadContent('register.php');
        });
    }

    // Adicione mais listeners conforme necessário
});

function loadContent(page) {
    fetch('modules/' + page)
        .then(response => {
            if (!response.ok) {
                throw new Error('Erro ao carregar a página');
            }
            return response.text();
        })
        .then(html => {
            document.getElementById('mainContent').innerHTML = html;
            bindFormSubmit();
        })
        .catch(error => {
            document.getElementById('mainContent').innerHTML = error.message;
        });
}

function bindFormSubmit() {
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function(event) {
            event.preventDefault();
            submitForm(form);
        });
    });
}

function submitForm(form) {
    const formData = new FormData(form);
    const url = form.getAttribute('action');

    fetch(url, {
        method: 'POST',
        body: formData
    })
        .then(response => response.text())
        .then(data => {
            if (data.includes('success')) {
                // Trate a resposta de sucesso aqui
                // Por exemplo, recarregar a página ou redirecionar
            } else {
                document.getElementById('mainContent').innerHTML = data;
                bindFormSubmit(); // Re-vincular para os novos formulários
            }
        })
        .catch(error => console.error('Error:', error));
}