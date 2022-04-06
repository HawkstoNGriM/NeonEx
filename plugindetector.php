<?php 


function pluginDetect($site,$cms){
    //echo "CMS: " . $cms;


    //first lets get the reuqest 
    $site = file_get_contents($site);




    echo "<hr/>";
    echo "<h6>[+] Specific Plugin detection (Medium Accuracy):</h6>";
    //implement word search - use the wp_popular_extensions_list
    //for Wp and for others other.
    $systems = [
        "Wordpress",
        "Joomla",
        "Textpattern"
    ];

    if(strtolower($cms) == strtolower($systems[0])){
        #wordpress
        $dataset = "wp_popular_extensions_list.txt";
    }else if(strtolower($cms) == strtolower($systems[1])){
        #joom
        $dataset = "joom_popular_extensions_list.txt";
    }else if(strtolower($cms) == strtolower($system[2])){
        #textpattern
        $dataset = "textpattern_popular_extensions_list.txt";
    }else {
        echo "<br/>No specific-plugin dataset found.";
    }
    
    if($dataset !== ""){
        #use site variable to check if in it there is queries from a file
        $data = file_get_contents($dataset);
        $data = explode("\n",$data);
        foreach($data as $d){
            if(str_contains($site,$d) && $d !== " " && $d !== "" ){
                echo " ⌚" . $d . " ; " ;  
            }
        }
    }

    

    echo "<hr/>";


    echo "<h6> [?] Word Plugin detection (Low Accuracy):</h6>";

    #find "plugin","plug-in","extension", "theme"
    $possiblePluginNames = ["plugin", "plug-in", "extension", "/theme","add-on","add-in","addon"];

    $arrayOfResults = array();
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
                                if(str_contains($reallyTinyPart, "<") && str_contains($reallyTinyPart,">")){
                                    $reallyTinyPart = str_replace("/>"," ");
                                    $reallyTinyPart = str_replace("<", " ");
                                }

                                #remove html stuff
                                if(str_contains($pluginName, $possiblePluginNames[3])){
                                    //its a theme
                                    $reallyTinyPart = " - " . $pluginName . " #" . "<a href='./exploitFinder.php?query=". $reallyTinyPart . "'>Search Exploit </a>". $reallyTinyPart . "<br/>" ;
                                }else {
                                    $reallyTinyPart = " -<b> " . $pluginName . " #</b>" . "<a href='./exploitFinder.php?query=". $reallyTinyPart . "'>Search Exploit </a>". $reallyTinyPart . "<br/>" ;
                                }
                                
                                

                                array_push($arrayOfResults,$reallyTinyPart);
                                #$reallyTinyPart = htmlentities($reallyTinyPart);
                                #echo "- <b> " . $pluginName . " # </b>" . "<a href='./exploitFinder.php?query=". $reallyTinyPart . "'> Search Exploit </a>". $reallyTinyPart . "<br/>" ;

                            
                            }

                        }

                    }
                }


            }
        }

    }

    #$arrayOfResults = array_unique($arrayOfResults);
    #remove duplicates

    foreach($arrayOfResults as $res){
        #$res = htmlentities($res);

        if(strlen($res) > 300){
            $res = mb_substr($res, 0, 300);
            #echo "More ";
        }
        
        echo $res;


    }

}

#pluginDetect("http://localhost/wordp","wordpress");

?>
