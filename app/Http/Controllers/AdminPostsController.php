<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostsCreateRequest;
use App\Photo;
use App\Post;
use App\User;
use App\Category;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AdminPostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $posts = Post::all();


        return view('admin/posts/index', compact('posts'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $categories = Category::lists('name', 'id')->all();


        return view('admin/posts/create', compact('categories'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostsCreateRequest $request)
    {
        // Assign the request
        $input = $request->all();


        // Get the post owner
        $user = Auth::user();


        // Get the file.
        // Check it there is a file request
        if($file = $request->file('photo_id')){

            // Name the file with current time to make it unique
            $name = time() . $file->getClientOriginalName();

            // Move the file to the image directory
            $file->move('images', $name);

            // Create the file using the Photo modle class
            $photo = Photo::create(['file' => $name]);


            // Update the array
            $input['photo_id'] = $photo->id;

        }

        $user->posts()->create($input);


        return redirect('/admin/posts');
        //return $request->all();



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

        $post = Post::findOrFail($id);

        $categories = Category::lists('name', 'id')->all();

        return view('admin/posts/edit', compact('post', 'categories'));

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
        //get the request
        $input = $request->all();

        //Check if a photo was submitted
        if($file = $request->file['photo_id']){

            // Get file name
            $name = time() . $file->getClientOriginalName();

            // Move the file
            $file->move('images', $name);

            // Create the file
            $photo = Photo::create(['file' => $name]);

            // Update file name
            $input['photo_id'] = $photo->id;


        }

        Auth::user()->posts()->whereId($id)->first()->update($input);

        // return the view
        return redirect('/admin/posts');



    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Find the record in the database
        $post = Post::findOrFail($id);

        //dd($post);
        //Delete the associated image
        if($post['photo_id']){
            unlink('C:\xampp\htdocs\/'. $post->photo->file);
        }
        // Delete the post
        $post->delete();



        //Set flash data
        //Session::flash('deleted_post', 'The post was deleted successfully');


        //Return to a specific view
        return redirect('/admin/posts');

    }
}
