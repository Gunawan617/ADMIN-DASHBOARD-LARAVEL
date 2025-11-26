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

export function AlumniGallery() {
    const [alumni, setAlumni] = useState<Alumni[]>([]);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        fetchAlumni();
    }, []);

    const fetchAlumni = async () => {
        try {
            const response = await fetch('/api/public/alumni');
            const data = await response.json();
            // Ambil 6 alumni terbaru
            setAlumni(Array.isArray(data) ? data.slice(0, 6) : []);
            setLoading(false);
        } catch (error) {
            console.error('Error:', error);
            setLoading(false);
        }
    };

    if (loading) {
        return (
            <section className="py-20 bg-white">
                <div className="container mx-auto px-4 lg:px-8">
                    <div className="text-center">
                        <div className="animate-pulse">Loading...</div>
                    </div>
                </div>
            </section>
        );
    }

    if (alumni.length === 0) {
        return null;
    }

    return (
        <section className="py-20 bg-white">
            <div className="container mx-auto px-4 lg:px-8">
                <div className="text-center max-w-3xl mx-auto mb-12">
                    <h2 className="text-3xl lg:text-4xl font-bold mb-4">
                        Galeri Alumni
                    </h2>
                    <p className="text-lg text-gray-600">
                        Momen kebahagiaan alumni kami yang telah sukses lulus UKOM
                    </p>
                </div>

                <div className="grid grid-cols-2 md:grid-cols-3 gap-4 mb-8">
                    {alumni.map((item) => (
                        <div
                            key={item.id}
                            className="group relative aspect-square overflow-hidden rounded-xl bg-gray-100 hover:shadow-xl transition-all duration-300"
                        >
                            <img
                                src={item.photo.startsWith('http') ? item.photo : `/storage/${item.photo}`}
                                alt={item.name}
                                className="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300"
                            />
                            <div className="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <div className="absolute bottom-0 left-0 right-0 p-4 text-white">
                                    <h3 className="font-bold text-lg">{item.name}</h3>
                                    <p className="text-sm text-gray-200">{item.batch} - {item.major}</p>
                                    {item.caption && (
                                        <p className="text-sm text-gray-300 mt-1 line-clamp-2">{item.caption}</p>
                                    )}
                                </div>
                            </div>
                        </div>
                    ))}
                </div>

                <div className="text-center">
                    <Link
                        to="/alumni"
                        className="inline-block px-8 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors"
                    >
                        Lihat Semua Galeri
                    </Link>
                </div>
            </div>
        </section>
    );
}
