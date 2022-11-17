<?php
include 'includes/header.php'; 
include 'init.php';
?>

    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search text-center">
        <div class="container">
            <?php
            
            $id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : '';
            if(checkItem('id', 'categories', $id)) {
                $food = getSingleRecord('title', 'categories', 'id', $id);
                $result = $food['title'];

                echo '<h2>Foods on <a href="#" class="text-white">"'.$result.'"</a></h2>';
            }else{
                /*$msg = 'No Categories With This ID';
                print_msg($msg, false);*/

                $result = 'No Categories With This ID';
                echo '<h2 class="text-white">'.$result.'</h2>';
            }

                
            ?> 

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->



    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>
            <?php
                $id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : '';
                if(checkItem('id', 'categories', $id)) {
                    $food = getRecords('*', 'food', 'category_id', '=', $id);
                    foreach($food as $food_item){

            ?>
                <div class="food-menu-box">
                    <div class="food-menu-img">
                        <img src="<?= SITE_URL."admin/images/food_images/".$food_item['image_name'] ?>" alt="Chicke Hawain Pizza" class="img-responsive img-curve">
                    </div>

                    <div class="food-menu-desc">
                        <h4><?= $food_item['title'] ?></h4>
                        <p class="food-price">$<?= $food_item['price'] ?></p>
                        <p class="food-detail"><?= $food_item['description'] ?></p>
                        <br>

                        <a href="<?= SITE_URL.'order.php' ?>" class="btn btn-primary">Order Now</a>
                    </div>
                </div>
            <?php
                    } 

                }else{
                    $msg = 'No Categories With This ID';
                    print_msg($msg, false);
                }
            ?>

            <div class="clearfix"></div>

            

        </div>

    </section>
    <!-- fOOD Menu Section Ends Here -->

<?php include 'includes/footer.php'; ?>