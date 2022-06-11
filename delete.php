<?php
    include "config.php";

    $id = $_GET["id"];
    $result = mysqli_query($connection, "DELETE FROM recipes WHERE recipeId = $id");

    if($result) {
        header("location: account.php");
    } else {
        echo "Error: Could not delete recipe.";
    }

?>