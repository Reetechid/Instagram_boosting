<?php

namespace App\Http\Controllers;

use App\Jobs\ManualBotJob;
use App\Models\ManualBotHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
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

    public function infoRun(Request $request, string $id)
    {
        $userData = Auth::user();

        $manualBotHistory = $userData->manualBotHistories()->where("id", $id)->first();

        return response()->json([
            "status" => "success",
            "data" => $manualBotHistory,
        ]);
    }

    public function run(Request $request)
    {
        $userData = Auth::user();

        $bot_auto_follow = $request->input('bot_auto_follow');
        $bot_auto_like = $request->input('bot_auto_like');
        $bot_auto_comment = $request->input('bot_auto_comment');
        $bot_auto_seen_like = $request->input('bot_auto_seen_like');

        $histories = $userData->manualBotHistories()->where('status', 'running')->first();

        // if ($histories != null) {
        //     return response()->json([
        //         "status" => "failed",
        //         "message" => "there is a bot running"
        //     ]);
        // }


        $botHistory = ManualBotHistory::create([
            "bot_auto_follow" => $bot_auto_follow,
            "bot_auto_like" => $bot_auto_like,
            "bot_auto_comment" => $bot_auto_comment,
            "bot_auto_seen_like" => $bot_auto_seen_like,
            "input_target" => $request->input('input_target'),
            "status" => "running",
            "start_time" => Carbon::now(),
            "delay" => "3",
            "user_id" => $userData->id,
        ]);

        $botHistory->save();

        $target = $request->input("input_target");
        $comment = $request->input("input_comment");

        ManualBotJob::dispatch($botHistory->id, $userData, $target, $comment);



        return response()
            ->json(['status' => 'success', 'message' => 'bot successfully run', 'bot_id' => $botHistory->id]);
    }

    public function log(Request $request, string $id)
    {
        $userData = Auth::user();

        $manualBotHistory = $userData->manualBotHistories()->where("id", $id)->first();

        if ($manualBotHistory->status == "failed") {
            return response()->json([
                "status" => "failed",
                "data" => $manualBotHistory->logs,
            ]);

        }

        if ($manualBotHistory->status == "stopped") {
            return response()->json([
                "status" => "stopped",
                "data" => $manualBotHistory->logs,
            ]);

        }

        return response()->json([
            "status" => "success",
            "data" => $manualBotHistory->logs()->orderBy("id", "desc")->get(),
        ]);
    }

    public function history(Request $request)
    {
        $userData = Auth::user();

        $manualBotHistory = $userData->manualBotHistories()->orderBy('updated_at', 'desc')->get();

        return response()->json([
            "status" => "success",
            "data" => $manualBotHistory,
        ]);
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
            return response()->json(["status" => $ext->status, "x" => $ext], 500);
        }

        // return response()->json(["data" => $cookie]);
    }
}
