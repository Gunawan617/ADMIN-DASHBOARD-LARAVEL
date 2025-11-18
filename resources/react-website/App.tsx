import { BrowserRouter as Router, Routes, Route } from "react-router-dom";
import { Header } from "./components/Header";
import { Hero } from "./components/Hero";
import { StatsCards } from "./components/StatsCards";
import { ProgramsNew } from "./components/ProgramsNew";
import { Features } from "./components/Features";
import { Testimonials } from "./components/Testimonials";
import { Blog } from "./components/Blog";
import { Partners } from "./components/Partners";
import { Footer } from "./components/Footer";
import { BlogPage } from "./pages/BlogPage";
import { BlogDetailPage } from "./pages/BlogDetailPage";
import { TestimonialsPage } from "./pages/TestimonialsPage";
import { SubmitTestimonialPage } from "./pages/SubmitTestimonialPage";
import { LoginPage } from "./pages/LoginPage";
import { RegisterPage } from "./pages/RegisterPage";
import { ProfilePage } from "./pages/ProfilePage";

import { BooksPage } from "./pages/BooksPage";
import { BookDetailPage } from "./pages/BookDetailPage";
import { Books } from "./components/Books";
import { TeamMarketing } from "./components/TeamMarketing";
import { AlumniGallery } from "./components/AlumniGallery";
import DaftarPage from "./pages/DaftarPage";
import { AlumniPage } from "./pages/AlumniPage";
import { SubmitAlumniPage } from "./pages/SubmitAlumniPage";
import { VideoSection } from "./components/VideoSection";
import { ContactPage } from "./pages/ContactPage";
import { FAQPage } from "./pages/FAQPage";
import { FAQ } from "./components/FAQ";
import { ProgramsTestPage } from "./pages/ProgramsTestPage";

function HomePage() {
  return (
    <div className="relative">
      <Hero />
      <StatsCards />
      <ProgramsNew />
      <Books />
      <VideoSection />
      <Features />
      <Testimonials />
      <AlumniGallery />
      <TeamMarketing />
      <Blog />
      <FAQ />
      {/* <Partners /> */}
    </div>
  );
}

export default function App() {
  return (
    <Router>
      <div className="min-h-screen flex flex-col">
        <Header />
        <main className="flex-1">
          <Routes>
            <Route path="/" element={<HomePage />} />
            <Route path="/blog" element={<BlogPage />} />
            <Route path="/blog/:slug" element={<BlogDetailPage />} />
            <Route path="/testimonials" element={<TestimonialsPage />} />
            <Route path="/submit-testimonial" element={<SubmitTestimonialPage />} />
            <Route path="/login" element={<LoginPage />} />
            <Route path="/register" element={<RegisterPage />} />
            <Route path="/profile" element={<ProfilePage />} />

            <Route path="/books" element={<BooksPage />} />
            <Route path="/books/:id" element={<BookDetailPage />} />
            <Route path="/daftar" element={<DaftarPage />} />
            <Route path="/alumni" element={<AlumniPage />} />
            <Route path="/submit-alumni" element={<SubmitAlumniPage />} />
            <Route path="/contact" element={<ContactPage />} />
            <Route path="/faq" element={<FAQPage />} />
            <Route path="/programs-test" element={<ProgramsTestPage />} />
          </Routes>
        </main>
        <Footer />
      </div>
    </Router>
  );
}
