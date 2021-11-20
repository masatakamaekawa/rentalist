<?php

namespace App\Http\Controllers;

use App\Consts\UserConst;
use App\Models\Rental;
use App\Models\Entry;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Consts\EntryConst;

class EntryController extends Controller
{
    /**
    * Store a newly created resource in storage.
    *
    * @param  \App\Models\Rental  $rental
    * @return \Illuminate\Http\Response
    */
    public function store(Rental $rental)
    {
        $entry = new Entry([
            'rental_id' => $rental->id,
            'user_id' => Auth::user()->id,
        ]);
        try {
           // 登録
            $entry->save();
        } catch (\Exception $e) {
            return back()->withInput()
                ->withErrors('貸出希望でエラーが発生しました');
        }
        return redirect()
            ->route('rentals.show', $rental)
            ->with('notice', '貸出希望しました');
    }
    /**
    * Remove the specified resource from storage.
    *
    * @param  \App\Models\Rental  $rental
    * @param  \App\Models\Entry  $entry
    * @return \Illuminate\Http\Response
    */
    public function destroy(Rental $rental, Entry $entry)
    {
        $entry->delete();
        return redirect()->route('rentals.show', $rental)
            ->with('notice', '貸出希望を取り消しました');
    }

    /**
     *
     * @param  \App\Models\Rental  $rental
     * @param  \App\Models\Entry  $entry
     * @return \Illuminate\Http\Response
     */
    public function approval(Rental $rental, Entry $entry)
    {
        $entry->status = EntryConst::STATUS_APPROVAL;
        $entry->save();

        return redirect()->route('rentals.show', $rental)
            ->with('notice', 'エントリーを承認しました');
    }

    /**
     *
     * @param  \App\Models\Rental  $rental
     * @param  \App\Models\Entry  $entry
     * @return \Illuminate\Http\Response
     */
    public function reject(Rental $rental, Entry $entry)
    {
        $entry->status = EntryConst::STATUS_REJECT;
        $entry->save();

        return redirect()->route('rentals.show', $rental)
            ->with('notice', 'エントリーを却下しました');
    }
}
