<?php session_start();
$USER=$_SESSION['username']?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="mise_en_forme.css"/>
    <title>PNJ Shop</title>
</head>
<body id="backColor">
<?php
$bdd = new PDO("mysql:host=localhost;dbname=projet1;charset=utf8", 'root', "");
$req= $bdd->prepare("SELECT COUNT(*) FROM personnage");
$req->execute();
$taille = $req->fetch();
?>
<div class="Boxes">

    <div class="blochaut">
        <form id="blochaut">
            <div class="nav">
                <header>
                    <img class="logo" src="image/logo.png" alt="logo">
                    <nav>
                        <ul class="nav_links">
                            <li><a href="profilpage.php">Profile</a> </li>
                            <li><a href="shopSpaceship.php">Spaceship Shop</a> </li>
                            <li><a href="shopPlayer.php">PNJ Shop</a> </li>
                            <li><a href="name.php">Play area</a> </li>
                        </ul>
                    </nav>
                    <a class="cta" href="connexionpage.php">Disconnect</a>
                </header>
            </div>
        </form>
    </div>
    <div id="missionExplorer">
        <p class="title "> <strong>Select PNJ Name</strong> </p><br/>

        <form action="shopPlayer.php" method="post">
            <select name="personnage" class="SelectName">
                <?php for ($line=1;$line <= $taille["COUNT(*)"]; $line=$line + 1):
                    $req= $bdd->prepare("SELECT name FROM personnage WHERE id_personnage=?");
                    $req->execute([$line]);
                    $names= $req ->fetch();
                    ?>
                    <option value="<?php echo $names["name"]?>"> <?php echo $names["name"] ?> </option>
                <?php endfor; ?><br/>
                <br>

                <input type="submit" value="Select" name="submit" class="submit"/>
                <?php if(isset($_POST['submit'])){
                $pnjName=$_POST['personnage'];
                $req= $bdd->prepare("SELECT personnage.name,personnage.price, skill.skills FROM personnage INNER JOIN skill ON skill.id_skill=personnage.id_skill WHERE personnage.name=?;");
                $req->execute([$pnjName]);
                $caracs= $req->fetch();
                ?>
            </select>
            <div id="caracForm">
                <div id="infoUser">
                    <label for="namePnj">Name</label>
                    <label for="price" class="price">Hiring price</label>
                    <label for="skill">Skill</label>
                </div>
                <div id="response">
                    <input type="text" name="namePnj" value="<?php echo $pnjName ?>" class="MissionCarac" disabled="disabled"/>
                    <input type="text" name="HiringPrice"  value="<?php echo $caracs['price'] ?>" class="MissionCarac" disabled="disabled"/>
                    <input type="text" name="skill" value="<?php echo $caracs['skills'] ?>" class="MissionCarac" disabled="disabled"/>
                </div>
            </div>
            <?php
            }
            ?>

        </form>
        <br>
        <?php if(isset($_POST['submit'])){
            ?>
            <form method="post" action="ConfirmPnj.php">
                <input type="hidden" name="pnjSkill" value="<?php echo $caracs['skills']?>">
                <input type="hidden" name="pnjPrice" value="<?php echo $caracs['price']?>">
                <input type="hidden" name="pnjName" value="<?php echo $pnjName;?>"/>
                <input type="submit" value="Hire" class="submit" name="Hire">
            </form>
            <?php
        }?>
    </div>


</body>
</html>

