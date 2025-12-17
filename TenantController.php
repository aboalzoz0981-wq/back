<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddClientRequest;
use App\Models\tenant;
use Illuminate\Http\Request;
use App\groupOfFunctions;
use App\Http\Requests\ReserveRequest;
use App\Http\Requests\UpdateReservRequest;
use App\Http\Resources\ApartmentResource;
use App\Models\Apartment;
use App\Models\Reservation;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TenantController extends Controller
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
        $tenant = tenant::create($valideted);
        return response()->json($tenant, 201);
    }
    
    public function ShowApartments(){
        $apartments = $this->showAllApartments();
        return ApartmentResource::collection($apartments);
    }

     public function loginForTenant(Request $request){
        return $this->login($request);
    }
    public function sign_upForTenant(Request $request){
        return $this->sign_up($request);
    }


    ///////////////////////////////////////////////////////////////////
    public function AddToFavorite($ApartmentId){
        Apartment::findOrFail($ApartmentId);
        Auth::user()->favoriteApartments()->syncWithoutDetaching($ApartmentId);
        return response()->json(['massege'=>'Apartment Added to favorite'], 200);
    }
    public function RemoveFromFavorite($ApartmentId){
        Apartment::findOrFail($ApartmentId);
        Auth::user()->favoriteApartments()->detach($ApartmentId);
        return response()->json(['massege'=>'Apartment removed from favorite'], 200);
    }

    public function getApartmentsFavorite(){
        $tasksFavorite = Auth::user()->favoriteApartments;
        return response()->json($tasksFavorite, 200);
    }

    ////////////////////////////////////////////////////////////////////
    public function reserve(ReserveRequest $request,$ApartmentId){

            $validated = $request->validated();
        return DB::transaction(function () use ($validated, $ApartmentId) {

        $apartment = Apartment::where('id', $ApartmentId)
            ->lockForUpdate()
            ->firstOrFail();

            $overlapping = Reservation::where('apartment_id', $ApartmentId)
            ->whereIn('status', ['pending', 'approved'])
            ->where(function ($q) use ($validated) {
                $q->where('start_date', '<=', $validated['end_date'])
                  ->where('end_date', '>=', $validated['start_date']);
            })
            ->lockForUpdate()
            ->exists();

        if ($overlapping) {
            return response()->json([
                'message' => 'عذراً، يوجد حجز آخر ضمن نفس الفترة الزمنية.',
            ], 409);}

        else{
                Reservation::create([
                'tenant_id'    => Auth::user()->id,
                'apartment_id' => $ApartmentId,
                'start_date'   => $validated['start_date'],
                'end_date'     => $validated['end_date']
         ]);
            return response()->json('apartment reserved successfully', 200);
        }
        });
    }
  
/////////////////////////////////////////////////////////////////////////

    public function updateDateOfReservation(UpdateReservRequest $request,$Id){
            $validated = $request->validated();
            $user_id = Auth::user()->id;
            $reservation = Reservation::findOrFail($Id);
            if($reservation->tenant_id!=$user_id){
                return response()->json('unauthorizeddd', 401);
            }

           $overlapping = Reservation::where(function ($q) use ($validated) {
                $q->where('start_date', '<=', $validated['end_date'])
                  ->where('end_date', '>=', $validated['start_date']);
            })
            ->lockForUpdate()
            ->exists();

            if ($overlapping) {
            return response()->json([
                'message' => 'عذراً، يوجد حجز آخر ضمن نفس الفترة الزمنية..',
            ], 409);}

            else{
                $reservation->update($request->only(['start_date','end_date']));
            }
            return response()->json('reserve updated successfully', 200);
        }

    public function updateStatusOfReservation(Request $request,$Id){
        $validated = $request->validate([
            'status'=>'required|in:"pending","cancelled","approved"'
        ]);
        $user_id = Auth::user()->id;
        $reservation = Reservation::findOrFail($Id);
        if($reservation->tenant_id!=$user_id){
            return response()->json('unauthorizeddd', 401);
        }
        $reservation->update($request->only('status'));
        return response()->json('reserve updated successfully', 200);
    }

    ///////////////////////////////////////////////////////////////////

    public function showAllReservation(){
        $user_id = Auth::user()->id;
        $reservations = Reservation::where('tenant_id',$user_id)->get();
        return response()->json($reservations, 200);
    }

    ///////////////////////////////////////////////////////////////////
    public function showByAddress($Address){
        $apartments = Apartment::where('address',$Address)->get();
        return response()->json($apartments, 200);
    }
    public function showByPrice($Price){
        $apartments = Apartment::where('cost','<=',$Price)->get();
        return response()->json($apartments, 200);
    }
    public function showByDescription($description){
        $apartments = Apartment::where('description',$description)->get();
        return response()->json($apartments, 200);
    }
    ///////////////////////////////////////////////////////////////////
    }

