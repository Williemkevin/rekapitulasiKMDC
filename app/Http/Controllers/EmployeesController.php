<?php

namespace App\Http\Controllers;

use App\Models\Employees;
use Illuminate\Http\Request;

class EmployeesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employee = Employees::all();
        return view('employee.index', ['employees' => $employee]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('employees.formcreate');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $employee = new Employees();
        $employee->username = $request->get('username');
        $employee->nama_lengkap = $request->get('nama_lengkap');
        $employee->tanggal_lahir = $request->get('tanggal_lahir');
        $employee->jenis_kelamin = $request->get('jenis_kelamin');
        $employee->agama = $request->get('agama');
        $employee->email = $request->get('email');
        $employee->password = $request->get('password');
        $employee->salt = $request->get('salt');
        $employee->alamat = $request->get('alamat');
        $employee->phone_number = $request->get('phone_number');
        $employee->riwayat_pendidikan = $request->get('riwayat_pendidikan');
        $employee->mulai_kerja = $request->get('mulai_kerja');
        $employee->salary = $request->get('salary');

        $employee->created_at = now("Asia/Bangkok");
        $employee->updated_at = now("Asia/Bangkok");

        $employee->save();
        return redirect()->route('buyer.index')->with('status', 'New Employee is already inserted');
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
    public function edit(employees $employees)
    {
        $employee = Employees::find($employees->nomor_pokok_pegawai);
        return view('employees.formcreate', ['employees' => $employee]);
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
        $employee = new Employees();
        $employee->username = $request->get('username');
        $employee->nama_lengkap = $request->get('nama_lengkap');
        $employee->tanggal_lahir = $request->get('tanggal_lahir');
        $employee->jenis_kelamin = $request->get('jenis_kelamin');
        $employee->agama = $request->get('agama');
        $employee->email = $request->get('email');
        $employee->password = $request->get('password');
        $employee->salt = $request->get('salt');
        $employee->alamat = $request->get('alamat');
        $employee->phone_number = $request->get('phone_number');
        $employee->riwayat_pendidikan = $request->get('riwayat_pendidikan');
        $employee->mulai_kerja = $request->get('mulai_kerja');
        $employee->salary = $request->get('salary');

        $employee->updated_at = now("Asia/Bangkok");

        $employee->save();
        return redirect()->route('buyer.index')->with('status', 'Employee is already updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(employees $employees)
    {
        $employee = Employees::find($employees->nomor_pokok_pegawai);
        $employee->delete();
        return redirect()->route('buyer.index')->with('success', 'Employee is already deleted');
    }
}
