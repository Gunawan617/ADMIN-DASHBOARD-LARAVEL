import { useState, useEffect } from "react";
import { Star, Calendar } from "lucide-react";
import { ImageWithFallback } from "../components/figma/ImageWithFallback";

interface Testimonial {
  id: number;
  name: string;
  batch: string | null;
  major: string | null;
  program: string | null;
  testimonial: string;
  photo: string | null;
  rating: number;
  approved_at: string;
}

export function TestimonialsPage() {
  const [testimonials, setTestimonials] = useState<Testimonial[]>([]);
  const [loading, setLoading] = useState(true);
  const [selectedFilter, setSelectedFilter] = useState<string | null>(null);

  useEffect(() => {
    fetchTestimonials();
  }, []);

  const fetchTestimonials = async () => {
    try {
      setLoading(true);
      const response = await fetch("/api/public/testimonials");
      const data = await response.json();

      if (data.success) {
        setTestimonials(data.data);
      }
    } catch (error) {
      console.error("Error fetching testimonials:", error);
    } finally {
      setLoading(false);
    }
  };

  const formatDate = (dateString: string) => {
    const date = new Date(dateString);
    return date.toLocaleDateString("id-ID", {
      month: "long",
      year: "numeric",
    });
  };

  const renderStars = (rating: number) => {
    return Array.from({ length: 5 }, (_, index) => (
      <Star
        key={index}
        size={16}
        className={index < rating ? "fill-yellow-400 text-yellow-400" : "text-gray-300"}
      />
    ));
  };

  const majors = Array.from(new Set(testimonials.map((t) => t.major).filter(Boolean)));

  const filteredTestimonials = selectedFilter
    ? testimonials.filter((t) => t.major === selectedFilter)
    : testimonials;

  if (loading) {
    return (
      <div className="min-h-screen flex items-center justify-center bg-gray-50">
        <div className="text-center">
          <div className="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mx-auto"></div>
          <p className="mt-4 text-muted-foreground">Memuat testimoni...</p>
        </div>
      </div>
    );
  }

  return (
    <div className="min-h-screen bg-white">
      {/* Hero Section */}
      <section className="bg-blue-600 text-white py-16">
        <div className="container mx-auto px-4 lg:px-8">
          <div className="max-w-3xl mx-auto text-center">
            <h1 className="text-3xl lg:text-4xl font-bold mb-4">
              Kata Mereka Tentang Klinik UKOM
            </h1>
            <p className="text-lg text-blue-100">
              Testimoni nyata dari alumni yang telah berhasil lulus UKOM bersama kami
            </p>
          </div>
        </div>
      </section>

      {/* Stats Section */}
      <section className="py-12 bg-white">
        <div className="container mx-auto px-4 lg:px-8">
          <div className="grid grid-cols-3 gap-8 max-w-3xl mx-auto">
            <div className="text-center">
              <div className="text-4xl font-bold text-blue-600 mb-1">
                {testimonials.length}+
              </div>
              <div className="text-sm text-gray-600">Alumni Puas</div>
            </div>
            <div className="text-center">
              <div className="text-4xl font-bold text-blue-600 mb-1">
                {(testimonials.reduce((acc, t) => acc + t.rating, 0) / testimonials.length || 5).toFixed(1)}
              </div>
              <div className="text-sm text-gray-600">Rating Rata-rata</div>
            </div>
            <div className="text-center">
              <div className="text-4xl font-bold text-blue-600 mb-1">95%</div>
              <div className="text-sm text-gray-600">Tingkat Kelulusan</div>
            </div>
          </div>
        </div>
      </section>

      {/* Filter Section */}
      <section className="py-6 bg-gray-50 border-y border-gray-200">
        <div className="container mx-auto px-4 lg:px-8">
          <div className="flex gap-3 justify-center">
            <button
              onClick={() => setSelectedFilter(null)}
              className={`px-6 py-2.5 rounded-full font-medium transition-all ${
                !selectedFilter
                  ? "bg-blue-600 text-white"
                  : "bg-white text-gray-700 hover:bg-gray-50"
              }`}
            >
              Semua
            </button>
            <button
              onClick={() => setSelectedFilter("Perawat")}
              className={`px-6 py-2.5 rounded-full font-medium transition-all ${
                selectedFilter === "Perawat"
                  ? "bg-blue-600 text-white"
                  : "bg-white text-gray-700 hover:bg-gray-50"
              }`}
            >
              Perawat
            </button>
            <button
              onClick={() => setSelectedFilter("Bidan")}
              className={`px-6 py-2.5 rounded-full font-medium transition-all ${
                selectedFilter === "Bidan"
                  ? "bg-blue-600 text-white"
                  : "bg-white text-gray-700 hover:bg-gray-50"
              }`}
            >
              Bidan
            </button>
          </div>
        </div>
      </section>

      {/* Testimonials Grid */}
      <section className="py-12 bg-gray-50">
        <div className="container mx-auto px-4 lg:px-8">
          {filteredTestimonials.length === 0 ? (
            <div className="text-center py-20">
              <p className="text-xl text-gray-500">
                Belum ada testimoni yang tersedia.
              </p>
            </div>
          ) : (
            <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-6 max-w-6xl mx-auto items-start">
              {filteredTestimonials.map((testimonial) => (
                <div
                  key={testimonial.id}
                  className="bg-white rounded-lg border border-gray-200 p-4"
                >
                  {/* Header */}
                  <div className="flex items-start gap-3 mb-3">
                    <div className="relative flex-shrink-0">
                      {testimonial.photo ? (
                        <ImageWithFallback
                          src={testimonial.photo}
                          alt={testimonial.name}
                          className="w-12 h-12 rounded-full object-cover"
                        />
                      ) : (
                        <div className="w-12 h-12 rounded-full bg-blue-600 flex items-center justify-center text-white text-lg font-semibold">
                          {testimonial.name.charAt(0)}
                        </div>
                      )}
                      <div className="absolute -bottom-0.5 -right-0.5 bg-blue-600 rounded-full p-0.5">
                        <svg className="w-2.5 h-2.5 text-white" fill="currentColor" viewBox="0 0 20 20">
                          <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                      </div>
                    </div>
                    <div className="flex-1 min-w-0">
                      <h3 className="font-semibold text-gray-900 text-sm">
                        {testimonial.name}
                      </h3>
                      <div className="flex items-center gap-1.5 mt-0.5 text-xs text-gray-500">
                        {testimonial.major && (
                          <span>{testimonial.major}</span>
                        )}
                        {testimonial.batch && testimonial.major && (
                          <span>•</span>
                        )}
                        {testimonial.batch && (
                          <span>Angkatan {testimonial.batch}</span>
                        )}
                      </div>
                      <div className="flex items-center gap-0.5 mt-1.5">
                        {renderStars(testimonial.rating)}
                      </div>
                    </div>
                  </div>

                  {/* Program Badge */}
                  {testimonial.program && (
                    <div className="mb-3">
                      <span className="inline-block text-xs font-medium text-blue-700 bg-blue-50 px-2.5 py-1 rounded">
                        {testimonial.program}
                      </span>
                    </div>
                  )}

                  {/* Testimonial Text */}
                  <div className="mb-3">
                    <p className="text-gray-700 text-sm leading-relaxed">
                      "{testimonial.testimonial}"
                    </p>
                  </div>

                  {/* Date */}
                  <div className="flex items-center gap-1.5 text-xs text-gray-400 pt-3 border-t border-gray-100">
                    <Calendar size={12} />
                    <span>{formatDate(testimonial.approved_at)}</span>
                  </div>
                </div>
              ))}
            </div>
          )}
        </div>
      </section>

      {/* CTA Section */}
      <section className="bg-blue-600 text-white py-16">
        <div className="container mx-auto px-4 lg:px-8">
          <div className="max-w-3xl mx-auto text-center">
            <h2 className="text-2xl font-bold mb-3">
              Ingin Menjadi Bagian dari Kisah Sukses Kami?
            </h2>
            <p className="text-lg text-blue-100 mb-6">
              Bergabunglah dengan ribuan alumni yang telah berhasil lulus UKOM
            </p>
            <div className="flex flex-col sm:flex-row gap-3 justify-center">
              <a
                href="/#programs"
                className="inline-block px-6 py-3 bg-white text-blue-600 rounded-lg font-medium hover:bg-blue-50 transition-colors"
              >
                Lihat Program Kami
              </a>
              <a
                href="/submit-testimonial"
                className="inline-block px-6 py-3 bg-blue-700 text-white rounded-lg font-medium hover:bg-blue-800 transition-colors"
              >
                Kirim Testimoni Anda
              </a>
            </div>
          </div>
        </div>
      </section>
    </div>
  );
}
