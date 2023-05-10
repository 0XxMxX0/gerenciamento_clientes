<?php
session_start();
require_once "vendor/autoload.php";
use \App\Controller\Pages\Home;

if(isset($_SESSION['messagerBar'])){
    ?>
    <div class="alert alert-<?php echo $_SESSION['messagerBar']['alert']?> alert-dismissible fade show" role="alert">
        <?php echo $_SESSION['messagerBar']['messeger']?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php
    session_destroy();
}

echo Home::getHome();