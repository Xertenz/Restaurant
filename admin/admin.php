<?php
include './inc/config.php';
session_start();
if(!isset($_SESSION['AdminID'])) {
    header('Location: '. SITE_URL.'admin/login.php');
    exit();
}
$pageTitle = 'Admin';
include './init.php';

$actions = array('Dashboard', 'Manage', 'Add', 'Insert', 'Edit', 'Update', 'Delete');
$do = isset($_GET['do']) && in_array($_GET['do'],  $actions) ? $_GET['do'] : 'Manage';
if($do == 'Manage') {
    $result = getRecords('*', 'admin');
    $admin_id =1;
    ?>

<div class="main-content manage-admin py-12">
    <div class="container mx-auto">
        <h1 class="title text-4xl mb-6 font-bold capitalize text-center">Manage Admin</h1>
        <div class="wrapper px-6 sm:p-0 w-full sm:w-3/4 m-auto">
            <table class="table-auto w-full mb-8">
                <thead>
                <tr class="border-b-2 border-black border-solid text-left">
                    <th>id</th>
                    <th>Fullname</th>
                    <th>Username</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach($result as $row) {
                    ?>
                    <tr class="py-2">
                        <td><?= $admin_id++ ?></td>
                        <td><?= $row['fullname'] ?></td>
                        <td><?= $row['username'] ?></td>
                        <td>
                            <a href="<?= SITE_URL.'admin/admin.php?do=Edit&id='.$row['id'] ?>" class="action-update inline-block bg-blue-400 hover:bg-blue-600 transition-colors rounded px-2 py-1 text-white"> <i class="fa fa-pen-to-square"></i> Update</a>
                            <a href="<?= SITE_URL.'admin/admin.php?do=Delete&id='.$row['id'] ?>" class="action-delete inline-block bg-red-400 hover:bg-red-600 transition-colors rounded px-2 py-1 text-white" onclick="return confirm('Are You Sure ?');"> <i class="fa fa-delete-left"></i> Delete</a>
                        </td>
                    </tr>
                    <?php
                }
                ?>
                </tbody>
            </table>
            <a href="admin.php?do=Add" class="add-admin inline-block bg-blue-400 hover:bg-blue-600 transition-colors rounded px-4 py-2 text-white font-bold"><i class="fa fa-plus"></i> Add Admin</a>
        </div>
    </div>
</div>

    <?php
}elseif($do == 'Add') {
    ?>


<div class="main-content add-admin py-12">
    <div class="container mx-auto">
        <h1 class="title text-4xl mb-6 font-bold capitalize text-center">Add Admin</h1>
        <div class="wrapper">
            <form action="?do=Insert" method="POST" autocomplete="off">
                <table class="max-w-full">
                    <tbody class="flex flex-col gap-4">
                        <tr class="flex flex-col items-start">
                            <td>
                               <label for="fullname" class="cursor-pointer select-none">Fullname</label>
                            </td>
                            <td>
                                <input type="text" id="fullname" name="fullname" autocomplete="off">
                            </td>
                        </tr>
                        <tr class="flex flex-col items-start">
                            <td>
                               <label for="username" class="cursor-pointer select-none">Username</label>
                            </td>
                            <td>
                                <input type="text" id="username" name="username" autocomplete="off">
                            </tdass=>
                        </tr>
                        <tr class="flex flex-col items-start">
                            <td>
                               <label for="password" class="cursor-pointer select-none">Password</label>
                            </td>
                            <td>
                                <input type="password" id="password" name="password" autocomplete="off">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <button class="action-add-admin mt-5 inline-block bg-blue-400 hover:bg-blue-600 transition-colors rounded px-2 py-1 text-white" name='add' value="admin"><i class="fa fa-plus"></i> Add Admin</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </form>
            <a href="?do=Manage" class="back-to-manage-admin mt-5 inline-block bg-yellow-400 hover:bg-yellow-600 transition-colors rounded px-2 py-1 text-white"> <i class="fa fa-chevron-left"></i> Back To Manage</a>
        </div> 
    </div>
</div>


    <?php

}elseif($do == 'Insert') {
    if(isset($_POST['add']) && $_POST['add'] == 'admin') {
        $fullname = $_POST['fullname'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $errors = array();

        if (empty($fullname)) {
            $errors[] = 'Fullname is required';
        }
        if (empty($username)) {
            $errors[] = 'Username is required';
        }
        if (empty($password)) {
            $errors[] = 'Password is required';
        }
        
        if (empty($errors)) {
            if(checkItem('username', 'admin', $username)) {
                $msg = 'Username Already Exist';
                print_msg($msg, false);
            }else{
                $hashed_password = md5($password);
                $stmt = $conn->prepare('INSERT INTO admin (fullname, username, password) VALUES (?, ?, ?)');
                $stmt->execute(array($fullname, $username, $hashed_password));
                // header('Location: '. SITE_URL.'admin/admin.php?do=Manage');
                $msg = 'Admin Added Successfully';
                print_msg($msg, true);
            }
        }{
            print_msg($errors, false);
        }
    }
}elseif($do == 'Edit') {
    
    $id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : '';
    if($id) {
        if(checkItem('id', 'admin', $id)){
            $admin_info = getSingleRecord('*', 'admin', 'id', $id);
           ?>
           
<div class="main-content add-admin update-admin py-12">
    <div class="container mx-auto">
        <h1 class="title text-4xl mb-6 font-bold capitalize text-center">Update Admin</h1>
        <div class="wrapper">
            <form action="admin.php?do=Update&id=<?=$admin_info['id'] ?>" method="POST" autocomplete="off">
                <table class="max-w-full">
                    <tbody class="flex flex-col gap-2">
                        <tr class="flex flex-col items-start">
                            <td>
                               <label for="fullname" class="cursor-pointer select-none">Fullname</label>
                               </td>
                            <td>
                                <input type="text" id="fullname" name="fullname" value="<?= $admin_info['fullname'] ?>" autocomplete="off" required>
                            </td>
                        </tr>
                        <tr class="flex flex-col items-start">
                            <td>
                               <label for="username" class="cursor-pointer select-none">Username</label>
                            </td>
                            <td>
                                <input type="text" id="username" name="username" value="<?= $admin_info['username'] ?>" autocomplete="off" required>
                            </td>
                        </tr>
                        <tr class="flex flex-col items-start">
                            <td>
                               <label for="password" class="cursor-pointer select-none">Password</label>
                            </td>
                            <td>
                                <input type="password" name="password" id="password" autocomplete="off">
                                <input type="hidden" name="old-password" autocomplete="off" value="<?= $admin_info['password'] ?>">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <button class="action-add-admin action-update-admin mt-5 inline-block bg-blue-400 hover:bg-blue-600 transition-colors rounded px-2 py-1 text-white" name='update' value="admin"><i class="fa fa-pen-to-square"></i> Update Admin</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </form>
            <a href="?do=Manage" class="back-to-manage-admin mt-5 inline-block bg-yellow-400 hover:bg-yellow-600 transition-colors rounded px-2 py-1 text-white"> <i class="fa fa-chevron-left"></i> Back To Manage</a>
        </div> 
    </div>
</div>
           <?php
        }else{
            $msg = 'No Admin With This Id';
            print_msg($msg, false);
        }

    }else{
        $msg = 'No Admin With This Id';
        print_msg($msg, false);
    }

}elseif($do == 'Update') {
    $id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : '';
    if($id) {
        $stmt = $conn->prepare('SELECT * FROM admin WHERE id = ?');
        $stmt->execute([$id]);
        $count = $stmt->rowCount();

        if($count){
            $fullname = $_POST['fullname'];
            $username = $_POST['username'];
            $password = $_POST['password'];
            $old_password = $_POST['old-password'];
            $hashed_password = !empty($password) ? md5($password) : $old_password;

            $errors = array();
            if (empty($fullname)) {
                $errors[] = 'Fullname is required';
            }
            if (empty($username)) {
                $errors[] = 'Username is required';
            }

            if (empty($errors)) {
                if(checkItem('username', 'admin', $username)) {
                    $msg = 'Username Already Exist';
                    print_msg($msg, false);
                }else{
                    $stmt = $conn->prepare('UPDATE admin SET fullname = ?, username = ?, password = ? WHERE id = ?');
                    $stmt->execute(array($fullname, $username, $hashed_password, $id));
                    // header('Location: '. SITE_URL.'admin/admin.php?do=Manage');
                    $msg = 'Admin Updated Successfully';
                    print_msg($msg, true);
                }
            }{
                print_msg($errors, false);
            }


        }else{
            $msg = 'No Admin With This Id';
            print_msg($msg, false);
    }
    }else{
        $msg = 'No Admin With This Id';
        print_msg($msg, false);
    }
}elseif($do == 'Delete') {
    $id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : '';
    if($id) {
        if(checkItem('id', 'admin', $id)){
            $stmt = $conn->prepare('DELETE FROM admin WHERE id = ?');
            $stmt->execute(array($id));
            // header('Location: '. SITE_URL.'admin/admin.php?do=Manage');
            $msg = 'Admin Deleted Successfully';
            print_msg($msg, true);
        }else{
            $msg = 'No Admin With This Id';
            print_msg($msg, false);
        }
    }else{
        $msg = 'No Admin With This Id';
        print_msg($msg, false);
    }
}


include './inc/footer.php';

?>