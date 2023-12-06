document.addEventListener('DOMContentLoaded', function() {
    // Carregar formulário de login
    document.getElementById('loginLink').addEventListener('click', function() {
        loadContent('login.php');
    });

    // Carregar formulário de registro
    document.getElementById('registerLink').addEventListener('click', function() {
        loadContent('register.php');
    });

    // Listener para submissão de formulários
    document.addEventListener('submit', function(event) {
        // Se for o formulário de login
        if (event.target.matches('.login-form form')) {
            event.preventDefault();
            submitForm(event.target, 'modules/login.php');
        }

        // Se for o formulário de registro
        if (event.target.matches('.register-form form')) {
            event.preventDefault();
            submitForm(event.target, 'modules/register.php');
        }
    });
});

function loadContent(page) {
    const xhr = new XMLHttpRequest();
    xhr.onload = function() {
        if (this.status === 200) {
            document.getElementById('mainContent').innerHTML = this.responseText;
        } else {
            document.getElementById('mainContent').innerHTML = 'Erro ao carregar a página';
        }
    };
    xhr.open('GET', 'modules/' + page, true);
    xhr.send();
}

function submitForm(form, url) {
    const formData = new FormData(form);
    fetch(url, {
        method: 'POST',
        body: formData
    })
        .then(response => response.text())
        .then(html => {
            document.getElementById('mainContent').innerHTML = html;
        })
        .catch(error => console.error('Error:', error));
}
