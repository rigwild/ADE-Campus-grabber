# ADE-Campus-grabber
Script PHP permettant de récupérer un planning sur un site type ADE Campus, au format JSON.
## Installation
Afin de récupérer le planning au format JSON, il faut renseigner l'URL de l'agenda au format .ics dans le fichier getPlanning.php.
## Récupérer l'URL du calendrier
 1. Naviguer vers le planning souhaité
 2. Exporter en ical (Icone agenda avec une flèche en bas)
 3. Date de fin : Mettre une année de limite de l'agenda, 2050 pour sans limite
 4. Client agenda : ICalendar
 5. Générer url
## Configuration
**Changer le format de retour** : modifiez cette ligne dans getPlanning.php :

    $data = getPlanningIut($url, "jsonIndent");
Formats possibles :

 

 - "array" : Retourne un tableau au format PHP
 - "json" : Retourn une chaîne au format JSON
 - "jsonIndent" : Retourne une chaîne au format JSON lisible

---
**Enregistrer le planning dans un fichier :** dé-commentez cette ligne dans getPlanning.php :

    /*saveToFile("planningData.json", $data);*/
