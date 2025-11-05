import React, { useState } from 'react';
import { useNavigate } from 'react-router-dom';

const DaftarPage: React.FC = () => {
  const navigate = useNavigate();
  const [loading, setLoading] = useState(false);
  const [success, setSuccess] = useState(false);
  const [adminWhatsapp, setAdminWhatsapp] = useState('');
  const [formData, setFormData] = useState({
    nama: '',
    email: '',
    whatsapp: '',
    jenis_program: 'bimbel',
    pesan: '',
  });
  const [errors, setErrors] = useState<any>({});

  const handleChange = (e: React.ChangeEvent<HTMLInputElement | HTMLTextAreaElement | HTMLSelectElement>) => {
    const { name, value } = e.target;
    setFormData(prev => ({
      ...prev,
      [name]: value
    }));
    // Clear error when user types
    if (errors[name]) {
      setErrors((prev: any) => ({
        ...prev,
        [name]: undefined
      }));
    }
  };

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    setLoading(true);
    setErrors({});

    try {
      const response = await fetch('/api/public/formulir', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify(formData),
      });

      const data = await response.json();

      if (response.ok && data.success) {
        setSuccess(true);
        setAdminWhatsapp(data.admin_whatsapp || '');
        // Reset form
        setFormData({
          nama: '',
          email: '',
          whatsapp: '',
          jenis_program: 'bimbel',
          pesan: '',
        });
      } else {
        setErrors(data.errors || {});
      }
    } catch (error) {
      console.error('Error submitting form:', error);
      setErrors({ general: 'Terjadi kesalahan. Silakan coba lagi.' });
    } finally {
      setLoading(false);
    }
  };

  const handleWhatsAppContact = () => {
    if (adminWhatsapp) {
      const message = encodeURIComponent(`Halo, saya baru saja mengisi formulir pendaftaran ${formData.jenis_program}. Nama saya ${formData.nama}.`);
      window.open(`https://wa.me/${adminWhatsapp}?text=${message}`, '_blank');
    }
  };

  if (success) {
    return (
      <div className="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-12 px-4 sm:px-6 lg:px-8">
        <div className="max-w-md mx-auto">
          <div className="bg-white rounded-lg shadow-xl p-8 text-center">
            <div className="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100 mb-4">
              <svg className="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M5 13l4 4L19 7" />
              </svg>
            </div>
            <h2 className="text-2xl font-bold text-gray-900 mb-2">Pendaftaran Berhasil!</h2>
            <p className="text-gray-600 mb-6">
              Terima kasih telah mendaftar. Tim kami akan segera menghubungi Anda.
            </p>
            {adminWhatsapp && (
              <button
                onClick={handleWhatsAppContact}
                className="w-full bg-green-500 hover:bg-green-600 text-white font-semibold py-3 px-6 rounded-lg mb-3 flex items-center justify-center gap-2 transition-colors"
              >
                <svg className="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                </svg>
                Hubungi via WhatsApp
              </button>
            )}
            <button
              onClick={() => navigate('/')}
              className="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors"
            >
              Kembali ke Beranda
            </button>
          </div>
        </div>
      </div>
    );
  }

  return (
    <div className="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-12 px-4 sm:px-6 lg:px-8">
      <div className="max-w-2xl mx-auto">
        <div className="bg-white rounded-lg shadow-xl p-8">
          <div className="text-center mb-8">
            <h1 className="text-3xl font-bold text-gray-900 mb-2">Formulir Pendaftaran</h1>
            <p className="text-gray-600">Silakan lengkapi data Anda untuk mendaftar program kami</p>
          </div>

          <form onSubmit={handleSubmit} className="space-y-6">
            {errors.general && (
              <div className="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                {errors.general}
              </div>
            )}

            <div>
              <label htmlFor="nama" className="block text-sm font-medium text-gray-700 mb-2">
                Nama Lengkap <span className="text-red-500">*</span>
              </label>
              <input
                type="text"
                id="nama"
                name="nama"
                value={formData.nama}
                onChange={handleChange}
                className={`w-full px-4 py-3 border ${errors.nama ? 'border-red-500' : 'border-gray-300'} rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent`}
                placeholder="Masukkan nama lengkap Anda"
              />
              {errors.nama && <p className="mt-1 text-sm text-red-500">{errors.nama[0]}</p>}
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
                className={`w-full px-4 py-3 border ${errors.email ? 'border-red-500' : 'border-gray-300'} rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent`}
                placeholder="contoh@email.com"
              />
              {errors.email && <p className="mt-1 text-sm text-red-500">{errors.email[0]}</p>}
            </div>

            <div>
              <label htmlFor="whatsapp" className="block text-sm font-medium text-gray-700 mb-2">
                Nomor WhatsApp <span className="text-red-500">*</span>
              </label>
              <input
                type="text"
                id="whatsapp"
                name="whatsapp"
                value={formData.whatsapp}
                onChange={handleChange}
                className={`w-full px-4 py-3 border ${errors.whatsapp ? 'border-red-500' : 'border-gray-300'} rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent`}
                placeholder="08123456789"
              />
              {errors.whatsapp && <p className="mt-1 text-sm text-red-500">{errors.whatsapp[0]}</p>}
            </div>

            <div>
              <label htmlFor="jenis_program" className="block text-sm font-medium text-gray-700 mb-2">
                Jenis Program <span className="text-red-500">*</span>
              </label>
              <select
                id="jenis_program"
                name="jenis_program"
                value={formData.jenis_program}
                onChange={handleChange}
                className={`w-full px-4 py-3 border ${errors.jenis_program ? 'border-red-500' : 'border-gray-300'} rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent`}
              >
                <option value="bimbel">Bimbel</option>
                <option value="tryout">Try Out</option>
              </select>
              {errors.jenis_program && <p className="mt-1 text-sm text-red-500">{errors.jenis_program[0]}</p>}
            </div>

            <div>
              <label htmlFor="pesan" className="block text-sm font-medium text-gray-700 mb-2">
                Pesan (Opsional)
              </label>
              <textarea
                id="pesan"
                name="pesan"
                value={formData.pesan}
                onChange={handleChange}
                rows={4}
                className="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                placeholder="Tulis pesan atau pertanyaan Anda di sini..."
              />
            </div>

            <div className="flex gap-4">
              <button
                type="button"
                onClick={() => navigate(-1)}
                className="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold py-3 px-6 rounded-lg transition-colors"
              >
                Batal
              </button>
              <button
                type="submit"
                disabled={loading}
                className="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
              >
                {loading ? 'Mengirim...' : 'Daftar Sekarang'}
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  );
};

export default DaftarPage;
