<?php 
require '../init.php' ;
ensureLoggedIn();
//delete
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['_method']) && $_POST['_method'] === 'DELETE') { 
  $id = $_POST['id']; 
  query("DELETE FROM users WHERE id=?", [$id]);
}

$users = getAll(' SELECT users.id, users.name, users.username, users.email,users.gender, roles.name as role_name FROM users JOIN roles ON users.role_id = roles.id ');

require '../include/head.php';
require '../include/nav.php';
?>

  <div class="card">
    <div class="card-header">
      <h3><i class="fas fa-users mr-2"></i>User list
        <span class="float-right">
            <a href="create.php" class="btn btn-primary"><i class="fas fa-user-plus"></i> Create User</a>
        </span>
      </h3>
    </div>
  </div>

  <div class="card-body pr-2 pl-2">
    <table id="example" class="table table-striped table-bordered" style="width:100%">
      <thead>
        <tr>
          <th  class="text-center">Id</th>
          <th  class="text-center">Name</th>
          <th  class="text-center">Username</th>
          <th  class="text-center">Email address</th>
          <th  class="text-center">Gender</th>
          <th  class="text-center">Role</th>
          <th  width='25%' class="text-center">Action</th>
        </tr>
      </thead>

      <tbody>
      
      <?php foreach ($users as $user) :?>
        <tr class="text-center">
          <td><?= htmlspecialchars($user->id) ?></td>
          <td><?= htmlspecialchars($user->name)?></td>
          <td><?= htmlspecialchars($user->username)?> </td>
          <td><?= htmlspecialchars($user->email)?></td>
          <td><?= htmlspecialchars($user->gender)?></td>
          <td><?= htmlspecialchars($user->role_name)?></td>

          <td>
              
              <a class="btn btn-info btn-sm " href="edit.php?id=<?= $user->id ?>">Edit</a>
              <form method="POST"  class="d-inline"> 
                <input type="hidden" name="_method" value="DELETE"> 
                <input type="hidden" name="id" value="<?= $user->id ?>"> 
                <button type="submit" onclick="return confirm('Sure For Delete?')" class="btn btn-danger btn-sm">Remove</button> 
              </form>
            </td>

      <?php endforeach ?>   
    </tbody>

  </table>
  

  </div>
</div>

<?php require '../include/footer.php';