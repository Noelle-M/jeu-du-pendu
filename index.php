<?php
session_start();
include "includes/header.php";
include "includes/tables.php";

if (
    !isset($_SESSION['nbre_tours'])
    && !isset($_SESSION['lettres'])
    && !isset($_SESSION['mot'])
) {
    $_SESSION['nbre_tours'] = 0;
    $_SESSION['lettres'] = [];
    $_SESSION['mot'] = [];
}

//melange le tableau des mots
if ($_SESSION['nbre_tours'] == 0) {
    shuffle($mots);
    foreach ($mots as $mot) {
        $mot;
    }
    //copie du tableau des mots dans session mot
    $_SESSION['mot'] = $mot;
}
$mot_choisi_to_upper = strtoupper($_SESSION['mot']);
$mot_choisi = str_split($mot_choisi_to_upper);
?>
<main class="mt-5">
    <div class="row mt-5 w-75 ml-auto mr-auto">
        <div class="col-7">
            <div class="intro w-75 ml-auto mr-auto">
                <h2>Régles du jeu</h2>
                <p>
                    Le but du jeu est de trouver le mot avant que le dessin ne soit fini.<br>
                    Pour cela, tapez une lettre dans le champ "Lettre", appuyez sur la touche entrée de votre clavier.<br>
                    Si celle-ci existe dans le mot, elle s'affichera alors à la bonne place, sinon, elle s'affichera sous le dessin afin de la garder en mémoire et ne pas la rejouer.
                </p>
            </div>
            <hr>
            <div class="row w-75 ml-auto mr-auto justify-content-center mt-5 mb-5 mb-5">
                <?php
                foreach ($mot_choisi as $lettre) {
                    echo '<div class="col col-lettre">';
                    if (in_array($lettre, $_SESSION['lettres'])) {
                        echo $lettre;
                    }
                    echo '</div>';
                }
                ?>
            </div>
            <?php
            sort($mot_choisi); //$_session mot
            sort($_SESSION['lettres']);

            $array_unique_mot_choisi = array_unique($mot_choisi);
            $array_unique_lettres_saisies = array_unique($_SESSION['lettres']);
            foreach ($array_unique_lettres_saisies as $key => $value) {
                if (!in_array($value, $array_unique_mot_choisi)) {
                    unset($array_unique_lettres_saisies[$key]);
                }
            }

            $implode_mot = implode($array_unique_mot_choisi);
            $implode_lettres = implode($array_unique_lettres_saisies);

            if ($implode_mot == $implode_lettres) {
            ?>
                <div class="text-center">
                    <h3>You are the best !</h3>
                    <p>Il s'agit bien de : <?= $mot_choisi_to_upper ?></p>
                    <a href="includes/unset.php">Rejouer</a>
                </div>
            <?php
            } elseif ($_SESSION['nbre_tours'] < 11) {
            ?>
                <form method="post" action="traitement.php" class="w-50 ml-auto mr-auto">
                    <br />
                    Tapez ici votre lettre :
                    <input type="text" name="lettre" required autofocus>
                    <button type="submit" class="btn btn-success" hidden>Ok</button>
                    <br />
                    <a href="includes/unset.php" class="float-right">Annuler</a>
                </form>
            <?php
            } else {
            ?>
                <div class="text-center">
                    <h3>Oups !</h3>
                    <p>Il s'agissait de : <?= $mot_choisi_to_upper ?></p>
                    <a href="includes/unset.php">Rejouer</a>
                </div>
            <?php
            }
            ?>
            <hr class="mt-5">
        </div>
        <div class="col-4">
            <div id="imageId">
                <?php
                if ($implode_mot == $implode_lettres) {
                ?>
                    <img src="assets/img/confettis.gif" class="confettis">
                <?php
                } elseif ($_SESSION['nbre_tours'] < 11) {
                ?>
                    <img src="assets/img/<?= $images[$_SESSION['nbre_tours']] . '.png' ?>" class="img-fluid">
                <?php
                } else {
                ?>
                    <img src="assets/img/11.png" class="img-fluid">
                <?php
                }
                ?>
            </div>
            <div class="non w-75 ml-auto mr-auto">
                <?php
                foreach ($_SESSION['lettres'] as $lettre_dedans) {
                    echo $lettre_dedans;
                    echo ' - ';
                }
                ?>
            </div>
        </div>
    </div>

</main>
<?php
include "includes/footer.php";
