<?php

if(!empty($_SESSION['rol_usuario_id'])){
    if(empty($_SESSION['autenticacion'])){
        echo "<script>alert('Se Requiere logueo'));</script>";
        header('Location: index.php');
    }
}else{
     echo "<script>alert('Se Requiere logueo 2');</script>";
     header('Location: index.php');
}

?>