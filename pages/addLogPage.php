<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/dataStyle.css">
    <title>Document</title>
</head>
<body>
<div class="column-body">
    <div class="column">
        <h2>Блюда</h2>
        <table class="film-table" id="menus">
            <thead>
                <tr>
                    <th>Название</th>
                    <th>Цена</th>
                    <th>Количество</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($menus as $menu) : ?>
                <tr class="item_row">
                    <td><?php echo $menu['dish_name']; ?></td>
                    <td><?php echo $menu['price']; ?></td>
                    <td><input type="number" name="menu_id[<?php echo $menu['menu_id']; ?>]" value="1"></td>
                    <input class="dish-id" name="dish_id[]" value="<?php echo $menu['dish_id']; ?>" type="hidden" />
                    <input class="menu-id" name="menu_id[]" value="<?php echo $menu['menu_id']; ?>" type="hidden" />
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<form class="filter-form" action="" method="post">
    <label for="">Дата заказа</label>
    <input class="log-date" name="issue_date" type="date">
    <input type="checkbox" class="custom-checkbox" id="happy" name="return_status">
    <label for="happy">Возвращен</label> />
    <input id="menuActive_id" name="menuActive_id" value="" type="hidden" />
    <input type="submit" name="AddLog" class="filter-btn" value="Сохранить">
</form>

<script>
    var menuActive_id = [];
    var rows1 = document.querySelectorAll("#menus tr");
    var menuInput = document.querySelector("#menuActive_id");
    // Добавляем обработчик события к каждой строке
    rows1.forEach(function(row) {
        row.addEventListener("click", function() {
            // Снимаем выделение с предыдущей выбранной строки
            rows1.forEach(function(row){row.classList.remove("selected")});
            // Выделяем выбранную строку
            this.classList.add("selected");
            var menuId = row.querySelector(".menu-id").value;
            var quantity = row.querySelector(".item_row input[name='menu_id[<?php echo $menu['menu_id']; ?>]']").value;
            var menu = menuId + ":" + quantity;
            // Добавляем выбранное блюдо в массив
            if (menuActive_id.indexOf(menu) === -1) {
                menuActive_id.push(menu);
            }
            // Устанавливаем значение поля menuActive_id
            menuInput.value = menuActive_id.join(",");
        });
    });
</script>
</body>
</html>