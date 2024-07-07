<nav class="navbar navbar-expand-md navbar-dark bg-dark card-header">
      <a class="navbar-brand" href="index.php"><i class="fas fa-home mr-2"></i>Dashboard</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav ml-auto">

        <?php if(isset($_SESSION['user'])) : ?>
            <li class="nav-item">
                <a class="nav-link" href="<?= $root; ?>user/index.php"><i class="fas fa-users mr-2"></i>User lists </span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?= $root; ?>user/create.php"><i class="fas fa-user-plus mr-2"></i>Add user </span></a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="<?= $root; ?>roles/create.php"><i class="fas fa-user-plus mr-2"></i>Add role </span></a>
            </li>
          
          <li class="nav-item">
            <a class="nav-link" href="<?= $root;?>logout.php"><i class="fas fa-sign-out-alt mr-2"></i>Logout</a>
          </li>

          <?php endif; ?>

         
      


        </ul>

      </div>
</nav>