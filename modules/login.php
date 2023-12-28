<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'dbconfig.php'; // Include database configuration file
header('Content-Type: application/json');
// Initialize variables for username and password
$username = $password = "";
$username_err = $password_err = $login_err = "";

// Process the form data when the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate username
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter your username.";
    } else {
        $username = trim($_POST["username"]);
    }

    // Validate password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate credentials
    if (empty($username_err) && empty($password_err)) {
        $pdo = getDbConnection();
        $sql = "SELECT uid, username, password FROM users WHERE username = :username";

        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            $param_username = $username;

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Check if username exists, if yes then verify password
                if ($stmt->rowCount() == 1) {
                    if ($row = $stmt->fetch()) {
                        if (isset($row["id"])) {
                            $id = $row["id"];
                        }
                        $username = $row["username"];
                        $hashed_password = $row["password"];
                        if (password_verify($password, $hashed_password)) {

                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["uid"] = $row["uid"];
                            $_SESSION["username"] = $username;

                            // For ajax know if login was successful
                            echo json_encode(["success" => true]);
                            exit;
                        } else {
                            // Display an error message if password is not valid
                            echo json_encode(["baduserpass" => true]);
                            exit;
                        }
                    }
                } else {
                    // Display an error message if username doesn't exist
                    echo json_encode(["nouser" => true]);
                    exit;
                }
            }
            // Close statement
            unset($stmt);
        }
    }

    // Close connection
    unset($pdo);
}
?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="login-form">
        <h2>Login</h2>
        <p>Please fill in your credentials to login.</p>

        <?php
        if(!empty($login_err)){
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }
        ?>

        <form class="loginForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" id="loginForm">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                <span class="text-danger"><?php echo $username_err; ?></span>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control">
                <span class="text-danger"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
        </form>
    </div>
</main>


