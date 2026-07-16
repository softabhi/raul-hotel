"use client";
import { useState } from "react";
import { SlidersHorizontal, Grid3X3, LayoutList, X } from "lucide-react";
import { roomCategories } from "@/data/rooms";

export default function RoomFilters({ activeCategory, setActiveCategory, priceRange, setPriceRange, capacity, setCapacity }) {
  const [showFilters, setShowFilters] = useState(false);

  return (
    <div className="mb-8">
      {/* Category tabs */}
      <div className="flex flex-wrap gap-2 mb-5">
        {roomCategories.map((cat) => (
          <button
            key={cat}
            onClick={() => setActiveCategory(cat)}
            className={`px-5 py-2.5 rounded-full text-sm font-medium transition-all duration-200 ${
              activeCategory === cat
                ? "bg-[#D4A853] text-white shadow-lg shadow-[#D4A853]/30"
                : "bg-white text-gray-600 border border-gray-200 hover:border-[#D4A853] hover:text-[#D4A853]"
            }`}
          >
            {cat}
          </button>
        ))}
        <button
          onClick={() => setShowFilters(!showFilters)}
          className="ml-auto flex items-center gap-2 px-5 py-2.5 rounded-full text-sm font-medium bg-white border border-gray-200 text-gray-600 hover:border-[#D4A853] transition-all"
        >
          <SlidersHorizontal size={15} />
          Filters
        </button>
      </div>

      {/* Advanced filters */}
      {showFilters && (
        <div className="bg-white rounded-2xl p-5 border border-gray-200 shadow-sm">
          <div className="flex items-center justify-between mb-4">
            <h3 className="font-semibold text-[#0F172A]">Advanced Filters</h3>
            <button onClick={() => setShowFilters(false)} className="text-gray-400 hover:text-gray-600">
              <X size={18} />
            </button>
          </div>
          <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
            {/* Price range */}
            <div>
              <label className="text-sm font-medium text-gray-700 mb-2 block">
                Max Price: <span className="text-[#D4A853]">₹{priceRange.toLocaleString()}</span>
              </label>
              <input
                type="range"
                min={4999}
                max={29999}
                step={1000}
                value={priceRange}
                onChange={(e) => setPriceRange(Number(e.target.value))}
                className="w-full accent-[#D4A853]"
              />
              <div className="flex justify-between text-xs text-gray-400 mt-1">
                <span>₹4,999</span>
                <span>₹29,999</span>
              </div>
            </div>
            {/* Capacity */}
            <div>
              <label className="text-sm font-medium text-gray-700 mb-2 block">Guests</label>
              <div className="flex gap-2 flex-wrap">
                {[1, 2, 3, 4, 5, "6+"].map((n) => (
                  <button
                    key={n}
                    onClick={() => setCapacity(n === capacity ? null : n)}
                    className={`px-3 py-1.5 rounded-lg text-sm border transition-all ${
                      capacity === n
                        ? "bg-[#D4A853] text-white border-[#D4A853]"
                        : "border-gray-200 text-gray-600 hover:border-[#D4A853]"
                    }`}
                  >
                    {n}
                  </button>
                ))}
              </div>
            </div>
            {/* Reset */}
            <div className="flex items-end">
              <button
                onClick={() => { setActiveCategory("All"); setPriceRange(29999); setCapacity(null); }}
                className="btn-outline-gold !py-2 !px-4 !text-sm"
              >
                Reset Filters
              </button>
            </div>
          </div>
        </div>
      )}
    </div>
  );
}
