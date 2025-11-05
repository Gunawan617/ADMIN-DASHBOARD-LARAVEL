@extends('admin.layout')

@section('content')
<div class="container mx-auto max-w-4xl">
  <div class="mb-6">
    <a href="{{ route('admin.program-details.index') }}" class="text-blue-600 hover:underline">← Kembali</a>
    <h1 class="text-3xl font-bold text-gray-800 mt-2">Tambah Program Baru</h1>
  </div>

  <form action="{{ route('admin.program-details.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-lg shadow p-6 space-y-6">
    @csrf

    {{-- Basic Info --}}
    <div class="border-b pb-4">
      <h2 class="text-xl font-bold mb-4">Informasi Dasar</h2>
      
      <div class="grid md:grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-medium mb-2">Judul Program *</label>
          <input type="text" name="title" required class="w-full px-3 py-2 border rounded-lg" value="{{ old('title') }}">
        </div>

        <div>
          <label class="block text-sm font-medium mb-2">Tipe Produk *</label>
          <select name="product_type" required class="w-full px-3 py-2 border rounded-lg">
            <option value="bimbel">Bimbel</option>
            <option value="tryout">Try Out</option>
            <option value="books">Buku</option>
            <option value="video">Video</option>
          </select>
        </div>

        <div>
          <label class="block text-sm font-medium mb-2">Audience *</label>
          <select name="audience_type" required class="w-full px-3 py-2 border rounded-lg">
            <option value="nurse">Perawat</option>
            <option value="midwife">Bidan</option>
          </select>
        </div>

        <div>
          <label class="block text-sm font-medium mb-2">Status *</label>
          <select name="status" required class="w-full px-3 py-2 border rounded-lg">
            <option value="published">Published</option>
            <option value="draft">Draft</option>
          </select>
        </div>
      </div>

      <div class="mt-4">
        <label class="block text-sm font-medium mb-2">Deskripsi *</label>
        <textarea name="description" required rows="3" class="w-full px-3 py-2 border rounded-lg">{{ old('description') }}</textarea>
      </div>

      <div class="mt-4">
        <label class="block text-sm font-medium mb-2">Jadwal</label>
        <textarea name="schedule_info" rows="3" class="w-full px-3 py-2 border rounded-lg" placeholder="Contoh: Senin-Jumat: Self Learning, Sabtu-Minggu: Live Session 10.00-12.00">{{ old('schedule_info') }}</textarea>
        <p class="text-sm text-gray-500 mt-1">Opsional - Jadwal pelaksanaan program</p>
      </div>

      <div class="mt-4">
        <label class="block text-sm font-medium mb-2">Gambar</label>
        <input type="file" name="image" accept="image/*" class="w-full px-3 py-2 border rounded-lg">
      </div>
    </div>

    {{-- Program Details --}}
    <div class="border-b pb-4">
      <h2 class="text-xl font-bold mb-4">Detail Program</h2>
      
      <div class="grid md:grid-cols-3 gap-4">
        <div>
          <label class="block text-sm font-medium mb-2">Tag</label>
          <input type="text" name="tag" class="w-full px-3 py-2 border rounded-lg" placeholder="Paling Populer">
        </div>

        <div>
          <label class="block text-sm font-medium mb-2">Durasi</label>
          <input type="text" name="duration" class="w-full px-3 py-2 border rounded-lg" placeholder="2 Bulan">
        </div>

        <div>
          <label class="block text-sm font-medium mb-2">Harga</label>
          <input type="text" name="price" class="w-full px-3 py-2 border rounded-lg" placeholder="Rp 850.000">
        </div>

        <div>
          <label class="block text-sm font-medium mb-2">Peserta</label>
          <input type="text" name="students" class="w-full px-3 py-2 border rounded-lg" placeholder="3,200+">
        </div>

        <div>
          <label class="block text-sm font-medium mb-2">Level</label>
          <input type="text" name="level" class="w-full px-3 py-2 border rounded-lg" placeholder="Semua Level">
        </div>

        <div>
          <label class="block text-sm font-medium mb-2">Jumlah Soal</label>
          <input type="text" name="questions" class="w-full px-3 py-2 border rounded-lg" placeholder="1000+ Soal">
        </div>
      </div>
    </div>

    {{-- Features (All types) --}}
    <div class="border-b pb-4">
      <h2 class="text-xl font-bold mb-4">Fitur (satu per baris)</h2>
      <textarea name="features_text" id="features_text" rows="6" class="w-full px-3 py-2 border rounded-lg" placeholder="Materi lengkap sesuai blueprint&#10;Video pembelajaran&#10;Bank soal 1000+"></textarea>
      <p class="text-xs text-gray-500 mt-1">Pisahkan setiap fitur dengan enter/baris baru</p>
    </div>

    {{-- Schedule (for bimbel only) --}}
    <div class="border-b pb-4" id="schedule_section" style="display: none;">
      <h2 class="text-xl font-bold mb-4">Modul Pembelajaran <span class="text-red-500">*</span></h2>
      <textarea name="schedule_text" id="schedule_text" rows="6" class="w-full px-3 py-2 border rounded-lg" placeholder="Minggu 1-2 | Dasar Keperawatan & Anatomi Fisiologi&#10;Minggu 3-4 | Keperawatan Medikal Bedah"></textarea>
      <p class="text-xs text-gray-500 mt-1">Format: Minggu | Topik (pisahkan dengan | dan setiap jadwal dengan enter)</p>
    </div>

    {{-- Packages (for tryout only) --}}
    <div class="border-b pb-4" id="packages_section" style="display: none;">
      <h2 class="text-xl font-bold mb-4">Paket Try Out <span class="text-red-500">*</span></h2>
      <textarea name="packages_text" id="packages_text" rows="6" class="w-full px-3 py-2 border rounded-lg" placeholder="Try Out 1 | Dasar Keperawatan & KMB | 180 | 180 menit&#10;Try Out 2 | Keperawatan Maternitas | 180 | 180 menit"></textarea>
      <p class="text-xs text-gray-500 mt-1">Format: Nama | Topik | Jumlah Soal | Durasi (pisahkan dengan | dan setiap paket dengan enter)</p>
    </div>

    <div class="flex gap-4">
      <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
        Simpan Program
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
