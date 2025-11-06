import { useState, useEffect } from "react";
import { Link } from "react-router-dom";

interface Alumni {
    id: number;
    name: string;
    batch: string;
    major: string;
    photo: string;
    caption?: string;
}

export function AlumniPage() {
    const [alumni, setAlumni] = useState<Alumni[]>([]);
    const [loading, setLoading] = useState(true);
    const [selectedImage, setSelectedImage] = useState<Alumni | null>(null);

    useEffect(() => {
        fetchAlumni();
    }, []);

    const fetchAlumni = async () => {
        try {
            const response = await fetch('/api/public/alumni');
            const data = await response.json();
            setAlumni(Array.isArray(data) ? data : []);
            setLoading(false);
        } catch (error) {
            console.error('Error:', error);
            setLoading(false);
        }
    };

    if (loading) {
        return (
            <div className="min-h-screen bg-gray-50 py-20">
                <div className="container mx-auto px-4 lg:px-8">
                    <div className="text-center">
                        <div className="animate-pulse text-gray-600">Memuat galeri...</div>
                    </div>
                </div>
            </div>
        );
    }

    return (
        <div className="min-h-screen bg-gray-50">
            {/* Header */}
            <section className="bg-gradient-to-r from-blue-600 to-indigo-600 text-white py-16">
                <div className="container mx-auto px-4 lg:px-8">
                    <div className="max-w-3xl mx-auto text-center">
                        <h1 className="text-4xl lg:text-5xl font-bold mb-4">
                            Galeri Alumni
                        </h1>
                        <p className="text-xl text-blue-100 mb-6">
                        Unggah sebaris kenangan — potret bahagiamu setelah menaklukkan UKOM.
                        </p>
                        <Link
                            to="/submit-alumni"
                            className="inline-block px-6 py-3 bg-white text-blue-600 font-semibold rounded-lg hover:bg-blue-50 transition-colors"
                        >
                            📸 Upload Foto Anda
                        </Link>
                    </div>
                </div>
            </section>

            {/* Gallery Grid */}
            <section className="py-12">
                <div className="container mx-auto px-4 lg:px-8">
                    {alumni.length === 0 ? (
                        <div className="text-center py-20">
                            <p className="text-gray-600 mb-4">Belum ada foto alumni</p>
                            <Link
                                to="/submit-alumni"
                                className="inline-block px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors"
                            >
                                Jadilah yang Pertama Upload
                            </Link>
                        </div>
                    ) : (
                        <div className="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                            {alumni.map((item) => (
                                <div
                                    key={item.id}
                                    onClick={() => setSelectedImage(item)}
                                    className="group relative aspect-square overflow-hidden rounded-xl bg-gray-100 cursor-pointer hover:shadow-xl transition-all duration-300"
                                >
                                    <img
                                        src={item.photo.startsWith('http') ? item.photo : `/storage/${item.photo}`}
                                        alt={item.name}
                                        className="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300"
                                    />
                                    <div className="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                        <div className="absolute bottom-0 left-0 right-0 p-4 text-white">
                                            <h3 className="font-bold">{item.name}</h3>
                                            <p className="text-sm text-gray-200">{item.batch}</p>
                                        </div>
                                    </div>
                                </div>
                            ))}
                        </div>
                    )}
                </div>
            </section>

            {/* Modal Lightbox */}
            {selectedImage && (
                <div
                    className="fixed inset-0 bg-black/95 z-50 flex items-center justify-center p-4 overflow-y-auto"
                    onClick={() => setSelectedImage(null)}
                >
                    <div className="relative w-full max-w-3xl my-8" onClick={(e) => e.stopPropagation()}>
                        {/* Close Button */}
                        <button
                            onClick={() => setSelectedImage(null)}
                            className="absolute -top-12 right-0 text-white hover:text-gray-300 text-4xl font-light z-10"
                        >
                            ×
                        </button>
                        
                        {/* Image Container */}
                        <div className="bg-white rounded-lg overflow-hidden shadow-2xl">
                            <div className="relative">
                                <img
                                    src={selectedImage.photo.startsWith('http') ? selectedImage.photo : `/storage/${selectedImage.photo}`}
                                    alt={selectedImage.name}
                                    className="w-full h-auto max-h-[60vh] object-contain bg-gray-100"
                                />
                            </div>
                            
                            {/* Info Section */}
                            <div className="p-6">
                                <h3 className="text-2xl font-bold text-gray-900 mb-2">{selectedImage.name}</h3>
                                <p className="text-gray-600 mb-1">
                                    <span className="font-medium">Batch:</span> {selectedImage.batch}
                                </p>
                                <p className="text-gray-600 mb-3">
                                    <span className="font-medium">Jurusan:</span> {selectedImage.major}
                                </p>
                                {selectedImage.caption && (
                                    <div className="pt-3 border-t border-gray-200">
                                        <p className="text-gray-700 italic">"{selectedImage.caption}"</p>
                                    </div>
                                )}
                            </div>
                        </div>
                    </div>
                </div>
            )}
        </div>
    );
}
