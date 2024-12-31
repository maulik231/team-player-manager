<?php

use App\Http\Controllers\TeamPlayerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/teams', [TeamPlayerController::class, 'getTeamAndPlayer']);
Route::post('/save-teams', [TeamPlayerController::class, 'saveTeams']);
