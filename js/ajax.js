document.addEventListener('DOMContentLoaded', function() {
    // Carregar formulário de login
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
});

function loadContent(page) {
    const xhr = new XMLHttpRequest();
    xhr.onload = function() {
        if (this.status === 200) {
            document.getElementById('mainContent').innerHTML = this.responseText;
            bindFormSubmit();
        } else {
            console.error('Falha ao carregar conteúdo:', this.status);
            document.getElementById('mainContent').innerHTML = 'Erro ao carregar a página';
        }
    };
    xhr.open('GET', 'modules/' + page, true);
    xhr.send();
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
    // Se o action não está definido, determinar a URL com base na classe do formulário
    if (!url || url === '') {
        if (form.classList.contains('login-form')) {
            url = 'modules/login.php';
        } else if (form.classList.contains('register-form')) {
            url = 'modules/register.php';
        } else if (form.classList.contains('jobs-form')) {
            url = 'modules/jobs.php';
        } else if (form.classList.contains('job-list')) {
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
            document.getElementById('mainContent').innerHTML = html;
            bindFormSubmit(); // Re-bind para novos formulários
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('mainContent').innerHTML = 'Erro ao processar o formulário';
        });
}
