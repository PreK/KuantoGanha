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

                    if (url === 'modules/register.php') {
                        setupRegisterForm();
                    }

                    if (url === 'modules/jobs.php') {
                        setupJobsForm();
                    }
                    if (url === 'modules/userJobs.php') {
                        setupUserJobsForm();
                    }
                    if (url === 'modules/perfil.php') {
                        setupChangePasswordForm();
                        setupAcademicDataForm();
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
                console.log("Formulário está tentando enviar");
                //e.preventDefault();

                var formData = new FormData(loginForm);

                fetch('modules/login.php', {
                    method: 'POST',
                    body: formData,
                    headers: new Headers({
                        'Accept': 'application/json'
                    })
                })
                    .then(response => response.json())
                    .then(data => {
                        console.log(data); // Verifique o que está sendo retornado
                        if(data.success) {
                            location.reload();
                            alert("Login efetuado com sucesso!")
                        } else {
                            alert("Erro ao processar o login!" + data);
                        }
                    })
                    .catch(error => console.error('Erro ao processar o login:', error));
            });
        }
    }

    function setupRegisterForm() {
        var registerForm = document.getElementById('registerForm');
        if (registerForm) {
            registerForm.addEventListener('submit', function(e) {
                e.preventDefault();

                var formData = new FormData(registerForm);

                fetch('modules/register.php', {
                    method: 'POST',
                    body: formData
                })
                    .then(response => response.text())
                    .then(data => {
                        console.log(data); // Verifique o que está sendo retornado
                        if(data === 'success') {
                            alert("Registro efetuado com sucesso!");
                            loadContent("modules/login.php", "mainContent");// Você pode redirecionar o usuário ou atualizar a página aqui
                        } else {
                            alert("Erro ao processar o registro: " + data);
                        }
                    })
                    .catch(error => console.error('Erro ao processar o registro:', error));
            });
        }
    }

    function setupUserJobsForm() {
        var addUserJobsForm = document.getElementById('userJobsForm');
        var removeUserJobsForm = document.getElementById('removeUserJobsForm');

        if (addUserJobsForm) {
            addUserJobsForm.addEventListener('submit', function(e) {
                e.preventDefault();
                submitUserJobForm(this, "Adição");
            });
        }

        if (removeUserJobsForm) {
            removeUserJobsForm.addEventListener('submit', function(e) {
                e.preventDefault();
                submitUserJobForm(this, "Remoção");
            });
        }
    }

    function submitUserJobForm(form, actionType) {
        var formData = new FormData(form);

        fetch('modules/userJobs.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.text())
            .then(data => {
                console.log(data); // Verifique o que está sendo retornado
                if (data === 'success') {
                    alert("Profissão " + actionType + " com sucesso!");
                    loadContent("modules/userJobs.php", "mainContent");
                } else {
                    alert("Erro ao processar a profissão: " + data);
                }
            })
            .catch(error => console.error('Erro ao processar a profissão:', error));
    }


    function setupJobsForm() {
        var addJobForm = document.getElementById('addJobForm');
        if (addJobForm) {
            addJobForm.addEventListener('submit', function(e) {
                e.preventDefault();
                submitJobForm(addJobForm, 'add');
            });
        }

        document.querySelectorAll('.job-list').forEach(function(form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                submitJobForm(form, 'remove');
            });
        });
    }

    function submitJobForm(form, action) {
        var formData = new FormData(form);
        formData.append('action', action);

        fetch('modules/jobs.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.text())
            .then(data => {
                if(data === 'success') {
                    loadContent("modules/jobs.php", "mainContent");
                } else {
                    alert('Erro: ' + data);
                }
            })
            .catch(error => console.error('Erro:', error));
    }
    function setupChangePasswordForm() {
        const changePasswordForm = document.getElementById('changePasswordForm');
        if (changePasswordForm) {
            changePasswordForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(changePasswordForm);
                formData.append('action', 'changePassword');

                fetch('modules/perfil.php', {
                    method: 'POST',
                    body: formData
                })
                    .then(response => response.text())
                    .then(data => {
                        alert(data); // Exibe a mensagem de retorno
                        if(data === 'success') {
                        loadContent('modules/perfil.php', 'mainContent'); // Recarrega o conteúdo do perfil
                        }
                    })
                    .catch(error => console.error('Erro:', error));
            });
        }
    }

    function setupAcademicDataForm() {
        const academicDataForm = document.getElementById('academicDataForm');
        if (academicDataForm) {
            academicDataForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(academicDataForm);
                formData.append('action', 'manageAcademicData');

                fetch('modules/perfil.php', {
                    method: 'POST',
                    body: formData
                })
                    .then(response => response.text())
                    .then(data => {
                        alert(data); // Exibe a mensagem de retorno
                        if(data === 'success') {
                        loadContent('modules/perfil.php', 'mainContent'); // Recarrega o conteúdo do perfil
                        }
                    })
                    .catch(error => console.error('Erro:', error));
            });
        }
    }
    // Adiciona ouvintes de eventos para os links da barra lateral
    document.querySelectorAll('.nav-link').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            var targetUrl = this.getAttribute('data-target');
            if(targetUrl === null) {
                location.reload();
            }else{
                loadContent(targetUrl, 'mainContent');
            }
        });
    });
});
