<?php
/**
 * Created by PhpStorm.
 * User: ritu
 * Date: 10/9/18
 * Time: 6:41 PM
 */
<?php
function build_table($array){
    // start table
    $html = '<table>';
    // header row
    $html .= '<tr>';
    foreach($array[0] as $key=>$value){
        $html .= '<th>' . htmlspecialchars($key) . '</th>';
    }
    $html .= '</tr>';

    // data rows
    foreach( $array as $key=>$value){
        $html .= '<tr>';
        foreach($value as $key2=>$value2){
            $html .= '<td>' . htmlspecialchars($value2) . '</td>';
        }
        $html .= '</tr>';
    }

    // finish table and return it

    $html .= '</table>';
    return $html;
}

/**
 * Created by PhpStorm.
 * User: kwilliams
 * Date: 10/1/18
 * Time: 9:23 PM
 */

main::start("example.csv");

class main  {

    static public function start($filename) {

        $records = csv::getRecords($filename);
        $table = html::generateTable($records);


    }
}

class html {

    public static function generateTable($records) {

        $count = 0;
        echo "<html lang=\"en\">
                    <head>
                    <title>Assignment 1</title>
                  <meta charset=\"utf-8\">
                  <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
                  <link rel=\"stylesheet\" href=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css\">
                  <script src=\"https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js\"></script>
                  <script src=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js\"></script>
                </head>
                <body>";
        echo "<table  class=\"table table-striped\">";
        foreach ($records as $record) {
            echo "<tr>";
            if($count == 0) {

                $array = $record->returnArray();
                $fields = array_keys($array);
                $values = array_values($array);

                foreach ($fields as $field) {
                    echo "<th>";
                    print_r($field);
                    echo "</th>";
                }
                echo "</tr><tr>";
                foreach ($values as $value) {
                    echo "<td>";
                    print_r($value);
                    echo "</td>";
                }

            } else {
                $array = $record->returnArray();
                $values = array_values($array);
                //print_r($values);
                foreach ($values as $value) {
                    echo "<td>";
                    print_r($value);
                    echo "</td>";
                }
            }
            echo "</tr>";
            $count++;
        }
        echo "</table>";
    }
}

class csv {


    static public function getRecords($filename) {

        $file = fopen($filename,"r");

        $fieldNames = array();

        $count = 0;
        $records=array();

        while(! feof($file))
        {

            $record = fgetcsv($file);
            if($count == 0) {
                $fieldNames = $record;
            } else {
                $records[] = recordFactory::create($fieldNames, $record);
            }
            $count++;
        }

        fclose($file);
        return $records;

    }

}

class record {

    public function __construct(Array $fieldNames = null, $values = null )
    {
        $record = array_combine($fieldNames, $values);

        foreach ($record as $property => $value) {
            $this->createProperty($property, $value);
        }

    }

    public function returnArray() {
        $array = (array) $this;

        return $array;
    }

    public function createProperty($name = 'first', $value = 'keith') {

        $this->{$name} = $value;

    }
}

class recordFactory {

    public static function create(Array $fieldNames = null, Array $values = null) {


        $record = new record($fieldNames, $values);

        return $record;

    }
}














