"use client";
import Link from "next/link";
import { useState } from "react";
import ImageSlider from "@/components/ui/ImageSlider";
import StarRating from "@/components/ui/StarRating";
import { Clock, Flame, Plus, Check, ShoppingCart } from "lucide-react";

export default function FoodCard({ food, onAddToCart }) {
  const [added, setAdded] = useState(false);

  const handleAdd = (e) => {
    e.preventDefault();
    e.stopPropagation();
    if (onAddToCart) onAddToCart(food);
    setAdded(true);
    setTimeout(() => setAdded(false), 2000);
  };

  const discount = food.originalPrice
    ? Math.round(((food.originalPrice - food.price) / food.originalPrice) * 100)
    : 0;

  return (
    <div className="card-hover bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 flex flex-col">
      {/* Image slider */}
      <div className="relative">
        <ImageSlider images={food.images} alt={food.name} height={210} />
        {/* Badges */}
        <div className="absolute top-3 left-3 flex gap-2 z-10">
          {food.isBestSeller && <span className="badge-gold">Best Seller</span>}
          {food.isPopular && !food.isBestSeller && <span className="badge-navy">Popular</span>}
          {discount > 0 && <span className="bg-green-600 text-white text-xs font-semibold px-2 py-0.5 rounded-full">{discount}% OFF</span>}
        </div>
        {/* Veg/Non-Veg indicator */}
        <div className="absolute top-3 right-3 z-10">
          <div className={`w-8 h-8 rounded-full flex items-center justify-center ${food.type === "veg" ? "bg-green-50 border-2 border-green-500" : "bg-red-50 border-2 border-red-500"}`}>
            <div className={`w-3 h-3 rounded-full ${food.type === "veg" ? "bg-green-500" : "bg-red-500"}`} />
          </div>
        </div>
      </div>

      {/* Content */}
      <div className="p-4 flex flex-col flex-1">
        <div className="flex items-start justify-between gap-2 mb-1">
          <h3 className="font-playfair text-base font-600 text-[#0F172A] leading-tight">{food.name}</h3>
        </div>
        <p className="text-xs text-gray-500 mb-2">{food.cuisine} · {food.category}</p>

        <StarRating rating={food.rating} count={food.reviewCount} size={12} />

        <p className="text-xs text-gray-500 mt-2 line-clamp-2 leading-relaxed">{food.description}</p>

        {/* Tags */}
        <div className="flex gap-2 mt-3 flex-wrap">
          <span className="flex items-center gap-1 text-xs text-gray-500">
            <Clock size={11} className="text-[#D4A853]" /> {food.prepTime}
          </span>
          <span className="flex items-center gap-1 text-xs text-gray-500">
            <Flame size={11} className="text-orange-400" /> {food.calories} kcal
          </span>
          {food.spiceLevel !== "None" && (
            <span className={`text-xs px-1.5 py-0.5 rounded font-medium ${
              food.spiceLevel === "Hot" ? "bg-red-50 text-red-600" :
              food.spiceLevel === "Medium-Hot" ? "bg-orange-50 text-orange-600" :
              "bg-yellow-50 text-yellow-600"
            }`}>
              {food.spiceLevel}
            </span>
          )}
        </div>

        {/* Price & CTA */}
        <div className="mt-auto flex items-center justify-between pt-4 border-t border-gray-100 mt-4">
          <div>
            <div className="flex items-baseline gap-1">
              <span className="text-xl font-bold text-[#0F172A]">₹{food.price}</span>
              {food.originalPrice && (
                <span className="text-xs text-gray-400 line-through">₹{food.originalPrice}</span>
              )}
            </div>
            <p className="text-xs text-gray-400">Serves {food.servings}</p>
          </div>
          <div className="flex gap-2">
            <Link href={`/restaurant/${food.id}`} className="btn-outline-gold !py-2 !px-3 !text-xs">
              View
            </Link>
            <button
              onClick={handleAdd}
              className={`flex items-center gap-1 py-2 px-3 rounded-lg text-xs font-semibold transition-all ${
                added
                  ? "bg-green-500 text-white"
                  : "btn-gold"
              }`}
            >
              {added ? <><Check size={14} /> Added</> : <><Plus size={14} /> Add</>}
            </button>
          </div>
        </div>
      </div>
    </div>
  );
}
