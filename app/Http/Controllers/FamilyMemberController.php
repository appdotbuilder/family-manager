<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFamilyMemberRequest;
use App\Http\Requests\UpdateFamilyMemberRequest;
use App\Models\Family;
use App\Models\FamilyMember;
use Inertia\Inertia;

class FamilyMemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Family $family)
    {
        // Check if user has access
        if (!$family->hasUserAccess(auth()->user())) {
            abort(403);
        }

        $members = $family->members()
            ->with(['medicalConditions' => function ($query) {
                $query->active();
            }, 'medications' => function ($query) {
                $query->active();
            }])
            ->get();

        $userRole = $family->getUserRole(auth()->user());

        return Inertia::render('family-members/index', [
            'family' => $family,
            'members' => $members,
            'userRole' => $userRole,
            'canEdit' => in_array($userRole, ['owner', 'admin', 'editor'])
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Family $family)
    {
        // Check if user can edit
        $userRole = $family->getUserRole(auth()->user());
        if (!in_array($userRole, ['owner', 'admin', 'editor'])) {
            abort(403);
        }

        return Inertia::render('family-members/create', [
            'family' => $family
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFamilyMemberRequest $request, Family $family)
    {
        // Check if user can edit
        $userRole = $family->getUserRole(auth()->user());
        if (!in_array($userRole, ['owner', 'admin', 'editor'])) {
            abort(403);
        }

        $member = $family->members()->create($request->validated());

        return redirect()->route('family-members.show', [$family, $member])
            ->with('success', 'Family member added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Family $family, FamilyMember $familyMember)
    {
        // Check if user has access
        if (!$family->hasUserAccess(auth()->user())) {
            abort(403);
        }

        $familyMember->load([
            'medicalConditions' => function ($query) {
                $query->active();
            },
            'medications' => function ($query) {
                $query->active();
            }
        ]);

        $userRole = $family->getUserRole(auth()->user());

        return Inertia::render('family-members/show', [
            'family' => $family,
            'member' => $familyMember,
            'userRole' => $userRole,
            'canEdit' => in_array($userRole, ['owner', 'admin', 'editor']),
            'canViewMedical' => in_array($userRole, ['owner', 'admin', 'editor'])
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Family $family, FamilyMember $familyMember)
    {
        // Check if user can edit
        $userRole = $family->getUserRole(auth()->user());
        if (!in_array($userRole, ['owner', 'admin', 'editor'])) {
            abort(403);
        }

        return Inertia::render('family-members/edit', [
            'family' => $family,
            'member' => $familyMember
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFamilyMemberRequest $request, Family $family, FamilyMember $familyMember)
    {
        // Check if user can edit
        $userRole = $family->getUserRole(auth()->user());
        if (!in_array($userRole, ['owner', 'admin', 'editor'])) {
            abort(403);
        }

        $familyMember->update($request->validated());

        return redirect()->route('family-members.show', [$family, $familyMember])
            ->with('success', 'Family member updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Family $family, FamilyMember $familyMember)
    {
        // Check if user can edit
        $userRole = $family->getUserRole(auth()->user());
        if (!in_array($userRole, ['owner', 'admin', 'editor'])) {
            abort(403);
        }

        $familyMember->delete();

        return redirect()->route('family-members.index', $family)
            ->with('success', 'Family member deleted successfully.');
    }
}