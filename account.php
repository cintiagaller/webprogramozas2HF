<?php
    session_start();
    
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
        header("location: login.php");
        exit;
    }

    include "config.php";
    include "templates/loggedInHeader.php";

    $recipeAuthor = $_SESSION["userName"];
    $sqlSelect = "SELECT * FROM recipes WHERE recipeAuthor = '$recipeAuthor'";
    $result = mysqli_query($connection, $sqlSelect);

?>

    <main class="container nav-space">
        <h1>Welcome back, <span><?php echo htmlspecialchars($_SESSION["userName"]); ?></span>!</h1>
        <div class="d-flex justify-content-center align-items-center">
            <h2 class="text-center">Add new recipe</h2>
            <p class="text-center my-5 mx-3">
                <a class="btn btn-primary" href="newRecipe.php">Go</a>
            </p>
        </div>
            

        <h2 class="mt-5 mb-3 text-center">Your recipes</h2>
        <div class="row mb-4">
        <?php     
            while ($row = mysqli_fetch_array($result)) {
            ?> 
                <div class="container mt-3">
                    <div class="row">
                        <div class="col-1"></div>
                        <div class="col-md-10 col-12 recipe-item">
                            <div class="row">
                                <div class="col-md-3 col-12">
                                    <img src="./assets/images/<?php echo $row["recipeImageUrl"]; ?>" alt="" class="recipe-photo">
                                </div>
                                <div class="col-md-9 col-12 d-flex flex-column justify-content-between">
                                    <div class="text">
                                        <h3><?php echo $row["recipeTitle"]; ?></h3>
                                        <p class="mt-3"><?php echo $row["recipeShortDescription"]; ?></p>
                                    </div>
                                    <div class="text-end">
                                        <a class="mt-2 btn btn-danger" href="delete.php?id=<?php echo $row['recipeId']; ?>">Delete recipe</a>
                                        <button class="mt-2 btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvas<?php echo $row["recipeId"]; ?>">See recipe</button>
                                    </div>
                                    <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvas<?php echo $row["recipeId"]; ?>">
                                        <div class="offcanvas-header">
                                            <h5 class="offcanvas-title"><?php echo $row["recipeTitle"]; ?></h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                                        </div>
                                        <div class="offcanvas-body">
                                            <?php echo $row["recipeShortDescription"]; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>   
                    </div>
                    <div class="col"></div>
                </div>
            <?php     
                };    
            ?>        
        </div>
    </main>


<?php
    include "templates/footer.php";
?>