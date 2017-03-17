<?php
    class Model
    {
        /* Le constructeur récupère les données, les formatte, et les stocke dans des variables de session. */
        function __construct()
        {
            if(!isset($_SESSION['scores']))
            {
                session_start();
                
                /* Les données sont récupérées */
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
                
                /*Formatage des tableuax*/
                foreach($_SESSION['scores'] as $noteur => $array)
                {
                    foreach($array as $matiere => $elevearray)
                    {
                        foreach($elevearray as $eleve)
                        {
                            $noteurs[$noteur][$matiere] = $eleve; /* stockage de qui a voté pour qui */
                            $tableau[$eleve][$matiere] += 1; /* calcul du nombre de votes pour un élève/matière */
                            $moyenne[$matiere] += 1; /* calcul du nombre de votes de chaque matière*/
                        }
                    }
                }
                
                $noteurs['total'] = $this->calculerPremiers($tableau);
                $tableau['total'] = $moyenne;
                $_SESSION['tableau'] = $tableau; /* montre le nombre brut de votes q'à recu un élève. */
                $_SESSION['noteurs'] = $noteurs; /* montre qui a voté pour qui */
                $_SESSION['pourcentages'] = $this->makePourcentages($tableau,$moyenne); /* montre le pourcentage de votes qu'a recu un élève dans une matière. */
                $_SESSION['euler'] = $this->makeEuler($_SESSION['pourcentages'],$noteurs); /* montre la surprise d'un vote */
            }
        }
        
        /* Calcule des élèves qui ont reçu le plus de votes. */
        function calculerPremiers($tableau)
        {
            $max = array();
            $e = array();
            foreach($tableau as $eleve =>$a)
            {
                foreach($a as $matiere => $score)
                {
                    if(($e[$matiere]==null)||($max[$matiere]<$score))
                    {
                        $max[$matiere] = $score;
                        $e[$matiere] = $eleve;
                    }
                }
            }
            return $e;
        }
        
        /* Calcule du surprise de chaque vote. */
        function makeEuler($pourcentages,$noteurs)
        {
            $surprise = $noteurs;
            $moyenne = array();	
            foreach($noteurs as $nlogin => $marray)
            {
                foreach($marray as $nmatiere => $eleve)
                {
                    if(strlen($eleve)>0)
                    {
                        $surprise[$nlogin][$nmatiere] = round(-log($pourcentages[$eleve][$nmatiere]),6);
                        $moyenne[$nlogin]["nombredevotes"] += 1;
                        $moyenne[$nlogin]["logs"] += $surprise[$nlogin][$nmatiere];
                    }
                    else
                    {
                        $surprise[$nlogin][$nmatiere] = null;
                        $moyenne[$nlogin]["nombredevotes"] += 0;
                        $moyenne[$nlogin]["logs"] += 0;	

                    }
                }
            }            

            foreach($moyenne as $nlogin => $moyarray)
            {
                $surprise[$nlogin]["Surprise Globale"] = ($moyarray["nombredevotes"]>0)?($moyarray["logs"]/$moyarray["nombredevotes"])+(-log($moyarray["nombredevotes"])):null;
            }
            return $surprise;
        }
        
        /* Calcul du pourcentage de votes qu'a reçu un élève. */
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
        
        /* Formatte un tableau pour le plugin CanvasJS */
        function createGraphe($etudiant)
        {
            $graphe = array();
            $i = 0;
            foreach($_SESSION['euler'][$etudiant] as $nommatiere => $surprise)
            {
                $graphe[$i]['label'] = $nommatiere;
                $graphe[$i]['y'] = $surprise;
                $graphe[$i]['color'] = "blue";
                $i++;
                $graphe[$i]['label'] = "Surprise minimum pour ".$nommatiere;
                $graphe[$i]['y'] = $_SESSION['euler']['total'][$nommatiere];
                $graphe[$i]['color'] = "grey";
                $i++;
            }
            return $graphe;
        }
    }

?>
