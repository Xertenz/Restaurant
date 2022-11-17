<?php
include 'includes/header.php';
include 'init.php';

if($_SERVER['REQUEST_METHOD'] != 'POST') {
    header('Location: '.SITE_URL);
    exit();
}

if(isset($_POST['search'])) {
    $word = strtolower($_POST['search']);
    $stmt = $conn->prepare('SELECT * FROM food WHERE LOWER(title) LIKE ? OR description LIKE ?');
    $stmt->execute(["%$word%", "%$word%"]);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search text-center">
        <div class="container">
            
            <h2>Foods on Your Search <a href="#" class="text-white">"<?= strip_tags($_POST['search']) ?>"</a></h2>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->



    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>
            <?php

                foreach ($result as $item) {
                
            ?>

            <div class="food-menu-box">
                <div class="food-menu-img">
                    <img src="<?= SITE_URL.'admin/images/food_images/'.$item['image_name']  ?>" alt="<?= substr($item['description'], 0, 15). ' ...' ?>" class="img-responsive img-curve">
                </div>

                <div class="food-menu-desc">
                    <h4><?= $item['title'] ?></h4>
                    <p class="food-price">$<?= $item['price'] ?></p>
                    <p class="food-detail"><?= $item['description'] ?></p>
                    <br>

                    <a href="#" class="btn btn-primary">Order Now</a>
                </div>
            </div>


            

            <div class="clearfix"></div>

            

        </div>

    </section>
    <!-- fOOD Menu Section Ends Here -->

<?php
    }
}else{
    header('Location: '.SITE_URL);
    exit();
}
?>

<?php include 'includes/footer.php'; ?>