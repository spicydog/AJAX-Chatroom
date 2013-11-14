<?php 

    require('config.php');
    require('facebook_sdk/connect.php');
    
    $facebook = get_facebook($appId,$secret);
    
    
    if($facebook['is_login']!=1)
        header("Location: ".$facebook['login_url']);
    
    
    
    $script = " <script>
                    if ( top.location.href != '$baseUrl' )
                        top.location.href = '$baseUrl';


                    var maxMessage = $maxMessage;
                    var maxLength = $maxLength;
                    var soundInterval = $soundInterval;
                    var sendInterval = $sendInterval;
                </script>";




 
    require 'template/'. $template.'/template.php';
    
    $data = array(  'script' => $script,
                    'version' => '<a href="http://www.spicydog.org" target="_blank">SPICYDOG</a>\'s Chatroom Version 1.0 Alpha (Build 26)'
                    
                 );
    
    $html = getTemplate();
    
    foreach($data as $key => $value)
        $html = str_replace ('{'.$key.'}', $value, $html);
    
    
    echo $html;
?>
































<?php /*


<!DOCTYPE html>




<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>AJAX Chat Room</title>
        <link rel="shortcut icon" href="icon.png" />
        
        <link rel="stylesheet" type="text/css" href="chat.css" />
        <script src="jquery.min.js"></script>
        <script src="chat.js"></script>
    </head>
    <body>
        
        <div id="main" style="width: 800px;margin-left: auto;margin-right: auto;text-align: left;">
        
            <?php if($facebook['is_login']==1): ?>
                <table style="width: 800px; height: 500px;padding: 5px;">
                    <tr>
                        <td style="vertical-align: top;">
                            <h2>Chat Room</h2>
                            <div id="chatarea" style="height: 400px; overflow: auto;">
                            </div>
                        </td>
                        <td rowspan="2" style="width: 200px; vertical-align: top;padding-left: 10px;">
                            <h2>Users Online</h2>
                            <div id="userarea" style=" overflow: auto;">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="">
                            <div id="typearea">
                                <span>
                                    <input type="text" id="typetext" />
                                </span>
                                <span>
                                    <button id="send" >send</button>
                                </span>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        
            <?php else: ?>
                <div style="position:absolute;height:47px; width:280px;margin:-23px 0px 0px -140px;top: 50%; left: 50%;text-align: center; padding: 0px;">
                    <a href="<?php echo $facebook['login_url']; ?>">
                        <img border="0" src="http://img23.imageshack.us/img23/6712/facebookconnectbutton.png" />
                    </a>
                </div>

            <?php endif; ?>
        
        <audio style="display:none;" id="pop" src="pop.wav" controls preload="auto" autobuffer></audio>
    </body>
</html>
 
*/
?>