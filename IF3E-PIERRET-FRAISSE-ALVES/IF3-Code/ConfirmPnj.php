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
if(isset($_POST['Hire'])) {
    // Get the pnj useful information
    $pnjName=$_POST['pnjName'];
    $pnjSkill=$_POST['pnjSkill'];
    $pnjPrice=$_POST['pnjPrice'];

    $req5=$bdd->prepare("SELECT id_personnage FROM personnage WHERE name=?;");
    $req5->execute([$pnjName]);
    $pnjId= $req5->fetch();
    //GET information about PNJ
    $req = $bdd->prepare("SELECT personnage.id_skill,personnage.name,personnage.id_personnage FROM personnage INNER JOIN skill ON skill.id_skill=personnage.id_skill WHERE skills=?;");
    $req->execute([$pnjSkill]);
    $skillId = $req->fetch();

    // Get the user amount of gold and id
    $req5=$bdd->prepare("SELECT id_user,gold FROM profile WHERE username=?;");
    $req5->execute([$USER]);
    $caracUSER=$req5->fetch();

    //Checks if the user's already have the spaceship
    $req=$bdd->prepare("Select personnage.id_personnage FROM equipe_personnage ep INNER JOIN profile ON profile.id_user=ep.id_user 
        INNER JOIN personnage ON personnage.id_personnage=ep.id_personnage WHERE profile.username=? AND personnage.name=?");
    $req->execute([$USER,$pnjName]);
    $Verification=$req->fetch();
    //Checks if the user's has enough money
    if(!$Verification){
    if($caracUSER['gold']>=$pnjPrice){
        $req3= $bdd->prepare("INSERT INTO equipe_personnage (id_user,id_personnage,id_skill) VALUES (?,?,?);");
        $req3->execute([$caracUSER['id_user'],$skillId['id_personnage'],$skillId['id_skill']]);
        $req3->fetch();

        $userfinalGold=$caracUSER['gold']-$pnjPrice;

        $req4= $bdd->prepare("UPDATE profile SET gold=$userfinalGold WHERE profile.username=?;");
        $req4->execute([$USER]);
        $req4->fetch();
        ?>
        <div id="ConfirmMission">
            <div id="ConfirmBox">
                <p>Well done ! You just bought a PNJ !</p>
            </div>
            <a href="shopPlayer.php" ><p id="mCreate">PNJ shop</p> </a>
        </div>
        <?php
    }}
    else{
        ?>
        <div id="ConfirmMission">
            <div id="ConfirmBox">
                <p>You cannot buy this pnj for now.<br /> Maybe you already own it or don't have enough money</p>
            </div>
            <a href="shopPlayer.php">
                <p id="mCreate">Boutique PNJ</p>
            </a>
        </div>
        <?php
    }
}
?>
</body>
</html>
