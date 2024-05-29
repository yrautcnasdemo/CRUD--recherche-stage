<?php
function addUser(PDO $db, string $first_name, string $last_name, string $email, string $password) {
    $sql = "INSERT INTO `users` (`first_name`, `last_name`, `email`, `password`, `role`) 
    VALUES (:first_name, :last_name, :email, :password, :role);";
    $query = $db->prepare($sql);

    //ici on sécurise le password dans la BDD afin de ne pas l'afficher
    $password = password_hash($password, PASSWORD_DEFAULT);

    $role = 'subscriber'; //role en dure avec variable déclarer mais osef, j'aurais du supprimer la colone role dans la BDD car elle est inutile
    $query->bindParam(':first_name', $first_name, PDO::PARAM_STR);
    $query->bindParam(':last_name', $last_name, PDO::PARAM_STR);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->bindParam(':password', $password, PDO::PARAM_STR);
    $query->bindParam(':role', $role, PDO::PARAM_STR);
    return $query->execute();
}

function verifyUserLoginPassword(PDO $db, string $email, string $password) {
    $sql=("SELECT * FROM users WHERE email = :email");

    $query = $db->prepare($sql);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->execute();
    $user = $query->fetch();

        //Ici on compare l'adresse mail (et le mdp crypté avec password_hash() ) de l'utilisateur situé dans la BDD, a l'adresse mail (et mdp) envoyer par l'utilisateur dans le formulaire 
        //et si c'est bon, on renvoie le message email trouvé
    if ($user && password_verify($password, $user['password'])) {
        return $user;
    }else{
        return false;
    }
}