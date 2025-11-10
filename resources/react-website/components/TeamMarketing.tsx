import { useState, useEffect, useRef } from "react";

interface TeamMember {
    id: number;
    name: string;
    role?: string | null;
    src: string;
}

export function TeamMarketing() {
    const [teamMembers, setTeamMembers] = useState<TeamMember[]>([]);
    const [loading, setLoading] = useState(true);
    const carouselRef = useRef<HTMLDivElement>(null);
    const scrollAmountRef = useRef(0);
    const animationFrameRef = useRef<number>();

    useEffect(() => {
        fetchTeamMembers();
    }, []);

    useEffect(() => {
        if (teamMembers.length === 0 || !carouselRef.current) return;

        const carousel = carouselRef.current;
        const scrollSpeed = 0.5;

        const autoScroll = () => {
            if (!carousel) return;

            scrollAmountRef.current += scrollSpeed;

            // Reset ke awal saat mencapai setengah (karena kita duplikasi 2x)
            const maxScroll = carousel.scrollWidth / 2;
            if (scrollAmountRef.current >= maxScroll) {
                scrollAmountRef.current = 0;
            }

            carousel.scrollLeft = scrollAmountRef.current;
            animationFrameRef.current = requestAnimationFrame(autoScroll);
        };

        animationFrameRef.current = requestAnimationFrame(autoScroll);

        // Pause on hover
        const handleMouseEnter = () => {
            if (animationFrameRef.current) {
                cancelAnimationFrame(animationFrameRef.current);
            }
        };

        const handleMouseLeave = () => {
            animationFrameRef.current = requestAnimationFrame(autoScroll);
        };

        carousel.addEventListener("mouseenter", handleMouseEnter);
        carousel.addEventListener("mouseleave", handleMouseLeave);

        return () => {
            if (animationFrameRef.current) {
                cancelAnimationFrame(animationFrameRef.current);
            }
            carousel.removeEventListener("mouseenter", handleMouseEnter);
            carousel.removeEventListener("mouseleave", handleMouseLeave);
        };
    }, [teamMembers]);

    const fetchTeamMembers = async () => {
        try {
            const response = await fetch('/api/public/team-members');
            const data = await response.json();
            setTeamMembers(Array.isArray(data) ? data : []);
            setLoading(false);
        } catch (error) {
            console.error('Error:', error);
            setLoading(false);
        }
    };

    if (loading || teamMembers.length === 0) {
        return null;
    }

    // Duplikasi 2x untuk infinite scroll
    const displayMembers = [...teamMembers, ...teamMembers];

    return (
        <section className="py-20 bg-gradient-to-b from-white to-blue-50">
            <div className="container mx-auto px-4 lg:px-8">
                <div className="text-center max-w-3xl mx-auto mb-16">
                    <h2 className="text-3xl lg:text-4xl font-bold mb-4">
                        Tim Kami
                    </h2>
                    <p className="text-lg text-gray-600">
                        Kenalan dengan tim yang siap membantu kesuksesan Anda
                    </p>
                </div>

                <div className="relative pt-4 pb-12">
                    <div 
                        ref={carouselRef}
                        className="flex gap-6 overflow-x-hidden px-4 py-4"
                        style={{
                            scrollbarWidth: 'none',
                            msOverflowStyle: 'none',
                            WebkitOverflowScrolling: 'touch',
                            maskImage: 'linear-gradient(to right, transparent, black 5%, black 95%, transparent)',
                            WebkitMaskImage: 'linear-gradient(to right, transparent, black 5%, black 95%, transparent)',
                        }}
                    >
                        {displayMembers.map((member, index) => (
                            <div
                                key={`${member.id}-${index}`}
                                className="flex-shrink-0 w-48 group mb-2"
                            >
                                <div className="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden group-hover:scale-105">
                                    <div className="relative aspect-square bg-gradient-to-br from-blue-100 to-blue-200">
                                        <img
                                            src={member.src.startsWith('http') ? member.src : `/storage/${member.src}`}
                                            alt={member.name}
                                            className="w-full h-full object-cover"
                                        />
                                    </div>
                                    <div className="p-4">
                                        <h3 className="text-center text-sm font-bold text-gray-900 truncate">
                                            {member.name}
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        ))}
                    </div>
                </div>

                {/* CTA WhatsApp */}
                <div className="text-center mt-12">
                    <p className="text-gray-600 mb-6">
                        Punya pertanyaan? Tim kami siap membantu Anda!
                    </p>
                    <a
                        href="https://wa.me/6281234567890?text=Halo,%20saya%20ingin%20bertanya%20tentang%20program%20bimbingan"
                        target="_blank"
                        rel="noopener noreferrer"
                        className="inline-flex items-center gap-3 px-8 py-4 bg-green-500 hover:bg-green-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all"
                    >
                        <svg className="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                        </svg>
                        Hubungi Kami di WhatsApp
                    </a>
                </div>
            </div>
        </section>
    );
}
