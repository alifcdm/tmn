<?php

namespace App\Http\Controllers;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Absensi;
use App\Models\User;
use App\Exports\AbsensiExport;
use DateTime;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class AbsensiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->role == 'admin') {
            $a = Absensi::all();
            $absensi = $a->where('user.deleted_at', null);
            $isAbsen = Absensi::where('user_id', Auth::user()->id)->whereDate('created_at', date('Y-m-d'))->first();
        } else {
            $absensi = Absensi::where('user_id', Auth::user()->id)->latest()->get();
            $isAbsen = Absensi::where('user_id', Auth::user()->id)->whereDate('created_at', date('Y-m-d'))->first();
        }

        return view('absensi.index', [
            'absensi' => $absensi,
            'isAbsen' => $isAbsen,
        ]);
    }

    public function search(Request $request)
    {
        $isAbsen = null;
        $isAbsen = Absensi::where('user_id', Auth::user()->id)->whereDate('created_at', date('Y-m-d'))->first();
        $absensi = Absensi::whereDate('created_at', 'LIKE', $request->post('tanggal'))->where('user_id', Auth::user()->id)->get();
        if (count($absensi) == 0) {
            $absensi = Absensi::where('user_id', Auth::user()->id)->get();
        }
        return view('absensi.index', [
            'absensi' => $absensi,
            'isAbsen' => $isAbsen,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'status' => 'required'
        ]);
        $validated['user_id'] = Auth::user()->id;
        $validated['status'] = $request->post('status');

        Absensi::create($validated);
        try {

            //return redirect()->back()
            return redirect()->back()
                ->with('success', 'Kamu Telah Absen, Terima Kasih!');
        } catch (\Exception $e) {
            //return redirect()->back()
            return redirect()->back()
                ->with('error', 'Error during the creation!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Absensi  $absensi
     * @return \Illuminate\Http\Response
     */
    public function show(Absensi $absensi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Absensi  $absensi
     * @return \Illuminate\Http\Response
     */
    public function edit(Absensi $absensi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Absensi  $absensi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $clock_out = Carbon::parse(date('Y-m-d H:i:s'), config()->get("app.timezone"))->timezone("Asia/Jakarta")->toDateTimeString();
        try {
            $absensi = Absensi::findOrFail($id);
            if ($absensi->status == 'attend') {
                $absensi->clock_out = $clock_out;
                $absensi->save();
            }
            //return redirect()->back()
            return redirect()->back()
                ->with('success', 'Kamu Telah Absen, Terima Kasih!');
        } catch (\Exception $e) {
            //return redirect()->back()
            return redirect()->back()
                ->with('error', 'Error during the creation!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Absensi  $absensi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Absensi $absensi)
    {
        $absensi->delete();

        return redirect()->route('users.index')
            ->with('success', 'Users deleted successfully');
    }

    public function absensiExcel()
    {
        return Excel::download(new AbsensiExport, 'absensi.xlsx');
    }
}
