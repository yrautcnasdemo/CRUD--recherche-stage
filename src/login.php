<?php
    session_start();
    require_once('header.php');
    require_once('connexion.php');
    require_once('user.php');

    $errors = [];
    $messages = [];


    //On teste si le formulaire a bien était remplie, loginUser est le "name" du bouton situé a la fin du formulaire
    if (isset($_POST['loginUser'])) {

        $user = verifyUserLoginPassword($db, $_POST['email'], $_POST['password']);

        if ($user) {
            $_SESSION['user'] = ['email' => $user['email']];
            header('Location: index.php');
        } else {
            $errors[] = 'Email ou mot de passe incorrect, votre vie est un echec...';
        }
    }

//DEBUT TESTE DE LOGIN EN LOCAL SANS BDD (avec un tableau $users implanté dans la page si dessous)
    // $users = [
    //     ['email' => 'abc@test.com', 'password' =>'1234'],
    //     ['email' => 'test@test.com', 'password' =>'test']
    // ];

    // //On teste si le formulaire a bien était remplie
    // if (isset($_POST['loginUser'])) {
    //     foreach($users as $user) {
    //         //Ici on compare l'adresse mail (et mdp) de l'utilisateur situé dans la BDD, a l'adresse mail (et mdp) envoyer par l'utilisateur dans le formulaire 
    //         //et si c'est bon, on renvoie le message email trouvé
    //         if ($user['email'] === $_POST['email'] && $user['password'] === $_POST['password']) 
    //         $messages[] = 'Email et mdp trouvé';
    //     }
    // }
//FIN TESTE DE LOGIN EN LOCAL SANS BDD


?>



<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>MyCRUD</title>
</head>
<body>
    <section>

        <h1>Connexion</h1>

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
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control">
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Mot de passe</label>
                <input type="password" name="password" id="password" class="form-control">
            </div>

            <!-- Cette input est le bouton correspondant a loginUser qui est utilisé pour récupèrer les données POST du formulaire afin de les vérifier -->
            <input type="submit" value="Connexion" name="loginUser" class="btn btn-primary">

        </form>

    </section>
    
</body>
</html>