<?php

namespace App\Http\Controllers;

use App\Models\ManualBotHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

function generate_useragent($sign_version = '107.0.0.27.121')
{
    $resolusi = array(
        '1080x1776',
        '1080x1920',
        '720x1280',
        '320x480',
        '480x800',
        '1024x768',
        '1280x720',
        '768x1024',
        '480x320'
    );
    $versi = array(
        'GT-N7000',
        'SM-N9000',
        'GT-I9220',
        'GT-I9100'
    );
    $dpi = array(
        '120',
        '160',
        '320',
        '240'
    );
    $ver = $versi[array_rand($versi)];
    return 'Instagram ' . $sign_version . ' Android (' . mt_rand(10, 11) . '/' . mt_rand(1, 3) . '.' . mt_rand(3, 5) . '.' . mt_rand(0, 5) . '; ' . $dpi[array_rand($dpi)] . '; ' . $resolusi[array_rand($resolusi)] . '; samsung; ' . $ver . '; ' . $ver . '; smdkc210; en_US)';
}

function generate_device_id()
{
    return 'android-' . md5(rand(1000, 9999)) . rand(2, 9);
}

function generate_guid($tipe = 0)
{
    $guid = sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
    return $tipe ? $guid : str_replace('-', '', $guid);
}

function hook($data)
{
    return 'ig_sig_key_version=4&signed_body=' . hash_hmac('sha256', $data, '5d406b6939d4fb10d3edb4ac0247d495b697543d3f53195deb269ec016a67911') . '.' . urlencode($data);
}

function proccess($ighost, $useragent, $url, $cookie = 0, $data = 0, $httpheader = array(), $proxy = 0, $userpwd = 0, $is_socks5 = 0)
{
    $url = $ighost ? 'https://i.instagram.com/api/v1/' . $url : $url;
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 20);
    if ($proxy)
        curl_setopt($ch, CURLOPT_PROXY, $proxy);
    if ($userpwd)
        curl_setopt($ch, CURLOPT_PROXYUSERPWD, $userpwd);
    if ($is_socks5)
        curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
    if ($httpheader)
        curl_setopt($ch, CURLOPT_HTTPHEADER, $httpheader);
    curl_setopt($ch, CURLOPT_HEADER, 1);
    if ($cookie)
        curl_setopt($ch, CURLOPT_COOKIE, $cookie);
    if ($data):
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    endif;
    $response = curl_exec($ch);
    $httpcode = curl_getinfo($ch);
    if (!$httpcode)
        return false;
    else {
        $header = substr($response, 0, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
        $body = substr($response, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
        curl_close($ch);
        return array(
            $header,
            $body
        );
    }
}

function proccess_v2($ighost, $useragent, $url, $cookie = 0, $data = 0, $httpheader = array(), $proxy = 0, $userpwd = 0, $is_socks5 = 0)
{
    $url = $ighost ? 'https://i.instagram.com/api/v2/' . $url : $url;
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 20);
    if ($proxy)
        curl_setopt($ch, CURLOPT_PROXY, $proxy);
    if ($userpwd)
        curl_setopt($ch, CURLOPT_PROXYUSERPWD, $userpwd);
    if ($is_socks5)
        curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
    if ($httpheader)
        curl_setopt($ch, CURLOPT_HTTPHEADER, $httpheader);
    curl_setopt($ch, CURLOPT_HEADER, 1);
    if ($cookie)
        curl_setopt($ch, CURLOPT_COOKIE, $cookie);
    if ($data):
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    endif;
    $response = curl_exec($ch);
    $httpcode = curl_getinfo($ch);
    if (!$httpcode)
        return false;
    else {
        $header = substr($response, 0, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
        $body = substr($response, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
        curl_close($ch);
        return array(
            $header,
            $body
        );
    }
}

function request($ighost, $useragent, $url, $cookie = 0, $data = 0, $httpheader = array(), $proxy = 0, $userpwd = 0, $is_socks5 = 0)
{
    $url = $ighost ? 'https://i.instagram.com/api/v1/' . $url : $url;
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 20);
    if ($proxy)
        curl_setopt($ch, CURLOPT_PROXY, $proxy);
    if ($userpwd)
        curl_setopt($ch, CURLOPT_PROXYUSERPWD, $userpwd);
    if ($is_socks5)
        curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
    if ($httpheader)
        curl_setopt($ch, CURLOPT_HTTPHEADER, $httpheader);
    curl_setopt($ch, CURLOPT_HEADER, 1);
    if ($cookie)
        curl_setopt($ch, CURLOPT_COOKIE, $cookie);
    if ($data):
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    endif;
    $response = curl_exec($ch);
    $httpcode = curl_getinfo($ch);
    if (!$httpcode)
        return false;
    else {
        $header = substr($response, 0, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
        $body = substr($response, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
        curl_close($ch);
        return array(
            $header,
            $body
        );
    }
}

function findUsernameById($users, $targetId)
{
    foreach ($users as $user) {
        if ($user['pk'] == $targetId) {
            return $user['username'];
        }
    }
    return null;
}

function getUserPosts($targetId, $cookie, $useragent, $ip, $userprox, $is_sock5)
{
    $userPostsUrl = 'feed/user/' . $targetId . '/';
    // $userPostsResponse = proccess(1, $useragent, $userPostsUrl, $cookie, , array(), $ip, $userprox, $is_sock5);
    // return json_decode($userPostsResponse[1], true);
    return "";
}

function commentLatestPosts($targetId, $cookie, $useragent, $ip, $userprox, $is_sock5)
{
    $userPosts = getUserPosts($targetId, $cookie, $useragent, $ip, $userprox, $is_sock5);

    // Ambil dua postingan terbaru
    // $latestPosts = array_slice($userPosts['items'], 0, 2);

    return $userPosts;

    // Loop untuk memberikan komentar pada setiap postingan terbaru
    foreach ($latestPosts as $post) {
        $commentText = "Komentar Anda di sini"; // Gantilah dengan komentar yang diinginkan
        // commentOnPost($post['id'], $cookie, $commentText);
    }
}


function followTarget($targetId, $useragent, $cookie, $ip, $user, $is_socks5)
{
    // $followUrl = 'friendships/create/' . $targetId . '/';
    // $followResponse = proccess(1, $useragent, $followUrl, $cookie, 0, array(), $ip, $user, $is_socks5);
    // $followData = json_decode($followResponse[1], true);

    // return $followResponse;

    // if ($followData['status'] == 'ok') {
    //     // echo "[~] " . date('d-m-Y H:i:s') . " - Success following user with ID: " . $targetId . "\n";
    //     return " - Success following user with ID: " . $targetId . "\n";
    // } else {
    //     // echo "[!] Error following user with ID: " . $targetId . "\n";
    //     // var_dump($followData);
    //     return "error";
    // }
}


class ManualBotHistoryController extends Controller
{
    //

    public function infoRun(Request $request)
    {

    }


    public function run(Request $request)
    {
        $userData = Auth::user();

        $bot_auto_follow = $request->input('bot_auto_follow');
        $bot_auto_like = $request->input('bot_auto_like');
        $bot_auto_comment = $request->input('bot_auto_comment');
        $bot_auto_seen_like = $request->input('bot_auto_seen_like');

        $histories = $userData->manualBotHistories()->where('status', 'running')->first();

        if ($histories != null) {
            return response()->json([
                "status" => "failed",
                "message" => "there is a bot running"
            ]);
        }



        // if()
        return response()->json([
            "user" => $histories,
        ]);

        $z = "";
        $getakun = "";

        $target = "pantjoranpik";
        $komen = "tesss";
        $ip = 0;
        $userprox = 0;
        $is_sock5 = 0;

        $message = "";

        $zx = "";

        // $botHistory = ManualBotHistory::create([
        //     "bot_auto_follow" => $bot_auto_follow,
        //     "bot_auto_like" => $bot_auto_like,
        //     "bot_auto_comment" => $bot_auto_comment,
        //     "bot_auto_seen_like" => $bot_auto_seen_like,
        //     "input_target" => $request->input('input_target'),
        //     "status" => "running",
        //     "delay" => "3",
        //     "user_id" => $userData->id,
        // ]);

        // $botHistory->save();



        // if ($userData->cookie_data) {
        //     $cookie = $userData->cookie_data;
        //     $useragent = $userData->user_agent;
        //     $getakun = proccess(1, $useragent, 'accounts/current_user/', $cookie);
        //     $getakun = json_decode($getakun[1], true);

        //     if ($getakun['status'] == 'ok') {
        //         $getakunV2 = proccess(1, $useragent, 'users/' . $getakun['user']['pk'] . '/info', $cookie);
        //         $getakunV2 = json_decode($getakunV2[1], true);
        //         $z = "[~] Login as @" . $getakun['user']['username'] . " \n";
        //         // echo "[~] [Media : " . $getakunV2['user']['media_count'] . "] [Follower : " . $getakunV2['user']['follower_count'] . "] [Following : " . $getakunV2['user']['following_count'] . "]\n";
        //         // echo "[~] Please wait 5 second for loading script\n";
        //         // echo "[~] ";
        //     }

        //     if ($bot_auto_follow) {
        //         // $message = followTarget("kelakarindonesia", $useragent, $cookie, $ip, $userprox, $is_sock5);

        //     }

        //     if ($bot_auto_like) {

        //     }

        //     if ($bot_auto_comment) {
        //         // $zx = commentLatestPosts("kelakarindonesia", $cookie, $useragent, $ip, $userprox, $is_sock5);
        //     }


        //     if ($bot_auto_seen_like) {

        //     }



        //     // get folower of target
        //     $targetid = json_decode(request(1, $useragent, 'users/' . $target . '/usernameinfo/', $cookie, 0, array(), $ip, 0, $is_sock5)[1], true);

        //     if ($targetid["status"] == "fail") {
        //         return response()->json(['message' => "Please try again later or login", 'status' => "fail"], 500);
        //     } else {
        //         $gettarget = proccess(1, $useragent, 'users/' . $targetid . '/info', $cookie, 0, array(), $ip, 0, $is_sock5);
        //         $gettarget = json_decode($gettarget[1], true);

        //         $counttargertfix = rand(25, 45);
        //         $jumlah = $counttargertfix;
        //         if (!is_numeric($jumlah)) {
        //             $limit = 1;
        //         } elseif ($jumlah > ($gettarget['user']['follower_count'] - 1)) {
        //             $limit = $gettarget['user']['follower_count'] - 1;
        //         } else {
        //             $limit = $jumlah - 1;
        //         }
        //         $next = false;
        //         $next_id = 0;
        //         $listids = array();
        //         do {
        //             if ($next == true) {
        //                 $parameters = '?max_id=' . $next_id . '';
        //             } else {
        //                 $parameters = '';
        //             }
        //             $req = proccess(1, $useragent, 'friendships/' . $targetid . '/followers/' . $parameters, $cookie, 0, array(), $ip, $userprox, $is_sock5);
        //             $req = json_decode($req[1], true);
        //             if ($req['status'] !== 'ok') {
        //                 var_dump($req);
        //                 exit();
        //             }
        //             shuffle($req['users']);
        //             foreach ($req['users'] as $user) {
        //                 if (!$user['is_private'] && $user['latest_reel_media']) {
        //                     if (count($listids) <= $limit) {
        //                         $listids[] = $user['pk'];
        //                     } else {
        //                         break;
        //                     }
        //                 }
        //             }
        //             if ($req['next_max_id']) {
        //                 $next = true;
        //                 $next_id = $req['next_max_id'];
        //             } else {
        //                 $next = false;
        //                 $next_id = '0';
        //             }
        //         } while (count($listids) <= $limit);
        //     }


        // for ($i = 0; $i < count($listids); $i++) {
        //     $username = array();
        //     $username[$i] = findUsernameById($req['users'], $listids[$i]);
        //     $i++;
        //     // saveData('./data/datafollowers.txt', $i . " https://instagram.com/" . $username[$i] . " DataScape from " . $target . " collected");
        // }

        // for ($i = 0; $i < count($listids); $i++):
        //     $getstory = proccess(1, $useragent, 'feed/user/' . $listids[$i] . '/story/', $cookie, 0, array(), $ip, $userprox, $is_sock5);
        //     $getstory = json_decode($getstory[1], true);
        //     foreach ($getstory['reel']['items'] as $storyitem):
        //         $reels[count($reels)] = $storyitem['id'] . "_" . $getstory['reel']['user']['pk'];
        //         $stories['id'] = $storyitem['id'];
        //         $stories['reels'] = $storyitem['id'] . "_" . $getstory['reel']['user']['pk'];
        //         $stories['reel'] = $storyitem['taken_at'] . '_' . time();
        //         // if (strpos(file_get_contents('./data/storyData.txt'), $stories['reels']) == false) {
        //         //     $hook = '{"live_vods_skipped": {}, "nuxes_skipped": {}, "nuxes": {}, "reels": {"' . $stories['reels'] . '": ["' . $stories['reel'] . '"]}, "live_vods": {}, "reel_media_skipped": {}}';
        //         //     $viewstory = proccess_v2(1, $useragent, 'media/seen/?reel=1&live_vod=0', $cookie, hook('' . $hook . ''), array(), $ip, $user, $is_sock5);
        //         //     $viewstory = json_decode($viewstory[1], true);
        //         //     if ($storyitem['story_polls']) {
        //         //         $stories['pool_id'] = $storyitem['story_polls'][0]['poll_sticker']['poll_id'];
        //         //         $react_1 = proccess(1, $useragent, 'media/' . $stories['id'] . '/' . $stories['pool_id'] . '/story_poll_vote/', $cookie, hook('{"radio_type": "none", "vote": "' . rand(0, 1) . '"}'), array(), $ip, $user, $is_sock5);
        //         //         $react_1 = json_decode($react_1[1], true);
        //         //         if ($react_1['status'] == 'ok') {
        //         //             echo "[~] " . date('d-m-Y H:i:s') . " - Success polling for " . $stories['id'] . "\n";
        //         //         }

        //         //         if ($storyitem['story_countdowns']) {
        //         //             $stories['countdown_id'] = $storyitem['story_countdowns'][0]['countdown_sticker']['countdown_id'];
        //         //             $react_3 = proccess(1, $useragent, 'media/' . $stories['countdown_id'] . '/follow_story_countdown/', $cookie, 0, array(), $prox['ip'], $prox['user'], $prox['is_socks5']);
        //         //             $react_3 = json_decode($react_3[1], true);
        //         //         }
        //         //         if ($storyitem['story_sliders']) {
        //         //             $stories['slider_id'] = $storyitem['story_sliders'][0]['slider_sticker']['slider_id'];
        //         //             $react_4 = proccess(1, $useragent, 'media/' . $stories['id'] . '/' . $stories['slider_id'] . '/story_slider_vote/', $cookie, hook('{"radio_type": "wifi-none", "vote": "1"}'), array(), $prox['ip'], $prox['user'], $prox['is_socks5']);
        //         //             $react_4 = json_decode($react_4[1], true);
        //         //             if ($react_2['status'] == 'ok') {
        //         //                 echo "[~] " . date('d-m-Y H:i:s') . " - Success sent slider for " . $stories['id'] . "\n";
        //         //             }
        //         //         }
        //         //         if ($storyitem['story_quizs']) {
        //         //             $stories['quiz_id'] = $storyitem['story_quizs'][0]['quiz_sticker']['quiz_id'];
        //         //         }
        //         //         if ($viewstory['status'] == 'ok') {

        //         //             $sendLike = proccess(1, $useragent, 'story_interactions/send_story_like', $cookie, "media_id=" . $storyitem['pk'], array(), $prox['ip'], $prox['user'], $prox['is_socks5']);
        //         //             $sendLike = json_decode($sendLike[1], true);

        //         //             if ($sendLike['status'] == 'ok') {
        //         //                 echo "[~] " . date('d-m-Y H:i:s') . " - Success send like for https://instagram.com/stories/" . $storyitem['user']['username'] . "/" . $storyitem['pk'] . "/\n";
        //         //                 saveData('./data/storySeen.txt', $storyitem['user']['username']);
        //         //             } else {
        //         //                 var_dump($sendLike);
        //         //                 exit;
        //         //             }

        //         //             $reels_suc[count($reels_suc)] = $storyitem['id'] . "_" . $getstory['reel']['user']['pk'];
        //         //             echo "[~] " . date('d-m-Y H:i:s') . " - Seen stories " . $stories['id'] . " \n";

        //         //         }
        //         //         $new_run++;
        //         //         $sleepfix1 = rand(25, 45);
        //         //         sleep($sleepfix);
        //         //     }

        //     endforeach;
        //     $sleepfix = rand(25, 45);
        //     // echo "[~] " . date('d-m-Y H:i:s') . " - Sleep for " . $sleepfix . " second to bypass instagram limit== " . count($reels_suc) . "\n";
        //     sleep($sleepfix);
        // endfor;
        // }
        // $input_target = $request->input('input_target');
        // $input_comment = $request->input('input_comment');
        // $delay = $request->input('delay');

        // $useragent = "1";

        // if ($user->instagram_user == "") {
        //     return response()->json([
        //         'status' => 400,
        //         'message' => 'instagram user empty',
        //     ], 400);
        // }



        // InstagramHelper::processHttpRequest(

        // )

        return response()
            ->json(['message' => $bot_auto_follow]);
    }

    public function log()
    {

    }

    public function history(Request $request)
    {

    }

    public function checkUser()
    {
        $user = Auth::user();

        return response()->json([
            "status" => "success",
            "data" => $user,
        ]);
    }

    public function loginInsta(Request $request)
    {
        $user = Auth::user();

        $username_insta = $request->input('username_insta');
        $password_insta = $request->input('password_insta');

        $useragent = generate_useragent();
        $device_id = generate_device_id();

        $loginRes = proccess(
            1,
            $useragent,
            'accounts/login/',
            0,
            hook('{"device_id":"' . $device_id . '","guid":"' . generate_guid() . '","username":"' . $username_insta . '","password":"' . $password_insta . '","Content-Type":"application/x-www-form-urlencoded; charset=UTF-8"}'),
            array(
                'Accept-Language: id-ID, en-US',
                'X-IG-Connection-Type: WIFI'
            )
        );

        $ext = json_decode($loginRes[1]);
        preg_match('#set-cookie: csrftoken=([^;]+)#i', str_replace('Set-Cookie:', 'set-cookie:', $loginRes[0]), $token);
        preg_match_all('%set-cookie: (.*?);%', str_replace('Set-Cookie:', 'set-cookie:', $loginRes[0]), $d);
        $cookie = '';
        for ($o = 0; $o < count($d[0]); $o++) {
            $cookie .= $d[1][$o] . ";";
        }

        if ($ext->status == "ok") {
            User::where("username", $user->username)->update(["instagram_user" => $username_insta, "instagram_password" => $password_insta, "cookie_data" => $cookie, "user_agent" => $useragent]);

            $user = User::where("username", $user->username)->firstOrFail();
            return response()->json(["user" => $user, "data" => $cookie]);
        } else {
            return response()->json(["status" => $ext->status], 500);
        }

        // return response()->json(["data" => $cookie]);
    }
}
