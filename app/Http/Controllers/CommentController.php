<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\Rental;
use App\Http\Requests\CommentRequest;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Post $post, Rental $rental)
    {
        return view('comments.create', compact('post','rental'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\CommentRequest  $request
     * @param  \App\Models\Post  $post
     * @param  \App\Models\Rental  $rental
     * @return \Illuminate\Http\Response
     */
    public function store(CommentRequest $request, Post $post, Rental $rental)
    {
        $comment = new Comment($request->all());
        $comment->user_id = $request->user()->id;

        // トランザクション開始
        DB::beginTransaction();
        try {
            // 登録
            $post->comments()->save($comment);
            $rental->comments()->save($comment);

            // トランザクション終了(成功)
            DB::commit();
        } catch (\Exception $e) {
            // トランザクション終了(失敗)
            DB::rollback();
            return back()->withInput()->withErrors($e->getMessage());
        }

        return redirect()
            ->route('posts.show', $post)
            ->route('rentals.show', $rental)
            ->with('notice', 'コメントを登録しました');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.

     * @param  \App\Models\Post  $post
     * @param  \App\Models\Rental  $rental
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post, Rental $rental, Comment $comment)
    {
        return view('comments.edit', compact('post','rental','comment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\CommentRequest  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(CommentRequest $request, Post $post, Rental $rental, Comment $comment)
    {

        if ($request->user()->cannot('update', $comment)) {
            return redirect()
            ->route('posts.show', $post)
            ->route('rentals.show', $rental)
                ->withErrors('自分のコメント以外は更新できません');
        }

        $comment ->fill($request->all());

        // トランザクション開始
        DB::beginTransaction();
        try {
            // 登録
            $post->comments()->save($comment);
            $rental->comments()->save($comment);

            // トランザクション終了(成功)
            DB::commit();
        } catch (\Exception $e) {
            // トランザクション終了(失敗)
            DB::rollback();
            return back()->withInput()->withErrors($e->getMessage());
        }

        return redirect()
            ->route('posts.show', $post)
            ->route('rentals.show', $rental)
            ->with('notice', 'コメントを更新しました');

            
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @param  \App\Models\Rental  $rental
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post, Rental $rental, Comment $comment)
    {
        //if ($request->user()->cannot('destroy', $comment)) {
        //    return redirect()->route('posts.show', $post)
        //        ->withErrors('自分のコメント以外は削除できません');
        //}

        // トランザクション開始
        //DB::beginTransaction();
        try {
            $comment->delete();

            // トランザクション終了(成功)
            //DB::commit();
        } catch (\Exception $e) {
            // トランザクション終了(失敗)
            //DB::rollback();
            return back()->withInput()->withErrors($e->getMessage());
        }

        return redirect()
        ->route('posts.show',$post)
        ->route('rentals.show',$rental)
            ->with('notice', 'コメントを削除しました');
    }

    private static function createFileName($file)
    {
        return date('YmdHis') . '_' . $file->getClientOriginalName();
    }
}
