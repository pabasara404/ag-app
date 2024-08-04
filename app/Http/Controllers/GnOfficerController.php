<?php

namespace App\Http\Controllers;

use App\Http\Resources\GnOfficerResource;
use App\Mail\SetPasswordMail;
use App\Models\GnOfficer;
use App\Http\Requests\StoreGnOfficerRequest;
use App\Http\Requests\UpdateGnOfficerRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class GnOfficerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return GnOfficerResource::collection(
            GnOfficer::with("user")->get()

        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreGnOfficerRequest  $request
     * @return Response
     */
    public function store(StoreGnOfficerRequest $request)
    {
        $userData = [
            'name' => $request->input('user.name'),
            'email' => $request->input('user.email'),
            'password' => Hash::make(Str::random(8)), // Random password for now
            'role_id' => $request->input('user.role_id'),
        ];
        $user = User::create($userData);

        $gnOfficerData = $request->except('user'); // Exclude the nested user array
        $gnOfficerData['user_id'] = $user->id; // Associate user with gnOfficer

        // Ensure that gnOfficerData includes all necessary fields
        $gnOfficer = GnOfficer::create($gnOfficerData);

        // Generate a password reset token and store it in the password resets table
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
     * @param GnOfficer $gnOfficer
     * @return Response
     */
    public function show(GnOfficer $gnOfficer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param GnOfficer $gnOfficer
     * @return Response
     */
    public function edit(GnOfficer $gnOfficer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateGnOfficerRequest $request
     * @param GnOfficer $gnOfficer
     * @return Response
     */
    public function update(UpdateGnOfficerRequest $request, GnOfficer $gnOfficer)
    {
        //
        $gnOfficer->update($request->toArray());
        return response()->noContent();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param GnOfficer $gnOfficer
     * @return Response
     */
    public function destroy(GnOfficer $gnOfficer)
    {
        // Get the user associated with the gnOfficer
        $user = $gnOfficer->user;

        // Delete the gnOfficer
        $gnOfficer->delete();

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
}
