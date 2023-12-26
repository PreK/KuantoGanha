document.addEventListener('DOMContentLoaded', function() {
    // Função genérica para lidar com a submissão de formulários
    function handleFormSubmit(formId, url) {
        var form = document.getElementById(formId);
        if (form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                var formData = new FormData(this);

                fetch(url, {
                    method: 'POST',
                    body: formData
                })
                    .then(response => response.text())
                    .then(data => {
                        // Lidar com a resposta
                        alert(data); // Exibe a resposta do servidor
                    })
                    .catch(error => console.error('Erro na requisição AJAX:', error));
            });
        }
    }

    // Configuração para cada formulário
    handleFormSubmit('registerForm', 'register.php');
    handleFormSubmit('loginForm', 'login.php');
    handleFormSubmit('jobsForm', 'jobs.php');
    // Adicione mais conforme necessário

});