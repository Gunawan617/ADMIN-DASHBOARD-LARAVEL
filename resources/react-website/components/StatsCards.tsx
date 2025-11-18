import { Users, ShoppingBag, BookOpen } from "lucide-react";

export function StatsCards() {
  return (
    <div className="relative z-50 px-4 -mt-16 mb-16">
      <div className="container mx-auto max-w-5xl">
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3 lg:gap-4">
          {/* Stat Card 1 */}
          <div className="bg-white rounded-xl shadow-2xl p-4 border border-gray-100 hover:shadow-3xl transition-all hover:-translate-y-1 backdrop-blur-sm bg-white/95">
            <div className="flex items-center gap-3">
              <div className="w-12 h-12 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg">
                <Users className="w-6 h-6 text-white" />
              </div>
              <div className="min-w-0">
                <div className="text-2xl lg:text-3xl font-bold text-gray-900">221K+</div>
                <p className="text-xs text-gray-600 font-medium">Pengguna Aktif</p>
              </div>
            </div>
          </div>

          {/* Stat Card 2 */}
          <div className="bg-white rounded-xl shadow-2xl p-4 border border-gray-100 hover:shadow-3xl transition-all hover:-translate-y-1 backdrop-blur-sm bg-white/95">
            <div className="flex items-center gap-3">
              <div className="w-12 h-12 bg-gradient-to-br from-cyan-400 to-cyan-600 rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg">
                <ShoppingBag className="w-6 h-6 text-white" />
              </div>
              <div className="min-w-0">
                <div className="text-2xl lg:text-3xl font-bold text-gray-900">786K+</div>
                <p className="text-xs text-gray-600 font-medium">Try Out Selesai</p>
              </div>
            </div>
          </div>

          {/* Stat Card 3 */}
          <div className="bg-white rounded-xl shadow-2xl p-4 border border-gray-100 hover:shadow-3xl transition-all hover:-translate-y-1 backdrop-blur-sm bg-white/95 md:col-span-2 lg:col-span-1">
            <div className="flex items-center gap-3">
              <div className="w-12 h-12 bg-gradient-to-br from-purple-400 to-purple-600 rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg">
                <BookOpen className="w-6 h-6 text-white" />
              </div>
              <div className="min-w-0">
                <div className="text-2xl lg:text-3xl font-bold text-gray-900">69K+</div>
                <p className="text-xs text-gray-600 font-medium">Alumni Kompeten</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}
