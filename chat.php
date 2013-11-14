<?php

session_start();
controller($_POST['method']);


function controller($method)
{
    require('config.php');
    
    if( !isset( $_SESSION['id'] ) )
    {

    require('facebook_sdk/connect.php');

    $facebook = get_facebook($appId,$secret);
    
        
        
        if($facebook['is_login']==0)
            exit();
        else
            $_SESSION['id'] = $facebook['me']['id'];

    }

    if($method == 'get')
    {
        select_message($_POST['id']);
    }

    elseif($method == 'send')
    {
        $message = stripslashes( $_POST['message'] );
        $message = iconv_substr($message, 0, $maxLength, "UTF-8"); 
        insert_message( $message );
    }

    elseif($method == 'info')
    {
        getInfo($_POST['id']);
    }
        
        
    

}

function getInfo($id)
{
    echo file_get_contents('http://graph.facebook.com/'.$id.'/');
}


function setMessage($message)
{
    /*
    $file_message = fopen("data/message.txt", 'r') or die("can't open file");

    $data_message = fread($file_message, filesize($file_message));
    fclose($file_message);
    echo $data_message;
    */

    

    
    
    $data_message = file_get_contents("data/message.txt");
    $data = json_decode($data_message);
    
    $i=0;
    $id=0;
    if(sizeof($data)>0)
        foreach($data as $item)
        {
            $save[$i]['i'] = $item->i;
            $save[$i]['u'] = $item->u;
            $save[$i]['m'] = $item->m;
            $save[$i]['t'] = $item->t;
            $id = $save[$i]['i'];
            $i++;
            
        }
    $id++;
    $save[$i]['i'] = $id;
    $save[$i]['u'] = $_SESSION['id'];
    $save[$i]['m'] = $message;
    $save[$i]['t'] = time();
    
    $file_message = fopen("data/message.txt", 'w') or die("can't open file");
    fwrite($file_message, json_encode($save));
    fclose($file_message);
    
    $file_id = fopen("data/id.txt", 'w') or die("can't open file");
    fwrite($file_id, $id);
    fclose($file_id);
    
    //getMessage($id);

}

function getMessage($id)
{
    
    $update = false;
    $loop = 0;
    //while(!$update)
    //{
        $file_id = fopen("data/id.txt", "rb");
        $lastest_id = fread($file_id, 4096);
        fclose($file_id);
        
        if($lastest_id > $id)
        {
            $update = true;
            if($lastest_id-$id > 15)
                $id = $lastest_id - 15;
            //break;
        }
        //if($loop>12)
        //    break;
        //$loop++;
        //usleep(300000);
    //}
    
    
    $online = online($_SESSION['id']);
    
    if($update)
    {
        $i=0;
        $data_message = file_get_contents("data/message.txt");
        $data = json_decode($data_message);
        if(sizeof($data)>0)
            foreach($data as $item)
            {
                $load[$i]['i'] = $item->i;
                $load[$i]['u'] = $item->u;
                $load[$i]['m'] = $item->m;
                $load[$i]['t'] = $item->t;
                
                if( $load[$i]['i'] > $id)
                    $i++;
            }
        $json['o'] = $online;
        $json['g'] = $load;
        echo json_encode($json);
    }
    else
    {
        $json['o'] = $online;
        $json['g'] = 0;
        echo json_encode($json);
    }
    
    
}

function online($id)
{


    $limit = 30;
 

    $file = "data/online.txt";
    $handle = fopen($file, 'r');
    $json = json_decode( fgetss($handle) );
    fclose($handle);




    $i=0;
    if(sizeof($json)>0)
    foreach($json as $line)
    {
        if( time() - $line->t < $limit )
        {
            if( $line->u != $id)
            {
                $array[$i]['u'] = $line->u;
                $array[$i]['t'] = $line->t;
                $i+=1;
            }
        }
    }
    $array[$i]['u'] = $id;
    $array[$i]['t'] = time();
    $json = json_encode($array);


    $file = "data/online.txt";
    $handle = fopen($file, 'w');
    fwrite($handle, $json);
    fclose($handle);

    return $array;
}

function insert_message($message)
{
    if(strlen($message)>0)
    {
        $id = connect_database('db_insert_message', $_SESSION['id'], $message);
        $file_id = fopen("data/id.txt", 'w') or die("can't open file");
        fwrite($file_id, $id);
        fclose($file_id);
    }

}

function select_message($id)
{
    

    $file_id = fopen("data/id.txt", "rb");
    $lastest_id = fread($file_id, 4096);
    fclose($file_id);

    
    $online = online($_SESSION['id']);
    
    if($lastest_id > $id)
    {
        $i=0;
        $data = connect_database('db_select_message', $id, 3);
        if(sizeof($data)>0)
            foreach($data as $item)
            {
                $load[$i]['i'] = $item['id'];
                $load[$i]['u'] = $item['name'];
                $load[$i]['m'] = $item['message'];
                $load[$i]['t'] = $item['time'];

                $i++;
            }
        $json['o'] = $online;
        $json['g'] = $load;
        echo json_encode($json);
    }
    else
    {
        $json['o'] = $online;
        $json['g'] = 0;
        echo json_encode($json);
    }
    
    
    
    
}

function connect_database($method,$parem1,$parem2)
{

    
    function db_insert_message($link, $name, $message)
    {
        $name = mysql_real_escape_string($name);
        $message = mysql_real_escape_string($message);
        $insert = "INSERT INTO `chat` (`name` ,`message` ,`time`) VALUES ('$name',  '$message', CURRENT_TIMESTAMP);";
        $result = mysql_query($insert);
        return mysql_insert_id();
    }

    function db_select_message($link, $id, $limit)
    {
        $insert = "SELECT * FROM  `chat` WHERE `id`>$id ORDER BY `id` DESC LIMIT 0 , $limit;";
        $result = mysql_query($insert);
        $n=0;
        while ($row = mysql_fetch_array($result)) {
            $output[$n]['id']       =   $row['id'];
            $output[$n]['name']     =   $row['name'];
            $output[$n]['message']  =   htmlspecialchars($row['message']);
            $output[$n]['time']     =   strtotime($row['time']);
            $n+=1;
        }
        if( isset($output) )
            return array_reverse($output);
    }

    $link = mysql_connect('localhost', 'spicydogin_chat', 'q36rQhIO');
    if (!$link) die('Could not connect: ' . mysql_error());

    mysql_select_db('spicydogin_chat');
    
    return $method($link,$parem1,$parem2);

    mysql_close($link);

}

?>
