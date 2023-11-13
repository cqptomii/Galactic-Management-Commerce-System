<?php session_start();
$USER=$_SESSION['username']?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="./mise_en_forme.css"/>
    <title>Buying Spaceship</title>
</head>
<body id="backColor">
<div class="blochaut">
    <form id="blochaut">
        <div class="nav">
            <header>
                <img class="logo" src="image/logo.png" alt="logo">
                <nav>
                    <ul class="nav_links">
                        <li><a href="profilpage.php">Profil</a> </li>
                        <li><a href="shopSpaceship.php">Boutique Vaisseaux</a> </li>
                        <li><a href="shopPlayer.php">Boutique PNJ</a> </li>
                        <li><a href="name.php">Espace de Jeu</a> </li>
                    </ul>
                </nav>
                <a class="cta" href="connexionpage.html">Se déconnecter</a>
            </header>
        </div>
    </form>
</div>
<?php
// link the database
$bdd = new PDO("mysql:host=localhost;dbname=projet1;charset=utf8", 'root', "");
if(isset($_POST['buySpaceship'])) {
    // Get the spaceship's useful information
    $spaceshipName=$_POST['spaceshipName'];
    $spaceshipPrice = $_POST['spaceshipPrice'];

    $req = $bdd->prepare("SELECT vaisseau.id_vaisseau,vaisseau.fuel FROM vaisseau WHERE vaisseau.name=?;");
    $req->execute([$spaceshipName]);
    $spaceshipId = $req->fetch();

    // Get the user amount of gold and id
    $req5=$bdd->prepare("SELECT profile.id_user,profile.gold FROM profile WHERE profile.username=?;");
    $req5->execute([$USER]);
    $caracUSER=$req5->fetch();


    //Checks if the user's already have the spaceship
    $req=$bdd->prepare("Select vaisseau.id_vaisseau FROM equipe_vaisseau ev INNER JOIN profile ON profile.id_user=ev.id_user 
        INNER JOIN vaisseau ON vaisseau.id_vaisseau=ev.id_vaisseau WHERE profile.username=? AND vaisseau.name=?");
    $req->execute([$USER,$spaceshipName]);
    $Verification=$req->fetch();

    //Checks if the user's has enough money
    if(!$Verification){
    if($caracUSER['gold']>=$spaceshipPrice ){
        $req3= $bdd->prepare("INSERT INTO equipe_vaisseau (id_user,id_vaisseau,fuel) VALUES (?, ?,?);");
        $req3->execute([$caracUSER['id_user'],$spaceshipId['id_vaisseau'],$spaceshipId['fuel']]);
        $req3->fetch();

        $userfinalGold=$caracUSER['gold']-$spaceshipPrice;
        $req4= $bdd->prepare("UPDATE profile SET gold=$userfinalGold WHERE profile.username=?;");
        $req4->execute([$USER]);
        $req4->fetch();

    ?>
    <div id="ConfirmMission">
        <div id="ConfirmBox">
            <p>Well done ! You just bought the spaceship !</p>
        </div>
        <a href="shopSpaceship.php" ><p id="mCreate">Spaceship shop</p> </a>
    </div>
<?php
    }}
    else{
        ?>
        <div id="ConfirmMission">
            <div id="ConfirmBox">
                <p>You cannot buy this spaceship for now</p><br />
                <p>Maybe you already own it or don't have enough money</p>
            </div>
            <a href="shopSpaceship.php">
                <p id="mCreate">Boutique Vaisseaux</p>
            </a>
        </div>
<?php
    }
}
?>
</body>
</html>
