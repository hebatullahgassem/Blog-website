<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

use function Laravel\Prompts\alert;
use function Laravel\Prompts\confirm;

class PostController extends Controller
{
    public function index(){
        //instead of writing row sql queries we write 
        //select * from posts;
        $postsFormDB = Post::all(); //prints a collection object this object contain proberty called items 
        //items is also an object contains the 3 arrays which is the number of records in db
        //items is the app/models/post

        //pass variable to view
        return view('posts.index', ['posts' => $postsFormDB]);
    }

    public function create(){
        //select * from users;
        $users = User::all();
        return view('posts.create', ['users' => $users]);
    }

    public function store(){
        //to validate data
        //validation logic must be before storing data (Post::create)
        request()->validate([
            'title' => ['required', 'min:3'],
            'description' => ['required', 'min:5'],
            'postCreator' => ['required', 'exists:users,id'] //this to make sure this id is exists in users table
            //this will prevent user from manipulating frontend and change id of user in inspect
            //The selected post creator is invalid. 
        ]);
        //takes assosiative array/key and value pairs
        //this code redirects to same page route if there is empty fields
        //min validate the minimum number of digits //The title field must be at least 3 characters.

        //1- get user data
        //$data = $_POST; //this is the olt way in php
        //return $data; //{"_token":"gorGYrGf3aIQxca9RWA2oeshA9rS8sX8QnCJ4Sws"}
        //this happened because inputs doesn't have names
        //to collect data from inputs, these inputs must have name attributes
        //return $data; {"_token":"gorGYrGf3aIQxca9RWA2oeshA9rS8sX8QnCJ4Sws","title":"mikokv","description":"rgrg4","post_creator":"Hebatullah"}
        //this result after putting names on inputs
        ////////////////----------------------------///////////////////////////////////////
        //the new way to get user data
        //$request = request();
        //@dd($request->title, $request->all()); // request return an object that we can access proberties or methods from
        //all returns all sumbitted data but we can specify input name and return its value only
        //$data = request()->all();
        $title = request()->title;
        $description = request()->description;
        $postCreator = request()->postCreator;

        //2- store submitted data in database 
        //there is 2 ways to store data
        //   1) 
        // $post = new Post; //create new object from post model to store new post in it
        // $post->title = $title;
        // $post->description = $description;

        // $post->save(); //to execute query //insert into posts table

        //   2) recommended
        Post::create([
            'title' => $title,
            'description' => $description,
            'xyz' => 'some value', //ignore
            'user_id' => $postCreator
        ]);
        //this syntax causes some security issues so the solution for this issues is:
        //fillable proberty in Post model
        //framework ignores columns that is not in fillable property
        
        //3- redirection to posts.index
        return to_route('posts.index');
    }

    public function edit(Post $post){ ////to show privious content
        //to access users from database
        //select * from users;
        $users = User::all();

        return view('posts.edit', ['users' => $users, 'post' => $post]);
    }

    public function update($postId){
        //to validate data
        request()->validate([
            'title' => ['required', 'min:3'],
            'description' => ['required', 'min:5'],
            'postCreator' => ['required', 'exists:users,id']
        ]);

        //its quit similar to store action
        //1- get user data
        $title = request()->title;
        $description = request()->description;
        $postCreator = request()->postCreator;
        
        //2- update user data in database 
        //1) select or find post
        $singlePostFromDB = Post::find($postId);

        //2) update post data
        $singlePostFromDB->update([
            'title' => $title,
            'description' => $description,
            'user_id' => $postCreator
        ]);

        
        //3- redirection to posts.show 
        return to_route('posts.show', $postId); 
    }

    public function destroy($postId){
       //its quit similar to store action
        
       //1- delete post from database
       //the 2 queries used to delete single record that is unique (recommended) //can use model events
       //1) select or find post
       $singlePostFromDB = Post::find($postId);
       //2) delete post from database
       $singlePostFromDB->delete();

       //Post::where('id', $postId)->delete(); //used if we want to delete multiple records that aren't unique

       //2- redirection to posts.index
            return to_route('posts.index');
        
    }

    public function show(Post $post){ //type hinting: $post param is from type model class Post //take same dynamic parameter name in route url //and write before it the model class name
        //ways to get single model object:

        //select * from posts where id = $postId;

        // 1- recommended
        //$singlePostFromDB = Post::find($postId); //model object
        //used when using ID (unique value) 

        // 2-
        //$singlePostFromDB = Post::where('id', $postId)->first(); //eloquent builder
        //this way is like building a query but yet not executed
        //unlike all() and find() methods they executes imediatly
        //to make where execute we write: ->first()
        //used when using ID (unique value) //select * from posts where title = 'php' limit 1;

        // 3- 
        //$singlePostFromDB = Post::where('id', $postId)->get(); //retrive collection object
        //used when using anything but ID (not unique or multiple records  will be retrived)
        //select * from posts where title = 'php';

        //to avoid throwing an error when requesting nonexisting id their is 2 ways:
        // 1-
        // if(is_null($singlePostFromDB)){
        //     //redirect to home page
        //     return to_route('posts.index');
        // }

        // 2-
        //$singlePostFromDB = Post::findOrFail($postId); //if id is not existed it will return notfound

        return view('posts.show', ['post' => $post]);
    }
}
