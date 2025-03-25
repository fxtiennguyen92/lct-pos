<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index(string $projectCode) {
        $project = Project::getByCode($projectCode);

        return view('business.schedule');
    }
}
