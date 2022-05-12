<?php 

function findInCsvFixes($cms) {
    $datasetfile = "Resources/known_exploited_vulnerabilities.csv";
    if($cms == ""){
        return "";
    }
    else {
        if($cms !== ""){
            if (($handle = fopen($datasetfile, "r")) !== FALSE) {
                while (($data = fgetcsv($handle, 0, ",")) !== FALSE) {

                    if(str_contains(strtoupper($data[1]), strtoupper($cms)) ||  str_contains(strtoupper($data[3]), strtoupper($cms))){
                        if($data[6] !== "" && $data[0] !== ""){
                            echo "🌀 : " .$data[6] . " ($data[0])" . "<br/>";
                        }elseif($data[6] !== ""){
                            echo "🌀 : " .$data[6] . "<br/>";
                        }elseif($data[0] !== ""){
                            echo "🌀 : " ."CMS Update ($data[0])" . "<br/>";
                        }else{}
                        
                    }

                    
                }
            }
        } else{
            return "";
        }
    }
}


#findInCsvFixes("Wordpress");
?>