<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="./mise_en_forme.css" />
    <title>Mission started</title>
</head>

<body>
    <div id="CreateMission" class="general">
        <div class="blochaut">
            <div class="nav">
                <header>
                    <img class="logo" src="image/logo.png" alt="logo">
                    <nav>
                        <ul class="nav_links">
                            <li><a href="profilpage.php">Profil</a> </li>
                            <li><a href="#">Boutique</a> </li>
                            <li><a href="name.php">Espace de Jeu</a> </li>
                        </ul>
                    </nav>
                    <a class="cta" href="connexionpage.html">Se déconnecter</a>
                </header>
            </div>

        </div>
        <form action="ConfirmMission.php" method="post" id="MissionEditor">
            <div class="createmission" <p id="title"> Mission Editor </p>
                <div class="insideform">
                    <label for="name">Name</label>
                    <input type="text" name="name" value="Mission name" />
                </div>
                <div class="insideform">
                    <label for="descriptionMission">Description</label>
                    <input type="text" name="descriptionMission" value="Description" />
                </div>
                <div class="insideform">
                    <label for="planete">Planete</label>
                    <select name="planete">
                        <?php
                        $bdd = new PDO("mysql:host=localhost;dbname=projet1;charset=utf8", 'root', "");
                        $req = $bdd->prepare("SELECT COUNT(*) FROM planete;");
                        $req->execute();
                        $nbPlanete = $req->fetch();
                        for ($line = 1; $line <= $nbPlanete["COUNT(*)"]; $line = $line + 1) :
                            $req = $bdd->prepare("SELECT planete,fuel FROM planete WHERE id_planete=?;");
                            $req->execute([$line]);
                            $planete = $req->fetch();
                        ?>
                            <option value="<?php echo $planete["planete"] ?>"> <?php echo $planete["planete"], " ------- fuel to go ------- ", $planete["fuel"] ?> </option>
                        <?php endfor; ?><br />
                    </select>
                </div>
                <div class="insideform">
                    <label for="missionType">Skill</label>
                    <select name="skill">
                        <?php
                        $req = $bdd->prepare("SELECT COUNT(*) FROM skill;");
                        $req->execute();
                        $nbSkill = $req->fetch();
                        for ($line = 1; $line <= $nbSkill["COUNT(*)"]; $line = $line + 1) :
                            $req = $bdd->prepare("SELECT skills FROM skill WHERE id_skill=?;");
                            $req->execute([$line]);
                            $req->execute([$line]);
                            $skill = $req->fetch();
                        ?>
                            <option value="<?php echo $skill["skills"] ?>"> <?php echo $skill["skills"] ?> </option>
                        <?php endfor; ?><br />
                    </select>
                </div>
                <div class="insideform">
                    <label for="spaceShip">Spaceship</label>
                    <select name="spaceship">
                        <?php
                        $req = $bdd->prepare("SELECT COUNT(*) FROM vaisseau;");
                        $req->execute();
                        $nbSpaceShip = $req->fetch();
                        for ($line = 1; $line <= $nbSpaceShip["COUNT(*)"]; $line = $line + 1) :
                            $req = $bdd->prepare("SELECT name,fuel FROM vaisseau WHERE id_vaisseau=? ;");
                            $req->execute([$line]);
                            $spaceShip = $req->fetch();
                        ?>
                            <option value="<?php echo $spaceShip["name"] ?>"> <?php echo $spaceShip["name"], " ------- fuel capacity ------- ", $spaceShip["fuel"] ?> </option>
                        <?php endfor; ?><br />
                    </select>
                </div>
                <div class="insideform">
                    <label for="experience">Experience</label>
                    <input type="text" name="experience" placeholder="Experience" />
                </div>
                <div class="insideform">
                    <label for="goldMission">Gold</label>
                    <input type="text" name="goldMission" placeholder="Gold " />
                </div>
                <div class="insideform">
                    <label for="silver">metal</label>
                    <input type="text" name="silver" placeholder="amount of metal" />
                </div>
                <div class="insideform">
                    <label for="cost">Creation cost</label>
                    <input type="text" name="cost" value="Price: Quantity(EXP+GOLD+Metal)" disabled="disabled" /><br />
                </div>
                <div class="insideform">
                    <input class="submit" type="submit" name="CreateMission" value="Create Mission" />
                </div>
        </form>
    </div>
    </form>
    </div>
</body>

</html>