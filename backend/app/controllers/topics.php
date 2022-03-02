<?php error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE); ?>
<?php include("../../app/database/db.php"); ?>
<?php include("../../app/helpers/validateTopic.php"); ?>
<?php include("../../app/helpers/middleware.php");?>

<?php

$table = 'topics';
$id = '';
$name = '';
$description = '';
$errors = array();


$topics = selectAll($table);

if(isset($_POST['add-topic'])){
    adminOnly();
    $errors = validateTopic($_POST);

    if(count($errors)===0){
        unset($_POST['add-topic']);
        $topic_id = create($table, $_POST);
        $_SESSION['message'] = 'Topic created successfully';
        $_SESSION['type'] = 'success';
        header('location: ' . BASE_URL . '/admin/topics/index.php');
        exit();
    } else{
        $name = $_POST['name'];
        $description = $_POST['description'];
    }
    
}

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $topic = selectOne($table, ['id' => $id]);
    $id = $topic['id'];
    $name = $topic['name'];
    $description = $topic['description'];
}

if(isset($_GET['del_id'])){
    adminOnly();
    $id = $_GET['del_id'];
    $count = delete($table, $id);
    $_SESSION['message'] = 'Topic successfully deleted';
    $_SESSION['type'] = 'error';
    header('location: ' . BASE_URL . '/admin/topics/index.php');
    exit();
}

if(isset($_POST['update-topic'])){
    adminOnly();
    $errors = validateTopic($_POST);
    if(count($errors === 0)){
        $id = $_POST['id'];
        unset($_POST['update-topic']);
        unset($_POST['id']);
        $topic_id = update($table, $id, $_POST);
        $_SESSION['message'] = 'Topic successfully updated';
        $_SESSION['type'] = 'success';
        header('location: ' . BASE_URL . '/admin/topics/index.php');
        exit();
    } else {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $description = $_POST['description'];
    }
    
}