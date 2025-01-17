<?php

namespace App\Http\Controllers;

use App\Models\Kitchen;
use App\Models\UserKitchen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class KitchenController extends Controller
{
    // Other methods...

    /**
     * Display the dashboard with a list of kitchens.
     */
    public function dashboard()
    {
        $kitchens = Kitchen::all();
        return view('dashboard', compact('kitchens'));
    }

    public function show($id)
    {
        $kitchen = Kitchen::with('userKitchens')->findOrFail($id);
        
        return view('kitchen-details', compact('kitchen'));
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $faker = Faker::create();
        $kitchen = new Kitchen();
        $kitchen->name = $request->name;
        $kitchen->kitchen_code = strtoupper($faker->unique()->uuid); // Generate a unique kitchen code
        $kitchen->save();

        
        // the id of the user that made the kitchen gets created pivot table user_kitchen has owner
        $userKitchen = new UserKitchen();
        $userKitchen->user_id = $request->user()->id;
        $userKitchen->kitchen_id = $kitchen->id;
        $userKitchen->is_owner = true;
        $userKitchen->save();
        
        return view('partials.kitchen', compact('kitchen'));
    }

    public function joinKitchen(Request $request)
    {
        $request->validate([
            'kitchen_code' => 'required|string|max:255',
        ]);

        $kitchen = Kitchen::where('kitchen_code', $request->kitchen_code)->first();
        if (!$kitchen) {
            return response()->json(['message' => 'Kitchen not found'], 404);
        }

        $userKitchen = new UserKitchen();
        $userKitchen->user_id = $request->user()->id;
        $userKitchen->kitchen_id = $kitchen->id;
        $userKitchen->is_owner = false;
        $userKitchen->save();

        return view('partials.kitchen', compact('kitchen'));
    }
   
    // delete kitchen
    public function destroy($id, Request $request)
    {
        // only the owner of the kitchen can delete the kitchen (check the user_kitchen table)
        $userKitchen = UserKitchen::where('kitchen_id', $id)
            ->where('user_id', $request->user()->id)
            ->where('is_owner', true)
            ->first();

        if (!$userKitchen) {
            return response()->json(['message' => 'You are not the owner of this kitchen'], 403);
        }

        $kitchen = Kitchen::findOrFail($id);
        $kitchen->delete();
        
        // redirect to the dashboard
        return redirect()->route('dashboard');
    }

    
}
