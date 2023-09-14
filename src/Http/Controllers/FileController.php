<?php

namespace Jiannius\Atom\Http\Controllers;

use App\Http\Controllers\Controller;

class FileController extends Controller
{
    public function get($ulid) : mixed
    {
        if (($file = model('file')->findUlidOrFail($ulid)) && $file->auth()) {
            return $file->response();
        }

        abort(401);
    }
}