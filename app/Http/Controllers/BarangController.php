<?php
    
namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Barang;
use Spatie\Permission\Models\Permission;
use DB;
    
class BarangController extends Controller
{   
    /**
    * Show all Barang
    *
    * @return \Illuminate\Http\Response
    */
    public function index(Request $request)
    {
        $barang = Barang::paginate(5);
        return view('admin.barang.tambah',compact('barang'));
    }
    
    /**
    * Create a new Barang
    *
    * @return \Illuminate\Http\Response
    */
    public function create()
    {
        $permission = Permission::get();
        return view('admin.barang.create',compact('permission'));
    }
    
    /**
    * Store new Barang into database
    *
    * @param $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
        // dd($request->all());
        $this->validate($request, [
            'name' => 'required|unique:Barang,name',
            'permission' => 'required',
        ]);
    
        $barang = Barang::create(['name' => $request->input('name')]);
        $barang->syncPermissions($request->input('permission'));

        // logging
        $barang = new Barang();
        activity()
            ->withProperties(['name' => $request->name])
            ->causedBy(auth()->user())
            ->performedOn($Barang)
           ->log('You have created Barang');
    
        return redirect()->route('admin.Barang')
                        ->with('success','Barang created successfully');
    }
    
    /**
    * Edit a Barang
    *
    * @param $id
    * @return \Illuminate\Http\Response
    */
    public function edit($id)
    {
        $barang = Barang::find($id);
        $permission = Permission::get();
        $barangPermissions = DB::table("Barang_has_permissions")
        	->where("Barang_has_permissions.Barang_id",$id)
            ->pluck('Barang_has_permissions.permission_id','Barang_has_permissions.permission_id')
            ->all();

    
        return view('admin.Barang.edit',compact('Barang','permission','BarangPermissions'));
    }
    
    /**
    * Update Barang
    *
    * @param $request, $id
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'permission' => 'required',
        ]);
    
        $barang = Barang::find($id);
        $barang->name = $request->input('name');
        $barang->save();
    
        $barang->syncPermissions($request->input('permission'));
    

        // logging
        $barang = new Barang();
        activity()
            ->withProperties(['name' => $Barang->name])
            ->causedBy(auth()->user())
            ->performedOn($Barang)
           ->log('You have edited Barang');

        return redirect()->route('admin.Barang')
                        ->with('success','Barang updated successfully');
    }
    
    /**
    * Show all Barang
    *
    * @param $id
    * @return \Illuminate\Http\Response
    */
    public function destroy($id)
    {
        $barang = Barang::find($id);
        $barang_name = $Barang->name;

        $barang->delete();

        // logging
        $barang = new Barang();
        activity()
            ->withProperties(['name' => $Barang_name])
            ->causedBy(auth()->user())
            ->performedOn($Barang)
           ->log('You have deleted Barang');

        return redirect()->route('admin.Barang')
                        ->with('success','Barang deleted successfully');
    }
}