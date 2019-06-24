<?php

//Функция получения массива каталога
function get_cat($bookTitle) {
    $link = mysqli_connect("localhost", "root", "", "books");
    //запрос к базе данных
    $sql = "SELECT * FROM heading WHERE book_title = \"$bookTitle\"";
    $result = mysqli_query($link, $sql, MYSQLI_STORE_RESULT);
    if(!$result) {
        return NULL;
    }
    $arr_cat = array();
    if(mysqli_num_rows($result) != 0) {

        //В цикле формируем массив
        for($i = 0; $i < mysqli_num_rows($result);$i++) {
            $row = mysqli_fetch_array($result,MYSQLI_ASSOC);

            //Формируем массив где ключами являются адишники на родительские категории
            if(empty($arr_cat[$row['parent_id']])) {
                $arr_cat[$row['parent_id']] = array();
            }
            $arr_cat[$row['parent_id']][] = $row;
        }
        //возвращаем массив
        return $arr_cat;
    }
}

//вывод каталогa с помощью рекурсии
function view_cat($arr,$parent_id = 0) {

    //Условия выхода из рекурсии
    if(empty($arr[$parent_id])) {
        return;
    }
    echo '<ul>';
    //перебираем в цикле массив и выводим на экран
    for($i = 0; $i < count($arr[$parent_id]);$i++) {
        echo '<li><a href="?id='.$arr[$parent_id][$i]['id'].
            '&parent_id='.$parent_id.'">'
            .$arr[$parent_id][$i]['title'].'</a>';
        //рекурсия - проверяем нет ли дочерних категорий
        view_cat($arr,$arr[$parent_id][$i]['id']);
        echo '</li>';
    }
    echo '</ul>';

}
?>