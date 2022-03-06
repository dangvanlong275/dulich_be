<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Traits\Helper;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laravel\Socialite\Facades\Socialite;

class SocialController extends Controller
{
    use Helper;

    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider($driver)
    {
        return Socialite::driver($driver)->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback($driver)
    {
        try {
            $user = Socialite::driver($driver)->user();
        } catch (\Throwable $th) {
            return $this->invalidRequest($th->getMessage());
        }

        $userExists = User::where('email', $user->getEmail())->where('social_type', $driver)->first();

        if ($userExists) {
            $token = $userExists->createToken(config('app.name'))->accessToken();
        } else {
            DB::beginTransaction();
            try {
                $data['social_type'] = $driver;
                $data['social_id'] = $user->getId();
                $data['name'] = $user->getName();
                $data['email'] = $user->getEmail();
                $data['email_verified_at'] = now();
                $data['avatar'] = $user->getAvatar();
                $user = User::create($data);
                $token = $user->createToken(config('app.name'))->accessToken;
                DB::commit();
            } catch (\Throwable $th) {
                DB::rollBack();
                return $this->invalidRequest($th->getMessage());
            }

        }
        return $this->sendResponse(true, $token, 200, 'Success!');
    }
}
