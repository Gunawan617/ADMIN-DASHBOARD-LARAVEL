import { useState } from "react";
import { BrowserRouter as Router, Routes, Route } from "react-router-dom";
import { Header } from "./components/Header";
import { Hero } from "./components/Hero";
import { ProductType, AudienceType } from "./components/ProductSwitcher";
import { Programs } from "./components/Programs";
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
import { ProgramDetailPage } from "./pages/ProgramDetailPage";
import { TryoutDetailPage } from "./pages/TryoutDetailPage";
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

function HomePage() {
  const [selectedProduct, setSelectedProduct] = useState<ProductType>("bimbel");
  const [selectedAudience, setSelectedAudience] = useState<AudienceType>("nurse");

  return (
    <>
      <Hero />
      <VideoSection />
      <Programs
        selectedProduct={selectedProduct}
        selectedAudience={selectedAudience}
        onProductChange={setSelectedProduct}
        onAudienceChange={setSelectedAudience}
      />
      <Features />
      <Books />
      <Testimonials />
      <AlumniGallery />
      <TeamMarketing />
      <Blog />
      <FAQ />
      {/* <Partners /> */}
    </>
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
            <Route path="/program/:slug" element={<ProgramDetailPage />} />
            <Route path="/tryout/:slug" element={<TryoutDetailPage />} />
            <Route path="/books" element={<BooksPage />} />
            <Route path="/books/:id" element={<BookDetailPage />} />
            <Route path="/daftar" element={<DaftarPage />} />
            <Route path="/alumni" element={<AlumniPage />} />
            <Route path="/submit-alumni" element={<SubmitAlumniPage />} />
            <Route path="/contact" element={<ContactPage />} />
            <Route path="/faq" element={<FAQPage />} />
          </Routes>
        </main>
        <Footer />
      </div>
    </Router>
  );
}
