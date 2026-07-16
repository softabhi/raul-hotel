"use client";
import { useState, useEffect } from "react";
import Link from "next/link";
import Image from "next/image";
import { Hotel, UtensilsCrossed, ChevronDown, Star, Play, ArrowRight } from "lucide-react";

const slides = [
  {
    image: "https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?w=1920&q=85",
    title: "A World of",
    highlight: "Unmatched Luxury",
    sub: "Experience the finest hospitality — where every detail tells a story of elegance.",
  },
  {
    image: "https://images.unsplash.com/photo-1571896349842-33c89424de2d?w=1920&q=85",
    title: "Rest in",
    highlight: "Absolute Comfort",
    sub: "Handcrafted suites and rooms designed to make every stay unforgettable.",
  },
  {
    image: "https://images.unsplash.com/photo-1414235077428-338989a2e8c0?w=1920&q=85",
    title: "Dine with",
    highlight: "Exquisite Flavors",
    sub: "An award-winning restaurant that transforms every meal into a masterpiece.",
  },
];

export default function HeroSection() {
  const [current, setCurrent] = useState(0);

  useEffect(() => {
    const t = setInterval(() => setCurrent((c) => (c + 1) % slides.length), 6000);
    return () => clearInterval(t);
  }, []);

  const slide = slides[current];

  return (
    <section className="relative min-h-screen flex items-center overflow-hidden">
      {/* Background images */}
      {slides.map((s, i) => (
        <div
          key={i}
          className={`absolute inset-0 transition-opacity duration-1500 ${i === current ? "opacity-100" : "opacity-0"}`}
        >
          <Image src={s.image} alt={s.title} fill className="object-cover" priority={i === 0} />
          <div className="absolute inset-0 bg-gradient-to-r from-[#0F172A]/90 via-[#0F172A]/60 to-[#0F172A]/20" />
          <div className="absolute inset-0 bg-gradient-to-t from-[#0F172A]/70 via-transparent to-transparent" />
        </div>
      ))}

      {/* Content */}
      <div className="relative z-10 w-full max-w-7xl mx-auto px-6 lg:px-10 pt-36 pb-32">
        <div className="max-w-2xl">
          {/* Rating badge */}
          <div className="inline-flex items-center gap-2 bg-white/10 backdrop-blur-sm border border-white/20 rounded-full px-4 py-2 mb-6">
            <div className="flex">
              {[1, 2, 3, 4, 5].map(i => <Star key={i} size={13} className="text-yellow-400 fill-yellow-400" />)}
            </div>
            <span className="text-white text-xs font-medium">Luxury Boutique Hotel</span>
          </div>

          {/* Headline */}
          <h1 className="font-playfair text-5xl md:text-6xl lg:text-7xl text-white leading-tight mb-4">
            {slide.title}
            <br />
            <span className="gold-text">{slide.highlight}</span>
          </h1>

          <p className="text-gray-300 text-lg max-w-xl mb-10 leading-relaxed">
            {slide.sub}
          </p>

          {/* CTAs */}
          <div className="flex flex-wrap gap-4">
            <Link href="/booking" className="btn-gold !text-base !py-3.5 !px-7 animate-pulse-gold">
              <Hotel size={18} /> Book Your Stay
            </Link>
            <Link href="/restaurant" className="btn-dark !text-base !py-3.5 !px-7">
              <UtensilsCrossed size={18} /> Explore Menu
            </Link>
          </div>

          {/* Slide indicators */}
          <div className="flex gap-2 mt-10">
            {slides.map((_, i) => (
              <button
                key={i}
                onClick={() => setCurrent(i)}
                className={`slider-dot ${i === current ? "active" : ""}`}
              />
            ))}
          </div>
        </div>
      </div>

      {/* Quick Booking Bar */}
      <div className="absolute bottom-0 left-0 right-0 z-10">
        <div className="max-w-7xl mx-auto px-6 lg:px-10 pb-8">
          <div className="glass-dark rounded-2xl p-5 shadow-2xl">
            <div className="grid grid-cols-2 md:grid-cols-4 gap-4">
              <div>
                <label className="text-xs text-[#D4A853] font-semibold mb-1.5 block">Check In</label>
                <input type="date" className="input-field !bg-white/10 !border-white/20 !text-white text-sm" />
              </div>
              <div>
                <label className="text-xs text-[#D4A853] font-semibold mb-1.5 block">Check Out</label>
                <input type="date" className="input-field !bg-white/10 !border-white/20 !text-white text-sm" />
              </div>
              <div>
                <label className="text-xs text-[#D4A853] font-semibold mb-1.5 block">Guests</label>
                <select className="input-field !bg-white/10 !border-white/20 !text-white text-sm">
                  {[1, 2, 3, 4, 5, 6].map(n => <option key={n} value={n} className="!text-black">{n} Guest{n > 1 ? "s" : ""}</option>)}
                </select>
              </div>
              <div className="flex items-end">
                <Link href="/hotel" className="btn-gold w-full justify-center !py-2.5">
                  Search Rooms <ArrowRight size={16} />
                </Link>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  );
}
