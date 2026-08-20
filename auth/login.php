<?php

session_start();

require_once "../config/database.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    if (empty($username) || empty($password)) {

        $error = "Please enter username and password.";

    } else {

        $sql = "SELECT * FROM users
                WHERE username = ?
                AND status = 'active'
                LIMIT 1";

        $stmt = $conn->prepare($sql);

        if ($stmt) {

            $stmt->bind_param("s", $username);

            $stmt->execute();

            $result = $stmt->get_result();

            if ($result->num_rows == 1) {

                $user = $result->fetch_assoc();

                if ($password === $user["password"]) {

                    $_SESSION["user_id"] = $user["id"];
                    $_SESSION["username"] = $user["username"];
                    $_SESSION["full_name"] = $user["full_name"];
                    $_SESSION["role"] = $user["role"];

                    /*
                    |--------------------------------
                    | ADMIN LOGIN
                    |--------------------------------
                    */

                    if ($user["role"] === "admin") {

                        header("Location: ../admin/dashboard.php");
                        exit();

                    }

                    /*
                    |--------------------------------
                    | USER LOGIN
                    |--------------------------------
                    */

                    else if ($user["role"] === "user") {

                        header("Location: ../user/dashboard.php");
                        exit();

                    }

                    else {

                        $error = "Invalid user role.";

                    }

                } else {

                    $error = "Invalid username or password.";

                }

            } else {

                $error = "Invalid username or password.";

            }

            $stmt->close();

        } else {

            $error = "Database query failed.";

        }
    }
}

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login - Inventory Management System</title>

    <link rel="stylesheet" href="../assets/css/style.css">

</head>

<body>

    <div class="login-container">

        <h2>Inventory Management System</h2>

        <h3>Login</h3>

        <?php

        if (!empty($error)) {

            echo '<div class="error">';
            echo htmlspecialchars($error);
            echo '</div>';

        }

        ?>

        <form method="POST" action="">

            <label>Username</label>

            <input
                type="text"
                name="username"
                placeholder="Enter username"
                required
            >

            <label>Password</label>

            <input
                type="password"
                name="password"
                placeholder="Enter password"
                required
            >

            <button type="submit">
                Login
            </button>

        </form>

    </div>

</body>

</html>