<?php
define('TOKEN','[TOKEN INSERT HERE]'); //Inser Your Token in this chart (توکن ربات خود را در این قسمت وارد کنید)
function getTxt(){
        $text = json_decode(file_get_contents('php://input'));
        return $text;
    }
	
$result = getTxt();
$text = $result->message->text;

// user
$messageid = $result->message->message_id;
$userid = $result->message->from->id;

$chatid = $result->message->chat->id;

// member
$newmemberid = $result->message->new_chat_member->id;
$newmemberfname = $result->message->new_chat_member->first_name;
$leftmemberid = $result->message->left_chat_member->id;
$leftmemberfname = $result->message->left_chat_member->first_name;
$entityType = $result->message->entities[0]->type;

function deleteMessage($chatid,$msgid){
        $url= 'https://api.telegram.org/bot'.TOKEN.'/deleteMessage?chat_id='.$chatid.'&message_id='.$msgid;
        file_get_contents($url);
    }
function kickChatMember($chatid,$userid){
        $url= 'https://api.telegram.org/bot'.TOKEN.'/kickChatMember?chat_id='.$chatid.'&user_id='.$userid;
        file_get_contents($url);
    }
function sendMessage($userid,$text){
        $url= 'https://api.telegram.org/bot'.TOKEN.'/sendMessage?chat_id='.$userid.'&text='.$text;
        file_get_contents($url);
    }
function sendReply($userid,$text,$msgid){
        $url= 'https://api.telegram.org/bot'.TOKEN.'/sendMessage?chat_id='.$userid.'&text='.$text.'&reply_to_message_id='.$msgid;
        file_get_contents($url);
    }

	
if($entityType == 'url'){
        sendReply($chatid,"بدلیل تخلف و ارسال آدرس سایت در چت روم , کاربر $newmemberfname از گروه اخراج شد . ",$messageid);
        deleteMessage($chatid,$messageid);
        kickChatMember($chatid,$userid);
	}
if($text == '/start' or $text == 'منوی اصلی'){
    $msg = 'سلام . خوش آمدید . من را به گروه اضافه کنید و دسترسی حذف پیام را بدهید';
    $telegram->sendMessage($userid,$msg);
}