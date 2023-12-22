document.addEventListener('DOMContentLoaded', function() {
    // Carregar formulário de login
    var loginLink = document.getElementById('loginLink');
    if (loginLink) {
        loginLink.addEventListener('click', function() {
            loadContent('login.php');
        });
    }

    // Carregar formulário de registro
    var registerLink = document.getElementById('registerLink');
    if (registerLink) {
        registerLink.addEventListener('click', function() {
            loadContent('register.php');
        });
    }
    // Carregar página de editar profissões
    var jobsLink = document.getElementById('jobsLink');
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
            document.getElementById('mainContent').innerHTML = 'Erro ao carregar a página';
        }
    };
    xhr.open('GET', 'modules/' + page, true);
    xhr.send();
}

function bindFormSubmit() {
    document.querySelectorAll('form').forEach(function(form) {
        console.log("Vinculando formulário:", form); // Debug
        form.addEventListener('submit', function(event) {
            event.preventDefault();
            var formType = form.classList.contains('login-form') ? 'login' : 'register';
            console.log("Tipo do formulário:", formType); // Debug
            var actionUrl = formType === 'login' ? 'modules/login.php' : 'modules/register.php';
            console.log("URL de ação:", actionUrl); // Debug
            submitForm(form, actionUrl, formType === 'login');
        });
    });
}

function submitForm(form, url, isLogin) {
    const formData = new FormData(form);
    fetch(url, {
        method: 'POST',
        body: formData
    })
        .then(response => response.text())
        .then(html => {
            if (isLogin && html.includes('success')) {
                window.location.reload();
            } else {
                document.getElementById('mainContent').innerHTML = html;
                bindFormSubmit(); // Vincular novamente para os novos formulários
            }
        })
        .catch(error => console.error('Error:', error));
}