<?php

namespace App\Http\Controllers\Api;
// Support
use Exception;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// Models
use App\Models\User;
// Storage
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        try {
            $data = json_decode($request->data);
            // update user data
            $user->first_name = $data->first_name;
            $user->last_name = $data->last_name;
            $user->email = $data->email;

            if ($request->hasFile('image')) {
                if (Storage::disk('public')->exists($user->profile_photo_path)) {
                    Storage::disk('public')->delete($user->profile_photo_path);
                }

                $path = $request->file('image')->store('avatars', [
                    'disk' => 'public'
                ]);
                $user->profile_photo_path = $path;
            }

            $user->save();
            return response()->json([
                'user'      => $user,
                'message'   => 'Profile information has been updated.'
            ]);
        } catch (Exception $e) {
            if (config('app.env') !== 'production') {
                return $e->getMessage();
            } else {
                Log::error($e->getMessage());
                return response()->json([
                    'error' => 'This request failed successfully in user update.'
                ]);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
