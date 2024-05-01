CREATE TABLE journal
(
    journal_id int(10) unsigned NOT NULL AUTO_INCREMENT,
    issue_date DATE,
    journal_status varchar(128) NOT NULL DEFAULT '',
    menu_id int(10) unsigned NOT NULL DEFAULT 0,
    quantity int(10) unsigned NOT NULL DEFAULT 0,
    total_price int(10) unsigned NOT NULL DEFAULT 0,
    PRIMARY KEY(journal_id)
);
CREATE TABLE menu
(
    menu_id int(10) unsigned NOT NULL AUTO_INCREMENT,
    dish_id int(10) unsigned NOT NULL DEFAULT 0,
    price int(10) NOT NULL DEFAULT 0,
    PRIMARY KEY (menu_id)
);
CREATE TABLE dishes (
  dish_id int(10) unsigned NOT NULL AUTO_INCREMENT,
  dish_name varchar(128) NOT NULL DEFAULT '',
  dish_ingredients varchar(128) NOT NULL DEFAULT '',
  PRIMARY KEY (dish_id)
);