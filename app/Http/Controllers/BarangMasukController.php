<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangMasuk;
use Illuminate\Http\Request;
use DB;

class BarangMasukController extends Controller
{
    public function index(Request $request)
    {
        $rsetBarangMasuk = BarangMasuk::with('barang')->latest()->paginate(10);
        return view('vbarangmasuk.index', compact('rsetBarangMasuk'))
            ->with('i', (request()->input('page', 1) - 1) * 10);
    }
    
    public function create()
    {
        $abarangmasuk = Barang::all();
        return view('vbarangmasuk.create',compact('abarangmasuk'));
    }
    
    public function store(Request $request)
    {
        $this->validate($request, [
            'tgl_masuk'     => 'required',
            'qty_masuk'     => 'required',
            'barang_id'     => 'required',
        ]);
        //create post
        BarangMasuk::create([
            'tgl_masuk'        => $request->tgl_masuk,
            'qty_masuk'        => $request->qty_masuk,
            'barang_id'        => $request->barang_id,
        ]);


        return redirect()->route('vbarangmasuk.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    public function show($id)
    {
        $barangMasuk = BarangMasuk::findOrFail($id);
        return view('vbarangmasuk.show', compact('barangMasuk'));
    }

    public function edit($id)
    {
        $barangMasuk = BarangMasuk::findOrFail($id);
        $abarangmasuk = Barang::all();

        return view('vbarangmasuk.edit', compact('barangMasuk', 'abarangmasuk'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'tgl_masuk' => 'required',
            'qty_masuk' => 'required',
            'barang_id' => 'required',
        ]);

        $barangMasuk = BarangMasuk::findOrFail($id);

        $barangMasuk->update([
            'tgl_masuk' => $request->tgl_masuk,
            'qty_masuk' => $request->qty_masuk,
            'barang_id' => $request->barang_id,
        ]);

        return redirect()->route('vbarangmasuk.index')->with(['success' => 'Data Berhasil Diubah!']);
    }

    public function destroy($id)
    {
        $barangMasuk = BarangMasuk::findOrFail($id);
        $barangMasuk->delete();

        return redirect()->route('vbarangmasuk.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }

}
