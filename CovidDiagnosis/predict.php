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
<script type="text/javascript" src="https://code.jquery.com/jquery.min.js"></script>
<script src="https://markjivko.com/dist/recorder.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs"></script>

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
        <!-------------------------------------- UPLOAD PAGE ------------------------------------>
        <!----------SYMPTOMS------------>	
        <h3> ---- Upload your audio here ----</h3>
        <div style="text-align:center">
		<div class="checkbox-container">
            <form action='app.py' method="post" enctype="multipart/form-data"> 
				<input name="aches" value="ACHES" type="checkbox" id="two">
				<label for="two">MUSCLE ACHES/ FEVER</label>

				<input name="respiratory" value="RESPIRATORY" type="checkbox" id="three">
				<label for="three">RESPIRATORY CONDITION</label>
				<input type="file" name="audio" accept="wav">
				<input type="submit" value="SUBMIT" class="signin-btn">
            </form>
		</div>
        
        <div id='hidden'>
            <h1>
                <?php $data=$_POST["pred"]; 
                    echo $data. "<br />";
                ?> 
            </h1>
        </div>

        <h3>--- If you dont have a recording, record one here ---</h3>
        <div class="holder">
            <div data-role="controls">
                <button>Record</button>
            </div>
            <div data-role="recordings"></div>
        </div>


        <script>
            function ShowAndHide(id) {
                var content = document.getElementById('hidden');
                content.style.display="block";

            };
        </script>
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

            jQuery(document).ready(function () {
                var $ = jQuery;
                var myRecorder = {
                    objects: {
                        context: null,
                        stream: null,
                        recorder: null
                    },
                    init: function () {
                        if (null === myRecorder.objects.context) {
                            myRecorder.objects.context = new (
                                    window.AudioContext || window.webkitAudioContext
                                    );
                        }
                    },
                    start: function () {
                        var options = {audio: true, video: false};
                        navigator.mediaDevices.getUserMedia(options).then(function (stream) {
                            myRecorder.objects.stream = stream;
                            myRecorder.objects.recorder = new Recorder(
                                    myRecorder.objects.context.createMediaStreamSource(stream),
                                    {numChannels: 1}
                            );
                            myRecorder.objects.recorder.record();
                        }).catch(function (err) {});
                    },
                    stop: function (listObject) {
                        if (null !== myRecorder.objects.stream) {
                            myRecorder.objects.stream.getAudioTracks()[0].stop();
                        }
                        if (null !== myRecorder.objects.recorder) {
                            myRecorder.objects.recorder.stop();

                            // Validate object
                            if (null !== listObject
                                    && 'object' === typeof listObject
                                    && listObject.length > 0) {
                                // Export the WAV file
                                myRecorder.objects.recorder.exportWAV(function (blob) {
                                    var url = (window.URL || window.webkitURL)
                                            .createObjectURL(blob);

                                    // Prepare the playback
                                    var audioObject = $('<audio controls></audio>')
                                            .attr('src', url);

                                    // Prepare the download link
                                    var downloadObject = $('<a>&#9660;</a>')
                                            .attr('href', url)
                                            .attr('download', new Date().toUTCString() + '.wav');

                                    // Wrap everything in a row
                                    var holderObject = $('<div class="row"></div>')
                                            .append(audioObject)
                                            .append(downloadObject);

                                    // Append to the list
                                    listObject.append(holderObject);
                                });
                            }
                        }
                    }
                };
                // Prepare the recordings list
                var listObject = $('[data-role="recordings"]');

                // Prepare the record button
                $('[data-role="controls"] > button').click(function () {
                    // Initialize the recorder
                    myRecorder.init();

                    // Get the button state 
                    var buttonState = !!$(this).attr('data-recording');

                    // Toggle
                    if (!buttonState) {
                        $(this).attr('data-recording', 'true');
                        myRecorder.start();
                    } else {
                        $(this).attr('data-recording', '');
                        myRecorder.stop(listObject);
                    }
                });
            });
        </script>
    </body>
</html>