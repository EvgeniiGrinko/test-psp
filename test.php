<?php

// 1)

function main() {
    // Открываем файл "input.txt"
    $input_file = file("input.txt");
    // Открываем если существует/создаем если не был создан файл "output.txt"
    $output_file = fopen("output.txt", "w");
    // Достаем размерность поля (фото)
    $n = (int) explode(' ' , $input_file[0])[0];
    $m = (int) explode(' ' , $input_file[0])[1];
    $source = array_slice($input_file, 2);
    // Делаем фотку - массивом
    $photo = [];
    for($i = 0; $i < count($source); $i++){
        $photo[$i] = str_split ( $source[$i]);
    };

    $dx = [0, 0, 1, -1];
    $dy = [1, -1, 0, 0];
   // Записываем число наеденных объектов
    $num_objects = 0;
    // Обходим массив и проверяем является ли элемент решеткой
    for($y = 0; $y < $n; $y++){

        for($x = 0; $x < $m; $x++){
            if($photo[$y][$x] == '#'){
                // Если элемент массива является решеткой, то увеличиваем число объектов (в переменной) и записываем координаты и заменяем решетку на точку
                $num_objects++;
                $queue = [];
                $queue[] = [$x, $y];
                $head = 0;
                $tail = 1;
                $photo[$y][$x] = '.';
                // Так как и высота и ширина объектов одинаковы (они квадраты) проверяем все точки вокруг найденного элемента решетки
                while($head < $tail){
                    $p = $queue[$head];
                    $x0 = $p[0]; 
                    $y0 = $p[1];
                    for($k = 0; $k < 4; $k++){
                        $x1 = $x0 + $dx[$k];
                        $y1 = $y0 + $dy[$k];
                        if ($x1 >= 0 and $x1 < $n and $y1 >= 0 and $y1 < $m and $photo[$x1][$y1] == "#"){
                        $queue[] = [$x1, $y1];
                        $photo[$x1][$y1] = ".";
                        $tail = $tail + 1;
                    }
                    $head = $head + 1;
                    }
                }
            };
            $x++;
        }
        $y++;
    }
    // Записываем полученный результат в файл
    file_put_contents("output.txt", $num_objects);
    // Закрывем файл
    fclose($output_file);
}

main();

// 2)
// Создадим функцию matr_snake и передадим ей размерностьматрицы и шаблон
function matr_snake(int $N, array $a)
{
    
     $i =1; $x = 1; $y = 1; $k = 1;
    // Заполним первую половину матрицы
    for ($i=0; $i<$N; $i++)
    {
        //  Сначала по четным диагоналям
        if ($i%2 == 0)
        {
            $x = 0;
            $y = $i;
 
            while ($y >= 0)
            {
                $a[$x][$y] = $k;
                $x++; $y--; $k++;
            }
        }
        // потом по нечетным диагоналям
        else 
        {
            $x = $i; $y = 0;
            while ($x >= 0)
            {   
                $a[$x][$y] = $k;
                $k++; $x--; $y++;
            }
        }
    }
    // Теперь заполним вторую половину матрицы
    if ($N%2 != 0){
    for ($i = 1; $i < $N; $i++) 
    {
        
        if ($i%2 == 0)
        {
            $x = $i; $y = $N-1;
            while ($x <= $N-1)
            {
                $a[$x][$y] = $k;
                $k++; $x++; $y--;
            }
        }
        else
        {
            $x = $N-1; $y = $i;
            while ($y <= $N-1)
            {
                $a[$x][$y] = $k;
                $k++; $x--; $y++;
            }
        }
    }
    }
    else
    {
        for ($i = 1; $i < $N; $i++) 
        {
            if ($i%2 == 0)
            {
                $x = $N-1; $y = $i;
                while ($y <= $N-1)
                {
                    $a[$x][$y] = $k;
                    $k++; $x--; $y++;
                }
            }
            else
            {
                $x = $i; $y = $N - 1;
                while ($x <= $N - 1)
                {
                    $a[$x][$y] = $k;
                    $k++; $x++; $y--;
                }
            }
        }
    }
    return $a;
}
 
 
function app()
{
    $a = [];
    // Достанем из input.txt размер матрицы 
    $N = (integer) file_get_contents("INPUT1.TXT", "r");
    // Заполним многомерный массив $a - создадим шаблон матрицы
    for($i = 0; $i < $N; $i++){
        $a[$i] = [];
    }
    // Вызовем функцию matr_snake и передадим туда размер матрицы и шаблон
    $array = matr_snake($N, $a);
    
    
    $f = fopen("OUTPUT1.TXT", "w");
    // Запишем построчно из матрицы числа в файл OUTPUT1.TXT, разделяя пробелами
    for ($i = 0; $i<count($array); $i++){
        file_put_contents("OUTPUT1.TXT", implode( ' ',  $array[$i]) . PHP_EOL,  FILE_APPEND | LOCK_EX);
    }
    fclose($f);
} 
app();

//3
// Cоздадим функцию golden_digger в которую передаем наш треугольник (преположительно массив со строками)
function golden_digger($triangle){
    // Строки рабиваем на массивы и создаем новый массив
    $tr = [];
    for($i = 0; $i < count($triangle); $i++){
        $tr[] = str_split($triangle[$i]);
    }
    // Идем по перевернутому вновь созданному массиву tr и ищем максимальную сумму 3 чисел расположенных рядом, которую записываем в строку ниже (в перевернутом массиве)
    foreach (range(count($tr) - 2, -1, -1) as $i){
        foreach (range(0,$i + 1) as $j){
            $tr[$i][$j] += max($tr[$i + 1][$j], $tr[$i + 1][$j + 1]);
        }
    }  
    // Возвращаем сумму пути с максимальным значением    
    return $tr[0][0];
}
    
    
