<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/dataStyle.css">
    <title>Административная панель</title>
</head>
<body>
<div class="navbar">
    <ul>
        <li><button onclick="ChangeTable('film')">Блюда</button></li>
        <li><button onclick="ChangeTable('librarian')">Меню</button></li>
    </ul>
    <a href='../controllers/addData.php' class="btn add-btn">
        Добавить
    </a>
</div>
<table class="film-table" id="films">
    <thead>
        <tr>
            <th>Название</th>
            <th>Ингредиенты</th>
            <th>Действия</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($dishes as $dish) : ?>
        <tr class="item_row">
            <td><?php echo $dish['dish_name']; ?></td>
            <td><?php echo $dish['ingredients']; ?></td>
            <td>
                <form action="" method="post">
                    <button class="btn edit-btn" name="EditDish" type="submit">Редактировать</button>
                    <button class="btn delete-btn" name="DeleteDish" type="submit">Удалить</button>
                    <input name="dish_id" value="<?php echo $dish['dish_id']; ?>" type="hidden" />
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<table class="film-table" id="librarians">
    <thead>
        <tr>
            <th>Название</th>
            <th>Ингредиенты</th>
            <th>Цена</th>
            <th>Действия</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($menus as $menu) : ?>
        <tr class="item_row">
            <td><?php echo $menu['dish_name']; ?></td>
            <td><?php echo $menu['dish_ingredients']; ?></td>
            <td><?php echo $menu['price']; ?></td>
            <td>
                <form action="" method="post">
                    <button class="btn edit-btn" name="EditMenu" type="submit">Редактировать</button>
                    <button class="btn delete-btn" name="DeleteMenu" type="submit">Удалить</button>
                    <input name="menu_id" value="<?php echo $menu['menu_id']; ?>" type="hidden" />
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
<table class="film-table" id="journals">
    <thead>
        <tr>
            <th>Дата заказа</th>
            <th>Статус</th>
            <th>Название блюда</th>
            <th>Количество</th>
            <th>Цена</th>
            <th>Общая цена</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $prev_id = null;
        $total_price = 0;
        foreach ($journals as $journal) :
            if ($prev_id != $journal['journal_id']) {
                echo '<tr class="item_row">';
                echo '<td rowspan="' . $journal['quantity'] . '">' . $journal['issue_date'] . '</td>';
                echo '<td rowspan="' . $journal['quantity'] . '">' . $journal['journal_status'] . '</td>';
                echo '<td>' . $journal['dish_name'] . '</td>';
                echo '<td>' . $journal['quantity'] . '</td>';
                echo '<td>' . $journal['price'] . '</td>';
                echo '<td rowspan="' . $journal['quantity'] . '">' . $journal['total_price'] . '</td>';
                echo '</tr>';
                $prev_id = $journal['journal_id'];
                $total_price = $journal['total_price'];
            } else {
                echo '<tr class="item_row">';
                echo '<td>' . $journal['dish_name'] . '</td>';
                echo '<td>' . $journal['quantity'] . '</td>';
                echo '<td>' . $journal['price'] . '</td>';
                echo '</tr>';
                $total_price += $journal['price'] * $journal['quantity'];
            }
        endforeach;
        ?>
    </tbody>
</table>
<form action="" method="post">
    <button class="btn addLog-btn" name="AddLog" type="submit">Добавить запись</button>
</form>

<script>
        var type = "film";
        var filmsTable; 
        var clientsTable; 
        var librariansTable;
        document.addEventListener("DOMContentLoaded", (event) => {
            filmsTable = document.getElementById("films");
            librariansTable = document.getElementById("librarians");
            SetInvisible();
            ChangeTable(type);
        });
    

    function ChangeTable(t)
    {
        SetInvisible();
        if(t == "film")
            filmsTable.style.display = "block";
        else
            librariansTable.style.display = "block";
    }

    function SetInvisible()
    {
        filmsTable.style.display = "none";
        librariansTable.style.display = "none";
    }
</script>
</body>