document.addEventListener("DOMContentLoaded", function() {
    // Função para carregar conteúdo no mainContent
    function loadContent(url) {
        fetch(url)
            .then(response => response.text())
            .then(html => {
                document.getElementById('mainContent').innerHTML = html;
            })
            .catch(error => {
                console.error('Erro ao carregar o conteúdo:', error);
            });
    }

    // Manipuladores de clique para links da barra lateral
    document.querySelectorAll('.sidebar .nav-link').forEach(link => {
        link.addEventListener('click', function(event) {
            event.preventDefault();
            const url = this.getAttribute('href');
            if (url !== '#') {
                loadContent(url);
            }
        });
    });

    // Função para enviar dados de formulários via AJAX
    function sendForm(form, url) {
        var formData = new FormData(form);
        fetch(url, {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                console.log(data); // Processar a resposta
                // Aqui você pode redirecionar o usuário ou atualizar a interface
            })
            .catch(error => {
                console.error('Erro:', error);
            });
    }

    // Intercepta submissões de formulário de login e registro
    document.querySelectorAll('.ajaxForm').forEach(form => {
        form.addEventListener('submit', function(event) {
            event.preventDefault();
            sendForm(this, this.getAttribute('action'));
        });
    });

    // Logout
    const logoutLink = document.getElementById('logoutLink');
    if (logoutLink) {
        logoutLink.addEventListener('click', function(event) {
            event.preventDefault();
            fetch('modules/logout.php', { method: 'POST' })
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    // Redirecionar para a página de login ou atualizar a interface
                })
                .catch(error => {
                    console.error('Erro no logout:', error);
                });
        });
    }
});
