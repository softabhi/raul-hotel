import Navbar from "@/components/layout/Navbar";
import Footer from "@/components/layout/Footer";
import HeroSection from "@/components/home/HeroSection";
import FeaturesSection from "@/components/home/FeaturesSection";
import RoomsPreview from "@/components/home/RoomsPreview";
import RestaurantPreview from "@/components/home/RestaurantPreview";
import TestimonialsSection from "@/components/home/TestimonialsSection";
import StatsSection from "@/components/home/StatsSection";

export const metadata = {
  title: "LuxeStay & Dine | Premium Hotel & Restaurant",
  description:
    "Experience unparalleled luxury at LuxeStay & Dine — 5-star hotel rooms, suites, and an award-winning restaurant in the heart of the city.",
};

export default function HomePage() {
  return (
    <>
      <Navbar />
      <main>
        <HeroSection />
        <FeaturesSection />
        <RoomsPreview />
        <RestaurantPreview />
        <TestimonialsSection />
        <StatsSection />
      </main>
      <Footer />
    </>
  );
}
