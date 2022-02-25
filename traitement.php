<?php
session_start();

if(!empty($_POST)){
    $lettre = strtoupper($_POST['lettre']);
    if(!in_array($lettre,$_SESSION['lettres'])){
        array_push($_SESSION['lettres'], $lettre);
    }

    $mot_choisi_to_upper = strtoupper($_SESSION['mot']);
    $mot_choisi = str_split($mot_choisi_to_upper);
    
    // si la lettre n'est pas dans session mot tour+1
    if(!in_array($lettre, $mot_choisi)){
        $_SESSION['nbre_tours'] = $_SESSION['nbre_tours'] + 1;
    }else{
       
        if($_SESSION['nbre_tours'] === 0){ 
            //var_dump($_SESSION['nbre_tours']); die();
            $_SESSION['nbre_tours'] = $_SESSION['nbre_tours'] + 1;
        }
    }
}else{
    $_SESSION['nbre_tours'] = $_SESSION['nbre_tours'] + 1;
}

header('Location: index.php');