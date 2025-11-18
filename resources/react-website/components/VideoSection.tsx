import { Volume2, VolumeX } from "lucide-react";
import { useState, useRef, useEffect } from "react";

interface VideoData {
    title: string;
    description: string;
    video_type: 'upload' | 'youtube';
    youtube_url: string | null;
    video_url: string;
    video_webm_url: string | null;
    thumbnail_url: string;
    badge_title: string;
    badge_subtitle: string;
}

export function VideoSection() {
    const [isInView, setIsInView] = useState(false);
    const [isMuted, setIsMuted] = useState(true);
    const [isLoaded, setIsLoaded] = useState(false);
    const [videoData, setVideoData] = useState<VideoData | null>(null);
    const [loading, setLoading] = useState(true);
    const videoRef = useRef<HTMLVideoElement>(null);
    const sectionRef = useRef<HTMLDivElement>(null);

    // Fetch video data
    useEffect(() => {
        fetch('/api/public/video-section')
            .then(res => res.json())
            .then(data => {
                console.log('Video section data:', data);
                setVideoData(data);
                setLoading(false);
            })
            .catch(err => {
                console.error('Failed to load video section:', err);
                setLoading(false);
            });
    }, []);

    // Intersection Observer untuk lazy load
    useEffect(() => {
        const observer = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting && !isInView) {
                        setIsInView(true);
                    }
                });
            },
            { threshold: 0.3 }
        );

        if (sectionRef.current) {
            observer.observe(sectionRef.current);
        }

        return () => observer.disconnect();
    }, [isInView]);

    const toggleMute = () => {
        if (videoRef.current) {
            videoRef.current.muted = !isMuted;
            setIsMuted(!isMuted);
        }
    };

    // Default fallback data
    const defaultData: VideoData = {
        title: "Lihat Bagaimana Kami Membantu Anda Lulus UKOM",
        description: "Dengar langsung dari alumni kami yang telah berhasil lulus dengan bimbingan Klinik Ukom",
        video_type: "upload",
        youtube_url: null,
        video_url: "/videos/hero-video.mp4",
        video_webm_url: "/videos/hero-video.webm",
        thumbnail_url: "https://images.unsplash.com/photo-1588072432836-e10032774350?w=1200",
        badge_title: "Testimoni Alumni Klinik Ukom",
        badge_subtitle: "Video otomatis diputar"
    };

    const data = videoData || defaultData;

    if (loading) {
        return (
            <section className="py-20 bg-white">
                <div className="container mx-auto px-4 lg:px-8">
                    <div className="max-w-5xl mx-auto animate-pulse">
                        <div className="h-8 bg-gray-200 rounded w-2/3 mx-auto mb-4"></div>
                        <div className="h-6 bg-gray-200 rounded w-1/2 mx-auto mb-12"></div>
                        <div className="aspect-video bg-gray-200 rounded-2xl"></div>
                    </div>
                </div>
            </section>
        );
    }

    return (
        <section ref={sectionRef} className="py-12 sm:py-16 lg:py-20 bg-white">
            <div className="container mx-auto px-4 lg:px-8">
                <div className="max-w-5xl mx-auto">
                    {/* Header */}
                    <div className="text-center mb-8 sm:mb-12">
                        <h2 className="text-2xl sm:text-3xl lg:text-4xl font-bold mb-3 sm:mb-4 px-2">
                            {data.title}
                        </h2>
                        <p className="text-base sm:text-lg text-muted-foreground px-4">
                            {data.description}
                        </p>
                    </div>

                    {/* Video Container */}
                    <div className="relative rounded-2xl overflow-hidden shadow-2xl bg-gradient-to-br from-blue-100 to-indigo-100">
                        <div className="relative aspect-video">
                            {data.video_type === 'youtube' && data.youtube_url ? (
                                /* YouTube Embed */
                                <iframe
                                    className="w-full h-full"
                                    src={`https://www.youtube.com/embed/${data.youtube_url}?autoplay=1&mute=1&loop=1&playlist=${data.youtube_url}`}
                                    title={data.title}
                                    frameBorder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowFullScreen
                                    onLoad={() => setIsLoaded(true)}
                                />
                            ) : (
                                <>
                                    {/* Thumbnail - shown while loading */}
                                    {!isLoaded && (
                                        <img
                                            src={data.thumbnail_url.startsWith('http') ? data.thumbnail_url : `/storage/${data.thumbnail_url}`}
                                            alt="Video Preview"
                                            className="absolute inset-0 w-full h-full object-cover"
                                        />
                                    )}

                                    {/* Video - lazy loaded when in view */}
                                    {isInView && (
                                        <video
                                            ref={videoRef}
                                            autoPlay
                                            loop
                                            muted
                                            playsInline
                                            preload="metadata"
                                            onLoadedData={() => {
                                                console.log('Video loaded successfully');
                                                setIsLoaded(true);
                                                // Force play jika tidak autoplay
                                                videoRef.current?.play().catch(err => {
                                                    console.log('Autoplay prevented:', err);
                                                });
                                            }}
                                            onError={(e) => {
                                                console.error('Video error:', e);
                                                console.error('Video src:', data.video_url.startsWith('http') ? data.video_url : `/storage/${data.video_url}`);
                                            }}
                                            className={`w-full h-full object-cover transition-opacity duration-500 ${isLoaded ? 'opacity-100' : 'opacity-0'
                                                }`}
                                        >
                                            <source src={data.video_url.startsWith('http') ? data.video_url : `/storage/${data.video_url}`} type="video/mp4" />
                                            {data.video_webm_url && <source src={data.video_webm_url.startsWith('http') ? data.video_webm_url : `/storage/${data.video_webm_url}`} type="video/webm" />}
                                        </video>
                                    )}
                                </>
                            )}

                            {/* Unmute Button */}
                            {isLoaded && (
                                <button
                                    onClick={toggleMute}
                                    className="absolute top-3 right-3 sm:top-6 sm:right-6 bg-white/90 backdrop-blur-sm hover:bg-white p-2 sm:p-3 rounded-full shadow-lg transition-all hover:scale-110 group"
                                    title={isMuted ? "Aktifkan Suara" : "Matikan Suara"}
                                >
                                    {isMuted ? (
                                        <VolumeX className="w-4 h-4 sm:w-5 sm:h-5 text-gray-700" />
                                    ) : (
                                        <Volume2 className="w-4 h-4 sm:w-5 sm:h-5 text-blue-600" />
                                    )}
                                </button>
                            )}

                            {/* Loading Indicator */}
                            {isInView && !isLoaded && (
                                <div className="absolute inset-0 flex items-center justify-center bg-black/20">
                                    <div className="flex flex-col items-center gap-3">
                                        <div className="w-12 h-12 border-4 border-white/30 border-t-white rounded-full animate-spin"></div>
                                        <p className="text-white text-sm font-medium">Memuat video...</p>
                                    </div>
                                </div>
                            )}
                        </div>
                    </div>


                </div>
            </div>
        </section>
    );
}
