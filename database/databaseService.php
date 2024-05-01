<?php
    function SaveDish($db)
    {
      try{
        $stmt = $db->prepare("INSERT INTO dishes (dish_name, dish_ingredients) VALUES (:namedb, :ingdb)");
        $stmt -> execute(['namedb'=>$_POST["dish_name"], 'ingdb'=>$_POST["dish_ing"],]);
      }
      catch(PDOException $e){
        print('Error : ' . $e->getMessage());
        print_r($e->getTrace());
      }
        
    }

    function SaveMenu($db)
    {
      try{
        $stmt = $db->prepare("INSERT INTO menu (dish_id,price) VALUES (:dishdb, :pricedb)");
        $stmt -> execute(['dishdb'=>$_POST["dish_id"], 'pricedb'=>$_POST["price"] ]);
      }
      catch(PDOException $e){
        print('Error : ' . $e->getMessage());
        print_r($e->getTrace());
      }
        
    }

    function SaveJournal($db)
    {
        $status = $_POST["return_status"]=1?"выполнен":"в процессе";
        try{
            $stmt = $db->prepare("INSERT INTO journal (issue_date, journal_status) VALUES (:issuedb, :statusdb)");
            $stmt -> execute(['issuedb'=>$_POST["issue_date"], 'statusdb'=>$status]);
            $journal_id = $db->lastInsertId();
            $menu_quantity = $_POST["menu_id"];
            $total_price = 0;
            foreach($menu_quantity as $menu){
                list($menu_id, $quantity) = explode(":", $menu);
                $stmt = $db->prepare("INSERT INTO dishes_journal (journal_id, dish_id, quantity) VALUES (:journal_id, :dish_id, :quantity)");
                $stmt -> execute(['journal_id'=>$journal_id, 'dish_id'=>$menu_id, 'quantity'=>$quantity]);
                $stmt = $db->prepare("SELECT price FROM dishes WHERE dish_id = :dish_id");
                $stmt -> execute(['dish_id'=>$menu_id]);
                $price = $stmt->fetchColumn();
                $total_price += $price * $quantity;
            }
            $stmt = $db->prepare("UPDATE journal SET total_price = :total WHERE journal_id = :journal_id");
            $stmt -> execute(['total'=>$total_price, 'journal_id'=>$journal_id]);
        }
        catch(PDOException $e){
            print('Error : ' . $e->getMessage());
            print_r($e->getTrace());
        }
    }

    function GetDish($db)
    {
        try{
            $sth = $db->prepare('SELECT * FROM dishes');
            $dishes = array();
            $result = $sth->execute();
            $row = $sth->fetchAll();
            for($h = 0; $h < count($row); $h++) {
                $result = array();
                $result['dish_name'] = $row[$h]['dish_name'];
                $result['dish_ingredients'] = $row[$h]['dish_ingredients'];
                $dishes[$h] = $result;
            }
          }
          catch(PDOException $e){
            print_r($e->getTrace());
            exit();
          }
          return $dishes;
    }

    function GetMenu($db)
    {
        try{
            $sth = $db->prepare('SELECT menu.menu_id, menu.price, dishes.dish_name, dishes.dish_ingredients FROM menu JOIN dishes ON menu.dish_id = dishes.dish_id');
            $menus = array();
            $result = $sth->execute();
            $row = $sth->fetchAll();
            for($h = 0; $h < count($row); $h++) {
                $result = array();
                $result['menu_id'] = $row[$h]['menu_id'];
                $result['dish_name'] = $row[$h]['dish_name'];
                $result['dish_ingredients'] = $row[$h]['dish_ingredients'];
                $result['price'] = $row[$h]['price'];
                $menus[$h] = $result;
            }
        }
        catch(PDOException $e){
            print_r($e->getTrace());
            exit();
        }
        return $menus;
    }

    function GetJournal($db)
{
    try{
        $sth = $db->prepare('SELECT journal.journal_id, journal.issue_date, journal.journal_status, menu.dish_name, menu.price, journal.quantity, journal.total_price FROM journal JOIN menu ON journal.menu_id = menu.menu_id');
        $journals = array();
        $result = $sth->execute();
        $row = $sth->fetchAll();
        for($h = 0; $h < count($row); $h++) {
            $result = array();
            $result['journal_id'] = $row[$h]['journal_id'];
            $result['issue_date'] = $row[$h]['issue_date'];
            $result['journal_status'] = $row[$h]['journal_status'];
            $result['dish_name'] = $row[$h]['dish_name'];
            $result['price'] = $row[$h]['price'];
            $result['quantity'] = $row[$h]['quantity'];
            $result['total_price'] = $row[$h]['total_price'];
            $journals[$h] = $result;
        }
    }
    catch(PDOException $e){
        print_r($e->getTrace());
        exit();
    }
    return $journals;
}

function DeleteDish($db, $id)
{
    try{
        $sth = $db->prepare('DELETE FROM journal WHERE dish_id = :id');
        $sth->execute(['id' => $id]);
        $sth = $db->prepare('DELETE FROM menu WHERE dish_id = :id');
        $sth->execute(['id' => $id]);
        $sth = $db->prepare('DELETE FROM dishes WHERE dish_id = :id');
        $sth->execute(['id' => $id]);
    }
    catch(PDOException $e){
        print_r($e->getTrace());
        exit();
    }
}

function DeleteMenu($db, $id)
{
    try{
        $sth = $db->prepare('DELETE FROM journal WHERE menu_id = :id');
        $sth->execute(['id' => $id]);
        $sth = $db->prepare('DELETE FROM menu WHERE menu_id = :id');
        $sth->execute(['id' => $id]);
    }
    catch(PDOException $e){
        print_r($e->getTrace());
        exit();
    }
}

function GetDishById($db, $id)
{
    $result = array();
    $sth = $db->prepare('SELECT * FROM dishes WHERE dish_id = :id');
    $sth->execute(["id" => $id]);
    while($row = $sth->fetch()) {
        $result = array();
        $result['dish_id'] = $row['dish_id'];
        $result['dish_name'] = $row['dish_name'];
        $result['product_id'] = $row['product_id'];
    }
    return $result;
}



function GetMenuById($db, $id)
{
    try{
        $sth = $db->prepare('SELECT menu.menu_id, menu.price, dishes.dish_name, dishes.dish_ingredients FROM menu JOIN dishes ON menu.dish_id = dishes.dish_id WHERE menu.menu_id = :id');
        $sth->execute(['id' => $id]);
        $row = $sth->fetch();
        $result = array();
        $result['menu_id'] = $row['menu_id'];
        $result['dish_name'] = $row['dish_name'];
        $result['dish_ingredients'] = $row['dish_ingredients'];
        $result['price'] = $row['price'];
    }
    catch(PDOException $e){
        print_r($e->getTrace());
        exit();
    }
    return $result;
}

function UpdateDish($db, $dish_id, $dish_name, $dish_ingredients)
{
    try{
        $sth = $db->prepare('UPDATE dishes SET dish_name = :dish_name, dish_ingredients = :dish_ingredients WHERE dish_id = :dish_id');
        $sth->execute(['dish_id' => $dish_id, 'dish_name' => $dish_name, 'dish_ingredients' => $dish_ingredients]);
    }
    catch(PDOException $e){
        print_r($e->getTrace());
        exit();
    }
}

function UpdateMenu($db, $menu_id, $dish_id, $price)
{
    try{
        $sth = $db->prepare('UPDATE menu SET dish_id = :dish_id, price = :price WHERE menu_id = :menu_id');
        $sth->execute(['menu_id' => $menu_id, 'dish_id' => $dish_id, 'price' => $price]);
    }
    catch(PDOException $e){
        print_r($e->getTrace());
        exit();
    }
}

?>
