<!-- 
    Parametros recibidos en el POST
    $_POST["name"] -- nombre usuario
    $_POST["email"] -- correo a verificar
    $_POST["password"] -- contraseña
    $_POST["re_password"] -- reiteración de contraseña
    $_POST["submit"] -- no sirve de nada
-->
<!DOCTYPE html> 
<html lang="en">
<?php
    include 'funciones.php';
?>	
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Espere un momento...</title>
</head>
<?php
    if(strcmp($_POST["password"],$_POST["re_password"]) == 0){
        echo "Match de contraseñas";
    } else {
        echo "No hay match de contraseñas";
        redirect('./error_reg.php');
    }
    echo "Conectando BD...";
    $db = connect_bd();
    $pas = $_POST["password"];
    $email = $_POST["email"];
    $name = $_POST["name"];
    $query_string = "SELECT * FROM users WHERE email = '$email'";
    $test = pg_query($query_string);
    if(pg_num_rows($test) > 0){
        redirect('./error_reg.php');
    } else {
        $result = pg_query($db,"INSERT INTO users (email, password, name) VALUES (lower('$email'), crypt('$pas', gen_salt('bf', 8)),'$name');");
        redirect('./exito_reg');
    }
?>
<body>
        <table>
                <?php
                    foreach ($_POST as $key => $value) {
                        echo "<tr>";
                        echo "<td>";
                        echo $key;
                        echo "</td>";
                        echo "<td>";
                        echo $value;
                        echo "</td>";
                        echo "</tr>";
                    }
                ?>
                </table>
</body>
</html>