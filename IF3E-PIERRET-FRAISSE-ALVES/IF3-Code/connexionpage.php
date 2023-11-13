<?php
session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page de connexion</title>
    <link rel="stylesheet" href="connexionpage.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.13.0/css/all.css">
</head>

<body>
<form method="POST" action="connexionpage.php">
    <h1>Login</h1>
    <div class="inputs">
        <input type="text" name="key" placeholder="Email/Username">
        <input type="password" name="mdp" placeholder="Password">
    </div>
    <p>
    <div align="center" class="inscription">I don't have account <br> <a href="inscription.html">Register</a>
    </div>
    </p>
    <div align="center">
        <input type="submit" name="connect" value="Login" >
    </div>
</form>
</body>

</html>
<?php
if(isset($_POST['connect'])) {
    $key = $_POST['key'];
    $mdp = $_POST['mdp'];

    $bdd = new PDO("mysql:host=localhost;dbname=projet1;charset=utf8", "root", "");

// Rechercher dans la base de données    si la clé correspond à un nom d'utilisateur ou à une adresse e-mail
    $keyCheck = $bdd->prepare("SELECT id_user,username,avatar,role,mail,password FROM login WHERE (username = ? OR mail = ?) AND login.password=sha2(?,512)");
    $keyCheck->execute([$key, $key, $mdp]);
    $userData = $keyCheck->fetch();

    if ($userData) {
        // La clé correspond à un nom d'utilisateur ou à une adresse e-mail
        // Le mot de passe est correct, rediriger vers le profil
        $_SESSION['id_user'] = $userData['id_user'];
        $_SESSION['username'] = $userData['username'];
        $_SESSION['avatar'] = $userData['avatar'];
        $_SESSION['role'] = $userData['role'];
        $_SESSION['mail'] = $userData['mail'];
        header('Location: profilpage.php');
        exit();
    } else {
        // Le mot de passe est incorrect, afficher un message d'erreur
        echo '<script>alert("Le mot de passe est incorrect.");</script>';
        echo '<script>window.location.href = "connexionpage.php";</script>';
    }
}
?>
