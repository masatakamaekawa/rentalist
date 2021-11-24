<?php

namespace App\Http\Controllers;

use App\Models\RentalComment;
use App\Models\Rental;
use Illuminate\Http\Request;
use App\Http\Requests\RentalCommentRequest;
use Illuminate\Support\Facades\DB;

class RentalCommentController extends Controller
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
    public function create(Rental $rental)
    {
    return view('rentalcomments.create', compact('rental'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\RentalCommentRequest  $request
     * @param  \App\Models\Rental  $rental
     * @return \Illuminate\Http\Response
     */
    public function store(RentalCommentRequest $request, Rental $rental)
    {
        $rentalcomment = new RentalComment($request->all());
        $rentalcomment->user_id = $request->user()->id;

        // トランザクション開始
        DB::beginTransaction();
        try {
            // 登録
            $rental->rentalcomments()->save($rentalcomment);

            // トランザクション終了(成功)
            DB::commit();
        } catch (\Exception $e) {
            // トランザクション終了(失敗)
            DB::rollback();
            return back()->withInput()->withErrors($e->getMessage());
        }

        return redirect()
            ->route('rentals.show', $rental)
            ->with('notice', 'コメントを登録しました');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RentalComment  $rentalComment
     * @return \Illuminate\Http\Response
     */
    public function show(RentalComment $rentalComment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Rental  $rental
     * @param  \App\Models\RentalComment  $rentalComment
     * @return \Illuminate\Http\Response
     */
    public function edit(Rental $rental, RentalComment $rentalcomment)
    {
        return view('rentalcomments.edit', compact('rental', 'rentalcomment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Models\Rental  $rental
     * @param  \App\Http\Requests\RentalCommentRequest  $request
     * @param  \App\Models\RentalComment  $rentalComment
     * @return \Illuminate\Http\Response
     */
    public function update(RentalCommentRequest $request, Rental $rental, RentalComment $rentalcomment)
    {
        if ($request->user()->cannot('update', $rentalcomment)) {
            return redirect()->route('rentals.show', $rental)
                ->withErrors('自分のコメント以外は更新できません');
        }

        $rentalcomment->fill($request->all());

        // トランザクション開始
        DB::beginTransaction();
        try {
            // 更新
            $rentalcomment->save();

            // トランザクション終了(成功)
            DB::commit();
        } catch (\Exception $e) {
            // トランザクション終了(失敗)
            DB::rollback();
            return back()->withInput()->withErrors($e->getMessage());
        }

        return redirect()->route('rentals.show', $rental)
            ->with('notice', 'コメントを更新しました');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Rental  $rental
     * @param  \App\Models\RentalComment  $rentalComment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rental $rental, RentalComment $rentalComment)
    {
        // トランザクション開始
        //DB::beginTransaction();
        try {
            $rentalComment->delete();

            // トランザクション終了(成功)
            //DB::commit();
        } catch (\Exception $e) {
            // トランザクション終了(失敗)
            //DB::rollback();
            return back()->withInput()->withErrors($e->getMessage());
        }

        return redirect()->route('rentals.show', $rental)
            ->with('notice', 'コメントを削除しました');
    }
}
