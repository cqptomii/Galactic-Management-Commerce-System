<?php
session_start()
?>


<!DOCTYPE html>
<html>
<head>
    <title>Sélection d'avatar</title>
    <link rel="stylesheet" href="avatarchange.css">
</head>
<body>
<form method="POST" action="avatarmaj.php">
<div class="conteneur">
    <div class="gros-bloc">
        <?php
        $avatarPath = "image/avatar/";
        $avatarCount = 10;
        for ($i = 1; $i <= $avatarCount; $i++) {
            $avatar = $avatarPath . "avatar" . $i . ".jpg";
            echo '<div class="avatar-bloc">';
            echo '<img src="' . $avatar . '" alt="Avatar ' . $i . '">';
            echo '<input type="radio" name="avatar" value="' . $avatar . '">';
            echo '</div>';
        }
        ?>
    </div>
    <button>Soumettre</button>
</div>
</body>
</html>
