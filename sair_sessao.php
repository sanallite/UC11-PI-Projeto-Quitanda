<?php
session_start();

if ( $_SESSION ) {
    session_destroy();
    header("location:index.php");
}

else {
    echo "Nada para exibir.";
}