<?php

    session_start();

    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
        header("location: account.php");
        exit;
    }

    include "config.php";
    include "templates/header.php";

    $userName = $password = "";
    $userNameError = $passwordError = $loginError = "";

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        if(empty(trim($_POST["userName"]))) {
            $userNameError = "Please enter a username.";
        } else {
            $userName = trim($_POST["userName"]);
        }

        if(empty(trim($_POST["password"]))) {
            $passwordError = "Please enter a password.";
        } else {
            $password = trim($_POST["password"]);
        }

        if(empty($userNameError) && empty($passwordError)) {
            $sqlSelect = "SELECT userId, userName, password FROM users WHERE userName = ?";

            if($statement = $connection->prepare($sqlSelect)) {
                $statement->bind_param("s", $param_userName);
                $param_userName = $userName;

                if($statement->execute()) {
                    $statement->store_result();

                    if($statement->num_rows == 1) {
                        $statement->bind_result($id, $userName, $hashedPassword);
                        if($statement->fetch()) {
                            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                            if(password_verify($password, $hashedPassword)) {
                                session_start();
                                $_SESSION["loggedin"] = true;
                                $_SESSION["id"] = $id;
                                $_SESSION["userName"] = $userName;
                                header("location: account.php");
                            } else {
                                $passwordError = "Password is incorrect.";
                            }
                        }
                    } else {
                        $loginError = "No account found with that username.";
                    }
                } else {
                    echo "Oops! Something went wrong. Please try again later.";
                }
                $statement->close();
            }
        }
    }


?>

<main class="container nav-space">
    <div class="row">
        <div class="col-md-3 col-1"></div>
        <div class="col-md-6 col-10 card p-4">
            <h2>Sign in</h2>
            <?php 
                if(!empty($loginError)) {
                    echo '<div class="alert alert-danger">' . $loginError . '</div>';
                }        
            ?>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

                    <div class="form-group mt-4">
                        <label>Username</label>
                        <input type="text" name="userName" class="form-control <?php echo (!empty($userNameError)) ? 'is-invalid' : ''; ?>" value="<?php echo $userName; ?>">
                        <span class="invalid-feedback"><?php echo $userNameError; ?></span>
                    </div>    
                    <div class="form-group mt-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control <?php echo (!empty($passwordError)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                        <span class="invalid-feedback"><?php echo $passwordError; ?></span>
                    </div>
                    <div class="form-group mt-4">
                        <input type="submit" class="btn btn-primary" value="Submit">
                    </div>
                    <p class="mt-1">Don't have an account? <a href="login.php">Register here</a></p>
            </form>
        </div>
        <div class="col-md-3 col-1"></div>
    </div>
</div>

<?php
include "templates/footer.php";
?>