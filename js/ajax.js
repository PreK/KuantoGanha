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
    bindMenuLinks();
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
function bindMenuLinks() {
    document.querySelectorAll('a').forEach(function(link) {
        link.addEventListener('click', function(event) {
            event.preventDefault();
            var url = link.getAttribute('href');
            loadPage(url);
        });
    });
}

function submitForm(form, url) {
    if (!url || url === '') {
        if (form.classList.contains('login-form')) {
            url = 'modules/login.php';
        } else if (form.classList.contains('register-form')) {
            url = 'modules/register.php';
        } else if (form.classList.contains('jobs-form') || form.classList.contains('job-list')) {
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
            bindFormSubmit();
            bindMenuLinks();
            if (html.includes('success')) {
                location.reload();
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            document.getElementById('mainContent').innerHTML = 'Erro ao processar o formulário';
        });
}

function loadPage(url) {
    fetch(url)
        .then(response => response.text())
        .then(html => {
            document.getElementById('mainContent').innerHTML = html;
            bindFormSubmit();
            bindMenuLinks();
        })
        .catch(error => {
            console.error('Erro:', error);
            document.getElementById('mainContent').innerHTML = 'Erro ao carregar a página';
        });
}