@extends('admin.layout')

@section('title', 'Formulir Pendaftaran')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Formulir Pendaftaran</h1>
        <p class="text-gray-600 mt-1">Kelola data pendaftaran program</p>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                {{ session('success') }}
            </div>
        </div>
    @endif

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total Formulir</p>
                    <p class="text-2xl font-bold text-gray-800 mt-1">{{ $formulir->total() }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Pending</p>
                    <p class="text-2xl font-bold text-yellow-600 mt-1">{{ $formulir->where('status', 'pending')->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Dihubungi</p>
                    <p class="text-2xl font-bold text-blue-600 mt-1">{{ $formulir->where('status', 'contacted')->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Terdaftar</p>
                    <p class="text-2xl font-bold text-green-600 mt-1">{{ $formulir->where('status', 'registered')->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    @if($formulir->total() > 0)
    <div class="flex flex-wrap gap-3 mb-4">
        <button 
            id="deleteSelectedBtn" 
            type="button"
            onclick="deleteSelected()" 
            class="hidden px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors flex items-center gap-2 whitespace-nowrap shadow-sm"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
            </svg>
            Hapus Terpilih (<span id="selectedCount">0</span>)
        </button>
        <button 
            type="button"
            onclick="deleteAll()" 
            class="px-4 py-2 bg-red-700 text-white rounded-lg hover:bg-red-800 transition-colors flex items-center gap-2 whitespace-nowrap shadow-sm"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
            </svg>
            Hapus Semua ({{ $formulir->total() }})
        </button>
    </div>
    @endif

    <!-- Table Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="p-6">
            <form id="deleteForm" action="{{ route('admin.formulir.bulk-delete') }}" method="POST">
                @csrf
                <div class="overflow-x-auto">
                    <table class="w-full min-w-max">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="text-left py-4 px-4 w-12">
                                    <input 
                                        type="checkbox" 
                                        id="selectAll" 
                                        onchange="toggleSelectAll(this)"
                                        class="w-4 h-4 text-blue-600 rounded focus:ring-2 focus:ring-blue-500"
                                    >
                                </th>
                                <th class="text-left py-4 px-4 text-sm font-semibold text-gray-700 min-w-[180px]">Nama</th>
                                <th class="text-left py-4 px-4 text-sm font-semibold text-gray-700 min-w-[200px]">Kontak</th>
                                <th class="text-left py-4 px-4 text-sm font-semibold text-gray-700 min-w-[100px]">Program</th>
                                <th class="text-left py-4 px-4 text-sm font-semibold text-gray-700 min-w-[140px]">Status</th>
                                <th class="text-left py-4 px-4 text-sm font-semibold text-gray-700 min-w-[120px]">Tanggal</th>
                                <th class="text-left py-4 px-4 text-sm font-semibold text-gray-700 min-w-[120px]">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($formulir as $item)
                                <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
                                    <td class="py-4 px-4">
                                        <input 
                                            type="checkbox" 
                                            name="ids[]" 
                                            value="{{ $item->id }}"
                                            class="item-checkbox w-4 h-4 text-blue-600 rounded focus:ring-2 focus:ring-blue-500"
                                            onchange="updateSelectedCount()"
                                        >
                                    </td>
                                    <td class="py-4 px-4">
                                        <div>
                                            <p class="font-medium text-gray-900">{{ $item->nama }}</p>
                                            <p class="text-sm text-gray-500">ID: #{{ $item->id }}</p>
                                        </div>
                                    </td>
                                    <td class="py-4 px-4">
                                        <div class="space-y-1">
                                            <p class="text-sm text-gray-700">{{ $item->email }}</p>
                                            <a href="https://wa.me/{{ $item->whatsapp }}" target="_blank" class="text-sm text-green-600 hover:text-green-700 flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                                </svg>
                                                {{ $item->whatsapp }}
                                            </a>
                                        </div>
                                    </td>
                                    <td class="py-4 px-4">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $item->jenis_program == 'bimbel' ? 'bg-blue-100 text-blue-700' : 'bg-purple-100 text-purple-700' }}">
                                            {{ ucfirst($item->jenis_program) }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-4">
                                        <form action="{{ route('admin.formulir.update-status', $item->id) }}" method="POST" class="status-form">
                                            @csrf
                                            <select 
                                                name="status" 
                                                onchange="submitStatusForm(this)"
                                                class="text-sm rounded-lg border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 {{ 
                                                    $item->status == 'pending' ? 'bg-yellow-50 text-yellow-700 border-yellow-300' : 
                                                    ($item->status == 'contacted' ? 'bg-blue-50 text-blue-700 border-blue-300' : 'bg-green-50 text-green-700 border-green-300') 
                                                }}"
                                            >
                                                <option value="pending" {{ $item->status == 'pending' ? 'selected' : '' }}>⏳ Pending</option>
                                                <option value="contacted" {{ $item->status == 'contacted' ? 'selected' : '' }}>📞 Dihubungi</option>
                                                <option value="registered" {{ $item->status == 'registered' ? 'selected' : '' }}>✅ Terdaftar</option>
                                            </select>
                                        </form>
                                    </td>
                                    <td class="py-4 px-4">
                                        <div class="text-sm">
                                            <p class="text-gray-900">{{ $item->created_at->format('d M Y') }}</p>
                                            <p class="text-gray-500">{{ $item->created_at->format('H:i') }} WIB</p>
                                        </div>
                                    </td>
                                    <td class="py-4 px-4">
                                        <div class="flex gap-2 items-center">
                                            <a 
                                                href="{{ route('admin.formulir.show', $item->id) }}" 
                                                class="inline-flex items-center justify-center w-9 h-9 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition-colors"
                                                title="Lihat Detail"
                                            >
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                            </a>
                                            <button 
                                                type="button"
                                                onclick="deleteSingle({{ $item->id }})" 
                                                class="inline-flex items-center justify-center w-9 h-9 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition-colors"
                                                title="Hapus"
                                            >
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="py-12 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                            <p class="text-gray-500 text-lg">Belum ada formulir pendaftaran</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </form>
        </div>

        @if($formulir->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $formulir->links() }}
            </div>
        @endif
    </div>
</div>

<script>
function toggleSelectAll(checkbox) {
    const checkboxes = document.querySelectorAll('.item-checkbox');
    checkboxes.forEach(cb => cb.checked = checkbox.checked);
    updateSelectedCount();
}

function updateSelectedCount() {
    const checked = document.querySelectorAll('.item-checkbox:checked').length;
    document.getElementById('selectedCount').textContent = checked;
    document.getElementById('deleteSelectedBtn').classList.toggle('hidden', checked === 0);
    
    const selectAll = document.getElementById('selectAll');
    const total = document.querySelectorAll('.item-checkbox').length;
    selectAll.checked = checked === total && total > 0;
}

function deleteSelected() {
    const checked = document.querySelectorAll('.item-checkbox:checked');
    if (checked.length === 0) {
        alert('Pilih minimal satu formulir untuk dihapus');
        return;
    }
    
    if (confirm(`Yakin ingin menghapus ${checked.length} formulir terpilih?`)) {
        const form = document.getElementById('deleteForm');
        // Pastikan form method adalah POST
        form.method = 'POST';
        form.submit();
    }
}

function deleteSingle(id) {
    if (confirm('Yakin ingin menghapus formulir ini?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '/admin/formulir/' + id;
        
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = '{{ csrf_token() }}';
        
        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'DELETE';
        
        form.appendChild(csrfInput);
        form.appendChild(methodInput);
        document.body.appendChild(form);
        form.submit();
    }
}

function submitStatusForm(selectElement) {
    const form = selectElement.closest('form');
    // Pastikan tidak ada method spoofing
    const methodInput = form.querySelector('input[name="_method"]');
    if (methodInput) {
        methodInput.remove();
    }
    form.method = 'POST';
    form.submit();
}

function deleteAll() {
    const total = document.querySelectorAll('.item-checkbox').length;
    
    if (total === 0) {
        alert('Tidak ada formulir untuk dihapus');
        return;
    }
    
    if (confirm(`PERINGATAN!\n\nAnda akan menghapus SEMUA ${total} formulir pendaftaran.\nTindakan ini tidak dapat dibatalkan!\n\nYakin ingin melanjutkan?`)) {
        // Select all checkboxes
        document.querySelectorAll('.item-checkbox').forEach(cb => cb.checked = true);
        
        // Submit form
        const form = document.getElementById('deleteForm');
        form.method = 'POST';
        form.submit();
    }
}
</script>
@endsection
