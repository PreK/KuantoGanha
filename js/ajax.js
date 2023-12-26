document.addEventListener('DOMContentLoaded', function() {


    // Função para carregar o conteúdo
    function loadContent(url, targetElementId) {
        if (url !== '#') {
            fetch(url)
                .then(response => response.text())
                .then(html => {
                    document.getElementById(targetElementId).innerHTML = html;

                    // Reconfiguração específica para o formulário de login
                    if (url === 'modules/login.php') {
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

                var formData = new FormData(loginForm);

                fetch('modules/login.php', {
                    method: 'POST',
                    body: formData
                })
                    .then(response => response.json())
                    .then(data => {
                        if(data.success) {
                            location.reload();
                        } else {
                            alert("Erro ao processar o login!" + data);
                        }
                    })
                    .catch(error => console.error('Erro ao processar o login:', error));
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
