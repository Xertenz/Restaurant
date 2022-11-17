<?php
include './inc/config.php';
session_start();
if(!isset($_SESSION['AdminID'])) {
    header('Location: '. SITE_URL.'admin/login.php');
    exit();
}
$pageTitle = 'Food';
include './init.php';

$actions = array('Dashboard', 'Manage', 'Add', 'Insert', 'Edit', 'Update', 'Delete');
$do = isset($_GET['do']) && in_array($_GET['do'],  $actions) ? $_GET['do'] : 'Manage';
if($do == 'Manage'){
   $result = getRecords('*', 'food');
    $food_id =1;
    ?>
<div class="main-content manage-admin py-12">
    <div class="container mx-auto">
        <h1 class="title text-4xl mb-6 font-bold capitalize text-center">manage foods</h1>
        <div class="wrapper px-6 sm:p-0 w-full sm:w-3/4 m-auto">
            <table class="table-auto w-full mb-8">
                <thead>
                <tr class="border-b-2 border-black border-solid text-left">
                    <th>id</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Image</th>
                    <th>Category</th>
                    <th>Featured</th>
                    <th>Active</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach($result as $row) {
                    $cat_id = $row['category_id'];
                    $cat_name = getSingleRecord('title', 'categories', 'id', $cat_id);
                    ?>
                    <tr class="py-2">
                        <td><?= $food_id++ ?></td>
                        <td><?= $row['title'] ?></td>
                        <td><?= substr($row['description'], 0, 18). '...' ?></td>
                        <td><?= $row['price'] ?></td>
                        <td><img src="<?= SITE_URL.'admin/images/food_images/'. $row['image_name'] ?>" alt="Image Not Added" class="cat_image h-9" /></td>
                        <td><?= $cat_name['title'] ?></td>
                        <td><?= $row['featured'] ?></td>
                        <td><?= $row['active'] ?></td>
                        <td>
                            <a href="<?= SITE_URL.'admin/food.php?do=Edit&id='.$row['id'] ?>" class="action-update inline-block bg-blue-400 hover:bg-blue-600 transition-colors rounded px-2 py-1 text-white"><i class="fa fa-pen-to-square"></i> Update</a>
                            <a href="<?= SITE_URL.'admin/food.php?do=Delete&id='.$row['id'] ?>" class="action-delete inline-block bg-red-400 hover:bg-red-600 transition-colors rounded px-2 py-1 text-white" onclick="return confirm('Are You Sure ?');"><i class="fa fa-delete-left"></i> Delete</a>
                        </td>
                    </tr>
                    <?php
                }
                ?>
                </tbody>
            </table>
            <a href="food.php?do=Add" class="add-admin inline-block bg-blue-400 hover:bg-blue-600 transition-colors rounded px-4 py-2 text-white font-bold capitalize"><i class="fa fa-plus"></i> add food</a>
        </div>
    </div>
</div>
    <?php
}elseif($do == 'Add') {
    $cats = getRecords('id, title', 'categories', 'active', '=', "Yes");
?>
<div class="main-content add-admin add-food py-12">
    <div class="container mx-auto">
        <h1 class="title text-4xl mb-6 font-bold capitalize text-center">add Food</h1>
        <div class="wrapper">
            <form action="?do=Insert" method="POST" autocomplete="off" enctype="multipart/form-data">
                <table class="max-w-full">
                    <tbody class="flex flex-col gap-4">
                        <tr class="flex justify-between items-center gap-6">
                            <td>Title</td>
                            <td>
                                <input type="text" name="food_title" class="w-[300px]" autocomplete="off">
                            </td>
                        </tr>
                        <tr class="flex justify-between items-center gap-6">
                            <td>Description</td>
                            <td class="w-[300px] flex justify-start gap-8">
                                <textarea name="food_description" id="food_description" cols="30" rows="5"></textarea>
                            </td>
                        </tr>
                        <tr class="flex justify-between items-center gap-6">
                            <td>Price ($)</td>
                            <td class="w-[300px] flex justify-start gap-8">
                                <input type="number" name="food_price" step="0.01" id="food_price">
                            </td>
                        </tr>
                        <tr class="flex justify-between items-center gap-6">
                            <td>Select Image</td>
                            <td>
                                <input type="file" name="food_image" class="w-[300px]" autocomplete="off">
                            </td>
                        </tr>
                        <tr class="flex justify-start items-center gap-6">
                            <td>Category</td>
                            <td>
                                <select name="food_category" id="food_category" class="p-1 outline-none">
                                    <?php
                                    foreach($cats as $cat) {
                                        echo "<option value='".$cat['id']."'>".$cat['title']."</option>";
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr class="flex justify-between items-center gap-6">
                            <td>Featured</td>
                            <td class="w-[300px] flex justify-start gap-8">
                                <div class="item item-1 flex items-center gap-2">
                                    <input type="radio" id="featured_yes" name="food_featured" value="Yes" autocomplete="off">
                                    <label for="featured_yes">Yes</label>
                                </div>
                                <div class="item item-2 flex items-center gap-2">
                                    <input type="radio" id="featured_no" name="food_featured" value="No" checked autocomplete="off">
                                    <label for="featured_no">No</label>
                                </div>
                            </td>
                        </tr>
                        <tr class="flex justify-between items-center gap-6">
                            <td>Active</td>
                            <td class="w-[300px] flex justify-start gap-8">
                                <div class="item item-1 flex items-center gap-2">
                                    <input type="radio" id="active_yes" name="food_active" value="Yes" autocomplete="off">
                                    <label for="active_yes">Yes</label>
                                </div>
                                <div class="item item-2 flex items-center gap-2">
                                    <input type="radio" id="active_no" name="food_active" value="No" checked autocomplete="off">
                                    <label for="active_no">No</label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <button class="action-add-food mt-5 inline-block bg-blue-400 hover:bg-blue-600 transition-colors rounded px-2 py-1 text-white" name='add' value="food"><i class="fa fa-plus"></i> Add Food</button>
                            </td>
                            <td></td>
                        </trclass=>
                    </tbody>
                </table>
            </form>
            <a href="?do=Manage" class="back-to-manage-food mt-5 inline-block bg-yellow-400 hover:bg-yellow-600 transition-colors rounded px-2 py-1 text-white"><i class="fa fa-chevron-left"></i> Back To Manage</a>
        </div> 
    </div>
</div>

<?php
}elseif($do == 'Insert') {
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $title = $_POST['food_title'];
        $desc  = $_POST['food_description'];
        $price = $_POST['food_price'];
        $food_image = $_FILES['food_image'];
        $cat_id = $_POST['food_category'];
        $featured = isset($_POST['food_featured']) ? $_POST['food_featured'] : 'No';
        $active = isset($_POST['food_active']) ? $_POST['food_active'] : 'No';

        //var_dump($_POST);
        //die;
        $errors = [];
        if(empty($title)) {
            $errors[] = 'Food title is required';
        }
        if(empty($price)) {
            $errors[] = 'Food price is required';
        }
        if($food_image['name'] != '') {
            $allowed_exts = array('jpg', 'jpeg', 'png', 'gif');
            $file_ext = strtolower(pathinfo($food_image['name'], PATHINFO_EXTENSION));
            if(!in_array($file_ext, $allowed_exts)){
                $errors[] = 'Not allowed file type';
            }else{
                $newFileName = time().'-'.$_SESSION['AdminID'].'-'.$food_image['name'];
            }
        }
        if(empty($cat_id)) {
            $errors[] = 'Category is required';
        }

        if(empty($errors)) {
            if(checkItem('title', 'food', $title)) {
                $msg = 'Category Already Exist';
                print_msg($msg, false);
            }else{
                if(isset($newFileName)) {
                    $sql = 'INSERT INTO food (title, description, price, image_name, category_id, featured, active) VALUES (?, ?, ?, ?, ?, ?, ?)';
                    $stmt = $conn->prepare($sql);
                    $stmt->execute([$title, $desc, $price, $newFileName, $cat_id, $featured, $active]);

                    move_uploaded_file($food_image['tmp_name'], SITE_PATH.'admin/images/food_images/'.$newFileName);
                }else{
                    $sql = 'INSERT INTO food (title, description, price, category_id, featured, active) VALUES (?, ?, ?, ?, ?, ?)';
                    $stmt = $conn->prepare($sql);
                    $stmt->execute([$title, $desc, $price, $cat_id, $featured, $active]);
                }

                $msg = 'Food Info Uploaded Successfully';
                print_msg($msg, true);
            }
        }else{
            print_msg($errors, false);
        }
        
    }
}elseif($do == 'Edit') {
    $id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : '';
    if($id) {
        if(checkItem('id', 'food', $id)){
            $food_info = getSingleRecord('*', 'food', 'id', $id);
            $cats = getRecords('id, title', 'categories');

    ?>


<div class="main-content add-admin add-food py-12">
    <div class="container mx-auto">
        <h1 class="title text-4xl mb-6 font-bold capitalize text-center">Edit Food</h1>
        <div class="wrapper">
            <form action="?do=Update&id=<?= $food_info['id'] ?>" method="POST" autocomplete="off" enctype="multipart/form-data">
                <table class="max-w-full">
                    <tbody class="flex flex-col gap-4">
                        <tr class="flex justify-between items-center gap-6">
                            <td>Title</td>
                            <td>
                                <input type="text" name="food_title" value="<?= $food_info['title'] ?>" class="w-[300px]" autocomplete="off">
                            </td>
                        </tr>
                        <tr class="flex justify-between items-center gap-6">
                            <td>Description</td>
                            <td class="w-[300px] flex justify-start gap-8">
                                <textarea name="food_description" id="food_description" cols="30" rows="5"><?= $food_info['description'] ?></textarea>
                            </td>
                        </tr>
                        <tr class="flex justify-between items-center gap-6">
                            <td>Price ($)</td>
                            <td class="w-[300px] flex justify-start gap-8">
                                <input type="number" name="food_price" value="<?= $food_info['price'] ?>" id="food_price">
                            </td>
                        </tr>
                        <tr class="flex justify-between items-center gap-6">
                            <td>Select Image</td>
                            <td>
                                <input type="file" name="food_image" class="w-[300px]" autocomplete="off">
                            </td>
                        </tr>
                        <tr class="flex justify-start items-center gap-6">
                            <td>Category</td>
                            <td>
                                <select name="food_category" id="food_category" class="p-1 outline-none">
                                    <?php
                                    foreach($cats as $cat) {
                                        $selected = $cat['id'] == $food_info['category_id'] ? 'selected' : '';
                                        echo "<option value='".$cat['id']."' ". $selected .">".$cat['title']."</option>";
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr class="flex justify-between items-center gap-6">
                            <td>Featured</td>
                            <td class="w-[300px] flex justify-start gap-8">
                                <div class="item item-1 flex items-center gap-2">
                                    <input type="radio" id="featured_yes" name="food_featured" value="Yes" <?= $food_info['featured'] == 'Yes' ? 'checked' : '' ?> autocomplete="off">
                                    <label for="featured_yes">Yes</label>
                                </div>
                                <div class="item item-2 flex items-center gap-2">
                                    <input type="radio" id="featured_no" name="food_featured" value="No" <?= $food_info['featured'] == 'No' ? 'checked' : '' ?>  autocomplete="off">
                                    <label for="featured_no">No</label>
                                </div>
                            </td>
                        </tr>
                        <tr class="flex justify-between items-center gap-6">
                            <td>Active</td>
                            <td class="w-[300px] flex justify-start gap-8">
                                <div class="item item-1 flex items-center gap-2">
                                    <input type="radio" id="active_yes" name="food_active" value="Yes" <?= $food_info['active'] == 'Yes' ? 'checked' : '' ?> autocomplete="off">
                                    <label for="active_yes">Yes</label>
                                </div>
                                <div class="item item-2 flex items-center gap-2">
                                    <input type="radio" id="active_no" name="food_active" value="No" <?= $food_info['active'] == 'No' ? 'checked': '' ?> autocomplete="off">
                                    <label for="active_no">No</label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <button class="action-add-food mt-5 inline-block bg-blue-400 hover:bg-blue-600 transition-colors rounded px-2 py-1 text-white" name='add' value="food"><i class="fa fa-pen-to-square"></i> Update Food</button>
                            </td>
                            <td></td>
                        </trclass=>
                    </tbody>
                </table>
            </form>
            <a href="?do=Manage" class="back-to-manage-food mt-5 inline-block bg-yellow-400 hover:bg-yellow-600 transition-colors rounded px-2 py-1 text-white"><i class="fa fa-chevron-left"></i> Back To Manage</a>
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

}elseif($do == 'Update') {
    $id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : '';
    if($id) {
        if(checkItem('id', 'food', $id)) {
            $title = $_POST['food_title'];
            $desc  = $_POST['food_description'];
            $price = $_POST['food_price'];
            $food_image = $_FILES['food_image'];
            $cat_id = $_POST['food_category'];
            $featured = isset($_POST['food_featured']) ? $_POST['food_featured'] : 'No';
            $active = isset($_POST['food_active']) ? $_POST['food_active'] : 'No';

            //var_dump($_POST);
            //die;
            $errors = [];
            if(empty($title)) {
                $errors[] = 'Food title is required';
            }
            if(empty($price)) {
                $errors[] = 'Food price is required';
            }
            if($food_image['name'] != '') {
                $allowed_exts = array('jpg', 'jpeg', 'png', 'gif');
                $file_ext = strtolower(pathinfo($food_image['name'], PATHINFO_EXTENSION));
                if(!in_array($file_ext, $allowed_exts)){
                    $errors[] = 'Not allowed file type';
                }else{
                    $newFileName = time().'-'.$_SESSION['AdminID'].'-'.$food_image['name'];
                }
            }
            if(empty($cat_id)) {
                $errors[] = 'Category is required';
            }
            
            if(empty($errors)) {
                $condition = "id != $id AND title = '".$title."'";
                if(checkOtherItems('*', 'food', $condition)) {
                    $msg = 'Food Already Exist';
                    print_msg($msg, false);
                }else{
                    if(isset($newFileName)) {
                        // Deleteing Old Category Image
                        $food_img_name = getSingleRecord('image_name', 'food', 'id', $id);
                        $food_img_path = SITE_PATH.'admin/images/food_images/'.$food_img_name['image_name'];
                        if(file_exists($food_img_path) && is_file($food_img_path)){
                            unlink($food_img_path);
                        }

                        $sql = 'UPDATE food SET title = ?, description = ?, price = ?, image_name = ?, category_id = ?, featured = ?, active = ? WHERE id = ?';
                        $stmt = $conn->prepare($sql);
                        $stmt->execute(array($title, $desc, $price, $newFileName, $cat_id, $featured, $active, $id));
                        move_uploaded_file($food_image['tmp_name'], './images/food_images/'.$newFileName);

                    }else{
                        $sql = 'UPDATE food SET title = ?, description = ?, price = ?, category_id = ?, featured = ?, active = ? WHERE id = ?';
                        $stmt = $conn->prepare($sql);
                        $stmt->execute(array($title, $desc, $price, $cat_id, $featured, $active, $id));
                    }
                    // header('Location: '. SITE_URL.'admin/admin.php?do=Manage');
                    $msg = 'Food Updated Successfully';
                    print_msg($msg, true);
                }
            }else{
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
}

elseif($do == 'Delete') {
    $id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : '';
    if($id) {
        if(checkItem('id', 'food', $id)){
            // Deleteing Category Image
            $food_img_name = getSingleRecord('image_name', 'food', 'id', $id);
            $food_img_path = SITE_PATH.'admin/images/food_images/'.$food_img_name['image_name'];
            if(file_exists($food_img_path) && is_file($food_img_path)){
                unlink($food_img_path);
            }
            $sql = 'DELETE FROM food WHERE id = ?';
            $stmt = $conn->prepare($sql);
            $stmt->execute(array($id));

            $msg = 'Food Deleted Successfully';
            print_msg($msg, true);
        }else{
            $msg = 'No Food With This Id';
            print_msg($msg, false);
        }
    }else{
        $msg = 'No Food With This Id';
        print_msg($msg, false);
    }
}

?>
<?php include "./inc/footer.php" ?>