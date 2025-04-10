<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
// Model
use App\Models\DashboardModel;
use App\Models\DataReqModel;
use App\Models\Data_m_s_Model;

class DashboardController extends Controller {
    public function index() {
    $loggedInUser = session('logged_in_user')['level'];
    $name_page = "B'Mine - Dashboard";
    $minepermit = DashboardModel::countAccess1();
    $simper = DashboardModel::countAccess2();
    $sheprosess = DataReqModel::where('status', 1)->count();
    $pjoprosess = DataReqModel::where('status', 2)->count();
    $becprosess = DataReqModel::where('status', 3)->count();
    $kttprosess = DataReqModel::where('status', 4)->count();
    $minepermit_data = DataReqModel::where('validasi_in', 1)->count();
    $simper_data = DataReqModel::where('validasi_in', 2)->count();
    $totaloutstanding = $sheprosess + $pjoprosess + $becprosess + $kttprosess;
    
    // Mendapatkan jumlah status
    $jumlahStatus = $this->getStatusCounts();
    
    // Ekstrak nilai jumlah status secara individu
    $sheprosess = $jumlahStatus['she'];
    $pjoprosess = $jumlahStatus['pjo'];
    $becprosess = $jumlahStatus['bec'];
    $kttprosess = $jumlahStatus['ktt'];

        // Mendapatkan jumlah KTT task berdasarkan area
    $kttTaskAreas = $jumlahStatus['ktt_by_area'];
    
    // Menghitung data yang akan kedaluwarsa untuk MINE PERMIT (validasi_in = 1)
    // simper_minepermit - Data MINE PERMIT yang kedaluwarsa dalam 1 bulan
    $oneMonthFromNow = now()->addMonth();
    $minepermit_oneMonthToExpire = Data_m_s_Model::where('validasi_in', 1)
        ->whereNotNull('expiry_date')
        ->whereDate('expiry_date', '<=', $oneMonthFromNow)
        ->whereDate('expiry_date', '>=', now())
        ->count();

    // simper_minepermit - Data MINE PERMIT yang kedaluwarsa dalam 2 bulan
    $twoMonthsFromNow = now()->addMonths(2);
    $minepermit_twoMonthsToExpire = Data_m_s_Model::where('validasi_in', 1)
        ->whereNotNull('expiry_date')
        ->whereDate('expiry_date', '<=', $twoMonthsFromNow)
        ->whereDate('expiry_date', '>', $oneMonthFromNow)
        ->count();

    // Menghitung data yang akan kedaluwarsa untuk SIMPER (validasi_in = 2)
    // simper_minepermit - Data SIMPER yang kedaluwarsa dalam 1 bulan
    $simper_oneMonthToExpire = Data_m_s_Model::where('validasi_in', 2)
        ->whereNotNull('expiry_date')
        ->whereDate('expiry_date', '<=', $oneMonthFromNow)
        ->whereDate('expiry_date', '>=', now())
        ->count();

    // simper_minepermit - Data SIMPER yang kedaluwarsa dalam 2 bulan
    $simper_twoMonthsToExpire = Data_m_s_Model::where('validasi_in', 2)
        ->whereNotNull('expiry_date')
        ->whereDate('expiry_date', '<=', $twoMonthsFromNow)
        ->whereDate('expiry_date', '>', $oneMonthFromNow)
        ->count();

       // Jika user adalah KTT, ambil area dari session
    $userArea = null;
    if ($loggedInUser === 'ktt') {
        $userArea = session('logged_in_user')['area'] ?? null;
    }
    
    if ($loggedInUser === 'admin' || $loggedInUser === 'section_admin' || $loggedInUser === 'she' || $loggedInUser === 'pjo') {
        // Jika pengguna adalah admin, section_admin, she, atau pjo
        return view('dashboard.dashboard', compact(
            'name_page', 'minepermit', 'simper', 'sheprosess', 'pjoprosess', 
            'becprosess', 'kttprosess', 'totaloutstanding', 'simper_data', 
            'minepermit_data', 'minepermit_oneMonthToExpire', 'minepermit_twoMonthsToExpire',
            'simper_oneMonthToExpire', 'simper_twoMonthsToExpire',
            'kttTaskAreas'
        ));
    } 
    elseif ($loggedInUser === 'bec' || $loggedInUser === 'ktt') {
        // Jika pengguna adalah bec atau ktt
        return view('dashboard.dashboard_external', compact(
            'name_page', 'minepermit', 'simper', 'sheprosess', 'pjoprosess', 
            'becprosess', 'kttprosess', 'totaloutstanding', 'simper_data', 
            'minepermit_data', 'minepermit_oneMonthToExpire', 'minepermit_twoMonthsToExpire',
            'simper_oneMonthToExpire', 'simper_twoMonthsToExpire',
            'kttTaskAreas', 'userArea'
        ));
    }
    else {
        // Jika tidak ada peran yang sesuai
        echo "Tidak ada peran yang dikenali";
    }
}

/**
 * Mendapatkan jumlah permintaan data berdasarkan jenis status dan area KTT
 *
 * @return array
 */
/**
 * Mendapatkan jumlah permintaan data berdasarkan jenis status dan area KTT
 *
 * @return array
 */
/**
 * Mendapatkan jumlah permintaan data berdasarkan jenis status dan area KTT
 *
 * @return array
 */
public function getStatusCounts()
{
    // Mendefinisikan pemetaan status
    $pemetaanStatus = [
        'she' => 1,
        'pjo' => 2,
        'bec' => 3,
        'ktt' => 4
    ];
    
    // Inisialisasi array jumlah
    $jumlah = [];
    
    // Mendapatkan jumlah untuk setiap status
    $jumlah['she'] = DataReqModel::where('status', $pemetaanStatus['she'])->count();
    $jumlah['pjo'] = DataReqModel::where('status', $pemetaanStatus['pjo'])->count();
    $jumlah['bec'] = DataReqModel::where('status', $pemetaanStatus['bec'])->count();
    $jumlah['ktt'] = DataReqModel::where('status', $pemetaanStatus['ktt'])->count();
    
    // Menghitung jumlah KTT task berdasarkan area - hanya yang status "no"
    $areaKTT = ['BT', 'FSP', 'TA', 'TJ'];
    
    $jumlah['ktt_by_area'] = [];
    
    // Debugging data sebelum melakukan count
    $ktts = DataReqModel::where('status', $pemetaanStatus['ktt'])
            ->select('id', 'ktt')
            ->get();
    
    foreach ($areaKTT as $area) {
        // Pastikan hanya menghitung yang nilai "no"
        $count = 0;
        foreach ($ktts as $ktt) {
            $kttData = json_decode($ktt->ktt, true);
            if (isset($kttData[$area]) && $kttData[$area] === 'no') {
                $count++;
            }
        }
        $jumlah['ktt_by_area'][$area] = $count;
    }
    
    return $jumlah;
}

    public function about() {
        $name_page  = "B'Mine - About";
        return view('dashboard.about', compact('name_page'));
    }
      public function reset_password(Request $request) {
        $name_page  = "B'Mine - Dashboard";
        return view('setting.reset_password', compact('name_page'));
    }
 /**
     * Mendapatkan data permintaan permit berdasarkan parameter tahun
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPermitRequestsData(Request $request)
    {
        // Dapatkan tahun dari request, default ke tahun saat ini
        $year = $request->input('year', Carbon::now()->year);
        
        // Set rentang tanggal berdasarkan tahun yang dipilih
        $startDate = Carbon::createFromDate($year, 1, 1)->startOfDay();
        $endDate = Carbon::createFromDate($year, 12, 31)->endOfDay();
        
        // Array untuk menyimpan jumlah permintaan per bulan (1-12)
        $simperCounts = array_fill(0, 12, 0);
        $minePermitCounts = array_fill(0, 12, 0);
        
        // Query untuk menghitung jumlah permintaan per bulan dan per tipe
        $data = DB::table('data_m_s')
            ->select(
                DB::raw('MONTH(date_req) as month'),
                'validasi_in',
                DB::raw('COUNT(id) as total')
            )
            ->whereBetween('date_req', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
            ->whereIn('validasi_in', [1, 2]) // Hanya ambil SIMPER (1) dan Mine Permit (2)
            ->groupBy('month', 'validasi_in')
            ->get();
        
        // Populasi array hasil berdasarkan data dari database
        foreach ($data as $item) {
            $month = $item->month - 1; // Adjust untuk array 0-based
            
            if ($item->validasi_in == 1) {
                // SIMPER
                $simperCounts[$month] = (int)$item->total;
            } elseif ($item->validasi_in == 2) {
                // Mine Permit
                $minePermitCounts[$month] = (int)$item->total;
            }
        }
        
        // Buat array label bulan
        $months = [
            'January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December'
        ];
        
        // Hitung total untuk donut chart
        $totalSimper = array_sum($simperCounts);
        $totalMinePermit = array_sum($minePermitCounts);
        
        // Return data dalam format JSON
        return response()->json([
            'labels' => $months,
            'simper' => $simperCounts,
            'minePermit' => $minePermitCounts,
            'totalSimper' => $totalSimper, 
            'totalMinePermit' => $totalMinePermit
        ]);
    }

    /**
     * Endpoint alternatif untuk mendapatkan data berdasarkan rentang tanggal kustom
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCustomRangeData(Request $request)
    {
        // Validasi input
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);
        
        $startDate = Carbon::parse($request->start_date)->startOfDay();
        $endDate = Carbon::parse($request->end_date)->endOfDay();
        
        // Hitung jumlah bulan antara tanggal mulai dan akhir
        $monthDiff = $endDate->diffInMonths($startDate) + 1;
        
        // Buat array untuk label bulan yang akan ditampilkan
        $labels = [];
        $simperCounts = [];
        $minePermitCounts = [];
        
        // Generate label dan array kosong untuk data
        $currentDate = clone $startDate;
        for ($i = 0; $i < $monthDiff; $i++) {
            $labels[] = $currentDate->format('F Y');
            $simperCounts[] = 0;
            $minePermitCounts[] = 0;
            $currentDate->addMonth();
        }
        
        // Query untuk mendapatkan data dalam rentang yang ditentukan
        $data = DB::table('data_m_s')
            ->select(
                DB::raw('DATE_FORMAT(date_req, "%Y-%m") as month_year'),
                'validasi_in',
                DB::raw('COUNT(id) as total')
            )
            ->whereBetween('date_req', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
            ->whereIn('validasi_in', [1, 2]) // Hanya ambil SIMPER (1) dan Mine Permit (2)
            ->groupBy('month_year', 'validasi_in')
            ->get();
        
        // Populasi array hasil
        foreach ($data as $item) {
            $date = Carbon::createFromFormat('Y-m', $item->month_year);
            $monthLabel = $date->format('F Y');
            $index = array_search($monthLabel, $labels);
            
            if ($index !== false) {
                if ($item->validasi_in == 1) {
                    // SIMPER
                    $simperCounts[$index] = (int)$item->total;
                } elseif ($item->validasi_in == 2) {
                    // Mine Permit
                    $minePermitCounts[$index] = (int)$item->total;
                }
            }
        }
        
        // Hitung total untuk donut chart
        $totalSimper = array_sum($simperCounts);
        $totalMinePermit = array_sum($minePermitCounts);
        
        // Return data dalam format JSON
        return response()->json([
            'labels' => $labels,
            'simper' => $simperCounts,
            'minePermit' => $minePermitCounts,
            'totalSimper' => $totalSimper,
            'totalMinePermit' => $totalMinePermit
        ]);
    }
}
