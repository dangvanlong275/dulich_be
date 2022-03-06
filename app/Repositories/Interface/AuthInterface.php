<?php

namespace App\Repositories\Interfaces;

interface AuthInterface{
    function store($data);
    function update($id, $data);
}
