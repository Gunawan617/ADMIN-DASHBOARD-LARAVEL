import { Link } from "react-router-dom";
import { BookOpen, X } from "lucide-react";
import { useState, useEffect } from "react";

interface Program {
  id: number;
  title: string;
  tag?: string | null;
  card_type: string;
  sold_count?: string | null;
  features: string[];
  price: string;
  link: string;
  type: 'bimbel' | 'tryout' | 'bundle';
  major: string;
  order: number;
  is_active: boolean;
  created_at?: string;
  updated_at?: string;
}

interface ProgramsNewProps {
  onMajorChange?: (major: string) => void;
}

export function ProgramsNew({ onMajorChange }: ProgramsNewProps) {
  const [programs, setPrograms] = useState<Program[]>([]);
  const [availableMajors, setAvailableMajors] = useState<string[]>(['Keperawatan', 'Kebidanan']);
  const [loading, setLoading] = useState(true);
  const [showFilterModal, setShowFilterModal] = useState(false);
  const [filterStep, setFilterStep] = useState<'type' | 'selection'>('type');
  const [selectedType, setSelectedType] = useState<'bimbel' | 'tryout' | 'bundle' | null>('bimbel');
  const [selectedMajor, setSelectedMajor] = useState<string | null>('Keperawatan');
  const [tempMajor, setTempMajor] = useState<string | null>('Keperawatan');

  useEffect(() => {
    fetchMajors();
  }, []);

  const fetchMajors = async () => {
    try {
      const response = await fetch('/api/public/program-news?get_majors=1');
      const data = await response.json();
      if (data.majors && data.majors.length > 0) {
        setAvailableMajors(data.majors);
      }
    } catch (error) {
      console.error('Error fetching majors:', error);
    }
  };

  useEffect(() => {
    fetchPrograms();
  }, [selectedType, selectedMajor]);

  const fetchPrograms = async () => {
    try {
      setLoading(true);
      const params = new URLSearchParams();
      if (selectedType) params.append('type', selectedType);
      if (selectedMajor) params.append('major', selectedMajor);


      const response = await fetch(`/api/public/program-news?${params}`);
      const data = await response.json();
      setPrograms(data);
    } catch (error) {
      console.error('Error fetching programs:', error);
    } finally {
      setLoading(false);
    }
  };

  const handleOpenFilter = () => {
    setShowFilterModal(true);
    setFilterStep('type');
    setTempMajor(selectedMajor);

  };

  const handleTypeSelect = (type: 'bimbel' | 'tryout' | 'bundle') => {
    setSelectedType(type);
    setFilterStep('selection');
  };

  const handleApplyFilter = () => {
    if (tempMajor) {
      setSelectedMajor(tempMajor);
      if (onMajorChange) {
        onMajorChange(tempMajor);
      }
      setShowFilterModal(false);
    }
  };

  const getDisplayText = () => {
    if (!selectedType) return 'Pilih Program';
    const typeText = selectedType === 'bimbel' ? 'Bimbel' : selectedType === 'tryout' ? 'Try Out' : 'Bundle';
    const majorText = selectedMajor || '';

    if (selectedMajor) return `${typeText} - ${majorText}`;
    return typeText;
  };

  return (
    <section className="min-h-screen bg-[#f5f5f5] py-10 px-5 -mt-20">
      <div className="max-w-[1200px] mx-auto">
        {/* Header */}
        <div className="text-center mb-8">
          <h1 className="invisible text-3xl font-bold text-[#1a202c] mb-6">
            Grab it Now
          </h1>
          <h1 className="text-[40px] font-bold text-[#1a202c] mb-6">
            Pilih Paket Belajarmu
          </h1>


          {/* Dropdown Selector */}
          <button
            onClick={handleOpenFilter}
            className="bg-[#1e293b] text-white px-7 py-3 rounded-lg font-semibold inline-flex items-center gap-2 hover:bg-[#334155] transition-all shadow-[0_2px_8px_rgba(30,41,59,0.15)] hover:shadow-[0_4px_12px_rgba(30,41,59,0.2)] hover:-translate-y-0.5 text-xl"
          >
            {getDisplayText()}
            <span className="text-xs">▼</span>
          </button>
        </div>

        {/* Programs Grid */}
        {loading ? (
          <div className="text-center py-16">
            <div className="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mx-auto mb-4"></div>
            <p className="text-gray-600">Memuat program...</p>
          </div>
        ) : (
          <>
            <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
              {programs.map((program) => (
                <ProgramCard key={program.id} program={program} />
              ))}
            </div>

            {/* Empty State */}
            {programs.length === 0 && (
              <div className="text-center py-16">
                <div className="text-6xl mb-4">📦</div>
                <h3 className="text-xl font-bold text-gray-900 mb-2">Belum Ada Program</h3>
                <p className="text-gray-600">Program untuk kategori ini sedang dalam pengembangan</p>
              </div>
            )}
          </>
        )}
      </div>

      {/* Filter Modal */}
      {showFilterModal && (
        <FilterModal
          step={filterStep}
          tempMajor={tempMajor}

          availableMajors={availableMajors}
          onClose={() => setShowFilterModal(false)}
          onTypeSelect={handleTypeSelect}
          onMajorSelect={setTempMajor}
          onApply={handleApplyFilter}
        />
      )}
    </section>
  );
}

interface FilterModalProps {
  step: 'type' | 'selection';
  tempMajor: string | null;

  availableMajors: string[];
  onClose: () => void;
  onTypeSelect: (type: 'bimbel' | 'tryout' | 'bundle') => void;
  onMajorSelect: (major: string) => void;

  onApply: () => void;
}

function FilterModal({ step, tempMajor, availableMajors, onClose, onTypeSelect, onMajorSelect, onApply }: FilterModalProps) {
  const getMajorIcon = (major: string) => {
    const lowerMajor = major.toLowerCase();
    if (lowerMajor.includes('keperawatan')) return '👨‍⚕️';
    if (lowerMajor.includes('kebidanan')) return '👩‍⚕️';
    if (lowerMajor.includes('gizi')) return '🥗';
    if (lowerMajor.includes('farmasi')) return '💊';
    if (lowerMajor.includes('analis')) return '🔬';
    return '🎓';
  };

  const getMajorColor = (major: string) => {
    const lowerMajor = major.toLowerCase();
    if (lowerMajor.includes('keperawatan')) return 'bg-blue-100';
    if (lowerMajor.includes('kebidanan')) return 'bg-pink-100';
    if (lowerMajor.includes('gizi')) return 'bg-green-100';
    if (lowerMajor.includes('farmasi')) return 'bg-purple-100';
    if (lowerMajor.includes('analis')) return 'bg-yellow-100';
    return 'bg-gray-100';
  };
  return (
    <div className="fixed inset-0 bg-black/50 backdrop-blur-sm z-[100] flex items-center justify-center p-2 md:p-4" onClick={onClose}>
      <div className="bg-white rounded-xl md:rounded-2xl max-w-3xl w-full max-h-[95vh] md:max-h-[90vh] overflow-y-auto shadow-2xl relative" onClick={(e) => e.stopPropagation()}>
        {/* Close Button */}
        <button
          onClick={onClose}
          className="absolute top-2 right-2 md:top-3 md:right-3 p-1.5 hover:bg-gray-100 rounded-lg transition-colors z-10"
        >
          <X className="w-5 h-5 text-gray-600" />
        </button>

        <div className="p-4 md:p-6">
          {/* Step 1: Select Type (Bimbel or Try Out) */}
          {step === 'type' && (
            <div className="text-center">
              <h2 className="text-xl md:text-2xl font-bold text-[#1a202c] mb-2">Pilih Tipe Program</h2>
              <p className="text-xs md:text-sm text-gray-500 mb-4 md:mb-6">Pilih antara Bimbel atau Try Out untuk memulai</p>

              <div className="grid grid-cols-1 md:grid-cols-3 gap-3 md:gap-4 max-w-3xl mx-auto">
                <button
                  onClick={() => onTypeSelect('bimbel')}
                  className="p-4 md:p-6 border-2 border-gray-200 rounded-lg md:rounded-xl hover:border-blue-500 hover:bg-blue-50 transition-all group"
                >
                  <div className="text-3xl md:text-4xl mb-2 md:mb-3">🎓</div>
                  <h3 className="text-base md:text-lg font-bold text-gray-900 mb-1">Bimbel</h3>
                  <p className="text-[10px] md:text-xs text-gray-600">Program bimbingan belajar lengkap</p>
                </button>

                <button
                  onClick={() => onTypeSelect('tryout')}
                  className="p-4 md:p-6 border-2 border-gray-200 rounded-lg md:rounded-xl hover:border-blue-500 hover:bg-blue-50 transition-all group"
                >
                  <div className="text-3xl md:text-4xl mb-2 md:mb-3">📝</div>
                  <h3 className="text-base md:text-lg font-bold text-gray-900 mb-1">Try Out</h3>
                  <p className="text-[10px] md:text-xs text-gray-600">Latihan soal dan simulasi ujian</p>
                </button>

                <button
                  onClick={() => onTypeSelect('bundle')}
                  className="p-4 md:p-6 border-2 border-gray-200 rounded-lg md:rounded-xl hover:border-blue-500 hover:bg-blue-50 transition-all group"
                >
                  <div className="text-3xl md:text-4xl mb-2 md:mb-3">📦</div>
                  <h3 className="text-base md:text-lg font-bold text-gray-900 mb-1">Bundle</h3>
                  <p className="text-[10px] md:text-xs text-gray-600">Paket hemat Bimbel + Try Out</p>
                </button>
              </div>
            </div>
          )}

          {/* Step 2: Select Major and Level Together */}
          {step === 'selection' && (
            <div className="text-center">
              {/* Pilih Jurusan */}
              <h2 className="text-xl md:text-2xl font-bold text-[#1a202c] mb-2">Pilih Jurusan</h2>
              <p className="text-xs md:text-sm text-gray-500 mb-4 md:mb-5">Mulai perjalanan UKOM-mu dengan memilih jurusan yang sesuai</p>

              <div className={`grid gap-2 md:gap-3 mb-6 md:mb-8 ${availableMajors.length === 1 ? 'grid-cols-1 max-w-xs mx-auto' :
                availableMajors.length === 2 ? 'grid-cols-2 max-w-md mx-auto' :
                  availableMajors.length === 3 ? 'grid-cols-3' :
                    availableMajors.length === 4 ? 'grid-cols-2 md:grid-cols-4' :
                      'grid-cols-2 md:grid-cols-3 lg:grid-cols-5'
                }`}>
                {availableMajors.map((major) => (
                  <button
                    key={major}
                    onClick={() => onMajorSelect(major)}
                    className={`p-2 md:p-4 border-2 rounded-lg md:rounded-xl transition-all ${tempMajor === major
                      ? 'border-blue-500 bg-blue-50'
                      : 'border-gray-200 hover:border-blue-500 hover:bg-blue-50'
                      }`}
                  >
                    <div className={`w-12 h-12 md:w-16 md:h-16 mx-auto mb-1 md:mb-2 ${getMajorColor(major)} rounded-full flex items-center justify-center text-2xl md:text-3xl`}>
                      {getMajorIcon(major)}
                    </div>
                    <h3 className="text-xs md:text-base font-bold text-gray-900">{major}</h3>
                  </button>
                ))}
              </div>



              <div className="mt-4 md:mt-6">
                <button
                  onClick={onApply}
                  disabled={!tempMajor}
                  className="bg-blue-600 text-white px-8 md:px-10 py-2.5 md:py-3 rounded-lg font-bold text-sm md:text-base hover:bg-blue-700 transition-all shadow-lg disabled:bg-gray-400 disabled:cursor-not-allowed w-full md:w-auto"
                >
                  Mulai Sekarang
                </button>
                <p className="text-[10px] md:text-xs text-gray-500 mt-2 md:mt-3">
                  Sudah memiliki akun Klinik Ukom? <Link to="/login" className="text-blue-600 font-semibold hover:underline">Login</Link>
                </p>
              </div>
            </div>
          )}
        </div>
      </div>
    </div>
  );
}

function ProgramCard({ program }: { program: Program }) {
  const [showModal, setShowModal] = useState(false);

  return (
    <>
      <div className="bg-white rounded-xl overflow-hidden transition-all duration-300 shadow-[0_2px_12px_rgba(0,0,0,0.08)] border border-[#e5e7eb] hover:-translate-y-2 hover:shadow-[0_12px_32px_rgba(0,0,0,0.12)] hover:border-[#2563eb] relative flex flex-col font-['Helvetica',sans-serif]">
        {/* Header with gradient */}
        <div className="relative bg-gradient-to-br from-[#2563eb] to-[#1e40af] px-5 pt-4 pb-10 overflow-hidden h-[110px]">
          {/* Badge */}
          {program.tag && (
            <div className="absolute top-3 right-3 z-20 bg-gradient-to-br from-[#f59e0b] to-[#d97706] text-white px-3 py-1 rounded text-xs font-bold uppercase shadow-[0_2px_8px_rgba(245,158,11,0.3)]">
              {program.tag}
            </div>
          )}

          {/* Icon and Label */}
          <div className="relative z-10 text-white text-base font-semibold flex items-center gap-2 mt-2">
            <span>{program.card_type}</span>
          </div>

          {/* Wave decoration */}
          <div className="absolute bottom-0 left-0 right-0 h-[30px] bg-white rounded-t-[20px] z-10"></div>
        </div>

        {/* Content */}
        <div className="bg-white px-6 pt-5 pb-6 flex flex-col flex-1">
          <h3 className="text-base font-bold text-[#1a202c] leading-[1.45] min-h-[68px] mb-4">
            {program.title}
          </h3>

          <div className="mb-5">
            <span className="text-[#2563eb] text-sm font-bold">
              {program.sold_count}
            </span>
          </div>

          <ul className="list-none mb-6 flex-grow">
            {program.features.slice(0, 2).map((feature, idx) => (
              <li key={idx} className="text-[#4b5563] text-sm leading-[1.65] mb-3 pl-7 relative">
                <span className="absolute left-0 top-0.5 text-[#10b981] font-bold w-5 h-5 bg-[#d1fae5] rounded-full flex items-center justify-center text-xs">
                  ✓
                </span>
                {feature}
              </li>
            ))}
          </ul>

          <div className="mb-5">
            <button
              onClick={() => setShowModal(true)}
              className="text-[#2563eb] text-sm font-bold inline-flex items-center gap-1 transition-all hover:text-[#1e40af] hover:gap-2 cursor-pointer"
            >
              selengkapnya ›
            </button>
          </div>

          <div className="flex justify-between items-center pt-5 border-t-2 border-[#f3f4f6] mt-auto">
            <div className="flex flex-col">
              <div className="text-xs text-[#6b7280] font-semibold mb-1.5">Rp</div>
              <div className="text-[2rem] font-bold text-[#1a202c] leading-none">
                {program.price}
              </div>
            </div>
            <Link to="/daftar">
              <button className="bg-[#2563eb] text-white border-none px-6 py-3 rounded-lg font-bold text-base cursor-pointer transition-all shadow-[0_2px_8px_rgba(37,99,235,0.25)] hover:bg-[#1e40af] hover:-translate-y-0.5 hover:shadow-[0_4px_12px_rgba(37,99,235,0.35)] active:translate-y-0">
                Beli
              </button>
            </Link>
          </div>
        </div>
      </div>

      {/* Detail Modal */}
      {showModal && (
        <div className="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4" onClick={() => setShowModal(false)}>
          <div className="bg-white rounded-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto shadow-2xl" onClick={(e) => e.stopPropagation()}>
            <div className="sticky top-0 bg-gradient-to-br from-blue-600 via-blue-700 to-blue-800 text-white p-6 rounded-t-2xl">
              <div className="flex items-start justify-between">
                <div className="flex-1">
                  <div className="flex items-center gap-2 mb-3">
                    <div className="w-10 h-10 bg-white/25 rounded-lg flex items-center justify-center backdrop-blur-sm border border-white/30">
                      <BookOpen className="w-5 h-5" />
                    </div>
                    <span className="font-semibold">{program.card_type}</span>
                  </div>
                  <h3 className="text-xl font-bold leading-tight">{program.title}</h3>
                  {program.sold_count && (
                    <p className="text-blue-100 text-sm mt-2">{program.sold_count}</p>
                  )}
                </div>
                <button
                  onClick={() => setShowModal(false)}
                  className="ml-4 p-2 hover:bg-white/20 rounded-lg transition-colors"
                >
                  <X className="w-5 h-5" />
                </button>
              </div>
            </div>

            <div className="p-6">
              <h4 className="font-bold text-lg mb-4 text-gray-900">Fitur Program:</h4>
              <ul className="space-y-3 mb-6">
                {program.features.map((feature, idx) => (
                  <li key={idx} className="flex items-start gap-3 text-sm text-gray-700">
                    <div className="w-5 h-5 rounded-full bg-gray-900 flex items-center justify-center flex-shrink-0 mt-0.5">
                      <svg className="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fillRule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clipRule="evenodd" />
                      </svg>
                    </div>
                    <span className="flex-1">{feature}</span>
                  </li>
                ))}
              </ul>

              <div className="flex items-center justify-between pt-6 border-t border-gray-200">
                <div>
                  <div className="text-xs text-gray-500 font-medium">Harga</div>
                  <div className="text-3xl font-bold text-gray-900">
                    Rp {program.price}
                  </div>
                </div>
                <Link to="/daftar">
                  <button className="bg-blue-600 hover:bg-blue-700 text-white font-bold px-8 py-3 rounded-lg transition-all shadow-lg hover:shadow-xl">
                    Beli Sekarang
                  </button>
                </Link>
              </div>
            </div>
          </div>
        </div>
      )}
    </>
  );
}
