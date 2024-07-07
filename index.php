<?php 
require 'init.php' ;
ensureLoggedIn();
require 'include/head.php';
require 'include/nav.php'
?>
<div class="card ">
        <div class="card-header">
          <h3 class="text-center">Welcome!
            <span class="badge badge-lg badge-secondary text-white">
            <?= $_SESSION['user']->name ?></span>

          </strong></span></h3>
        </div>
<?php require 'include/footer.php';