<?php
    
    class View
    {
        function __construct()
        {
            
        }
        
        function displayHome($table = null)
        {
            echo include_once("src/view_src/html/body.html");
        }
        
        function createTable($content)
        {
            $begin = "<table class=\"table table-striped\">";
            $table = "";
            foreach($content as $key => $value)
            {
                $table .=  "<tr><td><strong>".$key."</strong></td>";
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