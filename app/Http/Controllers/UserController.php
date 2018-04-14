<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $user;

    public function __construct(User $user) {
        $this->user = $user;
    }
    
    public function index()
    {
        return $this->user
        ->with('timelogs')
        ->get();
    }

}
