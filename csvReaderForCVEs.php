<?php 
#HINT: if ur using LAMPP (linux xampp) keep in mind that server might
#give u error 500, just look into your php log file (mine is at /opt/lampp/logs)
#it will show you its actually a php error


#data[0 is a CVE number
# 2 is desc
# 1 is status
# 3 is sauces 

function findInCsvx($query, $version,$datasetfile) {
    //echo $query . $version . $datasetfile;

    $relatedVulns = [];
    $mainVulns = [];
    $row = 1;
    if (($handle = fopen($datasetfile, "r")) !== FALSE) {
        
        while (($data = fgetcsv($handle, 0, ",")) !== FALSE) {
            
            $num = count($data);
            //echo "<p> $num fields in line $row: <br /></p>\n";
            $row++;
            for ($c=0; $c < $num; $c++) {


                if(str_contains(strtoupper($data[$c]), strtoupper($query))){
                    //checked if "wordpress"  in entry
                    $version2 = " " . $version;
                    //now lets check for versions


                    if(str_contains($data[3], $version2)){
                        
                        //implement status check
                        $mainEntrysample = "[+] " . $data[0] . " 💉 " . $data[2] . " 📕 : " . $data[1] . " ⛓: " . $data[3];
                        array_push($mainVulns, $mainEntrysample);
                    }
                    else {
                        //so if not " 3.0" in string, myb there is "3.0" itself
                        //as in wordpress3 or wordpress 3.0 
                        //we gotta implement string seperation to only lead by the first number
                        //maybe, idk
                        //TODO
                        if(str_contains($data[3], $version)){
                            if(str_contains($data[3],$version2)){
                                //pass
                            }else{
                                $entry = "[?] " . $data[0] . " 💉 " . $data[2] . " 📕 : " . $data[1] . " ⛓: " . $data[3];
                                array_push($relatedVulns, $entry);
                            }
                        }
                    }

                }


            }
        
        }
        fclose($handle);
        
        if(count($mainVulns) !== 0){
            //Clean up the array, remove duplicates 
            $mainVulns = array_unique($mainVulns);

            echo "<h4>Vulnerabilities Found</h4><hr/>";
            foreach($mainVulns as $vals){
                echo htmlentities($vals);
                echo "<br/>";
            }
        }

        if(count($relatedVulns) !== 0){
            //Clean up the array, remove duplicates 
            $relatedVulns = array_unique($relatedVulns);

            echo "<h4>Possible Related Vulnerabilities</h4><hr/>";
            foreach($relatedVulns as $rv){
                echo htmlentities($rv);
                echo "<br/>";
            }
        }
        
        
    }


}



//findInCsvx("WordPress","3.0","Resources/allCVEs2022.csv");

?>
