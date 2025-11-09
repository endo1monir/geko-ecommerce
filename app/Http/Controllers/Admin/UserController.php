<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\UserRepositoryInterface;
use Illuminate\Http\Request;


class UserController extends Controller
{
    //
    public function __construct(protected UserRepositoryInterface $userRepository)
    {
        
    }
    public function index(){
        $admins= $this->userRepository->getAdmins();
        return response()->json($admins);
    }
}
