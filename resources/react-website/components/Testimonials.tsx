import { useState, useEffect } from "react";
import { ChevronLeft, ChevronRight } from "lucide-react";

interface Testimonial {
  id: number;
  name: string;
  batch?: string;
  major?: string;
  program: string;
  testimonial: string;
  rating: number;
  photo?: string;
}

export function Testimonials() {
  const [testimonials, setTestimonials] = useState<Testimonial[]>([]);
  const [currentIndex, setCurrentIndex] = useState(0);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    const fetchTestimonials = async () => {
      try {
        const response = await fetch('/api/public/testimonials');
        const data = await response.json();
        setTestimonials(data.data || data);
      } catch (error) {
        console.error('Error fetching testimonials:', error);
      } finally {
        setLoading(false);
      }
    };

    fetchTestimonials();
  }, []);

  const nextTestimonial = () => {
    setCurrentIndex((prev) => (prev + 1) % testimonials.length);
  };

  const prevTestimonial = () => {
    setCurrentIndex((prev) => (prev - 1 + testimonials.length) % testimonials.length);
  };

  if (loading) {
    return (
      <section className="py-20 bg-blue-50">
        <div className="container mx-auto px-4">
          <div className="text-center">
            <div className="inline-block animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"></div>
          </div>
        </div>
      </section>
    );
  }

  if (testimonials.length === 0) {
    return null;
  }

  const currentTestimonial = testimonials[currentIndex];

  return (
    <section className="py-20 bg-gradient-to-br from-blue-50 to-indigo-50">
      <div className="container mx-auto px-4 max-w-5xl">
        {/* Header */}
        <div className="text-center mb-12">
          <p className="text-blue-600 font-semibold mb-2">Alumni Kami</p>
          <h2 className="text-3xl lg:text-4xl font-bold text-gray-800">
            Cek apa kata mereka Tentang Klinik Ukom
          </h2>
        </div>

        {/* Testimonial Card */}
        <div className="bg-white rounded-2xl shadow-xl p-8 md:p-12">
          <div className="flex flex-col md:flex-row gap-8 items-start">
            {/* Left Side - Profile */}
            <div className="flex-shrink-0 text-center md:text-left">
              <div className="w-24 h-24 mx-auto md:mx-0 mb-4 rounded-full overflow-hidden bg-gradient-to-br from-blue-400 to-indigo-500 flex items-center justify-center">
                {currentTestimonial.photo ? (
                  <img 
                    src={currentTestimonial.photo} 
                    alt={currentTestimonial.name}
                    className="w-full h-full object-cover"
                  />
                ) : (
                  <span className="text-3xl font-bold text-white">
                    {currentTestimonial.name.charAt(0)}
                  </span>
                )}
              </div>
              <h3 className="font-bold text-lg text-blue-600 mb-1">
                {currentTestimonial.name}
              </h3>
              <p className="text-sm text-gray-600 mb-1">{currentTestimonial.program}</p>
              {currentTestimonial.batch && (
                <p className="text-sm text-gray-500">Batch {currentTestimonial.batch}</p>
              )}
              {currentTestimonial.major && (
                <p className="text-sm text-gray-500">{currentTestimonial.major}</p>
              )}
              
              {/* Rating Stars */}
              <div className="flex gap-1 justify-center md:justify-start mt-3">
                {[...Array(5)].map((_, i) => (
                  <svg
                    key={i}
                    className={`w-5 h-5 ${
                      i < currentTestimonial.rating ? 'text-yellow-400' : 'text-gray-300'
                    }`}
                    fill="currentColor"
                    viewBox="0 0 20 20"
                  >
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                  </svg>
                ))}
              </div>
            </div>

            {/* Right Side - Message */}
            <div className="flex-1">
              <div className="text-6xl text-blue-200 leading-none mb-4">"</div>
              <p className="text-gray-700 leading-relaxed text-base md:text-lg">
                {currentTestimonial.testimonial}
              </p>
            </div>
          </div>
        </div>

        {/* Navigation */}
        <div className="flex items-center justify-center gap-4 mt-8">
          {/* Dots */}
          <div className="flex gap-2">
            {testimonials.map((_, index) => (
              <button
                key={index}
                onClick={() => setCurrentIndex(index)}
                className={`w-2 h-2 rounded-full transition-all ${
                  index === currentIndex 
                    ? 'bg-blue-600 w-8' 
                    : 'bg-blue-200 hover:bg-blue-300'
                }`}
                aria-label={`Go to testimonial ${index + 1}`}
              />
            ))}
          </div>

          {/* Arrow Buttons */}
          <div className="flex gap-2">
            <button
              onClick={prevTestimonial}
              className="w-10 h-10 rounded-full bg-white border-2 border-blue-600 text-blue-600 hover:bg-blue-600 hover:text-white transition-colors flex items-center justify-center"
              aria-label="Previous testimonial"
            >
              <ChevronLeft size={20} />
            </button>
            <button
              onClick={nextTestimonial}
              className="w-10 h-10 rounded-full bg-white border-2 border-blue-600 text-blue-600 hover:bg-blue-600 hover:text-white transition-colors flex items-center justify-center"
              aria-label="Next testimonial"
            >
              <ChevronRight size={20} />
            </button>
          </div>
        </div>
      </div>
    </section>
  );
}
