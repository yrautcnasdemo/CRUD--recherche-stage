<?php
// l'UPDATE est un mélange entre détails.php (qui fournie la fiche d'entreprise toute seule) 
// ET ajout.php qui fournis les élements (dont le formulaire) pour modifier la page existante
session_start();

// ICI COMMENCE LA REPRISE D'UNE PARTIE DE "ajout.php" (commentaire néttoyés pour plus de clareté, voir ajout.php pour avoir la totalité des commentaires)
if($_POST){
    if(isset($_POST['id']) && !empty($_POST['id']) //pour update.php on rajoute l'id
    && isset($_POST['search_statue']) && !empty($_POST['search_statue'])
    && isset($_POST['compagny_name']) && !empty($_POST['compagny_name'])
    && isset($_POST['apply_date']) && !empty($_POST['apply_date'])
    && isset($_POST['new_apply']) && !empty($_POST['new_apply'])
    && isset($_POST['apply_type']) && !empty($_POST['apply_type'])
    && isset($_POST['methode_apply']) && !empty($_POST['methode_apply'])
    && isset($_POST['job']) && !empty($_POST['job'])
    && isset($_POST['contrat_type']) && !empty($_POST['contrat_type'])
    && isset($_POST['e_mail']) && !empty($_POST['e_mail'])
    && isset($_POST['commentary']) && !empty($_POST['commentary'])){
    
    require_once('connexion.php');

    $id = strip_tags($_POST["id"]); //pour update.php on rajoute l'id
    $search_statue = strip_tags($_POST["search_statue"]);
    $compagny_name = strip_tags($_POST["compagny_name"]);
    $apply_date = strip_tags($_POST["apply_date"]);
    $new_apply = strip_tags($_POST["new_apply"]);
    $apply_type = strip_tags($_POST["apply_type"]);
    $methode_apply = strip_tags($_POST["methode_apply"]);
    $job = strip_tags($_POST["job"]);
    $contrat_type = strip_tags($_POST["contrat_type"]);
    $e_mail = strip_tags($_POST["e_mail"]);
    $commentary = strip_tags($_POST["commentary"]);

    //on change le INSERT INTO de ajout.php en UPDATE et on rajoute SET pour changer les parametres
    $sql = 'UPDATE MesRecherches SET `search_statue`=:search_statue, `compagny_name`=:compagny_name, `apply_date`=:apply_date, `new_apply`=:new_apply, 
    `apply_type`=:apply_type, `methode_apply`=:methode_apply, `job`=:job, `contrat_type`=:contrat_type, `e_mail`=:e_mail, `commentary`=:commentary
    WHERE `id`=:id;';

    $query = $db->prepare($sql);

    $query->bindValue(":id", $id, PDO::PARAM_INT);//On rajoute la valeur bindValue id 
    $query->bindValue(":search_statue", $search_statue, PDO::PARAM_STR);
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

    $_SESSION['message'] = "Fiche entreprise modifiée";
    require_once('deconnexion.php');
    header('Location: index.php');

    }else{
        //sinon envoyer le message d'erreur formulaire complet
        $_SESSION['erreur'] = "Le formulaire est incomplet";
    }
}
// ICI TERMINE LA REPRISE D'UNE PARTIE DE "ajout.php"


// ICI COMMENCE LA REPRISE D'UNE PARTIE DE "details.php" (commentaire néttoyés pour plus de clareté, voir details.php pour avoir la totalité des commentaires)
if(isset ($_GET["id"]) && !empty($_GET["id"])){
    require_once('connexion.php');

    $id = strip_tags($_GET["id"]);

    $sql = "SELECT * FROM MesRecherches WHERE id = :id;";

    $query = $db->prepare($sql);

    $query->bindValue(':id', $id, PDO::PARAM_INT);

    $query->execute();

    $entreprise = $query->fetch();

    if(!$entreprise){
        $_SESSION['erreur'] = "Cet id n'existe pas, votre vie est un echec...";
        header('Location: index.php');
    }

}else{
    $_SESSION["erreur"] = "URL invalide";
    header("Location: index.php");
}
// ICI TERMINE LA REPRISE D'UNE PARTIE DE "details.php" 

?>



<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="style.css">
        <title>Modifier une entreprise</title>

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
                    <h1>Modifier une recherches</h1>
                    <form method="post">
                        <div class="form-group">
                            <label for="search_statue">Statue recherche</label>
                            <input type="text" id="search_statue" name="search_statue" class="form-control" value="<?= $entreprise['search_statue'] ?>">
                        </div>
                        <div class="form-group">
                            <label for="compagny_name">Entreprise</label>
                            <input type="text" id="compagny_name" name="compagny_name" class="form-control" value="<?= $entreprise['compagny_name']?>">
                        </div>
                        <div class="form-group">
                            <label for="apply_date">Date postulation</label>
                            <input type="text" id="apply_date" name="apply_date" class="form-control" value="<?= $entreprise['apply_date']?>">
                        </div>
                        <div class="form-group">
                            <label for="new_apply">Date relance</label>
                            <input type="text" id="new_apply" name="new_apply" class="form-control" value="<?= $entreprise['new_apply']?>">
                        </div>
                        <div class="form-group">
                            <label for="apply_type">Type postulation</label>
                            <input type="text" id="apply_type" name="apply_type" class="form-control" value="<?= $entreprise['apply_type']?>">
                        </div>
                        <div class="form-group">
                            <label for="methode_apply">Méthode postulation</label>
                            <input type="text" id="methode_apply" name="methode_apply" class="form-control" value="<?= $entreprise['methode_apply']?>">
                        </div>
                        <div class="form-group">
                            <label for="job">Poste</label>
                            <input type="text" id="job" name="job" class="form-control" value="<?= $entreprise['job']?>">
                        </div>
                        <div class="form-group">
                            <label for="contrat_type">Type contrat</label>
                            <input type="text" id="contrat_type" name="contrat_type" class="form-control" value="<?= $entreprise['contrat_type']?>">
                        </div>
                        <div class="form-group">
                            <label for="e_mail">eM@il</label>
                            <input type="text" id="e_mail" name="e_mail" class="form-control" value="<?= $entreprise['e_mail']?>">
                        </div>
                        <div class="form-group">
                            <label for="commentary">Commentaire</label>
                            <input type="text" id="commentary" name="commentary" class="form-control" value="<?= $entreprise['commentary']?>">
                        </div>
                        <!--NE SURTOUT PAS OUBLIER DE RAJOUTER L'id POUR BIEN ENVOYER LA REQUÊTE -->
                        <input type="hidden" value="<?= $entreprise["id"]?>" name="id">

                        <!-- image start facultatif -->
                        <!-- <div>
                            <label for="image">Selectionner une image:</label>
                            <input type="file" id="image" name="image" class="form-control" required>
                        </div> -->
                        <!-- image end facultatif -->
                        <button class="btn btn-primary affichage">Envoyer</button>
                    </form>
                </section>
            </div>
        </main>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    </body>
</html>
