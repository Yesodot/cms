<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserEditRequest;
use App\Http\Requests\UsersRequest;
use App\User;
use App\Role;
use App\Photo;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;

class AdminUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $roles = Role::lists('name', 'id')->all();

        return view('admin.users.create', compact('roles'));


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UsersRequest $request)
    {

// Option to create it on field level rather than using the all() method
//        User::create([
//            'name' => $request->get('name'),
//            'email' => $request->get('email'),
//            'role_id' => $request->get('role_id'),
//            'is_active' => $request->get('is_active'),
//            'photo_id' => $request->get('photo_id'),
//            'password' => bcrypt($request->get('password'))
//        ]);


        $input = $request->all();

        if($file = $request->file('photo_id')){
            $name = time() . $file->getClientOriginalName();

            $file->move('images', $name);

            $photo = Photo::create(['file' => $name]);

            $input['photo_id'] = $photo->id;

        }

        $input['password'] = bcrypt($request->password);

        User::create($input);

        return redirect('admin/users');

//        if($request->file('photo_id')){
//            return "nissan";
//        }

        //User::create($request->all());



//        return $request->all();


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
        //Find the user
        $user = User::findOrFail($id);

        $roles = Role::lists('name', 'id')->all();

        return view('admin.users.edit', compact('user', 'roles'));




    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserEditRequest $request, $id)
    {
        //find the user
        $user = User::findOrFail($id);

        if(trim($request->password) == ''){
            $input = $request->except('password');
        }else{
            $input = $request->all();
            $input['password'] = bcrypt($request->password);
        }


        if($file = $request->file('photo_id')){

            $name = time() . $file->getClientOriginalName();

            $file->move('images', $name);

            $photo = Photo::create(['file' => $name]);

            $input['photo_id'] = $photo->id;


        }

        //$input['password'] = bcrypt($request->password);

        $user->update($input);

        return redirect('admin/users');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $user = User::findOrFail($id);

        if($user['photo_id']){
            unlink('C:\xampp\htdocs\/'. $user->photo->file);
        }

        $user->delete();
        Session::flash('deleted_user', 'The user has been deleted');
        return redirect('/admin/users');




        //        $user = User::findOrFail($id);
//
//        // Find the photo name of the poto table using the photo_id from the user table
//        $photo_id = $user->photo_id;
//        $photo_name = Photo::findOrFail($photo_id);
//        echo $photo_name->file;
//        dd($photo_name);



//        $image = $user->photo->file;
//        $base_path = 'C:\xampp\htdocs\codehacking\public\images\\' . $image;
//        echo $base_path;
////        $path = realpath($base_path);

        //      dd($path);

//        unlink('C:\xampp\htdocs\codehacking\public\images\1473309473Fotolia_51282384_M.jpg');
//
//        $user->delete();
//
//        Session::flash('deleted_user', 'The user has been deleted');
//
//        return redirect('/admin/users');







    }
}
