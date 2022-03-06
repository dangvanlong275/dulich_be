<?php

namespace App\Repositories;

use App\Repositories\Interfaces\AuthInterface;
use App\Traits\Helper;
use App\User;
use Illuminate\Support\Facades\DB;

class AuthRepo implements AuthInterface
{
    use Helper;

    protected $model;
    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function store($data)
    {
        DB::beginTransaction();
        try {
            $user = $this->model->create($data);
            $token = $user->createToken(config('app.name'))->accessToken;
            DB::commit();
            return $this->sendResponse(true, $token, 200, 'Success!');
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->invalidRequest($th->getMessage());
        }
    }

    public function update($id, $data)
    {
        DB::beginTransaction();
        try {
            $this->model->find($id)->update($data);
            DB::commit();
            return $this->sendResponse(true, 'Success!', 200, 'Success!');
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->invalidRequest($th->getMessage());
        }
    }
}
