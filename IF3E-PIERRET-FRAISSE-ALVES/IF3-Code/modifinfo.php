<?php
session_start();
$bdd = new PDO("mysql:host=localhost;dbname=projet1;charset=utf8", "root", "");

$username = $_POST["username"];
$name = $_POST["nom"];
$first_name = $_POST["prenom"];
$mail = $_POST["email"];
$password = $_POST["password"];
$birth = $_POST["birth"];

$id_user = $_SESSION['id_user'];

$updateUser = $bdd->prepare("UPDATE login SET username = ?, password = SHA2(?, 512), name = ?, mail = ?, first_name = ? WHERE id_user = ?");
$updateUser->execute([$username, $password, $name, $mail, $first_name, $id_user]);
$updateUser2 = $bdd->prepare("UPDATE profile SET username = ? WHERE id_user = ?");
$updateUser2->execute([$username, $id_user]);

$_SESSION['username'] = $username;


if ($updateUser) {
    if (!empty($birth)) {
        $updateBirth = $bdd->prepare("UPDATE login SET birth = ? WHERE id_user = ?");
        $updateBirth->execute([$birth, $id_user]);
    }
    header('Location: profilpage.php');
    die();
} else {
    echo "Error.";
}
?>
