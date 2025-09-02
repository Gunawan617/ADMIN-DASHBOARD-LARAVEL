@extends('admin.layout')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-8 mt-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-500">Admin Dashboard</h1>
            <p class="text-gray-600 mt-1">Selamat datang di panel admin</p>
        </div>
        <div class="text-sm text-gray-500">
            {{ date('l, d F Y') }}
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 shadow-lg rounded-xl border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Total Visits</p>
                    <p class="text-3xl font-bold text-gray-900">{{ number_format($totalVisits) }}</p>
                </div>
                <div class="p-3 bg-blue-100 rounded-full">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 shadow-lg rounded-xl border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Today Visits</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $visitsPerDay->where('date', date('Y-m-d'))->first()->total ?? 0 }}</p>
                </div>
                <div class="p-3 bg-green-100 rounded-full">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 shadow-lg rounded-xl border-l-4 border-purple-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Active Pages</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $mostVisitedPages->count() }}</p>
                </div>
                <div class="p-3 bg-purple-100 rounded-full">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 shadow-lg rounded-xl border-l-4 border-orange-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Avg Daily</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $visitsPerDay->count() > 0 ? round($visitsPerDay->avg('total'), 1) : 0 }}</p>
                </div>
                <div class="p-3 bg-orange-100 rounded-full">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts and Tables -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Visits Chart -->
        <div class="bg-white p-6 shadow-lg rounded-xl">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold text-gray-900">Visits Trend (7 Days)</h2>
                <div class="text-sm text-gray-500">
                    Last updated: {{ date('H:i') }}
                </div>
            </div>
            <div class="h-80">
                <canvas id="visitsChart"></canvas>
            </div>
        </div>

        <!-- Top Pages Table -->
        <div class="bg-white p-6 shadow-lg rounded-xl">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Top Visited Pages</h2>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left">Rank</th>
                            <th class="px-4 py-3 text-left">Page URL</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($mostVisitedPages as $index => $url)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 font-medium text-gray-900">
                                <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-blue-100 text-blue-600 text-xs font-bold">
                                    {{ $index + 1 }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-gray-900 truncate max-w-xs">
                                {{ $url }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2" class="px-4 py-8 text-center text-gray-500">
                                No visit data available yet
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Recent Visits Table -->
    <div class="bg-white p-6 shadow-lg rounded-xl">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold text-gray-900">Recent Visits</h2>
            <a href="#" class="text-sm text-blue-600 hover:text-blue-800">View All →</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left">Date</th>
                        <th class="px-4 py-3 text-left">Page</th>
                        <th class="px-4 py-3 text-left">IP Address</th>
                        <th class="px-4 py-3 text-left">User Agent</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @php
                        $recentVisits = \App\Models\Visit::latest()->limit(10)->get();
                    @endphp
                    @forelse($recentVisits as $visit)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 text-gray-900">
                            {{ $visit->created_at->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-4 py-3 text-gray-900 truncate max-w-xs">
                            {{ $visit->url }}
                        </td>
                        <td class="px-4 py-3 text-gray-500 text-xs">
                            {{ $visit->ip_address }}
                        </td>
                        <td class="px-4 py-3 text-gray-500 text-xs truncate max-w-xs">
                            {{ Str::limit($visit->user_agent, 50) }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-4 py-8 text-center text-gray-500">
                            No recent visits data available
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Visits Chart
    const ctx = document.getElementById('visitsChart');
    if (ctx) {
        const visitsData = @json($visitsPerDay->sortBy('date')->values());
        const labels = visitsData.map(item => {
            const date = new Date(item.date);
            return date.toLocaleDateString('id-ID', { month: 'short', day: 'numeric' });
        });
        const data = visitsData.map(item => item.total);

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Daily Visits',
                    data: data,
                    borderColor: 'rgb(59, 130, 246)',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: 'rgb(59, 130, 246)',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 6,
                    pointHoverRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        callbacks: {
                            title: function(context) {
                                return 'Date: ' + context[0].label;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.1)'
                        },
                        ticks: {
                            stepSize: 1
                        }
                    },
                    x: {
                        grid: {
                            color: 'rgba(0, 0, 0, 0.1)'
                        }
                    }
                },
                interaction: {
                    mode: 'nearest',
                    axis: 'x',
                    intersect: false
                }
            }
        });
    }
});
</script>
@endpush

@endsection
