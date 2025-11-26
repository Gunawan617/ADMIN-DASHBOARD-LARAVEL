import { Users, ShoppingBag, BookOpen } from "lucide-react";

export function StatsCards() {
  return (
    <div className="relative z-40 px-4 -mt-10 mb-13">
      <div className="container mx-auto max-w-7xl">
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 lg:gap-6">
          {/* Stat Card 1 */}
          <div className="bg-white rounded-xl shadow-2xl p-3 lg:p-4 border border-gray-100 hover:shadow-3xl transition-all hover:-translate-y-1 backdrop-blur-sm bg-white/95">
            <div className="flex items-center gap-3">
              <div className="w-11 h-11 lg:w-12 lg:h-12 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg">
                <Users className="w-5 h-5 lg:w-6 lg:h-6 text-white" />
              </div>
              <div className="min-w-0">
                <div className="text-xl lg:text-2xl font-bold text-gray-900">221K+</div>
                <p className="text-xs lg:text-sm text-gray-600 font-medium mt-0.5">Pengguna Aktif</p>
              </div>
            </div>
          </div>

          {/* Stat Card 2 */}
          <div className="bg-white rounded-xl shadow-2xl p-3 lg:p-4 border border-gray-100 hover:shadow-3xl transition-all hover:-translate-y-1 backdrop-blur-sm bg-white/95">
            <div className="flex items-center gap-3">
              <div className="w-11 h-11 lg:w-12 lg:h-12 bg-gradient-to-br from-cyan-400 to-cyan-600 rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg">
                <ShoppingBag className="w-5 h-5 lg:w-6 lg:h-6 text-white" />
              </div>
              <div className="min-w-0">
                <div className="text-xl lg:text-2xl font-bold text-gray-900">786K+</div>
                <p className="text-xs lg:text-sm text-gray-600 font-medium mt-0.5">Try Out Selesai</p>
              </div>
            </div>
          </div>

          {/* Stat Card 3 */}
          <div className="bg-white rounded-xl shadow-2xl p-3 lg:p-4 border border-gray-100 hover:shadow-3xl transition-all hover:-translate-y-1 backdrop-blur-sm bg-white/95 md:col-span-2 lg:col-span-1">
            <div className="flex items-center gap-3">
              <div className="w-11 h-11 lg:w-12 lg:h-12 bg-gradient-to-br from-purple-400 to-purple-600 rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg">
                <BookOpen className="w-5 h-5 lg:w-6 lg:h-6 text-white" />
              </div>
              <div className="min-w-0">
                <div className="text-xl lg:text-2xl font-bold text-gray-900">69K+</div>
                <p className="text-xs lg:text-sm text-gray-600 font-medium mt-0.5">Alumni Kompeten</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}
