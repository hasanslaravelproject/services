<?php
namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Package;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PackageCollection;

class UserPackagesController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, User $user)
    {
        $this->authorize('view', $user);

        $search = $request->get('search', '');

        $packages = $user
            ->packages()
            ->search($search)
            ->latest()
            ->paginate();

        return new PackageCollection($packages);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @param \App\Models\Package $package
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user, Package $package)
    {
        $this->authorize('update', $user);

        $user->packages()->syncWithoutDetaching([$package->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @param \App\Models\Package $package
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, User $user, Package $package)
    {
        $this->authorize('update', $user);

        $user->packages()->detach($package);

        return response()->noContent();
    }
}
