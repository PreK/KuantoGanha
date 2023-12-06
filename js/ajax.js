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
            submitForm(event.target, 'modules/login.php', true); // Adicionado um parâmetro para identificar login
        }

        // Se for o formulário de registro
        if (event.target.matches('.register-form form')) {
            event.preventDefault();
            submitForm(event.target, 'modules/register.php', false); // Aqui é para registro, então false
        }
    });
});

function submitForm(form, url, isLogin) {
    const formData = new FormData(form);
    fetch(url, {
        method: 'POST',
        body: formData
    })
        .then(response => response.text())
        .then(html => {
            if (isLogin && html.includes('success')) {
                // Se for login e a resposta incluir 'success', recarregue a página
                window.location.reload();
            } else {
                // Para outros casos (registro ou mensagem de erro de login), atualize o conteúdo principal
                document.getElementById('mainContent').innerHTML = html;
            }
        })
        .catch(error => console.error('Error:', error));
}
