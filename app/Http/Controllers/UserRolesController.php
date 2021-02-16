<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role as Role;

class UserRolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::all();
        
        $data = array(
            'roles' => $roles
        );
        
         return view('admin.roles.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         return view('roles.create');
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
            'name'=>'required'
        ]);

        $roles = new Role([
            'name' => $request->get('name')
        ]);
        $roles->save();
        return redirect('/admin/roles')->with('success', 'Role saved!');
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
        $roles = Role::find($id);
        
        
        
        $data = array(
            'roles' => $roles
        );
        return view('admin.roles.edit', $data);
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
            'name'=>'required'
        ]);
        
        $id = $request->get('id');
        $role = Role::find($id);
        $role->name =  $request->get('name');
        $role->save();

        return redirect('/admin/roles')->with('success', 'Role updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::find($id);
        $role->delete();

        return redirect('/admin/roles')->with('success', 'Role deleted!');
    }
}
