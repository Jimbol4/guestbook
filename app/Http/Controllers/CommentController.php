<?php namespace App\Http\Controllers;


use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;

use App\Comment;

class CommentController extends BaseController {
    
    /**
     * Send back all comments as JSON
     * 
     * @return Response
     */
    public function index() {
        return response()->json(Comment::get());
    }
    
    /**
     * Store a newly created resource in storage
     * 
     * @param Request $request
     * @return Response
     */
    public function store(Request $request) {
        return response()->json(Comment::create($request->all()));
    }
    
    /**
     * Remove the specified resource from storage.
     * 
     * @param int $id
     * @return Response
     */
    public function destroy($id) {
        return response()->json(Comment::destroy($id));
    }
    
}