<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
?>

<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        echo '<br> Hello World <br>';
        
        $result = shell_exec('phantomjs --version');
		echo 'Result from phantomjs : '.$result;
        ?>
    </body>
</html>
