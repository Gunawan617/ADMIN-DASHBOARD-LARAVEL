import { Button } from "./ui/button";
import { Menu, X, User, LogOut } from "lucide-react";
import { useState, useEffect } from "react";
import { Link, useLocation, useNavigate } from "react-router-dom";

export function Header() {
  const [mobileMenuOpen, setMobileMenuOpen] = useState(false);
  const [isAuthenticated, setIsAuthenticated] = useState(false);
  const [user, setUser] = useState<any>(null);
  const [showUserMenu, setShowUserMenu] = useState(false);
  const [showTestimoniDropdown, setShowTestimoniDropdown] = useState(false);
  const location = useLocation();
  const navigate = useNavigate();
  const isHomePage = location.pathname === "/";

  useEffect(() => {
    checkAuth();
  }, [location]);

  // Close dropdown when clicking outside
  useEffect(() => {
    const handleClickOutside = (event: MouseEvent) => {
      const target = event.target as HTMLElement;
      if (showTestimoniDropdown && !target.closest('.relative.group')) {
        setShowTestimoniDropdown(false);
      }
      if (showUserMenu && !target.closest('.relative')) {
        setShowUserMenu(false);
      }
    };

    document.addEventListener('mousedown', handleClickOutside);
    return () => document.removeEventListener('mousedown', handleClickOutside);
  }, [showTestimoniDropdown, showUserMenu]);

  const checkAuth = () => {
    const token = localStorage.getItem("auth_token");
    const userData = localStorage.getItem("user");
    if (token && userData) {
      setIsAuthenticated(true);
      setUser(JSON.parse(userData));
    } else {
      setIsAuthenticated(false);
      setUser(null);
    }
  };

  const handleLogout = async () => {
    const token = localStorage.getItem("auth_token");
    
    // Call logout API to revoke token
    if (token) {
      try {
        await fetch("/api/logout", {
          method: "POST",
          headers: {
            "Authorization": `Bearer ${token}`,
            "Accept": "application/json",
          },
        });
      } catch (error) {
        console.error("Logout error:", error);
      }
    }
    
    // Clear local storage
    localStorage.removeItem("auth_token");
    localStorage.removeItem("user");
    setIsAuthenticated(false);
    setUser(null);
    setShowUserMenu(false);
    navigate("/");
  };

  return (
    <header className="sticky top-0 z-50 w-full border-b bg-background/95 backdrop-blur supports-[backdrop-filter]:bg-background/60">
      <div className="container mx-auto px-4 lg:px-8">
        <div className="flex h-16 items-center justify-between">
          {/* Logo */}
          <Link to="/" className="flex items-center gap-3">
            <img src="/nfc.png" alt="NFC" className="h-10 w-auto" />
            <img src="/klikom.png" alt="Klinik Ukom" className="h-10 w-auto" />
          </Link>

          {/* Desktop Navigation */}
          <nav className="hidden md:flex items-center gap-8">
            {isHomePage ? (
              <>
                <a href="#programs" className="text-sm hover:text-primary transition-colors">
                  Program
                </a>
                <a href="#features" className="text-sm hover:text-primary transition-colors">
                  Keunggulan
                </a>
              </>
            ) : (
              <>
                <Link to="/#programs" className="text-sm hover:text-primary transition-colors">
                  Program
                </Link>
                <Link to="/#features" className="text-sm hover:text-primary transition-colors">
                  Keunggulan
                </Link>
              </>
            )}
            <div 
              className="relative group"
            >
              <button 
                className="text-sm hover:text-primary transition-colors flex items-center gap-1 py-2"
                onClick={() => setShowTestimoniDropdown(!showTestimoniDropdown)}
              >
                Testimoni
                <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M19 9l-7 7-7-7" />
                </svg>
              </button>
              {showTestimoniDropdown && (
                <>
                  {/* Invisible bridge to prevent dropdown from closing */}
                  <div className="absolute top-full left-0 w-48 h-2 -mt-0" />
                  <div className="absolute top-full left-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-2 z-50">
                    <Link
                      to="/testimonials"
                      className="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                      onClick={() => setShowTestimoniDropdown(false)}
                    >
                      📝 Testimoni
                    </Link>
                    <Link
                      to="/alumni"
                      className="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                      onClick={() => setShowTestimoniDropdown(false)}
                    >
                      📸 Galeri Alumni
                    </Link>
                  </div>
                </>
              )}
            </div>
            <Link to="/blog" className="text-sm hover:text-primary transition-colors">
              Artikel
            </Link>
            {isHomePage && (
              <a href="#partners" className="text-sm hover:text-primary transition-colors">
                Mitra
              </a>
            )}
          </nav>

          {/* Desktop CTA */}
          <div className="hidden md:flex items-center gap-4">
            {isAuthenticated && user ? (
              <div className="relative">
                <button
                  onClick={() => setShowUserMenu(!showUserMenu)}
                  className="flex items-center gap-2 px-4 py-2 rounded-lg hover:bg-gray-100 transition-colors max-w-[280px]"
                >
                  {user.photo ? (
                    <img
                      src={user.photo.startsWith('http') ? user.photo : `/storage/${user.photo}`}
                      alt={user.name}
                      className="w-8 h-8 rounded-full object-cover border-2 border-gray-200 flex-shrink-0"
                    />
                  ) : (
                    <div className="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center text-white font-semibold flex-shrink-0">
                      {user.name?.charAt(0).toUpperCase()}
                    </div>
                  )}
                  <span className="text-sm font-medium truncate">{user.name}</span>
                </button>
                {showUserMenu && (
                  <div className="absolute right-0 mt-2 w-72 bg-white rounded-lg shadow-lg border border-gray-200 py-2 z-50">
                    <div className="px-4 py-3 border-b border-gray-100 flex items-center gap-3">
                      {user.photo ? (
                        <img
                          src={user.photo.startsWith('http') ? user.photo : `/storage/${user.photo}`}
                          alt={user.name}
                          className="w-10 h-10 rounded-full object-cover border-2 border-gray-200 flex-shrink-0"
                        />
                      ) : (
                        <div className="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center text-white font-semibold flex-shrink-0">
                          {user.name?.charAt(0).toUpperCase()}
                        </div>
                      )}
                      <div className="min-w-0 flex-1">
                        <p className="text-sm font-medium text-gray-900 truncate">{user.name}</p>
                        <p className="text-xs text-gray-500 truncate">{user.email}</p>
                      </div>
                    </div>
                    <Link
                      to="/profile"
                      className="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                      onClick={() => setShowUserMenu(false)}
                    >
                      <User size={16} />
                      Edit Profil
                    </Link>
                    <Link
                      to="/submit-testimonial"
                      className="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                      onClick={() => setShowUserMenu(false)}
                    >
                      <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                      </svg>
                      Kirim Testimoni
                    </Link>
                    <button
                      onClick={handleLogout}
                      className="flex items-center gap-2 w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50"
                    >
                      <LogOut size={16} />
                      Logout
                    </button>
                  </div>
                )}
              </div>
            ) : (
              <>
                <Link to="/login">
                  <Button variant="ghost">Masuk</Button>
                </Link>
                <Link to="/register">
                  <Button className="bg-blue-600 hover:bg-blue-700">
                    Daftar Sekarang
                  </Button>
                </Link>
              </>
            )}
          </div>

          {/* Mobile Menu Button */}
          <button
            className="md:hidden p-2"
            onClick={() => setMobileMenuOpen(!mobileMenuOpen)}
          >
            {mobileMenuOpen ? <X size={24} /> : <Menu size={24} />}
          </button>
        </div>

        {/* Mobile Menu */}
        {mobileMenuOpen && (
          <div className="md:hidden py-4 border-t">
            <nav className="flex flex-col gap-4">
              {isHomePage ? (
                <>
                  <a href="#programs" className="text-sm hover:text-primary transition-colors">
                    Program
                  </a>
                  <a href="#features" className="text-sm hover:text-primary transition-colors">
                    Keunggulan
                  </a>
                </>
              ) : (
                <>
                  <Link to="/#programs" className="text-sm hover:text-primary transition-colors">
                    Program
                  </Link>
                  <Link to="/#features" className="text-sm hover:text-primary transition-colors">
                    Keunggulan
                  </Link>
                </>
              )}
              <div className="flex flex-col gap-2 pl-4">
                <div className="text-sm font-medium text-gray-500">Testimoni</div>
                <Link to="/testimonials" className="text-sm hover:text-primary transition-colors pl-2" onClick={() => setMobileMenuOpen(false)}>
                  📝 Testimoni
                </Link>
                <Link to="/alumni" className="text-sm hover:text-primary transition-colors pl-2" onClick={() => setMobileMenuOpen(false)}>
                  📸 Galeri Alumni
                </Link>
              </div>
              <Link to="/blog" className="text-sm hover:text-primary transition-colors" onClick={() => setMobileMenuOpen(false)}>
                Artikel
              </Link>
              {isHomePage && (
                <a href="#partners" className="text-sm hover:text-primary transition-colors" onClick={() => setMobileMenuOpen(false)}>
                  Mitra
                </a>
              )}
              <div className="flex flex-col gap-2 pt-2 border-t">
                {isAuthenticated && user ? (
                  <>
                    <div className="px-4 py-3 flex items-center gap-3">
                      {user.photo ? (
                        <img
                          src={user.photo.startsWith('http') ? user.photo : `/storage/${user.photo}`}
                          alt={user.name}
                          className="w-12 h-12 rounded-full object-cover border-2 border-gray-200 flex-shrink-0"
                        />
                      ) : (
                        <div className="w-12 h-12 rounded-full bg-blue-600 flex items-center justify-center text-white text-lg font-semibold flex-shrink-0">
                          {user.name?.charAt(0).toUpperCase()}
                        </div>
                      )}
                      <div className="min-w-0 flex-1">
                        <p className="text-sm font-medium text-gray-900 truncate">{user.name}</p>
                        <p className="text-xs text-gray-500 truncate">{user.email}</p>
                      </div>
                    </div>
                    <Link to="/profile" onClick={() => setMobileMenuOpen(false)}>
                      <Button variant="ghost" className="w-full justify-start">
                        <User size={16} className="mr-2" />
                        Edit Profil
                      </Button>
                    </Link>
                    <Link to="/submit-testimonial" onClick={() => setMobileMenuOpen(false)}>
                      <Button variant="ghost" className="w-full justify-start">
                        <svg className="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                        </svg>
                        Kirim Testimoni
                      </Button>
                    </Link>
                    <Button
                      variant="ghost"
                      className="w-full justify-start text-red-600 hover:text-red-700 hover:bg-red-50"
                      onClick={() => {
                        handleLogout();
                        setMobileMenuOpen(false);
                      }}
                    >
                      <LogOut size={16} className="mr-2" />
                      Logout
                    </Button>
                  </>
                ) : (
                  <>
                    <Link to="/login" onClick={() => setMobileMenuOpen(false)}>
                      <Button variant="ghost" className="w-full">Masuk</Button>
                    </Link>
                    <Link to="/register" onClick={() => setMobileMenuOpen(false)}>
                      <Button className="w-full bg-blue-600 hover:bg-blue-700">
                        Daftar Sekarang
                      </Button>
                    </Link>
                  </>
                )}
              </div>
            </nav>
          </div>
        )}
      </div>
    </header>
  );
}
