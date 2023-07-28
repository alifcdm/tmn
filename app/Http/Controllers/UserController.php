<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Models\User;
use App\Exports\UserExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = DB::table('users')->where('deleted_at', null)->get();
        return view('users.index', compact('users'))
            ->with('i', (request()->input('page', 1) - 1) * 100);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create', ['user' => User::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'fullname' => 'required',
            'nip' => 'required|numeric',
            'role' => 'required',
            'email' => 'required',
            'phone' => 'required|numeric',
            'address' => 'required',
            'password' => 'required',
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);

        try {
            User::create($validatedData);
            //return redirect()->back()
            return redirect()->route('dashboard')
                ->with('success', 'Users Created successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error during the creation!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\users  $product
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\users  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\users  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'fullname' => 'required',
            'nip' => 'required|numeric',
            'role' => 'required',
            'email' => 'required',
            'phone' => 'required|numeric',
            'address' => 'required',
            'password' => 'required',
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);

        //--------proses update data lama & upload file foto baru--------

        try {
            $user->update($validatedData);
            return redirect()->route('dashboard')
                ->with('success', 'Users updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error during the creation!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        // //--------hapus dulu fisik file foto--------

        $deleted_at = Carbon::parse(date('Y-m-d H:i:s'), config()->get("app.timezone"))->timezone("Asia/Jakarta")->toDateTimeString();
        try {
            $user->deleted_at = $deleted_at;
            $user->save();

            return redirect()->route('users.index')
                ->with('success', 'Users deleted successfully');
        } catch (\Exception $e) {
            //return redirect()->back()
            return redirect()->route('users.index')
                ->with('error', 'Error during the creation!');
        }
    }

    public function usersExcel()
    {
        return Excel::download(new UserExport, 'user.xlsx');
    }

    public function all(Request $request)
    {
        $id = $request->input('id');
        if ($id) {
            $id_user = User::find($id);
            if ($id_user) {
                return ResponseFormatter::success(
                    $id_user,
                    'Data User Berhasil ditampilkan'
                );
            } else {
                return ResponseFormatter::error(
                    null,
                    'Data User Gagal ditampilkan',
                    404
                );
            }
        }

        $user = User::all();
        return ResponseFormatter::success(
            $user,
            'Data User Berhasil Ditampilkan'
        );
    }
}
