<?php



function versionDetectorFunction($url, $cms){
    $ERRORS = 0;
    $systems = [
        "Wordpress",
        "Joomla"
    ];

    echo $url . " has " . $cms . " ... Detecting version for it. <br/>";
    
    $versionSource = "";
    foreach($systems as $s){
        if(str_contains($cms, $s)){
            echo $cms . " has CMS:" . $s . "<br/>";
            $versionSource = $s;
        }
        else{
        }
        
    }
    if($versionSource !== ""){
        echo "Checked the name, now its not 'Joomla_1' or whatever, its 'Joomla' - ready for testing.";
    
        // TODO 
        // IMPLEMETN VERSION DETECTION FOR EACH CMS

        if($versionSource == $systems[0]){
            echo "WP IT";
        }

        if($versionSource == $systems[1]){
            echo "JOOM IT";
        }
        //TODO LIKE THIS
    
    }
    else{
        echo "Couldnt find the right system in the list of versionDetect class.";
    }


}

versionDetectorFunction("http://localhost/joom","Joomla x");


    




?>