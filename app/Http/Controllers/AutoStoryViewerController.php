<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Artisan;
use App\Jobs\AutoStoryViewerJob;


use App\Models\Cookie;
use App\Models\Manualbot;
use Illuminate\Http\Request;

class AutoStoryViewerController extends Controller
{

    public static function startAutoStory()
    {
		$statusValue = 'Nilai status baru';

		// Membuat entri baru dalam tabel Manualbot
		$manualbot = \App\Models\Manualbot::create(['status' => $statusValue]);

		// Memeriksa apakah entri berhasil ditambahkan
		if ($manualbot) {
			echo "Entri baru berhasil ditambahkan ke dalam tabel Manualbot dengan status: $statusValue";
		} else {
			echo "Gagal menambahkan entri baru ke dalam tabel Manualbot";
		}
			//    AutoStoryViewerJob::dispatch();
	   
       $response = ['status' => 'success', 'message' => 'Proses Auto Story Viewer dimulai'];
	   return response()->json($response);
    }

    public function stopAutoStory()
    {
		Manualbot::where('id', 1)->update(['status' => "stop"]);
       	$response = ['status' => 'success', 'message' => 'Proses Auto Story Viewer dihentikan.'];
	   	return response()->json($response);
    }
    public function processTargets(Request $request)
	{
		$targets = $request->input('targets');
		$targets2 = $request->input('targets2');
		$targets3 = $request->input('targets3');

		cookie::where('id', 3)->update(array('target1' => $targets, 'target2' => $targets2, 'target3' => $targets3));
		$response = ['status' => 'success', 'message' => 'Targets berhasil diinput']; // Ubah pesan sesuai kebutuhan

        return response()->json($response);
	}
	public function index (){
		$cookieDataModel = Cookie::find(2);
		$cookie = $cookieDataModel->cookie_data;
		$useragent = $cookieDataModel->useragent;

		$cookieDataModel_Dump = Cookie::find(3);
		$cookie_dump = $cookieDataModel_Dump->cookie_data;
		$useragent_dump = $cookieDataModel_Dump->useragent;
		$target_data = $cookieDataModel_Dump->target;
		$target2_data = $cookieDataModel_Dump->target2;
		$target3_data = $cookieDataModel_Dump->target3;

		 if ($cookie_dump || $cookie) {
                $getakun = igfuncController::proccess(1, $useragent, 'accounts/current_user/', $cookie);
                $getakun = json_decode($getakun[1], true);

                $getakun_dump = igfuncController::proccess(1, $useragent_dump, 'accounts/current_user/', $cookie_dump);
                $getakun_dump = json_decode($getakun_dump[1], true);

                if ($getakun['status'] == 'ok' || $getakun_dump['status'] == 'ok') {
                    $getakunV2 = igfuncController::proccess(1, $useragent, 'users/' . $getakun['user']['pk'] . '/info', $cookie);
                    $getakunV2 = json_decode($getakunV2[1], true);

                    $getakunV2_dump = igfuncController::proccess(1, $useragent_dump, 'users/' . $getakun_dump['user']['pk'] . '/info', $cookie_dump);
                    $getakunV2_dump = json_decode($getakunV2_dump[1], true);

                    $username_akun_client = $getakun['user']['username'];
					$totalpost_akun_client = $getakunV2['user']['media_count'];
					$Followers_akun_client = $getakunV2['user']['follower_count'];
					$Following_akun_client = $getakunV2['user']['following_count'];

					$username_akun_dump = $getakun_dump['user']['username'];
					$totalpost_akun_dump = $getakunV2_dump['user']['media_count'];
					$Followers_akun_dump = $getakunV2_dump['user']['follower_count'];
					$Following_akun_dump = $getakunV2_dump['user']['following_count'];
				}
			}
		return view('index', compact('username_akun_client', 'totalpost_akun_client', 'Followers_akun_client', 'Following_akun_client',
		'username_akun_dump', 'totalpost_akun_dump', 'Followers_akun_dump', 'Following_akun_dump',
		'target_data','target2_data','target3_data'));
	}
}