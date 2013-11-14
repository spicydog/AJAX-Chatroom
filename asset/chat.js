var id          = 0;
var facebook    = new Array();
var newMessage  = false;
var firstTime   = true;
var sound       = true;

var soundTime   = new Date();
var lastSound   = soundTime.getTime();

var sendTime   = new Date();
var lastSend    = sendTime.getTime();



$(document).ready(function() {
    getMessage(true);
    
     $("#typetext").attr('maxlength',maxLength);
    
     $('#send').click(function(){
        sendMessage( $('#typetext').val() );
     });
     
     $('#typetext').keypress(function(e){
        if ((e.keyCode ? e.keyCode : e.which) == 13) 
            sendMessage( $('#typetext').val() );
    });
    $('#soundToggle').click(function(){
        if( $('#soundToggle').html()=='sound on' )
        {
            sound = false;
            $('#soundToggle').html('sound off');
            $('#soundToggle').css('color','darkred');
        }
        else
        {
            sound = true;
            $('#soundToggle').html('sound on');
            $('#soundToggle').css('color','darkblue');
        }
        
     });
});

function EvalSound(soundobj) {
  var thissound=document.getElementById(soundobj);
  thissound.play();
}

function getMessage(auto){
    $.ajax({
        url:    'chat.php',
        type:   "POST",
        data:   {'method':'get',
                    'id':id
                },
        success: function(json){
            var data = JSON.parse(json);
            
            if( data.g != '0' )
            {
                setMessage(data.g);
                document.getElementById('chatarea').scrollTop = 999999;
            }
            setOnline(data.o);
            
            
            
            
            if(newMessage)
            {
                

                soundTime = new Date();
                
                if( sound && soundTime.getTime()-lastSound > soundInterval*1000)
                {
                    EvalSound('pop');
                    lastSound = soundTime.getTime();
                }
                newMessage = false;
            }
            if(auto)
                setTimeout("getMessage(true);",5000);
            
        }
    });
    
}

function sendMessage(message){
    
    
    sendTime = new Date();
    if( sendTime.getTime()-lastSend > sendInterval*1000)
    {
        $.ajax({
            url:    'chat.php',
            type:   "POST",
            data:   {'method':'send',
                        'message':message
                    },
            success: function(data){
                
                lastSend = sendTime.getTime();
                $('#typetext').val('');
                getMessage(false);
                

            }
        });
    }
}



function setMessage(data)
{
    function messageBlock(data)
    {
        function timeConvert(unix_timestamp)
        {
            function format(n)
            {
                if(n<10)
                    return '0' + n;
                else
                    return n;
            }
            var date = new Date(unix_timestamp*1000);
            var hours = date.getHours();
            var minutes = date.getMinutes();
            var seconds = date.getSeconds();

            return format(hours) + ':' + format(minutes) + ':' + format(seconds);
        }
        
        function bbcConvert(message)
        {
            var tags = new Array('b','i');

            for(var j=0;j<2; j++)
            {
                
                var indexOfStart = message.indexOf( '['+tags[j]+']' );
                if( indexOfStart >= 0 )
                {
                    var indexOfEnd = message.indexOf( '[/'+tags[j]+']' );
                    if( indexOfEnd < 0 )
                    {
                        message += '[/'+tags[j]+']';
                    }

                    message = message.replace( '['+tags[j]+']'  , '<'+tags[j]+'>'  );
                    message = message.replace( '[/'+tags[j]+']' , '</'+tags[j]+'>' );
                    j--;
                }
                
            }
            return message;
        }
        

        
        
        
        
        getFacebookInfo(data.u);
        
        var bgstyle = 'odd';
        if(data.i % 2 == 0)
            bgstyle = 'even';
        
        
        var name='';
        try
        {
            name = facebook[data.u].name;
        }
        catch(err)
        {
            name='Loading..';
        }
        
        
        var str = '<div style="display:none" id="msg'+data.i+'" class="'+bgstyle+'"><div id="time" class="time">'+timeConvert(data.t)+'</div><div id="message" class="message">'+'<span class="fbpic'+data.u+'"><a target="_blank" href="http://www.facebook.com/'+data.u+'"><img class="fbpic" src="https://graph.facebook.com/'+data.u+'/picture" /></a></span> '+'<span id="name" class="fbname'+data.u+'">'+name+'</span>: '+ bbcConvert(data.m) +'</div></div>';
        
        var output = new Object();
        output.u = data.u;
        output.o = str;
        return output;
    }
    

    for(i in data)
    {
        if( data[i].i > id)
        {
            var result = messageBlock(data[i]);
            $('#chatarea').append( result.o );
            id = data[i].i;
            $('div[id^="msg"]').each( function(){
                $(this).fadeIn(500);
            }
            );
                
            if(!firstTime)
                newMessage = true;
            
            setName(result.u, facebook[result.u].name);
            
            
            removeOverflowMessage()
        }
    }
    firstTime = false;
    

}

function removeOverflowMessage()
{
   $('div[id^="msg"]').each(function(){
       var msgid = parseInt( $(this).attr('id').replace('msg', '') );
       if( id - msgid >= maxMessage )
           $(this).remove();
       else
           return false;
   });
}

function getFacebookInfo(id)
{


    try
    {
        setName(id, facebook[id].name);
    }
    catch(err)
    {
      
        facebook[id] = new Object();
        $.ajax({
        url:    'chat.php',
        type:   "POST",
        data:   {'method':'info',
                    'id':id
                },
        success: function(json){

            var data = JSON.parse(json);
            facebook[id].name = data.name;

            setName(id, facebook[id].name);
            }
        });
        
    }



}

function setName(id, name)
{
    $(".fbname"+id).html(name);
}

function setOnline(data)
{
    var str = '';
    var n=0;
    for( i in data )
    {
        var name='';
        try
        {
            name = facebook[data[i].u].name;
        }
        catch(err)
        {
            name='Loading..';
        }
        str += '<div><span class="fbpic'+data[i].u+'"><a target="_blank" href="http://www.facebook.com/'+data[i].u+'"><img border="0" class="fbpic" src="https://graph.facebook.com/'+data[i].u+'/picture" /></a></span> <span class="onlinename fbname'+data[i].u+'">' + name + '</span></div>';
        getFacebookInfo(data[i].u);
        n++;
    }
    if(n==0)
        $('#online-n').html(' 0 Users');
    else if(n==1)
        $('#online-n').html(' 1 User');
    else
        $('#online-n').html(' '+n+' Users');
    $('#userarea').html(str);
}











































