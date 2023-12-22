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
            if (actionUrl) {
                submitForm(form, actionUrl);
            } else {
                console.log("Ação definida para manipulação JS");
                // Aqui você pode adicionar lógica para lidar com formulários sem 'action'
            }
        });
    });
}

function submitForm(form, url) {
    const formData = new FormData(form);
    fetch(url, {
        method: 'POST',
        body: formData
    })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok: ' + response.statusText);
            }
            return response.text();
        })
        .then(html => {
            document.getElementById('mainContent').innerHTML = html;
            bindFormSubmit(); // Re-bind para novos formulários
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('mainContent').innerHTML = 'Erro ao processar o formulário';
        });
}