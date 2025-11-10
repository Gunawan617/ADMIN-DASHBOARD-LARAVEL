@extends('admin.layout')

@section('content')
<div class="container mx-auto max-w-3xl">
  <div class="mb-6">
    <a href="{{ route('admin.testimonials.index') }}" class="text-blue-500 hover:text-blue-700 inline-flex items-center gap-2">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
      </svg>
      Back to Testimonials
    </a>
  </div>

  <div class="bg-white rounded-lg shadow-md p-8">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">✏️ Edit Testimonial</h1>

    @if($errors->any())
      <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
        <ul class="list-disc list-inside">
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form action="{{ route('admin.testimonials.update', $testimonial) }}" method="POST" enctype="multipart/form-data">
      @csrf
      @method('PUT')

      <!-- Name -->
      <div class="mb-6">
        <label class="block text-sm font-medium text-gray-700 mb-2">
          Name <span class="text-red-500">*</span>
        </label>
        <input type="text" name="name" value="{{ old('name', $testimonial->name) }}" required
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
      </div>

      <!-- Batch -->
      <div class="mb-6">
        <label class="block text-sm font-medium text-gray-700 mb-2">
          Batch (Angkatan)
        </label>
        <input type="text" name="batch" value="{{ old('batch', $testimonial->batch) }}"
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
      </div>

      <!-- Major -->
      <div class="mb-6">
        <label class="block text-sm font-medium text-gray-700 mb-2">
          Major (Jurusan)
        </label>
        <select name="major" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
          <option value="">Select major</option>
          <option value="Perawat" {{ old('major', $testimonial->major) === 'Perawat' ? 'selected' : '' }}>Perawat</option>
          <option value="Bidan" {{ old('major', $testimonial->major) === 'Bidan' ? 'selected' : '' }}>Bidan</option>
        </select>
      </div>

      <!-- Program -->
      <div class="mb-6">
        <label class="block text-sm font-medium text-gray-700 mb-2">
          Program
        </label>
        <input type="text" name="program" value="{{ old('program', $testimonial->program) }}"
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
      </div>

      <!-- Rating -->
      <div class="mb-6">
        <label class="block text-sm font-medium text-gray-700 mb-2">
          Rating <span class="text-red-500">*</span>
        </label>
        <div class="flex gap-2">
          @for($i = 1; $i <= 5; $i++)
            <label class="cursor-pointer">
              <input type="radio" name="rating" value="{{ $i }}" {{ old('rating', $testimonial->rating) == $i ? 'checked' : '' }} required class="hidden peer">
              <div class="flex items-center gap-1 px-4 py-2 border-2 border-gray-300 rounded-lg peer-checked:border-blue-500 peer-checked:bg-blue-50 hover:border-blue-300">
                <svg class="w-5 h-5 text-yellow-400 fill-current" viewBox="0 0 20 20">
                  <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                </svg>
                <span class="font-medium">{{ $i }}</span>
              </div>
            </label>
          @endfor
        </div>
      </div>

      <!-- Testimonial -->
      <div class="mb-6">
        <label class="block text-sm font-medium text-gray-700 mb-2">
          Testimonial <span class="text-red-500">*</span>
        </label>
        <textarea name="testimonial" rows="6" required
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('testimonial', $testimonial->testimonial) }}</textarea>
        <p class="text-sm text-gray-500 mt-1">Minimum 50 characters</p>
      </div>

      <!-- Current Photo -->
      @if($testimonial->photo)
        <div class="mb-6">
          <label class="block text-sm font-medium text-gray-700 mb-2">Current Photo</label>
          <img src="{{ asset('storage/' . $testimonial->photo) }}" class="w-32 h-32 rounded-lg object-cover border-2 border-gray-200">
          <label class="flex items-center gap-2 mt-2">
            <input type="checkbox" name="remove_photo" value="1" class="rounded">
            <span class="text-sm text-gray-600">Remove current photo</span>
          </label>
        </div>
      @endif

      <!-- New Photo -->
      <div class="mb-6">
        <label class="block text-sm font-medium text-gray-700 mb-2">
          {{ $testimonial->photo ? 'Replace Photo' : 'Photo' }} (Optional)
        </label>
        <input type="file" name="photo" accept="image/jpeg,image/png,image/jpg,image/webp"
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
        <p class="text-sm text-gray-500 mt-1">Max 2MB. Formats: JPG, PNG, WEBP</p>
      </div>

      <!-- Status -->
      <div class="mb-6">
        <label class="block text-sm font-medium text-gray-700 mb-2">
          Status <span class="text-red-500">*</span>
        </label>
        <select name="status" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
          <option value="approved" {{ old('status', $testimonial->status) === 'approved' ? 'selected' : '' }}>Approved</option>
          <option value="pending" {{ old('status', $testimonial->status) === 'pending' ? 'selected' : '' }}>Pending</option>
          <option value="rejected" {{ old('status', $testimonial->status) === 'rejected' ? 'selected' : '' }}>Rejected</option>
        </select>
      </div>

      <!-- Admin Notes -->
      <div class="mb-6">
        <label class="block text-sm font-medium text-gray-700 mb-2">
          Admin Notes (Optional)
        </label>
        <textarea name="admin_notes" rows="3"
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('admin_notes', $testimonial->admin_notes) }}</textarea>
      </div>

      <!-- Submit Buttons -->
      <div class="flex gap-3">
        <button type="submit" class="flex-1 bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg font-medium">
          Update Testimonial
        </button>
        <a href="{{ route('admin.testimonials.index') }}" class="px-6 py-3 border border-gray-300 rounded-lg font-medium text-gray-700 hover:bg-gray-50">
          Cancel
        </a>
      </div>
    </form>
  </div>
</div>
@endsection
