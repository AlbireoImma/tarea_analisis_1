<!-- 
    $_POST["user"] -- usuario
    $_POST["pass"] -- contraseña
-->
<!DOCTYPE html>
<html lang="en">
<?php
    include 'funciones.php'
?>	
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Espere un momento...</title>
</head>
<?php
    if(strcmp($_POST["user"],'') == 0){
        redirect('./incorrect_pair.php');
    }
    if(strcmp($_POST["pass"],'') == 0){
        redirect('./incorrect_pair.php');
    }
    $db = connect_bd();
    $pass = $_POST["pass"];
    $email = $_POST["user"];
    $query_string = "SELECT * FROM users WHERE email = lower('$email');";
    $test = pg_query($query_string);
    if(pg_num_rows($test) == 0){
        echo '<meta http-equiv="refresh" content="2; URL=./incorrect_pair.php">';
        echo '<meta name="keywords" content="automatic redirection">';
        redirect('./incorrect_pair.php);
    }
    $pair_check = "SELECT * FROM users WHERE email = lower('$email') AND
    password = crypt('$pass', password);";
    $pair_query = pg_query($db,$pair_check);
    if(pg_num_rows($pair_query) == 0){
        redirect('./incorrect_pair.php');
    }
    $row = pg_fetch_assoc($pair_query);
    $nombre = $row["name"];
    $url = "./home.php?nombre=". $nombre;
    redirect($url);
?>
<body>
</body>
</html>
