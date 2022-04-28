<html lang="en">
<?php 

#detects cms
require "DetectCMS.php";

#require version detection
require "versionDetect.php";

#finds exploits for query type "wordpress" 
require "exploitFinder.php";

#implement Csv readers
require "csvReaderForCVEs.php";
require "csvReaderForExploits.php";

#require plugindetector
require "plugindetector.php";




$cmsfound = "";
$foundCVEs = array();
?>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>NeonEx Platform</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/styles.css" rel="stylesheet" />
</head>

<body>
    <!-- Responsive navbar-->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark" id="top">
        <div>
            <a class="navbar-brand" href="./index.php">&nbsp;&nbsp;&nbsp; NeonEx Platform &nbsp;&nbsp;</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        </div>
    </nav>

   
    <div class="row">
        <div class="col-md-6" style="background-color:#e6e6e6;">
            <br/>
            <h4 class="alert alert-dark" style="margin-left:1%;">Site: 
                <?php
                    if (isset($_GET["site"])) {
                        $site = $_GET["site"];
                        echo  $site ;
                    }else{
                        echo "GET not set.";
                    }
                    ?>
            </h4>
        
            <hr/>
            <br/>


            <?php

                $detectCMS = "";
                $cmsfound = "";
                if(isset($_GET["site"])){
                    
                    $detectCMS = $_GET["site"];
                    //echo "<p > Detecting CMS for ... " .  $detectCMS . " ...</p>" ;
                    

                    # THE WHOLE THING BREAKS HERE
                    
                    try{
                        
                        @$cms = new DetectCMS\DetectCMS($detectCMS);
                        //on linux (lampp xampp) this passes
                        //it doesnt go to Error 
                        //but it doesnt show anything else either?
                    }
                    catch (Exception $e) {
                        echo "Error:" . $e;
                    }

                    # THE WHOLE THING BREAKS HERE


                    if ($cms->getResult()) {

                        @$cmsfound = $cms->getResult();

                        echo "<b class='alert alert-dark' style='margin-left:1%;'>[+] Detected CMS: <u>" . $cmsfound . "</u> </b>";

                        //do cve detection - try nd get cve number from cmsfound
                        $pickedCveNumber =  $cmsfound;
                
                    
                    } else {
                        echo "<br/>Couldnt detect CMS.. ";
                    }
                    
                    
                } else{
                    echo "<br/>Couldnt detect CMS. ";
                }

                echo "<br><hr>";
                if($cmsfound !== "" && $detectCMS !== ""){
                    $versionFound = versionDetectorFunction($detectCMS,$cmsfound);
                }else {
                    echo "<br/> DetectCMS or CMSfound variables seem empty.";
                }
                

                echo "<p class='alert alert-dark' style='padding:5; margin-left:1%; margin-right:2%;'> Detected Version: <b>" . $versionFound . "</b> </p>";

                echo "<hr>";


                echo " UNCOMMENT ME (x2) ! <br/>";
                echo "<h4 class='alert alert-dark' style='padding:5; margin-left:1%; margin-right:2%;'> CSV Search </h4>";
                
                /*
                $printvar_expl = findInCsv($cmsfound,"3.0","Resources/files_exploits.csv");
                $countery = 0;
                foreach($printvar_expl as $pve){
                    #divide into seperate arrays
                    if($countery == 0){
                        echo "<br/><h4>Possible Exploits</h4><hr/>";
                        echo "<br/>";
                    } else if ($countery == 1) {
                        echo "<br/><h4>Possible Related Exploits</h4><hr/>";
                        echo "<br/>";
                    }
                    foreach($pve as $v){
                        #"- -" in $v
                        if(str_contains($v, "- -")){
                            $explNumForUrl = explode("- -",$v);
                            $explNumForUrl = $explNumForUrl[1];
                            $explNumForUrl = explode("/",$explNumForUrl);
                            $explNumForUrl = end($explNumForUrl);
                            #should get the last thing - number 
                            $explNumForUrl = explode(".",$explNumForUrl);
                            $explNumForUrl = $explNumForUrl[0];
                            #cause 89213.txt 
                            #we just need the number

                            $refForExploit = "<a href='https://www.exploit-db.com/exploits/" . $explNumForUrl . "'> Exploit </a>";
                        }else {
                            $refForExploit = "";
                        }
                        echo $v . " " . $refForExploit . "<br/>";
                    
                    }
                    $countery += 1;
                }
                */
                
                echo  "<hr/> <br/>";
                /*
                $printvar_cves = findInCsvx($cmsfound,"3.0","Resources/allCVEs2022.csv");
                $counterx = 0;
                foreach($printvar_cves as $pvc){
                    #divide into seperate arrays
                    if($counterx == 0){
                        echo "<h4>Possible Vulnerabilities</h4><hr/>";
                        echo "<br/>";
                    } else if ($counterx == 1){
                        echo "<h4>Possible Related Vulnerabilities</h4><hr/>";
                        echo "<br/>";
                    }

                    foreach($pvc as $p){
                        echo $p;
                        #seperate all cves into array for later:
                        #preg_match("CVE\-\d+\-\d+", $printvar_cves, $foundCVEs);
                    }
                $counterx += 1;
                }

                */

            ?>

            <h4 class="alert alert-dark" style="margin-left:1%;">Plugins</h4>
            <p><i><b>[ Hint ]</b> This website scan isn't agressive. This type of detection only displays SOME/Possible plugins.</i></p>
            <?php 
            if (isset($_GET["site"])) {
                #echo "UNCOMMENT ME";
                #$site = $_GET["site"];
                #$resultPlugin = pluginDetect($site,$cmsfound);
                #echo $resultPlugin;


            }

            ?>           
            <br>


        </div>

        <div class="col-md-6" style="background-color:Whitesmoke;">
            <br/>
            <h4 class="alert alert-dark">Possible Exploits</h4>
            <?php
                echo "Attempting exploit finding for CMS (Using APIs) : $cmsfound <br/><hr/>";
                
                if($cmsfound !== ""){

                    echo "<br/> UNCOMMENT ME <br/>";

                    ////for version stuff:
                    //$cmsfoundplusversion = $cmsfound . " " . "3.0";
                    ////replace cmsfound          v       with $cmsfoundplusversion
                    #$cmsfound = $cmsfound . " " . "3.0";
                    #$exploits = exploitFinder($cmsfound);
                    #foreach($exploits as $expl) {
                    #    echo $expl;
                    #}

                }
                else {
                    echo "CMS Couldn't pass to detection script.";
                }

            ?>
            <br/><hr>
            <h4 class="alert alert-dark">Possible Fixes</h4>
            <?php 
                if($cmsfound != ""){
                    #echo "<b>". $cmsfound . " Security fixes (options):</b> ";
                    $link = "https://www.cvedetails.com/vulnerability-list/vendor_id-3496/$cmsfound.html";
                    echo "<p> <b> $cmsfound </b> CVEs and their descriptions: <a target=_blank href=" . $link . "> Here </a></p>";
                    

                    echo "UNCOMMENT ME   ";
                    /*
                    try {
                            $advisories = file_get_contents("https://rss.packetstormsecurity.com/files/tags/advisory/$cmsfound");
                            $xml = simplexml_load_string($advisories);
                            if ($xml === false) {
                                echo "No data loaded. General advisories : " . "<a href='https://rss.packetstormsecurity.com/files/tags/advisory/'> Here </a>";
                            } else {
                                echo "<p> Latest advisories from PacketStorm : </p>";
                                foreach($xml as $entry){
                                    foreach($entry as $en){
                                        #print_r($en);
                                        if($en->title !== ""){
                                            if($en->link != "" && $en->title != "" && $en->title != "Packet Storm"){
                                                echo "🌀: " . $en->title . " <a target=_blank href='". $en->link ."'>╔SOURCE╗</a> - 🗄:". $en->description . "<hr/>";
                                            }
                                            

                                        }
                                        
                                    }
                                } 

                            }
                        } catch(Exception $e){
                            echo $e;
                    }

                    */
                    
                }


            ?>
            <br/>
            <br/>
            <p><b>Or visit our </b> <a href="vulnfix.html"> Vulnerability Fixing Recommendations </a> site.  
            <br/>
        </div>

    </div>

    


    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>




</body>

</html>










<!-- LOOK UP SPECIFIC CVE NUMBER DETAILS
echo "<br/><b> Looking up CVEs for: " . $number . "</b><br/>";
        
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
        
        
        
        
 -->