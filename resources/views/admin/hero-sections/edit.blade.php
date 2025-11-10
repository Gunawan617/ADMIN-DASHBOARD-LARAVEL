@extends('admin.layout')

@section('title', 'Edit Hero Section')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <div class="flex items-center gap-2 text-sm text-gray-600 mb-2">
            <a href="{{ route('admin.hero-sections.index') }}" class="hover:text-blue-600">Hero Sections</a>
            <span>/</span>
            <span class="text-gray-900 font-medium">Edit</span>
        </div>
        <h1 class="text-3xl font-bold text-gray-800">Edit Hero Section</h1>
    </div>

    <div class="max-w-4xl">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="p-8">
                <form action="{{ route('admin.hero-sections.update', $heroSection) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Badge Text -->
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Badge Text</label>
                        <input type="text" 
                               name="badge_text" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('badge_text') border-red-500 @enderror" 
                               value="{{ old('badge_text', $heroSection->badge_text) }}"
                               required>
                        @error('badge_text')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Title -->
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Title *</label>
                        <textarea name="title" 
                                  rows="2"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('title') border-red-500 @enderror" 
                                  required>{{ old('title', $heroSection->title) }}</textarea>
                        @error('title')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Description *</label>
                        <textarea name="description" 
                                  rows="3"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('description') border-red-500 @enderror" 
                                  required>{{ old('description', $heroSection->description) }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Buttons -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Primary Button Text *</label>
                            <input type="text" 
                                   name="primary_button_text" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('primary_button_text') border-red-500 @enderror" 
                                   value="{{ old('primary_button_text', $heroSection->primary_button_text) }}"
                                   required>
                            @error('primary_button_text')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Primary Button Link *</label>
                            <input type="text" 
                                   name="primary_button_link" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('primary_button_link') border-red-500 @enderror" 
                                   value="{{ old('primary_button_link', $heroSection->primary_button_link) }}"
                                   required>
                            @error('primary_button_link')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Secondary Button Text</label>
                            <input type="text" 
                                   name="secondary_button_text" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('secondary_button_text') border-red-500 @enderror" 
                                   value="{{ old('secondary_button_text', $heroSection->secondary_button_text) }}">
                            @error('secondary_button_text')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Secondary Button Link</label>
                            <input type="text" 
                                   name="secondary_button_link" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('secondary_button_link') border-red-500 @enderror" 
                                   value="{{ old('secondary_button_link', $heroSection->secondary_button_link) }}"
                                   placeholder="https://youtube.com/...">
                            @error('secondary_button_link')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Image -->
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Hero Image</label>
                        @if($heroSection->image_url)
                            <div class="mb-3">
                                @if(str_starts_with($heroSection->image_url, 'http'))
                                    <img src="{{ $heroSection->image_url }}" 
                                         alt="Current hero image" 
                                         class="max-w-sm rounded-lg shadow-md">
                                @else
                                    <img src="{{ asset('storage/' . $heroSection->image_url) }}" 
                                         alt="Current hero image" 
                                         class="max-w-sm rounded-lg shadow-md">
                                @endif
                            </div>
                        @endif
                        <input type="file" 
                               name="image" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('image') border-red-500 @enderror" 
                               accept="image/*">
                        <p class="text-sm text-gray-500 mt-1">Format: JPG, PNG, WEBP. Max: 2MB. Kosongkan jika tidak ingin mengubah gambar.</p>
                        @error('image')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Statistics -->
                    <div class="border-t border-gray-200 pt-6 mb-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Statistik</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Stat 1 Value *</label>
                                <input type="text" 
                                       name="stat1_value" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('stat1_value') border-red-500 @enderror" 
                                       value="{{ old('stat1_value', $heroSection->stat1_value) }}"
                                       required>
                                <input type="text" 
                                       name="stat1_label" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition mt-2 @error('stat1_label') border-red-500 @enderror" 
                                       value="{{ old('stat1_label', $heroSection->stat1_label) }}"
                                       placeholder="Label"
                                       required>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Stat 2 Value *</label>
                                <input type="text" 
                                       name="stat2_value" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('stat2_value') border-red-500 @enderror" 
                                       value="{{ old('stat2_value', $heroSection->stat2_value) }}"
                                       required>
                                <input type="text" 
                                       name="stat2_label" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition mt-2 @error('stat2_label') border-red-500 @enderror" 
                                       value="{{ old('stat2_label', $heroSection->stat2_label) }}"
                                       placeholder="Label"
                                       required>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Stat 3 Value *</label>
                                <input type="text" 
                                       name="stat3_value" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('stat3_value') border-red-500 @enderror" 
                                       value="{{ old('stat3_value', $heroSection->stat3_value) }}"
                                       required>
                                <input type="text" 
                                       name="stat3_label" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition mt-2 @error('stat3_label') border-red-500 @enderror" 
                                       value="{{ old('stat3_label', $heroSection->stat3_label) }}"
                                       placeholder="Label"
                                       required>
                            </div>
                        </div>
                    </div>

                    <!-- Floating Card -->
                    <div class="border-t border-gray-200 pt-6 mb-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Floating Card</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Floating Card Text *</label>
                                <input type="text" 
                                       name="floating_card_text" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('floating_card_text') border-red-500 @enderror" 
                                       value="{{ old('floating_card_text', $heroSection->floating_card_text) }}"
                                       required>
                                @error('floating_card_text')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Floating Card Value *</label>
                                <input type="text" 
                                       name="floating_card_value" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('floating_card_value') border-red-500 @enderror" 
                                       value="{{ old('floating_card_value', $heroSection->floating_card_value) }}"
                                       required>
                                @error('floating_card_value')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Active Status -->
                    <div class="mb-6">
                        <label class="flex items-center">
                            <input type="checkbox" 
                                   name="is_active" 
                                   value="1"
                                   class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                   {{ old('is_active', $heroSection->is_active) ? 'checked' : '' }}>
                            <span class="ml-2 text-sm font-medium text-gray-700">Aktifkan hero section ini</span>
                        </label>
                        <p class="text-sm text-gray-500 mt-1 ml-6">Hanya satu hero section yang bisa aktif pada satu waktu</p>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-3 pt-6 border-t border-gray-200">
                        <button type="submit" 
                                class="px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg hover:shadow-lg transition-all duration-300 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Update
                        </button>
                        <a href="{{ route('admin.hero-sections.index') }}" 
                           class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
