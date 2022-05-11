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
                        echo "🌀 : " .$data[6] . "<br/>";
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