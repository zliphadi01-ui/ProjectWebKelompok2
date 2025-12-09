<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RekamMedisRequest;
use App\Models\Pasien;
use App\Models\Pendaftaran;
use App\Models\Pemeriksaan;
use App\Models\LabRequest;
use App\Models\RawatInap;
use Illuminate\Support\Facades\Auth;

class DokterRekamMedisController extends Controller
{
    /**
     * Dashboard for doctors - show statistics and active access
     */
    public function index()
    {
        $dokterId = Auth::id();

        // Statistics
        $totalRequests = RekamMedisRequest::forDokter($dokterId)->count();
        $pendingRequests = RekamMedisRequest::forDokter($dokterId)->pending()->count();
        
        // Active access (approved and not expired)
        $activeAccess = RekamMedisRequest::forDokter($dokterId)
            ->approved()
            ->where('expires_at', '>', now())
            ->count();
        
        // Expired requests
        $expiredRequests = RekamMedisRequest::forDokter($dokterId)
            ->where(function($query) {
                $query->where('status', 'expired')
                      ->orWhere(function($q) {
                          $q->where('status', 'approved')
                            ->where('expires_at', '<=', now());
                      });
            })
            ->count();

        // Recently approved patients with active access
        $approvedPatients = RekamMedisRequest::with('pasien')
            ->forDokter($dokterId)
            ->approved()
            ->where('expires_at', '>', now())
            ->orderBy('processed_at', 'desc')
            ->limit(10)
            ->get();

        // Soon to expire (less than 2 hours)
        $soonToExpire = RekamMedisRequest::with('pasien')
            ->forDokter($dokterId)
            ->approved()
            ->where('expires_at', '>', now())
            ->where('expires_at', '<=', now()->addHours(2))
            ->get();

        return view('dokter.rekam_medis.index', compact(
            'totalRequests',
            'pendingRequests',
            'activeAccess',
            'expiredRequests',
            'approvedPatients',
            'soonToExpire'
        ));
    }

    /**
     * Show all patients with their access status for current doctor
     */
    public function patientList(Request $request)
    {
        $dokterId = Auth::id();
        $search = $request->get('search');

        // Get all patients with their request status for this doctor
        $query = Pasien::query();

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('no_rm', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%");
            });
        }

        $pasienList = $query->orderBy('nama')->paginate(20);

        // For each patient, get their request status
        foreach ($pasienList as $pasien) {
            $latestRequest = RekamMedisRequest::forDokter($dokterId)
                ->forPasien($pasien->id)
                ->orderBy('created_at', 'desc')
                ->first();

            $pasien->requestStatus = $this->getAccessStatus($latestRequest);
            $pasien->latestRequest = $latestRequest;
        }

        return view('dokter.rekam_medis.patients', compact('pasienList', 'search'));
    }

    /**
     * Show request form for specific patient
     */
    public function requestAccess($pasienId)
    {
        $pasien = Pasien::findOrFail($pasienId);
        
        return view('dokter.rekam_medis.request', compact('pasien'));
    }

    /**
     * Submit access request
     */
    public function submitRequest(Request $request)
    {
        $request->validate([
            'pasien_id' => 'required|exists:pasien,id',
            'keterangan' => 'required|string|max:500',
        ]);

        $dokterId = Auth::id();

        // Check if there's already a pending request from this doctor for this patient
        $existingPending = RekamMedisRequest::forDokter($dokterId)
            ->forPasien($request->pasien_id)
            ->pending()
            ->first();

        if ($existingPending) {
            return redirect()->back()
                ->with('warning', 'Anda sudah memiliki permintaan yang sedang menunggu persetujuan untuk pasien ini.');
        }

        // Check if there's active access
        $activeAccess = RekamMedisRequest::forDokter($dokterId)
            ->forPasien($request->pasien_id)
            ->approved()
            ->where('expires_at', '>', now())
            ->first();

        if ($activeAccess) {
            return redirect()->route('dokter.rekam-medis.view', $request->pasien_id)
                ->with('info', 'Anda sudah memiliki akses aktif ke rekam medis pasien ini.');
        }

        // Create new request
        RekamMedisRequest::create([
            'dokter_id' => $dokterId,
            'pasien_id' => $request->pasien_id,
            'keterangan' => $request->keterangan,
            'status' => 'pending',
            'requested_at' => now(),
        ]);

        return redirect()->route('dokter.rekam-medis.my-requests')
            ->with('success', 'Permintaan akses rekam medis berhasil dikirim. Menunggu persetujuan dari staff rekam medis.');
    }

    /**
     * Show all requests from current doctor
     */
    public function myRequests()
    {
        $dokterId = Auth::id();

        $requests = RekamMedisRequest::with(['pasien', 'processedBy'])
            ->forDokter($dokterId)
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('dokter.rekam_medis.my_requests', compact('requests'));
    }

    /**
     * View patient medical record (only if access is approved and not expired)
     */
    public function viewPatientRecord($pasienId)
    {
        $dokterId = Auth::id();
        $pasien = Pasien::findOrFail($pasienId);

        // Check if doctor has active access
        $activeAccess = RekamMedisRequest::forDokter($dokterId)
            ->forPasien($pasienId)
            ->approved()
            ->where('expires_at', '>', now())
            ->first();

        if (!$activeAccess) {
            return redirect()->route('dokter.rekam-medis.patients')
                ->with('error', 'Anda tidak memiliki akses ke rekam medis pasien ini. Silakan ajukan permintaan akses terlebih dahulu.');
        }

        // Gather all history
        $pendaftaran = Pendaftaran::where('pasien_id', $pasienId)->orderBy('created_at', 'desc')->get();
        $pemeriksaan = Pemeriksaan::where('pasien_id', $pasienId)->orderBy('created_at', 'desc')->get();
        $labRequests = LabRequest::where('pasien_id', $pasienId)->orderBy('created_at', 'desc')->get();
        $rawatInap = RawatInap::with('cppt')->where('pasien_id', $pasienId)->orderBy('created_at', 'desc')->get();

        return view('dokter.rekam_medis.view', compact(
            'pasien',
            'pendaftaran',
            'pemeriksaan',
            'labRequests',
            'rawatInap',
            'activeAccess'
        ));
    }

    /**
     * Cancel pending request
     */
    public function cancelRequest($requestId)
    {
        $dokterId = Auth::id();
        
        $request = RekamMedisRequest::forDokter($dokterId)
            ->pending()
            ->findOrFail($requestId);

        $request->delete();

        return redirect()->back()
            ->with('success', 'Permintaan akses berhasil dibatalkan.');
    }

    /**
     * Helper: Get access status for display
     */
    private function getAccessStatus($request)
    {
        if (!$request) {
            return ['status' => 'no_access', 'label' => 'Belum Ada Akses', 'class' => 'secondary'];
        }

        if ($request->status === 'pending') {
            return ['status' => 'pending', 'label' => 'Menunggu Persetujuan', 'class' => 'warning'];
        }

        if ($request->status === 'rejected') {
            return ['status' => 'rejected', 'label' => 'Ditolak', 'class' => 'danger'];
        }

        if ($request->status === 'approved') {
            if ($request->isExpired()) {
                return ['status' => 'expired', 'label' => 'Kadaluarsa', 'class' => 'secondary'];
            }
            return ['status' => 'active', 'label' => 'Aktif', 'class' => 'success'];
        }

        if ($request->status === 'expired') {
            return ['status' => 'expired', 'label' => 'Kadaluarsa', 'class' => 'secondary'];
        }

        return ['status' => 'unknown', 'label' => 'Tidak Diketahui', 'class' => 'secondary'];
    }
}
