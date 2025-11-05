import { useState, useEffect } from "react";
import { useParams, useNavigate } from "react-router-dom";
import {
    Clock, Users, Award, BookOpen, DollarSign, Check,
    ArrowLeft, Star, Calendar, MessageCircle
} from "lucide-react";
import { Button } from "../components/ui/button";
import { Card, CardContent } from "../components/ui/card";
import { Badge } from "../components/ui/badge";
import { ImageWithFallback } from "../components/figma/ImageWithFallback";

interface Program {
    id: number;
    slug: string;
    title: string;
    description: string;
    image: string;
    duration?: string;
    students?: string;
    level?: string;
    price?: string;
    pages?: string;
    questions?: string;
    tag?: string;
    product_type: string;
    audience_type: string;
    features?: string | null;
    schedule?: string | null;
    benefits?: string | null;
}

export function ProgramDetailPage() {
    const { slug } = useParams<{ slug: string }>();
    const navigate = useNavigate();
    const [program, setProgram] = useState<Program | null>(null);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        fetchProgram();
    }, [slug]);

    const fetchProgram = async () => {
        try {
            setLoading(true);
            const response = await fetch(`/api/public/program-details/${slug}`);
            
            if (!response.ok) {
                throw new Error('Program not found');
            }
            
            const result = await response.json();
            const data = result.data || result;
            
            setProgram(data);
        } catch (error) {
            console.error("Error fetching program:", error);
            setProgram(null);
        } finally {
            setLoading(false);
        }
    };

    if (loading) {
        return (
            <div className="min-h-screen flex items-center justify-center">
                <div className="text-center">
                    <div className="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mx-auto"></div>
                    <p className="mt-4 text-muted-foreground">Memuat detail program...</p>
                </div>
            </div>
        );
    }

    if (!program) {
        return (
            <div className="min-h-screen flex items-center justify-center">
                <div className="text-center">
                    <h2 className="text-2xl font-bold mb-4">Program Tidak Ditemukan</h2>
                    <Button onClick={() => navigate("/#programs")} className="bg-blue-600">
                        <ArrowLeft className="mr-2" size={16} />
                        Kembali ke Program
                    </Button>
                </div>
            </div>
        );
    }

    // Parse features from JSON - no fallback
    let features: string[] = [];
    if (program.features) {
        try {
            const parsed = typeof program.features === 'string' ? JSON.parse(program.features) : program.features;
            if (Array.isArray(parsed) && parsed.length > 0) {
                features = parsed;
            }
        } catch (e) {
            console.error('Error parsing features:', e);
        }
    }

    // Parse schedule from JSON - no fallback
    let schedule: any[] = [];
    if (program.schedule) {
        try {
            const parsed = typeof program.schedule === 'string' ? JSON.parse(program.schedule) : program.schedule;
            if (Array.isArray(parsed) && parsed.length > 0) {
                schedule = parsed;
            }
        } catch (e) {
            console.error('Error parsing schedule:', e);
        }
    }

    return (
        <div className="min-h-screen bg-gray-50">
            {/* Back Button */}
            <div className="bg-white border-b">
                <div className="container mx-auto px-4 lg:px-8 py-4">
                    <button
                        onClick={() => navigate("/#programs")}
                        className="inline-flex items-center gap-2 text-blue-600 hover:text-blue-700 transition-colors"
                    >
                        <ArrowLeft size={20} />
                        Kembali ke Program
                    </button>
                </div>
            </div>

            {/* Hero Section */}
            <section className="bg-white py-12">
                <div className="container mx-auto px-4 lg:px-8">
                    <div className="grid lg:grid-cols-2 gap-12 items-start">
                        {/* Image */}
                        <div className="relative">
                            {program.tag && (
                                <Badge className="absolute top-4 left-4 z-10 bg-blue-600 text-lg px-4 py-2">
                                    {program.tag}
                                </Badge>
                            )}
                            <ImageWithFallback
                                src={program.image}
                                alt={program.title}
                                className="w-full h-[400px] object-cover rounded-2xl shadow-lg"
                            />
                        </div>

                        {/* Info */}
                        <div>
                            <h1 className="text-4xl font-bold mb-4">{program.title}</h1>
                            <p className="text-lg text-gray-600 mb-6">{program.description}</p>

                            {/* Stats */}
                            <div className="grid grid-cols-2 gap-4 mb-6">
                                {program.duration && (
                                    <div className="flex items-center gap-3 p-4 bg-blue-50 rounded-lg">
                                        <Clock className="text-blue-600" size={24} />
                                        <div>
                                            <p className="text-sm text-gray-600">Durasi</p>
                                            <p className="font-semibold">{program.duration}</p>
                                        </div>
                                    </div>
                                )}
                                {program.students && (
                                    <div className="flex items-center gap-3 p-4 bg-green-50 rounded-lg">
                                        <Users className="text-green-600" size={24} />
                                        <div>
                                            <p className="text-sm text-gray-600">Peserta</p>
                                            <p className="font-semibold">{program.students}</p>
                                        </div>
                                    </div>
                                )}
                                {program.level && (
                                    <div className="flex items-center gap-3 p-4 bg-purple-50 rounded-lg">
                                        <Award className="text-purple-600" size={24} />
                                        <div>
                                            <p className="text-sm text-gray-600">Level</p>
                                            <p className="font-semibold">{program.level}</p>
                                        </div>
                                    </div>
                                )}
                                {program.questions && (
                                    <div className="flex items-center gap-3 p-4 bg-orange-50 rounded-lg">
                                        <BookOpen className="text-orange-600" size={24} />
                                        <div>
                                            <p className="text-sm text-gray-600">Bank Soal</p>
                                            <p className="font-semibold">{program.questions}</p>
                                        </div>
                                    </div>
                                )}
                            </div>

                            {/* Price & CTA */}
                            <div className="bg-gradient-to-r from-blue-600 to-blue-700 text-white p-6 rounded-xl mb-6">
                                <div className="flex items-center justify-between mb-4">
                                    <div>
                                        <p className="text-blue-100 text-sm">Investasi Anda</p>
                                        <p className="text-3xl font-bold">{program.price}</p>
                                    </div>
                                    <DollarSign size={48} className="text-blue-200" />
                                </div>
                                <Button className="w-full bg-white text-blue-600 hover:bg-blue-50 font-semibold text-lg py-6">
                                    Daftar Sekarang
                                </Button>
                            </div>

                            {/* Rating */}
                            <div className="flex items-center gap-4 p-4 bg-gray-50 rounded-lg">
                                <div className="flex items-center gap-1">
                                    {[1, 2, 3, 4, 5].map((star) => (
                                        <Star key={star} size={20} className="fill-yellow-400 text-yellow-400" />
                                    ))}
                                </div>
                                <div>
                                    <p className="font-semibold">4.9/5.0</p>
                                    <p className="text-sm text-gray-600">dari 1,200+ review</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {/* Features Section */}
            {features.length > 0 && (
                <section className="py-12 bg-white">
                    <div className="container mx-auto px-4 lg:px-8">
                        <div className="max-w-4xl mx-auto">
                            <h2 className="text-3xl font-bold mb-8">Yang Akan Anda Dapatkan</h2>
                            <div className="grid md:grid-cols-2 gap-4">
                                {features.map((feature: string, index: number) => (
                                    <div key={index} className="flex items-start gap-3 p-4 bg-gray-50 rounded-lg">
                                        <Check className="text-green-600 flex-shrink-0 mt-1" size={20} />
                                        <p className="text-gray-700">{feature}</p>
                                    </div>
                                ))}
                            </div>
                        </div>
                    </div>
                </section>
            )}

            {/* Schedule Section */}
            {schedule.length > 0 && (
                <section className="py-12">
                    <div className="container mx-auto px-4 lg:px-8">
                        <div className="max-w-4xl mx-auto">
                            <h2 className="text-3xl font-bold mb-8">Jadwal Pembelajaran</h2>
                            <div className="space-y-4">
                                {schedule.map((item: any, index: number) => (
                                    <Card key={index}>
                                        <CardContent className="p-6 flex items-center gap-4">
                                            <div className="flex items-center justify-center w-12 h-12 bg-blue-600 text-white rounded-full font-bold flex-shrink-0">
                                                {index + 1}
                                            </div>
                                            <div className="flex-1">
                                                <p className="font-semibold text-lg">{item.week}</p>
                                                <p className="text-gray-600">{item.topic}</p>
                                            </div>
                                            <Calendar className="text-gray-400" size={24} />
                                        </CardContent>
                                    </Card>
                                ))}
                            </div>
                        </div>
                    </div>
                </section>
            )}

            {/* CTA Section */}
            <section className="py-16 bg-gradient-to-br from-blue-600 to-blue-800 text-white">
                <div className="container mx-auto px-4 lg:px-8">
                    <div className="max-w-3xl mx-auto text-center">
                        <h2 className="text-3xl font-bold mb-4">
                            Siap Memulai Perjalanan Menuju Lulus UKOM?
                        </h2>
                        <p className="text-xl text-blue-100 mb-8">
                            Bergabunglah dengan ribuan alumni yang telah berhasil lulus UKOM
                        </p>
                        <div className="flex flex-col sm:flex-row gap-4 justify-center">
                            <Button className="bg-white text-blue-600 hover:bg-blue-50 font-semibold text-lg px-8 py-6">
                                Daftar Sekarang
                            </Button>
                            <Button className="bg-blue-700 text-white hover:bg-blue-800 font-semibold text-lg px-8 py-6 border-2 border-white/20">
                                <MessageCircle className="mr-2" size={20} />
                                Konsultasi Gratis
                            </Button>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    );
}
