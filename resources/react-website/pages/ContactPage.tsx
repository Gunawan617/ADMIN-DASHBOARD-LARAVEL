import { MapPin, Mail, Phone, Clock, Send } from "lucide-react";
import { useState } from "react";

export function ContactPage() {
    const [formData, setFormData] = useState({
        name: '',
        email: '',
        phone: '',
        subject: '',
        message: ''
    });
    const [loading, setLoading] = useState(false);
    const [success, setSuccess] = useState(false);

    const handleSubmit = async (e: React.FormEvent) => {
        e.preventDefault();
        setLoading(true);

        try {
            const response = await fetch('/api/public/contact', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify(formData)
            });

            const data = await response.json();

            if (response.ok) {
                setSuccess(true);
                setFormData({ name: '', email: '', phone: '', subject: '', message: '' });
                setTimeout(() => setSuccess(false), 5000);
            } else {
                alert('Gagal mengirim pesan. Silakan coba lagi.');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Terjadi kesalahan. Silakan coba lagi.');
        } finally {
            setLoading(false);
        }
    };

    const handleChange = (e: React.ChangeEvent<HTMLInputElement | HTMLTextAreaElement | HTMLSelectElement>) => {
        setFormData(prev => ({
            ...prev,
            [e.target.name]: e.target.value
        }));
    };

    return (
        <div className="min-h-screen bg-gradient-to-b from-blue-50 to-white">
            {/* Hero Section */}
            <div className="bg-gradient-to-r from-blue-600 to-indigo-700 text-white py-16">
                <div className="container mx-auto px-4 lg:px-8">
                    <div className="max-w-3xl mx-auto text-center">
                        <h1 className="text-4xl lg:text-5xl font-bold mb-4">Hubungi Kami</h1>
                        <p className="text-xl text-blue-100">
                            Kami siap membantu Anda mencapai kesuksesan dalam Uji Kompetensi
                        </p>
                    </div>
                </div>
            </div>

            <div className="container mx-auto px-4 lg:px-8 py-16">
                <div className="grid lg:grid-cols-3 gap-8 max-w-7xl mx-auto">
                    {/* Contact Info Cards */}
                    <div className="lg:col-span-1 space-y-6">
                        {/* Address */}
                        <div className="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
                            <div className="flex items-start gap-4">
                                <div className="p-3 bg-blue-100 rounded-lg">
                                    <MapPin className="w-6 h-6 text-blue-600" />
                                </div>
                                <div>
                                    <h3 className="font-semibold text-gray-900 mb-2">Alamat Kantor</h3>
                                    <p className="text-gray-600 text-sm leading-relaxed">
                                        Grand Slipi Tower<br />
                                        Jl. Letjen S. Parman No.22-24<br />
                                        RT.1/RW.4, Palmerah<br />
                                        Kota Jakarta Barat<br />
                                        DKI Jakarta 11480
                                    </p>
                                    <a
                                        href="https://maps.google.com/?q=Grand+Slipi+Tower+Jakarta"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        className="inline-flex items-center gap-1 text-blue-600 hover:text-blue-700 text-sm font-medium mt-3"
                                    >
                                        Lihat di Google Maps →
                                    </a>
                                </div>
                            </div>
                        </div>

                        {/* Email */}
                        <div className="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
                            <div className="flex items-start gap-4">
                                <div className="p-3 bg-green-100 rounded-lg">
                                    <Mail className="w-6 h-6 text-green-600" />
                                </div>
                                <div>
                                    <h3 className="font-semibold text-gray-900 mb-2">Email</h3>
                                    <a
                                        href="mailto:ukomklinik@gmail.com"
                                        className="text-gray-600 hover:text-blue-600 transition-colors"
                                    >
                                        ukomklinik@gmail.com
                                    </a>
                                    <p className="text-sm text-gray-500 mt-2">
                                        Kami akan membalas dalam 1x24 jam
                                    </p>
                                </div>
                            </div>
                        </div>

                        {/* Phone/WhatsApp */}
                        <div className="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
                            <div className="flex items-start gap-4">
                                <div className="p-3 bg-emerald-100 rounded-lg">
                                    <Phone className="w-6 h-6 text-emerald-600" />
                                </div>
                                <div>
                                    <h3 className="font-semibold text-gray-900 mb-2">WhatsApp</h3>
                                    <a
                                        href="https://wa.me/6281295012668"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        className="text-gray-600 hover:text-green-600 transition-colors"
                                    >
                                        +62 812-3456-7890
                                    </a>
                                    <p className="text-sm text-gray-500 mt-2">
                                        Chat langsung dengan tim kami
                                    </p>
                                </div>
                            </div>
                        </div>

                        {/* Office Hours */}
                        <div className="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
                            <div className="flex items-start gap-4">
                                <div className="p-3 bg-purple-100 rounded-lg">
                                    <Clock className="w-6 h-6 text-purple-600" />
                                </div>
                                <div>
                                    <h3 className="font-semibold text-gray-900 mb-2">Jam Operasional</h3>
                                    <div className="text-sm text-gray-600 space-y-1">
                                        <p>Senin - Jumat: 08.00 - 17.00</p>
                                        <p>Sabtu: 08.00 - 14.00</p>
                                        <p className="text-gray-500">Minggu & Libur: Tutup</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {/* Contact Form */}
                    <div className="lg:col-span-2">
                        <div className="bg-white rounded-xl shadow-lg p-8">
                            <h2 className="text-2xl font-bold text-gray-900 mb-2">Kirim Pesan</h2>
                            <p className="text-gray-600 mb-6">
                                Punya pertanyaan? Isi form di bawah dan kami akan segera menghubungi Anda.
                            </p>

                            {success && (
                                <div className="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg flex items-center gap-2">
                                    <svg className="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fillRule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clipRule="evenodd" />
                                    </svg>
                                    Pesan Anda berhasil dikirim! Kami akan segera menghubungi Anda.
                                </div>
                            )}

                            <form onSubmit={handleSubmit} className="space-y-6">
                                <div className="grid md:grid-cols-2 gap-6">
                                    <div>
                                        <label htmlFor="name" className="block text-sm font-medium text-gray-700 mb-2">
                                            Nama Lengkap <span className="text-red-500">*</span>
                                        </label>
                                        <input
                                            type="text"
                                            id="name"
                                            name="name"
                                            value={formData.name}
                                            onChange={handleChange}
                                            required
                                            className="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            placeholder="Nama Anda"
                                        />
                                    </div>

                                    <div>
                                        <label htmlFor="email" className="block text-sm font-medium text-gray-700 mb-2">
                                            Email <span className="text-red-500">*</span>
                                        </label>
                                        <input
                                            type="email"
                                            id="email"
                                            name="email"
                                            value={formData.email}
                                            onChange={handleChange}
                                            required
                                            className="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            placeholder="email@example.com"
                                        />
                                    </div>
                                </div>

                                <div className="grid md:grid-cols-2 gap-6">
                                    <div>
                                        <label htmlFor="phone" className="block text-sm font-medium text-gray-700 mb-2">
                                            Nomor WhatsApp <span className="text-red-500">*</span>
                                        </label>
                                        <input
                                            type="tel"
                                            id="phone"
                                            name="phone"
                                            value={formData.phone}
                                            onChange={handleChange}
                                            required
                                            className="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            placeholder="08123456789"
                                        />
                                    </div>

                                    <div>
                                        <label htmlFor="subject" className="block text-sm font-medium text-gray-700 mb-2">
                                            Subjek <span className="text-red-500">*</span>
                                        </label>
                                        <select
                                            id="subject"
                                            name="subject"
                                            value={formData.subject}
                                            onChange={handleChange}
                                            required
                                            className="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                        >
                                            <option value="">Pilih subjek</option>
                                            <option value="program">Informasi Program</option>
                                            <option value="pendaftaran">Pendaftaran</option>
                                            <option value="biaya">Biaya & Pembayaran</option>
                                            <option value="jadwal">Jadwal Kelas</option>
                                            <option value="lainnya">Lainnya</option>
                                        </select>
                                    </div>
                                </div>

                                <div>
                                    <label htmlFor="message" className="block text-sm font-medium text-gray-700 mb-2">
                                        Pesan <span className="text-red-500">*</span>
                                    </label>
                                    <textarea
                                        id="message"
                                        name="message"
                                        value={formData.message}
                                        onChange={handleChange}
                                        required
                                        rows={6}
                                        className="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none"
                                        placeholder="Tulis pesan Anda di sini..."
                                    />
                                </div>

                                <button
                                    type="submit"
                                    disabled={loading}
                                    className="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-4 px-6 rounded-lg transition-colors disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2"
                                >
                                    {loading ? (
                                        <>
                                            <svg className="animate-spin h-5 w-5" viewBox="0 0 24 24">
                                                <circle className="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" strokeWidth="4" fill="none" />
                                                <path className="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z" />
                                            </svg>
                                            Mengirim...
                                        </>
                                    ) : (
                                        <>
                                            <Send className="w-5 h-5" />
                                            Kirim Pesan
                                        </>
                                    )}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                {/* Map Section */}
                <div className="mt-16 max-w-7xl mx-auto">
                    <div className="bg-white rounded-xl shadow-lg overflow-hidden">
                        <div className="aspect-video w-full">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.8697!2d106.7989!3d-6.1867!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f6f8c8c8c8c8%3A0x8c8c8c8c8c8c8c8c!2sGrand%20Slipi%20Tower!5e0!3m2!1sen!2sid!4v1234567890"
                                width="100%"
                                height="100%"
                                style={{ border: 0 }}
                                allowFullScreen
                                loading="lazy"
                                referrerPolicy="no-referrer-when-downgrade"
                                title="Lokasi Klinik UKOM"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}
