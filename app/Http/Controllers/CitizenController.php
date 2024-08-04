<?php

namespace App\Http\Controllers;

use App\Actions\CitizenActions;
use App\Http\Resources\CitizenResource;
use App\Mail\SetPasswordMail;
use App\Models\Citizen;
use App\Http\Requests\StoreCitizenRequest;
use App\Http\Requests\UpdateCitizenRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class CitizenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return CitizenResource::collection(
            Citizen::with(["gn_division", "user"])->get()
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCitizenRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCitizenRequest $request)
    {
        $userData = [
            'name' => $request->input('user.name'),
            'email' => $request->input('user.email'),
            'password' => Hash::make(Str::random(8)), // Random password for now
            'role_id' => $request->input('user.role_id'),
        ];
        $user = User::create($userData);

        $citizenData = $request->except('user'); // Exclude the nested user array
        $citizenData['user_id'] = $user->id;

        $citizen = Citizen::create($citizenData);

        $token = Str::random(60);
        DB::table('password_reset_tokens')->insert([
            'email' => $user->email,
            'token' => Hash::make($token),
            'created_at' => now(),
        ]);

        // Send an email to the user with the password reset link
        Mail::to($user->email)->send(new SetPasswordMail($user, $token));

        return response()->noContent();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Citizen  $citizen
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request)
    {
        return response()->json(
            CitizenActions::getCitizenByUserId($request->user_id)
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Citizen  $citizen
     * @return \Illuminate\Http\Response
     */
    public function edit(Citizen $citizen)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCitizenRequest  $request
     * @param  \App\Models\Citizen  $citizen
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCitizenRequest $request, Citizen $citizen)
    {
        $citizen->update($request->toArray());
        return response()->noContent();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Citizen  $citizen
     * @return \Illuminate\Http\Response
     */
    public function destroy(Citizen $citizen)
    {
        $user = $citizen->user;

        // Delete the gnOfficer
        $citizen->delete();

        // If a user is associated, delete the user as well
        if ($user) {
            $user->delete();
        }

        return response()->noContent();
    }

    public function checkEmail(Request $request)
    {
        $email = $request->input('email');
        $exists = User::where('email', $email)->exists();

        return response()->json(['exists' => $exists]);
    }
    public function checkNic(Request $request)
    {
        $nic = $request->input('nic');
        $exists = Citizen::where('nic', $nic)->exists();

        return response()->json(['exists' => $exists]);
    }

}
