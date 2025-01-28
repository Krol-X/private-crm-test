<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class RationsController extends Controller
{
    function index(Request $request)
    {
        return Response::json();
    }

    function show(Request $request)
    {
        return Response::json();
    }
}
