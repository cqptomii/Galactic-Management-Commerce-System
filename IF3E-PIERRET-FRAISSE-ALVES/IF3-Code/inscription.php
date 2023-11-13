<?php
session_start();

// Connexion à la base de données
$bdd = new PDO("mysql:host=localhost;dbname=projet1;charset=utf8", "root", "");

$username =$_POST["username"];
$name = $_POST["nom"];
$first_name = $_POST["prenom"];
$mail = $_POST["email"];
$role = $_POST["role"];
$_SESSION['avatarname'] = "logo";
$_SESSION['username'] = $username;
$_SESSION['role'] = $role;
$_SESSION['mail'] = $mail;

// Vérification de l'existence de l'utilisateur ou de l'adresse e-mail dans la table login
$userCheck = $bdd->prepare("SELECT username, mail FROM login WHERE username = ? OR mail = ?");
$userCheck->execute([$username, $mail]);
$Userexist = $userCheck->fetch();

if ($Userexist) {
    // Si un utilisateur avec le même username ou email existe, prévenir l'utilisateur
    echo '<script>alert("Le username ou l\'adresse email sont déjà liés à un compte.");</script>';
    echo '<script>window.location.href = "inscription.html";</script>';
    die();
} else {
    // Inscription de l'utilisateur dans la table login
    $insertDB = $bdd->prepare("INSERT INTO login(username, password, name, mail, first_name, role,avatar) VALUES (?, SHA2(?,512), ?, ?, ?, ?,'avatarbase');");
    $insertDB->execute([$username, $_POST["password"], $name, $mail, $first_name, $role]);

    // Recup ID de l'utilisateur qui vient d'être creer
    $id_user = $bdd->lastInsertId();


    if ($id_user) {
        //On met toutes les ressources d'un nv utilisateurs à 0.
        $zeroall = $bdd->prepare("INSERT INTO profile(id_user, username, niveau, EXP, gold, metal) VALUES (?, ?, 1, 0, 0, 0)");
        $zeroall->execute([$id_user, $username]);
        // On attribue le vaisseau de base à un joueur qui vient d'etre creer.
        $insertVaisseau = $bdd->prepare("INSERT INTO equipe_vaisseau(id_user, id_vaisseau,fuel) VALUES (?, 1,100)");
        $insertVaisseau->execute([$id_user]);
        // En fonction du role choisi par le joueur lors de son inscription, on lui associe un partenaire de base.
        // Si soigneur ---> explorer
        // Si mineur ---> soigneur
        // Si explorer ---> soigneur
        if ($role == "soigneur") {
            $insertequipierbase = $bdd->prepare("INSERT INTO equipe_personnage(id_user,id_personnage,id_skill) VALUES (?,2,1)");
            $insertequipierbase->execute([$id_user]);
        }
        else if ($role == "mineur") {
            $insertequipierbase = $bdd->prepare("INSERT INTO equipe_personnage(id_user,id_personnage,id_skill) VALUES (?,1,1)");
            $insertequipierbase->execute([$id_user]);
        }
        else if ($role == "explorer") {
            $insertequipierbase = $bdd->prepare("INSERT INTO equipe_personnage(id_user,id_personnage,id_skill) VALUES (?,3,1)");
            $insertequipierbase->execute([$id_user]);
        }
        $_SESSION['id_user'] = $id_user;
        header('Location: profilpage.php'); // Redirection vers la page de profil
        die();
    } else {
        echo "Erreur lors de la création de l'utilisateur.";
    }
}
?>
