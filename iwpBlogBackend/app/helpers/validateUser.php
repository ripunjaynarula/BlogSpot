<?php



function validateUser($user){
    
    $errors = array();
    if(empty($user['username'])){
        array_push($errors, 'Username is required.');
      }
      if(empty($user['email'])){
        array_push($errors, 'Email is required.');
      }
      if(empty($user['password'])){
        array_push($errors, 'Password is required.');
      }
      $uppercase = preg_match('@[A-Z]@', $user['password']);
      $lowercase = preg_match('@[a-z]@', $user['password']);
      $number    = preg_match('@[0-9]@', $user['password']);

      if(!$uppercase || !$lowercase || !$number || strlen($user['password']) < 8) {
        array_push($errors, 'Password must contain 8 characters, one uppercase, one lowercase, one number.');
      }
      if(($user['password'] !== $user['passwordConf'])){
        array_push($errors, 'Passwords do not match');
      }
      $existingUser = selectOne('user', ['email' => $user['email']]);
      if($existingUser){
        if(isset($user['update-user']) && $existingUser['id'] != $user['id']){
          array_push($errors, 'User with email already exists');      
        }
        if(isset($user['create-admin'])){
          array_push($errors, 'User with email already exists');      
        }
      }
    return $errors;
}

function validateLogin($user){
    
    $errors = array();
    if(empty($user['username'])){
        array_push($errors, 'Username is required.');
      }
      if(empty($user['password'])){
        array_push($errors, 'Password is required.');
      }
    return $errors;
}