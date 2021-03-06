<?php
    include_once("src/model.php");
    include_once("src/view.php");
    
    class Controler
    {
        private $model;
        private $view;
        
        function __construct()
        {
            $this->model = new Model();
            $this->view = new View();
        }
        
        function home()
        {
            $this->view->displayHome(isset($_SESSION['tableau'])?$this->view->createTable($_SESSION['tableau']):"");
        }
        
        function getVotesTable()
        {
            echo $this->view->createTable($_SESSION['tableau']);
        }
        
        function getPourcentagesTable()
        {
            echo $this->view->createTable($_SESSION['pourcentages']);
        }
        
        function getDistributionTable()
        {
            echo $this->view->createTable($_SESSION['noteurs'],"palmarès");
        }
        
        function getGraphe()
        {
            echo json_encode($this->model->createGraphe($_POST['etudiant']));
        }

        function getSurprise()
        {
            echo $this->view->createTable($_SESSION['euler'],"surprise minimum");
        }
    }
?>
