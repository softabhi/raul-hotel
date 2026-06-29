import Link from "next/link";
import Image from "next/image";
import { Hotel, UtensilsCrossed, ArrowRight } from "lucide-react";

export default function StatsSection() {
  return (
    <>
      {/* Stats counters */}
      <section className="py-16 bg-gradient-to-r from-[#D4A853] via-[#E8C47A] to-[#B8923A]">
        <div className="max-w-7xl mx-auto px-6 lg:px-10">
          <div className="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
            {[
              { value: "15+", label: "Years of Excellence" },
              { value: "50+", label: "Luxury Rooms" },
              { value: "12,000+", label: "Guests Served" },
              { value: "25+", label: "Awards Won" },
            ].map((s) => (
              <div key={s.label}>
                <div className="font-playfair text-4xl md:text-5xl font-bold text-[#0F172A]">{s.value}</div>
                <div className="text-[#0F172A]/70 text-sm font-medium mt-1">{s.label}</div>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* Dual CTA Section */}
      <section className="py-20 bg-[#FAFAF8]">
        <div className="max-w-7xl mx-auto px-6 lg:px-10">
          <div className="grid grid-cols-1 md:grid-cols-2 gap-7">
            {/* Hotel CTA */}
            <div className="relative rounded-3xl overflow-hidden h-80 group cursor-pointer">
              <Image
                src="https://images.unsplash.com/photo-1618773928121-c32242e63f39?w=800&q=80"
                alt="Luxury Hotel Room"
                fill
                className="object-cover transition-transform duration-700 group-hover:scale-110"
              />
              <div className="absolute inset-0 bg-gradient-to-t from-[#0F172A]/80 via-[#0F172A]/40 to-transparent" />
              <div className="absolute inset-0 flex flex-col justify-end p-8">
                <div className="w-12 h-12 bg-[#D4A853] rounded-xl flex items-center justify-center mb-4">
                  <Hotel size={24} className="text-white" />
                </div>
                <h3 className="font-playfair text-3xl text-white mb-2">Luxury Rooms & Suites</h3>
                <p className="text-gray-300 text-sm mb-5">From standard comfort to presidential opulence</p>
                <Link href="/hotel" className="btn-gold !py-2.5 !px-5 self-start">
                  Explore Rooms <ArrowRight size={16} />
                </Link>
              </div>
            </div>

            {/* Restaurant CTA */}
            <div className="relative rounded-3xl overflow-hidden h-80 group cursor-pointer">
              <Image
                src="https://images.unsplash.com/photo-1414235077428-338989a2e8c0?w=800&q=80"
                alt="Fine Dining"
                fill
                className="object-cover transition-transform duration-700 group-hover:scale-110"
              />
              <div className="absolute inset-0 bg-gradient-to-t from-[#0F172A]/80 via-[#0F172A]/40 to-transparent" />
              <div className="absolute inset-0 flex flex-col justify-end p-8">
                <div className="w-12 h-12 bg-[#D4A853] rounded-xl flex items-center justify-center mb-4">
                  <UtensilsCrossed size={24} className="text-white" />
                </div>
                <h3 className="font-playfair text-3xl text-white mb-2">Award-Winning Restaurant</h3>
                <p className="text-gray-300 text-sm mb-5">Exquisite flavors crafted by world-class chefs</p>
                <Link href="/restaurant" className="btn-gold !py-2.5 !px-5 self-start">
                  View Menu <ArrowRight size={16} />
                </Link>
              </div>
            </div>
          </div>
        </div>
      </section>
    </>
  );
}
