<?php
/*
идея: перевести изначальный двумерный массив в графовое представление, далее найти все пути от начальной точки до конечной и найти между ними минимальный.
массив после представления в виде графа:
исходный массив: [[1, 2, 3, 8],    массив индексов точек: [[0, 1, 2, 3],     массив в виде графа: array(индекс точки => [все связанные с ней точки],)
                 [0, 2, 0, 1],  =>                         [4, 5, 6, 7],  =>
                 [9, 8, 2, 1]]                             [8, 9, 10, 11]]  
                 
*/
class ShortestWay
{
    private $w; private $start; private $end; private $map;

    public function __construct(array $map, array $start, array $end)
    {
        $this->w = array();
        $this->start = $start;
        $this->end = $end;
        $this->map = $map;
    }


    public function getShortestWay(): void
    {
        try
        {
            /*
            получение вспомагательных массивов
            */
            $arr_for_graph = array(); $arr_for_encode = array();
            $counter = 0;
            for ($y = 0; $y < count($this->map); $y++)
            {
                $temp = array(); 
                for ($x = 0; $x < count($this->map[0]); $x++) 
                {
                    $temp[] = $counter;
                    $arr_for_encode[$counter] = $this->map[$y][$x];
                    $counter += 1;
                }
                $obj = new ArrayObject($temp);
                $copytemp = $obj->getArrayCopy();
                $arr_for_graph[] = $copytemp;
            }

            /*
            получение графа из исходного массива
            */
            $map_graph = array(); $counter = 0;
            for ($y = 0; $y < count($this->map); $y++)
                for ($x = 0; $x < count($this->map[0]); $x++) 
                {
                    if ($this->map[$y][$x])
                    {
                        $temp = array();
                        if ($this->map[$y][$x + 1])
                            $temp[] = $arr_for_graph[$y][$x + 1];
                        if ($this->map[$y][$x - 1])
                            $temp[] = $arr_for_graph[$y][$x - 1];    
                        if ($this->map[$y - 1][$x])
                            $temp[] = $arr_for_graph[$y - 1][$x];
                        if ($this->map[$y + 1][$x])
                            $temp[] = $arr_for_graph[$y + 1][$x];
                        $obj = new ArrayObject($temp);
                        $copytemp = $obj->getArrayCopy();
                        $map_graph[$counter] = $copytemp;
                    }
                    $counter += 1;
                }
                
                /*
                подготовка данных: массив посещений, путь, наальная точка в графе и конечная, 
                вызов функции нахождения всех путей
                */
                $visited = array();
                foreach ($map_graph as $key => $value)
                    $visited[$key] = false;

                $start = $arr_for_graph[$this->start[0]][$this->start[1]];
                $end = $arr_for_graph[$this->end[0]][$this->end[1]];
                $path = array(); 
                $this->getPaths($start, $end, $visited, $path, $map_graph); 
                if (empty($this->w))
                    throw new Exception('невозможно найти расстояние');
                /*
                преобразование индексов точек в их значения из исходного массива 
                */
                $a = array();
                foreach ($this->w as $way)
                {
                    $encode_way = array();
                    foreach ($way as $point)
                    {
                        $encode_way[] = $arr_for_encode[$point];
                    }
                    $obj = new ArrayObject($encode_way);
                    $copytemp = $obj->getArrayCopy();
                    $a[] = $copytemp;
                }
                /*
                сумирование всех пунктов для каждого пути
                */
                $a_sum = array();
                foreach ($a as $way)
                {
                    $sum = 0;
                    foreach ($way as $point)
                    {
                        $sum += $point;
                    }
                    $a_sum[] = $sum;
                }
                /*
                нахождение самого короткого пути и его вывод
                */
                $shortest_way = min($a_sum);
                echo "<h1>Самый короткий путь равен $shortest_way ходов</h1>";
        }
        catch(Exception $ex)
        {
            $msg = $ex->getMessage();
            echo "<h1>$msg</h1>";
        }
        catch(Error)
        {
            echo "<h1>Были переданы некорректные данные в конструктор класса</h1>";
        }
    }


    /*
    функция рекурсивно просматирвает с помощью поиска в глубину все вершины графа 
    и находит все пути от начальной до конечной точки
     */
    private function getPaths(int $cur, int $end, array $visited, array $path, array $map_graph): void
    { 
        # Пометить текущий узел как посещенный и сохранить в path
        $visited[$cur] = true;
        $path[] = $cur;
        # Если текущая вершина совпадает с точкой назначения, то
        # print(current path[])
        if ($cur === $end)
        {
            $obj = new ArrayObject($path);
            $copytemp = $obj->getArrayCopy();
            $this->w[] = $copytemp;
        }
        else
        {
            # Если текущая вершина не является пунктом назначения
            # Повторить для всех вершин, смежных с этой вершиной
            foreach ($map_graph[$cur] as $vert)
            {
                if ($visited[$vert] === false)
                {
                    $this->getPaths($vert, $end, $visited, $path, $map_graph);
                }
            }
        }
        # Удалить текущую вершину из path[] и пометить ее как непосещенную
        unset($path[array_search($cur,$path)]);
        $visited[$cur] = False;
    }
}


$obj = new ShortestWay([[1, 2, 3, 8],
                        [0, 2, 0, 1],
                        [9, 8, 2, 1]], [0, 0], [2, 2]);
$obj->getShortestWay();


