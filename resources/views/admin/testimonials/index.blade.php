@extends('admin.layout')

@section('content')
<div class="container mx-auto">
  <div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold text-gray-800">💬 Testimonials Management</h1>
    <a href="{{ route('admin.testimonials.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg font-medium inline-flex items-center gap-2">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
      </svg>
      Add Testimonial
    </a>
  </div>

  @if(session('success'))
      <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
          {{ session('success') }}
      </div>
  @endif

  <!-- Stats Cards -->
  <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded-lg">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-sm text-yellow-700 font-medium">Pending</p>
          <p class="text-2xl font-bold text-yellow-900">{{ $pending }}</p>
        </div>
        <div class="p-3 bg-yellow-100 rounded-full">
          <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
          </svg>
        </div>
      </div>
    </div>

    <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-lg">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-sm text-green-700 font-medium">Approved</p>
          <p class="text-2xl font-bold text-green-900">{{ $approved }}</p>
        </div>
        <div class="p-3 bg-green-100 rounded-full">
          <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
          </svg>
        </div>
      </div>
    </div>

    <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-lg">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-sm text-red-700 font-medium">Rejected</p>
          <p class="text-2xl font-bold text-red-900">{{ $rejected }}</p>
        </div>
        <div class="p-3 bg-red-100 rounded-full">
          <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
          </svg>
        </div>
      </div>
    </div>
  </div>

  <!-- Tabs -->
  <div class="mb-6">
    <div class="border-b border-gray-200">
      <nav class="-mb-px flex space-x-8">
        <a href="?status=pending" class="border-b-2 {{ request('status', 'pending') === 'pending' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} py-4 px-1 text-sm font-medium">
          Pending ({{ $pending }})
        </a>
        <a href="?status=approved" class="border-b-2 {{ request('status') === 'approved' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} py-4 px-1 text-sm font-medium">
          Approved ({{ $approved }})
        </a>
        <a href="?status=rejected" class="border-b-2 {{ request('status') === 'rejected' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} py-4 px-1 text-sm font-medium">
          Rejected ({{ $rejected }})
        </a>
      </nav>
    </div>
  </div>

  <!-- Testimonials List -->
  <div class="space-y-4">
    @forelse($testimonials as $testimonial)
      <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <div class="p-6">
          <div class="flex items-start gap-4">
            <!-- Photo -->
            <div class="flex-shrink-0">
              @if($testimonial->photo)
                <img src="{{ asset('storage/' . $testimonial->photo) }}" class="w-16 h-16 rounded-full object-cover border-2 border-gray-200">
              @else
                <div class="w-16 h-16 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white text-xl font-bold">
                  {{ substr($testimonial->name, 0, 1) }}
                </div>
              @endif
            </div>

            <!-- Content -->
            <div class="flex-1">
              <div class="flex items-start justify-between">
                <div>
                  <h3 class="text-lg font-bold text-gray-900">{{ $testimonial->name }}</h3>
                  <div class="flex items-center gap-3 mt-1 text-sm text-gray-600">
                    @if($testimonial->major)
                      <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs font-medium">{{ $testimonial->major }}</span>
                    @endif
                    @if($testimonial->batch)
                      <span>Angkatan {{ $testimonial->batch }}</span>
                    @endif
                  </div>
                  @if($testimonial->program)
                    <p class="text-sm text-gray-600 mt-1">Program: {{ $testimonial->program }}</p>
                  @endif
                </div>

                <!-- Status Badge -->
                <div>
                  @if($testimonial->status === 'pending')
                    <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-xs font-medium">Pending</span>
                  @elseif($testimonial->status === 'approved')
                    <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-medium">Approved</span>
                  @else
                    <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-xs font-medium">Rejected</span>
                  @endif
                </div>
              </div>

              <!-- Rating -->
              <div class="flex items-center gap-1 mt-2">
                @for($i = 1; $i <= 5; $i++)
                  <svg class="w-4 h-4 {{ $i <= $testimonial->rating ? 'text-yellow-400 fill-current' : 'text-gray-300' }}" viewBox="0 0 20 20">
                    <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                  </svg>
                @endfor
                <span class="text-sm text-gray-600 ml-2">({{ $testimonial->rating }}/5)</span>
              </div>

              <!-- Testimonial Text -->
              <div class="mt-4 p-4 bg-gray-50 rounded-lg">
                <p class="text-gray-700 leading-relaxed">"{{ $testimonial->testimonial }}"</p>
              </div>

              <!-- Admin Notes -->
              @if($testimonial->admin_notes)
                <div class="mt-3 p-3 bg-blue-50 border-l-4 border-blue-500 rounded">
                  <p class="text-sm text-blue-900"><strong>Admin Notes:</strong> {{ $testimonial->admin_notes }}</p>
                </div>
              @endif

              <!-- Meta Info -->
              <div class="mt-4 flex items-center gap-4 text-xs text-gray-500">
                <span>Submitted: {{ $testimonial->created_at->format('d M Y, H:i') }}</span>
                @if($testimonial->approved_at)
                  <span>Approved: {{ $testimonial->approved_at->format('d M Y, H:i') }}</span>
                @endif
                <span>By: {{ $testimonial->user->name ?? 'Unknown' }}</span>
              </div>

              <!-- Actions -->
              <div class="mt-4 flex gap-2">
                @if($testimonial->status === 'pending')
                  <form action="{{ route('admin.testimonials.approve', $testimonial) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded text-sm font-medium">
                      ✓ Approve
                    </button>
                  </form>
                  <button onclick="showRejectModal({{ $testimonial->id }})" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded text-sm font-medium">
                    ✗ Reject
                  </button>
                @endif
                <a href="{{ route('admin.testimonials.edit', $testimonial) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded text-sm font-medium">
                  ✏️ Edit
                </a>
                <form action="{{ route('admin.testimonials.destroy', $testimonial) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this testimonial?')">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded text-sm font-medium">
                    🗑 Delete
                  </button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    @empty
      <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-12 text-center">
        <p class="text-gray-500">No testimonials found.</p>
      </div>
    @endforelse
  </div>

  <!-- Pagination -->
  <div class="mt-6">
    {{ $testimonials->links() }}
  </div>
</div>

<!-- Reject Modal -->
<div id="rejectModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
  <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
    <h3 class="text-lg font-bold mb-4">Reject Testimonial</h3>
    <form id="rejectForm" method="POST">
      @csrf
      <div class="mb-4">
        <label class="block text-sm font-medium mb-2">Reason for rejection:</label>
        <textarea name="admin_notes" rows="4" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Explain why this testimonial is being rejected..."></textarea>
      </div>
      <div class="flex gap-2">
        <button type="button" onclick="closeRejectModal()" class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded font-medium">
          Cancel
        </button>
        <button type="submit" class="flex-1 bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded font-medium">
          Reject
        </button>
      </div>
    </form>
  </div>
</div>

<script>
function showRejectModal(id) {
  const modal = document.getElementById('rejectModal');
  const form = document.getElementById('rejectForm');
  form.action = `/admin/testimonials/${id}/reject`;
  modal.classList.remove('hidden');
  modal.classList.add('flex');
}

function closeRejectModal() {
  const modal = document.getElementById('rejectModal');
  modal.classList.add('hidden');
  modal.classList.remove('flex');
}
</script>
@endsection
