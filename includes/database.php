<?php 
    define("HOSTNAME", "localhost" ); 
    define("USERNAME", "root" ); 
    define("PASSWORD", "");
    define("DATABASE","spendwise_db"); 
    
    $connection=mysqli_connect(HOSTNAME, USERNAME, PASSWORD, DATABASE);
    
    
    if(!$connection){ 
        die("Connectuon failed"); 
    } 
    else { 
        echo("Conention sucessfull");  
    } 
?>