<?php

namespace App\Jobs;

use App\Models\ManualBotHistory;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Log;

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
    $followUrl = 'friendships/create/' . $targetId . '/';
    $followResponse = proccess(1, $useragent, $followUrl, $cookie, 0, array(), $ip, $user, $is_socks5);
    // $followData = json_decode($followResponse[1], true);

    return strval($followResponse);

    if ($followData['status'] == 'ok') {
        // echo "[~] " . date('d-m-Y H:i:s') . " - Success following user with ID: " . $targetId . "\n";
        return " - Success following user with ID: " . $targetId . "\n";
    } else {
        // echo "[!] Error following user with ID: " . $targetId . "\n";
        // var_dump($followData);
        return "error";
    }
}


class ManualBotJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $manualBotId;
    protected $userData;

    protected $target;
    protected $comment;

    public $timeout = 1000;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($manualBotId, $userData, $target, $comment)
    {
        //
        $this->manualBotId = $manualBotId;
        $this->userData = $userData;
        $this->target = $target;
        $this->comment = $comment;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $userData = $this->userData;
        $z = "";
        $getakun = "";

        $target = $this->target;
        $komen = $this->comment;
        $ip = 0;
        $userprox = 0;
        $is_sock5 = 0;

        $message = "";

        if ($userData->cookie_data) {
            $cookie = $userData->cookie_data;
            $useragent = $userData->user_agent;
            $getakun = proccess(1, $useragent, 'accounts/current_user/', $cookie);
            $getakun = json_decode($getakun[1], true);
            // $userPk = $getakun['user']['pk'];

            if ($getakun['status'] == 'ok') {
                $getakunV2 = proccess(1, $useragent, 'users/' . $getakun['user']['pk'] . '/info', $cookie);
                $getakunV2 = json_decode($getakunV2[1], true);
                // $z = "[~] Login as @" . $getakun['user']['username'] . " \n";
                // echo "[~] [Media : " . $getakunV2['user']['media_count'] . "] [Follower : " . $getakunV2['user']['follower_count'] . "] [Following : " . $getakunV2['user']['following_count'] . "]\n";
                // echo "[~] Please wait 5 second for loading script\n";
                // echo "[~] ";

                $log = Log::create([
                    "tag" => "TEST",
                    "message" => "[~] Login as @" . $getakun['user']['username'] . " \n",
                    "manual_bot_history_id" => $this->manualBotId,
                ]);
                $log->save();

                $log = Log::create([
                    "tag" => "TEST",
                    "message" => "[~] [Media : " . $getakunV2['user']['media_count'] . "] [Follower : " . $getakunV2['user']['follower_count'] . "] [Following : " . $getakunV2['user']['following_count'] . "]\n",
                    "manual_bot_history_id" => $this->manualBotId,
                ]);
                $log->save();

                $new_run = 0;
                settype($new_run, "integer");



                //fuction action story
                // $todays = file_get_contents('./data/daily/' . date('d-m-Y') . '.txt');
                // $today = explode("\n", str_replace("\r", "", $todays));
                // $today = array($today)[0];

                $prox['ip'] = 0;
                $prox['user'] = 0;
                $prox['is_socks5'] = 0;

                $log = Log::create([
                    "tag" => "TEST",
                    "message" => "[~] Get followers of " . $target . "\n",
                    "manual_bot_history_id" => $this->manualBotId,
                ]);
                $log->save();

                $new_run = 0;
                settype($new_run, "integer");


                $targetid = json_decode(request(1, $useragent, 'users/' . $target . '/usernameinfo/', $cookie, 0, array(), $prox['ip'], $prox['user'], $prox['is_socks5'])[1], 1)['user']['pk'];
                $gettarget = proccess(1, $useragent, 'users/' . $targetid . '/info', $cookie, 0, array(), $prox['ip'], $prox['user'], $prox['is_socks5']);
                $gettarget = json_decode($gettarget[1], true);
                $log = Log::create([
                    "tag" => "TEST",
                    "message" => "[~] [Media : " . $gettarget['user']['media_count'] . "] [Follower : " . $gettarget['user']['follower_count'] . "] [Following : " . $gettarget['user']['following_count'] . "]\n",
                    "manual_bot_history_id" => $this->manualBotId,
                ]);
                $log->save();

                $counttargertfix = rand(10, 15);
                $jumlah = $counttargertfix;
                if (!is_numeric($jumlah)) {
                    $limit = 1;
                } elseif ($jumlah > ($gettarget['user']['follower_count'] - 1)) {
                    $limit = $gettarget['user']['follower_count'] - 1;
                } else {
                    $limit = $jumlah - 1;
                }
                $next = false;
                $next_id = 0;
                $listids = array();
                do {
                    if ($next == true) {
                        $parameters = '?max_id=' . $next_id . '';
                    } else {
                        $parameters = '';
                    }
                    $req = proccess(1, $useragent, 'friendships/' . $targetid . '/followers/' . $parameters, $cookie, 0, array(), $prox['ip'], $prox['user'], $prox['is_socks5']);
                    $req = json_decode($req[1], true);
                    if ($req['status'] !== 'ok') {

                        $log = Log::create([
                            "tag" => "TEST",
                            "message" => "[~] Failed collecting data.. please login again",
                            "manual_bot_history_id" => $this->manualBotId,
                        ]);
                        $log->save();

                        $botDataUpdated = ManualBotHistory::find($this->manualBotId);
                        if ($botDataUpdated) {
                            $botDataUpdated->status = "failed";
                            $botDataUpdated->save();
                        }


                        var_dump($req);
                        return;
                    }
                    shuffle($req['users']);
                    foreach ($req['users'] as $user) {
                        if (!$user['is_private'] && $user['latest_reel_media']) {
                            if (count($listids) <= $limit) {
                                $listids[] = $user['pk'];
                                $log = Log::create([
                                    "tag" => "TEST",
                                    "message" => "[~] Collecting data followers " . $target . " - " . $user['pk'],
                                    "manual_bot_history_id" => $this->manualBotId,
                                ]);
                                $log->save();
                            } else {
                                break;
                            }
                        }
                    }
                    if ($req['next_max_id']) {
                        $next = true;
                        $next_id = $req['next_max_id'];
                    } else {
                        $next = false;
                        $next_id = '0';
                    }

                } while (count($listids) <= $limit);
                for ($i = 0; $i < count($listids); $i++) {
                    $username = array();
                    $username[$i] = findUsernameById($req['users'], $listids[$i]);
                    // saveData('./data/datafollowers.txt', $i . " https://instagram.com/" . $username[$i] . " DataScape from " . $target . " collected");
                }
                $log = Log::create([
                    "tag" => "TEST",
                    "message" => "[~] " . count($listids) . " followers of " . $target . " collected\n",
                    "manual_bot_history_id" => $this->manualBotId,
                ]);
                $log->save();

                $reels = array();
                $reels_suc = array();
                for ($i = 0; $i < count($listids); $i++):
                    $getstory = proccess(1, $useragent, 'feed/user/' . $listids[$i] . '/story/', $cookie, 0, array(), $prox['ip'], $prox['user'], $prox['is_socks5']);
                    $getstory = json_decode($getstory[1], true);
                    foreach ($getstory['reel']['items'] as $storyitem):
                        $reels[count($reels)] = $storyitem['id'] . "_" . $getstory['reel']['user']['pk'];
                        $stories['id'] = $storyitem['id'];
                        $stories['reels'] = $storyitem['id'] . "_" . $getstory['reel']['user']['pk'];
                        $stories['reel'] = $storyitem['taken_at'] . '_' . time();

                        $x = "";

                        // if (strpos($x, $stories['reels']) == false) {
                        $hook = '{"live_vods_skipped": {}, "nuxes_skipped": {}, "nuxes": {}, "reels": {"' . $stories['reels'] . '": ["' . $stories['reel'] . '"]}, "live_vods": {}, "reel_media_skipped": {}}';
                        $viewstory = proccess_v2(1, $useragent, 'media/seen/?reel=1&live_vod=0', $cookie, hook('' . $hook . ''), array(), $prox['ip'], $prox['user'], $prox['is_socks5']);
                        $viewstory = json_decode($viewstory[1], true);
                        // if ($storyitem['story_polls']) {
                        //     $stories['pool_id'] = $storyitem['story_polls'][0]['poll_sticker']['poll_id'];
                        //     $react_1 = proccess(1, $useragent, 'media/' . $stories['id'] . '/' . $stories['pool_id'] . '/story_poll_vote/', $cookie, hook('{"radio_type": "none", "vote": "' . rand(0, 1) . '"}'), array(), $prox['ip'], $prox['user'], $prox['is_socks5']);
                        //     $react_1 = json_decode($react_1[1], true);
                        //     if ($react_1['status'] == 'ok') {
                        //         echo "[~] " . date('d-m-Y H:i:s') . " - Success polling for " . $stories['id'] . "\n";
                        //     }
                        //     //echo "[Stories Polls True : ".$stories['pool_id']." : ".$react_1[1]."] ";
                        // }
                        // if ($storyitem['story_questions']) {
                        //     $stories['question_id'] = $storyitem['story_questions'][0]['question_sticker']['question_id'];
                        //     // $rand = rand(0, count($komen) - 1);
                        //     // $textAnswer = $komen[$rand];
                        //     $react_2 = proccess(1, $useragent, 'media/' . $stories['id'] . '/' . $stories['question_id'] . '/story_question_response/', $cookie, hook('{"response": "' . $textAnswer . '", "type": "text"}'), array(), $prox['ip'], $prox['user'], $prox['is_socks5']);
                        //     $react_2 = json_decode($react_2[1], true);
                        //     if ($react_2['status'] == 'ok') {
                        //         echo "[~] " . date('d-m-Y H:i:s') . " - Question answer for " . $stories['id'] . " : " . $textAnswer . " \n";
                        //     }
                        //     //echo "[Stories Question True : ".$stories['question_id']." : ".$react_2[1]."] ";
                        // }
                        // if ($storyitem['story_countdowns']) {
                        //     $stories['countdown_id'] = $storyitem['story_countdowns'][0]['countdown_sticker']['countdown_id'];
                        //     $react_3 = proccess(1, $useragent, 'media/' . $stories['countdown_id'] . '/follow_story_countdown/', $cookie, 0, array(), $prox['ip'], $prox['user'], $prox['is_socks5']);
                        //     $react_3 = json_decode($react_3[1], true);
                        //     //echo "[Stories Countdown True : ".$stories['countdown_id']." : ".$react_3[1]."] ";
                        // }
                        // if ($storyitem['story_sliders']) {
                        //     $stories['slider_id'] = $storyitem['story_sliders'][0]['slider_sticker']['slider_id'];
                        //     $react_4 = proccess(1, $useragent, 'media/' . $stories['id'] . '/' . $stories['slider_id'] . '/story_slider_vote/', $cookie, hook('{"radio_type": "wifi-none", "vote": "1"}'), array(), $prox['ip'], $prox['user'], $prox['is_socks5']);
                        //     $react_4 = json_decode($react_4[1], true);
                        //     if ($react_2['status'] == 'ok') {
                        //         echo "[~] " . date('d-m-Y H:i:s') . " - Success sent slider for " . $stories['id'] . "\n";
                        //     }
                        //     //echo "[Stories Slider True : ".$stories['slider_id']." : ".$react_4[1]."] ";
                        // }
                        // if ($storyitem['story_quizs']) {
                        //     $stories['quiz_id'] = $storyitem['story_quizs'][0]['quiz_sticker']['quiz_id'];
                        //     //$react_5	  		= proccess(1, $useragent, 'media/'.$stories['id'].'/'.$stories['quiz_id'].'/story_poll_vote/', $cookie, hook('{"radio_type": "none", "vote": "'.rand(0,3).'"}'));
                        //     //echo "[Stories Quiz True : ".$stories['quiz_id']." : ".$react_5[1]."] ";
                        // }
                        print_r($viewstory);
                        if ($viewstory && $viewstory['status'] == 'ok') {
                            $sendLike = proccess(1, $useragent, 'story_interactions/send_story_like', $cookie, "media_id=" . $storyitem['pk'], array(), $prox['ip'], $prox['user'], $prox['is_socks5']);
                            $sendLike = json_decode($sendLike[1], true);

                            if ($sendLike['status'] == 'ok') {
                                $log = Log::create([
                                    "tag" => "TEST",
                                    "message" => "[~] " . date('d-m-Y H:i:s') . " - Success send like for https://instagram.com/stories/" . $storyitem['user']['username'] . "/" . $storyitem['pk'] . "/\n",
                                    "manual_bot_history_id" => $this->manualBotId,
                                ]);
                                $log->save();
                            } else {
                                var_dump($sendLike);
                                exit;
                            }

                            $reels_suc[count($reels_suc)] = $storyitem['id'] . "_" . $getstory['reel']['user']['pk'];
                            $log = Log::create([
                                "tag" => "TEST",
                                "message" => "[~] " . date('d-m-Y H:i:s') . " - Seen stories " . $stories['id'] . " \n",
                                "manual_bot_history_id" => $this->manualBotId,
                            ]);
                            $log->save();
                            // $x += $stories['reels'] . "\n";
                            // saveData('./data/daily/' . date('d-m-Y') . '.txt', $stories['reels']);
                            // }
                            $new_run++;

                            $sleep_1 = rand(20, 30);
                            $log = Log::create([
                                "tag" => "TEST",
                                "message" => "[~] story sleep " . $sleep_1,
                                "manual_bot_history_id" => $this->manualBotId,
                            ]);
                            $log->save();
                            sleep($sleep_1);
                        }
                    endforeach;
                    $sleep_2 = rand(20, 30);
                    echo "[~] " . date('d-m-Y H:i:s') . " - Sleep for " . $sleep_2 . " second to bypass instagram limit== [$new_run] \n";
                    sleep($sleep_2);
                endfor;
                $log = Log::create([
                    "tag" => "TEST",
                    "message" => "[~] " . count($reels) . " story from " . $target . " collected\n",
                    "manual_bot_history_id" => $this->manualBotId,
                ]);
                $log->save();
                $log = Log::create([
                    "tag" => "TEST",
                    "message" => "[~] " . count($reels_suc) . " story from " . $target . " marked as seen\n",
                    "manual_bot_history_id" => $this->manualBotId,
                ]);
                $log->save();

                // echo "[~] " . count($today) . " story reacted today\n";
                // saveData('./data/total.txt', count($today) . "story reacted today\n");

                // $log = Log::create([
                //     "tag" => "TEST",
                //     "message" => "[~] " . date('d-m-Y H:i:s') . " - Sleep for 150 second to bypass instagram limit\n",
                //     "manual_bot_history_id" => $this->manualBotId,
                // ]);
                // $log->save();

                // for ($x = 0; $x <= 4; $x++) {
                //     echo "========";
                //     sleep(30);
                // }
                // echo "\n\n";

                $botDataUpdated = ManualBotHistory::find($this->manualBotId);
                if ($botDataUpdated) {
                    $botDataUpdated->status = "stopped";
                    $botDataUpdated->save();
                }


                $log = Log::create([
                    "tag" => "TEST",
                    "message" => "[~] Finish ",
                    "manual_bot_history_id" => $this->manualBotId,
                ]);
                $log->save();


                // input target action
                // if (count($today) > 2) {
                // echo "[~] " . count($today) . " story direaksi hari ini\n";
                // echo "[~] Batas penggunaan API Instagram 500 tayangan/hari\n";

                // input lama delay per hari
                // $totalDetikTidur = 72000; // Total detik tidur (20 jam)
                // $jam = floor($totalDetikTidur / 3600); // Menghitung jumlah jam
                // $menit = floor(($totalDetikTidur % 3600) / 60); // Menghitung jumlah menit
                // $detik = $totalDetikTidur % 60; // Menghitung jumlah detik

                // echo "[~] Tidur selama " . $jam . " jam, " . $menit . " menit, dan " . $detik . " detik untuk menghindari batas penggunaan Instagram\n";

                // sleep($totalDetikTidur); // Tidur selama totalDetikTidur detik
                // echo "[~] Selesai tidur...\n\n";
                // }



            } else {
                $botDataUpdated = ManualBotHistory::find($this->manualBotId);
                if ($botDataUpdated) {
                    $botDataUpdated->status = "failed";
                    $botDataUpdated->save();
                }

                $log = Log::create([
                    "tag" => "TEST",
                    "message" => "[~] Get account status failed",
                    "manual_bot_history_id" => $this->manualBotId,
                ]);

                $log->save();
                sleep(3);
            }

            // if ($bot_auto_follow) {

            // }

            //     if ($bot_auto_like) {

            //     }

            //     if ($bot_auto_comment) {
            //         // $zx = commentLatestPosts("kelakarindonesia", $cookie, $useragent, $ip, $userprox, $is_sock5);
            //     }


            //     if ($bot_auto_seen_like) {

            //     }



            //     // get folower of target
            // $targetid = json_decode(request(1, $useragent, 'users/' . $target . '/usernameinfo/', $cookie, 0, array(), $ip, 0, $is_sock5)[1], true);

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


        } else {
            $botDataUpdated = ManualBotHistory::find($this->manualBotId);
            if ($botDataUpdated) {
                $botDataUpdated->status = "failed";
                $botDataUpdated->save();
            }

            $log = Log::create([
                "tag" => "FAILED",
                "message" => "Cookie data not found",
                "manual_bot_history_id" => $this->manualBotId,
            ]);

            $log->save();
            sleep(3);
        }
    }
}
