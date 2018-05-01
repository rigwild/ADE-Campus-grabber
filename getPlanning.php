<?php

require 'functions.php';

/*On applique un header de format JSON*/
header('Content-Type: application/json');

/*
URL de l'agenda .ICS à récupérer
Pour avoir une URL valide : 
1) Cliquer sur le planning souhaité et exporter en ical (Icone agenda avec une flèche en bas)
2) Date de fin : Mettre une année de limite de l'agenda, 2050 pour sans limite
3) Client agenda : ICalendar
4) Générer url
*/
$url = "https://edt.univ-littoral.fr/jsp/custom/modules/plannings/anonymous_cal.jsp?data=8241fc38732002149a9170a9182ea439bbe7663ee0168cb843bd7f0cc72d1aa08bb0a3cf5f01988a02551ee70088f8ff9bc7373a41a22325b7eb221266d57b00f9c4bc151f5a340023a6cf13bb3fe7a7f377b612dec2c5fba5147d40716acb1388637ba1215f9317";

/*Récupérer le planning*/
$data = getPlanningIut($url, "jsonIndent");

/*Enregistrer le planning dans un fichier*/
/*saveToFile("planningData.json", $data);*/

/*Afficher le JSON sur la page*/
echo $data;

?>