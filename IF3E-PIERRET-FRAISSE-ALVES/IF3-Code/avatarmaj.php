<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['avatar'])) {
        $avatarName = pathinfo($_POST['avatar'], PATHINFO_FILENAME); // Récupérer le nom de fichier sans extension
        $_SESSION['avatar'] = $avatarName;
    }
    // Redirection direct a la page profil
    header('Location: profilpage.php');
    die();
}
?>
