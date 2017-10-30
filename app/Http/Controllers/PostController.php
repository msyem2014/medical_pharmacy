<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Special;
use JWTAuth;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $posts = Post::with(['owner' => function($query){
         $query->select(['name','image','id','special_id']);
      },'special','owner.special','comments','comments.owner','favourites'])->orderBy('created_at','desc')->paginate(20);
      return response($posts, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $specials = Special::all();
      return response($specials, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $user = JWTAuth::parseToken()->authenticate();
        $post = Post::add($request,$user);
        $post = Post::where('id','=',$post->id)->with(['owner' => function($query){
            $query->select(['name','image','id','special_id']);
        },'special','owner.special','comments','comments.owner','favourites'])->get();
        return response($post, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $post = Post::join('users', 'posts.user_id', 'users.id')->where('posts.id', $id)->first();
      return response($post, 202);
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
      return response($post, 202);
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
//      $this->validate($request, [
//        'special_id' => 'required',
//        'title' => 'required',
//        'body' => 'required',
//      ]);
        $user = JWTAuth::parseToken()->authenticate();
        $post = Post::edit($request, $id,$user);
        return response($post, 205);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $post = Post::findOrFail($id);
      $post->delete();
      return response($post, 204);
    }
}
