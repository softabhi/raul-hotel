import Image from "next/image";
import Navbar from "@/components/layout/Navbar";
import Footer from "@/components/layout/Footer";

export const metadata = {
  title: "Gallery | LuxeStay & Dine",
  description: "Explore our stunning photo gallery featuring luxury rooms, suites, restaurant, and hotel facilities.",
};

const galleryImages = [
  { src: "https://images.unsplash.com/photo-1618773928121-c32242e63f39?w=800&q=80", label: "Deluxe Room", category: "Rooms", span: "col-span-2" },
  { src: "https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=800&q=80", label: "Standard Room", category: "Rooms", span: "" },
  { src: "https://images.unsplash.com/photo-1414235077428-338989a2e8c0?w=800&q=80", label: "Fine Dining", category: "Restaurant", span: "" },
  { src: "https://images.unsplash.com/photo-1611892440504-42a792e24d32?w=800&q=80", label: "Presidential Suite", category: "Rooms", span: "" },
  { src: "https://images.unsplash.com/photo-1590490360182-c33d57733427?w=800&q=80", label: "Chicken Biryani", category: "Food", span: "" },
  { src: "https://images.unsplash.com/photo-1596394516093-501ba68a0ba6?w=800&q=80", label: "Pool View Room", category: "Rooms", span: "col-span-2" },
  { src: "https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?w=800&q=80", label: "Hotel Exterior", category: "Hotel", span: "" },
  { src: "https://images.unsplash.com/photo-1578683010236-d716f9a3f461?w=800&q=80", label: "Spa & Wellness", category: "Facilities", span: "" },
  { src: "https://images.unsplash.com/photo-1565557623262-b51c2513a641?w=800&q=80", label: "Paneer Masala", category: "Food", span: "" },
  { src: "https://images.unsplash.com/photo-1540518614846-7eded433c457?w=800&q=80", label: "Suite Living Room", category: "Rooms", span: "" },
  { src: "https://images.unsplash.com/photo-1624353365286-3f8d62daad51?w=800&q=80", label: "Lava Cake", category: "Food", span: "" },
  { src: "https://images.unsplash.com/photo-1590490360182-c33d57733427?w=800&q=80", label: "Bathroom", category: "Rooms", span: "" },
];

const categories = ["All", "Rooms", "Restaurant", "Food", "Hotel", "Facilities"];

export default function GalleryPage() {
  return (
    <>
      <Navbar />
      <main>
        {/* Hero */}
        <div className="relative h-64 md:h-72">
          <Image src="https://images.unsplash.com/photo-1571896349842-33c89424de2d?w=1920&q=85" alt="Gallery" fill className="object-cover" priority />
          <div className="absolute inset-0 bg-[#0F172A]/70" />
          <div className="absolute inset-0 flex items-center justify-center text-center pt-16 pb-6">
            <div>
              <span className="section-label">Our World in Photos</span>
              <h1 className="font-playfair text-5xl text-white mt-2">
                Photo <span className="gold-text">Gallery</span>
              </h1>
            </div>
          </div>
        </div>

        <div className="max-w-7xl mx-auto px-6 lg:px-10 py-14">
          <p className="text-center text-gray-500 mb-10 max-w-xl mx-auto">
            Take a visual tour through our world-class facilities, breathtaking rooms, and culinary masterpieces.
          </p>

          {/* Gallery grid */}
          <div className="grid grid-cols-2 md:grid-cols-3 gap-4">
            {galleryImages.map((img, i) => (
              <div key={i} className={`relative group overflow-hidden rounded-2xl ${img.span} ${i % 5 === 0 ? "h-72" : "h-52"}`}>
                <Image
                  src={img.src}
                  alt={img.label}
                  fill
                  className="object-cover transition-transform duration-500 group-hover:scale-110"
                />
                <div className="absolute inset-0 bg-[#0F172A]/0 group-hover:bg-[#0F172A]/40 transition-all duration-300" />
                <div className="absolute bottom-0 left-0 right-0 p-4 translate-y-full group-hover:translate-y-0 transition-transform duration-300">
                  <p className="text-white font-semibold text-sm">{img.label}</p>
                  <span className="text-xs text-[#D4A853]">{img.category}</span>
                </div>
              </div>
            ))}
          </div>
        </div>
      </main>
      <Footer />
    </>
  );
}
