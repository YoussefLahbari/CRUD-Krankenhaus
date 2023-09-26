<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php 
    require 'connexion.php';
    session_start();
    echo "<a href='acceuil.php'>Precedent </a>";
    echo "<a href='deconnexion.php'>Deconnexion</a><br><br>";
    // Controle d'access
    if ( $_SESSION['droit']=='admin') {      
        if (isset($_POST['vpatient'])) {
            $resultat = $connexion -> prepare('select * from patient where codepatient=:param');
            $resultat -> BindValue('param', $_POST['codepat']);
        try {
            $resultat -> execute();
        } catch (PDOException $e3) {
            echo "Erreur l'hors de la verification de l'existence du patient". $e3 -> getMessage();
        }
        $rowpatient = $resultat -> fetch();
        if (isset($rowpatient['CodePatient'])) {
            $_SESSION['codepa']=$rowpatient['CodePatient'];
            $codep = $rowpatient['CodePatient'];
            $nomp = $rowpatient['NomPatient'];
            $adressep = $rowpatient['AdressePatient'];
            $datep = $rowpatient['DateNaissance'];
            $sexep = $rowpatient['SexePatient'];
        }
        }
        
    }
    else {
        header ('location: deconnexion.php');
    }
    ?>
     <form method='POST'>
        <table>
            <tr>
                <td><label>Code Patient :</label><span style="color:red;">*</span></td>
                <td><input type='text' name='codepat' value='<?php if (isset($codep)){echo @$codep;}else {echo @$_POST['codepat'];} ?>'></td>
                <td><input type='submit' value='Vérifier la disponibilité' name='vpatient'></td>
            </tr>
            <tr>
                <td><label>Nom Patient :</label></td>
                <td><input type='text' value='<?= @$nomp ?>' name='nompat'></td>
                <td></td>
            </tr>
            <tr>
                <td><label>Adresse Patient :</label></td>
                <td><input type='text' value='<?= @$adressep ?>' name='adrspat'></td>
                <td></td>
            </tr>
            <tr>
                <td><label>Date Naissance :</label></td>
                <td><input type='date' value='<?= @$datep ?>' name='datepat'></td>
                <td></td>
            </tr>
            <tr>
                <td><label>Sexe :</label></td>
                <td><input type='radio' name='sexe' value='Homme' <?php if (@$sexep=='Homme') {
        echo 'checked';
    } ?>><label>M</label>
                       <input type='radio' name='sexe' value='Femme'  <?php if (@$sexep=='Femme') {
        echo 'checked';
    } ?>><label>F</label></td>
            <td></td></tr>
        </table>
    <?php 
    // Affichage des bouttons
    if (isset($_POST['vpatient']) and !isset($codep)) {
        echo "<span>Ce patient n'existe pas<span><br>";  
        echo"<input type='submit' name='ajouter' value='ajouter'>";   
    }
    elseif(isset($_POST['vpatient']) and isset($codep)){
        echo "<span>Ce patient existe déja<span><br>";
        echo"<input type='submit' name='modifier' value='modifier'>";
        echo"<input type='submit' name='supprimer' value='supprimer'>";   
    }
    
    // Gestion des actions
    // 1-Ajouter
    if (isset($_POST['ajouter'])) {
        if (empty($_POST['codepat']) or empty($_POST['datepat']) or $_POST['datepat']>date('Y-m-d')) {
            if (empty($_POST['codepat'])) {
                echo 'Le code Patient est obligatoire pour ajouter';
            }
            elseif (empty($_POST['datepat'])){
                echo "Le date de naissance est obligatoire";
            }
            else {
                echo "Le date de naissance doit étre inférieur à la date d'aujourd'hui";
            }
        }
        else {
            $resultat2 = $connexion ->prepare('insert into Patient value(:param1, :param2, :param3, :param4, :param5) ');
                $resultat2 ->bindValue('param1',$_POST['codepat']);
                $resultat2 ->bindValue('param2',@$_POST['nompat']);
                $resultat2 ->bindValue('param3',@$_POST['adrspat']);
                $resultat2 ->bindValue('param4',$_POST['datepat']);
                $resultat2 ->bindValue('param5',@$_POST['sexe']);
        try {
            $resultat2 ->execute();
            echo 'Insertion reussite';
        } catch (PDOException $e3) {
            echo "L'insertion à rencontré le probléme suivant" . $e3 -> getMessage();
        }
        }
        
    }

    // 2-Modifier
    if (isset($_POST['modifier'])) {
        if (empty($_POST['codepat']) or empty($_POST['datepat']) or $_POST['datepat']>date('Y-m-d')) {
            if (empty($_POST['codepat'])) {
                echo 'Le code Patient est obligatoire pour modifier';
            }
            elseif (empty($_POST['datepat'])){
                echo "Le date de naissance est obligatoire";
            }
            else {
                echo "Le date de naissance doit étre inférieur à la date d'aujourd'hui";
            }
        }
        else {
            $resultat3 = $connexion -> prepare('update patient set CodePatient=:param2, NomPatient=:param3, AdressePatient=:param4, DateNaissance=:param5, SexePatient=:param6 where CodePatient=:param1');
                $resultat3 ->bindValue('param1', $_SESSION['codepa']);
                $resultat3 ->bindValue('param2',$_POST['codepat']);
                $resultat3 ->bindValue('param3',$_POST['nompat']);
                $resultat3 ->bindValue('param4',$_POST['adrspat']);
                $resultat3 ->bindValue('param5',$_POST['datepat']);
                $resultat3 ->bindValue('param6', $_POST['sexe']);
        try {
            $resultat3 ->execute();
            echo 'Modification reussite';
        } catch (PDOException $e4) {
            echo "La modification à rencontré le probléme suivant" . $e4 -> getMessage();
        }
        }  
    }

    // 3-Supprimer
    if (isset($_POST['supprimer'])) {
        if (empty($_POST['codepat'])){
            echo 'Le code Patient est obligatoire Pour Supprimer';
        }
        else {
            $resultat4 = $connexion -> prepare('delete from patient where CodePatient=:param');
            $resultat4 ->bindValue('param',$_POST['codepat']);
            try {
                $resultat4 ->execute();
                echo 'Suppression reussite';
            } catch (PDOException $e4) {
                echo "La Suppression à rencontré le probléme suivant" . $e4 -> getMessage();
            }
        }  
    }
    echo '</form>';
    ?>



<!-- Style CSS -->
    <style>
body{
    background:url(abstract-luxury-gradient-blue-background-smooth-dark-blue-with-black-vignette-studio-banner.jpg);
    background-size:cover;
    color:white;
    text-align:center;
    font-family:arial;
    font-size:4vh;
}
h1{
    font-size:5vh;
}
form{
    border:1px solid rgba(0,0,0,0.3);
    border-radius:15px;
    padding:1.5vh 1vh ;
    width:fit-content;
    margin:auto;
    background-color:rgba(0,0,0,0.3);
    box-shadow:5px 5px rgba(0,0,0,0.5);
}
table{
    margin:auto;
}
td,th{
    border-bottom:1px solid rgba(0,0,0,0.8);
    padding:10px;
}
input{
    padding:7px;
    margin:7px;
    font-size:3.5vh;
    border-radius:5px;
}
input[type='submit']{
    padding:15px;
    background-color:rgba(0,0,0,0.6);
    border:1px solid rgba(0,0,0,0.6);
    color:white;
    cursor:pointer;
}
input[type='radio']{
    height: 40px;
    width:40px;
    margin-left:20px;
}
a{
    color:white;
}
</style>
</body>
</html>