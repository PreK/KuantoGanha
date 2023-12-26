document.addEventListener('DOMContentLoaded', function() {
    // Função para carregar o conteúdo
    function loadContent(url, targetElementId) {
        if (url !== '#') {
            fetch(url)
                .then(response => response.text())
                .then(html => {
                    document.getElementById(targetElementId).innerHTML = html;
                    // Inicializar scripts adicionais aqui, se necessário
                })
                .catch(error => console.error('Erro ao carregar o conteúdo:', error));
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
