<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/dbconfig.php';

// Verificar se o utilizador está logado
$userId = $_SESSION['uid'] ?? null;
if (!$userId) {
    echo "Utilizador não está logado.";
    exit;
}

function getUserAcademicData($userId) {
    $pdo = getDbConnection();
    $sql = "SELECT * FROM academic_data WHERE user_id = :userId";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

$academicData = getUserAcademicData($userId);

// Alteração de Senha
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
    exit;
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
    exit;
}

// Funções para Alteração de Senha e Gerenciamento de Dados Acadêmicos
function updateUserPassword($userId, $currentPassword, $newPassword) {
    $pdo = getDbConnection();

    // Primeiro, verificar se a senha atual está correta
    $sql = "SELECT password FROM users WHERE uid = :userId";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($currentPassword, $user['password'])) {
        // A senha atual está correta, então atualize para a nova senha
        $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);
        $updateSql = "UPDATE users SET password = :newPassword WHERE uid = :userId";
        $updateStmt = $pdo->prepare($updateSql);
        $updateStmt->bindParam(':newPassword', $newPasswordHash);
        $updateStmt->bindParam(':userId', $userId, PDO::PARAM_INT);

        return $updateStmt->execute();
    } else {
        // Senha atual incorreta
        return false;
    }
}

function manageUserAcademicData($userId, $academicDegree, $fieldOfStudy, $institution, $yearOfCompletion) {
    $pdo = getDbConnection();

    // Verificar se já existem dados acadêmicos para o usuário
    $checkSql = "SELECT * FROM academic_data WHERE user_id = :userId";
    $checkStmt = $pdo->prepare($checkSql);
    $checkStmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    $checkStmt->execute();
    $exists = $checkStmt->fetch(PDO::FETCH_ASSOC);

    if ($exists) {
        // Atualizar dados acadêmicos existentes
        $updateSql = "UPDATE academic_data SET academic_degree = :academicDegree, field_of_study = :fieldOfStudy, 
                      educational_institution = :institution, year_of_completion = :yearOfCompletion 
                      WHERE user_id = :userId";
    } else {
        // Inserir novos dados acadêmicos
        $updateSql = "INSERT INTO academic_data (user_id, academic_degree, field_of_study, educational_institution, year_of_completion) 
                      VALUES (:userId, :academicDegree, :fieldOfStudy, :institution, :yearOfCompletion)";
    }

    $updateStmt = $pdo->prepare($updateSql);
    $updateStmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    $updateStmt->bindParam(':academicDegree', $academicDegree);
    $updateStmt->bindParam(':fieldOfStudy', $fieldOfStudy);
    $updateStmt->bindParam(':institution', $institution);
    $updateStmt->bindParam(':yearOfCompletion', $yearOfCompletion);

    return $updateStmt->execute();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Perfil do Utilizador</title>
</head>
<body>
<main class="container">
    <div class="row">
        <div class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="form-container">
                <h2>Perfil do Utilizador</h2>

                <!-- Formulário de Alteração de Senha -->
                <form id="changePasswordForm" method="post" class="mb-4">
                    <h3>Alterar Senha</h3>
                    <div class="form-group mb-3">
                        <label for="currentPassword" class="form-label">Senha Atual</label>
                        <input type="password" name="currentPassword" id="currentPassword" class="form-control" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="newPassword" class="form-label">Nova Senha</label>
                        <input type="password" name="newPassword" id="newPassword" class="form-control" required>
                    </div>
                    <input type="hidden" name="action" value="changePassword">
                    <button type="submit" class="btn btn-primary">Alterar Senha</button>
                </form>

                <!-- Formulário para Dados Acadêmicos -->
                <form id="academicDataForm" method="post" class="mb-4">
                    <h3>Dados Académicos</h3>
                    <div class="form-group mb-3">
                        <label for="academic_degree" class="form-label">Grau Académico</label>
                        <input type="text" name="academic_degree" id="academic_degree"
                               class="form-control" value="<?php echo htmlspecialchars($academicData['academic_degree'] ?? ''); ?>" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="field_of_study" class="form-label">Área de Estudo</label>
                        <input type="text" name="field_of_study" id="field_of_study"
                               class="form-control" value="<?php echo htmlspecialchars($academicData['field_of_study'] ?? ''); ?>" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="educational_institution" class="form-label">Instituição</label>
                        <input type="text" name="educational_institution" id="educational_institution"
                               class="form-control" value="<?php echo htmlspecialchars($academicData['educational_institution'] ?? ''); ?>" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="year_of_completion" class="form-label">Ano de Conclusão</label>
                        <input type="date" name="year_of_completion" id="year_of_completion"
                               class="form-control" value="<?php echo htmlspecialchars($academicData['year_of_completion'] ?? ''); ?>" required>
                    </div>
                    <input type="hidden" name="action" value="manageAcademicData">
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </form>
            </div>
        </div>
    </div>
</main>
</body>
</html>
