<?php
//La page ajouter une entreprise a 2 rôles, afficher le formulaire d'ajout vierge, et ajouter une entreprise dans la BDD

//ici on démare une session afin de pouvoir stocker les données de l'utilisateur , elle seront ensuite réutilisable sur les pages où la superglobal...
//...$_SESSION sera ecrite et définit (ATTENTION, il n'est apparament pas nessecaire d'écrire session_start() sur les autres pages)
session_start();
require_once('user.php');

    if(!isset($_SESSION['user'])){
        header('location: login.php');
    }

    if($_POST){
        //ici on vérifie si les champs du formulaire son définit et pas vide
        if(isset($_POST['search_statue']) && !empty($_POST['search_statue'])
        && isset($_POST['user_id']) && !empty($_POST['user_id']) //le user_id serre de clé étrangère
        && isset($_POST['compagny_name']) && !empty($_POST['compagny_name'])
        && isset($_POST['apply_date']) && !empty($_POST['apply_date'])
        && isset($_POST['new_apply']) && !empty($_POST['new_apply'])
        && isset($_POST['apply_type']) && !empty($_POST['apply_type'])
        && isset($_POST['methode_apply']) && !empty($_POST['methode_apply'])
        && isset($_POST['job']) && !empty($_POST['job'])
        && isset($_POST['contrat_type']) && !empty($_POST['contrat_type'])
        && isset($_POST['e_mail']) && !empty($_POST['e_mail'])
        && isset($_POST['commentary']) && !empty($_POST['commentary'])){
        
        //Si on a toutes les données du formulaire on se connecte
        require_once('connexion.php');

        //on néttoie les données envoyées afin d'empêcher l'injection de code
        $search_statue = strip_tags($_POST["search_statue"]);
        $user_id = strip_tags($_POST["user_id"]); //le user_id serre de clé étrangère
        $compagny_name = strip_tags($_POST["compagny_name"]);
        $apply_date = strip_tags($_POST["apply_date"]);
        $new_apply = strip_tags($_POST["new_apply"]);
        $apply_type = strip_tags($_POST["apply_type"]);
        $methode_apply = strip_tags($_POST["methode_apply"]);
        $job = strip_tags($_POST["job"]);
        $contrat_type = strip_tags($_POST["contrat_type"]);
        $e_mail = strip_tags($_POST["e_mail"]);
        $commentary = strip_tags($_POST["commentary"]);

        //requête d'insertion
        $sql = "INSERT INTO MesRecherches (`user_id`,`search_statue`, `compagny_name`, `apply_date`, `new_apply`, `apply_type`, `methode_apply`, `job`, `contrat_type`, `e_mail`, `commentary`)
        VALUES (:user_id, :search_statue, :compagny_name, :apply_date, :new_apply, :apply_type, :methode_apply, :job, :contrat_type, :e_mail, :commentary);";

        //Onprépare la requête
        $query = $db->prepare($sql);

        //On fix les données entre elles
        $query->bindValue(":search_statue", $search_statue, PDO::PARAM_STR);
        $query->bindValue(":user_id", $user_id, PDO::PARAM_INT); //le user_id serre de clé étrangère
        $query->bindValue(":compagny_name", $compagny_name, PDO::PARAM_STR);
        $query->bindValue(":apply_date", $apply_date, PDO::PARAM_STR);
        $query->bindValue(":new_apply", $new_apply, PDO::PARAM_STR);
        $query->bindValue(":apply_type", $apply_type, PDO::PARAM_STR);
        $query->bindValue(":methode_apply", $methode_apply, PDO::PARAM_STR);
        $query->bindValue(":job", $job, PDO::PARAM_STR);
        $query->bindValue(":contrat_type", $contrat_type, PDO::PARAM_STR);
        $query->bindValue(":e_mail", $e_mail, PDO::PARAM_STR);
        $query->bindValue(":commentary", $commentary, PDO::PARAM_STR);

        $query->execute();

        $_SESSION['message'] = "Recherche ajoutée";
        require_once('deconnexion.php');
        header('Location: index.php');

        }else{
            //sinon envoyer le message d'erreur formulaire complet
            $_SESSION['erreur'] = "Le formulaire est incomplet";
        }
    }
?>

<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="style.css">
        <title>Ajouter une entreprise</title>

    </head>
    <body>
        <main class="container mt-3">
            <div class="row">
                <section class="col-12">
                    <?php
                        if (!empty($_SESSION["erreur"])){
                            echo '<div class="alert alert-danger" role="alert">
                                    '. $_SESSION["erreur"].'
                                    </div>';
                            $_SESSION['erreur'] = "";
                        }
                    ?>
                    <h1>Ajouter une recherches</h1>
                    <form method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="search_statue">Statue recherche</label>
                            <input type="text" id="search_statue" name="search_statue" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="compagny_name">Entreprise</label>
                            <input type="text" id="compagny_name" name="compagny_name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="apply_date">Date postulation</label>
                            <input type="text" id="apply_date" name="apply_date" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="new_apply">Date relance</label>
                            <input type="text" id="new_apply" name="new_apply" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="apply_type">Type postulation</label>
                            <input type="text" id="apply_type" name="apply_type" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="methode_apply">Méthode postulation</label>
                            <input type="text" id="methode_apply" name="methode_apply" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="job">Poste</label>
                            <input type="text" id="job" name="job" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="contrat_type">Type contrat</label>
                            <select type="text" id="contrat_type" name="contrat_type" class="form-control">
                                <option value="CDI">CDI</option>
                                <option value="CDD">CDD</option>
                                <option value="Stage">Stage</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="e_mail">eM@il</label>
                            <input type="text" id="e_mail" name="e_mail" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="commentary">Commentaire</label>
                            <input type="text" id="commentary" name="commentary" class="form-control">
                        </div>
                        <div class="form-group">
                            <input type="hidden" value="<?= ($_SESSION['user']['user_id']) ?>" id="user_id" name="user_id" class="form-control"> 
                            <!--INSTANCIER UTILISATEUR: ici on assigne la valeur $_SESSION['user']['user_id'] grace a "$_SESSION['user'] = ['user_id' => $user['id']];" définit dans login.php et ne pas oublier le session_start() avec le require_once("user.php")--> 
                        </div>

                        <!-- image start facultatif -->
                        <!-- <div>
                            <label for="image">Selectionner une image:</label>
                            <input type="file" id="image" name="image" class="form-control" required>
                        </div> -->
                        <!-- image end facultatif -->
                        <button class="btn btn-primary">Envoyer</button>
                    </form>
                </section>
            </div>
        </main>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    </body>
</html>
