<?php include(ROOT_PATH . "/app/helpers/middleware.php");?>

<?php

  $_SESSION['id'] = 1;
  $_SESSION['username'] = 'testUser1';

  include(ROOT_PATH . "/app/database/db.php");
  include( ROOT_PATH . "/app/helpers/validateUser.php");
  // include("app/database/db.php");
  // include("app/helpers/validateUser.php");

  $table = 'user';
  $admin_users = selectAll($table);

  $username = '';
  $email = '';
  $password = '';
  $passwordConf = '';
  $id = '';
  
  $errors = array();

  function loginUser($user){
    $_SESSION['id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['admin'] = $user['admin'];
    $_SESSION['message'] = 'You are now logged in';
    $_SESSION['type'] = 'success';

    if ($_SESSION['admin']) {
      header('location:' . BASE_URL . '/admin/dashboard.php');
    } else {
      header('location:' . BASE_URL . '/index.php');
    }
    

    header('location: ' . BASE_URL . '/index.php');
    exit();
  }

  if(isset($_POST['register-btn']) || isset($_POST['create-admin'])){

       $errors = validateUser($_POST);

        if(count($errors)===0){
          
          unset($_POST['register-btn'], $_POST['passwordConf'], $_POST['create-admin']);
          $_POST['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
          
          if(isset($_POST['admin'])){
            $_POST['admin'] = 1;
            $user_id = create($table,$_POST);
            $_SESSION['message'] = "admin user created successfully";
            $_SESSION['type'] = "success";
            header('location:' . BASE_URL . '/admin/users/index.php');
            exit();
          } else{
            $_POST['admin'] = 0;
            $user_id = create($table,$_POST);
            $user = selectOne($table, ['id' => $user_id]);
            //log user in
            loginUser($user);
          }
        } else{
          $username = $_POST['username'];
          $email = $_POST['email'];
          $password = $_POST['password'];
          $passwordConf = $_POST['passwordConf'];
        }

        
  }

  if(isset($_POST['update-user'])){
    adminOnly();
    $id = $_POST['id'];
    $errors = validateUser($_POST);

        if(count($errors)===0){
          
          unset($_POST['update-user'], $_POST['passwordConf'], $_POST['id']);
          $_POST['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
          
            $_POST['admin'] = isset($_POST['admin']) ? 1 : 0;
            $count = update($table, $id,$_POST);
            $_SESSION['message'] = "admin user updated successfully";
            $_SESSION['type'] = "success";
            header('location:' . BASE_URL . '/admin/users/index.php');
            exit();
          
        } else{
          $username = $_POST['username'];
          $email = $_POST['email'];
          $password = $_POST['password'];
          $passwordConf = $_POST['passwordConf'];
        }

  }

  if(isset($_GET['id'])){
    $user = selectOne($table, ['id' => $_GET['id']]);
    $id = $user['id'];
    $username = $user['username'];
    $email = $user['email'];
    $admin = isset($user['admin']) ? 1 : 0;
  
  }

  if(isset($_POST['login-btn'])){
    $errors = validateLogin($_POST);
    if(count($errors)===0){
      $user = selectOne($table, ['username' => $_POST['username']]);
      if($user && password_verify($_POST['password'], $user['password'])){
        //log user in
        loginUser($user);
      }else{
        array_push($errors, 'Wrong Credentials');
      }
    }
    $username = $_POST['username'];
    $password = $_POST['password'];
  }

  if(isset($_GET['delete_id'])){
    adminOnly();
    $count = delete($table, $_GET['delete_id']);
    $_SESSION['message'] = "admin user deleted";
    $_SESSION['type'] = "error";
    header('location:' . BASE_URL . '/admin/users/index.php');
    exit();
  }
?>