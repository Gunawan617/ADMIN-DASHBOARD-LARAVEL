@extends('admin.layout')

@section('title', 'Edit Video Section')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <div class="flex items-center gap-2 text-sm text-gray-600 mb-2">
            <a href="{{ route('admin.video-sections.index') }}" class="hover:text-blue-600">Video Sections</a>
            <span>/</span>
            <span class="text-gray-900 font-medium">Edit</span>
        </div>
        <h1 class="text-3xl font-bold text-gray-800">Edit Video Section</h1>
    </div>

    <div class="max-w-4xl">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="p-8">
                <form action="{{ route('admin.video-sections.update', $videoSection) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Title & Description -->
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Title *</label>
                        <input type="text" 
                               name="title" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('title') border-red-500 @enderror" 
                               value="{{ old('title', $videoSection->title) }}"
                               required>
                        @error('title')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Description *</label>
                        <textarea name="description" 
                                  rows="2"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('description') border-red-500 @enderror" 
                                  required>{{ old('description', $videoSection->description) }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Video Type Selection -->
                    <div class="border-t border-gray-200 pt-6 mb-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Pilih Tipe Video</h3>
                        
                        <div class="flex gap-6 mb-6">
                            <label class="flex items-center cursor-pointer">
                                <input type="radio" 
                                       name="video_type" 
                                       value="upload" 
                                       class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500"
                                       {{ old('video_type', $videoSection->video_type) === 'upload' ? 'checked' : '' }}
                                       onchange="toggleVideoType('upload')">
                                <span class="ml-2 text-sm font-medium text-gray-700">Upload Video File</span>
                            </label>
                            <label class="flex items-center cursor-pointer">
                                <input type="radio" 
                                       name="video_type" 
                                       value="youtube" 
                                       class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500"
                                       {{ old('video_type', $videoSection->video_type) === 'youtube' ? 'checked' : '' }}
                                       onchange="toggleVideoType('youtube')">
                                <span class="ml-2 text-sm font-medium text-gray-700">YouTube Video</span>
                            </label>
                        </div>

                        <!-- Upload Video Section -->
                        <div id="upload-section">
                            @if($videoSection->video_type === 'upload' && $videoSection->video_url)
                                <div class="mb-4 p-4 bg-gray-50 rounded-lg">
                                    <p class="text-sm font-semibold text-gray-700 mb-2">Video Saat Ini:</p>
                                    <video controls class="w-full max-w-md rounded-lg">
                                        <source src="{{ asset('storage/' . $videoSection->video_url) }}" type="video/mp4">
                                    </video>
                                </div>
                            @endif

                            <div class="mb-4">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Upload Video Baru (Optional)</label>
                                <input type="file" 
                                       name="video_file" 
                                       id="video_file"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('video_file') border-red-500 @enderror" 
                                       accept="video/mp4,video/webm,video/quicktime">
                                <p class="text-sm text-gray-500 mt-1">Format: MP4, WEBM, MOV. Max: 50MB. Kosongkan jika tidak ingin mengubah video.</p>
                                @error('video_file')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- YouTube URL Section -->
                        <div id="youtube-section">
                            @if($videoSection->video_type === 'youtube' && $videoSection->youtube_url)
                                <div class="mb-4 p-4 bg-gray-50 rounded-lg">
                                    <p class="text-sm font-semibold text-gray-700 mb-2">YouTube Video Saat Ini:</p>
                                    <div class="aspect-video max-w-md">
                                        <iframe 
                                            class="w-full h-full rounded-lg"
                                            src="https://www.youtube.com/embed/{{ $videoSection->youtube_url }}" 
                                            frameborder="0" 
                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                            allowfullscreen>
                                        </iframe>
                                    </div>
                                </div>
                            @endif

                            <div class="mb-4">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">YouTube URL</label>
                                <input type="url" 
                                       name="youtube_url" 
                                       id="youtube_url"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('youtube_url') border-red-500 @enderror" 
                                       placeholder="https://www.youtube.com/watch?v=..."
                                       value="{{ old('youtube_url', $videoSection->youtube_url ? 'https://www.youtube.com/watch?v=' . $videoSection->youtube_url : '') }}">
                                <p class="text-sm text-gray-500 mt-1">Paste link YouTube video</p>
                                @error('youtube_url')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Thumbnail -->
                        @if($videoSection->thumbnail_url)
                            <div class="mb-4">
                                <p class="text-sm font-semibold text-gray-700 mb-2">Thumbnail Saat Ini:</p>
                                @if(str_starts_with($videoSection->thumbnail_url, 'http'))
                                    <img src="{{ $videoSection->thumbnail_url }}" 
                                         alt="Current thumbnail" 
                                         class="max-w-sm rounded-lg shadow-md">
                                @else
                                    <img src="{{ asset('storage/' . $videoSection->thumbnail_url) }}" 
                                         alt="Current thumbnail" 
                                         class="max-w-sm rounded-lg shadow-md">
                                @endif
                            </div>
                        @endif

                        <div class="mb-4">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Upload Thumbnail Baru (Optional)</label>
                            <input type="file" 
                                   name="thumbnail" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('thumbnail') border-red-500 @enderror" 
                                   accept="image/*">
                            <p class="text-sm text-gray-500 mt-1">Format: JPG, PNG, WEBP. Max: 2MB. Kosongkan jika tidak ingin mengubah thumbnail.</p>
                            @error('thumbnail')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <script>
                        function toggleVideoType(type) {
                            const uploadSection = document.getElementById('upload-section');
                            const youtubeSection = document.getElementById('youtube-section');
                            const videoFile = document.getElementById('video_file');
                            const youtubeUrl = document.getElementById('youtube_url');
                            
                            if (type === 'upload') {
                                uploadSection.style.display = 'block';
                                youtubeSection.style.display = 'none';
                                videoFile.required = false;
                                youtubeUrl.required = false;
                            } else {
                                uploadSection.style.display = 'none';
                                youtubeSection.style.display = 'block';
                                videoFile.required = false;
                                youtubeUrl.required = true;
                            }
                        }

                        // Initialize on page load
                        document.addEventListener('DOMContentLoaded', function() {
                            const selectedType = document.querySelector('input[name="video_type"]:checked').value;
                            toggleVideoType(selectedType);
                        });
                    </script>

                    <!-- Badge Info -->
                    <div class="border-t border-gray-200 pt-6 mb-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Badge Info</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Badge Title *</label>
                                <input type="text" 
                                       name="badge_title" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('badge_title') border-red-500 @enderror" 
                                       value="{{ old('badge_title', $videoSection->badge_title) }}"
                                       required>
                                @error('badge_title')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Badge Subtitle *</label>
                                <input type="text" 
                                       name="badge_subtitle" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('badge_subtitle') border-red-500 @enderror" 
                                       value="{{ old('badge_subtitle', $videoSection->badge_subtitle) }}"
                                       required>
                                @error('badge_subtitle')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Features -->
                    <div class="border-t border-gray-200 pt-6 mb-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Features (3 items)</h3>
                        
                        <!-- Feature 1 -->
                        <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                            <h4 class="font-semibold text-gray-700 mb-3">Feature 1</h4>
                            <div class="grid grid-cols-12 gap-4">
                                <div class="col-span-2">
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Icon</label>
                                    <input type="text" 
                                           name="feature1_icon" 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition text-center text-2xl" 
                                           value="{{ old('feature1_icon', $videoSection->feature1_icon) }}"
                                           maxlength="10"
                                           required>
                                </div>
                                <div class="col-span-4">
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Title</label>
                                    <input type="text" 
                                           name="feature1_title" 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" 
                                           value="{{ old('feature1_title', $videoSection->feature1_title) }}"
                                           required>
                                </div>
                                <div class="col-span-6">
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Description</label>
                                    <input type="text" 
                                           name="feature1_description" 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" 
                                           value="{{ old('feature1_description', $videoSection->feature1_description) }}"
                                           required>
                                </div>
                            </div>
                        </div>

                        <!-- Feature 2 -->
                        <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                            <h4 class="font-semibold text-gray-700 mb-3">Feature 2</h4>
                            <div class="grid grid-cols-12 gap-4">
                                <div class="col-span-2">
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Icon</label>
                                    <input type="text" 
                                           name="feature2_icon" 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition text-center text-2xl" 
                                           value="{{ old('feature2_icon', $videoSection->feature2_icon) }}"
                                           maxlength="10"
                                           required>
                                </div>
                                <div class="col-span-4">
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Title</label>
                                    <input type="text" 
                                           name="feature2_title" 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" 
                                           value="{{ old('feature2_title', $videoSection->feature2_title) }}"
                                           required>
                                </div>
                                <div class="col-span-6">
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Description</label>
                                    <input type="text" 
                                           name="feature2_description" 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" 
                                           value="{{ old('feature2_description', $videoSection->feature2_description) }}"
                                           required>
                                </div>
                            </div>
                        </div>

                        <!-- Feature 3 -->
                        <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                            <h4 class="font-semibold text-gray-700 mb-3">Feature 3</h4>
                            <div class="grid grid-cols-12 gap-4">
                                <div class="col-span-2">
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Icon</label>
                                    <input type="text" 
                                           name="feature3_icon" 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition text-center text-2xl" 
                                           value="{{ old('feature3_icon', $videoSection->feature3_icon) }}"
                                           maxlength="10"
                                           required>
                                </div>
                                <div class="col-span-4">
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Title</label>
                                    <input type="text" 
                                           name="feature3_title" 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" 
                                           value="{{ old('feature3_title', $videoSection->feature3_title) }}"
                                           required>
                                </div>
                                <div class="col-span-6">
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Description</label>
                                    <input type="text" 
                                           name="feature3_description" 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" 
                                           value="{{ old('feature3_description', $videoSection->feature3_description) }}"
                                           required>
                                </div>
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
                                   {{ old('is_active', $videoSection->is_active) ? 'checked' : '' }}>
                            <span class="ml-2 text-sm font-medium text-gray-700">Aktifkan video section ini</span>
                        </label>
                        <p class="text-sm text-gray-500 mt-1 ml-6">Hanya satu video section yang bisa aktif pada satu waktu</p>
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
                        <a href="{{ route('admin.video-sections.index') }}" 
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
