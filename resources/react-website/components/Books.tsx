import { useState, useEffect } from "react";
import { Link } from "react-router-dom";
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from "./ui/card";
import { Button } from "./ui/button";
import { Badge } from "./ui/badge";
import { BookOpen, User, ShoppingCart } from "lucide-react";
import { ImageWithFallback } from "./figma/ImageWithFallback";

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

export function Books() {
  const [books, setBooks] = useState<Book[]>([]);
  const [loading, setLoading] = useState(true);
  const [selectedAudience, setSelectedAudience] = useState<"nurse" | "midwife">("nurse");

  useEffect(() => {
    fetchBooks();
  }, [selectedAudience]);

  const fetchBooks = async () => {
    try {
      setLoading(true);
      const response = await fetch(`/api/public/books?audience_type=${selectedAudience}`);
      if (!response.ok) throw new Error('Failed to fetch books');
      
      const result = await response.json();
      const data = result.data || result;
      
      // Limit to 4 books for homepage
      setBooks(data.slice(0, 4));
    } catch (error) {
      console.error('Error fetching books:', error);
      setBooks([]);
    } finally {
      setLoading(false);
    }
  };

  const getAudienceTitle = () => {
    return selectedAudience === "nurse" ? "Perawat" : "Bidan";
  };

  if (loading) {
    return (
      <section id="books" className="py-20 bg-gray-50">
        <div className="container mx-auto px-4 lg:px-8">
          <div className="text-center">
            <div className="inline-block animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"></div>
            <p className="mt-4 text-muted-foreground">Memuat buku...</p>
          </div>
        </div>
      </section>
    );
  }

  if (books.length === 0) {
    return null; // Don't show section if no books
  }

  return (
    <section id="books" className="py-20 bg-gray-50">
      <div className="container mx-auto px-4 lg:px-8">
        {/* Header */}
        <div className="text-center max-w-3xl mx-auto mb-8">
          <h2 className="text-3xl lg:text-4xl font-bold mb-4">
            Buku UKOM untuk {getAudienceTitle()}
          </h2>
          <p className="text-lg text-muted-foreground mb-6">
            Koleksi buku terbaik untuk persiapan UKOM Anda
          </p>
          
          {/* Audience Filter - Independent from Programs */}
          <div className="flex gap-3 justify-center mb-6">
            <Button
              onClick={() => setSelectedAudience("nurse")}
              className={`px-8 py-3 rounded-lg transition-all ${
                selectedAudience === "nurse"
                  ? "bg-blue-600 text-white shadow-lg"
                  : "bg-gray-100 text-gray-700 hover:bg-gray-200"
              }`}
            >
              👨‍⚕️ Perawat
            </Button>
            <Button
              onClick={() => setSelectedAudience("midwife")}
              className={`px-8 py-3 rounded-lg transition-all ${
                selectedAudience === "midwife"
                  ? "bg-blue-600 text-white shadow-lg"
                  : "bg-gray-100 text-gray-700 hover:bg-gray-200"
              }`}
            >
              👩‍⚕️ Bidan
            </Button>
          </div>
        </div>

        {/* Books Grid */}
        <div className="grid md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
          {books.map((book) => (
            <Card key={book.id} className="group hover:shadow-xl transition-all duration-300 border-2 hover:border-blue-200">
              <CardHeader className="p-0">
                <div className="relative overflow-hidden rounded-t-lg">
                  <Badge className="absolute top-4 left-4 z-10 bg-green-600">
                    {book.category}
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

        {/* View All Button */}
        <div className="text-center">
          <Link to="/books">
            <Button size="lg" className="bg-blue-600 hover:bg-blue-700">
              <BookOpen size={20} className="mr-2" />
              Lihat Semua Buku
            </Button>
          </Link>
        </div>
      </div>
    </section>
  );
}
