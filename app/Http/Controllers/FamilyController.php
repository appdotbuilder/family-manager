<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFamilyRequest;
use App\Http\Requests\UpdateFamilyRequest;
use App\Models\Family;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FamilyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $families = auth()->user()->families()
            ->with(['members', 'creator'])
            ->withCount('members')
            ->latest()
            ->get();

        return Inertia::render('families/index', [
            'families' => $families
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('families/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFamilyRequest $request)
    {
        $family = Family::create([
            'name' => $request->validated()['name'],
            'description' => $request->validated()['description'] ?? null,
            'created_by' => auth()->id(),
        ]);

        // Add the creator as owner
        $family->users()->attach(auth()->id(), [
            'role' => 'owner',
            'is_active' => true,
            'accepted_at' => now(),
        ]);

        return redirect()->route('families.show', $family)
            ->with('success', 'Family created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Family $family)
    {
        // Check if user has access
        if (!$family->hasUserAccess(auth()->user())) {
            abort(403);
        }

        $family->load([
            'members' => function ($query) {
                $query->with(['medicalConditions' => function ($q) {
                    $q->active();
                }, 'medications' => function ($q) {
                    $q->active();
                }]);
            },
            'users' => function ($query) {
                $query->wherePivot('is_active', true);
            }
        ]);

        $userRole = $family->getUserRole(auth()->user());

        return Inertia::render('families/show', [
            'family' => $family,
            'userRole' => $userRole,
            'canEdit' => in_array($userRole, ['owner', 'admin', 'editor'])
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Family $family)
    {
        // Check if user can edit
        $userRole = $family->getUserRole(auth()->user());
        if (!in_array($userRole, ['owner', 'admin'])) {
            abort(403);
        }

        return Inertia::render('families/edit', [
            'family' => $family
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFamilyRequest $request, Family $family)
    {
        // Check if user can edit
        $userRole = $family->getUserRole(auth()->user());
        if (!in_array($userRole, ['owner', 'admin'])) {
            abort(403);
        }

        $family->update($request->validated());

        return redirect()->route('families.show', $family)
            ->with('success', 'Family updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Family $family)
    {
        // Only owner can delete
        if ($family->getUserRole(auth()->user()) !== 'owner') {
            abort(403);
        }

        $family->delete();

        return redirect()->route('families.index')
            ->with('success', 'Family deleted successfully.');
    }
}