<html lang="en">
<?php 

require "DetectCMS.php";

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
        <div class="container">
            <a class="navbar-brand" href="./index.php">NeonEx Platform</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        </div>
    </nav>
    <!-- Content section-->
    <section class="py-5">
        <div class="container my-5">
            <div class="row justify-content-center">
                <div class="col-lg-6" id="instructions">
                    <h2>Passive scan of the website : </h2>
                    <p class="lead">
                        <?php

                        if (isset($_GET["site"])) {
                            $site = $_GET["site"];
                            echo $site;

                            //TODO : Implement CMS Detection
                        }
                        ?>

                    </p>
                    <h4>CVE Numbers</h4>
                    <p class="mb-0">
                        

                    <?php
                        //TODO
                        //Flow -> Usersite.com -> wordpress 3 -> which CVEs -> describe contents
                        //use what user inputed to get "wordpress 3" then
                        //use that to find CVEs based on that
                        //then print out CVE content
						if(isset($_GET["site"])){
							$detectCMS = $_GET["site"];
							echo "<p>[+] Detecting CMS for ... " .  $detectCMS . " ...</p>" ;
                            
							try{
							    @$cms = new DetectCMS\DetectCMS($detectCMS);
                                //on linux (lampp xampp) this passes
                                //it doesnt go to Error 
                                //but it doesnt show anything else either?
                            }
                            catch (Exception $e) {
                                echo "Error:" . $e;
                            }
                            
                            
							if ($cms->getResult()) {
								
								@$cmsfound = $cms->getResult();
							
								echo "<br/><b>" . $detectCMS . " has CMS: " . $cmsfound . " </b>";
							
							} else {
								echo "<br/>Couldnt detect CMS. ";
							}
							
							
							
						} else{
							$detectCMS = "Couldnt detect CMS. Something went wrong with the detection module.";
                            echo $detectCMS;
                        }

                        //calls CMS detector and returns CMS
                        //ex. "Wordpress 3"
                        
                        //Then we query for CVE's for "wordpress 3"
                        //and we count them 


                        //x

                        
                        //Implement foreach ^ result
                        $pickedCveNumber =  $detectCMS;
						
						//									removed ! from here !!!!
                        if ($pickedCveNumber !== "" && $pickedCveNumber == false) {


                            $number = $pickedCveNumber;
                            //echo "<br/><b>" . $number . "</b><br/>";

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
                            echo "<br/>CVE number not provided/found.";
                        }

                    ?>

                    </p>
                    <br>
                    <h4>Possible Exploits</h4>
                    <p class="mb-0">
                        <?php
                        echo "Possible " . " XSS " . " for " . " v1.2 " . "sourceNumber" . " 1 (references down)";
                        ?>

                    </p>



                </div>
            </div>
        </div>
    </section>

    <!-- Content section-->
    <section class="py-5">
        <div class="container my-5">
            <div class="row justify-content-center">
                <div class="col-lg-6" id="contact">
                    <p class="lead">References</p>
                    <p class="mb-0">
                        <?php

                        $reference = "exploitdb";

                        echo "Ref : $reference";


                        ?>

                    </p>
                </div>
            </div>
        </div>
    </section>



    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>




</body>

</html>