<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLevelRequest;
use App\Http\Requests\UpdateLevelRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\LevelResource;
use App\Models\Feature;
use App\Models\FeatureLevel;
use App\Models\Level;
use App\Models\LevelUser;
use Illuminate\Http\Request;

class LevelController extends Controller
{    
       
    public function index(){
        $levels = Level::all();
        return LevelResource::collection($levels);
    }

    public function show(Level $level){
        return LevelResource::make($level);
    }

    public function store(StoreLevelRequest $request){
        $request->validated($request->all());

        $level = Level::create($request->all());
        foreach ($request->feature_ids as $feature_id){
            FeatureLevel::create([
                'feature_id' =>  $feature_id,
                'level_id' => $level->id
            ]);
        }
        return LevelResource::make($level);
    }


    public function update(UpdateLevelRequest $request , Level $level){
        $level->update($request->all());
        return LevelResource::make($level);
    }

    public function destroy(Level $level){
        $level->delete();
        return response()->json(['message' => 'Level Has Been Deleted Successfully']);
    }
}
