<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Divine Shephered</title>

    <link rel="stylesheet" type="text/css" href="home-assets/css/vendor.css">

    <!-- Link Swiper's CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
    <link rel="shortcut icon" href="home-assets/images/divine-logo.png" type="image/x-icon">
    <!-- Link Bootstrap's CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <link rel="stylesheet" href="home-assets/style.css">

    <!-- Google Fonts ================================================== -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">


    <!-- script ================================================== -->
    <script src="home-assets/js/modernizr.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</head>

<body data-bs-spy="scroll" data-bs-target="#navbar-example2" tabindex="0">

    <!-- NAVBAR START -->
    <header id="nav" class="site-header position-fixed text-white bg-dark">
        <nav style="background-color: #2364a3;" id="navbar-example2" class="navbar navbar-expand-lg py-2">

            <div class="container ">

                <a data-aos="fade-right" data-aos-duration="2000" class="navbar-brand" href="home.php"><img style="height: 65px; border-radius: 100px;" src="home-assets/images/divine-logo.jpg" alt="image"> DIVINE SHEPERED</a>

                <button class="navbar-toggler text-white" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar2" aria-controls="offcanvasNavbar2" aria-label="Toggle navigation"><ion-icon name="menu-outline" style="font-size: 30px;"></ion-icon></button>

                <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar2" aria-labelledby="offcanvasNavbar2Label">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title" id="offcanvasNavbar2Label">Menu</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div data-aos="fade-left" data-aos-duration="2000" class="offcanvas-body">
                        <ul class="navbar-nav align-items-center justify-content-end align-items-center flex-grow-1 ">
                            <li class="nav-item">
                                <a class="nav-link active me-md-4" href="#home">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link me-md-4" href="#about-us">About</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link me-md-4" href="#start">Contact</a>
                            </li>

                            <li class="nav-item">
                                <a style="background-color: #1A242F; border: none;" class="btn-medium btn btn-info text-white" href="login.php">Student Portal</a>
                            </li>

                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="tabs-listing mt-4">
                                                <nav>
                                                    <div class="nav nav-tabs d-flex justify-content-center border-0" id="nav-tab2" role="tablist">
                                                        <button class="btn btn-outline-primary text-uppercase me-4 " id="nav-sign-in-tab2" data-bs-toggle="tab" data-bs-target="#nav-sign-in2" type="button" role="tab" aria-controls="nav-sign-in2" aria-selected="false">Log In</button>
                                                        <button class="btn btn-outline-primary text-uppercase active" id="nav-register-tab2" data-bs-toggle="tab" data-bs-target="#nav-register2" type="button" role="tab" aria-controls="nav-register2" aria-selected="true">Sign Up</button>
                                                    </div>
                                                </nav>
                                                <div class="tab-content" id="nav-tabContent1">
                                                    <div class="tab-pane fade " id="nav-sign-in2" role="tabpanel" aria-labelledby="nav-sign-in-tab2">
                                                        <form id="form3" class="form-group flex-wrap p-3 ">
                                                            <div class="form-input col-lg-12 my-4">
                                                                <label for="exampleInputEmail3" class="form-label fs-6 text-uppercase fw-bold text-black">Email
                                                                    Address</label>
                                                                <input type="text" id="exampleInputEmail3" name="email" placeholder="Email" class="form-control ps-3">
                                                            </div>
                                                            <div class="form-input col-lg-12 my-4">
                                                                <label for="inputPassword3" class="form-label  fs-6 text-uppercase fw-bold text-black">Password</label>
                                                                <input type="password" id="inputPassword3" placeholder="Password" class="form-control ps-3" aria-describedby="passwordHelpBlock">
                                                                <div id="passwordHelpBlock2" class="form-text text-center">
                                                                    <a href="#" class=" password">Forgot Password ?</a>
                                                                </div>

                                                            </div>
                                                            <label class="py-3">
                                                                <input type="checkbox" required="" class="d-inline">
                                                                <span class="label-body text-black">Remember Me</span>
                                                            </label>
                                                            <div class="d-grid my-3">
                                                                <button class="btn btn-primary btn-lg btn-dark text-uppercase btn-rounded-none fs-6">Log
                                                                    In</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="tab-pane fade active show" id="nav-register2" role="tabpanel" aria-labelledby="nav-register-tab2">
                                                        <form id="form4" class="form-group flex-wrap p-3 ">
                                                            <div class="form-input col-lg-12 my-4">
                                                                <label for="exampleInputEmail4" class="form-label fs-6 text-uppercase fw-bold text-black">Email
                                                                    Address</label>
                                                                <input type="text" id="exampleInputEmail4" name="email" placeholder="Email" class="form-control ps-3">
                                                            </div>
                                                            <div class="form-input col-lg-12 my-4">
                                                                <label for="inputPassword4" class="form-label  fs-6 text-uppercase fw-bold text-black">Password</label>
                                                                <input type="password" id="inputPassword4" placeholder="Password" class="form-control ps-3" aria-describedby="passwordHelpBlock">
                                                            </div>
                                                            <label class="py-3">
                                                                <input type="checkbox" required="" class="d-inline">
                                                                <span class="label-body text-black">I agree to the <a href="#" class="text-black password border-bottom">Privacy Policy</a>
                                                                </span>
                                                            </label>
                                                            <div class="d-grid my-3">
                                                                <button class="btn btn-primary btn-lg btn-dark text-uppercase btn-rounded-none fs-6">Sign
                                                                    Up</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </ul>

                    </div>
                </div>


            </div>
        </nav>
    </header>

    <!-- BANNER START -->
    <section id="home" data-aos="fade-right" data-aos-duration="2000" style="padding: 50px;">
        <div class="container ">
            <div class="row flex-lg-row-reverse align-items-center ">

                <div class="col-lg-6">
                    <img src="home-assets/images/divine_shephered.jpg" class="d-block mx-lg-auto img-fluid" alt="Bootstrap Themes" width="700" height="500" loading="lazy">
                </div>

                <div class="col-lg-6">
                    <h1 style="color: #2364a3;" class="lh-1 my-3">Welcome to DIVINE SHEPHERED</h1>
                    <p style="color: black;" class="lead">
<br>
WORK IN PROGRESS!</p>

                </div>
            </div>
        </div>
    </section>
    <!-- BANNER END -->

    <!-- Feature start  -->
    <section id="feature" data-aos="fade-up" data-aos-duration="3000">
    </section>



    <!--About us start  -->
    <section id="about-us" data-aos="fade-up" data-aos-duration="3000">
        <div class="container">
            <div class="row py-lg-5">

                <h2 style="color: #2364a3" class="text-capitalize text-center m-0 py-lg-5">Why choose us</h2>

                <div class="text-center col-lg-4">
                    <img src="home-assets/images/search.png" class="bd-placeholder-img rounded-circle" alt="Bootstrap Themes" width="140" height="140" loading="lazy">
                    <h4 style="color: #2364a3" class="fw-normal mt-5 ">Equal education Opportunities</h4>
                </div>

                <div class="text-center col-lg-4">
                    <img src="home-assets/images/price.png" class="bd-placeholder-img rounded-circle" alt="Bootstrap Themes" width="140" height="140" loading="lazy">
                    <h4 style="color: #2364a3" class="fw-normal mt-5">Cost effective education</h4>
                </div>

                <div class="text-center col-lg-4">
                    <img src="home-assets/images/time.png" class="bd-placeholder-img rounded-circle" alt="Bootstrap Themes" width="140" height="140" loading="lazy">
                    <h4 style="color: #2364a3" class="fw-normal mt-5 ">Certified Trained Teachers</h4>
                </div>
            </div>
        </div>
    </section>

    <!-- Mission Vision start  -->
    <section id="testimonial" data-aos="fade-right" data-aos-md="fade-up" data-aos-duration="2000" style="overflow: hidden;">
        <div class="container my-5">

            <div class="swiper testimonial-swiper">
                <div class="swiper-wrapper">

                    <div class="swiper-slide">
                        <div class="row my-5 py-lg-5">
                            <div class="col-md-8 mx-auto">
                                <img src="home-assets/images/quote-new.jpg" class="rounded mx-auto d-inline" alt="...">
                                <p style="color: #2364a3" class="testimonial-p mt-4"> Mission - Vision<br> <br>
                                work in progress!
                                </p>

                                <div class="row">
                                    <div class="col-md-8">
                                        <p style="color: #2364a3" class="pt-5 mb-1">DIVINE SHEPHERED Mission - Vision</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="row my-5 py-lg-5">
                            <div class="col-md-8 mx-auto">
                                <img src="home-assets/images/quote-new.jpg" class="rounded mx-auto d-inline" alt="...">
                                <p style="color: #2364a3" class="testimonial-p mt-4">- Goals - <br> <br>
                               WORK IN PROGRESS!
                                </p>

                                <div class="row">
                                    <div class="col-md-8">
                                        <p style="color: #2364a3" class="pt-5 mb-1">DIVINE SHEPHERED Goals</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class=" testimonial-swiper-button col-md-3 position-absolute">
                    <div class="swiper-button-prev testimonial-arrow"></div>
                    <div class="arrow-divider"> | </div>
                    <div class="swiper-button-next testimonial-arrow"></div>
                </div>
            </div>
        </div>
    </section>

            </div>
        </div>
    </section>

    <!-- Lets start  -->
    <section id="start" style="background-color: #2364a3 !important; overflow-x: hidden;">
        <div class="container my-5 py-5">
            <div class="row featurette py-lg-5 ">
                <div class="col-md-5 order-md-1 d-flex">
                    <h1 class="text-capitalize  lh-1 mb-3" data-aos="fade-right" data-aos-duration="1000"> CONTACT US NOW! <img height="200px" width="200px" style="border-radius: 5px;" src="home-assets/images/divine-logo.jpg" alt=""></h1>
                </div>
                <div class="col-md-7 order-md-2">
                    <div class="text-content ps-md-5 mt-4 mt-md-0">
                        <p class="py-lg-2" data-aos="zoom-in" data-aos-duration="1000">Contact Us Now!</p>
                        <a style="background-color: #fff; color: #2364a3; border: none;" href="contact.php" data-aos="zoom-in" data-aos-duration="1500" class="btn btn-primary btn-lg px-4 me-md-2">Press me!</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer start  -->
    <section style="background-color: black !important;" id="footer">
        <div class="container footer-container">
            <footer class="row row-cols-1 row-cols-sm-2 row-cols-md-5  ">

                <div class=" col-md-5 mb-5">
                    <h3>
                        <img id="footer-logo" style="height: 100px; width: 100px;" src="home-assets/images/divine-logo.png" alt="image">
                        DIVINE SHEPHERED
                    </h3>
                    <p><ion-icon name="location-outline"></ion-icon> #50 Col. Felino Paran Street, Lipa City<br>Philippines</p>
                    <p><ion-icon name="mail-outline"></ion-icon> divineshepherd97@gmail.com</p>
                    <p><ion-icon name="call-outline"></ion-icon> (043) 756 0820</p>
                    <a href="https://www.facebook.com/DSSLCI" target="_blank">
    <i class="bi-facebook pe-4"> https://www.facebook.com/DSSLCI</i>
</a>
                </div>


                <div class="col-md-4 mb-3 ">
                    <h5>Offered Strand</h5>
                    <ul class="nav flex-column">
                        <li class="nav-item mb-2">
                            <p style="margin: 0 !important;" class="nav-link p-0 ">Accountancy, Business, and Management (ABM)</p>
                        </li>
                        <li class="nav-item mb-2">
                            <p style="margin: 0 !important;" class="nav-link p-0 ">Science, Technology, Engineering, and Mathematics (STEM) </p>
                        </li>
                        <li class="nav-item mb-2">
                            <p style="margin: 0 !important;" class="nav-link p-0 ">Humanities and Social Sciences (HUMSS)</p>
                        </li>
                        <li class="nav-item mb-2">
                            <p style="margin: 0 !important;" class="nav-link p-0 ">General Academic Strand (GAS)</p>
                        </li>
                        <li class="nav-item mb-2">
                            <p style="margin: 0 !important;" class="nav-link p-0 "></p>
                        </li>
                    </ul>
                </div>

                <div class="col-md-3 ">
                    <h5>Office hours</h5>
                    <ul class="nav flex-column">
                        <li class="nav-item mb-2">
                            <p style="margin: 0 !important;" class="nav-link p-0 ">Monday to Friday </p>
                        </li>
                        <li class="nav-item mb-2">
                            <p style="margin: 0 !important;" class="nav-link p-0 ">8:00 am – 5:00 pm</p>
                        </li>
                        <li class="nav-item mb-2">
                            <p style="margin: 0 !important;" class="nav-link p-0 ">Saturday </p>
                        </li>
                        <li class="nav-item mb-2">
                            <p class="nav-link p-0 ">8:00 am – 12:00 pm</p>
                        </li>
                    </ul>
                </div>
            </footer>
        </div>



        <footer class="d-flex flex-wrap justify-content-between align-items-center border-top"></footer>

        <div class="container">
            <footer class="p-2 mt-2">
                <div class="">
                    <p style="text-align: center !important;">© 2024 Made by: Dominic, Charles, John Albert</p>

                </div>
            </footer>
        </div>
    </section>




    <script src="home-assets/js/jquery-1.11.0.min.js"></script>
    <script src="home-assets/js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <!-- AOS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>

</body>

</html>