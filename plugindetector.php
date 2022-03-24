<?php 


function pluginDetect($site,$cms){
    //echo "CMS: " . $cms;


    //first lets get the reuqest 
    $site = file_get_contents($site);




    echo "<hr/>";
    echo "<h6>[+] Specific Plugin detection (High/Medium Accuracy):</h6>";
    //implement word search - use the wp_popular_extensions_list
    //for Wp and for others other.
    echo "<br/>";

    echo "<hr/>";


    echo "<h6> [?] Word Plugin detection (Medium/Low Accuracy):</h6>";
    echo "<br/>";

    #find "plugin","plug-in","extension", "theme"
    $possiblePluginNames = ["plugin", "plug-in", "extension", "/theme","add-on","add-in","addon"];

    foreach($possiblePluginNames as $pluginName){
        $pluginName = strtolower($pluginName); 
        $site = strval($site);
        $site = strtolower($site);
        //change it all to lower strings

        $siteTextified = explode("/>",$site);
        foreach($siteTextified as $part){
            if(str_contains($part, $pluginName)){
                $part = explode("<",$part);
                foreach($part as $miniPart){
                    if(str_contains($miniPart, $pluginName)){ 
                        $miniPart = explode("=", $miniPart);
                        foreach($miniPart as $reallyTinyPart){
                            if(str_contains($reallyTinyPart, $pluginName)){
                                $reallyTinyPart = htmlentities($reallyTinyPart);
                                echo "<b> Possible [>] " . $pluginName . " - </b>". $reallyTinyPart .  "<br/>";
                            
                            }

                        }

                    }
                }


            }
        }

    }


}


?>