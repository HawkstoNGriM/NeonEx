<?php



function versionDetectorFunction($url, $cms){
    $ERRORS = 0;
    $systems = [
        "Wordpress",
        "Joomla",
        "Textpattern"
    ];

    //echo $url . " has " . $cms . " ... Detecting version for it. <br/>";
    #echo "<br/>Detecting the version for CMS...</br>";

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
        #WP - DONE
        #JOOM - DONE
        #Textpattern - Not done

        if($versionSource == $systems[0]){
            echo "<br/>";
            #System : Wordpress

            if(str_ends_with($url, "/")){
                $url = substr($url, 0, -1);
                #remove slash
                #hopefully substr works well
            }  

            $options = ["", "/index.php"];
            #first one is index.php which has
            #<meta name="generator" content="WordPress 5.9" />
            
            foreach($options as $option){
                $url2 = $url . $option;
                $url2 = file_get_contents($url2);
                
                #$url2 = htmlentities($url2);
                

                if(str_contains(strtolower($url2), "meta name=") && str_contains(strtolower($url2), "generator" ) ){
                    $url2 = explode('<meta name="generator',$url2);
                    $url2 = $url2[1];
                    $url2 = explode(" />", $url2);
                    $url2 = str_replace("content=","",$url2[0]);
                    $url2 = str_replace('"',"",$url2);
                    #yeah but it still gives " Wordpress 5.9 Wordpress 5.9"
                    #No it doesnt it runs it twice cause for loop - solved with return
                    $url2 = str_replace(strtolower($versionSource),"",strtolower($url2));

                    if(str_contains($url2, " ")){
                        $url2 = str_replace(" ", "", $url2);
                    }
                    if($url2 != ""){
                        if(str_contains(strtolower($url2),strtolower("wpml"))){
                        }else{
                            return $url2;
                        }
                        
                    }
                    return "";
                }

            }
        }

        if($versionSource == $systems[1]){
            echo "<br/>";
            #System : Joomla
            if(str_ends_with($url, "/")){
                $url = substr($url, 0, -1);
                #remove slash
            }  

            $options = ["/administrator/manifests/files/joomla.xml","/includes/version.php","/libraries/joomla/version.php","/libraries/cms/version/version.php","/index.php", "/README.txt"];
            $final_joomla_version = "";
            foreach($options as $option){
                $url2 = $url . $option;
                //echo "Trying :" . $url2 . "<br/>";
                try{
                    $response = file_get_contents($url2);
                    $response = htmlentities($response);
                    //the version for my /joom is 3.10.4 
                    //echo $response;


                    if(str_contains(strtoupper($response),strtoupper($versionSource) )) {    
                        //the IF statements lower are if, elseif -type 
                        //reason for this is we dont wanna detect version 10 times
                    
                        //check the xml if its it 
                        if(str_contains(strtolower($response), "version")){
                            //maybe its version=3.10.4
                            //and maybe its <version>3.10.4</version>
                            $response = html_entity_decode($response);
                            if(str_contains($response,"</version")){
                                $response = explode("</version>",$response);
                                $versionDirty = explode("<version>", $response[0]);
                                $final_joomla_version = $versionDirty[1]; 
                            }
                        }
                        else if(str_contains(strtolower($response), "version history")){
                            //ITS A README.txt
                            // "Joomla! 3.10 version history"

                            $response = html_entity_decode($response);
                            $response = explode("version history",$response);
                            echo "<br/>";
                            $versionDirty = substr($response[0], -10);
                            //echo $versionDirty;
                            if(str_contains($versionDirty, " ")){
                                $versionDirty = explode(" ", $versionDirty);
                                $versionDirty = $versionDirty[1];
                            }else {
                                $versionDirty = explode("!", $versionDirty);
                                if(str_contains($versionDirty[1], " ")){
                                    $versionDirty = str_replace(' ', '', $versionDirty[1]);
                                }
                            }
                            $final_joomla_version = $versionDirty;
                            


                            echo "";
                        } else if(str_contains(strtolower($response), 'meta name=')){
                            #  <meta name="generator" content="Joomla! 1.5 - Open Source Content Management" />
                            $response = html_entity_decode($response);
                            $response = explode("meta name=",$response);
                            foreach($response as $rsp){
                                if(str_contains($rsp, "generator")){
                                    $rsp = explode("content=",$rsp);
                                    foreach($rsp as $r){
                                        if(str_contains(strtolower($r), strtolower("Joomla!"))){
                                            $r = explode("Joomla!", $r);
                                            $r = $r[1];
                                            $r = explode("- Open", $r);
                                            $r = $r[0];
                                            $final_joomla_version = $r;
                                        }
                                    }
                                }
                            }
                        
                        }
                        else {
                            #echo "Couldnt find version in available files.";
                            #it has to be a pass cause loop
                        }

                    }
                    
                } catch(Error $e){
                    echo "<p hidden> " . $e . "</p>";
                }
            }

            return $final_joomla_version;

        }
        
        if($versionSource == $systems[2]){
            #versions can be found in:
            #http://localhost/textpattern-4.8.7/textpattern/textpattern.js
            #http://localhost/textpattern-4.8.7/README.txt

            #echo "<br/>";
            #System : TextPattern

            if(str_ends_with($url, "/")){
                $url = substr($url, 0, -1);
                #remove slash
            }  
            
            $options = ["/README.txt", "/textpattern/textpattern.js","/textpattern.js"];
            #two times textpattern.js - cause it depends on the directories
            foreach($options as $option){
                
                $url2 = $url . $option;
                $url2 = file_get_contents($url2);
                if($option == $options[0]){
                    if(str_contains($url2, "Textpattern CMS ")){
                        #split by "Released"
                        $result = explode("Released",$url2);
                        $result = explode("CMS",$result[0]);
                        $result = $result[1];
                        $result = str_replace(" ", "",$result);
                        if($result !== ""){
                            return $result;
                        }
                    }
                }
                if($option == $options[1] || $option == $option[2]){
                    if(str_contains($url2, "textpattern.version = ")){
                        #Split by that textpattern.version =
                        $result = explode("textpattern.version = ", $url2);
                        $result = explode("';",$result[1]);
                        $result = $result[0];
                        $result = str_replace("'","",$result);
                        if($result !== ""){
                            return $result;
                        }
                        
                    }
                }

            
            }

        }
    
    }
    else{
        echo " Couldnt find the right system in the list of versionDetect class.";
    }


}

#$data = versionDetectorFunction("http://localhost/joom/"," Joomla ");
#echo $data;

    




?>