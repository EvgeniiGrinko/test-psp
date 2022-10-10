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

   // Записываем число наеденных объектов
   $num_objects = 0;
    //Обходим массив и проверяем является ли элемент решеткой
     
       for ($z = 0; $z < $n-1; $z++){
        for ($x = 0; $x < $m-1; $x++){
            if ($photo[$z][$x] == '#') { //  проверяем здание ли это
                $num_objects++;        // если это здание, инкрементируем
                $l = 0;
                $k = $x;
                while ($k < $m && $photo[$z][$k] == '#') {
                       $photo[$z][$k] = '.'; // прячем фрагмент
                       $k++; $l++; // считаем ширину здания
                }
                for ($i = $z + 1; $i < $z + $l; $i++) // добиваем здание точками
                       for ($j = $x; $j < $x + $l; $j++) $photo[$i][$j] = '.';
         }
        }
        
       }
               
    // Записываем полученный результат в файл

    file_put_contents("output.txt", $num_objects);
    // Закрывaем файл
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
    $m = count($triangle);
   
    $n = null;
    for($i = 0; $i < $m; $i++){
        $tr[] = str_split($triangle[$i]);
        if(strlen($triangle[$i]) > $n){
            $n = strlen($triangle[$i]);
        }
    }
   // Заполним до квадрата строки недостающими нулями
    for($i = 0; $i < $m; $i++){
        if(count($tr[$i])<$n){
            $tr[$i] = $tr[$i] + array_fill($i+1, $n-$i - 1, "0");
        }
        
    }
    
    // Идем по перевернутому вновь созданному массиву tr и ищем максимальную сумму 3 чисел расположенных рядом, которую записываем в строку ниже (в перевернутом массиве)

    for ( $i = $m - 2; $i >= 0; $i--)
    {
        for ($j = 0; $j <= $i; $j++)
        {
            if ($tr[$i + 1][$j] > $tr[$i + 1]
                                       [$j + 1])
                $tr[$i][$j] += $tr[$i + 1][$j];
            else
                $tr[$i][$j] += $tr[$i + 1]
                                    [$j + 1];
        }
    }
 
    // Возвращаем сумму пути с максимальным значением    
    return $tr[0][0];
}
$tri = array("7",
            "23",
            "331",
            "3154",
            "31313",
            "222222",
            "5645643");
 echo golden_digger($tri);
    
    
