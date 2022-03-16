<?php



function versionDetectorFunction($url, $cms){
    $ERRORS = 0;
    $systems = [
        "Wordpress",
        "Joomla"
    ];

    //echo $url . " has " . $cms . " ... Detecting version for it. <br/>";
    echo "<br/>Detecting the version for CMS...</br>";

    $versionSource = "";
    foreach($systems as $s){
        if(str_contains(strtoupper($cms), strtoupper($s))){
            //echo $cms . " has CMS:" . $s . "<br/>";
            $versionSource = $s;
            //$cms was "Joomla " and now its "Joomla" - assigned the right one 
            //according to the list
        }
        else{
        }
        
    }
    if($versionSource !== ""){

        // TODO 
        // IMPLEMETN VERSION DETECTION FOR EACH CMS

        if($versionSource == $systems[0]){
            echo "<br/>";
            #System : Wordpress
            $response = file_get_contents($url);
            if(str_contains(strtoupper($response),strtoupper($cms) )) {
                echo "IT CONTAINS";
                //TODO 
            }

        }

        if($versionSource == $systems[1]){
            echo "<br/>";
            #System : Joomla

            $options = ["/administrator/manifests/files/joomla.xml","/includes/version.php","/libraries/joomla/version.php","/libraries/cms/version/version.php","/", "/README.txt"];
            
            foreach($options as $option){
                $url2 = $url . $option;
                //echo "Trying :" . $url2 . "<br/>";
                try{
                    $response = file_get_contents($url2);
                    $response = htmlentities($response);
                    //the version for my /joom is 3.10.4 
                    //echo $response;


                    if(str_contains(strtoupper($response),strtoupper($versionSource) )) {    

                        //check the xml if its it           RENAME TO "version" I PUT THIS TO TEST THE OTHER ONE
                        if(str_contains(strtolower($response), "versionxxx")){
                            //maybe its version=3.10.4
                            //and maybe its <version>3.10.4</version>
                            //echo $response;
                            $response = html_entity_decode($response);
                            if(str_contains($response,"</version")){
                                $response = explode("</version>",$response);
                                $versionDirty = explode("<version>", $response[0]);
                                echo "<br> Version :<br/>" . $versionDirty[1] . "<hr/>"; 
                            }


                        }


                        else if(str_contains(strtolower($response), "version history")){
                            echo "TODO, also rename upper IF when done.";

                            echo "";
                        }

                    }

                } catch(Error $e){
                    echo "<p hidden> " . $e . "</p>";
                }
            }



        }
        //TODO LIKE THIS
    
    }
    else{
        echo "Couldnt find the right system in the list of versionDetect class.";
    }


}

versionDetectorFunction("http://localhost/joom","Joomla ");


    




?>