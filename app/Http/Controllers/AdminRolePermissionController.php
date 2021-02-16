<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Permission as Permission;

class AdminRolePermissionController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Permission::all();
        
        $data = array(
            'permissions' => $roles
        );
        
         return view('admin.permissions.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         return view('permissions.create');
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
            'name'=>'name',
            'slug'=>'slug'
        ]);

        $roles = new Permission([
            'name' => $request->get('name'),
            'slug' => $request->get('slug')
        ]);
        
        $roles->save();
        
        return redirect('/admin/permissions')->with('success', 'Permission Saved!');
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
        $roles = Permission::find($id);
        
        $data = array(
            'permissions' => $roles
        );
        return view('admin.permissions.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        
       $request->validate([
            'name'=>'required',
            'slug'=>'required'
        ]);
        
        $id = $request->get('id');
        $role = Permission::find($id);
        $role->name =  $request->get('name');
        $role->slug =  $request->get('slug');
        $role->save();

        return redirect('/admin/permissions')->with('success', 'Role updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Permission::find($id);
        $role->delete();

        return redirect('/admin/permissions')->with('success', 'Role deleted!');
    }
}
