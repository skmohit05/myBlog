<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Tag;
use Session;
use App\Category;
use Purifier;
use Image;

class PostController extends Controller
{


   public function __construct(){
$this->middleware('auth');
   }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // create a variable  and store all the blog posts in it from hte database
        $posts = Post::orderBy('id', 'desc')->paginate(10);  //orderBy for reversing

        //return a view
        return view('posts.index')->withPosts($posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       $categories = Category::all();
       $tags = Tag::all();
       return view('posts.create')->withCategories($categories)->withTags($tags);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validate the data
        $this->validate($request, array(
          'title' => 'required|max:255',
          'slug'  => 'required|alpha_dash|min:5|max:255|unique:posts,slug',
          'category_id' => 'required|integer',
          'body'  => 'required',
          'featured_image' => 'sometimes|image'      //sometimes: only validate it when something i
      ));

        //store in the database
        $post = new Post;
        $post->title = $request->title;
        $post->slug = $request->slug;
        $post->category_id = $request->category_id;
        $post->body = Purifier::clean($request->body);

        if($request->hasFile('featured_image')){
          $image = $request->file('featured_image');
          $filename = time().'.'.$image->getClientOriginalExtension();
          $location = public_path('images/'.$filename);
          Image::make($image)->resize(800, 400)->save($location);

          $post->image = $filename;
        }

        $post->save();

        $post->tags()->sync($request->tags, false);

        Session::flash('success', 'the blog post is successfully saved!');
        //redirect to another page
        return redirect()->route('posts.show', $post->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);    //Here Post is existing model
        return view('posts.show')->withPost($post); //show request in post controller
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // find the post in the database and save as variable
        $post = Post::find($id);
        $categories = Category::all();
        $tags = Tag::all();

        // return the view and pass in the variable we previously created
        return view('posts.edit')->withPost($post)->withCategories($categories)->withTags($tags);
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
        //validate the data
        // check whether the updated slug is same or different
        $post = Post::find($id);
        if($request->input('slug') == $post->slug){
            $this->validate($request, array(
            'title' => 'required|max:255',
            'body'  => 'required'));
        }
        else {
                $this->validate($request, array(
                'title' => 'required|max:255',
                'slug'  => 'required|alpha_dash|min:5|max:255|unique:posts,slug',
                'category_id' => 'required|integer',
                'body'  => 'required'
                ));
             }
        //save the data to datbase
        $post = Post::find($id);  // find the existing row of the existing post
        $post->title = $request->input('title');     // data coming from the changed form is coming through request
        $post->slug  = $request->input('slug');
        $post->category_id = $request->input('category_id');
        $post->body = Purifier::clean($request->input('body'));
        $post->save();

        if(isset($request->tags)){
          $post->tags()->sync($request->tags);
        }
        else {
          $post->tags()->sync(array());
        }
        //set flash data with success message
        Session::flash('success', 'This post was successfully saved.');

        //redirect with flash data to posts.show
        return redirect()->route('posts.show', $post->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        $post->tags()->detach();
        Storage::delete($post->image);
        $post->delete();
        Session::flash('success', 'the post was successfully deleted');
        return redirect()->route('posts.index');
    }
}
