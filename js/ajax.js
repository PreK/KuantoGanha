$(document).ready(function() {
    // Vincula eventos de clique para carregar páginas específicas
    $('#loginLink, #registerLink, #jobsLink').click(function(event) {
        event.preventDefault();
        var page = $(this).attr('id').replace('Link', '') + '.php';
        loadContent(page);
    });

    // Carrega o conteúdo dinamicamente e atualiza mainContent
    function loadContent(page) {
        $.get('modules/' + page, function(html) {
            $('#mainContent').html(html);
            bindFormSubmit();
            bindMenuLinks();
        }).fail(function() {
            $('#mainContent').html('Erro ao carregar a página');
        });
    }

    // Vincula eventos de submissão de formulários
    function bindFormSubmit() {
        $('#mainContent').find('form').submit(function(event) {
            event.preventDefault();
            submitForm($(this));
        });
    }

    // Trata a submissão do formulário
    function submitForm($form) {
        var url = $form.attr('action') || 'modules/' + $form.attr('class').split('-')[0] + '.php';

        $.post(url, $form.serialize(), function(html) {
            $('#mainContent').html(html);
            bindFormSubmit();
            bindMenuLinks();

            processResponse(html);
        }).fail(function() {
            $('#mainContent').html('Erro ao processar o formulário');
        });
    }

    function processResponse(html) {
        if (html.includes('register-success')) {
            loadContent('login.php'); // Carrega a página de login
        } else if (html.includes('login-success')) {
            window.location.href = 'index.php'; // Recarrega a página index
        } else if (html.includes('job-modified')) {
            loadContent('jobs.php'); // Recarrega a página de jobs
        }
    }

    // Vincula eventos de clique aos links dentro de mainContent
    function bindMenuLinks() {
        $('#mainContent a').click(function(event) {
            event.preventDefault();
            var href = $(this).attr('href');
            if (href) {
                loadContent(href);
            }
        });
    }
});
