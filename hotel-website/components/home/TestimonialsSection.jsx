"use client";
import { useState } from "react";
import { Star, ChevronLeft, ChevronRight } from "lucide-react";
import Image from "next/image";

const testimonials = [
  {
    id: 1,
    name: "Priya Sharma",
    role: "Business Traveler",
    location: "Mumbai, India",
    avatar: "https://images.unsplash.com/photo-1494790108755-2616b612b786?w=200&q=80",
    rating: 5,
    review: "Absolutely stunning hotel! The Presidential Suite exceeded every expectation. The butler service was impeccable, and the restaurant's biryani is honestly the best I've ever had. Will definitely return.",
    stay: "Presidential Suite",
  },
  {
    id: 2,
    name: "James Mitchell",
    role: "Honeymooner",
    location: "London, UK",
    avatar: "https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=200&q=80",
    rating: 5,
    review: "My wife and I spent our honeymoon here and it was pure magic. The rose petal turndown, the champagne, the private terrace overlooking the sea — we couldn't have asked for more perfect.",
    stay: "Honeymoon Suite",
  },
  {
    id: 3,
    name: "Ananya Patel",
    role: "Food Enthusiast",
    location: "Bangalore, India",
    avatar: "https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=200&q=80",
    rating: 5,
    review: "The restaurant alone is worth visiting! Tried the Paneer Butter Masala and the Chocolate Lava Cake — both were absolutely divine. The ambiance is elegant without being pretentious.",
    stay: "Deluxe Pool View",
  },
  {
    id: 4,
    name: "Rahul Mehta",
    role: "Family Vacation",
    location: "Delhi, India",
    avatar: "https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=200&q=80",
    rating: 4,
    review: "Brought the family for a long weekend. The kids loved the pool, and the family room was spacious and comfortable. Staff went above and beyond to make our stay special. Highly recommended!",
    stay: "Family Room",
  },
];

export default function TestimonialsSection() {
  const [current, setCurrent] = useState(0);

  const prev = () => setCurrent((c) => (c - 1 + testimonials.length) % testimonials.length);
  const next = () => setCurrent((c) => (c + 1) % testimonials.length);

  const t = testimonials[current];

  return (
    <section className="py-20 bg-[#0F172A]">
      <div className="max-w-5xl mx-auto px-6 lg:px-10">
        <div className="text-center mb-14">
          <span className="section-label">Guest Reviews</span>
          <h2 className="font-playfair text-4xl md:text-5xl text-white mt-2">
            What Our <span className="gold-text">Guests Say</span>
          </h2>
          <div className="gold-divider mt-4"></div>
        </div>

        <div className="relative">
          <div className="bg-white/5 backdrop-blur-sm border border-white/10 rounded-3xl p-8 md:p-12">
            {/* Big decorative quote mark */}
            <div className="text-[#D4A853]/20 text-[120px] font-playfair leading-none select-none absolute top-4 left-8">"</div>

            <div className="flex flex-col md:flex-row items-start gap-6 relative z-10 mt-6">
              <div className="shrink-0">
                <div className="relative w-16 h-16 rounded-full overflow-hidden border-2 border-[#D4A853]/50">
                  <Image src={t.avatar} alt={t.name} fill className="object-cover" sizes="64px" />
                </div>
              </div>
              <div className="flex-1">
                <p className="text-gray-200 text-lg leading-relaxed mb-6 italic">
                  &ldquo;{t.review}&rdquo;
                </p>
                <div className="flex items-center justify-between flex-wrap gap-4">
                  <div>
                    <p className="text-white font-semibold">{t.name}</p>
                    <p className="text-gray-400 text-sm">{t.role} &middot; {t.location}</p>
                    <p className="text-[#D4A853] text-xs mt-1">Stayed in: {t.stay}</p>
                  </div>
                  <div className="flex gap-1">
                    {[...Array(5)].map((_, i) => (
                      <Star key={i} size={16} className={i < t.rating ? "text-yellow-400 fill-yellow-400" : "text-gray-600 fill-gray-600"} />
                    ))}
                  </div>
                </div>
              </div>
            </div>
          </div>

          {/* Nav */}
          <div className="flex items-center justify-between mt-6">
            <div className="flex gap-2">
              {testimonials.map((_, i) => (
                <button
                  key={i}
                  onClick={() => setCurrent(i)}
                  className={`slider-dot ${i === current ? "active" : ""}`}
                />
              ))}
            </div>
            <div className="flex gap-2">
              <button onClick={prev} className="w-10 h-10 rounded-full border border-white/20 text-white flex items-center justify-center hover:border-[#D4A853] hover:text-[#D4A853] transition-all">
                <ChevronLeft size={18} />
              </button>
              <button onClick={next} className="w-10 h-10 rounded-full border border-white/20 text-white flex items-center justify-center hover:border-[#D4A853] hover:text-[#D4A853] transition-all">
                <ChevronRight size={18} />
              </button>
            </div>
          </div>
        </div>

        {/* Overall rating */}
        <div className="mt-12 grid grid-cols-3 gap-6 text-center">
          {[
            { value: "4.8", label: "Overall Rating", sub: "Based on 500+ reviews" },
            { value: "98%", label: "Recommended", sub: "Would visit again" },
            { value: "500+", label: "Happy Guests", sub: "This year alone" },
          ].map((s) => (
            <div key={s.label} className="bg-white/5 rounded-2xl p-5 border border-white/10">
              <div className="font-playfair text-3xl font-bold gold-text">{s.value}</div>
              <div className="text-white font-medium text-sm mt-1">{s.label}</div>
              <div className="text-gray-400 text-xs mt-0.5">{s.sub}</div>
            </div>
          ))}
        </div>
      </div>
    </section>
  );
}
