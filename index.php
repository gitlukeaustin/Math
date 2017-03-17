<?php
    include_once("src/controler.php");
    
    class Index
    {
        private $controler;
        function __construct()
        {
            $this->controler = new Controler();
            $this->action();
        }
        
        function action()
        {
            if(isset($_GET['action']))
            {
                if($_GET['action']=="Poids")
                {
                    $this->controler->getPourcentagesTable();
                }
                else if($_GET['action']=="Points")
                {
                    $this->controler->getVotesTable();
                }
                else if($_GET['action']=="Distribution")
                {
                    $this->controler->getDistributionTable();
                }
                else if($_GET['action']=="graphe")
                {
                    $this->controler->getGraphe();
                }
                else if($_GET['action']=="Euler")
                {
                    $this->controler->getSurprise();
                }
            }
            else
            {
                $this->controler->home();
            }
        }
    }

    new Index();
?>
