<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Setting;
use App\Models\Tax;
use App\Models\User;
use App\RolesEnum;
use App\SettingsEnum;
use App\StatusEnum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class TaxController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Project $project)
    {
        $user = User::find(Auth::id());
        $taxes = $user->hasRole(RolesEnum::SUPER_ADMIN)
            ? $project->taxes()->withTrashed()->orderBy('priority')->paginate(10)
            : $project->taxes()->orderBy('priority')->paginate(10);

        $defaultTax = Setting::getValueByKey(SettingsEnum::EC_TAX_DEFAULT->value, $project->id);
        $displayPriceWithTax = Setting::getValueByKey(SettingsEnum::EC_PRICE_INCLUDING_TAX->value, $project->id);

        return view('projects.taxes.index', compact('project', 'taxes', 'defaultTax', 'displayPriceWithTax'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Project $project)
    {
        return view('projects.taxes.create', compact('project'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Project $project)
    {
        $validated = $request->validate([
            'title' => [
                'required',
                'string',
                'max:150',
                Rule::unique('taxes')->where(
                    fn($q) =>
                    $q->where('project_id', $project->id)
                )
            ],
            'percentage' => 'required|decimal:0,2|gte:0|lt:100,',
            'priority' => 'required|integer|gt:0|lt:100',
            'status' => 'required|boolean',
            'description' => 'nullable|string|max:250',
        ]);

        $project->taxes()->create($validated);
        return redirect()->route('projects.taxes.index', $project)
            ->with('success', 'Tax of project created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project, Tax $tax)
    {
        return view('projects.taxes.edit', compact('project', 'tax'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project, Tax $tax)
    {
        $validated = $request->validate([
            'title' => [
                'required',
                'string',
                'max:150',
                Rule::unique('taxes')
                    ->where(fn($q) => $q->where('project_id', $project->id))
                    ->ignore($tax->id, 'id'),
            ],
            'percentage' => 'required|decimal:0,2|gte:0|lt:100,',
            'priority' => 'required|integer|gt:0|lt:100',
            'status' => 'required|boolean',
            'description' => 'nullable|string|max:250',
        ]);

        $tax->update($validated);

        // remove if is default tax
        if (
            $tax->status !== StatusEnum::ACTIVE->value
            && $tax->id == Setting::getValueByKey(SettingsEnum::EC_TAX_DEFAULT->value, $project->id)
        ) {
            Setting::storeValue(SettingsEnum::EC_TAX_DEFAULT->value, '', $project->id);
        }

        return redirect()->back()
            ->with('success', 'Tax updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project, Tax $tax)
    {
        $tax->status = StatusEnum::DISABLE;
        $tax->save();
        $tax->delete();

        // remove if is default tax
        if ($tax->id == Setting::getValueByKey(SettingsEnum::EC_TAX_DEFAULT->value, $project->id)) {
            Setting::storeValue(SettingsEnum::EC_TAX_DEFAULT->value, '', $project->id);
        }

        return redirect()->route('projects.taxes.index', $project->id)
            ->with('success', 'Tax deleted successfully.');
    }

    public function restore(string $id)
    {
        $tax = Tax::onlyTrashed()->findOrFail($id);
        $tax->restore();
        

        return redirect()->route('projects.taxes.index', $tax->project_id)
            ->with('success', 'Tax restored successfully.');
    }

    public function settings(Request $request, string $id)
    {
        $request->validate([
            'default_tax' => 'nullable|exists:taxes,id',
            'display_price_with_tax' => 'nullable|boolean',
        ]);

        Setting::storeValue(SettingsEnum::EC_TAX_DEFAULT->value, $request->has('default_tax') ? $request->get('default_tax') : '', $id);
        Setting::storeValue(SettingsEnum::EC_PRICE_INCLUDING_TAX->value, $request->has('display_price_with_tax') ? '1' : '', $id);

        return redirect()->back()
            ->with('success', 'Tax settings updated successfully.');
    }
}
