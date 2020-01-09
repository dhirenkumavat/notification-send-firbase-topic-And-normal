<?php 

session_start();

 if( ( empty($_SESSION['Prix_email'] )) && ( empty($_SESSION['Prix_pass'] )) && ( empty($_SESSION['txtloginName'] ))  ){
      header('location:index.php');
}


?>

<html>
    <head>
        <title>Free Study</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
       <!-- <link rel="shortcut icon" href="//www.gstatic.com/mobilesdk/160503_mobilesdk/logo/favicon.ico">-->
        <link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.6.0/pure-min.css">

        <style type="text/css">
            body{
            }
            div.container{
                width: 1000px;
                margin: 0 auto;
                position: relative;
            }
            legend{
                font-size: 30px;
                color: #555;
            }
            .btn_send{
                background: #00bcd4;
            }
            label{
                margin:10px 0px !important;
            }
            textarea{
                resize: none !important;
            }
            .fl_window{
                width: 400px;
                position: absolute;
                right: 0;
                top:100px;
            }
            pre, code {
                padding:10px 0px;
                box-sizing:border-box;
                -moz-box-sizing:border-box;
                webkit-box-sizing:border-box;
                display:block; 
                white-space: pre-wrap;  
                white-space: -moz-pre-wrap; 
                white-space: -pre-wrap; 
                white-space: -o-pre-wrap; 
                word-wrap: break-word; 
                width:100%; overflow-x:auto;
            }

        </style>
    </head>
    <body>
        <?php
        
          error_reporting(1);
        ini_set('display_errors', 'On');
             
                    $img = $_FILES['include_image'];
                     $imgName = $_FILES['include_image']['name'];
                     $imgtemp = $_FILES['include_image']['tmp_name'];
                    
                           $folder="uploads/";
                      move_uploaded_file($imgtemp,$folder.$imgName);
        
					
                       
                   $imgurl= "http://javaqpoint.com/admin/firebase/uploads".$imgName;
                    
        
        
        
        
        
        
        // Enabling error reporting
        error_reporting(-1);
        ini_set('display_errors', 'On');

        require_once __DIR__ . '/firebase.php';
        require_once __DIR__ . '/push.php';

        $firebase = new Firebase();
        $push = new Push();

        // optional payload
        $payload = array();
        $payload['team'] = 'India';
        $payload['score'] = '5.6';

        // notification title
        $title = isset($_POST['title']) ? $_POST['title'] : '';
        
        // notification message
        $message = isset($_POST['message']) ? $_POST['message'] : '';
        
        // push type - single user / topic
        $push_type = isset($_POST['push_type']) ? $_POST['push_type'] : '';
        
        // whether to include to image or not
        $include_image = isset($_POST['include_image']) ? TRUE : FALSE;
            
              
              
                
              

        $push->setTitle($title);
        $push->setMessage($message);
        if ($include_image) {
            $push->setImage($imgurl);
        } else {
            $push->setImage($imgurl);
        }
        $push->setIsBackground(FALSE);
        $push->setPayload($payload);


        $json = '';
        $response = '';

        if ($push_type == 'topic') {
            $json = $push->getPush();
             $response = $firebase->sendToTopic('global', $json);
        } else if ($push_type == 'individual') {
            $json = $push->getPush();
            $regId = isset($_GET['regId']) ? $_GET['regId'] : ''; 
            $response = $firebase->send($regId, $json);
        }
        ?>
        
        
                      
                      
                      
        <div class="container">
           <!---<div class="fl_window">
                <div><img src="http://api.androidhive.info/images/firebase_logo.png" width="200" alt="Firebase"/></div>
                <br/>
                <?php if ($json != '') { ?>
                    <label><b>Request:</b></label>
                    <div class="json_preview">
                        <pre><?php echo json_encode($json) ?></pre>
                    </div>
                <?php } ?>
                <br/>
                <?php if ($response != '') { ?>
                    <label><b>Response:</b></label>
                    <div class="json_preview">
                        <pre><?php echo json_encode($response) ?></pre>
                    </div>
                <?php } ?>

            </div>--->

           <!--- <form class="pure-form pure-form-stacked" method="get">
                <fieldset>
                    <legend>Send to Single Device</legend>

                    <label for="redId">Firebase Reg Id</label>
                    <input type="text" id="redId" name="regId" class="pure-input-1-2" placeholder="Enter firebase registration id">

                    <label for="title">Title</label>
                    <input type="text" id="title" name="title" class="pure-input-1-2" placeholder="Enter title"> 

                    <label for="message">Message</label>
                    <textarea class="pure-input-1-2" rows="5" name="message" id="message" placeholder="Notification message!"></textarea>

                    <label for="include_image" class="pure-checkbox">
                        <input name="include_image" id="include_image" type="checkbox"> Include image
                    </label>
                    <input type="hidden" name="push_type" value="individual"/>
                    <button type="submit" class="pure-button pure-button-primary btn_send">Send</button>
                </fieldset>
            </form>--->
			
			<p style="
    padding-top: 70px;>
   
    font-weight: bold;
    "><a href="../home.php" style="text-decoration: none;">Back To Home</a></p>
<div class="logo" style="
    padding-top: 70px;
    font-size: 35px;
    font-weight: bold;
    text-decoration: none;
"><a href="../home.php" style="
    text-decoration: none;
">Free Study</a></div>
<div>
        <form class="pure-form pure-form-stacked" method="POST" enctype="multipart/form-data">
                <fieldset>
                  

                    <label for="title1">Title</label>
                    <input type="text" id="title1" name="title" class="pure-input-1-2" placeholder="Enter title">

                    <label for="message1">Message</label>
                    <textarea class="pure-input-1-2" name="message" id="message1" rows="5" placeholder="Notification message!"></textarea>

                    <label for="include_image1">Image </label>
                        <input id="include_image1" name="include_image" type="file"> 
                   <br>
                    <input type="hidden" name="push_type" value="topic"/>
                    <button type="submit"  name="sub" class="pure-button pure-button-primary btn_send">Send to Topic</button>
                </fieldset>
            </form>
			</div>
        </div>
    </body>
</html>
