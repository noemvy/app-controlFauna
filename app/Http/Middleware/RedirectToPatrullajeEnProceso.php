<?php

// namespace App\Http\Middleware;

// use Closure;
// use Illuminate\Http\Request;
// use Symfony\Component\HttpFoundation\Response;
// use App\Models\Patrullaje;
// use Illuminate\Support\Facades\Auth;

// class RedirectToPatrullajeEnProceso
// {
//     /**
//      * Handle an incoming request.
//      *
//      * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
//      */
//     public function handle(Request $request, Closure $next): Response
//     {

//         if (Auth::check()) {
//             $user = Auth::user();

//             $patrullaje = Patrullaje::where('user_id', $user->id)
//                 ->where('estado', 'en_proceso')
//                 ->first();

//             // Si hay un patrullaje pendiente y no estamos ya en la página de edición de ese mismo patrullaje
//             if (
//                 $patrullaje &&
//                 !$request->routeIs('filament.dashboard.resources.patrullajes.edit') &&
//                 !$request->routeIs('filament.dashboard.resources.patrullajes.update')
//             ) {
//                 return redirect()
//                     ->route('filament.dashboard.resources.patrullajes.edit', ['record' => $patrullaje->id])
//                     ->with('alerta_patrullaje', 'Tienes un patrullaje pendiente.');
//             }

//             // Si no hay patrullaje y está en dashboard o admin, lo mandamos a crear
//             if (
//                 !$patrullaje &&
//                 ($request->is('dashboard') || $request->routeIs('filament.dashboard.pages.dashboard'))
//             ) {
//                 return redirect()
//                     ->route('filament.dashboard.resources.patrullajes.create')
//                     ->with('alerta_patrullaje', 'No tienes patrullajes activos. Crea uno nuevo.');
//             }
//         }

//         return $next($request);
//     }
// }
