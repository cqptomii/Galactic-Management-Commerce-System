<?php session_start();
$USER=$_SESSION['username']?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="mise_en_forme.css"/>
    <title>Space Shop</title>
</head>
<body id="backColor">
<?php
$bdd = new PDO("mysql:host=localhost;dbname=projet1;charset=utf8", 'root', "");
$req= $bdd->prepare("SELECT COUNT(*) FROM vaisseau");
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
        <p class="title "> <strong>Select Spaceship Name</strong> </p><br/>

        <form action="shopSpaceship.php" method="post">
            <select name="vaisseaux" class="SelectName">
                <?php for ($line=1;$line <= $taille["COUNT(*)"]; $line=$line + 1):
                    $req= $bdd->prepare("SELECT name FROM vaisseau WHERE id_vaisseau=?");
                    $req->execute([$line]);
                    $names= $req ->fetch();
                    ?>
                    <option value="<?php echo $names["name"]?>"> <?php echo $names["name"] ?> </option>
                <?php endfor; ?><br/>
                <br>

                <input type="submit" value="Select" name="submit" class="submit"/>
                <?php if(isset($_POST['submit'])){
                $spaceshipName=$_POST['vaisseaux'];
                $req= $bdd->prepare("SELECT name, price, fuel, description FROM vaisseau WHERE name=?;");
                $req->execute([$spaceshipName]);
                $caracs= $req->fetch();
                ?>
            </select>
            <div id="caracForm">
                <div id="infoUser">
                    <label for="nameSpaceship">Name</label>
                    <label for="Price" class="price">Buying price</label>
                    <label for="fuelToGo">Fuel Capacity</label>
                    <label for="description">Description</label>

                </div>
                <div id="response">
                    <input type="text" name="spaceshipName" value="<?php echo $spaceshipName ?>" class="MissionCarac" disabled="disabled"/>
                    <input type="text" name="Price"  value="<?php echo $caracs['price'] ?>" class="MissionCarac" disabled="disabled"/>
                    <input type="text" name="fuelToGo" value="<?php echo $caracs['fuel'] ?>" class="MissionCarac" disabled="disabled"/>
                    <input type="text" name="description" value="<?php echo $caracs['description'] ?>" class="MissionCarac" disabled="disabled"/>

                </div>
            </div>
            <?php
            }
            ?>

        </form>
        <br>
        <?php if(isset($_POST['submit'])){
            ?>
            <form method="post" action="ConfirmSpaceship.php">

                <input type="hidden" name="spaceshipName" value="<?php echo $caracs['name']?>">
                <input type="hidden" name="spaceshipPrice" value="<?php echo $caracs['price'];?>"/>
                <input type="submit" value="Buy" class="submit" name="buySpaceship">
            </form>
            <?php
        }?>
    </div>

</body>
</html>

