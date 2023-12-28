<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'dbconfig.php'; // Conexão com o banco de dados

// Verificar se o usuário está logado
$userId = $_SESSION['uid'] ?? null;
if (!$userId) {
    echo "Utilizador não está logado.";
    exit;
}

// Processamento para Alteração de Senha
if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['action'] == 'changePassword') {
    $currentPassword = $_POST['currentPassword'];
    $newPassword = $_POST['newPassword'];

    // Função para verificar a senha atual e atualizar para a nova senha
    // Supondo que esta função retorne verdadeiro se a senha for alterada com sucesso
    $passwordChanged = updateUserPassword($userId, $currentPassword, $newPassword);
    if ($passwordChanged) {
        echo "Senha alterada com sucesso!";
    } else {
        echo "Erro ao alterar a senha.";
    }
}

// Processamento para Gerenciamento de Dados Acadêmicos
if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['action'] == 'manageAcademicData') {
    $academicDegree = $_POST['academic_degree'];
    $fieldOfStudy = $_POST['field_of_study'];
    $institution = $_POST['educational_institution'];
    $yearOfCompletion = $_POST['year_of_completion'];

    // Função para inserir ou atualizar dados acadêmicos
    // Supondo que esta função retorne verdadeiro se os dados forem salvos com sucesso
    $dataSaved = manageUserAcademicData($userId, $academicDegree, $fieldOfStudy, $institution, $yearOfCompletion);
    if ($dataSaved) {
        echo "Dados acadêmicos salvos com sucesso!";
    } else {
        echo "Erro ao salvar os dados acadêmicos.";
    }
}

// Funções para Alteração de Senha e Gerenciamento de Dados Acadêmicos
function updateUserPassword($userId, $currentPassword, $newPassword) {
    // Implemente esta função
}

function manageUserAcademicData($userId, $academicDegree, $fieldOfStudy, $institution, $yearOfCompletion) {
    // Implemente esta função
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Perfil do Utilizador</title>
    <!-- Incluir CSS e JavaScript se necessário -->
</head>
<body>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="form-container">
        <h2>Perfil do Utilizador</h2>

        <!-- Formulário de Alteração de Senha -->
        <form id="changePasswordForm" method="post">
            <h3>Alterar Senha</h3>
            <div class="form-group">
                <label for="currentPassword">Senha Atual</label>
                <input type="password" name="currentPassword" id="currentPassword" required>
            </div>
            <div class="form-group">
                <label for="newPassword">Nova Senha</label>
                <input type="password" name="newPassword" id="newPassword" required>
            </div>
            <input type="hidden" name="action" value="changePassword">
            <button type="submit">Alterar Senha</button>
        </form>

        <!-- Formulário para Dados Acadêmicos -->
        <form id="academicDataForm" method="post">
            <h3>Dados Acadêmicos</h3>
            <div class="form-group">
                <label for="academic_degree">Grau Acadêmico</label>
                <input type="text" name="academic_degree" id="academic_degree" required>
            </div>
            <div class="form-group">
                <label for="field_of_study">Campo de Estudo</label>
                <input type="text" name="field_of_study" id="field_of_study" required>
            </div>
            <div class="form-group">
                <label for="educational_institution">Instituição Educacional</label>
                <input type="text" name="educational_institution" id="educational_institution" required>
            </div>
            <div class="form-group">
                <label for="year_of_completion">Ano de Conclusão</label>
                <input type="text" name="year_of_completion" id="year_of_completion" required>
            </div>
            <input type="hidden" name="action" value="manageAcademicData">
            <button type="submit">Salvar Dados Acadêmicos</button>
        </form>
    </div>
</main>
</body>
</html>
