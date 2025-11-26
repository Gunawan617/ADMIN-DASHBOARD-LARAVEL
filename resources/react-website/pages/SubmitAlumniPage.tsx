import { useState, useEffect } from "react";
import { useNavigate } from "react-router-dom";
import { compressImage } from "../utils/imageCompression";

export function SubmitAlumniPage() {
    const navigate = useNavigate();
    const [loading, setLoading] = useState(false);
    const [error, setError] = useState<string | null>(null);
    const [success, setSuccess] = useState(false);
    const [preview, setPreview] = useState<string | null>(null);
    const [formData, setFormData] = useState({
        photo: null as File | null,
        caption: "",
    });
    const [isAuthenticated, setIsAuthenticated] = useState(false);

    useEffect(() => {
        const token = localStorage.getItem("auth_token");
        if (!token) {
            navigate("/login");
        } else {
            setIsAuthenticated(true);
        }
    }, [navigate]);

    const handleFileChange = async (e: React.ChangeEvent<HTMLInputElement>) => {
        const file = e.target.files?.[0];
        if (!file) return;

        // Validate file type
        if (!file.type.startsWith('image/')) {
            setError('File harus berupa gambar');
            return;
        }

        // Validate file size (max 10MB before compression)
        if (file.size > 10 * 1024 * 1024) {
            setError('Ukuran file maksimal 10MB');
            return;
        }

        try {
            setError(null);
            setLoading(true);

            // Compress image
            const compressedFile = await compressImage(file, 1200, 0.85);
            
            setFormData({ ...formData, photo: compressedFile });
            
            // Create preview
            const reader = new FileReader();
            reader.onloadend = () => {
                setPreview(reader.result as string);
            };
            reader.readAsDataURL(compressedFile);
            
            setLoading(false);
        } catch (err) {
            setError('Gagal memproses gambar');
            setLoading(false);
        }
    };

    const handleSubmit = async (e: React.FormEvent) => {
        e.preventDefault();
        
        if (!formData.photo) {
            setError('Pilih foto terlebih dahulu');
            return;
        }

        setLoading(true);
        setError(null);

        try {
            const token = localStorage.getItem("auth_token");
            const submitData = new FormData();
            submitData.append('photo', formData.photo);
            if (formData.caption) {
                submitData.append('caption', formData.caption);
            }

            const response = await fetch("/api/user/alumni/submit", {
                method: "POST",
                headers: {
                    "Authorization": `Bearer ${token}`,
                    "Accept": "application/json",
                },
                body: submitData,
            });

            const data = await response.json();

            if (response.ok && data.success) {
                setSuccess(true);
                setTimeout(() => {
                    navigate("/alumni");
                }, 2000);
            } else {
                setError(data.message || "Gagal mengupload foto");
            }
        } catch (error) {
            console.error("Submit error:", error);
            setError("Terjadi kesalahan. Silakan coba lagi.");
        } finally {
            setLoading(false);
        }
    };

    if (!isAuthenticated) {
        return null;
    }

    if (success) {
        return (
            <div className="min-h-screen bg-gray-50 flex items-center justify-center py-12 px-4">
                <div className="max-w-md w-full text-center">
                    <div className="bg-white rounded-xl shadow-lg p-8">
                        <div className="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg className="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <h2 className="text-2xl font-bold text-gray-900 mb-2">Berhasil!</h2>
                        <p className="text-gray-600">Foto Anda berhasil diupload ke galeri alumni</p>
                    </div>
                </div>
            </div>
        );
    }

    return (
        <div className="min-h-screen bg-gray-50 py-12 px-4">
            <div className="max-w-2xl mx-auto">
                <div className="text-center mb-8">
                    <h1 className="text-3xl font-bold text-gray-900 mb-2">Upload Foto Alumni</h1>
                    <p className="text-gray-600">Bagikan hagiaan Anda di galeri alumni kami</p>
                </div>

                <div className="bg-white rounded-xl shadow-lg p-8">
                    <form onSubmit={handleSubmit} className="space-y-6">
                        {error && (
                            <div className="bg-red-50 border border-red-200 rounded-lg p-4">
                                <p className="text-red-800 text-sm">{error}</p>
                            </div>
                        )}

                        {/* Photo Upload */}
                        <div>
                            <label className="block text-sm font-medium mb-2">
                                Foto <span className="text-red-500">*</span>
                            </label>
                            <div className="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-blue-500 transition-colors">
                                {preview ? (
                                    <div className="space-y-4">
                                        <img
                                            src={preview}
                                            alt="Preview"
                                            className="max-h-64 mx-auto rounded-lg"
                                        />
                                        <button
                                            type="button"
                                            onClick={() => {
                                                setPreview(null);
                                                setFormData({ ...formData, photo: null });
                                            }}
                                            className="text-sm text-red-600 hover:text-red-700"
                                        >
                                            Ganti Foto
                                        </button>
                                    </div>
                                ) : (
                                    <div>
                                        <svg className="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <label className="cursor-pointer">
                                            <span className="text-blue-600 hover:text-blue-700 font-medium">
                                                Pilih foto
                                            </span>
                                            <input
                                                type="file"
                                                accept="image/*"
                                                onChange={handleFileChange}
                                                className="hidden"
                                            />
                                        </label>
                                        <p className="text-sm text-gray-500 mt-2">
                                            PNG, JPG, WEBP (max 10MB)
                                        </p>
                                        <p className="text-xs text-gray-400 mt-1">
                                            Foto akan dikompres otomatis untuk kualitas optimal
                                        </p>
                                    </div>
                                )}
                            </div>
                        </div>

                        {/* Caption */}
                        <div>
                            <label className="block text-sm font-medium mb-2">
                                Caption (Opsional)
                            </label>
                            <textarea
                                value={formData.caption}
                                onChange={(e) => setFormData({ ...formData, caption: e.target.value })}
                                rows={3}
                                className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Ceritakan momen spesial Anda..."
                            />
                        </div>

                        {/* Submit Button */}
                        <div className="flex gap-4">
                            <button
                                type="button"
                                onClick={() => navigate("/alumni")}
                                className="flex-1 px-6 py-3 border border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition-colors"
                            >
                                Batal
                            </button>
                            <button
                                type="submit"
                                disabled={loading || !formData.photo}
                                className="flex-1 px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 disabled:bg-gray-300 disabled:cursor-not-allowed transition-colors"
                            >
                                {loading ? "Mengupload..." : "Upload Foto"}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    );
}
