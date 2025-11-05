@extends('admin.layout')

@section('content')
<div class="container mx-auto max-w-4xl">
  <div class="mb-6">
    <a href="{{ route('admin.program-details.index') }}" class="text-blue-600 hover:underline">← Kembali</a>
    <h1 class="text-3xl font-bold text-gray-800 mt-2">Edit Program</h1>
  </div>

  <form action="{{ route('admin.program-details.update', $programDetail) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-lg shadow p-6 space-y-6">
    @csrf
    @method('PUT')

    {{-- Basic Info --}}
    <div class="border-b pb-4">
      <h2 class="text-xl font-bold mb-4">Informasi Dasar</h2>
      
      <div class="grid md:grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-medium mb-2">Judul Program *</label>
          <input type="text" name="title" required class="w-full px-3 py-2 border rounded-lg" value="{{ old('title', $programDetail->title) }}">
        </div>

        <div>
          <label class="block text-sm font-medium mb-2">Tipe Produk *</label>
          <select name="product_type" required class="w-full px-3 py-2 border rounded-lg">
            <option value="bimbel" {{ $programDetail->product_type === 'bimbel' ? 'selected' : '' }}>Bimbel</option>
            <option value="tryout" {{ $programDetail->product_type === 'tryout' ? 'selected' : '' }}>Try Out</option>
            <option value="books" {{ $programDetail->product_type === 'books' ? 'selected' : '' }}>Buku</option>
            <option value="video" {{ $programDetail->product_type === 'video' ? 'selected' : '' }}>Video</option>
          </select>
        </div>

        <div>
          <label class="block text-sm font-medium mb-2">Audience *</label>
          <select name="audience_type" required class="w-full px-3 py-2 border rounded-lg">
            <option value="nurse" {{ $programDetail->audience_type === 'nurse' ? 'selected' : '' }}>Perawat</option>
            <option value="midwife" {{ $programDetail->audience_type === 'midwife' ? 'selected' : '' }}>Bidan</option>
          </select>
        </div>

        <div>
          <label class="block text-sm font-medium mb-2">Status *</label>
          <select name="status" required class="w-full px-3 py-2 border rounded-lg">
            <option value="published" {{ $programDetail->status === 'published' ? 'selected' : '' }}>Published</option>
            <option value="draft" {{ $programDetail->status === 'draft' ? 'selected' : '' }}>Draft</option>
          </select>
        </div>
      </div>

      <div class="mt-4">
        <label class="block text-sm font-medium mb-2">Deskripsi *</label>
        <textarea name="description" required rows="3" class="w-full px-3 py-2 border rounded-lg">{{ old('description', $programDetail->description) }}</textarea>
      </div>

      <div class="mt-4">
        <label class="block text-sm font-medium mb-2">Gambar</label>
        @if($programDetail->image)
          <img src="{{ asset('storage/' . $programDetail->image) }}" class="w-32 h-32 object-cover rounded mb-2">
        @endif
        <input type="file" name="image" accept="image/*" class="w-full px-3 py-2 border rounded-lg">
      </div>
    </div>

    {{-- Program Details --}}
    <div class="border-b pb-4">
      <h2 class="text-xl font-bold mb-4">Detail Program</h2>
      
      <div class="grid md:grid-cols-3 gap-4">
        <div>
          <label class="block text-sm font-medium mb-2">Tag</label>
          <input type="text" name="tag" class="w-full px-3 py-2 border rounded-lg" value="{{ old('tag', $programDetail->tag) }}">
        </div>

        <div>
          <label class="block text-sm font-medium mb-2">Durasi</label>
          <input type="text" name="duration" class="w-full px-3 py-2 border rounded-lg" value="{{ old('duration', $programDetail->duration) }}">
        </div>

        <div>
          <label class="block text-sm font-medium mb-2">Harga</label>
          <input type="text" name="price" class="w-full px-3 py-2 border rounded-lg" value="{{ old('price', $programDetail->price) }}">
        </div>

        <div>
          <label class="block text-sm font-medium mb-2">Peserta</label>
          <input type="text" name="students" class="w-full px-3 py-2 border rounded-lg" value="{{ old('students', $programDetail->students) }}">
        </div>

        <div>
          <label class="block text-sm font-medium mb-2">Level</label>
          <input type="text" name="level" class="w-full px-3 py-2 border rounded-lg" value="{{ old('level', $programDetail->level) }}">
        </div>

        <div>
          <label class="block text-sm font-medium mb-2">Jumlah Soal</label>
          <input type="text" name="questions" class="w-full px-3 py-2 border rounded-lg" value="{{ old('questions', $programDetail->questions) }}">
        </div>
      </div>
    </div>

    {{-- Features (All types) --}}
    <div class="border-b pb-4">
      <h2 class="text-xl font-bold mb-4">Fitur (satu per baris)</h2>
      <textarea name="features_text" rows="6" class="w-full px-3 py-2 border rounded-lg">{{ old('features_text', is_array($programDetail->features) ? implode("\n", $programDetail->features) : '') }}</textarea>
      <p class="text-xs text-gray-500 mt-1">Pisahkan setiap fitur dengan enter/baris baru</p>
    </div>

    {{-- Schedule (for bimbel only) --}}
    <div class="border-b pb-4" id="schedule_section" style="display: {{ $programDetail->product_type === 'bimbel' ? 'block' : 'none' }};">
      <h2 class="text-xl font-bold mb-4">Jadwal Pembelajaran <span class="text-red-500">*</span></h2>
      @php
        $scheduleText = '';
        if (is_array($programDetail->schedule)) {
          $scheduleText = collect($programDetail->schedule)->map(function($item) {
            return ($item['week'] ?? '') . ' | ' . ($item['topic'] ?? '');
          })->implode("\n");
        }
      @endphp
      <textarea name="schedule_text" rows="6" class="w-full px-3 py-2 border rounded-lg">{{ old('schedule_text', $scheduleText) }}</textarea>
      <p class="text-xs text-gray-500 mt-1">Format: Minggu | Topik (pisahkan dengan | dan setiap jadwal dengan enter)</p>
    </div>

    {{-- Packages (for tryout only) --}}
    <div class="border-b pb-4" id="packages_section" style="display: {{ $programDetail->product_type === 'tryout' ? 'block' : 'none' }};">
      <h2 class="text-xl font-bold mb-4">Paket Try Out <span class="text-red-500">*</span></h2>
      @php
        $packagesText = '';
        if (is_array($programDetail->packages)) {
          $packagesText = collect($programDetail->packages)->map(function($item) {
            return ($item['name'] ?? '') . ' | ' . ($item['topic'] ?? '') . ' | ' . ($item['questions'] ?? '') . ' | ' . ($item['duration'] ?? '');
          })->implode("\n");
        }
      @endphp
      <textarea name="packages_text" rows="6" class="w-full px-3 py-2 border rounded-lg">{{ old('packages_text', $packagesText) }}</textarea>
      <p class="text-xs text-gray-500 mt-1">Format: Nama | Topik | Jumlah Soal | Durasi (pisahkan dengan | dan setiap paket dengan enter)</p>
    </div>

    <div class="flex gap-4">
      <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
        Update Program
      </button>
      <a href="{{ route('admin.program-details.index') }}" class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-400">
        Batal
      </a>
    </div>
  </form>
</div>

<script>
// Show/hide sections based on product type
document.addEventListener('DOMContentLoaded', function() {
  const productTypeSelect = document.querySelector('[name="product_type"]');
  const scheduleSection = document.getElementById('schedule_section');
  const packagesSection = document.getElementById('packages_section');

  function updateSections() {
    const productType = productTypeSelect.value;
    
    // Hide all optional sections first
    scheduleSection.style.display = 'none';
    packagesSection.style.display = 'none';
    
    // Show relevant sections
    if (productType === 'bimbel') {
      scheduleSection.style.display = 'block';
    } else if (productType === 'tryout') {
      packagesSection.style.display = 'block';
    }
  }

  productTypeSelect.addEventListener('change', updateSections);
  updateSections(); // Initial call
});
</script>

@endsection
