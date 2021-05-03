<?php

namespace App\Http\Controllers\Api;
// Support
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// Models
use App\Models\User;
// Storage
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

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
        $data = json_decode($request->data);
        // update user data
        $user->first_name = $data->first_name;
        $user->last_name = $data->last_name;
        $user->email = $data->email;

        // if ($request->hasFile('image')) {
        //     $image = $request->file('image');
        //     $file_name = time() . '_' . $image->getFilename() . '.' . $image->getClientOriginalExtension();

        //     Storage::disk('local')->put($file_name, File::get($image));

        //     $img = Image::make($image->getRealPath());
        //     $img->resize(120, 120, function ($constraint) {
        //         $constraint->aspectRatio();
        //     });
        //     $user->profile_photo_path = 
        // }
        if ($request->hasFile('image')) {
            //TODO: find and delete the existing file;

            $path = $request->file('image')->store('avatars', [
                'disk' => 'public'
            ]);
            $user->profile_photo_path = $path;
        }

        $user->save();
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
