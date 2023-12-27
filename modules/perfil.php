<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'dbconfig.php';
require_once 'getInfo.php';


$userData = getUserData($_SESSION['uid']);
$academicData = getAcademicData($_SESSION['uid']);
$jobData = getJobData($_SESSION['uid']);
echo '<pre>';
print_r($userData);
echo '</pre>';
echo '<pre>';
print_r($academicData);
echo '</pre>';
echo '<pre>';
print_r($jobData);
echo '</pre>';


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['updateUserInfo'])) {
    // Inicialização das variáveis com dados do formulário
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $userId = $_SESSION['uid']; // ou outro identificador de usuário apropriado

    $pdo = getDbConnection();

    // Validação básica (deve ser expandida conforme necessário)
    if (empty($username) || empty($email)) {
        // Adicione um erro se os campos estiverem vazios
        $error = "Por favor, preencha todos os campos.";
    } else {
        // Processamento da atualização no banco de dados
        $sql = "UPDATE users SET username = :username, email = :email WHERE uid = :uid";

        if ($stmt = $pdo->prepare($sql)) {
            // Vincular parâmetros
            $stmt->bindParam(":username", $username, PDO::PARAM_STR);
            $stmt->bindParam(":email", $email, PDO::PARAM_STR);
            $stmt->bindParam(":uid", $userId, PDO::PARAM_INT);

            // Executar a declaração
            if ($stmt->execute()) {
                $success = "Informações atualizadas com sucesso.";
            } else {
                $error = "Erro ao atualizar as informações.";
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Perfil do Usuário</title>
    <!-- Adicione aqui os links para o CSS -->
</head>
<body>
<div class="user-profile">
    <h2>Perfil de <?php echo htmlspecialchars($userData['username']); ?></h2>

    <!-- Formulário para editar informações do usuário -->
    <form method="post">
        <!-- Campos para editar informações do usuário -->
        <label>Nome de Usuário:</label>
        <input type="text" name="username" value="<?php echo htmlspecialchars($userData['username']); ?>">
        <label>Email:</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($userData['email']); ?>">
        <input type="submit" name="updateUserInfo" value="Salvar Alterações">
    </form>

    <!-- Seção de Dados Acadêmicos -->
    <div class="academic-data">
        <h3>Dados Acadêmicos</h3>
        <!-- Listar os dados acadêmicos -->
        <?php foreach ($academicData as $data) { ?>
            <p><?php echo htmlspecialchars($data['academic_degree']); ?> em <?php echo htmlspecialchars($data['field_of_study']); ?></p>
        <?php } ?>
    </div>

    <!-- Seção de Empregos e Salários -->
    <div class="job-data">
        <h3>Empregos e Salários</h3>
        <!-- Listar os empregos e salários -->
        <?php foreach ($jobData as $job) { ?>
            <p><?php echo htmlspecialchars($job['title']); ?> - <?php echo htmlspecialchars($job['gross_amount']); ?></p>
        <?php } ?>
    </div>
</div>
</body>
</html>
