<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\API\BaseController;
use Illuminate\Http\Request;

class OrderController extends BaseController
{
    public function index (Request $request) 
    {
        return $request->user();
    }
}
