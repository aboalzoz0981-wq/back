<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddClientRequest;
use App\Models\renter;
use Illuminate\Http\Request;
use App\groupOfFunctions;
use App\Http\Resources\ApartmentResource;

class RenterController extends Controller
{
    use groupOfFunctions;
    public function store(AddClientRequest $request){
        
        $valideted = $request->validated();
        if($request->hasFile('personal_photo')){
            $path = $request->file('personal_photo')->store('personal photo','public');
            $valideted['personal_photo'] = $path;
        }
        if($request->hasFile('An_ID_photo')){
            $path = $request->file('An_ID_photo')->store('An ID photo','public');
            $valideted['An_ID_photo'] = $path;
        }
        $renter = renter::create($valideted);
        return response()->json($renter, 201);
    }
    public function ShowApartments(){
        $apartments = $this->showAllApartments();
        return ApartmentResource::collection($apartments);
    }

    public function loginForRenter(Request $request){
        return $this->login($request);
    }
    public function sign_upForRenter(Request $request){
        return $this->sign_up($request);
    }
    
}
