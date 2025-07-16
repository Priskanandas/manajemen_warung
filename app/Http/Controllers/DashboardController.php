<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Activitylog\Models\Activity;
use App\Http\Requests\SettingRequest;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Pembayaran;
use App\Models\Penjualan;
use App\Models\Barang;
use Illuminate\Support\Facades\DB;



class DashboardController extends Controller
{


public function index()
{
    $warungId = session('warung_id');

    $totalCustomer = Penjualan::where('id_warung', $warungId)->count();
    $totalVisitor  = User::has('warungs')->count();
    $totalIncome   = Pembayaran::where('id_warung', $warungId)->sum('total_bayar');
    $totalProduct  = Barang::where('id_warung', $warungId)->count();

    $logs = Activity::latest()->limit(5)->get();

    // Data untuk chart penjualan 7 hari terakhir
    $penjualanChart = Penjualan::where('id_warung', $warungId)
        ->selectRaw('DATE(tanggal) as tanggal, SUM(total_harga) as total')
        ->whereDate('tanggal', '>=', now()->subDays(6))
        ->groupBy('tanggal')
        ->orderBy('tanggal')
        ->get();

    $labels = $penjualanChart->pluck('tanggal')->map(function ($date) {
        return \Carbon\Carbon::parse($date)->format('d M');
    });

    $values = $penjualanChart->pluck('total');

    return view('admin.dashboard', compact(
        'totalCustomer',
        'totalVisitor',
        'totalIncome',
        'totalProduct',
        'logs',
        'labels',
        'values'
    ));
}



    public function activity_logs()
    {
        $logs = Activity::where('causer_id', auth()->id())
                        ->when(session('warung_id'), function ($query) {
                            $query->where('properties->warung_id', session('warung_id'));
                        })
                        ->latest()
                        ->paginate(10);

        return view('admin.logs', compact('logs'));
    }

    public function settings_store(SettingRequest $request)
    {
        if ($request->file('logo')) {
            $filename = $request->file('logo')->getClientOriginalName();
            $filePath = $request->file('logo')->storeAs('uploads', $filename, 'public');
            setting()->set('logo', $filePath);
        }

        setting()->set('site_name', $request->site_name);
        setting()->set('keyword', $request->keyword);
        setting()->set('description', $request->description);
        setting()->set('url', $request->url);
        setting()->save();

        return redirect()->back()->with('success', 'Pengaturan berhasil disimpan');
    }

    public function profile_update(Request $request)
    {
        $data = ['name' => $request->name];

        if ($request->old_password && $request->new_password) {
            if (!Hash::check($request->old_password, auth()->user()->password)) {
                session()->flash('failed', 'Password lama salah!');
                return redirect()->back();
            }

            $data['password'] = Hash::make($request->new_password);
        }

        if ($request->avatar) {
            $data['avatar'] = $request->avatar;

            if (auth()->user()->avatar) {
                @unlink(storage_path('app/public/' . auth()->user()->avatar));
            }
        }

        auth()->user()->update($data);

        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }

    public function upload_avatar(Request $request)
    {
        $request->validate(['avatar'  => 'file|image|mimes:jpg,png,svg|max:1024']);

        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $fileName = $file->getClientOriginalName();
            $folder = 'user-' . auth()->id();

            $file->storeAs('avatars/' . $folder, $fileName, 'public');

            return 'avatars/' . $folder . '/' . $fileName;
        }

        return '';
    }

    public function delete_logs()
    {
        $logs = Activity::where('created_at', '<=', Carbon::now()->subWeeks())->delete();

        return back()->with('success', $logs . ' log berhasil dihapus!');
    }
}
