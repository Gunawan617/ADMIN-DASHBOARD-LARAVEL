import { useState, useEffect } from "react";
import { useParams, useNavigate, Link } from "react-router-dom";
import { Button } from "../components/ui/button";
import { Card, CardContent } from "../components/ui/card";
import { Badge } from "../components/ui/badge";
import { ArrowLeft, ShoppingCart, User, BookOpen, ExternalLink } from "lucide-react";
import { ImageWithFallback } from "../components/figma/ImageWithFallback";

interface Book {
  id: number;
  title: string;
  author: string;
  category: string;
  excerpt: string;
  description: string;
  price: string;
  cover_image: string;
  audience_type: string;
  buy_link?: string;
}

export function BookDetailPage() {
  const { id } = useParams<{ id: string }>();
  const navigate = useNavigate();
  const [book, setBook] = useState<Book | null>(null);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    fetchBook();
  }, [id]);

  const fetchBook = async () => {
    try {
      setLoading(true);
      const response = await fetch(`/api/public/books/${id}`);
      
      if (!response.ok) {
        throw new Error('Book not found');
      }
      
      const result = await response.json();
      const data = result.data || result;
      setBook(data);
    } catch (error) {
      console.error("Error fetching book:", error);
      setBook(null);
    } finally {
      setLoading(false);
    }
  };

  if (loading) {
    return (
      <div className="min-h-screen flex items-center justify-center">
        <div className="text-center">
          <div className="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mx-auto"></div>
          <p className="mt-4 text-muted-foreground">Memuat detail buku...</p>
        </div>
      </div>
    );
  }

  if (!book) {
    return (
      <div className="min-h-screen flex items-center justify-center">
        <div className="text-center">
          <BookOpen size={64} className="mx-auto text-gray-300 mb-4" />
          <h2 className="text-2xl font-bold mb-4">Buku Tidak Ditemukan</h2>
          <Button onClick={() => navigate("/books")} className="bg-blue-600">
            <ArrowLeft className="mr-2" size={16} />
            Kembali ke Daftar Buku
          </Button>
        </div>
      </div>
    );
  }

  return (
    <div className="min-h-screen bg-gray-50">
      {/* Back Button */}
      <div className="bg-white border-b">
        <div className="container mx-auto px-4 lg:px-8 py-4">
          <button
            onClick={() => navigate("/books")}
            className="inline-flex items-center gap-2 text-blue-600 hover:text-blue-700 transition-colors"
          >
            <ArrowLeft size={20} />
            Kembali ke Daftar Buku
          </button>
        </div>
      </div>

      {/* Book Detail */}
      <section className="py-12 bg-white">
        <div className="container mx-auto px-4 lg:px-8">
          <div className="max-w-6xl mx-auto">
            <div className="grid lg:grid-cols-2 gap-12">
              {/* Book Cover */}
              <div className="relative">
                <Badge className="absolute top-4 left-4 z-10 bg-green-600 text-lg px-4 py-2">
                  {book.category}
                </Badge>
                <Badge className="absolute top-4 right-4 z-10 bg-blue-600 text-lg px-4 py-2">
                  {book.audience_type === 'nurse' ? '👨‍⚕️ Perawat' : '👩‍⚕️ Bidan'}
                </Badge>
                <ImageWithFallback
                  src={book.cover_image}
                  alt={book.title}
                  className="w-full h-[600px] object-cover rounded-2xl shadow-2xl"
                />
              </div>

              {/* Book Info */}
              <div className="flex flex-col">
                <div className="flex-1">
                  <h1 className="text-4xl font-bold mb-4">{book.title}</h1>
                  
                  <div className="flex items-center gap-3 mb-6 text-lg text-gray-600">
                    <User size={20} />
                    <span>oleh <strong>{book.author}</strong></span>
                  </div>

                  <div className="mb-6">
                    <h3 className="text-lg font-semibold mb-2">Ringkasan</h3>
                    <p className="text-gray-700 leading-relaxed">{book.excerpt}</p>
                  </div>

                  <div className="mb-8">
                    <h3 className="text-lg font-semibold mb-2">Deskripsi</h3>
                    <p className="text-gray-700 leading-relaxed whitespace-pre-line">{book.description}</p>
                  </div>
                </div>

                {/* Price & Buy Button */}
                <Card className="bg-gradient-to-br from-blue-50 to-blue-100 border-2 border-blue-200">
                  <CardContent className="p-6">
                    <div className="flex items-center justify-between mb-4">
                      <div>
                        <p className="text-sm text-gray-600 mb-1">Harga Buku</p>
                        <p className="text-3xl font-bold text-blue-600">{book.price}</p>
                      </div>
                      <ShoppingCart size={48} className="text-blue-600" />
                    </div>

                    {book.buy_link ? (
                      <a 
                        href={book.buy_link} 
                        target="_blank" 
                        rel="noopener noreferrer"
                        className="block"
                      >
                        <Button className="w-full bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-semibold text-lg py-6">
                          <ShoppingCart className="mr-2" size={20} />
                          Beli Sekarang
                          <ExternalLink className="ml-2" size={16} />
                        </Button>
                      </a>
                    ) : (
                      <Button 
                        disabled 
                        className="w-full bg-gray-400 text-white font-semibold text-lg py-6 cursor-not-allowed"
                      >
                        Link Pembelian Tidak Tersedia
                      </Button>
                    )}

                    <p className="text-xs text-gray-600 text-center mt-3">
                      * Anda akan diarahkan ke toko online untuk melakukan pembelian
                    </p>
                  </CardContent>
                </Card>
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* Related Books Section (Optional) */}
      <section className="py-12 bg-gray-50">
        <div className="container mx-auto px-4 lg:px-8">
          <div className="max-w-6xl mx-auto text-center">
            <h2 className="text-3xl font-bold mb-4">Cari Buku Lainnya?</h2>
            <p className="text-gray-600 mb-6">
              Lihat koleksi lengkap buku UKOM kami
            </p>
            <Link to="/books">
              <Button size="lg" className="bg-blue-600 hover:bg-blue-700">
                <BookOpen size={20} className="mr-2" />
                Lihat Semua Buku
              </Button>
            </Link>
          </div>
        </div>
      </section>
    </div>
  );
}
