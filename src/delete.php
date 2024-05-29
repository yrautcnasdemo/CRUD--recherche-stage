<?php
// l'UPDATE est un mélange entre détails.php (qui fournie la fiche d'entreprise toute seule) 
// ET ajout.php qui fournis les élements (dont le formulaire) pour modifier la page existante
session_start();


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
        die();
    }



    $sql = "DELETE FROM MesRecherches WHERE id = :id;";

    $query = $db->prepare($sql);

    $query->bindValue(':id', $id, PDO::PARAM_INT);

    $query->execute();
    $_SESSION['message'] = "Fiche supprimée";
    header('Location: index.php');

}else{
    $_SESSION["erreur"] = "URL invalide";
    header("Location: index.php");
}
?>