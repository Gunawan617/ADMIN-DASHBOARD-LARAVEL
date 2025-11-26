import { Facebook, Twitter, Instagram, Linkedin, Youtube, MapPin, Mail, Phone } from "lucide-react";

export function Footer() {
  return (
    <footer className="bg-gray-900 text-gray-300">
      <div className="container mx-auto px-4 lg:px-8 py-12">
        <div className="grid md:grid-cols-2 lg:grid-cols-4 gap-8 mb-8">
          {/* Brand & Contact */}
          <div className="lg:col-span-1">
            <div className="flex items-center gap-3 mb-4">
              <img src="/nfc.png" alt="NFC" className="h-8 w-auto" />
              <img src="/klikom.png" alt="Klinik Ukom" className="h-8 w-auto" />
            </div>
            <p className="text-sm mb-4">
              Bimbingan belajar terpercaya untuk persiapan Uji Kompetensi perawat dan bidan.
            </p>
            <div className="flex gap-4 mb-6">
              <a href="#" className="hover:text-white transition-colors" aria-label="Facebook">
                <Facebook size={20} />
              </a>
              <a href="#" className="hover:text-white transition-colors" aria-label="Twitter">
                <Twitter size={20} />
              </a>
              <a href="#" className="hover:text-white transition-colors" aria-label="Instagram">
                <Instagram size={20} />
              </a>
              <a href="#" className="hover:text-white transition-colors" aria-label="LinkedIn">
                <Linkedin size={20} />
              </a>
              <a href="#" className="hover:text-white transition-colors" aria-label="YouTube">
                <Youtube size={20} />
              </a>
            </div>

            {/* Contact Info */}
            <div className="space-y-3 text-sm">
              <div className="flex items-start gap-2">
                <MapPin size={16} className="flex-shrink-0 mt-1 text-blue-400" />
                <div>
                  <p className="font-medium text-white mb-1">Alamat Kantor</p>
                  <p className="text-gray-400 leading-relaxed">
                    Grand Slipi Tower<br />
                    Jl. Letjen S. Parman No.22-24<br />
                    RT.1/RW.4, Palmerah<br />
                    Jakarta Barat 11480
                  </p>
                </div>
              </div>
              
              <div className="flex items-center gap-2">
                <Mail size={16} className="flex-shrink-0 text-blue-400" />
                <a href="mailto:info@klinikukom.com" className="hover:text-white transition-colors">
                 ukomklinik@gmail.com
                </a>
              </div>
              
              <div className="flex items-center gap-2">
                <Phone size={16} className="flex-shrink-0 text-blue-400" />
                <a href="https://wa.me/6281295012668" className="hover:text-white transition-colors">
                 +6281295012668
                </a>
              </div>
            </div>
          </div>

          {/* Programs */}
          <div>
            <h4 className="text-white font-semibold mb-4">Program</h4>
            <ul className="space-y-2 text-sm">
              <li><a href="#" className="hover:text-white transition-colors">UKOM Perawat</a></li>
              <li><a href="#" className="hover:text-white transition-colors">UKOM Bidan</a></li>
              <li><a href="#" className="hover:text-white transition-colors">Program Reguler</a></li>
              <li><a href="#" className="hover:text-white transition-colors">Program Intensif</a></li>
            </ul>
          </div>

          {/* Company */}
          <div>
            <h4 className="text-white font-semibold mb-4">Tentang</h4>
            <ul className="space-y-2 text-sm">
              <li><a href="#" className="hover:text-white transition-colors">Tentang Kami</a></li>
              <li><a href="#" className="hover:text-white transition-colors">Testimoni</a></li>
              <li><a href="#" className="hover:text-white transition-colors">Blog</a></li>
              <li><a href="#" className="hover:text-white transition-colors">Mitra RS</a></li>
            </ul>
          </div>

          {/* Support */}
          <div>
            <h4 className="text-white font-semibold mb-4">Bantuan</h4>
            <ul className="space-y-2 text-sm">
              <li><a href="#" className="hover:text-white transition-colors">Pusat Bantuan</a></li>
              <li><a href="/contact" className="hover:text-white transition-colors">Hubungi Kami</a></li>
              <li><a href="#" className="hover:text-white transition-colors">Kebijakan Privasi</a></li>
              <li><a href="#" className="hover:text-white transition-colors">Syarat & Ketentuan</a></li>
            </ul>
          </div>
        </div>

        <div className="border-t border-gray-800 pt-8 text-center text-sm">
          <p>&copy; 2025 Klinik Ukom. Hak cipta dilindungi undang-undang.</p>
        </div>
      </div>
    </footer>
  );
}
