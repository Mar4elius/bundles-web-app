<?php

namespace App\Http\Controllers\Api;
// Support
use Exception;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\MustVerifyEmail;
// Models
use App\Models\User;
use App\Models\Province;
// Storage
use Illuminate\Support\Facades\Storage;
// Requests
use Illuminate\Http\Request;
use App\Http\Requests\Api\User\UpdateUserProfileRequest;

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
     * @param  \App\Http\Requests\Api\User\UpdateUserProfileRequest  $request
     * @param  \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserProfileRequest $request, User $user)
    {
        try {
            $data = $request->all();
            // update user data
            $user->first_name = $data['first_name'];
            $user->last_name = $data['last_name'];

            // because request is coming as form-data object it sees null as string
            $user->address = $data['address'] === 'null' ? null : $data['address'];
            $user->apartment = $data['apartment'] === 'null' ? null : $data['apartment'];
            $user->city = $data['city'] === 'null' ? null : $data['city'];
            if (isset($data['active_province_id'])) {
                $province = Province::find($data['active_province_id']);
                $user->province()->associate($province);
            }
            $user->postal_code = $data['postal_code'] === 'null' ? null : $data['postal_code'];
            $user->phone = $data['phone'] === 'null' ? null : $data['phone'];;

            if ($request->hasFile('image')) {
                if (Storage::disk('public')->exists($user->profile_photo_path)) {
                    Storage::disk('public')->delete($user->profile_photo_path);
                }

                $path = $request->file('image')->store('avatars', [
                    'disk' => 'public'
                ]);
                $user->profile_photo_path = $path;
            }

            // If user update current email we have to send verification email
            $is_email_changed = $data['email'] !== $user->email && $user instanceof MustVerifyEmail;
            if ($is_email_changed) {
                $user->forceFill([
                    'email' => $data['email'],
                    'email_verified_at' => null,
                ]);

                $user->sendEmailVerificationNotification();

                $user->save();
            } else {
                $user->email = $data['email'];
            }

            $user->save();
            // can not redirect user to verification page because I don't reload a page. Just updating data on the page
            // https://laracasts.com/discuss/channels/vue/redirect-after-ajax-post-request
            return response()->json([
                'user'              => $user,
                'is_email_changed'  => $is_email_changed,
                'message'           => $is_email_changed ? 'Profile information has been updated. Please, verify your new email.' : 'Profile information has been updated.'
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

    /**
     * Update the given verified user's profile information.
     *
     * @param  mixed  $user
     * @param  array  $input
     *
     * @return Illuminate\Routing\Redirector
     */
    protected function updateVerifiedUser($user, array $input)
    {
        $user->forceFill([
            'email' => $input['email'],
            'email_verified_at' => null,
        ])->save();

        $user->sendEmailVerificationNotification();
    }
}
