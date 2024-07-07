<?php 
require '../init.php' ;
ensureLoggedIn();

$features = getAll("SELECT * FROM features");
$permissions = getAll("SELECT * FROM permissions");

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if (isset($_POST['cancel'])) {
        // Redirect to the create page
        go('create.php'); 
        exit;
    }

    $name = trim($_POST['name']);
    if(empty($name)){
        setError('Please Enter Role');
    }
    if(!hasError()){
        $reg = query("INSERT INTO roles (name) VALUES (?)",[$name]);
        if($reg){
            setMsg('Role Created Successfully');
            $roleId = lastInsertId(); // Get the last inserted role ID
            if($roleId && isset($_POST['permissions']) && is_array($_POST['permissions'])){
                foreach($_POST['permissions'] as $permissionId){
                    query("INSERT INTO role_permissions (role_id, permission_id) VALUES (?, ?)", [$roleId, $permissionId]);
                }
            }
        }
    }
}

require '../include/head.php';
require '../include/nav.php';
?>

<div class="card">
    <div class="card-header">
        <h3><i class="fas fa-users mr-2"></i>Create Role
            <span class="float-right">
                <a href="<?= $root ?>user/index.php" class="btn btn-secondary btn-sm ml-2">Back</a>
            </span>
        </h3>
    </div>
</div>

<div class="card-body">
    <div style="width:600px; margin:0px auto">
        <form action="" method="POST">
            <div class="form-group pt-3">
                <label for="name">Role Name</label>
                <input type="text" name="name" class="form-control"> 
                <?php showError(); showMsg(); ?> 
            </div>

            <div class="form-group">
                <h3>Role permissions</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Feature</th>
                            <th>Create</th>
                            <th>View</th>
                            <th>Update</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($features as $feature) :?>
                            <tr>
                                <td><?= $feature->name ?></td>
                                <?php 
                                $featurePermissions = array_filter($permissions, function($permission) use ($feature) {
                                    return $permission->feature_id == $feature->id;
                                });
                                foreach ($featurePermissions as $permission) {
                                    echo "<td><label class='checkbox-label'><input type='checkbox' name='permissions[]' value='{$permission->id}' style='margin-right:10px'>{$permission->name}</label></td>";
                                }
                                ?>
                            </tr>       
                        <?php endforeach ?>
                        
                    </tbody>
                </table>
            </div>

            <div class="form-group">
                <button type="submit" name="register" class="btn btn-success">Save</button>
                <button type="submit" name="cancel" class="btn btn-danger">Cancel</button>
            </div>
        </form>
    </div>
</div>

<?php require '../include/footer.php'; ?>