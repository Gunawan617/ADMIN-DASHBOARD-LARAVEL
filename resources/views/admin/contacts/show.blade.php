@extends('admin.layout')

@section('content')
<div class="container mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 py-8">
    
    <div class="mb-6">
        <a href="{{ route('admin.contacts.index') }}" class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-800 font-medium">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali ke Daftar Pesan
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-indigo-50 to-blue-50 px-8 py-6 border-b border-gray-200">
            <div class="flex items-start justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 mb-2">Detail Pesan Kontak</h1>
                    <p class="text-sm text-gray-600">Diterima pada {{ $contact->created_at->format('d F Y, H:i') }}</p>
                </div>
                <div>
                    @if($contact->status === 'new')
                        <span class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg text-sm font-bold bg-yellow-100 text-yellow-800 border border-yellow-200">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"/>
                            </svg>
                            Baru
                        </span>
                    @elseif($contact->status === 'read')
                        <span class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg text-sm font-bold bg-blue-100 text-blue-800 border border-blue-200">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                            </svg>
                            Dibaca
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg text-sm font-bold bg-green-100 text-green-800 border border-green-200">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            Dibalas
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="px-8 py-6 space-y-6">
            <!-- Contact Info -->
            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
                    <div class="flex items-center gap-3 p-4 bg-gray-50 rounded-lg border border-gray-200">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <span class="text-gray-900 font-medium">{{ $contact->name }}</span>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                    <div class="flex items-center gap-3 p-4 bg-gray-50 rounded-lg border border-gray-200">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <a href="mailto:{{ $contact->email }}" class="text-blue-600 hover:text-blue-800 hover:underline font-medium">
                            {{ $contact->email }}
                        </a>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nomor WhatsApp</label>
                    <div class="flex items-center gap-3 p-4 bg-gray-50 rounded-lg border border-gray-200">
                        <svg class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                        </svg>
                        <a href="https://wa.me/{{ $contact->phone }}" target="_blank" class="text-green-600 hover:text-green-800 hover:underline font-medium">
                            {{ $contact->phone }}
                        </a>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Subjek</label>
                    <div class="flex items-center gap-3 p-4 bg-gray-50 rounded-lg border border-gray-200">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                        <span class="text-gray-900 font-medium">{{ ucfirst($contact->subject) }}</span>
                    </div>
                </div>
            </div>

            <!-- Message -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Pesan</label>
                <div class="p-6 bg-gray-50 rounded-lg border border-gray-200">
                    <p class="text-gray-800 leading-relaxed whitespace-pre-wrap">{{ $contact->message }}</p>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center gap-3 pt-4 border-t border-gray-200">
                <form action="{{ route('admin.contacts.update-status', $contact->id) }}" method="POST" class="flex-1">
                    @csrf
                    <div class="flex items-center gap-3">
                        <label class="text-sm font-semibold text-gray-700">Ubah Status:</label>
                        <select name="status" onchange="this.form.submit()" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="new" {{ $contact->status === 'new' ? 'selected' : '' }}>Baru</option>
                            <option value="read" {{ $contact->status === 'read' ? 'selected' : '' }}>Dibaca</option>
                            <option value="replied" {{ $contact->status === 'replied' ? 'selected' : '' }}>Dibalas</option>
                        </select>
                    </div>
                </form>

                <form action="{{ route('admin.contacts.destroy', $contact->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pesan ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center gap-2 px-6 py-2 bg-red-500 text-white font-bold rounded-lg shadow-md hover:bg-red-600 hover:shadow-lg transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Hapus Pesan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
