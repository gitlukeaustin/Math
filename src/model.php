<?php
    class Model
    {
        function __construct()
        {
            if(!isset($_SESSION['scores']))
            {
                session_start();
                $_SESSION['scores'] = json_decode($this->getJSON("http://www.iut-fbleau.fr/projet/maths/?rah_external_output=pagerank.json"));
                 $_SESSION['eleves'] = json_decode($this->getJSON("http://www.iut-fbleau.fr/projet/maths/?rah_external_output=logins.json"));

                
                $tableau = array();
                $noteurs = array();
                $moyennes = array();
                
                foreach($_SESSION['scores'] as $noteur => $array)
                {
                    foreach($array as $matiere => $elevearray)
                    {
                        $moyenn[$matiere] = 0;
                        foreach($_SESSION['eleves'] as $login => $nom)
                        {
                            $noteurs[$noteur][$login][$matiere] = 0;
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
                            $tableau[$eleve][$matiere] += 1;
                            $moyenne[$matiere] += 1;
                        }
                    }
                }
                $_SESSION['tableau'] = $tableau;
                $_SESSION['pourcentages'] = $this->makePourcentages($tableau,$moyenne);
                $_SESSION['euler'] = $this->makeEuler($tableau,$moyenne);

            }
        }
        
        function getJSON($url)
        {
            $c = curl_init();
            curl_setopt($c, CURLOPT_URL,$url);
            curl_setopt($c,CURLOPT_RETURNTRANSFER,1);
            curl_setopt($c,CURLOPT_HEADER,0);
            
            
            curl_init("http://www.iut-fbleau.fr/projet/maths/?rah_external_output=pagerank.json");
            curl_setopt($c, CURLOPT_HEADER, 0);
            
            $result = curl_exec($c);
            curl_close($c);
            
            
            http://www.iut-fbleau.fr/projet/maths/?rah_external_output=logins.json
            return $result;
           
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