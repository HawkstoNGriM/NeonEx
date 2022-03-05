<?php 
header('Content-Type: text/html; charset=utf-8');

?>
<!DOCTYPE html>
<html lang="en">
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
                <a class="navbar-brand" href="#!">NeonEx Platform</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="#!">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="#instructions">Usage</a></li>
                        <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Header - set the background image for the header in the line below-->
        <header class="py-5 bg-image-full" style="background-image: url('./img/colorful.png') ">
            <div class="text-center my-5">
				<form method="GET" action="work.php"> 
					<input type="text" name="site"/>
					<input type="submit" value=" " style="opacity: 10%;"/>
				</form>
				<br/><br/>
                <h1 class="text-white fs-3 fw-bolder">Scan your website's CMS</h1>
                <p class="text-white-50 mb-0">Just input the URL with the protocol.</p>
            </div>
        </header>
        <!-- Content section-->
        <section class="py-5">
            <div class="container my-5">
                <div class="row justify-content-center">
                    <div class="col-lg-6" id="instructions" >
                        <h2 >Usage & possible issues</h2>
                        <p class="lead">Just enter your URL into the search bar. Please use this tool legally and responsibly.</p>
                        <h4>Q: How do i ?</h4>
                        <p class="mb-0">Dont even trip dude</p>
                        <br>
                        <h4>Q: How do i ?</h4>
                        <p class="mb-0">Dont even trip dude</p>

                    </div>
                </div>
            </div>
        </section>
        <!-- Image element - set the background image for the header in the line below-->
        <div class="py-5 bg-image-full" style="background-image: url('./img/black.png') ">
            <!-- Put anything you want here! The spacer below with inline CSS is just for demo purposes!-->
            <div style="height: 20rem"></div>
        </div>
        <!-- Content section-->
        <section class="py-5">
            <div class="container my-5">
                <div class="row justify-content-center">
                    <div class="col-lg-6" id="contact">
                        <p class="lead">Contact</p>
                        <p class="mb-0">Currently you can only contact us at our Github. I'm not planning to open a communication line except Github in some time</p>
                    </div>
                </div>
            </div>
        </section>
        <!-- Footer-->
        <footer class="py-5 bg-dark">
            <div class="container"><p class="m-0 text-center text-white">Created by F.O.</p></div>
            <!-- Created by F.O. - student at FFOS@UNIOS for the Masters degree project -->
            
            <center>
            <a href="#top">Back to the top</a>
             </center>

        </footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>
