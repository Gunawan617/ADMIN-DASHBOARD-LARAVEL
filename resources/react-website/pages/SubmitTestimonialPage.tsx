import { useState, useEffect } from "react";
import { useNavigate } from "react-router-dom";
import { Star, Upload, CheckCircle, AlertCircle, Loader2 } from "lucide-react";
import { Button } from "../components/ui/button";
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from "../components/ui/card";

export function SubmitTestimonialPage() {
  const navigate = useNavigate();
  const [loading, setLoading] = useState(false);
  const [success, setSuccess] = useState(false);
  const [error, setError] = useState<string | null>(null);
  const [isAuthenticated, setIsAuthenticated] = useState(false);
  const [checkingAuth, setCheckingAuth] = useState(true);

  const [formData, setFormData] = useState({
    name: "",
    batch: "",
    major: "",
    program: "",
    testimonial: "",
    rating: 5,
  });

  useEffect(() => {
    checkAuthentication();
  }, []);

  const checkAuthentication = async () => {
    try {
      const token = localStorage.getItem("auth_token");
      if (!token) {
        setIsAuthenticated(false);
        setCheckingAuth(false);
        return;
      }

      const response = await fetch("/api/user/profile", {
        headers: {
          Authorization: `Bearer ${token}`,
          Accept: "application/json",
        },
      });

      if (response.ok) {
        const data = await response.json();
        setIsAuthenticated(true);
        // Auto-fill form with user data
        setFormData((prev) => ({
          ...prev,
          name: data.name || "",
          batch: data.batch || "",
          major: data.major || "",
        }));
      } else {
        setIsAuthenticated(false);
        localStorage.removeItem("auth_token");
        localStorage.removeItem("user");
      }
    } catch (error) {
      console.error("Auth check error:", error);
      setIsAuthenticated(false);
    } finally {
      setCheckingAuth(false);
    }
  };



  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    setLoading(true);
    setError(null);

    try {
      const token = localStorage.getItem("auth_token");
      if (!token) {
        setError("Anda harus login terlebih dahulu");
        setLoading(false);
        return;
      }

      const response = await fetch("/api/user/testimonials", {
        method: "POST",
        headers: {
          Authorization: `Bearer ${token}`,
          Accept: "application/json",
          "Content-Type": "application/json",
        },
        body: JSON.stringify({
          name: formData.name,
          batch: formData.batch,
          major: formData.major,
          program: formData.program,
          testimonial: formData.testimonial,
          rating: formData.rating,
        }),
      });

      const data = await response.json();

      if (response.ok && data.success) {
        setSuccess(true);
        setTimeout(() => {
          navigate("/testimonials");
        }, 3000);
      } else {
        setError(data.message || "Terjadi kesalahan saat mengirim testimoni");
      }
    } catch (error) {
      console.error("Submit error:", error);
      setError("Terjadi kesalahan. Silakan coba lagi.");
    } finally {
      setLoading(false);
    }
  };

  if (checkingAuth) {
    return (
      <div className="min-h-screen flex items-center justify-center bg-gray-50">
        <div className="text-center">
          <Loader2 className="animate-spin h-12 w-12 text-blue-600 mx-auto" />
          <p className="mt-4 text-muted-foreground">Memeriksa autentikasi...</p>
        </div>
      </div>
    );
  }

  if (!isAuthenticated) {
    return (
      <div className="min-h-screen flex items-center justify-center bg-gray-50">
        <Card className="max-w-md w-full mx-4">
          <CardHeader>
            <CardTitle className="text-center">Login Diperlukan</CardTitle>
            <CardDescription className="text-center">
              Anda harus login sebagai alumni untuk mengirim testimoni
            </CardDescription>
          </CardHeader>
          <CardContent className="text-center space-y-4">
            <p className="text-muted-foreground">
              Silakan login atau daftar terlebih dahulu untuk mengirim testimoni
            </p>
            <div className="flex gap-3 justify-center">
              <Button
                onClick={() => navigate("/login")}
                className="bg-blue-600 hover:bg-blue-700"
              >
                Login
              </Button>
              <Button
                onClick={() => navigate("/register")}
                variant="outline"
              >
                Daftar
              </Button>
            </div>
          </CardContent>
        </Card>
      </div>
    );
  }

  if (success) {
    return (
      <div className="min-h-screen flex items-center justify-center bg-gray-50">
        <Card className="max-w-md w-full mx-4">
          <CardContent className="pt-6 text-center">
            <CheckCircle className="w-16 h-16 text-green-500 mx-auto mb-4" />
            <h2 className="text-2xl font-bold mb-2">Testimoni Terkirim!</h2>
            <p className="text-muted-foreground mb-6">
              Terima kasih! Testimoni Anda sedang menunggu persetujuan admin dan akan
              segera ditampilkan.
            </p>
            <Button
              onClick={() => navigate("/testimonials")}
              className="bg-blue-600 hover:bg-blue-700"
            >
              Lihat Testimoni Lainnya
            </Button>
          </CardContent>
        </Card>
      </div>
    );
  }

  return (
    <div className="min-h-screen bg-gray-50 py-12">
      <div className="container mx-auto px-4 lg:px-8">
        <div className="max-w-3xl mx-auto">
          <div className="text-center mb-8">
            <h1 className="text-3xl lg:text-4xl font-bold mb-4">
              Kirim Testimoni Anda
            </h1>
            <p className="text-lg text-muted-foreground">
              Bagikan pengalaman Anda belajar di Klinik UKOM
            </p>
          </div>

          <Card>
            <CardContent className="pt-6">
              <form onSubmit={handleSubmit} className="space-y-6">
                {error && (
                  <div className="bg-red-50 border border-red-200 rounded-lg p-4 flex items-start gap-3">
                    <AlertCircle className="text-red-600 flex-shrink-0 mt-0.5" size={20} />
                    <p className="text-red-800 text-sm">{error}</p>
                  </div>
                )}

                {/* Info Box */}
                <div className="bg-blue-50 border border-blue-200 rounded-lg p-4">
                  <p className="text-sm text-blue-800">
                    <strong>Info:</strong> Data nama, angkatan, dan jurusan akan diambil dari profil Anda. 
                    Jika belum lengkap, silakan{" "}
                    <button
                      type="button"
                      onClick={() => navigate("/profile")}
                      className="underline font-medium hover:text-blue-900"
                    >
                      lengkapi profil
                    </button>{" "}
                    terlebih dahulu.
                  </p>
                </div>

                {/* Display User Info (Read Only) */}
                <div className="bg-gray-50 rounded-lg p-4 space-y-2">
                  <div className="flex items-center gap-2">
                    <span className="text-sm font-medium text-gray-600">Nama:</span>
                    <span className="text-sm text-gray-900">{formData.name || "-"}</span>
                  </div>
                  <div className="flex items-center gap-2">
                    <span className="text-sm font-medium text-gray-600">Jurusan:</span>
                    <span className="text-sm text-gray-900">{formData.major || "-"}</span>
                  </div>
                  <div className="flex items-center gap-2">
                    <span className="text-sm font-medium text-gray-600">Angkatan:</span>
                    <span className="text-sm text-gray-900">{formData.batch || "-"}</span>
                  </div>
                </div>

                {/* Program */}
                <div>
                  <label className="block text-sm font-medium mb-2">
                    Program yang Diikuti
                  </label>
                  <input
                    type="text"
                    value={formData.program}
                    onChange={(e) =>
                      setFormData({ ...formData, program: e.target.value })
                    }
                    className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="Contoh: Bimbel Intensif UKOM Perawat"
                  />
                </div>

                {/* Rating */}
                <div>
                  <label className="block text-sm font-medium mb-2">
                    Rating <span className="text-red-500">*</span>
                  </label>
                  <div className="flex gap-2">
                    {[1, 2, 3, 4, 5].map((star) => (
                      <button
                        key={star}
                        type="button"
                        onClick={() => setFormData({ ...formData, rating: star })}
                        className="focus:outline-none"
                      >
                        <Star
                          size={32}
                          className={
                            star <= formData.rating
                              ? "fill-yellow-400 text-yellow-400"
                              : "text-gray-300"
                          }
                        />
                      </button>
                    ))}
                  </div>
                </div>

                {/* Testimonial */}
                <div>
                  <label className="block text-sm font-medium mb-2">
                    Testimoni Anda <span className="text-red-500">*</span>
                  </label>
                  <textarea
                    required
                    rows={6}
                    minLength={50}
                    value={formData.testimonial}
                    onChange={(e) =>
                      setFormData({ ...formData, testimonial: e.target.value })
                    }
                    className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="Ceritakan pengalaman Anda belajar di Klinik UKOM... (minimal 50 karakter)"
                  />
                  <p className="text-xs text-muted-foreground mt-1">
                    {formData.testimonial.length} / 50 karakter minimum
                  </p>
                </div>

                {/* Submit Button */}
                <div className="flex gap-4">
                  <Button
                    type="button"
                    variant="outline"
                    onClick={() => navigate("/testimonials")}
                    className="flex-1"
                  >
                    Batal
                  </Button>
                  <Button
                    type="submit"
                    disabled={loading}
                    className="flex-1 bg-blue-600 hover:bg-blue-700"
                  >
                    {loading ? (
                      <>
                        <Loader2 className="animate-spin mr-2" size={16} />
                        Mengirim...
                      </>
                    ) : (
                      "Kirim Testimoni"
                    )}
                  </Button>
                </div>
              </form>
            </CardContent>
          </Card>
        </div>
      </div>
    </div>
  );
}
