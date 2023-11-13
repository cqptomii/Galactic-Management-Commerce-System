<?php session_start();
$USER = $_SESSION['username'] ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="./mise_en_forme.css" />
    <title>Mission started</title>
</head>

<body id="backColor">
    <?php
    // link our DataBase
    $bdd = new PDO("mysql:host=localhost;dbname=projet1;charset=utf8", 'root', "");

    if (isset($_POST['submitMission'])) {
        // GET ALL THE INFO FROM THE MISSION WHO IS IN QUEUE
        $missionName = $_POST['MissionName'];
        $spaceShipUse = $_POST['spaceShip'];
        $playerUse = $_POST['perso'];
        $fuelNeeded = $_POST['missionFuel'];
        $req = $bdd->prepare("SELECT e1.fuel,vaisseau.id_vaisseau,profile.id_user FROM vaisseau INNER JOIN equipe_vaisseau e1 ON e1.id_vaisseau=vaisseau.id_vaisseau INNER JOIN profile ON e1.id_user=profile.id_user WHERE vaisseau.name=?;");
        $req->execute([$spaceShipUse]);
        $fuelSpaceShip = $req->fetch();

        // GET Mission Conditions

        $req = $bdd->prepare("SELECT vaisseau.name,planete.fuel FROM mission INNER JOIN planete ON planete.id_planete=mission.id_planete INNER JOIN vaisseau ON vaisseau.id_vaisseau=mission.id_vaisseau WHERE mission.name=?;");
        $req->execute([$missionName]);
        $missionCaracs = $req->fetch();
        $req = $bdd->prepare("SELECT personnage.name FROM mission INNER JOIN personnage ON mission.id_skill=personnage.id_skill WHERE mission.name=?;");
        $req->execute([$missionName]);
        $persoCarac=$req->fetch();
        // Verification des conditions necessaire afin de réaliser la mission

        if ((($fuelSpaceShip['fuel'] >= $fuelNeeded && $spaceShipUse == $missionCaracs['name'])
            || ($fuelSpaceShip['fuel'] >= $fuelNeeded && $spaceShipUse != $missionCaracs['name'])) && ($playerUse == $persoCarac['name'])) {

            // GET MISSION REWARD AND PROFILE DATA

            $req = $bdd->prepare("SELECT reward.gold,reward.metal,reward.EXP FROM reward INNER JOIN mission ON mission.id_mission=reward.id_mission WHERE mission.name=?;");
            $req->execute([$missionName]);
            $reward = $req->fetch();
            $req = $bdd->prepare("SELECT profile.EXP,profile.gold,profile.metal,profile.niveau FROM profile WHERE username=?;");
            $req->execute([$USER]);
            $userData = $req->fetch();

            //UPDATE USER PROFILE ( EXP + Or + metal + level UP( if he have enough EXP ) )

            $updatedOr = $userData['gold'] + $reward['gold'];
            $updatedMetal = $userData['metal'] + $reward['metal'];
            $updatedEXP = $userData['EXP'] + $reward['metal'];
            $updatedLvl = $userData['niveau'];
            if ($updatedEXP >= ($userData['niveau'] * 10)) {
                $updatedEXP = $userData['EXP'] - (($userData['niveau']-1) * 10);
                $updatedLvl = $userData['niveau'] + 1;
            }
            $req = $bdd->prepare("UPDATE profile SET profile.EXP=$updatedEXP,profile.gold=$updatedOr,profile.metal=$updatedMetal,profile.niveau=$updatedLvl WHERE profile.username=?;");
            $req->execute([$USER]);

            //UPDATE FUEL OF SPACESHIP USE
            $updateFuel=$fuelSpaceShip['fuel']-$fuelNeeded;
            $req= $bdd->prepare("UPDATE equipe_vaisseau set equipe_vaisseau.fuel=? WHERE equipe_vaisseau.id_user=? AND equipe_vaisseau.id_vaisseau=?");
            $req->execute([$updateFuel,$fuelSpaceShip['id_user'],$fuelSpaceShip['id_vaisseau']]);

            //
            //END OF ALL UPDATE
            //

            //UPDATE MISSION LOG
            $req = $bdd->prepare("SELECT name,id_mission FROM mission WHERE name=?;");
            $req->execute([$missionName]);
            $IdMission = $req->fetch();
    ?>
            <div id="ConfirmMission">
                <div id="ConfirmBox">
                    <p>Well done ! you finished the mission : <strong><?php echo $missionName ?></strong></p>
                </div>
                <a href="loadingFile.php">
                    <p id="mCreate">Play Area</p>
                </a>
            </div>
        <?php } else { ?>
            <div id="ConfirmMission">
                <div id="ConfirmBox">
                    <?php if($spaceShipUse != $missionCaracs['name']){?>

                    <p>You cannot do this mission for now, Because you don't have the right spaceship or the right crewmate...</p>
                    <?php }else {
                        if($fuelSpaceShip['fuel'] >= $fuelNeeded){
                    ?>
                    <p> Maybe your spaceship doesn't have enough fuel capacity !</p>
                    <?php }}?>
                </div>
                <a href="name.php">
                    <p id="mCreate">Play Area</p>
                </a>
            </div>

            <?php
        }
    }
    // CREATION MISSION -> UPDATE DATABASE
    if (isset($_POST['CreateMission'])) {

        // GET MISSION DATA

        $missionName = $_POST['name'];
        $description = $_POST['descriptionMission'];
        $EXP = $_POST['experience'];
        $gold = $_POST['goldMission'];
        $silver = $_POST['silver'];
        $cost = $gold + $silver + $EXP;
        $planeteData = $_POST['planete'];
        $req= $bdd->prepare("SELECT planete.fuel FROM planete WHERE planete.planete=?;");
        $req->execute([$planeteData]);
        $fuelNeeded = $req->fetch();
        $req = $bdd->prepare("SELECT vaisseau.fuel FROM vaisseau WHERE vaisseau.name=?;");
        $req->execute([$_POST['spaceship']]);
        $fuelSpaceShip = $req->fetch();
        $req = $bdd->prepare("SELECT profile.gold FROM profile WHERE username=?;");
        $req->execute([$USER]);
        $currentGold = $req->fetch();
        // VERIFY THE POSSIBILITY TO CREATE THE MISSIONS

        if ($fuelSpaceShip['fuel'] >= $fuelNeeded['fuel']) {
            if ($currentGold >= $cost) {


                // ADD NEW MISSION
                $req = $bdd->prepare("SELECT id_vaisseau FROM vaisseau WHERE name=?;");
                $req->execute([$_POST['spaceship']]);
                $spaceShipUse = $req->fetch();
                $req = $bdd->prepare("SELECT id_skill FROM skill WHERE skills=?;");
                $req->execute([$_POST['skill']]);
                $playerUse = $req->fetch();
                $req = $bdd->prepare("SELECT id_planete FROM planete WHERE planete=?;");
                $req->execute([$planeteData]);
                $planete = $req->fetch();
                $req = $bdd->prepare("INSERT INTO mission (mission.name,mission.description,mission.id_vaisseau,mission.id_skill,mission.id_planete,mission.commu,mission.creator) VALUES (?,?,?,?,?,?,?);");
                $req->execute([$missionName,$description,$spaceShipUse[0],$playerUse[0],$planete[0],1,$USER]);

                // ADD REWARDS RELATED TO THE NEW MISSION

                $req = $bdd->prepare("INSERT INTO reward (reward.gold,reward.metal,reward.EXP) VALUES ($gold,$EXP,$silver);");
                $req->execute();

                //UPDATE currentgold of the user

                $currentGold[0] = $currentGold[0] - $cost;
                $req = $bdd->prepare("UPDATE profile SET profile.gold=?;");
                $req->execute([$currentGold[0]]);
            ?>
                <div id="ConfirmMission">
                    <div id="ConfirmBox">
                        <p>The Mission <strong><?php echo $missionName ?></strong> was succesfully created !</p><br />
                    </div>
                    <a href="name.php">
                        <p id="mCreate">Play Area</p>
                    </a>
                </div>
            <?php
            } else { ?>
                <div id="ConfirmMission">
                    <div id="ConfirmBox">
                        <p>You cannot create this mission for now, Because you don't have enough gold ...</p><br />
                        <a href="name.php">
                            <p id="mCreate">Play Area</p>
                        </a>
                    </div>
                <?php
            }
        } else { ?>
                <div id="ConfirmMission">
                    <div id="ConfirmBox">
                        <p>You cannot create this mission for now, Because mission options are impossible ...</p><br />
                    </div>
                    <a href="name.php">
                        <p id="mCreate">Play Area</p>
                    </a>
                </div>
        <?php
        }
    }
        ?>
</body>

</html>