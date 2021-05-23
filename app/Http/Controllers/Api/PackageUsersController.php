<?php
namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Package;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserCollection;

class PackageUsersController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Package $package
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Package $package)
    {
        $this->authorize('view', $package);

        $search = $request->get('search', '');

        $users = $package
            ->users()
            ->search($search)
            ->latest()
            ->paginate();

        return new UserCollection($users);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Package $package
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Package $package, User $user)
    {
        $this->authorize('update', $package);

        $package->users()->syncWithoutDetaching([$user->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Package $package
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Package $package, User $user)
    {
        $this->authorize('update', $package);

        $package->users()->detach($user);

        return response()->noContent();
    }
}
