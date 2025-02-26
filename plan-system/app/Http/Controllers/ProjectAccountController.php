<?php

namespace App\Http\Controllers;

use App\Models\InitPassword;
use App\Models\Project;
use App\Models\User;
use App\RolesEnum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProjectAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, string $projectCode)
    {
        $project = Project::getByCode($projectCode);
        $accounts = User::getByProject($project->code, $request->search ?? '');

        return view('business.accounts.index', compact('project', 'accounts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request, string $projectCode)
    {
        return view('business.accounts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, string $projectCode)
    {
        $project = Project::getByCode($projectCode);
        if (!$project) {
            return abort(404);
        }

        $request->validate([
            'email' => 'required|email|unique:users',
            'name' => 'required|string|max:150',
            'first_name' => 'nullable|string|max:200',
            'phone_number' => 'nullable|phone:FR,INTERNATIONAL',
            'role' => [
                'required',
                Rule::in(RolesEnum::values()),
            ],
        ]);

        $user = User::getByEmailOrPhone($request->email);
        if (!$user) {
            // Define and store init password of new account
            $initPassword = Str::random(10);
            InitPassword::create([
                'email' => $request->email,
                'password' => $initPassword,
            ]);

            // Create new account
            $user = User::create([
                'email' => $request->email,
                'password' => Hash::make($initPassword),
                'name' => $request->name,
                'first_name' => $request->first_name,
                'country_code' => 'FR',
                'phone_number' => $request->phone_number ? '0' . preg_replace('/^0/', '', $request->phone_number) : ''
            ]);
            // Assign role
            setPermissionsTeamId($project->id);
            $user->assignRole($request->role);
        }

        // Add account to project
        $user->projects()->syncWithoutDetaching($project->id);

        return redirect()->route('project-accounts.index', $projectCode);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $projectCode, User $projectAccount)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $projectCode, User $projectAccount)
    {
        $account = User::findUserWithProject($projectCode, $projectAccount->id);
        if (!$account) {
            return abort(404);
        }

        return view('business.accounts.edit', compact('account'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $projectCode, User $projectAccount)
    {
        $account = User::findUserWithProject($projectCode, $projectAccount->id);
        if (!$account) {
            return abort(404);
        }

        $request->validate([
            'email' => 'required|email|unique:users,email,'.$account->id,
            'name' => 'required|string|max:150',
            'first_name' => 'nullable|string|max:200',
            'phone_number' => 'nullable|phone:FR,INTERNATIONAL',
            'role' => [
                'required',
                Rule::in(RolesEnum::values()),
            ],
        ]);

        // Update
        $account->email = $request->email;
        $account->name = $request->name;
        $account->first_name = $request->first_name;
        $account->phone_number = $request->phone_number ? '0' . preg_replace('/^0/', '', $request->phone_number) : '';

        $account->active_flg = $request->has('status');

        // Assign role
        $account->syncRoles($request->role);

        $account->save();

        return back()->with('success', __('messages.update.success'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
