<?php

include './inc/config.php';
session_start();
if(!isset($_SESSION['AdminID'])) {
    header('Location: '. SITE_URL.'admin/login.php');
    exit();
}
$pageTitle = 'Order';
include './init.php';

?>

<div class="main-content py-12">
    <div class="container mx-auto">
        <h1 class="title text-4xl mb-6 font-bold capitalize text-center">Manage Orders</h1>
    </div>
</div>


<?php include "./inc/footer.php" ?>