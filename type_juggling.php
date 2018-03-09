<?php

/**
 * Tool to show the Type Juggling value of php
 */
class Color
{
    protected static $foreground_colors = array(
        'bold' => '1', 'dim' => '2',
        'black' => '0;30', 'dark_gray' => '1;30',
        'blue' => '0;34', 'light_blue' => '1;34',
        'green' => '0;32', 'light_green' => '1;32',
        'cyan' => '0;36', 'light_cyan' => '1;36',
        'red' => '0;31', 'light_red' => '1;31',
        'purple' => '0;35', 'light_purple' => '1;35',
        'brown' => '0;33', 'yellow' => '1;33',
        'light_gray' => '0;37', 'white' => '1;37',
        'normal' => '0;39',
    );

    public static function getColor($color)
    {
        return "\033[" . self::$foreground_colors[$color] . "m";
    }
}

class TypeJuggling
{
    private $typeList = array(
        "True   " => True,
        "False  " => False,
        "0      " => 0,
        "1      " => 1,
        "\"\"     " => "",
        "\"php\"  " => "php",
        "array()" => array()
    );

    private $padding = 10;

    protected function drawHeader()
    {
        printf("%-" . $this->padding . "s", "");
        foreach ($this->typeList as $typeName => $typeValue) {
            printf("%-" . $this->padding . "s", " | " . $typeName);
        }
        echo PHP_EOL;
    }

    protected function drawJuggling()
    {
        foreach ($this->typeList as $typeName => $typeValue) {
            printf("%-" . $this->padding . "s", $typeName);

            foreach ($this->typeList as $typeName2 => $typeValue2) {
                // here the juggling condition
                $result = ($typeValue == $typeValue2);

                $color = 'green';
                if ($typeName !== $typeName2){
                    $color = ($result)?'light_green':'red';
                }
                if ($result) {
                    $value = Color::getColor('normal') . " | " . Color::getColor($color) . "True   " . Color::getColor('normal');
                    printf("%-" . $this->padding . "s", $value);
                } else {
                    $value = Color::getColor('normal') . " | " . Color::getColor($color) . "False  " . Color::getColor('normal');
                    printf("%-" . $this->padding . "s", $value);
                }
            }
            echo PHP_EOL;
        }
    }

    public function run()
    {
        $this->drawHeader();
        $this->drawJuggling();
    }
}

$tj = new TypeJuggling();
$tj->run();
