import { useState, useEffect } from "react";
import { ChevronDown, Search, HelpCircle } from "lucide-react";

interface FAQ {
    id: number;
    question: string;
    answer: string;
    category: string;
    order: number;
    is_active: boolean;
}

export function FAQPage() {
    const [faqs, setFaqs] = useState<FAQ[]>([]);
    const [loading, setLoading] = useState(true);
    const [searchQuery, setSearchQuery] = useState("");
    const [selectedCategory, setSelectedCategory] = useState("all");
    const [openIndex, setOpenIndex] = useState<number | null>(null);

    useEffect(() => {
        fetchFAQs();
    }, []);

    const fetchFAQs = async () => {
        try {
            const response = await fetch('/api/public/faqs');
            const data = await response.json();
            setFaqs(data);
        } catch (error) {
            console.error('Error fetching FAQs:', error);
        } finally {
            setLoading(false);
        }
    };

    const categories = [
        { value: 'all', label: 'Semua' },
        { value: 'general', label: 'Umum' },
        { value: 'program', label: 'Program' },
        { value: 'payment', label: 'Pembayaran' },
        { value: 'technical', label: 'Teknis' },
    ];

    const filteredFAQs = faqs.filter(faq => {
        const matchesSearch = faq.question.toLowerCase().includes(searchQuery.toLowerCase()) ||
                            faq.answer.toLowerCase().includes(searchQuery.toLowerCase());
        const matchesCategory = selectedCategory === 'all' || faq.category === selectedCategory;
        return matchesSearch && matchesCategory;
    });

    const toggleFAQ = (index: number) => {
        setOpenIndex(openIndex === index ? null : index);
    };

    const getCategoryColor = (category: string) => {
        const colors: Record<string, string> = {
            general: 'bg-blue-100 text-blue-800',
            program: 'bg-green-100 text-green-800',
            payment: 'bg-yellow-100 text-yellow-800',
            technical: 'bg-purple-100 text-purple-800',
        };
        return colors[category] || 'bg-gray-100 text-gray-800';
    };

    const getCategoryLabel = (category: string) => {
        const labels: Record<string, string> = {
            general: 'Umum',
            program: 'Program',
            payment: 'Pembayaran',
            technical: 'Teknis',
        };
        return labels[category] || category;
    };

    return (
        <div className="min-h-screen bg-gradient-to-b from-blue-50 to-white">
            {/* Hero Section */}
            <div className="bg-gradient-to-r from-blue-600 to-indigo-700 text-white py-16">
                <div className="container mx-auto px-4 lg:px-8">
                    <div className="max-w-3xl mx-auto text-center">
                        <div className="inline-flex items-center justify-center w-16 h-16 bg-white/20 rounded-full mb-4">
                            <HelpCircle className="w-8 h-8" />
                        </div>
                        <h1 className="text-4xl lg:text-5xl font-bold mb-4">Frequently Asked Questions</h1>
                        <p className="text-xl text-blue-100">
                            Temukan jawaban untuk pertanyaan yang sering ditanyakan
                        </p>
                    </div>
                </div>
            </div>

            <div className="container mx-auto px-4 lg:px-8 py-16">
                <div className="max-w-4xl mx-auto">
                    {/* Search and Filter */}
                    <div className="mb-8 space-y-4">
                        {/* Search Bar */}
                        <div className="relative">
                            <Search className="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400 w-5 h-5" />
                            <input
                                type="text"
                                placeholder="Cari pertanyaan..."
                                value={searchQuery}
                                onChange={(e) => setSearchQuery(e.target.value)}
                                className="w-full pl-12 pr-4 py-4 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent shadow-sm"
                            />
                        </div>

                        {/* Category Filter */}
                        <div className="flex flex-wrap gap-2">
                            {categories.map((category) => (
                                <button
                                    key={category.value}
                                    onClick={() => setSelectedCategory(category.value)}
                                    className={`px-4 py-2 rounded-lg font-medium transition-all ${
                                        selectedCategory === category.value
                                            ? 'bg-blue-600 text-white shadow-md'
                                            : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200'
                                    }`}
                                >
                                    {category.label}
                                </button>
                            ))}
                        </div>
                    </div>

                    {/* FAQ List */}
                    {loading ? (
                        <div className="text-center py-12">
                            <div className="inline-block animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"></div>
                            <p className="mt-4 text-gray-600">Memuat FAQ...</p>
                        </div>
                    ) : filteredFAQs.length === 0 ? (
                        <div className="text-center py-12 bg-white rounded-xl shadow-lg">
                            <HelpCircle className="w-16 h-16 text-gray-300 mx-auto mb-4" />
                            <p className="text-gray-500 text-lg font-medium">Tidak ada FAQ yang ditemukan</p>
                            <p className="text-gray-400 text-sm mt-2">Coba ubah kata kunci pencarian atau kategori</p>
                        </div>
                    ) : (
                        <div className="space-y-4">
                            {filteredFAQs.map((faq, index) => (
                                <div
                                    key={faq.id}
                                    className="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow overflow-hidden"
                                >
                                    <button
                                        onClick={() => toggleFAQ(index)}
                                        className="w-full px-6 py-5 flex items-start justify-between text-left hover:bg-gray-50 transition-colors"
                                    >
                                        <div className="flex-1 pr-4">
                                            <div className="flex items-center gap-2 mb-2">
                                                <span className={`px-3 py-1 rounded-full text-xs font-semibold ${getCategoryColor(faq.category)}`}>
                                                    {getCategoryLabel(faq.category)}
                                                </span>
                                            </div>
                                            <h3 className="text-lg font-bold text-gray-900">
                                                {faq.question}
                                            </h3>
                                        </div>
                                        <ChevronDown
                                            className={`w-6 h-6 text-gray-400 flex-shrink-0 transition-transform ${
                                                openIndex === index ? 'transform rotate-180' : ''
                                            }`}
                                        />
                                    </button>
                                    
                                    <div
                                        className={`overflow-hidden transition-all duration-300 ${
                                            openIndex === index ? 'max-h-96' : 'max-h-0'
                                        }`}
                                    >
                                        <div className="px-6 pb-5 pt-2">
                                            <div className="pl-4 border-l-4 border-blue-500">
                                                <p className="text-gray-700 leading-relaxed whitespace-pre-wrap">
                                                    {faq.answer}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            ))}
                        </div>
                    )}

                    {/* Contact CTA */}
                    <div className="mt-12 bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl shadow-xl p-8 text-center text-white">
                        <h2 className="text-2xl font-bold mb-2">Masih ada pertanyaan?</h2>
                        <p className="text-blue-100 mb-6">
                            Tim kami siap membantu Anda. Hubungi kami untuk informasi lebih lanjut.
                        </p>
                        <a
                            href="/contact"
                            className="inline-flex items-center gap-2 px-8 py-3 bg-white text-blue-600 font-bold rounded-lg hover:bg-blue-50 transition-colors shadow-lg"
                        >
                            <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            Hubungi Kami
                        </a>
                    </div>
                </div>
            </div>
        </div>
    );
}
