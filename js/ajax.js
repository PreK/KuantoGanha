document.addEventListener('DOMContentLoaded', function() {
    bindFormSubmit();
});

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
            window.location.reload();
        })
        .catch(error => {
            console.error('Erro:', error);
            document.getElementById('mainContent').innerHTML = 'Erro ao processar o formulário';
        });
}