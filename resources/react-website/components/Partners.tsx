export function Partners() {
  const hospitals = [
    "RSUP Dr. Sardjito", "RS Siloam", "RS Hermina", "RSUD Tangerang", "RS Premier", 
    "RSCM", "RS Mitra Keluarga", "RS Harapan Kita", "RS Pondok Indah", "RS Mayapada"
  ];

  return (
    <section id="partners" className="py-20 bg-gradient-to-b from-blue-50 to-white">
      <div className="container mx-auto px-4 lg:px-8">
        {/* Header */}
        <div className="text-center max-w-3xl mx-auto mb-16">
          <h2 className="text-3xl lg:text-4xl mb-4">Rumah Sakit Mitra Kami</h2>
          <p className="text-lg text-muted-foreground">
            Alumni kami bekerja di berbagai rumah sakit terkemuka di Indonesia.
          </p>
        </div>

        {/* Companies Grid */}
        <div className="grid grid-cols-2 md:grid-cols-5 gap-8 items-center">
          {hospitals.map((hospital, index) => (
            <div
              key={index}
              className="flex items-center justify-center p-6 bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow"
            >
              <span className="text-sm text-center text-muted-foreground">{hospital}</span>
            </div>
          ))}
        </div>

        {/* CTA Section */}
        <div className="mt-20 bg-blue-600 rounded-2xl p-12 text-center text-white">
          <h3 className="text-2xl lg:text-3xl mb-4">Siap Memulai Persiapan UKOM?</h3>
          <p className="text-lg mb-8 opacity-90">
            Daftar sekarang dan bergabung dengan batch berikutnya. Raih STR Anda bersama kami!
          </p>
          <div className="flex flex-col sm:flex-row gap-4 justify-center">
            <button className="px-8 py-3 bg-white text-blue-600 rounded-lg hover:bg-gray-100 transition-colors">
              Lihat Program
            </button>
            <button className="px-8 py-3 border-2 border-white text-white rounded-lg hover:bg-white/10 transition-colors">
              Konsultasi Gratis
            </button>
          </div>
        </div>
      </div>
    </section>
  );
}
