"use client";
import { useState } from "react";
import { rooms } from "@/data/rooms";
import Navbar from "@/components/layout/Navbar";
import Footer from "@/components/layout/Footer";
import RoomCard from "@/components/hotel/RoomCard";
import RoomFilters from "@/components/hotel/RoomFilters";
import { Hotel, Search } from "lucide-react";
import Image from "next/image";

export default function HotelPage() {
  const [activeCategory, setActiveCategory] = useState("All");
  const [priceRange, setPriceRange] = useState(29999);
  const [capacity, setCapacity] = useState(null);
  const [search, setSearch] = useState("");

  const filtered = rooms.filter((r) => {
    if (activeCategory !== "All" && r.category !== activeCategory) return false;
    if (r.price > priceRange) return false;
    if (capacity && capacity !== "6+" && r.capacity < capacity) return false;
    if (capacity === "6+" && r.capacity < 6) return false;
    if (search && !r.name.toLowerCase().includes(search.toLowerCase())) return false;
    return true;
  });

  return (
    <>
      <Navbar />
      <main>
        {/* Hero Banner */}
        <div className="relative h-72 md:h-96">
          <Image
            src="https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?w=1920&q=85"
            alt="Hotel Rooms"
            fill
            className="object-cover"
            priority
          />
          <div className="absolute inset-0 bg-[#0F172A]/70" />
          <div className="absolute inset-0 flex items-center justify-center text-center px-6 pt-16 pb-6">
            <div>
              <span className="section-label">Our Accommodation</span>
              <h1 className="font-playfair text-4xl md:text-6xl text-white mt-2 mb-3">
                Rooms & <span className="gold-text">Suites</span>
              </h1>
              <p className="text-gray-300 text-lg max-w-xl mx-auto">
                Discover your perfect sanctuary — from cosy standard rooms to lavish presidential suites.
              </p>
            </div>
          </div>
        </div>

        {/* Content */}
        <div className="max-w-7xl mx-auto px-6 lg:px-10 py-12">
          {/* Search */}
          <div className="flex items-center gap-4 mb-8 flex-wrap">
            <div className="relative w-full max-w-sm">
              <Search size={18} className="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400" />
              <input
                type="text"
                placeholder="Search rooms..."
                value={search}
                onChange={(e) => setSearch(e.target.value)}
                className="input-field !pl-10"
              />
            </div>
            <span className="text-sm text-gray-500">
              Showing <strong className="text-[#0F172A]">{filtered.length}</strong> of {rooms.length} rooms
            </span>
          </div>

          <RoomFilters
            activeCategory={activeCategory}
            setActiveCategory={setActiveCategory}
            priceRange={priceRange}
            setPriceRange={setPriceRange}
            capacity={capacity}
            setCapacity={setCapacity}
          />

          {/* Grid */}
          {filtered.length > 0 ? (
            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-7">
              {filtered.map((room) => (
                <RoomCard key={room.id} room={room} />
              ))}
            </div>
          ) : (
            <div className="text-center py-20">
              <Hotel size={48} className="text-gray-300 mx-auto mb-4" />
              <h3 className="text-xl font-semibold text-gray-600 mb-2">No rooms found</h3>
              <p className="text-gray-400 text-sm">Try adjusting your filters</p>
            </div>
          )}
        </div>

        {/* Why Stay With Us */}
        <div className="bg-[#0F172A] py-16">
          <div className="max-w-7xl mx-auto px-6 lg:px-10 text-center">
            <h2 className="font-playfair text-3xl text-white mb-10">Why Stay With Us?</h2>
            <div className="grid grid-cols-2 md:grid-cols-4 gap-6">
              {[
                { icon: "🏆", title: "Award-Winning", desc: "5-star luxury experience" },
                { icon: "🍳", title: "Free Breakfast", desc: "Complimentary for all guests" },
                { icon: "🏊", title: "Rooftop Pool", desc: "Infinity pool with panoramic views" },
                { icon: "🚗", title: "Free Parking", desc: "Valet service included" },
              ].map((w) => (
                <div key={w.title} className="p-5 bg-white/5 rounded-2xl border border-white/10">
                  <div className="text-3xl mb-3">{w.icon}</div>
                  <h3 className="text-white font-semibold mb-1">{w.title}</h3>
                  <p className="text-gray-400 text-xs">{w.desc}</p>
                </div>
              ))}
            </div>
          </div>
        </div>
      </main>
      <Footer />
    </>
  );
}
