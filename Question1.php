<?php
/**
 * @param $value1
 * @param $value2
 * @return float|int
 */
function sumArray($value1, $value2)
{
    $array = [10, 20, 30, 40, 50, 60, 70, 80, 90, 100];
    $arrayCount = count($array);

    if ($value1 >= 0 && $value2 >= 0) {
        if ($value2 > $value1 && in_array($value1, $array)) {
            $startIndex = array_search($value1, $array);
            $length = $arrayCount - $startIndex + 1;
            if (in_array($value2, $array)) {
                $endIndex = array_search($value2, $array);
                $length = $endIndex - $startIndex + 1;
            }
            $response = array_sum(array_slice($array, $startIndex, $length));
        } else {
            $response = 0;
        }
    } else {
        $response = -1;
    }
    return $response;
}

echo(sumArray(30, 60));
echo '<br>';
echo(sumArray(-30, 60));
echo '<br>';
echo(sumArray(60, 30));
echo '<br>';
echo(sumArray(50, 110));
echo '<br>';
echo(sumArray(110, 120));
?>