<?php
//this doesnt work but we gotta make it work
//so we gotta search "wordpress 3" and get CVEs
//but we cant do that with these 2 apis


$usersCMS=  "wordpress 3";
if ($usersCMS !== "") {
    //This function is made to search the CVE numbers from
    //user's detected cms
    //so it sends "wordpress 3" to CVE search
    $number = $usersCMS;
    echo "<b>" . $number . "</b><br/>";

    // GET REQUEST TO APIs - try one, if it doesnt work try other
    try {
        $url = "https://cve.circl.lu/api/cve/$number";
        $result = file_get_contents($url);
        //echo htmlspecialchars($result);
        $result = json_decode($result);
        $data = $result->capec;
        $num = 1;
        foreach ($data as $d) {
            echo "<u> Vulnerability number " . $num . "</u><br/>";
            if (isset($d->name)) {
                echo "Name:" . $d->name . " <br/>";
            }
            if (isset($d->summary)) {
                echo "Summary:" . $d->summary . " <br/>";
            }
            if (isset($d->prerequisites)) {
                echo "Prerequisites : " . $d->prerequisites . " </br>";
            }
            if (isset($d->solutions)) {
                echo "Solutions : " . $d->solutions . " </br>";
            }

            //echo $d->name;
            //print_r($d);

            $num++;
        }
    } catch (Exception) {
        $url = "https://services.nvd.nist.gov/rest/json/cve/1.0/$number";
        $result = file_get_contents($url);
        echo htmlspecialchars($result);
    }
    //https://www.cve-search.org/api/ (dokumentacija samo)
    //https://cve.circl.lu/api/cve/CVE-2010-3333
    //also whatever this is: https://services.nvd.nist.gov/rest/json/cve/1.0/CVE-2021-45105




} else {
    echo "CVE has not been found.";
}
?>