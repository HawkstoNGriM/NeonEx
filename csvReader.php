<?php 

function findInCsv($query, $version) {
    $row = 1;
    if (($handle = fopen("exploitdb-master/files_exploits.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 0, ",")) !== FALSE) {
        $num = count($data);
        //echo "<p> $num fields in line $row: <br /></p>\n";
        $row++;
        for ($c=0; $c < $num; $c++) {
            if(str_contains(strtoupper($data[$c]), strtoupper($query))){
                //echo $data[2] . " - - " . $data[1] . "<br/>";
                $version2 = " " . $version;
                if(str_contains($data[2], $version2)){
                    echo "[+] " . $data[2] . " - - " . $data[1] . "<br/>";
                }elseif (str_contains($data[2], $version)){
                    echo "[?] " . $data[2] . " - - " . $data[1] . "<br/>";
                } else {}

            }
        }
    }
    fclose($handle);
    }
}

findInCsv("WordPress","3.0");

?>