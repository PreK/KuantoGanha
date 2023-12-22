$(document).ready(function() {
    $('#loginLink, #registerLink, #jobsLink').click(function(event) {
        event.preventDefault();
        var page = $(this).attr('id').replace('Link', '') + '.php';
        loadContent(page);
    });

    function loadContent(page) {
        $.get('modules/' + page, function(html) {
            $('#mainContent').html(html);
            bindFormSubmit();
        }).fail(function() {
            $('#mainContent').html('Erro ao carregar a página');
        });
    }

    function bindFormSubmit() {
        $('#mainContent').find('form').submit(function(event) {
            event.preventDefault();
            submitForm($(this));
        });
    }

    function submitForm($form) {
        var url = $form.attr('action') || 'modules/' + $form.attr('class').split('-')[0] + '.php';

        $.post(url, $form.serialize(), function(html) {
            $('#mainContent').html(html);
            bindFormSubmit();

            // Delay na verificação para garantir que o DOM foi atualizado
            setTimeout(function() {
                if ($('#mainContent').text().includes('success')) {
                    window.location.reload();
                }
            }, 100); // Ajuste o tempo conforme necessário
        }).fail(function() {
            $('#mainContent').html('Erro ao processar o formulário');
        });
    }
});