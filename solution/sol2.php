<?php
/**
 * @charset UTF-8
 *
 * Задание 2. Работа с массивами и строками.
 *
 * Есть список временных интервалов (интервалы записаны в формате чч:мм-чч:мм).
 *
 * Необходимо написать две функции:
 *
 *
 * Первая функция должна проверять временной интервал на валидность
 * 	принимать она будет один параметр: временной интервал (строка в формате чч:мм-чч:мм)
 * 	возвращать boolean
 *
 *
 * Вторая функция должна проверять "наложение интервалов" при попытке добавить новый интервал в список существующих
 * 	принимать она будет один параметр: временной интервал (строка в формате чч:мм-чч:мм). Учесть переход времени на следующий день
 *  возвращать boolean
 *
 *  "наложение интервалов" - это когда в промежутке между началом и окончанием одного интервала,
 *   встречается начало, окончание или то и другое одновременно, другого интервала
 *
 *
 *
 *  пример:
 *
 *  есть интервалы
 *  	"10:00-14:00"
 *  	"16:00-20:00"
 *
 *  пытаемся добавить еще один интервал
 *  	"09:00-11:00" => произошло наложение
 *  	"11:00-13:00" => произошло наложение
 *  	"14:00-16:00" => наложения нет
 *  	"14:00-17:00" => произошло наложение
 */


$intervals = array(
    "10:00-14:00",
    "16:00-20:00"
);

function isValidTimeInterval($interval) {
    $pattern = '/^([01][0-9]|2[0-3]):([0-5][0-9])-([01][0-9]|2[0-3]):([0-5][0-9])$/';
    if (preg_match($pattern, $interval)) {
        return true;
    }
    return false;
}


function checkOverlap($newInterval) {
    if (isValidTimeInterval($newInterval)) {
        list($newStart, $newEnd) = explode('-', $newInterval);
        $newStart = strtotime($newStart);
        $newEnd = strtotime($newEnd);

        foreach ($GLOBALS['intervals'] as $interval) {
            list($existingStart, $existingEnd) = explode('-', $interval);
            $existingStart = strtotime($existingStart);
            $existingEnd = strtotime($existingEnd);
            // условие наложения интервалов
            if (($newEnd < $newStart) && ($newStart < $existingEnd)) {
                // интервал с переходом на след. день накладывается на существующий
                return true;
            } else if (($existingStart < $newEnd && $newEnd < $existingEnd) || ($existingStart < $newStart && $newStart < $existingEnd)) {
                // интервалы накладываются
                return true;
            }
        }
    }
    return false;
}

?>