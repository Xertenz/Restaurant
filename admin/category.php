<?php
include './inc/config.php';
session_start();
if(!isset($_SESSION['AdminID'])) {
    header('Location: '. SITE_URL.'admin/login.php');
    exit();
}
$pageTitle = 'Category';
include './init.php';

$actions = array('Dashboard', 'Manage', 'Add', 'Insert', 'Edit', 'Update', 'Delete');
$do = isset($_GET['do']) && in_array($_GET['do'],  $actions) ? $_GET['do'] : 'Manage';

if($do == 'Manage'){
   $result = getRecords('*', 'categories');
    $cat_id =1;
    ?>
<div class="main-content manage-admin py-12">
    <div class="container mx-auto">
        <h1 class="title text-4xl mb-6 font-bold capitalize text-center">manage category</h1>
        <div class="wrapper px-6 sm:p-0 w-full sm:w-3/4 m-auto">
            <table class="table-auto w-full mb-8">
                <thead>
                <tr class="border-b-2 border-black border-solid text-left">
                    <th>id</th>
                    <th>Title</th>
                    <th>Image</th>
                    <th>Featured</th>
                    <th>Active</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach($result as $row) {
                    ?>
                    <tr class="py-2">
                        <td><?= $cat_id++ ?></td>
                        <td><?= $row['title'] ?></td>
                        <td>
                            <img src="<?= SITE_URL.'admin/images/cat_images/'. $row['image_name'] ?>" alt="Image Not Added" class="cat_image h-9" /></td>
                        <td><?= $row['featured'] ?></td>
                        <td><?= $row['active'] ?></td>
                        <td>
                            <a href="<?= SITE_URL.'admin/category.php?do=Edit&id='.$row['id'] ?>" class="action-update inline-block bg-blue-400 hover:bg-blue-600 transition-colors rounded px-2 py-1 text-white"><i class="fa fa-pen-to-square"></i> Update</a>
                            <a href="<?= SITE_URL.'admin/category.php?do=Delete&id='.$row['id'] ?>" class="action-delete inline-block bg-red-400 hover:bg-red-600 transition-colors rounded px-2 py-1 text-white" onclick="return confirm('Are You Sure ?');"><i class="fa fa-delete-left"></i> Delete</a>
                        </td>
                    </tr>
                    <?php
                }
                ?>
                </tbody>
            </table>
            <a href="category.php?do=Add" class="add-admin inline-block bg-blue-400 hover:bg-blue-600 transition-colors rounded px-4 py-2 text-white font-bold capitalize"><i class="fa fa-plus"></i> add category</a>
        </div>
    </div>
</div>
    <?php
}elseif($do == 'Add') {
    ?>


<div class="main-content add-admin add-category py-12">
    <div class="container mx-auto">
        <h1 class="title text-4xl mb-6 font-bold capitalize text-center">add category</h1>
        <div class="wrapper">
            <form action="?do=Insert" method="POST" autocomplete="off" enctype="multipart/form-data">
                <table class="max-w-full">
                    <tbody class="flex flex-col gap-2">
                        <tr class="flex justify-between items-center gap-6">
                            <td>Title</td>
                            <td>
                                <input type="text" name="cat_title" class="w-[300px]" autocomplete="off">
                            </td>
                        </tr>
                        <tr class="flex justify-between items-center gap-6">
                            <td>Select Image</td>
                            <td>
                                <input type="file" name="cat_image" class="w-[300px]" autocomplete="off">
                            </td>
                        </tr>
                        <tr class="flex justify-between items-center gap-6">
                            <td>Featured</td>
                            <td class="w-[300px] flex justify-start gap-8">
                                <div class="item item-1 flex items-center gap-2">
                                    <input type="radio" id="featured_yes" name="cat_featured" value="Yes" autocomplete="off">
                                    <label for="featured_yes">Yes</label>
                                </div>
                                <div class="item item-2 flex items-center gap-2">
                                    <input type="radio" id="featured_no" name="cat_featured" value="No" checked autocomplete="off">
                                    <label for="featured_no">No</label>
                                </div>
                            </td>
                        </tr>
                        <tr class="flex justify-between items-center gap-6">
                            <td>Active</td>
                            <td class="w-[300px] flex justify-start gap-8">
                                <div class="item item-1 flex items-center gap-2">
                                    <input type="radio" id="active_yes" name="cat_active" value="Yes" autocomplete="off">
                                    <label for="active_yes">Yes</label>
                                </div>
                                <div class="item item-2 flex items-center gap-2">
                                    <input type="radio" id="active_no" name="cat_active" value="No" checked autocomplete="off">
                                    <label for="active_no">No</label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <button class="action-add-cat mt-5 inline-block bg-blue-400 hover:bg-blue-600 transition-colors rounded px-2 py-1 text-white capitalize" name='add' value="category"><i class="fa fa-plus"></i> add Category</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </form>
            <a href="?do=Manage" class="back-to-manage-category mt-5 inline-block bg-yellow-400 hover:bg-yellow-600 transition-colors rounded px-2 py-1 text-white"><i class="fa fa-chevron-left"></i> Back To Manage</a>
        </div> 
    </div>
</div>


    <?php
}elseif($do == 'Insert') {
    if(isset($_POST['add']) && $_POST['add'] == 'category') {
        $cat_title    = $_POST['cat_title'];
        $cat_featured = $_POST['cat_featured'];
        $cat_active   = $_POST['cat_active'];
        $cat_image    = $_FILES['cat_image'];
        $errors = array();

        if (empty($cat_title)) {
            $errors[] = 'Category title is required';
        }
        if ($cat_image['name'] != '') {
            $allowed_exts = array('jpg', 'jpeg', 'png', 'gif');
            $file_ext = strtolower(pathinfo($cat_image['name'], PATHINFO_EXTENSION));
            if(!in_array($file_ext, $allowed_exts)){
                $errors[] = 'Not allowed file type';
            }else{
                $newFileName = time().'-'.$_SESSION['AdminID'].'-'.$cat_image['name'];
            }
        }
        if (empty($cat_featured)) {
            $errors[] = 'Category featured is required';
        }
        if (empty($cat_active)) {
            $errors[] = 'Category active is required';
        }
        
        if (empty($errors)) {
            if(checkItem('title', 'categories', $cat_title)) {
                $msg = 'Category Already Exist';
                print_msg($msg, false);
            }else{
                if(isset($newFileName)) {
                    $sql = 'INSERT INTO categories (title, image_name, featured, active) VALUES (?, ?, ?, ?)';
                    $stmt = $conn->prepare($sql);
                    $stmt->execute(array($cat_title, $newFileName, $cat_featured, $cat_active));
                    move_uploaded_file($cat_image['tmp_name'], './images/cat_images/'.$newFileName);
                    // header('Location: '. SITE_URL.'admin/admin.php?do=Manage');
                }else{
                    $sql = 'INSERT INTO categories (title, featured, active) VALUES (?, ?, ?)';
                    $stmt = $conn->prepare($sql);
                    $stmt->execute(array($cat_title, $cat_featured, $cat_active));
                    // header('Location: '. SITE_URL.'admin/admin.php?do=Manage');

                }
                $msg = 'Category Added Successfully';
                print_msg($msg, true);
            }
        }{
            print_msg($errors, false);
        }
    }
}elseif($do == 'Edit') {

    $id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : '';
    if($id) {
        if(checkItem('id', 'categories', $id)){
            $cat_info = getSingleRecord('*', 'categories', 'id', $id);

    ?>
<div class="main-content add-admin edit-category py-12">
    <div class="container mx-auto">
        <h1 class="title text-4xl mb-6 font-bold capitalize text-center">edit category</h1>
        <div class="wrapper">
            <form action="category.php?do=Update&id=<?= $cat_info['id'] ?>" method="POST" autocomplete="off" enctype="multipart/form-data">
                <table class="max-w-full">
                    <tbody class="flex flex-col gap-2">
                        <tr class="flex justify-between items-center gap-6">
                            <td>Title</td>
                            <td>
                                <input type="text" name="cat_title" value="<?= $cat_info['title'] ?>" class="w-[300px]" autocomplete="off">
                            </td>
                        </tr>
                        <tr class="flex justify-between items-center gap-6">
                            <td>Select Image</td>
                            <td>
                                <input type="file" name="cat_image" class="w-[300px]" autocomplete="off">
                            </td>
                        </tr>
                        <tr class="flex justify-between items-center gap-6">
                            <td>Featured</td>
                            <td class="w-[300px] flex justify-start gap-8">
                                <div class="item item-1 flex items-center gap-2">
                                    <input type="radio" id="featured_yes" name="cat_featured" value="Yes" <?= $cat_info['featured'] == 'Yes' ?  'checked' : '' ?> autocomplete="off">
                                    <label for="featured_yes">Yes</label>
                                </div>
                                <div class="item item-2 flex items-center gap-2">
                                    <input type="radio" id="featured_no" name="cat_featured" value="No" <?= $cat_info['featured'] == 'No' ? 'checked' : '' ?> autocomplete="off">
                                    <label for="featured_no">No</label>
                                </div>
                            </td>
                        </tr>
                        <tr class="flex justify-between items-center gap-6">
                            <td>Active</td>
                            <td class="w-[300px] flex justify-start gap-8">
                                <div class="item item-1 flex items-center gap-2">
                                    <input type="radio" id="active_yes" name="cat_active" value="Yes" <?= $cat_info['active'] == 'Yes' ? 'checked' : '' ?> autocomplete="off">
                                    <label for="active_yes">Yes</label>
                                </div>
                                <div class="item item-2 flex items-center gap-2">
                                    <input type="radio" id="active_no" name="cat_active" value="No" <?= $cat_info['active'] == 'No' ? 'checked' : '' ?> autocomplete="off">
                                    <label for="active_no">No</label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <button class="action-add-admin mt-5 inline-block bg-blue-400 hover:bg-blue-600 transition-colors rounded px-2 py-1 text-white capitalize" name='add' value="category"><i class="fa fa-pen-to-square"></i> update Category</button>
                            </td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </form>
            <a href="?do=Manage" class="back-to-manage-category mt-5 inline-block bg-yellow-400 hover:bg-yellow-600 transition-colors rounded px-2 py-1 text-white"><i class="fa fa-chevron-left"></i> Back To Manage</a>
        </div> 
    </div>
</div>
    <?php
        }else{
            $msg = 'No Category With This Id';
            print_msg($msg, false);
        }

    }else{
        $msg = 'No Admin With This Id';
        print_msg($msg, false);
    }
}elseif($do == 'Update'){
    $id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : '';
    if($id) {
        if(checkItem('id', 'categories', $id)){
            $cat_title    = $_POST['cat_title'];
            $cat_featured = isset($_POST['cat_featured']) ? $_POST['cat_featured']: 'No';
            $cat_active   = isset($_POST['cat_active']) ? $_POST['cat_active'] : 'No';
            $cat_image    = $_FILES['cat_image'];
            $errors = array();

            if (empty($cat_title)) {
                $errors[] = 'Category title is required';
            }
            if ($cat_image['name'] != '') {
                $allowed_exts = array('jpg', 'jpeg', 'png', 'gif');
                $file_ext = strtolower(pathinfo($cat_image['name'], PATHINFO_EXTENSION));
                if(!in_array($file_ext, $allowed_exts)){
                    $errors[] = 'Not allowed file type';
                }else{
                    $newFileName = time().'-'.$_SESSION['AdminID'].'-'.$cat_image['name'];
                }
            }

            if (empty($errors)) {

                $condition = "id != $id AND title = '".$cat_title."'";
                if(checkOtherItems('*', 'categories', $condition)) {
                    $msg = 'Category Already Exist';
                    print_msg($msg, false);
                }else{
                    if(isset($newFileName)) {
                        // Deleteing Old Category Image
                        $cat_img_name = getSingleRecord('image_name', 'categories', 'id', $id);
                        $cat_img_path = SITE_PATH.'admin/images/cat_images/'.$cat_img_name['image_name'];
                        if(file_exists($cat_img_path) && is_file($cat_img_path)){
                            unlink($cat_img_path);
                        }

                        $sql = 'UPDATE categories SET title = ?, image_name = ?, featured = ?, active = ? WHERE id = ?';
                        $stmt = $conn->prepare($sql);
                        $stmt->execute(array($cat_title, $newFileName, $cat_featured, $cat_active, $id));
                        move_uploaded_file($cat_image['tmp_name'], './images/cat_images/'.$newFileName);

                    }else{
                        $sql = 'UPDATE categories SET title = ?, featured = ?, active = ? WHERE id = ?';
                        $stmt = $conn->prepare($sql);
                        $stmt->execute(array($cat_title, $cat_featured, $cat_active, $id));
                    }
                    // header('Location: '. SITE_URL.'admin/admin.php?do=Manage');
                    $msg = 'Category Updated Successfully';
                    print_msg($msg, true);
                }
            }{
                print_msg($errors, false);
            }
        }else{
            $msg = 'No Category With This Id';
            print_msg($msg, false);
    }
    }else{
        $msg = 'No Category With This Id';
        print_msg($msg, false);
    }
}elseif($do == 'Delete') {
    $id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : '';
    if($id) {
        if(checkItem('id', 'categories', $id)){
            // Deleteing Category Image
            $cat_img_name = getSingleRecord('image_name', 'categories', 'id', $id);
            $cat_img_path = SITE_PATH.'admin/images/cat_images/'.$cat_img_name['image_name'];
            if(file_exists($cat_img_path) && is_file($cat_img_path)){
                unlink($cat_img_path);
            }
            $sql = 'DELETE FROM categories WHERE id = ?';
            $stmt = $conn->prepare($sql);
            $stmt->execute(array($id));

            $msg = 'Category Deleted Successfully';
            print_msg($msg, true);
        }else{
            $msg = 'No Category With This Id';
            print_msg($msg, false);
        }
    }else{
        $msg = 'No Category With This Id';
        print_msg($msg, false);
    }
}


include './inc/footer.php';

?>