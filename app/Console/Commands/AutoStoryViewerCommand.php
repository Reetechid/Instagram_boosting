<?php

namespace App\Console\Commands;
use App\Http\Controllers\igfuncController;
use App\Models\Cookie;

use Illuminate\Console\Command;

class AutoStoryViewerCommand extends Command
{
    protected $signature = 'auto-story-viewer:run';
    protected $description = 'Run Auto Story Viewer Script';

    public function findUsernameById($users, $targetId)
    {
        foreach ($users as $user) {
            if ($user['pk'] == $targetId) {
                return $user['username'];
            }
        }
        return null;
    }


    public function handle()
    {
        \Log::info('Auto Story Viewer Command started...');
        $cookieDataModel = Cookie::find(2);
        $cookie = $cookieDataModel->cookie_data;
        $useragent = $cookieDataModel->useragent;

        $cookieDataModel_Dump = Cookie::find(2);
        $cookie_dump = $cookieDataModel_Dump->cookie_data;
        $useragent_dump = $cookieDataModel_Dump->useragent;
        $target_data = $cookieDataModel_Dump->target;
        $target2_data = $cookieDataModel_Dump->target2;
        $target3_data = $cookieDataModel_Dump->target3;

        \Log::info("Reetech Product Auto Story Viewer\n");
            if ($cookie_dump || $cookie) {
                \Log::info("masuk sini\n");
                $getakun = igfuncController::proccess(1, $useragent, 'accounts/current_user/', $cookie);
                $getakun = json_decode($getakun[1], true);

                $getakun_dump = igfuncController::proccess(1, $useragent_dump, 'accounts/current_user/', $cookie_dump);
                $getakun_dump = json_decode($getakun_dump[1], true);

                if ($getakun['status'] == 'ok' || $getakun_dump['status'] == 'ok') {
                    $getakunV2 = igfuncController::proccess(1, $useragent, 'users/' . $getakun['user']['pk'] . '/info', $cookie);
                    $getakunV2 = json_decode($getakunV2[1], true);

                    $getakunV2_dump = igfuncController::proccess(1, $useragent_dump, 'users/' . $getakun_dump['user']['pk'] . '/info', $cookie_dump);
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

                    $targetid = json_decode(igfuncController::request(1, $useragent_dump, 'users/' . $targetAcak . '/usernameinfo/', $cookie_dump, 0, array(), $prox['ip'], $prox['user'], $prox['is_socks5'])[1], 1)['user']['pk'];
                    // ... (lanjutan kode

                    $gettarget = igfuncController::proccess(1, $useragent_dump, 'users/' . $targetid . '/info', $cookie_dump, 0, array(), $prox['ip'], $prox['user'], $prox['is_socks5']);
                    $gettarget = json_decode($gettarget[1], true);
                    var_dump($gettarget);
                    echo "[~] [Media : " . $gettarget['user']['media_count'] . "] [Follower : " . $gettarget['user']['follower_count'] . "] [Following : " . $gettarget['user']['following_count'] . "]\n";
                    $counttargertfix = rand(1,4);
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
                        $req        = igfuncController::proccess(1, $useragent, 'friendships/' . $targetid . '/followers/' . $parameters, $cookie, 0, array(), $prox['ip'], $prox['user'], $prox['is_socks5']);
                        $req        = json_decode($req[1], true);
                        if ($req['status'] !== 'ok') {
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
                        if ($req['next_max_id']) {
                            $next = true;
                            $next_id	= $req['next_max_id'];
                        } else {
                            $next = false;
                            $next_id = '0';
                        }
                    } while (count($listids) <= $limit);

                            for ($i = 0; $i < count($listids); $i++) {
                                $username = array();
                                $username[$i] = $this->findUsernameById($req['users'], $listids[$i]);
                                // saveData('./data/datafollowers.txt', $i . " https://instagram.com/" . $username[$i] . " DataScape from " . $target . " collected");
                            }

                        echo "[~] " . count($listids) . " followers of " . $target . " collected\n";
                    // fwrite($outputHandle, "[~] " . count($listids) . " followers of " . $target . " collected\n");
                    $reels = array();
                    $reels_suc = array();
                    $sleepfix = rand(2,6);
                    echo "[~] " . date('d-m-Y H:i:s') . " - Sleep for " . $sleepfix .  "\n";
                    // fwrite($outputHandle,"[~] " . date('d-m-Y H:i:s') . " - Sleep for " . $sleepfix . "\n"); 
                    sleep($sleepfix);
                    $jumlah_total_data_berhasil_disimpan = 0;

                    for ($i = 0; $i < count($listids); $i++) :
                        $getstory = igfuncController::proccess(1, $useragent, 'feed/user/' . $listids[$i] . '/story/', $cookie, 0, array(), $prox['ip'], $prox['user'], $prox['is_socks5']);
                        $getstory = json_decode($getstory[1], true);

                        if (isset($getstory['reel']['items'][0])) {
                            $storyitem = $getstory['reel']['items'][0];
                            $reels[] = $storyitem['id'] . "_" . $getstory['reel']['user']['pk'];
                            $stories['id'] = $storyitem['id'];
                            $stories['reels'] = $storyitem['id'] . "_" . $getstory['reel']['user']['pk'];
                            $stories['reel'] = $storyitem['taken_at'] . '_' . time();

                            if ($stories['reels'] === false) {
                                $hook = '{"live_vods_skipped": {}, "nuxes_skipped": {}, "nuxes": {}, "reels": {"' . $stories['reels'] . '": ["' . $stories['reel'] . '"]}, "live_vods": {}, "reel_media_skipped": {}}';
                                $viewstory = igfuncController::proccess_v2(1, $useragent, 'media/seen/?reel=1&live_vod=0', $cookie, hook('' . $hook . ''), array(), $prox['ip'], $prox['user'], $prox['is_socks5']);
                                $viewstory = json_decode($viewstory[1], true);

                                if ($viewstory['status'] == 'ok') {
                                    $sendLike = igfuncController::proccess(1, $useragent, 'story_interactions/send_story_like', $cookie, "media_id=" . $storyitem['pk'], array(), $prox['ip'], $prox['user'], $prox['is_socks5']);
                                    $sendLike = json_decode($sendLike[1], true);

                                    if ($sendLike['status'] == 'ok') {
                                        echo "[~] " . date('d-m-Y H:i:s') . " - Berhasil memberikan suka untuk https://instagram.com/stories/" . $storyitem['user']['username'] . "/" . $storyitem['pk'] . "/\n";
                                        // fwrite($outputHandle, "[~] " . date('d-m-Y H:i:s') . " - Berhasil memberikan suka untuk https://instagram.com/stories/" . $storyitem['user']['username'] . "/" . $storyitem['pk'] . "/\n");
                                        // saveData('./data/storySeen.txt', $storyitem['user']['username']);
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
                        $sleepfix = rand(2, 1);
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
                    $sleepfix = rand(2, 5);
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

    if ($reels_suc > 2) {
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
