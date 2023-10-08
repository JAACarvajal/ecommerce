<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Auth\UserService;

class UserController extends Controller
{
    /**
     * Constructor
     * 
     * @param UserService
     */
    public function __construct(
        protected UserService $userService
    ) {}

    /**
     * Handle an incoming registration request
     *
     * @param Request
     */
    public function register(Request $request): Response
    {
        $this->userService->store($request);
    }
}
