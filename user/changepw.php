<?php 
require '../init.php';

if(isset($_GET['id']) && !empty($_GET['id'])){
    $id = $_GET['id'];
    $user = getOne("SELECT * FROM users WHERE id=$id");

    $errors = [];
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if (isset($_POST['cancel'])) {
            go('edit.php?id='.$user->id);
            exit;
        }

        $old_password = trim($_POST['old_password']);
        $new_password = trim($_POST['new_password']);
        
        if(empty($old_password)){
            $errors['old_password'] = 'Old Password is required';
        }
        if(empty($new_password)){
            $errors['new_password'] = 'New Password is required';
        }
        
        if(!empty($old_password) && !empty($new_password)) {
            if(password_verify($old_password, $user->password)) {
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                $result = query("UPDATE users SET password=? WHERE id=?", [
                    $hashed_password,
                    $id
                ]);
                if ($result) {
                    setMsg('Password updated successfully');
                    go('changepw.php?id=' . $id);
                    exit;
                } else {
                    setError('Password update failed');
                }
            } else {
                setError("Wrong Password");
            }
        }
    }
}

require '../include/head.php';
require '../include/nav.php';
?>

<div class="card">
  <div class="card-header">
    <h3>
      Change Password
      <span class="float-right">
        <div style="display: flex; align-items: center;">
          <div>
            <?php showMsg(); showError(); ?>
          </div>
          <a href="index.php" class="btn btn-secondary btn-sm ml-2">Back</a>
          
        </div>
      </span>
    </h3>
  </div>
</div>

<div class="card-body">
    <div style="width:600px; margin:0px auto">
        <form action="" method="POST">
            <div class="form-group pt-3">
                <label for="old_password">Old password</label>
                <input type="text" name="old_password" class="form-control">
                <?php if (isset($errors['old_password'])): ?>
                <h6 class="text-danger"><?= $errors['old_password'] ?></h6>
                <?php endif; ?>
                
            </div>
            <div class="form-group">
                <label for="new_password">New Password</label>
                <input type="text" name="new_password" class="form-control">
                <?php if (isset($errors['new_password'])): ?>
                <h6 class="text-danger"><?= $errors['new_password'] ?></h6>
                <?php endif; ?>
                
            </div>
            <div class="form-group">
                <button type="submit" name="register" class="btn btn-success">Update</button>
                <button type="submit" name="cancel" class="btn btn-secondary">Cancel</button>
            </div>
        </form>
    </div>
</div>

<?php require '../include/footer.php'; ?>