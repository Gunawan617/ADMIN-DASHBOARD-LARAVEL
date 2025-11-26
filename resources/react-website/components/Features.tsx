import { Card, CardContent } from "./ui/card";
import { BookOpen, Users, ClipboardCheck, Trophy, Video, MessageSquare } from "lucide-react";

const features = [
  {
    icon: BookOpen,
    title: "Materi Terlengkap & Terkini",
    description: "Modul pembelajaran sesuai blueprint UKOM terbaru dengan update materi berkala."
  },
  {
    icon: Users,
    title: "Mentor Berpengalaman",
    description: "Dibimbing oleh perawat dan bidan profesional yang telah lulus UKOM dengan nilai tinggi."
  },
  {
    icon: Video,
    title: "Kelas Live & Rekaman",
    description: "Belajar fleksibel dengan kelas live interaktif dan akses unlimited ke rekaman materi."
  },
  {
    icon: ClipboardCheck,
    title: "Try Out Berkala",
    description: "Simulasi ujian rutin dengan sistem CBT mirip ujian UKOM sesungguhnya."
  },
  {
    icon: Trophy,
    title: "Bank Soal Ribuan",
    description: "Akses ribuan soal latihan dengan pembahasan detail untuk setiap topik."
  },
  {
    icon: MessageSquare,
    title: "Grup Diskusi Aktif",
    description: "Bergabung dengan komunitas peserta dan alumni untuk saling support dan berbagi tips."
  }
];

export function Features() {
  return (
    <section id="features" className="py-20 bg-gradient-to-b from-blue-50 to-white">
      <div className="container mx-auto px-4 lg:px-8">
        {/* Header */}
        <div className="text-center max-w-3xl mx-auto mb-16">
          <h2 className="text-3xl lg:text-4xl mb-4">Keunggulan Klinik Ukom</h2>
          <p className="text-lg text-muted-foreground">
            Semua yang Anda butuhkan untuk lulus UKOM dengan nilai maksimal.
          </p>
        </div>

        {/* Features Grid */}
        <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
          {features.map((feature, index) => {
            const Icon = feature.icon;
            return (
              <Card key={index} className="border-none shadow-lg hover:shadow-xl transition-shadow">
                <CardContent className="p-6 space-y-4">
                  <div className="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center">
                    <Icon className="text-white" size={24} />
                  </div>
                  <div>
                    <h3 className="mb-2">{feature.title}</h3>
                    <p className="text-sm text-muted-foreground">{feature.description}</p>
                  </div>
                </CardContent>
              </Card>
            );
          })}
        </div>
      </div>
    </section>
  );
}
