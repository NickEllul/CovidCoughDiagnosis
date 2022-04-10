<!DOCTYPE html>
<html lang="en">
    
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Covid Prediction Website</title>
        <link rel="stylesheet" href="style.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/fontawesome.min.css">
<script src="https://kit.fontawesome.com/8415f96b30.js" crossorigin="anonymous"></script>

    
    </head>
    <body>
        <!------------Navigation Menu---------->
        <section class="header">

            <!------------Navigation Menu---------->
            <nav>
                <div class="logo">
                <a href="index.php"> <img src="image/logo.png"></a>
            </div>
                
                <!-----------creating menu link------------->
                <div class="nav-links" id="navLinks">

                    <!-----------Creating hide icon for small device----------->
                    <i class="fas fa-times" onclick="hideMenu()"></i>
                    <ul>
                    <li><a href="index.php">HOME</a></li>
                        <li><a href="signIn.php">SIGN IN</a></li>
                        <li><a href="disclaimer.php">DISCLAIMER</a></li>
                        <li><a href="symptoms.php">SYMPTOMS</a></li>
                        <li><a href="upload.php">UPLOAD</a></li>
                        <li><a href="register.php">REGISTER</a></li>
                        <li><a href="logout.php">LOGOUT</a></li>
                    </ul>
                </div>
                <!-----------Creating show icon for small device----------->
                <i class="fas fa-bars" onclick="showMenu()"></i>
            </nav>   
            </section> 
            <!-----------Creating show icon for small device----------->
            <i class="fas fa-bars" onclick="showMenu()"></i>
            </nav>

            <div class="text-box">
                <h1>Disclaimer</h1>
                <br>
                <h6>----------------------------------------------------------------------------------</h6>
                <br>
                
                <p>The medical information on this website is provided as an information 
                    resource only, and is not to be used or relied on for any diagnostic or treatment purpose.
                    This information does not create any patient physician relationship, and should not be used
                    as a substitute for professional diagnosis and treatment.
                    Please consulte your health care provider before making any health care decisions or for 
                    guidance about a specific medical condition. Our team expressly disclaim responsibility, and 
                    shall have no liability for any damages, loss, injury or liability whatever suffered as a result 
                    of your reliance on the information contained in this website. By clicking <b>AGREE</b>, you accept our
                    terms and conditions and provide us the consent to your data solely for research and development purposes. 
                </p>
                    <br>
                    <br>

                    <!------------Button for sign in page----------->
                    <a href="symptoms.html" class="hero-btn">AGREE</a>
            </div>
        </section> 

        <!-------------FOOTER------------->

        <section class="footer">
            <h4>About Us</h4>
            <p>This website is Created by a group of Students of Victoria University Melbourne as 
                there Final Year Project.</p>

            <div class="icons">
                <i class="fa-brands fa-facebook"></i>
                <i class="fa-brands fa-twitter-square"></i>
                <i class="fa-brands fa-linkedin"></i>
                <i class="fa-brands fa-instagram-square"></i>
            </div>
            <p>Made by NUA Group, Victoria university</p>
        </section>
        

        
<!-----------JavaScript for toggle menu for mobile screen------------>

        <script>
            var navLinks = document.getElementById("navLinks");

            function showMenu(){
                navLinks.style.right= "0";
            }
            function hideMenu(){
                navLinks.style.right= "-200px";
            }

        </script>

        

    </body>

</html>