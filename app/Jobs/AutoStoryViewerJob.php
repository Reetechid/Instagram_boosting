<?php

namespace App\Jobs;

use App\Models\Cookie;
use App\Models\Manualbot;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AutoStoryViewerJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

     private static $status = 'running';

    public function findUsernameById($users, $targetId)
    {
        foreach ($users as $user) {
            if ($user['pk'] == $targetId) {
                return $user['username'];
            }
        }
        return null;
    }
    public function proccess($ighost, $useragent, $url, $cookie = 0, $data = 0, $httpheader = array(), $proxy = 0, $userpwd = 0, $is_socks5 = 0)
    {
        $url = $ighost ? 'https://i.instagram.com/api/v1/' . $url : $url;
        $ch  = curl_init($url);
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
        if ($data) :
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        endif;
        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch);
        if (!$httpcode)
            return false;
        else {
            $header = substr($response, 0, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
            $body   = substr($response, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
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
    function hook($data)
    {
        return 'ig_sig_key_version=4&signed_body=' . hash_hmac('sha256', $data, '5d406b6939d4fb10d3edb4ac0247d495b697543d3f53195deb269ec016a67911') . '.' . urlencode($data);
    }
    public static function setStatus($status)
    {
        self::$status = $status;
    }

    public function handle()
    {
        \Log::info('Auto Story Viewer Command started...');
        $cookieDataModel = Cookie::find(2);
        $cookie = $cookieDataModel->cookie_data;
        $useragent = $cookieDataModel->useragent;

        $cookieDataModel_Dump = Cookie::find(3);
        $cookie_dump = $cookieDataModel_Dump->cookie_data;
        $useragent_dump = $cookieDataModel_Dump->useragent;
        $target_data = $cookieDataModel_Dump->target;
        $target2_data = $cookieDataModel_Dump->target2;
        $target3_data = $cookieDataModel_Dump->target3;

        $status = Manualbot::find(2);
        $statusValue = $status->status;
        echo  $statusValue;

        \Log::info("Reetech Product Auto Story Viewer\n");
            if ($cookie_dump || $cookie) {
                $getakun =  $this->proccess(1, $useragent, 'accounts/current_user/', $cookie);
                $getakun = json_decode($getakun[1], true);

                $getakun_dump =  $this->proccess(1, $useragent_dump, 'accounts/current_user/', $cookie_dump);
                $getakun_dump = json_decode($getakun_dump[1], true);

                if ($getakun['status'] == 'ok' || $getakun_dump['status'] == 'ok') {
                    $getakunV2 =  $this->proccess(1, $useragent, 'users/' . $getakun['user']['pk'] . '/info', $cookie);
                    $getakunV2 = json_decode($getakunV2[1], true);

                    $getakunV2_dump =  $this->proccess(1, $useragent_dump, 'users/' . $getakun_dump['user']['pk'] . '/info', $cookie_dump);
                    $getakunV2_dump = json_decode($getakunV2_dump[1], true);

                    \Log::info("[~] Login as @" . $getakun['user']['username'] . " \n");

                    echo "[~] Login as @" . $getakun['user']['username'] . " \n";
                    echo "[~] [Media : " . $getakunV2['user']['media_count'] . "] [Follower : " . $getakunV2['user']['follower_count'] . "] [Following : " . $getakunV2['user']['following_count'] . "]\n";
                    echo "[~] Please wait 5 seconds for loading script\n";
                    echo "[~] ";
                    for ($x = 0; $x <= 4; $x++) {
                        echo "========";
                        sleep(1);
                    }
                    echo "\n\n";

                    echo "[~] Login as @" . $getakun_dump['user']['username'] . " (Akun Dump) \n";
                    echo "[~] [Media : " . $getakunV2_dump['user']['media_count'] . "] [Follower : " . $getakunV2_dump['user']['follower_count'] . "] [Following : " . $getakunV2_dump['user']['following_count'] . "]\n";
                    echo "[~] Please wait 5 seconds for loading script\n";
                    echo "[~] ";
                    for ($x = 0; $x <= 4; $x++) {
                        echo "========";
                        sleep(1);
                    }
                    echo "\n\n";

                    $new_run = 0;
                    settype($new_run, "integer");
                    $loop = true;
                    do {
                        $targets = $target_data."|".$target2_data."|".$target3_data;
                        $targets = explode("|", str_replace("\r", "", $targets));
                        $targets = array_filter($targets);

                        foreach ($targets as $target) {
                    // $komens		= file_get_contents('./data/' . $answerFile);
                    // $komen		= explode("\n", str_replace("\r", "", $komens));
                    // $komen		= array($komen)[0];
                    $indeksAcak = array_rand($targets);
                    $targetAcak = $targets[$indeksAcak];
                    //
                    // $todays		= file_get_contents('./data/daily/' . date('d-m-Y') . '.txt');
                    // $today		= explode("\n", str_replace("\r", "", $todays));
                    // $today		= array($today)[0];
                    $prox['ip']			= 0;
                    $prox['user']		= 0;
                    $prox['is_socks5']	= 0;
                    //
                    echo "[~] AKUN_DUMP @" . $getakun_dump['user']['username'] . "Mendapatkan pengikut dari " . $targetAcak . "\n";

                    $targetid	= json_decode($this->request(1, $useragent_dump, 'users/' . $targetAcak . '/usernameinfo/', $cookie_dump, 0, array(), $prox['ip'], $prox['user'], $prox['is_socks5'])[1], 1)['user']['pk'];
                    echo "[~] AKUN_DUMP @" . $targetid;
                    $gettarget = $this->proccess(1, $useragent_dump, 'users/' . $targetid . '/info', $cookie_dump, 0, array(), $prox['ip'], $prox['user'], $prox['is_socks5']);
                    $gettarget = json_decode($gettarget[1], true);
                    // var_dump($gettarget);
                    echo "[~] [Media : " . $gettarget['user']['media_count'] . "] [Follower : " . $gettarget['user']['follower_count'] . "] [Following : " . $gettarget['user']['following_count'] . "]\n";
                    $counttargertfix = rand(10,15);
                    $jumlah		= $counttargertfix;
                    if (!is_numeric($jumlah)) {
                        $limit = 1;
                    } elseif ($jumlah > ($gettarget['user']['follower_count'] - 1)) {
                        $limit = $gettarget['user']['follower_count'] - 1;
                    } else {
                        $limit = $jumlah - 1;
                    }
                    $next      	= false;
                    $next_id    = 0;
                    $listids	= array();
                    do {
                        if ($next == true) {
                            $parameters = '?max_id=' . $next_id . '';
                        } else {
                            $parameters = '';
                        }
                        $req = $this->proccess(1, $useragent, 'friendships/' . $targetid . '/followers/' . $parameters, $cookie, 0, array(), $prox['ip'], $prox['user'], $prox['is_socks5']);
                        $req = json_decode($req[1], true);

                        if (!isset($req['status']) || $req['status'] !== 'ok') {
                            var_dump($req);
                            exit();
                        }

                        shuffle($req['users']); // Mengacak urutan pengguna dalam respons

                        foreach ($req['users'] as $user) {
                            if (!$user['is_private'] && $user['latest_reel_media']) {
                                if (count($listids) <= $limit) {
                                    $listids[] = $user['pk'];
                                } else {
                                    break; // Keluar dari loop jika sudah mencapai batas $limit
                                }
                            }
                        }

                        if (isset($req['next_max_id'])) {
                            $next = true;
                            $next_id = $req['next_max_id'];
                        } else {
                            $next = false;
                            $next_id = '0';
                        }

                    } while (count($listids) <= $limit);

                    for ($i = 0; $i < count($listids); $i++) {
                        $username = array();
                        $username[$i] = $this->findUsernameById($req['users'], $listids[$i]);
                        echo $i . " https://instagram.com/" . $username[$i] . " DataScape from " . $target . " collected\n";
                    }

                    echo "[~] " . count($listids) . " followers of " . $target . " collected\n";
                    // fwrite($outputHandle, "[~] " . count($listids) . " followers of " . $target . " collected\n");
                    $reels = array();
                    $reels_suc = array();
                    $sleepfix = rand(20,60);
                    echo "[~] " . date('d-m-Y H:i:s') . " - Sleep for " . $sleepfix .  "\n";
                    // fwrite($outputHandle,"[~] " . date('d-m-Y H:i:s') . " - Sleep for " . $sleepfix . "\n"); 
                    sleep($sleepfix);
                    $jumlah_total_data_berhasil_disimpan = 0;
                    for ($i = 0; $i < count($listids); $i++) :
                        $getstory = $this->proccess(1, $useragent, 'feed/user/' . $listids[$i] . '/story/', $cookie, 0, array(), $prox['ip'], $prox['user'], $prox['is_socks5']);
                        $getstory = json_decode($getstory[1], true);

                        if (isset($getstory['reel']['items'][0])) {
                            $storyitem = $getstory['reel']['items'][0];
                            $reels[] = $storyitem['id'] . "_" . $getstory['reel']['user']['pk'];
                            $stories['id'] = $storyitem['id'];
                            $stories['reels'] = $storyitem['id'] . "_" . $getstory['reel']['user']['pk'];
                            $stories['reel'] = $storyitem['taken_at'] . '_' . time();

                            if ($stories['reels'] === false) {
                                $hook = '{"live_vods_skipped": {}, "nuxes_skipped": {}, "nuxes": {}, "reels": {"' . $stories['reels'] . '": ["' . $stories['reel'] . '"]}, "live_vods": {}, "reel_media_skipped": {}}';
                                $viewstory = $this->proccess_v2(1, $useragent, 'media/seen/?reel=1&live_vod=0', $cookie, $this->hook('' . $hook . ''), array(), $prox['ip'], $prox['user'], $prox['is_socks5']);
                                $viewstory = json_decode($viewstory[1], true);

                                if ($viewstory['status'] == 'ok') {
                                    $sendLike = $this->proccess(1, $useragent, 'story_interactions/send_story_like', $cookie, "media_id=" . $storyitem['pk'], array(), $prox['ip'], $prox['user'], $prox['is_socks5']);
                                    $sendLike = json_decode($sendLike[1], true);

                                    if ($sendLike['status'] == 'ok') {
                                        echo "[~] " . date('d-m-Y H:i:s') . " - Berhasil memberikan suka untuk https://instagram.com/stories/" . $storyitem['user']['username'] . "/" . $storyitem['pk'] . "/\n";
                                        $jumlah_total_data_berhasil_disimpan++;
                                    }
                                    $reels_suc[] = $storyitem['id'] . "_" . $getstory['reel']['user']['pk'];
                                    
                                }
                                else{
                                    echo "[~] " . date('d-m-Y H:i:s') . " Gagal memberikan suka\n";
                                    // fwrite($outputHandle, "[~] " . date('d-m-Y H:i:s') . " Gagal memberikan suka\n");
                                    $new_run++;
                                }
                                $new_run++;
                            }
                        }
                        $sleepfix = rand(20, 60);
                        echo "[~] " . date('d-m-Y H:i:s') . " - Tidur selama " . $sleepfix . " detik untuk menghindari batasan Instagram, Suka pada index ke = " . count($reels) . " dari total = " . count($listids) . "\n";
                        // fwrite($outputHandle,"[~] " . date('d-m-Y H:i:s') . " - Tidur selama " . $sleepfix . " detik untuk menghindari batasan Instagram, Suka pada index ke = " . count($reels) . " dari total = " . count($listids) . "\n");
                        sleep($sleepfix);
                        
                    endfor;
                    // Menampilkan jumlah total data yang berhasi
                    // echo "[~] " . $jumlah_total_data_berhasil_disimpan . " total data yang berhasil disimpan\n";
                    echo "[~] " . count($reels) . " total data story dari " . $target . " yang telah diambil\n";
                    // fwrite($outputHandle,"[~] " . count($reels) . " total data story dari " . $target . " yang telah diambil\n");
                    echo "[~] " . count($reels_suc) . " total story yang berhasil dilike dari " . $target . "\n";
                    // fwrite($outputHandle,"[~] " . count($reels_suc) . " total story yang berhasil dilike dari " . $target . "\n");
                    // echo "[~] " . $jumlah_total_reels_suc . " Total like story hari ini \n";
                    // fwrite($outputHandle,"[~] " . $jumlah_total_reels_suc . " Total like story hari ini \n");
                    $sleepfix = rand(20, 50);
                    echo "[~] " . date('d-m-Y H:i:s') . " - Sleep for ".$sleepfix." second to bypass Instagram limit\n";
                    // fwrite($outputHandle,"[~] " . date('d-m-Y H:i:s') . " - Sleep for ".$sleepfix." second to bypass Instagram limit\n");
                    echo "[~] ";
                    for ($x = 0; $x <= 4; $x++) {
                        echo "========";
                        sleep($sleepfix);
                    }
                    echo "\n\n";
                }
                         
                        } while ($loop == true);

    if ($reels_suc > 200) {
        echo "[~] Batas penggunaan API Instagram 250 tayangan/hari\n";
        $totalDetikTidur = 72000; // Total detik tidur (20 jam)
        $jam = floor($totalDetikTidur / 3600); // Menghitung jumlah jam
        $menit = floor(($totalDetikTidur % 3600) / 60); // Menghitung jumlah menit
        $detik = $totalDetikTidur % 60; // Menghitung jumlah detik

        echo "[~] Tidur selama " . $jam . " jam, " . $menit . " menit, dan " . $detik . " detik untuk menghindari batas penggunaan Instagram\n";
        sleep(72000); // Tidur selama totalDetikTidur detik
        echo "[~] Selesai tidur...\n\n";
    }

    } else {
        echo "[!] Error : " . json_encode($getakun) . "\n";
    }

    } else {
        echo "[!] Please login\n";
    }
    }
    
}
