import { useState, useEffect } from "react";
import { Link } from "react-router-dom";
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from "./ui/card";
import { Badge } from "./ui/badge";
import { Calendar, Clock, ArrowRight } from "lucide-react";
import { ImageWithFallback } from "./figma/ImageWithFallback";

interface Post {
  id: number;
  title: string;
  slug: string;
  summary: string;
  content: string;
  image: string | null;
  published_at: string;
  status: string;
  author: string | null;
  category: string | null;
  created_at: string;
}

export function Blog() {
  const [posts, setPosts] = useState<Post[]>([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    fetchPosts();
  }, []);

  const fetchPosts = async () => {
    try {
      const response = await fetch("/api/public/posts?per_page=6");
      const data = await response.json();

      if (data.success) {
        setPosts(data.data.data.filter((post: Post) => post.status === "published"));
      }
    } catch (error) {
      console.error("Error fetching posts:", error);
    } finally {
      setLoading(false);
    }
  };

  const formatDate = (dateString: string) => {
    const date = new Date(dateString);
    return date.toLocaleDateString("id-ID", {
      day: "numeric",
      month: "long",
      year: "numeric",
    });
  };

  const calculateReadTime = (content: string) => {
    const wordsPerMinute = 200;
    const wordCount = content.split(/\s+/).length;
    const minutes = Math.ceil(wordCount / wordsPerMinute);
    return `${minutes} menit`;
  };

  const getImageUrl = (imagePath: string | null) => {
    if (!imagePath) return "https://images.unsplash.com/photo-1620063487586-c3f97749bb84?w=800";
    return imagePath.startsWith("http") ? imagePath : `/storage/${imagePath}`;
  };

  if (loading) {
    return (
      <section id="blog" className="py-20 bg-gray-50">
        <div className="container mx-auto px-4 lg:px-8 text-center">
          <div className="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mx-auto"></div>
          <p className="mt-4 text-muted-foreground">Memuat artikel...</p>
        </div>
      </section>
    );
  }
  return (
    <section id="blog" className="py-20 bg-gray-50">
      <div className="container mx-auto px-4 lg:px-8">
        {/* Header */}
        <div className="text-center max-w-3xl mx-auto mb-16">
          <h2 className="text-3xl lg:text-4xl mb-4">Artikel & Tips UKOM</h2>
          <p className="text-lg text-muted-foreground">
            Panduan lengkap, tips belajar, dan informasi terkini seputar persiapan UKOM untuk perawat dan bidan.
          </p>
        </div>

        {/* Articles Grid */}
        <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
          {posts.slice(0, 6).map((post) => (
            <Card key={post.id} className="group hover:shadow-xl transition-all duration-300 overflow-hidden border-2 hover:border-blue-200">
              <CardHeader className="p-0">
                <div className="relative overflow-hidden">
                  <ImageWithFallback
                    src={getImageUrl(post.image)}
                    alt={post.title}
                    className="w-full h-56 object-cover group-hover:scale-105 transition-transform duration-300"
                  />
                  {post.category && (
                    <Badge className="absolute top-4 left-4 bg-blue-600">
                      {post.category}
                    </Badge>
                  )}
                </div>
              </CardHeader>
              <CardContent className="p-6 space-y-4">
                <div>
                  <CardTitle className="mb-3 group-hover:text-blue-600 transition-colors">
                    {post.title}
                  </CardTitle>
                  <CardDescription className="line-clamp-3">
                    {post.summary}
                  </CardDescription>
                </div>

                <div className="flex items-center gap-4 text-sm text-muted-foreground pt-4 border-t">
                  <div className="flex items-center gap-1">
                    <Calendar size={14} />
                    <span>{formatDate(post.published_at || post.created_at)}</span>
                  </div>
                  <div className="flex items-center gap-1">
                    <Clock size={14} />
                    <span>{calculateReadTime(post.content)}</span>
                  </div>
                </div>

                <Link
                  to={`/blog/${post.slug}`}
                  className="flex items-center gap-2 text-blue-600 hover:gap-3 transition-all group/btn"
                >
                  <span>Baca Selengkapnya</span>
                  <ArrowRight size={16} className="group-hover/btn:translate-x-1 transition-transform" />
                </Link>
              </CardContent>
            </Card>
          ))}
        </div>

        {/* View All Button */}
        <div className="text-center mt-12">
          <Link
            to="/blog"
            className="inline-block px-8 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors"
          >
            Lihat Semua Artikel
          </Link>
        </div>
      </div>
    </section>
  );
}
