<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.roles.index',[
            'roles'=>Role::paginate()

        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.roles.create',[
            'role_permissions'=> [],

        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=> 'required',
            'permissions' =>'required|array',

        ]);
        $role = Role::forceCreate($request->only('name'));
        foreach($request->permissions as $permission){
            DB::table('roles_permissions')->insert([
                'role_id'=>$role->id,
                'permission'=> $permission,
            ]);
        }
        $message= sprintf('Product %s created',$role->name);
        return redirect()->route('admin.roles.index')
        ->with('success', $message);
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
        $role = Role::findOrFail($id);
        $role_permissions = DB::table('roles_permissions')
                            ->where('role_id',$role->id)
                            ->pluck('permission')->toArray();
        return view('admin.roles.edit',[
            'role role,
            'role_permissions'=> $role_permissions,

        ]);

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
        $role = Role::findOrFail($id);
        $request->validate([
            'name'=> 'required',
            'permissions' =>'required|array',

        ]);
        $role->update($request->only('name'));
        DB::table('roles_permissions')->where('role_id',$role->id)->delete();
       
        foreach($request->permissions as $permission){
            DB::table('roles_permissions')->insert([
                'role_id'=>$role->id,
                'permission'=> $permission,
            ]);
        }
        $message= sprintf('Product %s updated',$role->name);
        return redirect()->route('admin.roles.index')
        ->with('success', $message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role = delete();
        $message= sprintf('Product %s deleted',$role->name);
        return redirect()->route('admin.roles.index')
        ->with('success', $message);

    }
}
