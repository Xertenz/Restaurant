<?php

/* Print A Message For Success Or Error */
function print_msg($message, $success=true) {
    $classes = 'error px-9 py-3 font-bold rounded ';
    if ($success) {
        $classes .= 'text-green-400 bg-green-100';
    }else{
        $classes .= 'text-red-400 bg-red-100';
    }
    echo '<div class="admin-msg-wrapper text-center">';
        echo '<div class="admin-msg inline-flex flex-col gap-2">';
        if(is_array($message)) {
            foreach($message as $msg) {
                echo '<span class="'.$classes.'">'.$msg.'</span>';
            }
        }else{
                echo '<span class="'.$classes.'">'.$message.'</span>';
        }
        echo '</div>';
    echo '</div>';

}

// Get All Records In Table With Condition
function getRecords($column, $table, $where=null, $operation=null, $whereValue=null) {
    global $conn;
    $sql = "SELECT $column FROM $table";
    if( $where != null && $operation != null && $whereValue != null ) {
        $sql .= " WHERE $where $operation ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute(array($whereValue));
    }else{
        $stmt = $conn->prepare($sql);
        $stmt->execute();
    }

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

// Get Single Record In Table
function getSingleRecord($columns, $table, $column, $value) {
    global $conn;
    $stmt = $conn->prepare("SELECT $columns FROM $table WHERE $column = ?");
    $stmt->execute([$value]);
    if ($stmt->rowCount() != 0)
        return $stmt->fetch(PDO::FETCH_ASSOC);
}

/* Count The Number Of All Records In Table */
function count_items_in_table($tbl) {
    global $conn;
    $stmt = $conn->prepare("select count(*) from $tbl");
    $stmt->execute();
    return $stmt->fetchColumn();
}

/* Check For A Record In A Table */
function checkItem($column, $table, $where) {
    global $conn;
    $sql = "SELECT $column FROM $table WHERE $column = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array($where));
    return ($stmt->rowCount() != 0) ? true : false; 
}

// Check For An Exstence In Other Item
function checkOtherItems($column, $table, $where) {
    global $conn;
    $sql = "SELECT $column FROM $table WHERE $where";
    $stmt = $conn->prepare($sql);
    // print_r($stmt);
    // die;
    $stmt->execute();
    return ($stmt->rowCount() != 0) ? true : false;
}
?>