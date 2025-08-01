<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\StoreRoleRequest;
use App\Http\Resources\RoleResource;
use App\Models\Role;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Role::class);

        $perPage = $request->query('per_page', 10);

        return RoleResource::collection(Role::paginate($perPage));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoleRequest $request)
    {
        $this->authorize('create', Role::class);

        return new RoleResource(Role::create($request->validated()));
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        $this->authorize('view', $role);

        return new RoleResource($role);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreRoleRequest $request, Role $role)
    {
        $this->authorize('update', $role);

        $role->update($request->validated());

        return new RoleResource($role);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $this->authorize('delete', $role);

        $role->delete();

        return response()->json();
    }

    /**
     * Assign permissions to role.
     */
    public function assignPermissions(Request $request, Role $role)
    {
        $this->authorize('update', $role);

        $request->validate([
            'permissions' => [
                'required',
                'array',
                'exists:permissions,name',
            ],
        ]);

        foreach ($request->permissions as $permission) {
            $role->givePermissionTo($permission);
        }

        return new RoleResource($role);
    }

    /**
     * Revoke permissions from role.
     */
    public function revokePermissions(Request $request, Role $role)
    {
        $this->authorize('update', $role);

        $request->validate([
            'permissions' => [
                'required',
                'array',
                'exists:permissions,name',
            ],
        ]);

        foreach ($request->permissions as $permission) {
            $role->revokePermissionTo($permission);
        }

        return new RoleResource($role);
    }
}
