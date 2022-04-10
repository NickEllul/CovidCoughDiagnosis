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

        <!----------SYMPTOMS------------>
         <h3>--- Select the symptoms you have ---</h3>
        <div class="checkbox-container">

            <form action="" method="POST">
                <input name="symptoms[]" value="FEVER" type="checkbox" id="one">
                <label for="one">FEVER</label>
            
                <input name="symptoms[]" value="HEADACHE" type="checkbox" id="two">
                <label for="two">HEADACHE</label>

                <input name="symptoms[]" value="COUGH" type="checkbox" id="three">
                <label for="three">COUGH</label>

                <input name="symptoms[]" value="DIZZINESS" type="checkbox" id="four">
                <label for="four">DIZINESS</label>

                <input name="symptoms[]" value="TIREDNESS" type="checkbox" id="five">
                <label for="five">TIREDNESS</label>

                <input name="symptoms[]" value="SORE THROUT" type="checkbox" id="six">
                <label for="six">SORE THROUT</label>

                <input name="symptoms[]" value="DIARRHEA" type="checkbox" id="seven">
                <label for="seven">DIARRHEA</label>

                <input name="symptoms[]" value="LOSS OF SMELL" type="checkbox" id="eight">
                <label for="eight">LOSS OF SMELL</label>

                <input name="symptoms[]" value="ACHES AND PAINS" type="checkbox" id="nine">
                <label for="nine">ACHES AND PAINS</label>

                <input name="symptoms[]" value="NO SYMPTOMS" type="checkbox" id="ten">
                <label for="ten">NO SYMPTOMS</label>

                <button type="submit" name="submit" class="signin-btn">NEXT</button>
            </form>
        </div>

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