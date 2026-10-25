<?php

namespace App\Http\Controllers;

use App\Models\PushSubscription;
use App\Services\PwaService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class PwaController extends Controller
{
    protected $pwaService;

    public function __construct(PwaService $pwaService)
    {
        $this->pwaService = $pwaService;
    }

    /**
     * Dynamic Web App Manifest
     */
    public function manifest(): JsonResponse
    {
        $manifest = $this->pwaService->getManifest();

        return response()->json($manifest)
            ->header('Content-Type', 'application/manifest+json; charset=utf-8')
            ->header('Cache-Control', 'public, max-age=3600');
    }

    /**
     * Branded Offline Fallback View
     */
    public function offline()
    {
        return response()
            ->view('pages.pwa.offline', [
                'systemName' => config('app.name', 'School Management System'),
            ])
            ->header('Cache-Control', 'public, max-age=86400');
    }

    /**
     * Serve Service Worker with proper headers
     */
    public function serviceWorker(): Response
    {
        $swPath = public_path('sw.js');
        if (!file_exists($swPath)) {
            abort(404, 'Service worker script not found');
        }

        $content = file_get_contents($swPath);

        return response($content, 200)
            ->header('Content-Type', 'application/javascript; charset=utf-8')
            ->header('Service-Worker-Allowed', '/')
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate');
    }

    /**
     * Save web push subscription
     */
    public function subscribe(Request $request): JsonResponse
    {
        $request->validate([
            'endpoint' => 'required|url',
            'keys' => 'nullable|array',
            'keys.p256dh' => 'nullable|string',
            'keys.auth' => 'nullable|string',
        ]);

        $sub = PushSubscription::storeSubscription(Auth::id(), $request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Push subscription registered successfully',
            'id' => $sub->id,
        ]);
    }

    /**
     * Unsubscribe from web push
     */
    public function unsubscribe(Request $request): JsonResponse
    {
        $request->validate([
            'endpoint' => 'required|url',
        ]);

        $hash = hash('sha256', $request->endpoint);
        PushSubscription::where('user_id', Auth::id())
            ->where('endpoint_hash', $hash)
            ->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Push subscription removed successfully',
        ]);
    }
}
