<?php
include 'includes/header.php';
include 'init.php';
$categories = getRecords('id, title, image_name', 'categories', 'active' , '=' , "Yes");

?>

    <!-- CAtegories Section Starts Here -->
    <section class="categories">
        <div class="container">
            <h2 class="text-center">Explore Foods</h2>
            <?php
                foreach($categories as $cat) {
            ?>
            <a href="category-foods.php?id=<?= $cat['id']?>">
            <div class="box-3 float-container">
                <img src="<?= SITE_URL.'admin/images/cat_images/'.$cat['image_name'] ?>" alt="Pizza" class="img-responsive img-curve">

                <h3 class="float-text text-white"><?= $cat['title'] ?></h3>
            </div>
            </a>
            <?php
                }
            ?>

            <div class="clearfix"></div>
        </div>
    </section>
    <!-- Categories Section Ends Here -->


<?php include 'includes/footer.php' ?>