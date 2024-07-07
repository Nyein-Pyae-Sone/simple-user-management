<?php 
require '../init.php' ;
ensureLoggedIn();

$role = getAll("SELECT * FROM  roles");
$gender = getAll("SELECT DISTINCT gender FROM users");
if(isset($_GET['id']) && !empty($_GET['id'])){
    $id = $_GET['id'];
    $user = getOne("select * from users where id=$id");

    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        $name = $_POST['name'];
        $username = $_POST['username'];
        $role_id = $_POST['role_id'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $address = $_POST['address'];
        $gender = $_POST['gender'];
   
        $sql = "UPDATE users SET name = ?, username = ?, email = ?, address = ?, phone = ?, gender = ?, role_id = ? WHERE id = ?";
        $params = [$name, $username, $email, $address, $phone, $gender, $role_id, $id]; 
        $res = query($sql, $params);

        if($res){
            setMsg('User Updated Success');
            go('edit.php?id='.$user->id);
            die();
        }else{
            setError('User Updated Fail');
            go('edit.php?id='.$user->id);
            die();
        }
    }
}


require '../include/head.php';
require '../include/nav.php';
?>

<div class="card">
  <div class="card-header">
    <h3>
      <i class="fas fa-user-plus mr-2"></i>Edit User
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

<div class="cad-body">
        <div style="width:600px; margin:0px auto">

        <form class="" action="" method="POST">
            <div class="form-group pt-3">
              <label for="name">Your name</label>
              <input type="text" name="name" class="form-control" value="<?= $user->name ?>" required>
            </div>
            <div class="form-group">
              <label for="username">Your username</label>
              <input type="text" name="username"  value="<?= $user->username ?>" class="form-control" required>
            </div>
            <div class="form-group">
              <label for="email">Email address</label>
              <input type="email" name="email" value="<?= $user->email ?>" class="form-control" required>
            </div>
            <div class="form-group">
              <label for="address">Address</label>
              <input type="text" name="address" value="<?= $user->address ?>"  class="form-control" required>
            </div>
            <div class="form-group">
              <label for="mobile">Mobile Number</label>
              <input type="text" name="phone" value="<?= $user->phone ?>" class="form-control" required>
            </div>
            <div class="form-group">
              <label for="gender">Gender</label>
              <select class="form-control" name="gender" id="gender">
                <?php foreach($gender as $g) : ?>
                    <?php $selected = $g->gender == $user->gender? 'selected' : '' ; ?>
                    <option value="<?= $g->gender ?>" <?= $selected ?>><?= $g->gender ?></option>
                <?php endforeach ?>
                </select>
            </div>
            <div class="form-group">
                  <label for="sel1">User Role</label>
                  <select class="form-control" name="role_id" id="role_id">
                    <?php foreach($role as $r) : ?>
                        <?php $selected = $r->id == $user->role_id ? 'selected' : ''; ?>
                        <option value="<?= $r->id ?>" <?= $selected ?> ><?= $r->name ?></option>
                    <?php endforeach ?>
                  </select>
               </div>
               <div class="form-group">
              <button type="submit" name="register" class="btn btn-success">Save</button>
              <a href="changepw.php?id=<?= $user->id ?>" class="btn btn-success">Change Password</a>
            </div>


        </form>
      </div>


    </div>
</div>

<?php require '../include/footer.php'; ?>