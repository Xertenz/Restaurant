<?php

include './inc/config.php';
session_start();
if(!isset($_SESSION['AdminID'])) {
    header('Location: '. SITE_URL.'admin/login.php');
    exit();
}

$pageTitle = 'Admin Dashboard';
include './init.php';

?>

<div class="main-content dashboard py-12">
    <div class="container mx-auto">
        <h1 class="title text-4xl mb-6 font-bold capitalize text-center">dashboard</h1>
        <div class="stats grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-2 sm:gap-8">
            <div class="stat border-brack border-2 border-solid text-center rounded-md py-4 bg-red-400">
                <a href="<?php echo SITE_URL.'admin/admin.php?do=Manage'; ?>" class="stat-num block text-3xl"><?= count_items_in_table('admin') ?></a>
                <span class="stat-name block text-lg text-white">Admins</span>
            </div>
            <div class="stat border-brack border-2 border-solid text-center rounded-md py-4 bg-orange-400">
                <a href="<?php echo SITE_URL.'admin/category.php?do=Manage'; ?>" class="stat-num block text-3xl"><?= count_items_in_table('categories'); ?></a>
                <span class="stat-name block text-lg text-white">Category</span>
            </div>
            <div class="stat border-brack border-2 border-solid text-center rounded-md py-4 bg-emerald-500">
                <a href="<?php echo SITE_URL.'admin/food.php?do=Manage'; ?>" class="stat-num block text-3xl"><?= count_items_in_table('food'); ?></a>
                <span class="stat-name block text-lg text-white">Food</span>
            </div>
            <div class="stat border-brack border-2 border-solid text-center rounded-md py-4 bg-lime-500">
                <a href="#" class="stat-num block text-3xl">33</a>
                <span class="stat-name block text-lg text-white">Order</span>
            </div>
        </div>
    </div>
</div>


<?php include "./inc/footer.php" ?>