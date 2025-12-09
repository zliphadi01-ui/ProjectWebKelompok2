<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pasien;
use App\Models\Pendaftaran;
use App\Models\Pemeriksaan;
use App\Models\LabRequest;
use App\Models\RawatInap;
use App\Models\RekamMedisRequest;
use Illuminate\Support\Facades\Auth;

class RekamMedisController extends Controller
{
    public function index()
    {
        // Dashboard Stats for Rekam Medis
        $totalPasien = Pasien::count();
        $kunjunganHariIni = Pendaftaran::whereDate('created_at', now())->count();
        $rawatInapAktif = RawatInap::where('status', 'Dirawat')->count();
        $pendingRequestCount = RekamMedisRequest::pending()->count();

        return view('rekam_medis.index', compact('totalPasien', 'kunjunganHariIni', 'rawatInapAktif', 'pendingRequestCount'));
    }

    public function pasien(Request $request)
    {
        $query = Pasien::query();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where('nama', 'like', "%{$search}%")
                  ->orWhere('no_rm', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%");
        }

        $pasien = $query->orderBy('nama')->paginate(20);

        return view('rekam_medis.pasien', compact('pasien'));
    }

    public function riwayat($id)
    {
        $pasien = Pasien::findOrFail($id);
        
        // Gather all history
        $pendaftaran = Pendaftaran::where('pasien_id', $id)->orderBy('created_at', 'desc')->get();
        $pemeriksaan = Pemeriksaan::where('pasien_id', $id)->orderBy('created_at', 'desc')->get();
        $labRequests = LabRequest::where('pasien_id', $id)->orderBy('created_at', 'desc')->get();
        $rawatInap = RawatInap::with('cppt')->where('pasien_id', $id)->orderBy('created_at', 'desc')->get();

        // Merge and sort by date (simplified approach: just passing collections)
        // In a more complex app, we might merge these into a single timeline collection.

        return view('rekam_medis.riwayat', compact('pasien', 'pendaftaran', 'pemeriksaan', 'labRequests', 'rawatInap'));
    }

    /**
     * Show all access requests from doctors
     */
    public function requestList(Request $request)
    {
        $filter = $request->get('filter', 'all');

        $query = RekamMedisRequest::with(['dokter', 'pasien', 'processedBy']);

        // Apply filters
        switch ($filter) {
            case 'pending':
                $query->pending();
                break;
            case 'approved':
                $query->approved()->where('expires_at', '>', now());
                break;
            case 'expired':
                $query->where(function($q) {
                    $q->where('status', 'expired')
                      ->orWhere(function($subQ) {
                          $subQ->where('status', 'approved')
                               ->where('expires_at', '<=', now());
                      });
                });
                break;
            case 'rejected':
                $query->rejected();
                break;
        }

        $requests = $query->orderBy('created_at', 'desc')->paginate(20);

        // Count by status for tabs
        $pendingCount = RekamMedisRequest::pending()->count();
        $approvedCount = RekamMedisRequest::approved()->where('expires_at', '>', now())->count();
        $expiredCount = RekamMedisRequest::where(function($q) {
            $q->where('status', 'expired')
              ->orWhere(function($subQ) {
                  $subQ->where('status', 'approved')
                       ->where('expires_at', '<=', now());
              });
        })->count();
        $rejectedCount = RekamMedisRequest::rejected()->count();
        $allCount = RekamMedisRequest::count();

        return view('rekam_medis.requests', compact(
            'requests',
            'filter',
            'pendingCount',
            'approvedCount',
            'expiredCount',
            'rejectedCount',
            'allCount'
        ));
    }

    /**
     * Approve an access request (24 hour expiration)
     */
    public function approveRequest($id)
    {
        $request = RekamMedisRequest::findOrFail($id);

        if ($request->status !== 'pending') {
            return redirect()->back()
                ->with('error', 'Permintaan ini sudah diproses sebelumnya.');
        }

        $request->approve(Auth::id());

        return redirect()->back()
            ->with('success', 'Permintaan akses disetujui. Akses berlaku selama 24 jam.');
    }

    /**
     * Reject an access request with notes
     */
    public function rejectRequest(Request $request, $id)
    {
        $request->validate([
            'catatan_penolakan' => 'required|string|max:500',
        ]);

        $accessRequest = RekamMedisRequest::findOrFail($id);

        if ($accessRequest->status !== 'pending') {
            return redirect()->back()
                ->with('error', 'Permintaan ini sudah diproses sebelumnya.');
        }

        $accessRequest->reject(Auth::id(), $request->catatan_penolakan);

        return redirect()->back()
            ->with('success', 'Permintaan akses ditolak.');
    }

    /**
     * API endpoint: Get pending request count for notification badge
     */
    public function getPendingCount()
    {
        $count = RekamMedisRequest::pending()->count();
        return response()->json(['count' => $count]);
    }
}
