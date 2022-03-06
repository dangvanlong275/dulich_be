<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserValidate;
use App\Repositories\Interfaces\AuthInterface;
use App\Traits\Helper;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use PHPUnit\TextUI\Help;

class AuthController extends Controller
{
    use Helper;

    protected $authRepo;

    public function __construct(AuthInterface $authInterface)
    {
        $this->authRepo = $authInterface;
    }

    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if(!$user || !Hash::check($request->password, $user->password))
            return $this->invalidRequest('Username or password is incorrect.');

        $token = $user->createToken(config('app.name'))->accessToken;

        return $this->sendResponse(true, $token, 200, 'Success!');
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return $this->sendResponse(true, 'Logout successfully!', 200, "Logout successfully!");
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'avatar' => 'mimetypes:image/jpeg,image/png',
            'email' => 'required|email|unique:users',
            'password' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails())
            return $this->invalidRequest($validator->errors()->first());

        $data = $request->all();
        if($request->hasFile('avatar')){
            $fileName = random_int(1,100).'_'.time().'_'.$request->avatar->getClientOriginalName();
            $path = $request->file('avatar')->storeAs(
                'uploads',$fileName, 'public'
            );
            $data['avatar'] = Storage::url($path);
        }
        $data['password'] = bcrypt($request->password);

        return $this->authRepo->store($data);
    }

    public function show(Request $request)
    {
        $user = $request->user();

        return $this->sendResponse(true, $user, 200, 'Success!');
    }

    public function update(Request $request)
    {
        $rules = [
            'name' => 'required',
            'avatar' => 'mimetypes:image/jpeg,image/png',
            'email' => 'required|email',
        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails())
            return $this->invalidRequest($validator->errors()->first());

        $userId = $request->user()->id;
        $checkExits = User::where('id', '<>', $userId)->where('email', $request->email)->exists();
        if($checkExits)
            return $this->invalidRequest('The email has already been taken.');

        $data = $request->all();

        if(isset($request->password))
            $data['password'] = bcrypt($request->password);

        if($request->hasFile('avatar')){
            $fileName =   random_int(1,100).'_'.time().'_'.$request->avatar->getClientOriginalName();
            $path = $request->file('avatar')->storeAs(
                'uploads',$fileName, 'public'
            );
            $data['avatar'] = Storage::url($path);
        }

        return $this->authRepo->update($userId, $data);

    }
}
