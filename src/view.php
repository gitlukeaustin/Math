<?php
    /* 
        La classe View génère un tableau en format HTML.
     */
    class View
    {
        function __construct()
        {
            
        }
        
        function displayHome($table = null)
        {
            return include_once("src/view_src/html/body.html");
        }
        
        function createTable($content,$nomdif = null)
        {
            $begin = "<table class=\"table table-striped\">";
            $table = "";
            foreach($content as $key => $value)
            {
                $table .=  "<tr><td><a onclick=\"makeGraphe('".$key."')\"><strong>".((isset($nomdif)&&($key=="total"))?$nomdif:$key)."</strong></a></td>";
                $head = "<th>";
                foreach($value as $kv => $iv)
                {
                    $head .= "<td>".$kv."</td>";
                    $table .= "<td>".$iv."</td>";
                }
                $table .= "</tr>";
                $head .= "</th>";
            }
            $table .= "</table>";
            return $begin.$head.$table;
        }
    }
?>
