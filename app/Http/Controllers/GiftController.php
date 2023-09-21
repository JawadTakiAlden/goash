<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGiftRequest;
use App\Http\Requests\UpdateGiftRequest;
use App\Http\Resources\GiftResource;
use App\Models\Gift;
use App\Models\GiftUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GiftController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(){
        $gifts = Gift::all();
        return GiftResource::collection($gifts);
    }

    // public function indexuser() {
    //     $gift = Gift::where(Auth::user()->id)
    // }

    public function show(Gift $gift){
        return GiftResource::make($gift);
    }

    public function store(StoreGiftRequest $request){
        $request->validated($request->all());
        $gift = Gift::create($request->all());

        // foreach($request->user_ids as $user_id) {
        //     GiftUser::create([
        //         'gift_id' => $gift->id,
        //         'user_id' => $user_id,
        //     ]);
        // }

        return GiftResource::make($gift);
    }

    public function update(UpdateGiftRequest $request , Gift $gift){
        $gift->update($request->all());
        return GiftResource::make($gift);
    }

    public function destroy(Gift $gift){
        $gift->delete();
        return response()->json(['message' => 'Gift Has Been Deleted Successfully']);
    }

    public function rateGift(Request $request, Gift $gift)
{
    $user = Auth::user();
    $rating = $request->input('rating');

    $userGift = new GiftUser();
    $userGift->user_id = $user->id;
    $userGift->gift_id = $gift->id;
    $userGift->rating = $rating;
    $userGift->save();

    return response()->json(['message' => 'Rating Successfully']);
}
}
