<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Http\Resources\EmployeeResource;
use App\Mail\SetPasswordMail;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Password;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        return EmployeeResource::collection(
            Employee::with("user")->get()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreEmployeeRequest $request
     * @return Response
     */
    public function store(StoreEmployeeRequest $request)
    {
        $userData = [
            'name' => $request->input('user.name'),
            'email' => $request->input('user.email'),
            'password' => Hash::make(Str::random(8)), // Random password for now
            'role_id' => $request->input('user.role_id'),
        ];
        $user = User::create($userData);

        $employeeData = $request->except('user'); // Exclude the nested user array
        $employeeData['user_id'] = $user->id; // Associate user with employee

        Employee::create($employeeData);

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
     * Send a password reset link to the user.
     *
     * @param \App\Models\User $user
     * @return void
     */
    protected function sendPasswordResetLink(User $user)
    {
        $token = Password::createToken($user);
        $user->sendPasswordResetNotification($token);
    }

    /**
     * Display the specified resource.
     *
     * @param Employee $employee
     * @return Response
     */
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateEmployeeRequest $request
     * @param Employee $employee
     * @return Response
     */
    public function update(UpdateEmployeeRequest $request, Employee $employee)
    {
        $employee->update($request->toArray());

        return response()->noContent();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Employee $employee
     * @return Response
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();

        return response()->noContent();
    }
}
