<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $adminAktif = Admin::join('users', 'admins.user_id', '=', 'users.id')
            ->select('admins.*', 'users.*')
            ->where('status', '1')->get();
        $adminNonaktif = Admin::join('users', 'admins.user_id', '=', 'users.id')
            ->select('admins.*', 'users.*')
            ->where('status', '0')->get();

        return view('admin.index', compact('adminAktif', 'adminNonaktif'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = new User();
        $user->name = $request->get('namaAdmin');
        $user->email = $request->get('emailAdmin');
        $user->username = $request->get('usernameAdmin');
        $user->password = Hash::make($request->get('password'));
        $user->role = "admin";
        $user->last_login = now("Asia/Bangkok");
        $user->created_at = now("Asia/Bangkok");
        $user->updated_at = now("Asia/Bangkok");
        $user->save();

        $admin = new Admin();
        $admin->nama_lengkap = $request->get('namaAdmin');
        $admin->status = "1";
        $admin->user_id = $user->id;
        $admin->created_at = now("Asia/Bangkok");
        $admin->updated_at = now("Asia/Bangkok");
        $user->admin()->save($admin);

        return redirect()->route('admin.index')->with('status', 'New Admin  ' .  $admin->nama_lengkap . ' is already inserted');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $admin = Admin::where('user_id', $id)->first();
        $user = User::where('id', $id)->first();
        return view('admin.edit', compact('admin', 'user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $admin = Admin::find($id);
        $user = User::find($admin->user_id);

        $user->name = $request->get('namaAdmin');
        $user->email = $request->get('emailAdmin');
        $user->username = $request->get('usernameAdmin');
        $user->updated_at = now("Asia/Bangkok");
        $user->save();

        $admin->nama_lengkap = $request->get('namaAdmin');
        $admin->created_at = now("Asia/Bangkok");
        $admin->updated_at = now("Asia/Bangkok");
        $user->dokter()->save($admin);

        return redirect()->route('admin.index')->with('status', 'Admin ' .  $admin->nama_lengkap . ' is already updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function nonaktifkan(Request $request)
    {
        $admin = Admin::where('user_id', $request->get('id'))->first();
        $admin->status = '0';
        $admin->save();
        return response()->json(array('status' => 'success'), 200);
    }

    public function aktifkan(Request $request)
    {
        $admin = Admin::where('user_id', $request->get('id'))->first();
        $admin->status = '1';
        $admin->save();
        return response()->json(array('status' => 'success'), 200);
    }
}
