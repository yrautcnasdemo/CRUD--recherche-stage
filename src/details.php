<?php
//ici on démare une session afin de pouvoir stocker les données de l'utilisateur , elle seront ensuite réutilisable sur les pages où la superglobal...
//...$_SESSION sera ecrite et définit (ATTENTION, il n'est apparament pas nessecaire d'écrire session_start() sur les autres pages mais là si, et je ne sais pas pourquoi)
// gemini me propose ces solutions : 
// 1-Vérifier la configuration des erreurs : Assurez-vous que le reporting des erreurs est activé pour afficher les notices et warnings. Un niveau d'erreur reporting de E_ALL est généralement recommandé pour le débogage.
// 2-Analyser le code de gestion des erreurs : Vérifiez si vous avez implémenté un traitement d'erreurs personnalisé qui masque le message d'erreur par défaut.
// 3-Mettre à jour PHP : Si vous utilisez une version de PHP obsolète, envisagez de la mettre à jour vers une version récente et stable pour bénéficier des meilleures performances et de la meilleure sécurité.
// 4-Tester le code : Reproduisez le scénario où l'erreur devrait se produire et vérifiez attentivement les messages d'erreur affichés ou les comportements inattendus.
session_start();



//Vérifie si l'id récupéré dans l'url grace a $_GET existe , et vérifie si elle n'est pas vide.
if(isset ($_GET["id"]) && !empty($_GET["id"])){
    require_once('connexion.php');
    //ici on récupuère les données d'une seule de mes recherches afin d'afficher une nouvelle page qui concerne uniquement l'entreprise choisie

    //on néttoie l'id envoyer afin d'empêcher l'injection de code
    $id = strip_tags($_GET["id"]);

    $sql = "SELECT * FROM MesRecherches WHERE id = :id;";

    //on prépare la requête
    $query = $db->prepare($sql);

    //on "accroche" les parametres de l'id avec un bindValue
    $query->bindValue(':id', $id, PDO::PARAM_INT);

    //on execute 
    $query->execute();

    //on récupère la fiche détaillée de ma recherche d'entreprise, on utilise fetch et non pas fetchAll car ici
    //on ne demande qu'une seule donnée du tableau (une seule de mes recherches de stage)
    $entreprise = $query->fetch();

    //On vérifie si la fiche de recherche de stage existe
    if(!$entreprise){
        $_SESSION['erreur'] = "Cet id n'existe pas, votre vie est un echec...";
        header('Location: index.php');
    }

}else{
    $_SESSION["erreur"] = "URL invalide";
    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="style.css">
    <title>Détailles de ma recherche</title>
</head>
<body>
    <main class="container">
        <div class="row">
            <section class="col-12">

                <div class="row flex-lg-row-reverse align-items-center g-5 py-5">
                    <div class="col-10 col-sm-8 col-lg-6">
                        <img src="/images/nointernet.jpg" class="d-block mx-lg-auto img-fluid" alt="Bootstrap Themes" width="auto" height="auto" loading="lazy">
                    </div>
                    <div class="col-lg-6">
                    <h1>Entreprise : <?= $entreprise["compagny_name"]?></h1>
                                    <p>ID : <?= $entreprise["id"]?></p>
                                    <p>Statut : <?= $entreprise["search_statue"] ?></p>
                                    <p>Date postulation : <?= $entreprise["apply_date"] ?></p>
                                    <p>Date relance : <?= $entreprise["new_apply"] ?></p>
                                    <p>Type postulation : <?= $entreprise["apply_type"] ?></p>
                                    <p>Méthode postulation : <?= $entreprise["methode_apply"] ?></p>
                                    <p>Poste : <?= $entreprise["job"] ?></p>
                                    <p>Type contrat : <?= $entreprise["contrat_type"] ?></p>
                                    <p>Adresse mail : <?= $entreprise["e_mail"] ?></p>
                                    <p>commentaire : <?= $entreprise["commentary"] ?></p>
                        <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                        <a href="index.php?id=<?= $entreprise["id"] ?>"><button type="button" class="btn btn-primary btn-lg px-4 me-md-2">Index</button></a>
                        <a href="update.php?id=<?= $entreprise["id"] ?>"><button type="button" class="btn btn-outline-warning btn-lg px-4 me-md-2">Modifier</button></a>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>
    
</body>
</html>
