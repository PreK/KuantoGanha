document.addEventListener('DOMContentLoaded', function() {

    // Função para carregar o conteúdo
    function loadContent(url, targetElementId) {
        if (url !== '#') {
            fetch(url)
                .then(response => response.text())
                .then(html => {
                    document.getElementById(targetElementId).innerHTML = html;

                    // Reconfiguração específica para o formulário de login
                    if (url === 'login.php') {
                        setupLoginForm();
                    }

                    // Aqui você pode adicionar condições semelhantes para outros formulários se necessário
                })
                .catch(error => console.error('Erro ao carregar o conteúdo:', error));
        }
    }

    function setupLoginForm() {
        var loginForm = document.getElementById('loginForm');
        if (loginForm) {
            loginForm.addEventListener('submit', function(e) {
                e.preventDefault();

                // Obter dados do formulário
                var formData = new FormData(loginForm);

                // Enviar dados do formulário via AJAX
                fetch('process_login.php', {
                    method: 'POST',
                    body: formData
                })
                    .then(response => response.text())
                    .then(data => {
                        if (data === 'success') {
                            // Redirecionar ou realizar ações após o login bem-sucedido
                            alert('Login successful');
                            // Você pode redirecionar para outra página ou fazer algo aqui
                        } else {
                            // Exibir mensagem de erro no formulário
                            var loginError = document.getElementById('loginError');
                            if (loginError) {
                                loginError.textContent = 'Invalid username or password.';
                            }
                        }
                    })
                    .catch(error => console.error('Erro ao enviar dados via AJAX:', error));
            });
        }
    }

    // Adiciona ouvintes de eventos para os links da barra lateral
    document.querySelectorAll('.nav-link').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            var targetUrl = this.getAttribute('data-target');
            loadContent(targetUrl, 'mainContent');
        });
    });

});
