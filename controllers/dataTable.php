<?php 
    include("../database/databaseService.php");
    include("../credentials.php")
    $db = new PDO('mysql:host=localhost;dbname=u67322', $user, $pass,
    [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $type = "film";
        $dishes = array();
        $menus = array();
        $dishes = GetDish($db);
        $menus = GetMenu($db);
        $logs = GetJournal($db);
        include("../pages/dataTablePage.php");
      }
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if(isset($_POST["DeleteDish"])){
            DeleteDish($db, $_POST["dish_id"]);
            header('Location: ./dataTable.php');
          } 

        if(isset($_POST["DeleteMenu"])){
            DeleteMenu($db, $_POST["menu_id"]);
            header('Location: ./dataTable.php');
          } 
          
        if(isset($_POST["EditDish"])){
            $currentDish = array();
            $currentDish = GetDishById($db, $_POST["dish_id"]);
            include('../pages/editFilm.php');
          } 


        if(isset($_POST["EditMenu"])){
            $currentLibrarian = array();
            $currentLibrarian = GetMenuById($db, $_POST["menu_id"]);
            include('../pages/editLibrarian.php');
          } 

          if(isset($_POST["UpdateMenu"])){
            UpdateMenu($db, $_POST["menu_id"], $_POST["dish_id"], $_POST["price"]);
            header('Location: ./dataTable.php');
            exit();
          } 

          if(isset($_POST["UpdateDish"])){
            UpdateDish($db, $_POST["dish_id"],  $_POST["dish_name"], $_POST["dish_ingredients"]);
            header('Location: ./dataTable.php');
            exit();
          } 

          if(isset($_POST["AddLog"])){
            header('Location: ./addLog.php');
            exit();
          } 
          
    }
?>