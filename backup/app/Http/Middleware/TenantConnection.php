<?php

namespace App\Http\Middleware;

use App\Models\Workspace;
use Closure;

class TenantConnection
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $prefix = $request->route('prefix');
        $workspace = null;
        if ($prefix) {
            $workspace = Workspace::where('prefix', $prefix)->first();
            if ($workspace) {
                \Tenant::setTenant($workspace);
            }
        }
        if(\Tenant::isTenantRequest() && !$workspace){
            abort(403, 'Tenant not found');
        }
        return $next($request);
    }
}
