import { useState, useEffect } from "react";
import { useParams, useNavigate } from "react-router-dom";
import { 
  Clock, Award, Check, ArrowLeft, Star, 
  FileText, Target, TrendingUp, Shield, Play
} from "lucide-react";
import { Button } from "../components/ui/button";
import { Card, CardContent } from "../components/ui/card";
import { Badge } from "../components/ui/badge";
import { ImageWithFallback } from "../components/figma/ImageWithFallback";

interface Tryout {
  id: number;
  slug: string;
  title: string;
  description: string;
  image: string;
  duration?: string;
  questions?: string;
  price?: string;
  tag?: string;
  product_type: string;
  audience_type: string;
  features?: string | null;
  packages?: string | null;
  benefits?: string | null;
}

export function TryoutDetailPage() {
  const { slug } = useParams<{ slug: string }>();
  const navigate = useNavigate();
  const [tryout, setTryout] = useState<Tryout | null>(null);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    fetchTryout();
  }, [slug]);

  const fetchTryout = async () => {
    try {
      setLoading(true);
      const response = await fetch(`/api/public/program-details/${slug}`);
      
      if (!response.ok) {
        throw new Error('Try out not found');
      }
      
      const result = await response.json();
      const data = result.data || result;
      
      setTryout(data);
    } catch (error) {
      console.error("Error fetching tryout:", error);
      setTryout(null);
    } finally {
      setLoading(false);
    }
  };

  if (loading) {
    return (
      <div className="min-h-screen flex items-center justify-center">
        <div className="text-center">
          <div className="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mx-auto"></div>
          <p className="mt-4 text-muted-foreground">Memuat detail try out...</p>
        </div>
      </div>
    );
  }

  if (!tryout) {
    return (
      <div className="min-h-screen flex items-center justify-center">
        <div className="text-center">
          <h2 className="text-2xl font-bold mb-4">Try Out Tidak Ditemukan</h2>
          <Button onClick={() => navigate("/#programs")} className="bg-blue-600">
            <ArrowLeft className="mr-2" size={16} />
            Kembali ke Program
          </Button>
        </div>
      </div>
    );
  }

  // Parse features from JSON - no fallback
  let features: string[] = [];
  if (tryout.features) {
    try {
      const parsed = typeof tryout.features === 'string' ? JSON.parse(tryout.features) : tryout.features;
      if (Array.isArray(parsed) && parsed.length > 0) {
        features = parsed;
      }
    } catch (e) {
      console.error('Error parsing features:', e);
    }
  }

  // Parse packages from JSON - no fallback
  let tryoutPackages: any[] = [];
  if (tryout.packages) {
    try {
      const parsed = typeof tryout.packages === 'string' ? JSON.parse(tryout.packages) : tryout.packages;
      if (Array.isArray(parsed) && parsed.length > 0) {
        tryoutPackages = parsed;
      }
    } catch (e) {
      console.error('Error parsing packages:', e);
    }
  }

  const benefits = [
    {
      icon: Target,
      title: "Simulasi Ujian Nyata",
      description: "Interface dan sistem yang sama persis dengan ujian UKOM sesungguhnya"
    },
    {
      icon: TrendingUp,
      title: "Analisis Mendalam",
      description: "Laporan detail tentang kekuatan dan kelemahan Anda di setiap topik"
    },
    {
      icon: Shield,
      title: "Prediksi Kelulusan",
      description: "Sistem AI yang memprediksi peluang kelulusan Anda berdasarkan performa"
    },
    {
      icon: Award,
      title: "Ranking Nasional",
      description: "Bandingkan hasil Anda dengan ribuan peserta lain di seluruh Indonesia"
    }
  ];

  return (
    <div className="min-h-screen bg-gray-50">
      {/* Back Button */}
      <div className="bg-white border-b">
        <div className="container mx-auto px-4 lg:px-8 py-4">
          <button
            onClick={() => navigate("/#programs")}
            className="inline-flex items-center gap-2 text-blue-600 hover:text-blue-700 transition-colors"
          >
            <ArrowLeft size={20} />
            Kembali ke Program
          </button>
        </div>
      </div>

      {/* Hero Section */}
      <section className="bg-gradient-to-br from-blue-600 to-blue-800 text-white py-16">
        <div className="container mx-auto px-4 lg:px-8">
          <div className="grid lg:grid-cols-2 gap-12 items-center">
            {/* Info */}
            <div>
              {tryout.tag && (
                <Badge className="mb-4 bg-yellow-500 text-yellow-900 text-lg px-4 py-2">
                  {tryout.tag}
                </Badge>
              )}
              <h1 className="text-4xl lg:text-5xl font-bold mb-6">{tryout.title}</h1>
              <p className="text-xl text-blue-100 mb-8">{tryout.description}</p>

              {/* Quick Stats */}
              <div className="grid grid-cols-2 gap-4 mb-8">
                <div className="bg-white/10 backdrop-blur-sm p-4 rounded-lg">
                  <FileText className="text-blue-200 mb-2" size={32} />
                  <p className="text-2xl font-bold">{tryout.questions}</p>
                  <p className="text-blue-200 text-sm">Paket Try Out</p>
                </div>
                <div className="bg-white/10 backdrop-blur-sm p-4 rounded-lg">
                  <Clock className="text-blue-200 mb-2" size={32} />
                  <p className="text-2xl font-bold">{tryout.duration}</p>
                  <p className="text-blue-200 text-sm">Akses Penuh</p>
                </div>
              </div>

              {/* Price & CTA */}
              <div className="bg-white text-gray-900 p-6 rounded-xl">
                <div className="flex items-center justify-between mb-4">
                  <div>
                    <p className="text-gray-600 text-sm">Harga Spesial</p>
                    <p className="text-3xl font-bold text-blue-600">{tryout.price}</p>
                  </div>
                  <div className="text-right">
                    <p className="text-sm text-gray-500 line-through">Rp 400.000</p>
                    <Badge className="bg-red-500">Hemat 50%</Badge>
                  </div>
                </div>
                <Button className="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold text-lg py-6">
                  <Play className="mr-2" size={20} />
                  Mulai Try Out Sekarang
                </Button>
              </div>
            </div>

            {/* Image */}
            <div className="relative">
              <ImageWithFallback
                src={tryout.image}
                alt={tryout.title}
                className="w-full h-[500px] object-cover rounded-2xl shadow-2xl"
              />
              {/* Floating Stats */}
              <div className="absolute -bottom-6 left-6 right-6 bg-white p-4 rounded-xl shadow-lg">
                <div className="flex items-center justify-around">
                  <div className="text-center">
                    <p className="text-2xl font-bold text-blue-600">4.9</p>
                    <div className="flex items-center gap-1 justify-center">
                      {[1, 2, 3, 4, 5].map((star) => (
                        <Star key={star} size={14} className="fill-yellow-400 text-yellow-400" />
                      ))}
                    </div>
                    <p className="text-xs text-gray-600">Rating</p>
                  </div>
                  <div className="h-12 w-px bg-gray-200"></div>
                  <div className="text-center">
                    <p className="text-2xl font-bold text-blue-600">5,000+</p>
                    <p className="text-xs text-gray-600">Peserta</p>
                  </div>
                  <div className="h-12 w-px bg-gray-200"></div>
                  <div className="text-center">
                    <p className="text-2xl font-bold text-blue-600">95%</p>
                    <p className="text-xs text-gray-600">Lulus UKOM</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* Benefits Section */}
      <section className="py-16 bg-white mt-12">
        <div className="container mx-auto px-4 lg:px-8">
          <div className="text-center mb-12">
            <h2 className="text-3xl font-bold mb-4">Keunggulan Try Out Kami</h2>
            <p className="text-gray-600 max-w-2xl mx-auto">
              Sistem try out terlengkap dengan fitur-fitur canggih untuk persiapan UKOM yang maksimal
            </p>
          </div>
          <div className="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
            {benefits.map((benefit, index) => (
              <Card key={index} className="text-center hover:shadow-lg transition-shadow">
                <CardContent className="p-6">
                  <div className="inline-flex items-center justify-center w-16 h-16 bg-blue-100 rounded-full mb-4">
                    <benefit.icon className="text-blue-600" size={32} />
                  </div>
                  <h3 className="font-bold text-lg mb-2">{benefit.title}</h3>
                  <p className="text-gray-600 text-sm">{benefit.description}</p>
                </CardContent>
              </Card>
            ))}
          </div>
        </div>
      </section>

      {/* Features Section */}
      {features.length > 0 && (
        <section className="py-16">
          <div className="container mx-auto px-4 lg:px-8">
            <div className="max-w-4xl mx-auto">
              <h2 className="text-3xl font-bold mb-8">Yang Akan Anda Dapatkan</h2>
              <div className="grid md:grid-cols-2 gap-4">
                {features.map((feature: string, index: number) => (
                  <div key={index} className="flex items-start gap-3 p-4 bg-white rounded-lg border border-gray-200">
                    <Check className="text-green-600 flex-shrink-0 mt-1" size={20} />
                    <p className="text-gray-700">{feature}</p>
                  </div>
                ))}
              </div>
            </div>
          </div>
        </section>
      )}

      {/* Tryout Packages Section */}
      {tryoutPackages.length > 0 && (
        <section className="py-16 bg-white">
          <div className="container mx-auto px-4 lg:px-8">
            <div className="max-w-4xl mx-auto">
              <h2 className="text-3xl font-bold mb-8">Paket Try Out</h2>
              <div className="space-y-4">
                {tryoutPackages.map((pkg: any, index: number) => (
                  <Card key={index} className="hover:shadow-lg transition-shadow">
                    <CardContent className="p-6">
                      <div className="flex items-center gap-4">
                        <div className="flex items-center justify-center w-12 h-12 bg-blue-600 text-white rounded-lg font-bold flex-shrink-0">
                          {index + 1}
                        </div>
                        <div className="flex-1">
                          <h3 className="font-bold text-lg mb-1">{pkg.name}</h3>
                          <p className="text-gray-600">{pkg.topic}</p>
                        </div>
                        <div className="text-right">
                          <p className="text-sm text-gray-600">{pkg.questions} Soal</p>
                          <p className="text-sm text-gray-600">{pkg.duration}</p>
                        </div>
                      </div>
                    </CardContent>
                  </Card>
                ))}
              </div>
            </div>
          </div>
        </section>
      )}

      {/* CTA Section */}
      <section className="py-16 bg-gradient-to-br from-blue-600 to-blue-800 text-white">
        <div className="container mx-auto px-4 lg:px-8">
          <div className="max-w-3xl mx-auto text-center">
            <h2 className="text-3xl font-bold mb-4">
              Siap Mengukur Kemampuan Anda?
            </h2>
            <p className="text-xl text-blue-100 mb-8">
              Mulai try out sekarang dan ketahui seberapa siap Anda menghadapi UKOM
            </p>
            <div className="flex flex-col sm:flex-row gap-4 justify-center">
              <Button className="bg-white text-blue-600 hover:bg-blue-50 font-semibold text-lg px-8 py-6">
                <Play className="mr-2" size={20} />
                Mulai Try Out
              </Button>
              <Button className="bg-blue-700 text-white hover:bg-blue-800 font-semibold text-lg px-8 py-6 border-2 border-white/20">
                Lihat Demo
              </Button>
            </div>
            <p className="mt-6 text-blue-200 text-sm">
              * Garansi uang kembali 100% jika tidak puas
            </p>
          </div>
        </div>
      </section>
    </div>
  );
}
