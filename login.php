<?php 
require 'init.php';
if(isset($_SESSION['user'])){
    go('index.php');
  }
  $errors = [];
  if($_SERVER['REQUEST_METHOD'] == 'POST'){
      $email = $_POST['email'];
      $password = $_POST['password'];
  
      if(empty($email)){
        $errors['email'] = 'Please enter your email';
      }
  
      if(empty($password)){
        $errors['password'] = 'Please enter your password';
      }
  
      if(empty($errors)){
        $user = getOne(
            'select * from users where email=?',
            [$email]
        );
        if(! $user){
            setError("Email not Found");
        }else{
            $ver = password_verify($password, $user->password);
            if(! $ver){
            setError("Wrong Password");
            }
        }
    
        if(!hasError()){
            $_SESSION['user'] = $user;
            go('index.php');
        }
    }
}
  
require 'include/head.php';
require 'include/nav.php';
?>

<div class="card ">
  <div class="card-header">
    <h3><i class="fas fa-sign-in-alt mr-2"></i>User login
    <span class="float-right">
        <div style="display: flex; align-items: center;">
            <div>
                <?php showError(); ?>
            </div>
        </div>
      </span>
    </h3>

  </div>
  <div class="card-body">
    <div style="width:450px; margin:0px auto">
    
      <form class="" action="" method="post">
          <div class="form-group">
            <label for="email">Email address</label>
            <input type="email" name="email"  class="form-control">
            <?php if (isset($errors['email'])): ?>
                <h6 class="text-danger"><?= $errors['email'] ?></h6>
            <?php endif; ?>
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password"  class="form-control">
            <?php if (isset($errors['password'])): ?>
                <h6 class="text-danger"><?= $errors['password'] ?></h6>
            <?php endif; ?>
          </div>
          <div class="form-group">
            <button type="submit" name="login" class="btn btn-success">Login</button>
          </div>


      </form>
    </div>
  </div>
</div>


<?php require 'include/footer.php';