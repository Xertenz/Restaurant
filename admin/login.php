<?php

include './inc/config.php';
session_start();
if(isset($_SESSION['AdminID'])) {
    header('Location: '. SITE_URL.'admin/index.php');
    exit();
}

$pageTitle = 'Admin Login';
$noNavbar = '';
include "../database/connect.php";
include './inc/functions.php';
include "./inc/header.php";

if(isset($_POST['action']) && $_POST['action'] == 'login') {
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $stmt = $conn->prepare('SELECT id, username, password FROM admin WHERE username = ? AND password = ?');
    $stmt->execute(array($username, $password));
    if($stmt->rowCount() != 0) {
        $admin_info = $stmt->fetch(PDO::FETCH_ASSOC);
        $_SESSION['AdminID'] = $admin_info['id'];
        $_SESSION['AdminUserName'] = $admin_info['username'];
        header('Location: '.SITE_URL.'admin/index.php');
    }
}

?>

<section class="admin-login">
    <div class="wrapper border-stone-300 border-solid border-2 rounded w-[353px] max-w-full mx-auto p-5">
        <h2 class="title bg-stone-200 text-center capitalize text-2xl py-3 mb-10">admin login</h2>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" autocomplete="off">
            <div class="form-group flex flex-col gap-2 mb-7">
                <label for="username" class="form-label block">Username</label>
                <input type="text" name="username" id="username" class="focus:outline-none" autocomplete="off" placeholder="Username">
            </div> 
            <div class="form-group flex flex-col gap-2 mb-6">
                <label for="password" class="form-label block">Password</label>
                <input type="password" name="password" id="password" class="focus:outline-none" autocomplete="off" placeholder="Password">
            </div> 
            <div class="form-group">
                <button class="admin-login mt-5 inline-block bg-blue-400 hover:bg-blue-800 transition-colors rounded px-3 py-1 text-white" name="action" value="login">Login</button>
            </div>
        </form>
    </div>
</section>


<?php include './inc/footer.php'; ?>