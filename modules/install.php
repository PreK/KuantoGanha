<?php
require_once 'dbconfig.php';

try {
    $pdo = getDbConnection();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // SQL to create all tables
    $createTablesSql = "
    -- Users Table
    CREATE TABLE IF NOT EXISTS users (
        uid SERIAL PRIMARY KEY,
        username VARCHAR(255) UNIQUE NOT NULL,
        password VARCHAR(255) NOT NULL,
        email VARCHAR(255) UNIQUE NOT NULL,
        profile_photo VARCHAR(200) DEFAULT NULL
    );

    -- Academic Data Table
    CREATE TABLE IF NOT EXISTS academic_data (
        id SERIAL PRIMARY KEY,
        user_id INTEGER REFERENCES users(uid),
        academic_degree VARCHAR(100) NOT NULL,
        field_of_study VARCHAR(255) NOT NULL,
        educational_institution VARCHAR(255) NOT NULL,
        year_of_completion DATE
    );
    -- Jobs Table with Start Date
    CREATE TABLE IF NOT EXISTS jobs (
        id SERIAL PRIMARY KEY,
        title VARCHAR(255) NOT NULL
    );
    
    -- Salaries Table with additional fields
    CREATE TABLE IF NOT EXISTS salaries (
        id SERIAL PRIMARY KEY,
        user_id INTEGER REFERENCES users(uid),
        job_id INTEGER REFERENCES jobs(id),
        gross_amount DECIMAL(10,2) NOT NULL,
        discount_percentage DECIMAL(5,2), -- Assuming a value between 0 and 100.
        food_allowance DECIMAL(10,2),
        tax_exempt_extras DECIMAL(10,2),
        created_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP WITH TIME ZONE
    );
    
    -- Salary History Table
    CREATE TABLE IF NOT EXISTS salary_history (
        id SERIAL PRIMARY KEY,
        user_id INTEGER REFERENCES users(uid),
        job_id INTEGER REFERENCES jobs(id),
        gross_amount DECIMAL(10,2) NOT NULL,
        discount_percentage DECIMAL(5,2),
        food_allowance DECIMAL(10,2),
        tax_exempt_extras DECIMAL(10,2),
        start_date TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
        end_date TIMESTAMP WITH TIME ZONE -- NULL means it is the current salary.
    );
    
    -- Benefits Table
    CREATE TABLE IF NOT EXISTS benefits (
        id SERIAL PRIMARY KEY,
        description TEXT NOT NULL
    );
    
    -- Associative Table Salary-Benefits
    CREATE TABLE IF NOT EXISTS salary_benefits (
        salary_id INTEGER REFERENCES salaries(id),
        benefit_id INTEGER REFERENCES benefits(id),
        PRIMARY KEY (salary_id, benefit_id)
    );
    
    -- Locations Table
    CREATE TABLE IF NOT EXISTS locations (
        id SERIAL PRIMARY KEY,
        district VARCHAR(100) NOT NULL
    );
    
    INSERT INTO locations (district) VALUES
    ('Aveiro'),
    ('Beja'),
    ('Braga'),
    ('Bragança'),
    ('Castelo Branco'),
    ('Coimbra'),
    ('Évora'),
    ('Faro'),
    ('Guarda'),
    ('Leiria'),
    ('Lisboa'),
    ('Portalegre'),
    ('Porto'),
    ('Santarém'),
    ('Setúbal'),
    ('Viana do Castelo'),
    ('Vila Real'),
    ('Viseu'),
    ('Madeira'),
    ('Açores');
    
    
    -- Work Modalities Table
    CREATE TABLE IF NOT EXISTS work_modalities (
        id SERIAL PRIMARY KEY,
        description VARCHAR(50) NOT NULL -- e.g., 'Remote', 'On-site', 'Hybrid'
    );
    
    INSERT INTO work_modalities (description) VALUES
    ('Presencial'),
    ('Remoto'),
    ('Híbrido'),
    ('Flexível'),
    ('Conta própria'),
    ('Freelancer'),
    ('Estágio');
    
    -- Relationship between Users and Jobs
    CREATE TABLE IF NOT EXISTS user_jobs (
        id SERIAL PRIMARY KEY,
        user_id INTEGER REFERENCES users(uid),
        job_id INTEGER REFERENCES jobs(id),
        location_id INTEGER REFERENCES locations(id),
        modality_id INTEGER REFERENCES work_modalities(id),
        start_date DATE NOT NULL,
        end_date DATE -- NULL means the job is current.
    );
    ";

    $pdo->exec($createTablesSql);

    // Create an initial admin user
    $username = 'admin';
    $password = password_hash('admin', PASSWORD_DEFAULT); // Change this in production!
    $email = 'admin@kuantoganha.pt';

    $insertAdminSql = "INSERT INTO users (username, password, email) VALUES (:username, :password, :email) ON CONFLICT DO NOTHING;";
    $stmt = $pdo->prepare($insertAdminSql);

    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':email', $email);

    $stmt->execute();

    echo "Installation successful. Admin user created.";

} catch (PDOException $e) {
    die("DB ERROR: " . $e->getMessage());
}
?>

