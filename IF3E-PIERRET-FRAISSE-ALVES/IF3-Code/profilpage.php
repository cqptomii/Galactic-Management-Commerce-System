    <!DOCTYPE html>
    <html lang="fr">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Profil</title>
        <link rel="stylesheet" href="profilpage.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.13.0/css/all.css">
    </head>

    <body>
        <?php
        session_start();
        $bdd = new PDO("mysql:host=localhost;dbname=projet1;charset=utf8", "root", "");
        $extract = $bdd->prepare("SELECT * FROM profile WHERE username = ?");
        $extract->execute([$_SESSION['username']]);
        $profilData = $extract->fetch();


        header('refresh: 60;url=profilpage.php');
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
            if($ship1['fuel']<100){
                $req=$bdd->prepare("UPDATE equipe_vaisseau SET equipe_vaisseau.fuel= equipe_vaisseau.fuel+10
                                                                         WHERE equipe_vaisseau.id_user=$idUSER[0] AND equipe_vaisseau.fuel=? AND equipe_vaisseau.id_vaisseau=1;");
                $req->execute([$ship1['fuel']]);
            }
        }

        $space=$bdd->prepare("SELECT fuel FROM equipe_vaisseau ev INNER JOIN profile ON profile.id_user=ev.id_user WHERE profile.id_user=? AND ev.id_vaisseau=2;");
        $space->execute([$idUSER[0]]);
        $ship2=$space->fetch();
        if($ship2 ){
            if($ship2['fuel']<250){
                $req=$bdd->prepare("UPDATE equipe_vaisseau SET equipe_vaisseau.fuel= equipe_vaisseau.fuel+10
                                                                         WHERE equipe_vaisseau.id_user=$idUSER[0] AND equipe_vaisseau.fuel=? AND equipe_vaisseau.id_vaisseau=2;");
                $req->execute([$ship2['fuel']]);
            }
        }

        $space=$bdd->prepare("SELECT fuel FROM equipe_vaisseau ev INNER JOIN profile ON profile.id_user=ev.id_user WHERE profile.id_user=? AND ev.id_vaisseau=3;");
        $space->execute([$idUSER[0]]);
        $ship3=$space->fetch();
        if($ship3 ){
            if($ship3['fuel']<500){
                $req=$bdd->prepare("UPDATE equipe_vaisseau SET equipe_vaisseau.fuel= equipe_vaisseau.fuel+10
                                                                         WHERE equipe_vaisseau.id_user=$idUSER[0] AND equipe_vaisseau.fuel=? AND equipe_vaisseau.id_vaisseau=3;");
                $req->execute([$ship3['fuel']]);
            }
        }
        //END  UPDATE

        ?>
        <header>
            <h1>Welcome on your profile, <?php echo $_SESSION['username']; ?> !</h1>
        </header>


        <main>
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
            <div class="blocuvel">
                <div class="blocmidgauche">
                    <div class="blocuser">
                        <form id="blocuser">
                            <div class="avatar">
                                <?php
                                $avatarPath = "./image/avatar/"; // Chemin par défaut
                                $avatar = $avatarPath . $_SESSION['avatar'] . ".jpg";
                                echo '<img src="' . $avatar . '" alt="Avatar">';
                                ?>

                                <a class="cta" href="avatarchange.php">Change avatar</a>
                                <a class="cta" href="modifinfo.html">Change my information</a>
                            </div>
                            <div class="username">
                                <p> Username : <?php echo $_SESSION['username'] ?> </p>
                                <p> Email : <?php echo $_SESSION['mail'] ?> </p>
                                <p> Role : <?php echo $_SESSION['role'] ?> </p>
                            </div>
                        </form>
                    </div>
                    <div class="blocvaisseaux">
                        <form id="blocvaisseaux">
                            <div class="vaisseux_titre">
                                <p>My spaceships:</p>
                            </div>
                            <?php
                            $extractvaisseau = $bdd->prepare("SELECT * FROM vaisseau v INNER JOIN equipe_vaisseau ev ON v.id_vaisseau = ev.id_vaisseau WHERE ev.id_user = ?");
                            $extractvaisseau->execute([$_SESSION['id_user']]);
                            $vaisseau = $extractvaisseau->fetch();
                            ?>
                            <div class="vaisseaux_inventaire">
                                <label class="audessusvaisseau">
                                    <p id="nomvaisseau"><?php echo $vaisseau['name'] ?></p>
                                </label>
                                <label for="vaisseaux_menu"></label>

                                <?php
                                if ($vaisseau['name'] === "A-Wing RZ-2") {
                                    echo '<img src="image/RZ-2.jepg.png" alt="Vaisseau de l\'utilisateur">';
                                } elseif ($vaisseau['name'] === "X-Wing T-70") {
                                    echo '<img src="image/x-ing-t-70.jpg" alt="Vaisseau de l\'utilisateur">';
                                } elseif ($vaisseau['name'] === "Y-Wing BTL") {
                                    echo '<img src="image/Y-Wing-BTL.png" alt="Vaisseau de l\'utilisateur">';
                                }
                                ?>

                                <label class="undervaisseaux">
                                    <p id="vaisseaux_description"><?php echo $vaisseau['description'] ?></p>
                                    <label class="fuelaffiche">
                                        <img src="image/fuel.png">
                                        <p id="nbfuel"><?php echo $vaisseau['fuel'] ?>L</p>
                                    </label>
                                </label>
                            </div>

                        </form>
                    </div>
                </div>
                <div class="blocmiddroite">
                    <div class="blocequipe">
                        <form id="blocequipe">
                            <p id="monequipe">My crew : </p>
                            <div class="equipeavatar">
                                <?php
                                $extractequipe = $bdd->prepare("SELECT * FROM personnage p INNER JOIN equipe_personnage ep ON p.id_personnage = ep.id_personnage WHERE ep.id_user = ?");
                                $extractequipe->execute([$_SESSION['id_user']]);
                                $equipe = $extractequipe->fetchAll(); // On recup tous les equipers

                                // Check if one crewmember exist
                                if ($equipe) {
                                    foreach ($equipe as $equipier) {
                                        echo '<div class="equipieravatar">';
                                        echo '<img src="image/' . $equipier['nameperso'] . '" alt="Avatar equipier">';









                                        $id_skill = $equipier['id_skill'];
                                        $skillQuery = $bdd->prepare("SELECT skills FROM skill WHERE id_skill = ?");
                                        $skillQuery->execute([$id_skill]);
                                        $skill = $skillQuery->fetchColumn();

                                        echo '<p>' . $skill . '</p>';
                                        echo '</div>';
                                    }

                                } else {
                                    echo '<p>No member found</p>';
                                }
                                ?>
                            </div>
                        </form>

                    </div>
                    <div class="bloclevel">
                        <form id="bloclevel">
                            <p>Level and ressources :</p>
                            <div class="ressources"></div>
                            <div class="or">
                                <img src="image/or.png" alt="imageor">
                                <p> GOLD : <?php echo $profilData['gold'] ?></p>

                            </div>
                            <div class="fuel">
                                <img src="image/fer.png" alt="imagefer">
                                <p> METAL : <?php echo $profilData['metal'] ?></p>
                            </div>
                            <div class="niveau">
                                <p>
                                    LEVEL <?php echo $profilData['niveau'] ?>
                                    <br>
                                    EXP : <?php echo $profilData['EXP'] ?>
                                </p>
                            </div>

                        </form>
                    </div>
                </div>
            </div>

        </main>
    </body>

    </html>