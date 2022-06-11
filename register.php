<?php
include "config.php";
include "templates/header.php";

$userName = $password = $confirmPassword = "";
$userNameError = $passwordError = $confirmPasswordError = "";

if($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate user name
    if (empty(trim($_POST["userName"]))) {
        $userNameError = "Please enter a username.";
    } elseif (!preg_match("/^[a-zA-Z0-9]*$/", trim($_POST["userName"]))) {
        $userNameError = "Only letters and numbers are allowed.";
    } else {
        $sqlSelect = "SELECT userId FROM users WHERE userName = ?";

        if($statement = $connection->prepare($sqlSelect)) {
            $statement->bind_param("s", $param_userName);
            $param_userName = trim($_POST["userName"]);

            if($statement->execute()) {
                $statement->store_result();

                if($statement->num_rows == 1) {
                    $userNameError = "Username is already taken. Choose a new one.";
                } else {
                    $userName = trim($_POST["userName"]);
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
            $statement->close();
        }
    }
    //Validate password
    if (empty(trim($_POST["password"]))) {
        $passwordError = "Please enter a password.";
    } elseif (strlen(trim($_POST["password"])) < 5) {
        $passwordError = "Password must have atleast 5 characters.";
    } else {
        $password = trim($_POST["password"]);
    }

    //Validate confirmPassword
    if (empty(trim($_POST["confirmPassword"]))) {
        $confirmPasswordError = "Please confirm password.";
    } else {
        $confirmPassword = trim($_POST["confirmPassword"]);
        if(empty($passwordError) && ($password != $confirmPassword)) {
            $confirmPasswordError = "Passwords don't match.";
        }
    }

    //Inserting new user
    if(empty($userNameError) && empty($passwordError) && empty($confirmPasswordError)) {
        $sqlInsert = "INSERT INTO users (userName, password) VALUES (?, ?)";

        if($statement = $connection->prepare($sqlInsert)) {
            $statement->bind_param("ss", $param_userName, $param_password);

            $param_userName = $userName;
            $param_password = password_hash($password, PASSWORD_DEFAULT);

            if($statement->execute()) {
                header("location: index.php");
            } else {
                echo "Something went wrong. Please try again later.";
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
            <h2>Register</h2>
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
                    <div class="form-group mt-3">
                        <label>Confirm Password</label>
                        <input type="password" name="confirmPassword" class="form-control <?php echo (!empty($confirmPasswordError)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirmPassword; ?>">
                        <span class="invalid-feedback"><?php echo $confirmPasswordError; ?></span>
                    </div>
                    <div class="form-group mt-4">
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <input type="reset" class="btn btn-secondary ml-2" value="Reset">
                    </div>
                    <p class="mt-1">Already have an account? <a href="login.php">Sign in</a></p>
            </form>
        </div>
        <div class="col-md-3 col-1"></div>
    </div>
</div>


<?php
include "templates/footer.php";
?>