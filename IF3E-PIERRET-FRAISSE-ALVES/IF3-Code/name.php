<?php session_start();
$USER = $_SESSION['username'] ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="./mise_en_forme.css" />
    <title>Play area</title>
</head>

<body id="backColor">

    <?php
    $bdd = new PDO("mysql:host=localhost;dbname=projet1;charset=utf8", 'root', "");
    header('refresh: 60;url=namepage.php');
    //GET number of spaceship which belongs to USER
    $req= $bdd->prepare("SELECT COUNT(*) FROM equipe_vaisseau INNER JOIN profile ON profile.id_user=equipe_vaisseau.id_user WHERE profile.username=?;");
    $req->execute([$_SESSION['username']]);
    $UpdateFuel=$req->fetch();

    //GET ID FROM USER
    $req= $bdd->prepare("SELECT profile.id_user FROM profile WHERE profile.username=?;");
    $req->execute([$_SESSION['username']]);
    $idUSER=$req->fetch();

    $space1=$bdd->prepare("SELECT fuel FROM equipe_vaisseau ev INNER JOIN profile ON profile.id_user=ev.id_user WHERE profile.id_user=? AND ev.id_vaisseau=1;");
    $space1->execute([$idUSER[0]]);
    $ship1=$space1->fetch();
    if($ship1 ){
        if($ship1['fuel']+10<=100){
            $req=$bdd->prepare("UPDATE equipe_vaisseau SET equipe_vaisseau.fuel= equipe_vaisseau.fuel+10
                                                                         WHERE equipe_vaisseau.id_user=$idUSER[0] AND equipe_vaisseau.fuel=? AND equipe_vaisseau.id_vaisseau=1;");
            $req->execute([$ship1['fuel']]);
        }
    }

    $space=$bdd->prepare("SELECT fuel FROM equipe_vaisseau ev INNER JOIN profile ON profile.id_user=ev.id_user WHERE profile.id_user=? AND ev.id_vaisseau=2;");
    $space->execute([$idUSER[0]]);
    $ship2=$space->fetch();
    if($ship2 ){
        if($ship2['fuel']+10<=250){
            $req=$bdd->prepare("UPDATE equipe_vaisseau SET equipe_vaisseau.fuel= equipe_vaisseau.fuel+10
                                                                         WHERE equipe_vaisseau.id_user=$idUSER[0] AND equipe_vaisseau.fuel=? AND equipe_vaisseau.id_vaisseau=2;");
            $req->execute([$ship2['fuel']]);
        }
    }

    $space=$bdd->prepare("SELECT fuel FROM equipe_vaisseau ev INNER JOIN profile ON profile.id_user=ev.id_user WHERE profile.id_user=? AND ev.id_vaisseau=3;");
    $space->execute([$idUSER[0]]);
    $ship3=$space->fetch();
    if($ship3 ){
        if($ship3['fuel']+10<=500){
            $req=$bdd->prepare("UPDATE equipe_vaisseau SET equipe_vaisseau.fuel= equipe_vaisseau.fuel+10
                                                                         WHERE equipe_vaisseau.id_user=$idUSER[0] AND equipe_vaisseau.fuel=? AND equipe_vaisseau.id_vaisseau=3;");
            $req->execute([$ship3['fuel']]);
        }
    }
    //END  UPDATE
    ?>
        <div class="Boxes">
            <div class="blochaut">
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
                        <a class="cta" href="connexionpage.html">Disconnect</a>
                    </header>
                </div>
            </div>
            <div class="selectMission">
                <div class="createMission">
                    <a href="Create%20Mission.php">
                        <p id="mCreate"> Create Mission </p>
                    </a>
                </div>
                <div id="missionExplorer">
                    <p class="title "> <strong>Select Mission Name</strong> </p><br />

                    <form action="name.php" method="post">
                        <select name="missions" class="SelectName">
                            <option disabled="disabled" value="basicMission" class="sep"><strong>Basic Mission</strong></option>
                            <?php
                            $req = $bdd->prepare("SELECT COUNT(*) FROM mission WHERE commu=0;");
                            $req->execute();
                            $taille = $req->fetch();
                            for ($line = 1; $line <= $taille["COUNT(*)"]; $line = $line + 1) :
                                $req = $bdd->prepare("SELECT name FROM mission WHERE id_mission=? AND mission.commu=0");
                                $req->execute([$line]);
                                $names = $req->fetch();
                            ?>
                                <option value="<?php echo $names["name"] ?>"> <?php echo $names["name"] ?> </option>
                            <?php endfor; ?><br />
                            <option disabled="disabled" value="commuMission" class="sep"><strong>Community Mission</strong></option>
                            <?php
                            $req = $bdd->prepare("SELECT COUNT(*) FROM mission WHERE commu=1;");
                            $req->execute();
                            $MissionCommuTaille = $req->fetch();
                            $req = $bdd->prepare("SELECT name FROM mission WHERE mission.commu=1");
                            $req->execute();
                            $namesMissionCommu = $req->fetch();
                            for ($line = 0; $line < $MissionCommuTaille["COUNT(*)"]; $line = $line + 1) :
                                ?>
                                <option value="<?php echo $namesMissionCommu[$line] ?>"> <?php echo $namesMissionCommu[$line] ?> </option>
                            <?php endfor; ?><br />
                            <input type="submit" value="Select" name="submit" class="submit" />
                            <?php if (isset($_POST['submit'])) {
                                $missionName = $_POST['missions'];
                                $req = $bdd->prepare("SELECT mission.description,planete.planete,skills,planete.fuel,reward.EXP,reward.gold,reward.metal,vaisseau.name,mission.creator FROM mission INNER JOIN reward ON mission.id_mission=reward.id_mission INNER JOIN planete on mission.id_planete=planete.id_planete INNER JOIN skill ON mission.id_skill=skill.id_skill INNER JOIN vaisseau ON mission.id_vaisseau=vaisseau.id_vaisseau  WHERE mission.name = ?;");
                                $req->execute([$missionName]);
                                $caracs = $req->fetch();
                            ?>
                        </select>
                        <div id="caracForm">
                            <div id="infoUser">
                                <label for="nameMission">name</label>
                                <label for="">Creator</label>
                                <label for="Purpose">description</label>
                                <label for="planete">planete</label>
                                <label for="Skill">MissionType</label>
                                <label for="Spaceship">Spaceship</label>
                                <label for="fuelToGo">fuel to explore</label>
                                <label for="ExpEarn">Experience</label>
                                <label for="GoldEarn">Gold</label>
                                <label for="SilverEarn">Silver</label>
                            </div>
                            <div id="response">
                                <input type="text" name="nameMission" value="<?php echo $missionName ?>" class="MissionCarac" disabled="disabled" />
                                <input type="text" name="creator" value="<?php echo $caracs['creator'] ?>"  class="MissionCarac" disabled="disabled">
                                <input type="text" name="Purpose" value="<?php echo $caracs['description'] ?>" class="MissionCarac" disabled="disabled" />
                                <input type="text" name="planete" value="<?php echo $caracs['planete'] ?>" class="MissionCarac" disabled="disabled" />
                                <input type="text" name="Skill" value="<?php echo $caracs['skills'] ?>" class="MissionCarac" disabled="disabled" />
                                <input type="text" name="Spaceship" value="<?php echo $caracs['name'] ?>" class="MissionCarac" disabled="disabled" />
                                <input type="text" name="fuelToGo" value="<?php echo $caracs['fuel'] ?>" class="MissionCarac" disabled="disabled" />
                                <input type="text" name="ExpEarn" value="<?php echo $caracs['EXP'] ?>" class="MissionCarac" disabled="disabled" />
                                <input type="text" name="GoldEarn" value="<?php echo $caracs['gold'] ?>" class="MissionCarac" disabled="disabled" />
                                <input type="text" name="SilverEarn" value="<?php echo $caracs['metal'] ?>" class="MissionCarac" disabled="disabled" />
                            </div>
                        </div>
                    <?php
                            }
                    ?>
                    </form>
                    <?php if (isset($_POST['submit'])) {
                    ?>
                        <form method="post" action="ConfirmMission.php">
                            <?php
                            $req = $bdd->prepare("SELECT DISTINCT COUNT(*) FROM equipe_vaisseau INNER JOIN profile ON profile.id_user=equipe_vaisseau.id_user WHERE profile.username= ?;");
                            $req->execute([$USER]);
                            $NBspaceShip = $req->fetch();
                            $req2 = $bdd->prepare("SELECT DISTINCT COUNT(*) FROM equipe_personnage INNER JOIN profile ON profile.id_user=equipe_personnage.id_user WHERE profile.username= ?;");
                            $req2->execute([$USER]);
                            $NBperso = $req2->fetch();
                            ?>
                            <label for="spaceShip" id="labelSelect"> Choose Spaceship</label>
                            <select name="spaceShip" class="selectEquip">
                                <?php $ship1= $bdd->prepare("SELECT vaisseau.name,ev.fuel FROM equipe_vaisseau ev INNER JOIN profile ON profile.id_user=ev.id_user INNER JOIN vaisseau ON vaisseau.id_vaisseau=ev.id_vaisseau WHERE profile.username=? AND ev.id_vaisseau=1;");
                                      $ship2= $bdd->prepare("SELECT vaisseau.name,ev.fuel FROM equipe_vaisseau ev INNER JOIN profile ON profile.id_user=ev.id_user INNER JOIN vaisseau ON vaisseau.id_vaisseau=ev.id_vaisseau WHERE profile.username=? AND ev.id_vaisseau=2;");
                                      $ship3= $bdd->prepare("SELECT vaisseau.name,ev.fuel FROM equipe_vaisseau ev INNER JOIN profile ON profile.id_user=ev.id_user INNER JOIN vaisseau ON vaisseau.id_vaisseau=ev.id_vaisseau WHERE profile.username=? AND ev.id_vaisseau=3;");
                                      $ship1->execute([$USER]);
                                      $ship2->execute([$USER]);
                                      $ship3->execute([$USER]);
                                      $Val1=$ship1->fetch();
                                      $Val2=$ship2->fetch();
                                      $Val3=$ship3->fetch();
                                      if($Val1){ ?>
                                             <option value="<?php echo $Val1['name'] ?>"> <?php echo $Val1['name'], " ------- Fuel ------- ", $Val1['fuel'] ?> </option>
                                      <?php }
                                      if($Val2){ ?>
                                          <option value="<?php echo $Val2['name'] ?>"> <?php echo $Val2['name'], " ------- Fuel ------- ", $Val2['fuel'] ?> </option>
                                          <?php
                                      }
                                      if($Val3){ ?>
                                          <option value="<?php echo $Val3['name'] ?>"> <?php echo $Val3['name'], " ------- Fuel ------- ", $Val3['fuel'] ?> </option>
                                          <?php
                                      }
                                ?>
                            </select>

                            <br /><label for="perso" id="labelSelect"> Choose Player</label>
                            <select name="perso" class="selectEquip2">
                                <?php $ship1= $bdd->prepare("SELECT personnage.name,skill.skills FROM equipe_personnage ep INNER JOIN profile ON profile.id_user=ep.id_user INNER JOIN personnage ON personnage.id_personnage=ep.id_personnage INNER JOIN skill ON skill.id_skill=personnage.id_skill WHERE profile.username=? AND ep.id_personnage=1;");
                                $ship2= $bdd->prepare("SELECT personnage.name,skill.skills FROM equipe_personnage ep INNER JOIN profile ON profile.id_user=ep.id_user INNER JOIN personnage ON personnage.id_personnage=ep.id_personnage INNER JOIN skill ON skill.id_skill=personnage.id_skill WHERE profile.username=? AND ep.id_personnage=2;");
                                $ship3= $bdd->prepare("SELECT personnage.name,skill.skills FROM equipe_personnage ep INNER JOIN profile ON profile.id_user=ep.id_user INNER JOIN personnage ON personnage.id_personnage=ep.id_personnage INNER JOIN skill ON skill.id_skill=personnage.id_skill WHERE profile.username=? AND ep.id_personnage=3;");
                                $ship1->execute([$USER]);
                                $ship2->execute([$USER]);
                                $ship3->execute([$USER]);
                                $Val1=$ship1->fetch();
                                $Val2=$ship2->fetch();
                                $Val3=$ship3->fetch();
                                if($Val1){ ?>
                                    <option value="<?php echo $Val1['name'] ?>"> <?php echo $Val1['name'], " ------- Skill ------- ", $Val1['skills'] ?> </option>
                                <?php }
                                if($Val2){ ?>
                                    <option value="<?php echo $Val2['name'] ?>"> <?php echo $Val2['name'], " ------- Skill ------- ", $Val2['skills'] ?> </option>
                                    <?php
                                }
                                if($Val3){ ?>
                                    <option value="<?php echo $Val3['name'] ?>"> <?php echo $Val3['name'], " ------- Skill ------- ", $Val3['skills'] ?> </option>
                                    <?php
                                }
                                ?>
                            </select>
                            <?php $req=$bdd->prepare("SELECT planete.fuel FROM planete INNER JOIN mission ON mission.id_planete=planete.id_planete WHERE mission.name=?;");
                                  $req->execute([$missionName]);
                                  $fuelToGo=$req->fetch();
                            ?>
                            <input type="hidden" name="missionFuel" value="<?php echo $fuelToGo[0] ?>">
                            <input type="hidden" name="MissionName" value="<?php echo $missionName; ?>" />
                            <input type="submit" value="Submit mission" class="submit" name="submitMission">
                        </form>
                    <?php
                    } ?>
                </div>
            </div>


        </div>
</body>

</html>