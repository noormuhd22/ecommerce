<?php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class NewController extends Controller
{
    public function index($id)
    {
     

      $post = post::where("id",$id) ->first();

      if(!$post){
        abort(404);
      }
//migrations
      $data =[
        "post" => $post
      ];
        return view('post.index',$data);
    }
}

?>