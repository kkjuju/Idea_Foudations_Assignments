<?php

/**
 * - adds the given text to the current value
 * - and returns the current value
 */
class TextInput
{
    protected $string = '';

    /**
     * adds the given text to the current value
     * @param $value
     */
    public function add($value)
    {
        $this->string .= $value;
    }

    /**
     * returns the current value
     * @return string
     */
    public function getValue()
    {
        return $this->string;
    }
}


class NumericInput extends TextInput
{

    /**
     * Overrides the add method so that each non-numeric text is ignored
     * @param $value
     */
    public function add($value)
    {
        if (is_numeric($value)) {
            $this->string .= $value;
        }
    }
}

$input = new NumericInput();
$input->add('String');
$input->add('123');
$input->add('Text');
echo $input->getValue();

?>