<?php
    include "templates/header.php";
    include "config.php";

    $sqlSelect = "SELECT * FROM recipes LIMIT 3";
    $result = mysqli_query($connection, $sqlSelect);
?>

<main class="container">
    <div class="row">
        <div class="col mb-5">
            <h1 class="nav-space text-center text-capitalize home-heading">Our favourite recipes</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-9 col-12">
            <?php 
            $row1 = mysqli_fetch_array($result);
            ?>
            <img class="recipe-photo" src="./assets/images/<?php echo $row1["recipeImageUrl"]; ?>">
            <h2><?php echo $row1["recipeTitle"]; ?></h2>
            <p><?php echo $row1["recipeShortDescription"]; ?></p>
        </div>
        <div class="col-lg-3 col-12 container-fluid d-lg-flex flex-lg-column justify-content-between">
            <div class="col">
                <?php 
                    $row2 = mysqli_fetch_array($result);
                ?>
                <img class="recipe-photo" src="./assets/images/<?php echo $row2["recipeImageUrl"]; ?>">
                <h2><?php echo $row2["recipeTitle"]; ?></h2>
            </div>

            <div class="col">
                <?php 
                    $row3 = mysqli_fetch_array($result);
                ?>
                <img class="recipe-photo" src="./assets/images/<?php echo $row3["recipeImageUrl"]; ?>">
                <h2><?php echo $row3["recipeTitle"]; ?></h2>
            </div>
        </div>
    </div>
    <div class="row">
        <h2 class="mt-5 title-negative-margin">All recipes</h2>
    </div>
    <div>
        <?php
            include "recipeList.php";
        ?>
    </div>

    
</main>

<?php
include "templates/footer.php";
?>