<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>HOPITALE UNIVAISITAIRE SYBA</h1>
    <?php 
    session_start();
    require 'connexion.php';
    if (isset($_POST['check'])) {
        $resultat = $connexion ->prepare('select * from utilisateur where login =:param');
        $resultat -> bindValue('param', $_POST['login']);
        try {
            $resultat ->execute();
        } catch (PDOException $e1) {
            echo "Erreur l'hors de l'execution de la requete" . $e1 -> getMessage();
        }
        $row = $resultat -> fetch();
        if(isset($row['login'])){
            header('location: acceuil.php');
            $_SESSION['login']=$row['login'];
            $_SESSION['password']=$row['password'];
            $_SESSION['nom']=$row['nom'];
            $_SESSION['prenom']=$row['prénom'];
            $_SESSION['droit']=$row['droit'];
        }
        else {
            echo "Cette utilisateur n'existe pas";
        }
    }
    ?>
    <form action="" method='POST'>
        <input type="text" name='login' placeholder='LOGIN'><br>
        <input type="text" name='password' placeholder='PASSWORD'><br>
        <input type="submit" value="LOGIN" name='check'>
    </form>




    

<!-- STYLE CSS -->
    <style>

    body{
        background:url(abstract-luxury-gradient-blue-background-smooth-dark-blue-with-black-vignette-studio-banner.jpg);
        background-size:cover;
        color:white;
        text-align:center;
        font-family:Verdana;
        font-size:4vh;
    }
    h1{
        color:#E8E8E8;
        font-size:7vh;
    }
    form{
        border:1px solid rgba(0,0,0,0.3);
        border-radius:15px;
        padding:70px 20px 40px 20px;
        width:fit-content;
        margin:auto;
        background-color:rgba(0,0,0,0.3);
        box-shadow:5px 5px rgba(0,0,0,0.5);
    }
    input{
        padding:10px;
        margin:10px;
        font-size:4.5vh;
        border-radius:5px;
    }
    input[type='submit']{
        margin-top:20px;
        padding:15px;
        background-color:rgba(0,0,0,0.6);
        border:1px solid rgba(0,0,0,0.6);
        color:white;
        cursor:pointer;
    }
</style>
</body>
</html>