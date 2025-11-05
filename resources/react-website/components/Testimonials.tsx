import { Card, CardContent } from "./ui/card";
import { Star } from "lucide-react";

const testimonials = [
  {
    name: "Siti Nurhaliza",
    role: "Perawat di RSUP Dr. Sardjito",
    content: "Alhamdulillah lulus UKOM di attempt pertama dengan nilai 85! Materinya lengkap banget dan try out-nya mirip sama ujian asli. Terima kasih Bimbel UKOM!",
    rating: 5,
    avatar: "SN"
  },
  {
    name: "Ahmad Fauzi",
    role: "Perawat di RS Siloam",
    content: "Program intensif 1 bulan sangat membantu saya yang persiapannya mepet. Mentor sabar dan selalu siap jawab pertanyaan. Highly recommended!",
    rating: 5,
    avatar: "AF"
  },
  {
    name: "Dewi Lestari",
    role: "Bidan di RS Hermina",
    content: "Bank soalnya lengkap dan pembahasannya detail. Grup diskusinya juga aktif, jadi bisa saling support sama teman-teman lain. Puas banget!",
    rating: 5,
    avatar: "DL"
  },
  {
    name: "Rina Anggraini",
    role: "Bidan di Puskesmas",
    content: "Sempat gagal 2x sebelum ikut bimbel ini. Alhamdulillah sekarang sudah lulus dan sudah bekerja. Investasi terbaik untuk karir sebagai bidan!",
    rating: 5,
    avatar: "RA"
  }
];

export function Testimonials() {
  return (
    <section id="testimonials" className="py-20 bg-white">
      <div className="container mx-auto px-4 lg:px-8">
        {/* Header */}
        <div className="text-center max-w-3xl mx-auto mb-16">
          <h2 className="text-3xl lg:text-4xl mb-4">Kisah Sukses Alumni</h2>
          <p className="text-lg text-muted-foreground">
            Bergabung dengan ribuan perawat dan bidan yang telah lulus UKOM bersama kami.
          </p>
        </div>

        {/* Testimonials Grid */}
        <div className="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
          {testimonials.map((testimonial, index) => (
            <Card key={index} className="hover:shadow-lg transition-shadow">
              <CardContent className="p-6 space-y-4">
                {/* Rating */}
                <div className="flex gap-1">
                  {[...Array(testimonial.rating)].map((_, i) => (
                    <Star key={i} className="fill-yellow-400 text-yellow-400" size={16} />
                  ))}
                </div>

                {/* Content */}
                <p className="text-sm text-muted-foreground">{testimonial.content}</p>

                {/* Author */}
                <div className="flex items-center gap-3 pt-4 border-t">
                  <div className="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center text-white">
                    {testimonial.avatar}
                  </div>
                  <div>
                    <p className="text-sm">{testimonial.name}</p>
                    <p className="text-xs text-muted-foreground">{testimonial.role}</p>
                  </div>
                </div>
              </CardContent>
            </Card>
          ))}
        </div>
      </div>
    </section>
  );
}
