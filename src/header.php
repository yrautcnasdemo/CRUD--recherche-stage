<header class="container">
        <div class="mt-4 d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">

            <div class="container text-end">
                <?php if(!isset($_SESSION['user'])) { ?>
                    <a href="inscription.php" type="button" class="btn btn-outline-light me-2">S'inscrire</a> 
                <?php } else { ?>
                    <a href="logout.php" type="button" class="btn btn-warning">Déconnexion</a>
                <?php } ?>
            </div>
        </div>
</header>
