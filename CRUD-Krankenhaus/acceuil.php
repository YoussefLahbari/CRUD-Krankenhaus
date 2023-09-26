<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<?php 

require 'connexion.php';
session_start();
echo "<a href='deconnexion.php'>Deconnexion</a>";

// Controle d'access
if (isset( $_SESSION['login']) and isset($_SESSION['password'])) {
    
    echo '<h1>Bienvenu Monsieur '.  $_SESSION['nom'] . ' ' . $_SESSION['prenom'] . '</h1>';
}
else {
    header ('location: deconnexion.php');
}

// Controle des autorisation
if ($_SESSION['droit']=='user') {
    echo '<style>.admin{display:none;}</style>';
}

?>



<body>
    <form action="" method='POST'>
       <!-- <input type="submit" value="Mise à jour des medecins" class='admin' name='MajM'> -->
       <input type="submit" value="Mise à jour des patients" class='admin' name='MajP'>
       <input type="submit" value="Mise à jour des RDVs" class='admin' name='MajR'>
       <input type="submit" value="Consulter" name='consulter'>
       <input type="submit" value="Votre avis nous interresse" name='Avis'>
    </form><br>

    <?php 
    // Actions des submits

// Consultation
if (isset($_POST['consulter'])) {
    $resultat = $connexion ->query('select * from Patient');
    echo "<table><tr><th>CodePatient</th><th>NomPatient</th><th>AdressePatient</th><th>DateNaissance</th><th>SexePatient</th></tr>";
    while ($row = $resultat -> fetch()) {
        echo "<tr>
        <td>$row[CodePatient]</td>
        <td>$row[NomPatient]</td>
        <td>$row[AdressePatient]</td>
        <td>$row[DateNaissance]</td>
        <td>$row[SexePatient]</td>
        </tr>
        ";
    }
    echo '</table>';
}

// Redirection en submit
if (isset($_POST['MajP'])) {
   header('location:MajP.php');
   
}
if (isset($_POST['MajR'])) {
    header('location:MajR.php');
}
if (isset($_POST['Avis'])) {
    echo'coming soon';
}
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
td,th{
    border:1px solid rgba(0,0,0,0.8);
    padding:10px;
}
table{
    background-color:rgba(0,0,0,0.6);
    border-collapse:collapse;
    margin:auto;
    box-shadow:5px 5px rgba(0,0,0,0.8);
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
a{
    color:white;
}
</style>
</body>
</html>