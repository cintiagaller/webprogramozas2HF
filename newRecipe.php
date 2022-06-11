<?php
    session_start();
    
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
        header("location: login.php");
        exit;
    }

    include "config.php";
    include "templates/loggedInHeader.php";
    $recipeAuthor = $_SESSION["userName"];

    if (isset($_POST["submit"])) {
        $recipeTitle = mysqli_real_escape_string($connection, $_POST["recipeTitle"]);
        $recipeShortDescription = mysqli_real_escape_string($connection, $_POST["recipeShortDescription"]);
        $recipePrepTimeMinutes = $_POST["recipePrepTimeMinutes"];
        $recipeServings = $_POST["recipeServings"];
        
        if(!empty($recipeTitle) && !empty($recipeShortDescription) && !empty($recipePrepTimeMinutes) && !empty($recipeServings) && !empty($_FILES["recipeImage"]["name"])) {
            $recipeImageError = $_FILES["recipeImage"]["error"];
            $recipeImageType = $_FILES["recipeImage"]["type"];
            $recipeImageSize = $_FILES["recipeImage"]["size"];

            if ($recipeImageError == 0 && $recipeImageSize > 0 && $recipeImageSize <= $MAXFS && ($recipeImageType == "image/jpeg" || $recipeImageType == "image/png")) {
                $tempFolder = $_FILES["recipeImage"]["tmp_name"];
                $recipeImage = time().$_FILES["recipeImage"]["name"];
                $target = $PATH.$recipeImage;

                if (move_uploaded_file($tempFolder, $target)) {
                    $sqlInsert = "INSERT INTO recipes (recipeTitle, recipeShortDescription, recipePrepTimeMinutes, recipeServings, recipeImageUrl, recipeAuthor) VALUES ('$recipeTitle', '$recipeShortDescription', '$recipePrepTimeMinutes', '$recipeServings', '$recipeImage', '$recipeAuthor')";
                    mysqli_query($connection, $sqlInsert) or die("Error!!");
                    header("location: account.php");
                } else {
                    echo "Error uploading image!";
                }
            } else {
                echo "Only jpeg and png images are allowed!";
            }
        } else {
            echo "Please fill in all fields!";
        }
    }

?>

    <main class="container nav-space">
        <div class="row">
            <div class="col-1"></div>
            <div class="col-10">
                <div class="container recipe-item">
                    <h1 class="text-center mt-2 mb-3">Add new recipe</h1>
                    <div class="row">
                        <div class="col-1"></div>
                        <div class="col-10">
                            <form method = "post" action = "<?php echo $_SERVER['PHP_SELF']; ?>" enctype = "multipart/form-data">
                                <div class="form-group mb-3">
                                    <label for="recipeTitle">Recipe title</label>
                                    <input type="text" class="form-control" id="recipeTitle" name="recipeTitle">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="recipeShortDescription">Description</label>
                                    <textarea class="form-control" id="recipeShortDescription" name="recipeShortDescription" rows="3"></textarea>
                                </div>
                                <div class="row mb-3 d-flex align-items-center">
                                    <div class="col-md-6 col-12 form-group">
                                        <label for="recipeImage">Image</label>
                                        <input type="file" class="form-control-file" id="recipeImage" name="recipeImage">
                                    </div>
                                    <div class="col-md-3 col-12 form-group">
                                        <label for="recipePrepTimeMinutes">Preptime</label>
                                        <input type="number" class="form-control" id="recipePrepTimeMinutes" name="recipePrepTimeMinutes">
                                    </div>
                                    <div class="col-md-3 col-12 form-group">
                                        <label for="recipeServings">Servings</label>
                                        <input type="number" class="form-control" id="recipeServings" name="recipeServings">
                                    </div>
                                    <div class="form-group mt-2">
                                        <button class="btn btn-secondary" type="submit" name="submit">Add</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-1"></div>
                    </div>
                </div>
            </div>
            <div class="col-1"></div>
        </div>
    </main>


<?php
    include "templates/footer.php";
?>