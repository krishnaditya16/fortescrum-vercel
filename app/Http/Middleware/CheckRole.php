<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;
use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, string $role)
    {
        $user = Auth::user();
        $current_team = $user->currentTeam;
        
        if($role == 'guest' && $user->hasTeamRole($current_team, 'guest')) {
            return $next($request);
        }

        if ($role == 'project-manager' && $user->hasTeamRole($current_team, 'project-manager') || $user->ownsTeam($current_team)) {
            return $next($request);
        }

        if ($role == 'team-member' && $user->hasTeamRole($current_team, 'team-member')) {
            return $next($request);
        }

        if ($role == 'client-user' && $user->hasTeamRole($current_team, 'client-user')) {
            return $next($request);
        }
        abort(403);
    }
}
