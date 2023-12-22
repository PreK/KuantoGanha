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

            // Adicionando um delay para garantir que o DOM tenha sido atualizado
            setTimeout(function() {
                if ($('#mainContent').text().includes('success')) {
                    window.location.reload();
                }
            }, 100); // Ajuste o tempo de delay conforme necessário
        }).fail(function() {
            $('#mainContent').html('Erro ao processar o formulário');
        });
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
