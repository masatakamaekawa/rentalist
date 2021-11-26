<?php

namespace App\Http\Controllers;

use App\Consts\UserConst;
use Illuminate\Http\Request;
use App\Http\Requests\RentalRequest;
use App\Models\Rental;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController;

class RentalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $title = $request->title;
        $category = $request->category;

        $params = $request->query();
        $rentals = Rental::search($params)->paginate(10);

        $rentals->appends(compact('title', 'category'));

        return view('rentals.index', compact('rentals'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('rentals.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\RentalRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RentalRequest $request)
    {
        $rental = new Rental($request->all());
        $rental->user_id = $request->user()->id;

        // トランザクション開始
        DB::beginTransaction();
        try {
            // 登録
            $rental->save();

            // トランザクション終了(成功)
            DB::commit();
        } catch (\Exception $e) {
            // トランザクション終了(失敗)
            DB::rollback();
            return back()->withInput()->withErrors($e->getMessage());
        }

        return redirect()
            ->route('rentals.show', $rental)
            ->with('notice', 'レンタルリストを登録しました');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Rental $rental)
    {
        $entry = '';
        $entries = [];

        $entries = $rental->entries()->get();

        // if (Auth::check() &&
        //     Auth::user()->id == $rental->user_id) {
        //     $entries = $rental->entries()->with('user')->get();
        // }

        $rental = Rental::with(['user'])->find($rental->id);

        $rentalcomments = $rental->rentalcomments()->latest()->get()->load(['user']);

        return view('rentals.show', compact('rental', 'rentalcomments', 'entry', 'entries'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $rental = Rental::find($id);

        return view('rentals.edit', compact('rental'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\RentalRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RentalRequest $request, $id)
    {
        $rental = Rental::find($id);

        if ($request->user()->cannot('update', $rental)) {
            return redirect()->route('rentals.show', $rental)
                ->withErrors('自分のリスト以外は更新できません');
        }

        $file = $request->file('image');
        if ($file) {
            $delete_file_path = $rental->image_url;
            $rental->image = date('YmdHis') . '_' . $file->getClientOriginalName();
        }
        $rental->fill($request->all());

        // トランザクション開始
        DB::beginTransaction();
        try {
            // 更新
            $rental->save();

            // トランザクション終了(成功)
            DB::commit();
        } catch (\Exception $e) {
            // トランザクション終了(失敗)
            DB::rollback();
            return back()->withInput()->withErrors($e->getMessage());
        }

        return redirect()->route('rentals.show', $rental)
            ->with('notice', 'レンタルリストを更新しました');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $rental = Rental::find($id);

        // トランザクション開始
        DB::beginTransaction();
        try {
            $rental->delete();

            // トランザクション終了(成功)
            DB::commit();
        } catch (\Exception $e) {
            // トランザクション終了(失敗)
            DB::rollback();
            return back()->withInput()->withErrors($e->getMessage());
        }

        return redirect()->route('rentals.index')
            ->with('notice', 'レンタルリストを削除しました');
    }

    private static function createFileName($file)
    {
        return date('YmdHis') . '_' . $file->getClientOriginalName();
    }
}
