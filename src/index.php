<?php
//ici on démmare une session afin de pouvoir stocker les données de l'utilisateur , elle seront ensuite réutilisable sur les pages où la superglobal...
//...$_SESSION sera ecrite et définit (ATTENTION, il n'est apparament pas nessecaire d'écrire session_start() sur les autres pages)
session_start();

    require_once('header.php');
    require_once('connexion.php');

    $sql = "SELECT * FROM MesRecherches"; //Requête sql
    $query = $db->prepare($sql); //Ici on prépare la requête sql (préparer une requête serre diminuer le temps d'attente en cas d'utilisation multiple et protege aussi des injection SQL)

    //on execute la requête SELECT INSERT UPDATE DELETE
    $query->execute();

    //On stocke le  résultat dans un tableau
    $result = $query->fetchAll(PDO::FETCH_ASSOC);

    require_once('deconnexion.php');
?>

<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="style.css">
        <title>MyCRUD</title>

    </head>
    <body>
        <main class="container-fluid mt-3">
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
                    <?php
                        if (!empty($_SESSION["message"])){
                            echo '<div class="alert alert-success" role="alert">
                                    '. $_SESSION["message"].'
                                    </div>';
                            $_SESSION['message'] = "";
                        }
                    ?>
                    <h1>Mes recherches</h1>
                    <table class="table">
                        <thead class="text-danger">
                            <th>id</th>
                            <th>Statut recherche</th>
                            <th class="text-primary">Nom Entreprise</th>
                            <th>Date postulation</th>
                            <th>Date relance</th>
                            <th>Type postulation</th>
                            <th>Méthode postulation</th>
                            <th>Poste</th>
                            <th>Type contrat</th>
                            <th>Adresse Mail</th>
                            <th>Commentaires</th>
                            <th>Action</th>
                        </thead>


                    <!-- Le foreach ici serre a boucler sur la commande $result qui renvois un tableau avec mes recherche a l'interrieur -->
                        <tbody>
                            <?php
                            foreach($result as $entreprise){
                            ?>
                                <tr class="text-white">
                                    <td><?= $entreprise["id"] ?></td>
                                    <td><?= $entreprise["search_statue"] ?></td>
                                    <td><?= $entreprise["compagny_name"] ?></td>
                                    <td><?= $entreprise["apply_date"] ?></td>
                                    <td><?= $entreprise["new_apply"] ?></td>
                                    <td><?= $entreprise["apply_type"] ?></td>
                                    <td><?= $entreprise["methode_apply"] ?></td>
                                    <td><?= $entreprise["job"] ?></td>
                                    <td><?= $entreprise["contrat_type"] ?></td>
                                    <td><?= $entreprise["e_mail"] ?></td>
                                    <td><?= $entreprise["commentary"] ?></td>
                                    <td>
                                        <a href="details.php?id=<?= $entreprise["id"] ?>">Voir</a>
                                        <a href="update.php?id=<?= $entreprise["id"] ?>">Modifier</a>
                                        <a href="delete.php?id=<?= $entreprise["id"] ?>">Supprimer</a>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>

                    </table>
                    <a href="ajout.php" class="btn btn-primary">Ajouter une recherche</a>
                </section>
            </div>
        </main>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    </body>
</html>
