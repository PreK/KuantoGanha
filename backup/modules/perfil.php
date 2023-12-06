<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Perfil do Utilizador</title>
    <!-- Incluir CSS aqui -->
</head>
<body>
<h1>Perfil do Usuário</h1>

<!-- Seção: Dados Pessoais -->
<section>
    <h2>Dados Pessoais</h2>
    <form action="update_user.php" method="post">
        Nome de Usuário: <input type="text" name="username" required>
        Email: <input type="email" name="email" required>
        Foto de Perfil: <input type="text" name="profile_photo">
        <input type="submit" value="Atualizar Dados Pessoais">
    </form>
</section>

<!-- Seção: Dados Acadêmicos -->
<section>
    <h2>Dados Acadêmicos</h2>
    <form action="update_academic_data.php" method="post">
        Grau Acadêmico: <input type="text" name="academic_degree" required>
        Área de Estudo: <input type="text" name="field_of_study" required>
        Instituição de Ensino: <input type="text" name="educational_institution" required>
        Ano de Conclusão: <input type="date" name="year_of_completion">
        <input type="submit" value="Atualizar Dados Acadêmicos">
    </form>
</section>

<!-- Seção: Profissões -->
<section>
    <h2>Profissões</h2>
    <form action="update_jobs.php" method="post">
        Cargo: <input type="text" name="title" required>
        Data de Início: <input type="date" name="start_date" required>
        <input type="submit" value="Adicionar/Atualizar Emprego">
    </form>
</section>

<!-- Seção: Outras seções conforme necessário -->

<!-- Incluir JavaScript se necessário -->
</body>
</html>
