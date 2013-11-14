<?php 

function getTemplate()
{
$html = '
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US" xml:lang="en">
<head>
    
    <title>SPICYDOG\'s AJAX Chat</title>
    <script type="text/javascript" src="asset/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="template/yellow/overlay.css" />
    <script src="asset/chat.js"></script>
    <link rel="shortcut icon" href="asset/icon.png" />
    
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    
    

    <link rel="stylesheet" href="template/yellow/style.css" type="text/css" media="screen" />
    <!--[if IE 6]><link rel="stylesheet" href="template/yellow/style.ie6.css" type="text/css" media="screen" /><![endif]-->
    <!--[if IE 7]><link rel="stylesheet" href="template/yellow/style.ie7.css" type="text/css" media="screen" /><![endif]-->
    <script type="text/javascript" src="template/yellow/script.js"></script>
    
    {script}
    
    
    
</head>
<body>
<div id="art-page-background-middle-texture">
    <div id="art-page-background-glare">
        <div id="art-page-background-glare-image">
    <div id="art-main">
        <div class="art-sheet">
            <div class="art-sheet-tl"></div>
            <div class="art-sheet-tr"></div>
            <div class="art-sheet-bl"></div>
            <div class="art-sheet-br"></div>
            <div class="art-sheet-tc"></div>
            <div class="art-sheet-bc"></div>
            <div class="art-sheet-cl"></div>
            <div class="art-sheet-cr"></div>
            <div class="art-sheet-cc"></div>
            <div class="art-sheet-body">
                <div class="art-header">
                    <div class="art-header-center">
                        <div class="art-header-png"></div>
                        <div class="art-header-jpeg"></div>
                    </div>
                    <div class="art-logo">
                     <h1 id="name-text" class="art-logo-name"><a href="#">SPICYDOG\'s AJAX Chat</a></h1>
                    </div>
                </div>
                <div class="art-content-layout">
                    <div class="art-content-layout-row">
                        <div class="art-layout-cell art-content">
                          <div class="art-post">
                              <div class="art-post-body">
                          <div class="art-post-inner art-article">
                              <div class="art-postcontent">
                                  <div id="chatarea"></div>
                              </div>
                              <div class="cleared"></div>
                          </div>
                                <div class="cleared"></div>
                              </div>
                          </div>
                          
                        </div>
                        <div class="art-layout-cell art-sidebar1">
                         <div class="art-layout-bg"></div>
                          <div class="art-block">
                              <div class="art-block-body">
                                  <div class="art-blockheader">
                                      <h3 class="t">Online <span id="online-n"></span></h3>
                                  </div>
                                  <div class="art-blockcontent">
                                      <div class="art-blockcontent-body">
                                        <div>
                                           <div id="userarea" style=" overflow: auto;"></div>     
                                        </div>
                                        <div class="cleared"></div>
                                      </div>
                                  </div>
                                <div class="cleared"></div>
                              </div>
                          </div>
                          <div class="cleared"></div>
                        </div>
                    </div>
                </div>
                <div class="cleared"></div>
                <div class="art-footer">
                    <div class="art-footer-t"></div>
                    <div class="art-footer-l"></div>
                    <div class="art-footer-b"></div>
                    <div class="art-footer-r"></div>
                    <div class="art-footer-body">
                        <div class="art-footer-text">
                            <div id="typearea">
                                <div style="float: left; margin-right: 3px;">
                                    <input type="text" id="typetext" />
                                </div>
                                <div style="float: left">
                                    <button id="send" class="art-button">send</button>
                                </div>
                                <div style="text-align: center;padding-top: 7px;">
                                    <span id="soundToggle" style="color: darkblue">sound on</span>
                                    <audio style="display:none;" id="pop" src="asset/pop.wav" controls="controls" preload="auto" autobuffer="autobuffer"></audio>
                                </div>
                            </div>
                        </div>
                            <div class="cleared"></div>
                    </div>
                </div>
                    <div class="cleared"></div>
            </div>
        </div>
        <div class="cleared"></div>
        <p class="art-page-footer"><br />{version}</p>
    </div>
        </div>
    </div>
    </div>
    
    
    
    
    
</body>
</html>

';


    return $html;
}

?>