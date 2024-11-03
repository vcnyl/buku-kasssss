<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    function index(){
        echo "haloo,selamat datang";
        echo "<h1>". Auth::user()->nama ."</h1>";
        echo "<a href='/logout'>Logout >></a>";
    }

    function admin(){
        echo "haloo,selamat datang admin";
        echo "<h1>". Auth::user()->nama ."</h1>";
        echo "<a href='/logout'>Logout >></a>";
    }

    function superadmin(){
        echo "haloo,selamat datang superadmin";
        echo "<h1>". Auth::user()->nama ."</h1>";
        echo "<a href='/logout'>Logout >></a>";
    }
}
