<?php
        include "templates/header.php";

        $conn = mysqli_connect('localhost', 'root', '');  
        if (! $conn) {  
            die("Connection failed" . mysqli_connect_error());  
        }  
        else {  
            mysqli_select_db($conn, 'recipeapp');  
        }       

        $limit = 4;    

        if (isset($_GET["page"])) {    
            $page_number  = $_GET["page"];    
        }    
        else {    
          $page_number=1;    
        }       

        $initial_page = ($page_number-1) * $limit;       

        $sqlSelect = "SELECT * FROM recipes LIMIT $initial_page, $limit";     
        $result = mysqli_query ($conn, $sqlSelect);    
    ?>     

    <div class="container nav-space">   
      <div>       
        <div class="row">
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
                                        <div class="d-lg-flex justify-content-between">
                                            <h3><?php echo $row["recipeId"]; ?>. <?php echo $row["recipeTitle"]; ?></h3>
                                            <p class="text-muted">Author: <?php echo $row["recipeAuthor"]; ?></p>
                                        </div>
                                        <p class="mt-3"><?php echo $row["recipeShortDescription"]; ?></p>
                                    </div>
                                    <div class="text-end">
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

        <div class="bottom-nav">
            <div>    
              <?php  
                $sqlSelect = "SELECT COUNT(*) FROM recipes";     
                $result = mysqli_query($conn, $sqlSelect);     
                $row = mysqli_fetch_row($result);     
                $total_rows = $row[0];              
                echo "</br>";            

                $total_pages = ceil($total_rows / $limit);     
                $pageURL = "";             
        
                if($page_number>=2) {   
                    echo "<a href='recipeList.php?page=".($page_number-1)."'>  Prev </a>";   
                }                          
        
                for ($i=1; $i<=$total_pages; $i++) {   
                  if ($i == $page_number) {   
                      $pageURL .= "<a class = 'active' href='recipeList.php?page=".$i."'>".$i." </a>";   
                  } else {   
                      $pageURL .= "<a href='recipeList.php?page=".$i."'>".$i." </a>";     
                  }   
                };     
                echo $pageURL;    
        
                if($page_number<$total_pages) {   
                    echo "<a href='recipeList.php?page=".($page_number+1)."'>  Next </a>";   
                }     
              ?>    
        
            </div>    
        
            <div class="d-flex">   
              <input id="page" type="number" min="1" max="<?php echo $total_pages?>"placeholder="<?php echo $page_number."/".$total_pages; ?>" required>   
              <button onClick="goToPage();">Go</button>   
            </div>    
        </div>
    </div>   
  </div>

  <script>
    function goToPage() {   
        let page = document.getElementById("page").value;   
        page = ((page><?php echo $total_pages; ?>)?<?php echo $total_pages; ?>:((page<1)?1:page));   
        window.location.href = 'recipeList.php?page='+page;   
    } 
  </script>  