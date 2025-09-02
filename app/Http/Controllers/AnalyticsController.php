<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Visit;

class AnalyticsController extends Controller
{
    // Untuk API tracking dari frontend (Next.js)
    public function store(Request $request)
    {
        \Log::info('Visit API request', [
            'url' => $request->url,
            'referrer' => $request->referrer,
            'user_agent' => $request->user_agent,
            'userAgent' => $request->userAgent,
            'ip_address' => $request->ip(),
            'all' => $request->all(),
        ]);

        try {
            $visit = Visit::create([
                'url' => $request->url,
                'referrer' => $request->referrer,
                'user_agent' => $request->user_agent ?? $request->userAgent,
                'ip_address' => $request->ip(),
            ]);
            \Log::info('Visit created', ['visit' => $visit]);
            return response()->json(['success' => true, 'message' => 'Logged', 'visit' => $visit]);
        } catch (\Exception $e) {
            \Log::error('Visit create error', ['error' => $e->getMessage()]);
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    // Untuk tampilkan dashboard ke admin
    public function dashboard()
    {
        $totalVisits = Visit::count();
        $mostVisitedPages = Visit::select('url')
            ->groupBy('url')
            ->orderByRaw('COUNT(*) DESC')
            ->limit(5)
            ->pluck('url');

        $visitsPerDay = Visit::selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->limit(7)
            ->get();

        return view('admin.dashboard', compact('totalVisits', 'mostVisitedPages', 'visitsPerDay'));
    }

    // API: Get semua visits (untuk dashboard)
    public function getVisits()
    {
        try {
            $visits = Visit::latest()->paginate(50);
            
            return response()->json([
                'success' => true,
                'data' => $visits
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch visits',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // API: Get statistics untuk dashboard
    public function getStats()
    {
        try {
            $totalVisits = Visit::count();
            
            // Most visited pages
            $mostVisitedPages = Visit::selectRaw('url, COUNT(*) as count')
                ->groupBy('url')
                ->orderByRaw('COUNT(*) DESC')
                ->limit(10)
                ->get();
            
            // Visits per day (last 7 days)
            $visitsPerDay = Visit::selectRaw('DATE(created_at) as date, COUNT(*) as total')
                ->where('created_at', '>=', now()->subDays(7))
                ->groupBy('date')
                ->orderBy('date', 'desc')
                ->get();
            
            // Visits per hour (last 24 hours)
            $visitsPerHour = Visit::selectRaw('HOUR(created_at) as hour, COUNT(*) as total')
                ->where('created_at', '>=', now()->subDay())
                ->groupBy('hour')
                ->orderBy('hour')
                ->get();
            
            // Top referrers
            $topReferrers = Visit::selectRaw('referrer, COUNT(*) as count')
                ->whereNotNull('referrer')
                ->groupBy('referrer')
                ->orderByRaw('COUNT(*) DESC')
                ->limit(10)
                ->get();
            
            return response()->json([
                'success' => true,
                'data' => [
                    'total_visits' => $totalVisits,
                    'most_visited_pages' => $mostVisitedPages,
                    'visits_per_day' => $visitsPerDay,
                    'visits_per_hour' => $visitsPerHour,
                    'top_referrers' => $topReferrers,
                    'last_updated' => now()->toISOString()
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch analytics stats',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
