import { Link } from "react-router-dom";
import { useState, useEffect } from "react";
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from "./ui/card";
import { Button } from "./ui/button";
import { Badge } from "./ui/badge";
import { Clock, Users, Award, BookOpen, DollarSign } from "lucide-react";
import { ImageWithFallback } from "./figma/ImageWithFallback";
import type { ProductType, AudienceType } from "./ProductSwitcher";

interface Program {
  id: number;
  slug: string;
  title: string;
  description: string;
  image: string;
  duration?: string;
  students?: string;
  level?: string;
  price?: string;
  pages?: string;
  questions?: string;
  tag: string;
  productType: ProductType;
  audienceType: AudienceType;
}

const allPrograms: Program[] = [
  // Bimbel - Perawat
  {
    id: 1,
    slug: "bimbel-ukom-perawat-reguler",
    title: "Bimbel UKOM Perawat Reguler",
    description: "Program persiapan lengkap UKOM untuk perawat dengan materi komprehensif, latihan soal, dan try out berkala.",
    image: "https://images.unsplash.com/photo-1725870475677-7dc91efe9f93?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxudXJzaW5nJTIwZWR1Y2F0aW9ufGVufDF8fHx8MTc2MjE0MzIxNnww&ixlib=rb-4.1.0&q=80&w=1080&utm_source=figma&utm_medium=referral",
    duration: "2 Bulan",
    students: "3,200+",
    level: "Semua Level",
    price: "Rp 850.000",
    tag: "Paling Populer",
    productType: "bimbel",
    audienceType: "nurse"
  },
  {
    id: 2,
    slug: "bimbel-ukom-perawat-intensif",
    title: "Bimbel UKOM Perawat Intensif",
    description: "Program intensif dengan bimbingan mentor pribadi, kelas kecil, dan pendampingan hingga lulus UKOM.",
    image: "https://images.unsplash.com/photo-1652787544912-137c7f92f99b?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxtZWRpY2FsJTIwdGV4dGJvb2slMjBzdHVkeXxlbnwxfHx8fDE3NjIxNDMyMTZ8MA&ixlib=rb-4.1.0&q=80&w=1080&utm_source=figma&utm_medium=referral",
    duration: "1 Bulan",
    students: "1,500+",
    level: "Intensif",
    price: "Rp 1.200.000",
    tag: "Batch Baru",
    productType: "bimbel",
    audienceType: "nurse"
  },
  // Bimbel - Bidan
  {
    id: 3,
    slug: "bimbel-ukom-bidan-reguler",
    title: "Bimbel UKOM Bidan Reguler",
    description: "Persiapan UKOM khusus bidan dengan materi terkini, simulasi ujian, dan pembahasan kasus klinis.",
    image: "https://images.unsplash.com/photo-1560306990-18fa759c8713?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxtaWR3aWZlJTIwaGVhbHRoY2FyZXxlbnwxfHx8fDE3NjIwNjQxMTh8MA&ixlib=rb-4.1.0&q=80&w=1080&utm_source=figma&utm_medium=referral",
    duration: "2 Bulan",
    students: "2,800+",
    level: "Semua Level",
    price: "Rp 800.000",
    tag: "",
    productType: "bimbel",
    audienceType: "midwife"
  },
  {
    id: 4,
    slug: "bimbel-ukom-bidan-intensif",
    title: "Bimbel UKOM Bidan Intensif",
    description: "Program super intensif untuk bidan dengan target lulus cepat, materi ringkas, dan drilling soal.",
    image: "https://images.unsplash.com/photo-1576670160060-c4e874631c5a?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxtZWRpY2FsJTIwcHJvZmVzc2lvbmFsJTIwbGVhcm5pbmd8ZW58MXx8fHwxNzYyMTQzMjE3fDA&ixlib=rb-4.1.0&q=80&w=1080&utm_source=figma&utm_medium=referral",
    duration: "1 Bulan",
    students: "1,200+",
    level: "Intensif",
    price: "Rp 1.100.000",
    tag: "",
    productType: "bimbel",
    audienceType: "midwife"
  },
  // Books - Perawat
  {
    id: 5,
    slug: "buku-ukom-perawat-lengkap",
    title: "Buku UKOM Perawat Lengkap",
    description: "Buku panduan lengkap UKOM perawat dengan ringkasan materi, contoh soal, dan pembahasan detail.",
    image: "https://images.unsplash.com/photo-1652787544912-137c7f92f99b?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxtZWRpY2FsJTIwdGV4dGJvb2slMjBzdHVkeXxlbnwxfHx8fDE3NjIxNDMyMTZ8MA&ixlib=rb-4.1.0&q=80&w=1080&utm_source=figma&utm_medium=referral",
    pages: "500+ Halaman",
    questions: "1,000+ Soal",
    price: "Rp 150.000",
    tag: "Best Seller",
    productType: "books",
    audienceType: "nurse"
  },
  {
    id: 6,
    slug: "buku-soal-ukom-perawat",
    title: "Buku Soal UKOM Perawat",
    description: "Kumpulan soal UKOM perawat dengan pembahasan lengkap dari berbagai topik sesuai blueprint terbaru.",
    image: "https://images.unsplash.com/photo-1652787544912-137c7f92f99b?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxtZWRpY2FsJTIwdGV4dGJvb2slMjBzdHVkeXxlbnwxfHx8fDE3NjIxNDMyMTZ8MA&ixlib=rb-4.1.0&q=80&w=1080&utm_source=figma&utm_medium=referral",
    pages: "300+ Halaman",
    questions: "1,500+ Soal",
    price: "Rp 120.000",
    tag: "",
    productType: "books",
    audienceType: "nurse"
  },
  // Books - Bidan
  {
    id: 7,
    slug: "buku-ukom-bidan-lengkap",
    title: "Buku UKOM Bidan Lengkap",
    description: "Buku panduan lengkap UKOM bidan dengan materi esensial, latihan soal, dan kunci jawaban.",
    image: "https://images.unsplash.com/photo-1652787544912-137c7f92f99b?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxtZWRpY2FsJTIwdGV4dGJvb2slMjBzdHVkeXxlbnwxfHx8fDE3NjIxNDMyMTZ8MA&ixlib=rb-4.1.0&q=80&w=1080&utm_source=figma&utm_medium=referral",
    pages: "450+ Halaman",
    questions: "900+ Soal",
    price: "Rp 140.000",
    tag: "Best Seller",
    productType: "books",
    audienceType: "midwife"
  },
  {
    id: 8,
    slug: "buku-soal-ukom-bidan",
    title: "Buku Soal UKOM Bidan",
    description: "Bank soal UKOM bidan dengan pembahasan komprehensif untuk persiapan ujian yang maksimal.",
    image: "https://images.unsplash.com/photo-1652787544912-137c7f92f99b?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxtZWRpY2FsJTIwdGV4dGJvb2slMjBzdHVkeXxlbnwxfHx8fDE3NjIxNDMyMTZ8MA&ixlib=rb-4.1.0&q=80&w=1080&utm_source=figma&utm_medium=referral",
    pages: "280+ Halaman",
    questions: "1,200+ Soal",
    price: "Rp 110.000",
    tag: "",
    productType: "books",
    audienceType: "midwife"
  },
  // Try Out - Perawat
  {
    id: 9,
    slug: "try-out-ukom-perawat-premium",
    title: "Try Out UKOM Perawat Premium",
    description: "Paket try out online dengan sistem CBT mirip ujian sesungguhnya, pembahasan lengkap, dan analisis hasil.",
    image: "https://images.unsplash.com/photo-1725870475677-7dc91efe9f93?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxudXJzaW5nJTIwZWR1Y2F0aW9ufGVufDF8fHx8MTc2MjE0MzIxNnww&ixlib=rb-4.1.0&q=80&w=1080&utm_source=figma&utm_medium=referral",
    questions: "10x Try Out",
    duration: "3 Bulan Akses",
    price: "Rp 200.000",
    tag: "Unlimited",
    productType: "tryout",
    audienceType: "nurse"
  },
  {
    id: 10,
    slug: "try-out-ukom-perawat-basic",
    title: "Try Out UKOM Perawat Basic",
    description: "Paket try out dasar untuk perawat dengan soal-soal pilihan sesuai blueprint UKOM terkini.",
    image: "https://images.unsplash.com/photo-1725870475677-7dc91efe9f93?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxudXJzaW5nJTIwZWR1Y2F0aW9ufGVufDF8fHx8MTc2MjE0MzIxNnww&ixlib=rb-4.1.0&q=80&w=1080&utm_source=figma&utm_medium=referral",
    questions: "5x Try Out",
    duration: "1 Bulan Akses",
    price: "Rp 100.000",
    tag: "",
    productType: "tryout",
    audienceType: "nurse"
  },
  // Try Out - Bidan
  {
    id: 11,
    slug: "try-out-ukom-bidan-premium",
    title: "Try Out UKOM Bidan Premium",
    description: "Paket try out online untuk bidan dengan simulasi ujian lengkap dan evaluasi hasil yang mendetail.",
    image: "https://images.unsplash.com/photo-1560306990-18fa759c8713?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxtaWR3aWZlJTIwaGVhbHRoY2FyZXxlbnwxfHx8fDE3NjIwNjQxMTh8MA&ixlib=rb-4.1.0&q=80&w=1080&utm_source=figma&utm_medium=referral",
    questions: "10x Try Out",
    duration: "3 Bulan Akses",
    price: "Rp 180.000",
    tag: "Unlimited",
    productType: "tryout",
    audienceType: "midwife"
  },
  {
    id: 12,
    slug: "try-out-ukom-bidan-basic",
    title: "Try Out UKOM Bidan Basic",
    description: "Paket try out dasar untuk bidan dengan soal-soal esensial dan pembahasan singkat.",
    image: "https://images.unsplash.com/photo-1560306990-18fa759c8713?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxtaWR3aWZlJTIwaGVhbHRoY2FyZXxlbnwxfHx8fDE3NjIwNjQxMTh8MA&ixlib=rb-4.1.0&q=80&w=1080&utm_source=figma&utm_medium=referral",
    questions: "5x Try Out",
    duration: "1 Bulan Akses",
    price: "Rp 90.000",
    tag: "",
    productType: "tryout",
    audienceType: "midwife"
  },
  // Video - Perawat
  {
    id: 13,
    slug: "video-pembelajaran-ukom-perawat",
    title: "Video Pembelajaran UKOM Perawat",
    description: "Koleksi video pembelajaran lengkap dengan penjelasan materi UKOM perawat dari ahli.",
    image: "https://images.unsplash.com/photo-1576670160060-c4e874631c5a?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxtZWRpY2FsJTIwcHJvZmVzc2lvbmFsJTIwbGVhcm5pbmd8ZW58MXx8fHwxNzYyMTQzMjE3fDA&ixlib=rb-4.1.0&q=80&w=1080&utm_source=figma&utm_medium=referral",
    duration: "50+ Video",
    level: "HD Quality",
    price: "Rp 250.000",
    tag: "Lengkap",
    productType: "video",
    audienceType: "nurse"
  },
  {
    id: 14,
    slug: "video-ringkas-ukom-perawat",
    title: "Video Ringkas UKOM Perawat",
    description: "Video ringkasan materi penting UKOM perawat untuk belajar cepat dan efisien.",
    image: "https://images.unsplash.com/photo-1576670160060-c4e874631c5a?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxtZWRpY2FsJTIwcHJvZmVzc2lvbmFsJTIwbGVhcm5pbmd8ZW58MXx8fHwxNzYyMTQzMjE3fDA&ixlib=rb-4.1.0&q=80&w=1080&utm_source=figma&utm_medium=referral",
    duration: "20+ Video",
    level: "HD Quality",
    price: "Rp 150.000",
    tag: "",
    productType: "video",
    audienceType: "nurse"
  },
  // Video - Bidan
  {
    id: 15,
    slug: "video-pembelajaran-ukom-bidan",
    title: "Video Pembelajaran UKOM Bidan",
    description: "Koleksi video pembelajaran komprehensif dengan materi UKOM bidan dari praktisi berpengalaman.",
    image: "https://images.unsplash.com/photo-1576670160060-c4e874631c5a?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxtZWRpY2FsJTIwcHJvZmVzc2lvbmFsJTIwbGVhcm5pbmd8ZW58MXx8fHwxNzYyMTQzMjE3fDA&ixlib=rb-4.1.0&q=80&w=1080&utm_source=figma&utm_medium=referral",
    duration: "45+ Video",
    level: "HD Quality",
    price: "Rp 230.000",
    tag: "Lengkap",
    productType: "video",
    audienceType: "midwife"
  },
  {
    id: 16,
    slug: "video-ringkas-ukom-bidan",
    title: "Video Ringkas UKOM Bidan",
    description: "Video ringkasan materi esensial UKOM bidan untuk pembelajaran yang efektif dan tepat sasaran.",
    image: "https://images.unsplash.com/photo-1576670160060-c4e874631c5a?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxtZWRpY2FsJTIwcHJvZmVzc2lvbmFsJTIwbGVhcm5pbmd8ZW58MXx8fHwxNzYyMTQzMjE3fDA&ixlib=rb-4.1.0&q=80&w=1080&utm_source=figma&utm_medium=referral",
    duration: "18+ Video",
    level: "HD Quality",
    price: "Rp 140.000",
    tag: "",
    productType: "video",
    audienceType: "midwife"
  }
];

interface ProgramsProps {
  selectedProduct: ProductType;
  selectedAudience: AudienceType;
  onProductChange: (product: ProductType) => void;
  onAudienceChange: (audience: AudienceType) => void;
}

export function Programs({ selectedProduct, selectedAudience, onProductChange, onAudienceChange }: ProgramsProps) {
  const [programs, setPrograms] = useState<Program[]>([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState<string | null>(null);

  useEffect(() => {
    const fetchPrograms = async () => {
      try {
        setLoading(true);
        const response = await fetch('/api/public/program-details');
        if (!response.ok) {
          throw new Error('Failed to fetch programs');
        }
        const result = await response.json();
        const data = result.data || result; // Handle both {data: [...]} and [...] formats
        
        // Transform API data to match Program interface
        const transformedPrograms: Program[] = data.map((item: any) => ({
          id: item.id,
          slug: item.slug,
          title: item.title,
          description: item.description,
          image: item.image?.startsWith('http') ? item.image : `https://images.unsplash.com/photo-1725870475677-7dc91efe9f93?w=1080`,
          duration: item.duration || undefined,
          students: item.students || undefined,
          level: item.level || undefined,
          price: item.price || undefined,
          pages: item.pages || undefined,
          questions: item.questions || undefined,
          tag: item.tag || '',
          productType: item.product_type as ProductType,
          audienceType: item.audience_type as AudienceType,
        }));
        
        setPrograms(transformedPrograms);
        setError(null);
      } catch (err) {
        console.error('Error fetching programs:', err);
        setError('Gagal memuat data program');
        // Fallback to dummy data if API fails
        setPrograms(allPrograms);
      } finally {
        setLoading(false);
      }
    };

    fetchPrograms();
  }, []);

  const filteredPrograms = programs.filter(
    (program) =>
      program.productType === selectedProduct &&
      program.audienceType === selectedAudience
  );

  const getProductTitle = () => {
    const titles = {
      bimbel: "Program Bimbel",
      tryout: "Paket Try Out"
    };
    return titles[selectedProduct];
  };

  const getAudienceTitle = () => {
    return selectedAudience === "nurse" ? "Perawat" : "Bidan";
  };

  const products = [
    { id: "bimbel" as ProductType, label: "Bimbel", icon: "🎓" },
    { id: "tryout" as ProductType, label: "Try Out", icon: "📝" },
  ];

  return (
    <section id="programs" className="py-20 bg-white">
      <div className="container mx-auto px-4 lg:px-8">
        {/* Header */}
        <div className="text-center max-w-3xl mx-auto mb-8">
          <h2 className="text-3xl lg:text-4xl mb-4">
            Produk & Program UKOM
          </h2>
          <p className="text-lg text-muted-foreground">
            Pilihan terbaik untuk persiapan UKOM Anda dengan tingkat kelulusan tinggi.
          </p>
        </div>

        {/* Product Switcher - Integrated */}
        <div className="max-w-4xl mx-auto mb-12">
          {/* Product Type Selector */}
          <div className="flex flex-col gap-6">
            <div className="flex justify-center">
              <div className="inline-flex bg-gray-100 rounded-xl p-1.5 gap-1">
                {products.map((product) => (
                  <button
                    key={product.id}
                    onClick={() => onProductChange(product.id)}
                    className={`px-8 py-3 rounded-lg font-medium transition-all duration-200 ${
                      selectedProduct === product.id
                        ? "bg-white text-blue-600 shadow-md"
                        : "text-gray-600 hover:text-gray-800"
                    }`}
                  >
                    <span className="mr-2">{product.icon}</span>
                    {product.label}
                  </button>
                ))}
              </div>
            </div>

            {/* Audience Selector */}
            <div className="flex justify-center">
              <div className="inline-flex bg-gray-100 rounded-xl p-1.5 gap-1">
                <button
                  onClick={() => onAudienceChange("nurse")}
                  className={`px-8 py-3 rounded-lg font-medium transition-all duration-200 ${
                    selectedAudience === "nurse"
                      ? "bg-white text-blue-600 shadow-md"
                      : "text-gray-600 hover:text-gray-800"
                  }`}
                >
                  👨‍⚕️ Perawat
                </button>
                <button
                  onClick={() => onAudienceChange("midwife")}
                  className={`px-8 py-3 rounded-lg font-medium transition-all duration-200 ${
                    selectedAudience === "midwife"
                      ? "bg-white text-blue-600 shadow-md"
                      : "text-gray-600 hover:text-gray-800"
                  }`}
                >
                  👩‍⚕️ Bidan
                </button>
              </div>
            </div>
          </div>
        </div>

        {/* Selected Category Title */}
        <div className="text-center mb-12">
          <h3 className="text-2xl">
            {getProductTitle()} untuk {getAudienceTitle()}
          </h3>
        </div>

        {/* Loading State */}
        {loading && (
          <div className="text-center py-12">
            <div className="inline-block animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"></div>
            <p className="mt-4 text-muted-foreground">Memuat program...</p>
          </div>
        )}

        {/* Error State */}
        {error && !loading && (
          <div className="text-center py-12">
            <p className="text-red-600 mb-4">{error}</p>
            <p className="text-sm text-muted-foreground">Menampilkan data contoh</p>
          </div>
        )}

        {/* Programs Grid */}
        {!loading && (
          <div className="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
            {filteredPrograms.length === 0 ? (
              <div className="col-span-full text-center py-12">
                <p className="text-muted-foreground">Belum ada program tersedia untuk kategori ini.</p>
              </div>
            ) : (
              filteredPrograms.map((program) => (
            <Card key={program.id} className="group hover:shadow-xl transition-all duration-300 border-2 hover:border-blue-200">
              <CardHeader className="p-0">
                <div className="relative overflow-hidden rounded-t-lg">
                  {program.tag && (
                    <Badge className="absolute top-4 left-4 z-10 bg-blue-600">
                      {program.tag}
                    </Badge>
                  )}
                  <ImageWithFallback
                    src={program.image}
                    alt={program.title}
                    className="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300"
                  />
                </div>
              </CardHeader>
              <CardContent className="p-6 space-y-4">
                <div>
                  <CardTitle className="mb-2">{program.title}</CardTitle>
                  <CardDescription>{program.description}</CardDescription>
                </div>

                <div className="flex flex-wrap gap-3 text-sm text-muted-foreground">
                  {program.duration && (
                    <div className="flex items-center gap-1">
                      <Clock size={16} />
                      <span>{program.duration}</span>
                    </div>
                  )}
                  {program.students && (
                    <div className="flex items-center gap-1">
                      <Users size={16} />
                      <span>{program.students}</span>
                    </div>
                  )}
                  {program.level && (
                    <div className="flex items-center gap-1">
                      <Award size={16} />
                      <span>{program.level}</span>
                    </div>
                  )}
                  {program.pages && (
                    <div className="flex items-center gap-1">
                      <BookOpen size={16} />
                      <span>{program.pages}</span>
                    </div>
                  )}
                  {program.questions && (
                    <div className="flex items-center gap-1">
                      <Award size={16} />
                      <span>{program.questions}</span>
                    </div>
                  )}
                </div>

                {program.price && (
                  <div className="flex items-center gap-2 pt-2 border-t">
                    <DollarSign size={16} className="text-blue-600" />
                    <span className="text-blue-600">{program.price}</span>
                  </div>
                )}

                <Link to={`/${program.productType === 'tryout' ? 'tryout' : 'program'}/${program.slug}`}>
                  <Button className="w-full bg-blue-600 hover:bg-blue-700">
                    Selengkapnya
                  </Button>
                </Link>
              </CardContent>
            </Card>
              ))
            )}
          </div>
        )}
      </div>
    </section>
  );
}
