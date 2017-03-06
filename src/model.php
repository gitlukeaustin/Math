<?php
    class Model
    {
        function __construct()
        {
            if(!isset($_SESSION['scores']))
            {
                session_start();
                $_SESSION['scores'] = json_decode(file_get_contents("src/model_src/maths.json"));
                 $_SESSION['eleves'] = json_decode(file_get_contents("src/model_src/logins.json"));

                
                $tableau = array();
                $noteurs = array();
                $moyennes = array();
                
                
                /*Initialisation vide des tableaux*/
                foreach($_SESSION['scores'] as $noteur => $array)
                {
                    foreach($array as $matiere => $elevearray)
                    {
                        $moyenn[$matiere] = 0;
                        foreach($_SESSION['eleves'] as $login => $nom)
                        {
                            $noteurs[$login][$matiere] = "";
                            $tableau[$login][$matiere] = 0;
                        }
                    }
                }
                
                
                foreach($_SESSION['scores'] as $noteur => $array)
                {
                    foreach($array as $matiere => $elevearray)
                    {
                        foreach($elevearray as $eleve)
                        {
                            $noteurs[$noteur][$matiere] = $eleve;
                            $tableau[$eleve][$matiere] += 1;
                            $moyenne[$matiere] += 1;
                        }
                    }
                }
                $_SESSION['tableau'] = $tableau;
                $_SESSION['noteurs'] = $noteurs;
                $_SESSION['pourcentages'] = $this->makePourcentages($tableau,$moyenne);
                /*$_SESSION['euler'] = $this->makeEuler($tableau,$moyenne);*/
            }
        }
        
        function makeEuler($p,$q)
        {
            
        }
        
        function makePourcentages($array,$moyennes)
        {
            $return = $array;
            
            foreach($array as $eleve => $elevearray)
            {
                foreach($elevearray as $matiere => $note)
                {
                    $return[$eleve][$matiere] = round($return[$eleve][$matiere]/$moyennes[$matiere],4);
                }
            }
            
            return $return;
        }
    }

?>