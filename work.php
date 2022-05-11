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
require "csvReaderForFixes.php";

#require plugindetector
require "plugindetector.php";



#supress boring file_Get_contents 403/404 warnings
error_reporting(E_ALL ^ E_WARNING);

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
                    

     
                    
                    try{
                        @$cms = new DetectCMS\DetectCMS($detectCMS);
                    }
                    catch (Exception $e) {
                        echo "Couldnt detect CMS. <br/>Error:" . $e;
                    }



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

                #echo "<br>";
                if($cmsfound !== "" && $detectCMS !== ""){
                    $versionFound = versionDetectorFunction($detectCMS,$cmsfound);
                }else {
                    echo "CMS Wasn't detected, so can't detect version either.";
                    $versionFound = "";
                }
                

                echo "<br/><p style='padding:5; margin-left:1%; margin-right:2%;'>🌑 Detected Version: <b>" . $versionFound . "</b> </p>";

                echo "<hr>";


                #echo " UNCOMMENT ME (x2) ! <br/>";
                echo "<h4 class='alert alert-dark' style='padding:5; margin-left:1%; margin-right:2%;'> CSV Search </h4>";
                //SEGMENT
                try{
                    if($versionFound !== "" && strlen($versionFound) > 0){
                        $printvar_expl = findInCsv($cmsfound,$versionFound,"Resources/files_exploits.csv");
                    }elseif ($cmsfound !== "" && strlen($cmsfound) > 0 ){
                        echo "<p hidden> Couldnt detect version, running general search</p>";
                        $printvar_expl = findInCsv($cmsfound,"","Resources/files_exploits.csv");
                    }else {
                        $printvar_expl = "";
                    }
                    $countery = 0;
                    
                    if($printvar_expl !== ""){
                        foreach($printvar_expl as $pve){
                            #divide into seperate arrays
                            if($countery == 0){
                                echo "<br/><h4>Possible Exploits</h4><hr/>";
                            } else if ($countery == 1) {
                                echo "<br/><h4>Possible Related Exploits</h4><hr/>";
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
    
                                #implement this: if no version
                                #then dont do POSSIBLE 
                                #only do basic
                                if(strlen($versionFound) > 0){
                                    echo $v . " " . $refForExploit . "<br/>";
                                }else{
                                    if($countery == 1){
                                        #pass
                                    }else{
                                        echo $v . " " . $refForExploit . "<br/>";
                                    }
                                }
                                
                            
                            }
                            $countery += 1;
                        }
                    } else {
                        echo "<br/> Undetected version or CMS - can't show exploits.";
                    }

                } catch(Exception $xr){
                    echo "<br/> $xr";
                }
                //SEGMENT
                echo  "<hr/>";
                //SEGMENT
                try{
                    if($versionFound !== "" && strlen($versionFound) > 0){
                        $printvar_cves = findInCsvx($cmsfound,$versionFound,"Resources/allCVEs2022.csv");
                    }elseif ($cmsfound !== "" && strlen($cmsfound) > 0 ) {
                        echo "<p hidden> Couldnt detect version, running general search</p>";
                        $printvar_cves = findInCsvx($cmsfound,"","Resources/allCVEs2022.csv");
                    } else{
                        $printvar_cves = "";
                    }
                    
                    if($printvar_cves !== ""){
                        $counterx = 0;
                        foreach($printvar_cves as $pvc){
                            #divide into seperate arrays
                            if($counterx == 0){
                                echo "<br/>";
                                echo "<h4>Possible Vulnerabilities</h4><hr/>";
                            } else if ($counterx == 1){
                                echo "<br/>";
                                echo "<h4>Possible Related Vulnerabilities</h4><hr/>";
                            }
    
                            foreach($pvc as $p){
                                echo $p;
                                #seperate all cves into array for later:
                                #preg_match("CVE\-\d+\-\d+", $printvar_cves, $foundCVEs);
                            }
                        $counterx += 1;
                        }
                    }else {
                        echo "<br/> Undetected version or CMS - can't show CVEs.";
                    }

                    
                } catch(Exception $wrp){
                    echo "<br/> $wrp";
                }
                //SEGMENT

            ?>

           <!-- Plugins were here -->


        </div>

        <div class="col-md-6" style="background-color:Whitesmoke;">
            <br/>
            <h4 class="alert alert-dark">Possible Exploits</h4>
            <?php
                echo "Attempting exploit finding for CMS (Using APIs) : $cmsfound <br/><hr/>";
                
                if($cmsfound !== ""){

                    #echo "<br/> UNCOMMENT ME <br/>";

                    //SEGMENT
                    try{
                        if($versionFound !== "" && strlen($versionFound) > 0){
                            $cmsfoundplusversion = $cmsfound . " " . $versionFound;
                        }else{
                            $cmsfoundplusversion = $cmsfound;
                        }
                        $exploits = exploitFinder($cmsfoundplusversion);
                        
                        #print_r($exploits);
                        if($exploits !== "" && count($exploits) > 0){
                            foreach($exploits as $expl) {
                                echo '<p style="font-size:10px;">';
                                echo $expl;
                                echo "<hr>";
                                echo "</p>";
                            }
                        }

                    } catch(Exception $wpw){
                        echo "<br/> $wpw";
                    }   
                    
                    //SEGMENT

                }
                else {
                    echo "CMS Couldn't pass to detection script.";
                }

            ?>
            

            <h4 class="alert alert-dark" style="margin-left:1%;">Plugins</h4>
            <?php 
            if (isset($_GET["site"])) {
                #echo "UNCOMMENT ME";
                //SEGMENT
                try{
                    $siteToPlug = $_GET["site"];
                    $resultPlugin = pluginDetect($siteToPlug,$cmsfound);
                    echo $resultPlugin;
                } catch(Exception $e){
                    echo $e;
                }
                
                //SEGMENT
            }

            ?>           
            <br>

            <h4 class="alert alert-dark">Possible Fixes</h4>
            <?php 
                if($cmsfound != ""){
                    #echo "<b>". $cmsfound . " Security fixes (options):</b> ";
                    $link = "https://www.cvedetails.com/vulnerability-list/vendor_id-3496/$cmsfound.html";
                    echo "<p> <b> $cmsfound </b> CVEs and their descriptions: <a target=_blank href=" . $link . "> Here </a></p>";
                    

                    #echo "UNCOMMENT ME   ";
                    //SEGMENT
                    
                    try {
                            $advisories = file_get_contents("https://rss.packetstormsecurity.com/files/tags/advisory/$cmsfound");
                            $xml = simplexml_load_string($advisories);
                            if ($xml === false) {
                                echo "No advisories found for $cmsfound. ";
                            } else {
                                echo "<p> Latest advisories (ignores CMS version) from PacketStorm : </p>";
                                foreach($xml as $entry){
                                    foreach($entry as $en){
                                        #print_r($en);
                                        if($en->title !== ""){
                                            if($en->link != "" && $en->title != "" && $en->title != "Packet Storm"){
                                                if(str_contains(strtolower($en->link),strtolower($cmsfound)) || str_contains(strtolower($en->title), strtolower($cmsfound))  ) {
                                                    echo "🌀: " . $en->title . " <a target=_blank href='". $en->link ."'>╔SOURCE╗</a> - 🗄:". $en->description . "<hr/>";
                                                } elseif(str_contains(strtolower($en->description), strtolower($cmsfound))){
                                                    echo "🌀: " . $en->title . " <a target=_blank href='". $en->link ."'>╔SOURCE╗</a> - 🗄:". $en->description . "<hr/>";
                                                }
                                                
                                            }
                                        }
                                        
                                    }
                                } 
                            }
                            echo "<b>General advisories</b> : " . "<a href='https://rss.packetstormsecurity.com/files/tags/advisory/'> Here </a>";
                        } catch(Exception $e){
                            echo $e;
                    }

                    
                    //SEGMENT
                    
                }

                echo "<br/>";
                
                if($cmsfound !== ""){
                    try{
                        echo "<br/><b> Showing all found Required actions found for $cmsfound (Generally):</b><br/>";
                        $fixesCsv = findInCsvFixes($cmsfound);
                        echo $fixesCsv;
                    } catch(Exception $fixerror){
                        echo "Required actions not detected for this CMS. $fixerror";
                    }

                }


            ?>
            <br/>
            <p><b>Or visit our </b> <a href="vulnfix.html"> Vulnerability Fixing Recommendations </a> site.  
            <br/>
            <hr/>
        </div>

    </div>

    


    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>




</body>

</html>


<!-- Platform developed by F.O. - FFOS Student for the Masters thesis thing -->
<!-- Hawkston Grim software -->