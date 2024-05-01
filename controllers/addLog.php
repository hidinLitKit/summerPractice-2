<?php 
    include("../database/databaseService.php");
    include("../credentials.php")
    $db = new PDO('mysql:host=localhost;dbname=u67322', $user, $pass,
    [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $type = "film";
        $menus = array();
        $menus = GetMenu($db);
        include("../pages/addLogPage.php");
      }
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if(isset($_POST["AddLog"])){
          SaveLog($db);
          header('Location: ./dataTable.php');
          exit();
        }
      }
?>