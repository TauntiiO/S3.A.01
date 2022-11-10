<?php
include('baseDeDonnees.php');
if(!isset($_SESSION)){
    session_start();
}
if (isset($_SESSION['message'])){
    notifier($_SESSION['message'][0], $_SESSION['message'][1]);
    unset($_SESSION['message']);
}


//Insert un code d'erreur dans la page HTML dans la div d'id "erreur"
function error($message) {
    echo '<script type="text/javascript">document.getElementById("error").innerHTML ="'. $message . '" ;</script>';      
}




/*Cette fonction génère un code aléatoire et l'envoie par mail à l'utilisateur dont l'adresse mail est passée en paramètre
*puis renvoie le code généré pour pouvoir le comparer avec celui entré par l'utilisateur*/
function envoyerCodeMail($login){
    $code = rand(100000, 999999);
    $subject = "Code de vérification";
    $message = "Voici votre code de vérification : " . $code;
    echo $code;
    mail($login.'@iutbayonne.univ-pau.fr', $subject, $message);
    return $code;


}

function verifUtilisateur($user){
    //retourne les informations de l'utilisateur
    global $database;
    $req = $database->prepare('SELECT * FROM Utilisateur WHERE login = ?');
    $req->execute(array($user));
    return $req->fetch();
}




function estConnecter($user){
    //retourne true si l'utilisateur est connecté
    if (isset($_SESSION['login']) && $_SESSION['login'] == $user){
        return true;
    }
    else{
        return false;
    }
}


function estAdmin($user){
    //retourne true si l'utilisateur est admin
    if (estConnecter($user) && $_SESSION['role'] == 'admin'){
        return true;
    }
    else{
        return false;
    }
}





function notifier($message,$rgb="#333"){
    $injection= '<section id=injection><script type="text/javascript" src="../script/outils.js"></script>
          <link rel="stylesheet" href="../style/notification.css">
          <div id="notif">'."$message".'</div>
          <script>notification("'.$rgb.'")</script></section>';
    echo $injection;
}



?>