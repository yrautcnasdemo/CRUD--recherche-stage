<?php
    session_start();
    require_once('connexion.php');
    require_once('user.php');

    $errors = [];
    $messages = [];


    //On teste si le formulaire a bien était remplie, loginUser est le "name" du bouton situé a la fin du formulaire
    if (isset($_POST['addUser'])) {

        $resulta = addUser($db, $_POST['first_name'], $_POST['last_name'], $_POST['email'], $_POST['password']);

        if($resulta) {
            header('Location: login.php');
        } else {
            $errors[] = "Une erreur s'est produit lors de votre inscription, votre vie est un echec...";
        }

    }

?>



<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Inscription</title>
</head>
<body>

    <section>
        
        <?php require_once('header.php'); ?>

        <h1>Inscription</h1>

        <?php foreach($messages as $message) { ?>
            <div class="alert alert-success">
                <?=$message; ?>
            </div>
        <?php } ?>

        <?php foreach($errors as $error) { ?>
            <div class="alert alert-danger">
                <?=$error; ?>
            </div>
        <?php } ?>

        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="first_name" class="form-label">Prenom</label>
                <input type="first_name" name="first_name" id="first_name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="last_name" class="form-label">Nom</label>
                <input type="last_name" name="last_name" id="last_name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Mot de passe</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>

            <input type="submit" value="Inscription" name="addUser" class="btn btn-primary">

        </form>

    </section>
    
</body>
</html>