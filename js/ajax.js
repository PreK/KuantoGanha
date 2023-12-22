document.addEventListener('DOMContentLoaded', function() {
    var loginLink = document.getElementById('loginLink');
    var registerLink = document.getElementById('registerLink');
    var jobsLink = document.getElementById('jobsLink');

    if (loginLink) {
        loginLink.addEventListener('click', function() {
            loadContent('login.php');
        });
    }
    if (registerLink) {
        registerLink.addEventListener('click', function() {
            loadContent('register.php');
        });
    }
    if (jobsLink) {
        jobsLink.addEventListener('click', function() {
            loadContent('jobs.php');
        });
    }
    bindFormSubmit();
});

function loadContent(page) {
    fetch('modules/' + page)
        .then(response => {
            if (response.ok) {
                return response.text();
            } else {
                throw new Error('Falha ao carregar conteúdo: ' + response.status);
            }
        })
        .then(html => {
            document.getElementById('mainContent').innerHTML = html;
            bindFormSubmit();
        })
        .catch(error => {
            console.error('Erro ao carregar conteúdo:', error);
            document.getElementById('mainContent').innerHTML = 'Erro ao carregar a página';
        });
}

function bindFormSubmit() {
    document.querySelectorAll('form').forEach(function(form) {
        form.addEventListener('submit', function(event) {
            event.preventDefault();
            var actionUrl = form.getAttribute('action');
            submitForm(form, actionUrl);
        });
    });
}

function submitForm(form, url) {
    if (!url || url === '') {
        if (form.classList.contains('login-form')) {
            url = 'modules/login.php';
        } else if (form.classList.contains('register-form')) {
            url = 'modules/register.php';
        } else if (form.classList.contains('jobs-form')) {
            url = 'modules/jobs.php';
        } else {
            console.error('Formulário desconhecido, não é possível determinar o endpoint.');
            return;
        }
    }

    const formData = new FormData(form);
    fetch(url, {
        method: 'POST',
        body: formData
    })
        .then(response => response.text())
        .then(html => {
            if (html.includes('success')) {
                window.location.reload(); // Recarregar a página se a resposta contém 'success'
            } else {
                document.getElementById('mainContent').innerHTML = html;
                bindFormSubmit(); // Re-bind para novos formulários
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            document.getElementById('mainContent').innerHTML = 'Erro ao processar o formulário';
        });
}
