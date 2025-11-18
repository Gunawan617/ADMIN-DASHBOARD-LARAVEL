import { useState, useEffect } from "react";
import { useParams, Link } from "react-router-dom";
import { Calendar, Clock, ArrowLeft, User, Tag } from "lucide-react";
import { ImageWithFallback } from "../components/figma/ImageWithFallback";
import { Badge } from "../components/ui/badge";

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
  tags: Array<{ id: number; name: string }>;
  created_at: string;
  updated_at: string;
}

export function BlogDetailPage() {
  const { slug } = useParams<{ slug: string }>();
  const [post, setPost] = useState<Post | null>(null);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState<string | null>(null);

  useEffect(() => {
    fetchPost();
  }, [slug]);

  const fetchPost = async () => {
    try {
      setLoading(true);
      const response = await fetch(`/api/public/posts/slug/${slug}`);
      const data = await response.json();
      
      if (data.success) {
        setPost(data.data);
      } else {
        setError("Artikel tidak ditemukan");
      }
    } catch (error) {
      console.error("Error fetching post:", error);
      setError("Terjadi kesalahan saat memuat artikel");
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
    if (!imagePath) return "https://images.unsplash.com/photo-1620063487586-c3f97749bb84?w=1200";
    return imagePath.startsWith("http") ? imagePath : `/storage/${imagePath}`;
  };

  if (loading) {
    return (
      <div className="min-h-screen flex items-center justify-center">
        <div className="text-center">
          <div className="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mx-auto"></div>
          <p className="mt-4 text-muted-foreground">Memuat artikel...</p>
        </div>
      </div>
    );
  }

  if (error || !post) {
    return (
      <div className="min-h-screen flex items-center justify-center">
        <div className="text-center">
          <h2 className="text-2xl font-bold mb-4">Artikel Tidak Ditemukan</h2>
          <p className="text-muted-foreground mb-6">{error}</p>
          <Link
            to="/blog"
            className="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors"
          >
            <ArrowLeft size={20} />
            Kembali ke Blog
          </Link>
        </div>
      </div>
    );
  }

  return (
    <div className="min-h-screen bg-gradient-to-b from-gray-50 to-white">
      {/* Back Button */}
      <div className="bg-white border-b shadow-sm sticky top-0 z-10">
        <div className="container mx-auto px-4 lg:px-8 py-4">
          <Link
            to="/blog"
            className="inline-flex items-center gap-2 text-blue-600 hover:text-blue-700 transition-all hover:gap-3 font-medium"
          >
            <ArrowLeft size={20} />
            Kembali ke Blog
          </Link>
        </div>
      </div>

      {/* Article Header */}
      <article className="py-6 sm:py-8 lg:py-16">
        <div className="container mx-auto px-4 sm:px-6 lg:px-8">
          <div className="max-w-5xl mx-auto">
            {/* Category Badge */}
            {post.category && (
              <Badge className="mb-6 bg-blue-600 hover:bg-blue-700 px-4 py-1.5 text-sm font-medium">
                {post.category}
              </Badge>
            )}

            {/* Title */}
            <h1 className="text-2xl sm:text-3xl lg:text-3xl font-bold mb-4 sm:mb-6 leading-tight text-gray-900">
              {post.title}
            </h1>

            {/* Meta Information */}
            <div className="flex flex-wrap items-center gap-3 sm:gap-4 text-xs sm:text-sm text-gray-600 mb-6 pb-4 border-b border-gray-200">
              {post.author && (
                <div className="flex items-center gap-1.5">
                  <User size={14} className="text-gray-500" />
                  <span>By {post.author}</span>
                </div>
              )}
              <div className="flex items-center gap-1.5">
                <Calendar size={14} className="text-gray-500" />
                <span>{formatDate(post.published_at || post.created_at)}</span>
              </div>
              <div className="flex items-center gap-1.5">
                <Clock size={14} className="text-gray-500" />
                <span>{calculateReadTime(post.content)}</span>
              </div>
            </div>

            {/* Featured Image */}
            {post.image && (
              <div className="mb-6 sm:mb-8 rounded-lg overflow-hidden shadow-md">
                <ImageWithFallback
                  src={getImageUrl(post.image)}
                  alt={post.title}
                  className="w-full h-auto object-cover"
                />
              </div>
            )}

            {/* Summary */}
            <div className="bg-blue-50 border-l-4 border-blue-600 p-4 sm:p-5 mb-6 sm:mb-8 rounded-r-lg">
              <p className="text-sm sm:text-base text-gray-800 leading-relaxed font-medium italic">
                {post.summary}
              </p>
            </div>

            {/* Content */}
            <article 
              className="blog-content prose prose-sm sm:prose-base !max-w-full mb-8 sm:mb-10 lg:mb-12
                         prose-headings:font-bold prose-headings:text-gray-900 prose-headings:tracking-tight
                         prose-h1:text-2xl prose-h1:sm:text-3xl prose-h1:mb-5 prose-h1:mt-6
                         prose-h2:text-xl prose-h2:sm:text-2xl prose-h2:mb-4 prose-h2:mt-6 prose-h2:pb-2 prose-h2:border-b prose-h2:border-gray-200
                         prose-h3:text-lg prose-h3:sm:text-xl prose-h3:mb-3 prose-h3:mt-5
                         prose-h4:text-base prose-h4:sm:text-lg prose-h4:mb-3 prose-h4:mt-4
                         prose-p:text-gray-700 prose-p:leading-[1.7] prose-p:mb-4 prose-p:text-[15px] prose-p:sm:text-[15px] prose-p:text-justify
                         prose-a:text-blue-600 prose-a:font-medium prose-a:underline hover:prose-a:text-blue-700 prose-a:transition-colors prose-a:break-words
                         prose-img:rounded-lg prose-img:w-full prose-img:h-auto prose-img:shadow-md prose-img:my-5
                         prose-ul:list-disc prose-ul:pl-5 prose-ul:mb-4 prose-ul:space-y-1
                         prose-ol:list-decimal prose-ol:pl-5 prose-ol:mb-4 prose-ol:space-y-1
                         prose-li:text-gray-700 prose-li:leading-[1.7] prose-li:text-[15px] prose-li:sm:text-[15px]
                         prose-strong:text-gray-900 prose-strong:font-bold
                         prose-em:text-gray-800 prose-em:italic
                         prose-code:bg-gray-100 prose-code:px-1.5 prose-code:py-0.5 prose-code:rounded prose-code:text-sm prose-code:text-pink-600 prose-code:font-mono
                         prose-pre:bg-gray-900 prose-pre:text-gray-100 prose-pre:p-4 prose-pre:rounded-lg prose-pre:overflow-x-auto prose-pre:shadow-md prose-pre:mb-5
                         prose-blockquote:border-l-4 prose-blockquote:border-blue-500 prose-blockquote:bg-blue-50
                         prose-blockquote:pl-4 prose-blockquote:pr-3 prose-blockquote:py-3 prose-blockquote:italic prose-blockquote:text-gray-700 prose-blockquote:rounded-r-lg prose-blockquote:my-5
                         prose-table:border-collapse prose-table:w-full prose-table:my-5 prose-table:text-sm
                         prose-th:bg-gray-100 prose-th:p-2 prose-th:text-left prose-th:font-semibold prose-th:border prose-th:border-gray-300
                         prose-td:p-2 prose-td:border prose-td:border-gray-300
                         prose-hr:border-t prose-hr:border-gray-300 prose-hr:my-6
                         [&_p]:mb-4 [&_p:last-child]:mb-0 [&_p:empty]:min-h-[1em]
                         [&_img]:max-w-full [&_img]:h-auto [&_img]:mx-auto [&_img]:block [&_img]:my-5
                         [&_figure]:my-6 [&_figcaption]:text-center [&_figcaption]:text-sm [&_figcaption]:text-gray-600 [&_figcaption]:mt-2
                         [&_br]:block [&_br]:my-0
                         break-words"
              style={{ 
                whiteSpace: 'pre-wrap',
                wordBreak: 'break-word',
                overflowWrap: 'break-word'
              }}
              dangerouslySetInnerHTML={{ __html: post.content }}
            />

            {/* Tags */}
            {post.tags && post.tags.length > 0 && (
              <div className="flex flex-col sm:flex-row sm:items-center gap-3 sm:gap-4 pt-8 sm:pt-10 mt-8 sm:mt-10 border-t-2 border-gray-200">
                <div className="flex items-center gap-2 text-gray-600 font-medium">
                  <Tag size={18} className="text-blue-600" />
                  <span className="text-sm sm:text-base">Tags:</span>
                </div>
                <div className="flex flex-wrap gap-2">
                  {post.tags.map((tag) => (
                    <Badge 
                      key={tag.id} 
                      variant="outline" 
                      className="text-xs sm:text-sm px-3 py-1.5 border-blue-200 text-blue-700 hover:bg-blue-50 hover:border-blue-300 transition-colors cursor-pointer"
                    >
                      #{tag.name}
                    </Badge>
                  ))}
                </div>
              </div>
            )}
          </div>
        </div>
      </article>

      {/* Call to Action */}
      <section className="relative bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 text-white py-16 sm:py-20 lg:py-24 overflow-hidden">
        {/* Background Pattern */}
        <div className="absolute inset-0 opacity-10">
          <div className="absolute inset-0" style={{
            backgroundImage: 'radial-gradient(circle at 2px 2px, white 1px, transparent 0)',
            backgroundSize: '40px 40px'
          }}></div>
        </div>
        
        <div className="container mx-auto px-4 lg:px-8 relative z-10">
          <div className="max-w-3xl mx-auto text-center">
            <div className="inline-block px-4 py-2 bg-white/20 backdrop-blur-sm rounded-full text-sm font-medium mb-6">
              ✨ Bergabung Sekarang
            </div>
            <h2 className="text-2xl sm:text-3xl lg:text-4xl font-bold mb-4 sm:mb-6 leading-tight">
              Siap Lulus UKOM dengan Nilai Terbaik?
            </h2>
            <p className="text-base sm:text-lg lg:text-xl text-blue-100 mb-8 sm:mb-10 leading-relaxed max-w-2xl mx-auto">
              Bergabunglah dengan ribuan peserta yang telah berhasil lulus UKOM bersama kami. Dapatkan bimbingan terbaik dari mentor berpengalaman.
            </p>
            <Link
              to="/#programs"
              className="inline-flex items-center gap-3 px-8 sm:px-10 py-4 sm:py-5 bg-white text-blue-600 rounded-xl font-bold hover:bg-blue-50 hover:shadow-2xl hover:scale-105 transition-all duration-300 text-sm sm:text-base lg:text-lg shadow-xl"
            >
              Lihat Program Kami
              <ArrowLeft size={20} className="rotate-180" />
            </Link>
          </div>
        </div>
      </section>
    </div>
  );
}
