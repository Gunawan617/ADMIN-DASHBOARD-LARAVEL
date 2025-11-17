import { useState, useEffect } from "react";
import { ChevronDown, HelpCircle, ArrowRight } from "lucide-react";
import { Link } from "react-router-dom";

interface FAQ {
    id: number;
    question: string;
    answer: string;
    category: string;
    order: number;
    is_active: boolean;
}

export function FAQ() {
    const [faqs, setFaqs] = useState<FAQ[]>([]);
    const [openIndex, setOpenIndex] = useState<number | null>(0); // Default buka yang pertama

    useEffect(() => {
        fetchFAQs();
    }, []);

    const fetchFAQs = async () => {
        try {
            const response = await fetch('/api/public/faqs');
            const data = await response.json();
            // Ambil hanya 6 FAQ pertama untuk homepage
            setFaqs(data.slice(0, 6));
        } catch (error) {
            console.error('Error fetching FAQs:', error);
        }
    };

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

    if (faqs.length === 0) return null;

    return (
        <section className="py-20 bg-gradient-to-b from-white to-blue-50">
            <div className="container mx-auto px-4 lg:px-8">
                {/* Header */}
                <div className="text-center mb-12">
                    <div className="inline-flex items-center justify-center w-16 h-16 bg-blue-100 rounded-full mb-4">
                        <HelpCircle className="w-8 h-8 text-blue-600" />
                    </div>
                    <h2 className="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">
                        Pertanyaan yang Sering Ditanyakan
                    </h2>
                    <p className="text-xl text-gray-600 max-w-2xl mx-auto">
                        Temukan jawaban untuk pertanyaan umum seputar program kami
                    </p>
                </div>

                {/* FAQ List */}
                <div className="max-w-4xl mx-auto space-y-4 mb-8">
                    {faqs.map((faq, index) => (
                        <div
                            key={faq.id}
                            className="bg-white rounded-xl shadow-md hover:shadow-lg transition-all overflow-hidden border border-gray-100"
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
                                    className={`w-6 h-6 text-gray-400 flex-shrink-0 transition-transform duration-300 ${openIndex === index ? 'transform rotate-180' : ''
                                        }`}
                                />
                            </button>

                            <div
                                className={`overflow-hidden transition-all duration-300 ${openIndex === index ? 'max-h-96' : 'max-h-0'
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

                {/* CTA Button */}
                <div className="text-center">
                    <Link
                        to="/faq"
                        className="inline-flex items-center gap-2 px-8 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold rounded-xl shadow-lg hover:from-blue-700 hover:to-indigo-700 transition-all transform hover:scale-105"
                    >
                        Lihat Semua FAQ
                        <ArrowRight className="w-5 h-5" />
                    </Link>
                </div>
            </div>
        </section>
    );
}
