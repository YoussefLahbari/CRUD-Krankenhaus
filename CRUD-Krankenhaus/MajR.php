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
        if (isset($_POST['vrdv'])) {
            $resultat = $connexion -> prepare('select * from rdv where NumRDV=:param');
            $resultat -> BindValue('param', $_POST['numrdv']);
        try {
            $resultat -> execute();
        } catch (PDOException $e3) {
            echo "Erreur l'hors de la verification de l'existence du RDV". $e3 -> getMessage();
        }
        $rowrdv = $resultat -> fetch();
        if (isset($rowrdv['NumRDV'])) {
            $_SESSION['numrdv']=$rowrdv['NumRDV'];
            $numrdv = $rowrdv['NumRDV'];
            $daterdv = $rowrdv['DateRDV'];
            $heurerdv = $rowrdv['HeureRDV'];
            $codepat = $rowrdv['CodePatient'];
            $codemed = $rowrdv['CodeMedecin'];
        }
        }
        
    }
    else {
        header ('location: deconnexion.php');
    }
    ?>
     <form method='POST' id='Patient'>
        <table>
            <tr>
                <td><label>Numéro RDV :</label><span style="color:red;">*</span></td>
                <td><input type='text' name='numrdv' value='<?php if (isset($numrdv)){echo $numrdv;}else {echo @$_POST['numrdv'];} ?>'></td>
                <td><input type='submit' value='Vérifier la disponibilité' name='vrdv'></td>
            </tr>
            <tr>
                <td><label>Date RDV :</label></td>
                <td><input type='date' value='<?= @$daterdv ?>' name='daterdv'></td>
                <td></td>
            </tr>
            <tr>
                <td><label>Heure RDV :</label></td>
                <td><input type='time' value='<?=  @$heurerdv ?>'  name='heurerdv'></td>
                <td></td>
            </tr>
            <tr>
                <td><label>Code Patient :</label></td>
                <td>
                    <!-- <input type="text" name="codepat" value='<?= @$codepat?>'> -->
                        <?php 
                         $query = "SELECT CodePatient FROM rdv";
                         $resultatf = $connexion->query($query);
                         echo "<select name='codepat'>";
                         echo "<option></option>";
                         while ($row10 = $resultatf->fetch(PDO::FETCH_ASSOC)) {
                            
                            echo "<option ";
                             if  ($row10['CodePatient']==@$codepat) {
                                 echo 'selected';
                             }
                             echo ">".$row10['CodePatient']."</option>";
                             
                         }
                         echo "</select>";
                        // $resultatf = $connexion->query('select CodePatient from rdv');
                        // while ( $rowcodepat = $resultatf->fetch()) {
                        //     echo "<option";
                        //     if (1== @$codepat) {
                        //         echo 'selected';
                        //    }
                        //    echo  ">". $rowcodepat['CodePatient'] ."</option>";

                        // }
                        ?>
                </td>
                <td></td>
            </tr>
            <tr>
                <td><label>Code Medecin :</label></td>
                <!-- <td>
                    <input type="text" value='<?= @$codemed ?>' name="codemed"  >
            </td> -->
            <td>
            <?php 
                         $query2 = "SELECT CodeMedecin FROM rdv";
                         $resultatff = $connexion->query($query2);
                         echo "<select name='codemed'>";
                         echo "<option></option>";
                         while ($row11 = $resultatff->fetch(PDO::FETCH_ASSOC)) {
                    
                            echo "<option ";
                             if  ($row11['CodeMedecin']==@$codemed) {
                                 echo 'selected';
                             }
                             echo ">".$row11['CodeMedecin']."</option>";
                             
                         }
                         echo "</select>";?>
            </td>
            <td></td></tr>
        </table>
    <?php 
    // Affichage des bouttons
    if (isset($_POST['vrdv']) and !isset($numrdv)) {
        echo "<span>Ce RDV n'existe pas<span><br>";  
        echo"<input type='submit' name='ajouter' value='ajouter'>";   
    }
    elseif(isset($_POST['vrdv']) and isset($numrdv)){
        echo "<span>Ce RDV existe déja<span><br>";
        echo"<input type='submit' name='modifier' value='modifier'>";
        echo"<input type='submit' name='supprimer' value='supprimer'>";   
    }
    
    // Gestion des actions
    // 1-Ajouter
    if (isset($_POST['ajouter'])) {
        if (empty($_POST['numrdv']) or empty($_POST['daterdv']) or empty($_POST['heurerdv']) or empty($_POST['codepat']) or empty($_POST['codemed'])   or $_POST['daterdv']<date('Y-m-d')) {
            if (empty($_POST['numrdv'])) {
                echo 'Le Numero de RDV est obligatoire pour ajouter';
            }
            elseif (empty($_POST['daterdv'])){
                echo "Le date de RDV est obligatoire";
            }
            elseif (empty($_POST['heurerdv'])) {
                echo "L'heure du RDV est obligatoire";
            }
            elseif (empty($_POST['codepat'])) {
                echo "Le Code Patient est obligatoire";
            }
            elseif (empty($_POST['codemed'])) {
                echo "Le Code Medecin est obligatoire";
            }
            else {
                echo "Le date de RDV doit étre supérieur à la date d'aujourd'hui";
            }
        }
        else {
            $resultat2 = $connexion ->prepare('insert into RDV value(:param1, :param2, :param3, :param4, :param5) ');
                $resultat2 ->bindValue('param1',$_POST['numrdv']);
                $resultat2 ->bindValue('param2',$_POST['daterdv']);
                $resultat2 ->bindValue('param3',$_POST['heurerdv']);
                $resultat2 ->bindValue('param4',$_POST['codepat']);
                $resultat2 ->bindValue('param5',$_POST['codemed']);
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
        if (empty($_POST['numrdv']) or empty($_POST['daterdv']) or empty($_POST['heurerdv']) or empty($_POST['codepat']) or empty($_POST['codemed'])   or $_POST['daterdv']>date('Y-m-d')) {
            if (empty($_POST['numrdv'])) {
                echo 'Le Numero de RDV est obligatoire pour modifier';
            }
            elseif (empty($_POST['daterdv'])){
                echo "Le date de RDV est obligatoire";
            }
            elseif (empty($_POST['heurerdv'])) {
                echo "L'heure du RDV est obligatoire";
            }
            elseif (empty($_POST['codepat'])) {
                echo "Le Code Patient est obligatoire";
            }
            elseif (empty($_POST['codemed'])) {
                echo "Le Code Medecin est obligatoire";
            }
            else {
                echo "Le date de RDV doit étre inférieur à la date d'aujourd'hui";
            }
        }
        else {
            $resultat3 = $connexion -> prepare('update rdv set NumRDV=:param2, DateRDV=:param3, HeureRDV=:param4, CodePatient=:param5, CodeMedecin=:param6 where NumRDV=:param1');

                $resultat3 ->bindValue('param1', $_SESSION['numrdv']);
                $resultat3 ->bindValue('param2',$_POST['numrdv']);
                $resultat3 ->bindValue('param3',$_POST['daterdv']);
                $resultat3 ->bindValue('param4',$_POST['heurerdv']);
                $resultat3 ->bindValue('param5',$_POST['codepat']);
                $resultat3 ->bindValue('param6',$_POST['codemed']);
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
        if (empty($_POST['numrdv'])){
            echo 'Le numéro de RDV est obligatoire Pour Supprimer';
        }
        else {
            $resultat4 = $connexion -> prepare('delete from rdv where NumRDV=:param');
            $resultat4 ->bindValue('param',$_POST['numrdv']);
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
input, select{
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