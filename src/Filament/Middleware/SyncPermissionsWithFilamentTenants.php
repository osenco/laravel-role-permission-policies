<?php

namespace Osen\Permission\Filament\Middleware;

use Closure;
use Filament\Facades\Filament;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SyncPermissionsWithFilamentTenants
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $filament = Filament::getTenant()->id;
        $osen = getPermissionsTeamId();
        if ($filament !== $osen) {
            setPermissionsTeamId($filament);
        }

        return $next($request);
    }
}
