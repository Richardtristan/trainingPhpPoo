<?php
/**
 * classform
 * fast create form
 */

class Form
{
    /**
     * @var string  ce qui entour les input etc
     */
    public $surround = 'p';

    /**
     * @var array|mixed donnée du formulaire
     */
    private $data;

    /**
     * @param array $data donnée utilisé
     */
    public function __construct($data = array())
    {
        $this->data = $data;
    }

    /**
     * @param $type
     * @param $name
     * @param $value
     * @return string
     */
    public function input($type, $name, $value)
    {
        return $this->surround("<input type='$type ' name ='$name' value='$value'>");
    }

    /**
     * @param $html code html a entourer
     * @return string
     */
    private function surround($html)
    {
        return "<{$this->surround}>{$html}</{$this->surround}>";

    }

    /**
     * @param $type input TYPE RADIO
     * @return string
     */
    public function inputRadio($name, array $values)
    {
        echo "<p>select your $name</p>";
        foreach ($values as $value) {
            echo $this->surround(" 
            <div> 
                <input type='radio' id='$value' name = '$name' value = '$value'>
                <label for='$value' >$value</label>
            </div > ");
        }
    }

    public function inputCheckbox($name, array $values)
    {
        echo "select your $name";
        foreach ($values as $value) {
            echo $this->surround("
        <div>
            <input type='checkbox' id='$value'  name='$name' value='$value'>
            <label for='$value'>$value</label>
        </div>
        ");
        }
    }

    /**
     * @return string select utilisé par le form
     */
    public function select($name, array $values)
    {

        echo "<p><label for='$name'>Choose a value:</label></p>
               <select name='$name' id='$name'>
               <option value=''>--Please choose an option--</option>";
        foreach ($values as $value) {
            echo $this->surround("
            <option value='$value'>$value</option>
        
        ");
        }
        echo "</select>";
    }

    /**
     * @return string textarea utilisé par le form
     */
    public function textarea($name, $value)
    {
        return $this->surround("
    <label for='$value'>$name :</label>
        <textarea id='$value' name='$name' rows='5' cols='33'>$value</textarea>"
        );
    }

    /**
     * @return string bouton submit avec choix du texte
     */
    public function submit($html)
    {
        return $this->surround("<button type='submit'>$html</button>");
    }

    /**
     * @param $method ouvre un formulaire avec la method et laction choisis
     * @param $action
     */
    public function openForm($method, $action){
       echo "<form action='$action' method='$method'>";
    }

    /**
     * @return string  button avec choix du texte
     */
    public function button($html, $href)
    {
        return "<a href='$href' target='blank'><button type='button'>$html</button></a>";
    }

    /**
     * ferme un formulaire
     */
    public function closeForm(){
        echo "</form>";
    }

    /**
     * @param $index index de la valeur recup
     * @return mixed|null
     */
    private function getValue($index)
    {
        return isset($this->data[$index]) ? $this->data[$index] : null;
    }
}