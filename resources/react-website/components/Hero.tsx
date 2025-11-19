import { Button } from "./ui/button";
import { ArrowRight, Play } from "lucide-react";
import { ImageWithFallback } from "./figma/ImageWithFallback";
import { useNavigate } from "react-router-dom";
import { useState, useEffect } from "react";

interface HeroData {
  badge_text: string;
  title: string;
  description: string;
  primary_button_text: string;
  primary_button_link: string;
  secondary_button_text: string;
  secondary_button_link: string | null;
  image_url: string;
  stat1_value: string;
  stat1_label: string;
  stat2_value: string;
  stat2_label: string;
  stat3_value: string;
  stat3_label: string;
  floating_card_text: string;
  floating_card_value: string;
}

export function Hero() {
  const navigate = useNavigate();
  const [heroData, setHeroData] = useState<HeroData | null>(null);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    fetch('/api/public/hero-section')
      .then(res => res.json())
      .then(data => {
        setHeroData(data);
        setLoading(false);
      })
      .catch(err => {
        console.error('Failed to load hero section:', err);
        setLoading(false);
      });
  }, []);

  // Default fallback data
  const defaultData: HeroData = {
    badge_text: "Dipercaya 5,000+ Peserta",
    title: "Temani perjalananmu menuju kompeten 1x ujian",
    description: "Persiapan lengkap Uji Kompetensi untuk Perawat dan Bidan. Bimbingan intensif dengan materi terkini, try out berkala, dan pendampingan hingga lulus.",
    primary_button_text: "Daftar Sekarang",
    primary_button_link: "/daftar",
    secondary_button_text: "Video Penjelasan",
    secondary_button_link: null,
    image_url: "https://images.unsplash.com/photo-1676552055618-22ec8cde399a?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxudXJzZSUyMHN0dWR5aW5nJTIwbWVkaWNhbHxlbnwxfHx8fDE3NjIxNDMyMTV8MA&ixlib=rb-4.1.0&q=80&w=1080&utm_source=figma&utm_medium=referral",
    stat1_value: "92%",
    stat1_label: "Tingkat Kelulusan",
    stat2_value: "100+",
    stat2_label: "Rumah Sakit Mitra",
    stat3_value: "4.8/5",
    stat3_label: "Rating Peserta",
    floating_card_text: "Peserta Lulus",
    floating_card_value: "92% Berhasil"
  };

  const data = heroData || defaultData;
  const imageUrl = heroData?.image_url.startsWith('http')
    ? heroData.image_url
    : `/storage/${heroData?.image_url || defaultData.image_url}`;

  if (loading) {
    return (
      <section className="relative overflow-hidden bg-gradient-to-b from-blue-50 to-white py-20 lg:py-32">
        <div className="container mx-auto px-4 lg:px-8">
          <div className="animate-pulse">
            <div className="h-8 bg-gray-200 rounded w-1/3 mb-4"></div>
            <div className="h-12 bg-gray-200 rounded w-2/3 mb-4"></div>
            <div className="h-6 bg-gray-200 rounded w-full"></div>
          </div>
        </div>
      </section>
    );
  }

  return (
    <section className="relative overflow-hidden bg-gradient-to-b from-blue-50 to-white pt-16 lg:pt-24 pb-20 lg:pb-40">
      {/* Background Pattern */}
      <div className="absolute inset-0 opacity-10 pointer-events-none">
        <div className="absolute top-0 left-1/4 w-96 h-96 bg-blue-600 rounded-full blur-3xl"></div>
        <div className="absolute bottom-0 right-1/4 w-96 h-96 bg-blue-400 rounded-full blur-3xl"></div>
      </div>

      <div className="container mx-auto px-4 lg:px-8 relative">
        <div className="grid lg:grid-cols-2 gap-12">
          {/* Left Content */}
          <div className="space-y-8 lg:max-w-xl z-10 relative">
            <div className="inline-flex items-center gap-2 px-4 py-2 bg-blue-100 text-blue-700 rounded-full">
              <span className="w-2 h-2 bg-blue-600 rounded-full animate-pulse"></span>
              <span className="text-sm">{data.badge_text}</span>
            </div>

            <div className="space-y-4">
              <h1 className="text-4xl lg:text-5xl xl:text-6xl font-bold font-poppins">
                {data.title}
              </h1>
              <p className="text-[21px] text-muted-foreground">
                {data.description}
              </p>
            </div>

            <div className="flex flex-col sm:flex-row gap-4 mt-12">
              <Button
                size="lg"
                onClick={() => navigate(data.primary_button_link)}
                className="bg-blue-600 hover:bg-blue-700 text-lg px-8 py-6 shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all font-bold"
              >
                {data.primary_button_text}
                <ArrowRight className="ml-2" size={24} />
              </Button>
              {data.secondary_button_text && (
                <Button
                  size="lg"
                  variant="outline"
                  className="gap-2 text-lg px-8 py-6 shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all font-bold border-2"
                  onClick={() => data.secondary_button_link && window.open(data.secondary_button_link, '_blank')}
                >
                  <Play size={24} />
                  {data.secondary_button_text}
                </Button>
              )}
            </div>

            {/* Stats */}
            <div className="grid grid-cols-3 gap-6 pt-8">
              <div>
                <div className="text-3xl">{data.stat1_value}</div>
                <p className="text-sm text-muted-foreground">{data.stat1_label}</p>
              </div>
              <div>
                <div className="text-3xl">{data.stat2_value}</div>
                <p className="text-sm text-muted-foreground">{data.stat2_label}</p>
              </div>
              <div>
                <div className="text-3xl">{data.stat3_value}</div>
                <p className="text-sm text-muted-foreground">{data.stat3_label}</p>
              </div>
            </div>
          </div>

          {/* Right Image - Positioned Lower */}
          <div className="relative lg:absolute lg:right-0 lg:-top-40 lg:w-[58%] lg:max-w-3xl">
            <div className="relative mt-8 lg:mt-0">
              <ImageWithFallback
                src={imageUrl}
                alt="Hero Image"
                className="w-full h-auto object-cover object-right rounded-lg"
              />
              {/* Floating Card */}
              {/* <div className="absolute -bottom-6 lg:-bottom-8 -left-4 lg:-left-6 bg-white p-4 lg:p-6 rounded-xl shadow-lg border z-10">
                <div className="flex items-center gap-4">
                  <div className="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                    <span className="text-2xl">✓</span>
                  </div>
                  <div>
                    <p className="text-sm text-muted-foreground">{data.floating_card_text}</p>
                    <div className="text-xl">{data.floating_card_value}</div>
                  </div>
                </div>
              </div> */}
            </div>
          </div>
        </div>
      </div>
    </section>
  );
}