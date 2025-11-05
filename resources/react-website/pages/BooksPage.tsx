import { useState, useEffect } from "react";
import { Link } from "react-router-dom";
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from "../components/ui/card";
import { Button } from "../components/ui/button";
import { Badge } from "../components/ui/badge";
import { Input } from "../components/ui/input";
import { BookOpen, User, ShoppingCart, Search } from "lucide-react";
import { ImageWithFallback } from "../components/figma/ImageWithFallback";

interface Book {
  id: number;
  title: string;
  author: string;
  category: string;
  excerpt: string;
  price: string;
  cover_image: string;
  audience_type: string;
}

export function BooksPage() {
  const [books, setBooks] = useState<Book[]>([]);
  const [loading, setLoading] = useState(true);
  const [search, setSearch] = useState("");
  const [audienceFilter, setAudienceFilter] = useState<"all" | "nurse" | "midwife">("all");

  useEffect(() => {
    fetchBooks();
  }, [audienceFilter]);

  const fetchBooks = async () => {
    try {
      setLoading(true);
      let url = '/api/public/books';
      if (audienceFilter !== 'all') {
        url += `?audience_type=${audienceFilter}`;
      }
      
      const response = await fetch(url);
      if (!response.ok) throw new Error('Failed to fetch books');
      
      const result = await response.json();
      const data = result.data || result;
      setBooks(data);
    } catch (error) {
      console.error('Error fetching books:', error);
      setBooks([]);
    } finally {
      setLoading(false);
    }
  };

  // Filter books by search query
  const filteredBooks = books.filter(book => 
    book.title.toLowerCase().includes(search.toLowerCase()) ||
    book.author.toLowerCase().includes(search.toLowerCase()) ||
    book.category.toLowerCase().includes(search.toLowerCase())
  );

  return (
    <div className="min-h-screen bg-gray-50">
      {/* Header */}
      <section className="bg-gradient-to-br from-blue-600 to-blue-800 text-white py-16">
        <div className="container mx-auto px-4 lg:px-8">
          <div className="max-w-3xl mx-auto text-center">
            <h1 className="text-4xl lg:text-5xl font-bold mb-4">
              Koleksi Buku UKOM
            </h1>
            <p className="text-xl text-blue-100">
              Temukan buku terbaik untuk persiapan UKOM Anda
            </p>
          </div>
        </div>
      </section>

      {/* Filters & Search */}
      <section className="py-8 bg-white border-b">
        <div className="container mx-auto px-4 lg:px-8">
          <div className="max-w-4xl mx-auto">
            <div className="flex flex-col md:flex-row gap-4">
              {/* Search */}
              <div className="flex-1 relative">
                <Search className="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400" size={20} />
                <Input
                  type="text"
                  placeholder="Cari judul, penulis, atau kategori..."
                  value={search}
                  onChange={(e) => setSearch(e.target.value)}
                  className="pl-10 py-6"
                />
              </div>

              {/* Audience Filter */}
              <div className="flex gap-2">
                <Button
                  variant={audienceFilter === "all" ? "default" : "outline"}
                  onClick={() => setAudienceFilter("all")}
                  className={audienceFilter === "all" ? "bg-blue-600" : ""}
                >
                  Semua
                </Button>
                <Button
                  variant={audienceFilter === "nurse" ? "default" : "outline"}
                  onClick={() => setAudienceFilter("nurse")}
                  className={audienceFilter === "nurse" ? "bg-blue-600" : ""}
                >
                  👨‍⚕️ Perawat
                </Button>
                <Button
                  variant={audienceFilter === "midwife" ? "default" : "outline"}
                  onClick={() => setAudienceFilter("midwife")}
                  className={audienceFilter === "midwife" ? "bg-blue-600" : ""}
                >
                  👩‍⚕️ Bidan
                </Button>
              </div>
            </div>

            {/* Results count */}
            <div className="mt-4 text-sm text-gray-600">
              Menampilkan {filteredBooks.length} dari {books.length} buku
            </div>
          </div>
        </div>
      </section>

      {/* Books Grid */}
      <section className="py-12">
        <div className="container mx-auto px-4 lg:px-8">
          {loading ? (
            <div className="text-center py-12">
              <div className="inline-block animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"></div>
              <p className="mt-4 text-muted-foreground">Memuat buku...</p>
            </div>
          ) : filteredBooks.length === 0 ? (
            <div className="text-center py-12">
              <BookOpen size={64} className="mx-auto text-gray-300 mb-4" />
              <h3 className="text-xl font-semibold text-gray-600 mb-2">
                Tidak ada buku ditemukan
              </h3>
              <p className="text-gray-500">
                Coba ubah filter atau kata kunci pencarian Anda
              </p>
            </div>
          ) : (
            <div className="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
              {filteredBooks.map((book) => (
                <Card key={book.id} className="group hover:shadow-xl transition-all duration-300 border-2 hover:border-blue-200">
                  <CardHeader className="p-0">
                    <div className="relative overflow-hidden rounded-t-lg">
                      <Badge className="absolute top-4 left-4 z-10 bg-green-600">
                        {book.category}
                      </Badge>
                      <Badge className="absolute top-4 right-4 z-10 bg-blue-600">
                        {book.audience_type === 'nurse' ? '👨‍⚕️ Perawat' : '👩‍⚕️ Bidan'}
                      </Badge>
                      <ImageWithFallback
                        src={book.cover_image}
                        alt={book.title}
                        className="w-full h-64 object-cover group-hover:scale-105 transition-transform duration-300"
                      />
                    </div>
                  </CardHeader>
                  <CardContent className="p-6 space-y-4">
                    <div>
                      <CardTitle className="mb-2 line-clamp-2">{book.title}</CardTitle>
                      <div className="flex items-center gap-2 text-sm text-muted-foreground mb-2">
                        <User size={14} />
                        <span>{book.author}</span>
                      </div>
                      <CardDescription className="line-clamp-2">{book.excerpt}</CardDescription>
                    </div>

                    <div className="flex items-center justify-between pt-2 border-t">
                      <div className="flex items-center gap-2">
                        <ShoppingCart size={16} className="text-blue-600" />
                        <span className="text-blue-600 font-semibold">{book.price}</span>
                      </div>
                    </div>

                    <Link to={`/books/${book.id}`}>
                      <Button className="w-full bg-blue-600 hover:bg-blue-700">
                        <BookOpen size={16} className="mr-2" />
                        Detail Buku
                      </Button>
                    </Link>
                  </CardContent>
                </Card>
              ))}
            </div>
          )}
        </div>
      </section>
    </div>
  );
}
