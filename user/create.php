<?php 
require '../init.php';
ensureLoggedIn();
// Fetch all roles
$roles = getAll('SELECT * FROM roles');

$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (isset($_POST['cancel'])) {
    // Redirect to the create page without retaining form data
    header('Location: create.php');
    exit;
  }

  $name = trim($_POST['name']);
  $username = trim($_POST['username']);
  $role_id = $_POST['role_id'];
  $phone = trim($_POST['phone']);
  $email = trim($_POST['email']);
  $address = trim($_POST['address']);
  $password = trim($_POST['password']);
  $gender = $_POST['gender'];

  if (empty($name)) {
    $errors['name'] = 'Please enter your name';
  }
  if (empty($username)) {
    $errors['username'] = 'Please enter your username';
  }
  if (empty($email)) {
    $errors['email'] = 'Please enter your email';
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = 'Invalid email format';
  }

  if (empty($password)) {
    $errors['password'] = 'Password is required';
  }
  if (empty($address)) {
    $errors['address'] = 'Please enter your address';
  }
  if (empty($phone)) {
    $errors['phone'] = 'Please enter your phone';
  }

  if (empty($errors)) {
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    $res = query(
      'INSERT INTO users (name, username, role_id, phone, email, address, password, gender) VALUES (?, ?, ?, ?, ?, ?, ?, ?)',
      [$name, $username, $role_id, $phone, $email, $address, $hashed_password, $gender]
    );

    if ($res) {
      setMsg('User created successfully.');
    } else {
      setError('User creation failed.');
    }
  } else {
    setError('Please fix the errors below.');
  }
}

require '../include/head.php';
require '../include/nav.php';
?>

<div class="card">
  <div class="card-header">
    <h3>
      <i class="fas fa-user-plus mr-2"></i>Create User
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
  <div style="width:600px; margin:0 auto">
    <form action="" method="POST">
      <div class="form-group pt-3">
        <label for="name">Your name</label>
        <input type="text" name="name" class="form-control" value="<?= $name ?? '' ?>">
        <?php if (isset($errors['name'])): ?>
          <h6 class="text-danger"><?= $errors['name'] ?></h6>
        <?php endif; ?>
      </div>

      <div class="form-group">
        <label for="username">Your username</label>
        <input type="text" name="username" class="form-control" value="<?= $username ?? '' ?>">
        <?php if (isset($errors['username'])): ?>
          <h6 class="text-danger"><?= $errors['username'] ?></h6>
        <?php endif; ?>
      </div>

      <div class="form-group">
        <label for="email">Email address</label>
        <input type="email" name="email" class="form-control" value="<?= $email ?? '' ?>">
        <?php if (isset($errors['email'])): ?>
          <h6 class="text-danger"><?= $errors['email'] ?></h6>
        <?php endif; ?>
      </div>

      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" name="password" class="form-control">
        <?php if (isset($errors['password'])): ?>
          <h6 class="text-danger"><?= $errors['password'] ?></h6>
        <?php endif; ?>
      </div>

      <div class="form-group">
        <label for="address">Address</label>
        <input type="text" name="address" class="form-control" value="<?= $address ?? '' ?>">
        <?php if (isset($errors['address'])): ?>
          <h6 class="text-danger"><?= $errors['address'] ?></h6>
        <?php endif; ?>
      </div>

      <div class="form-group">
        <label for="mobile">Mobile Number</label>
        <input type="text" name="phone" class="form-control" value="<?= $phone ?? '' ?>">
        <?php if (isset($errors['phone'])): ?>
          <h6 class="text-danger"><?= $errors['phone'] ?></h6>
        <?php endif; ?>
      </div>

      <div class="form-group">
        <label for="gender">Gender</label>
        <select class="form-control" name="gender" id="gender">
            <option value="1">Male</option>
            <option value="2">Female</option>  
          </select>
      </div>

      <div class="form-group">
            <label for="sel1">Select User Role</label>
            <select class="form-control" name="role_id" id="role_id">
              <?php foreach($roles as $role) : ?>
                <option value="<?= $role->id ?>"><?= $role->name ?></option>
              <?php endforeach ?>
            </select>
      </div>
      
      <div class="form-group">
        <button type="submit" name="register" class="btn btn-success">Save</button>
        <button type="button" onclick="window.location.href='create.php';" class="btn btn-secondary">Cancel</button>
      </div>
    </form>
  </div>
</div>

<?php require '../include/footer.php'; ?>