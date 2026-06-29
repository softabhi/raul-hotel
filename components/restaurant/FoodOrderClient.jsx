"use client";
import { useState } from "react";
import Link from "next/link";
import { Plus, Minus, ShoppingCart, ArrowRight } from "lucide-react";

export default function FoodOrderClient({ food }) {
  const [qty, setQty] = useState(1);

  const total = food.price * qty;
  const discount = food.originalPrice
    ? Math.round(((food.originalPrice - food.price) / food.originalPrice) * 100)
    : 0;

  return (
    <div className="bg-[#FAFAF8] rounded-2xl p-5 border border-gray-100">
      {/* Price */}
      <div className="flex items-baseline gap-3 mb-5">
        <span className="font-playfair text-4xl font-bold text-[#0F172A]">₹{food.price}</span>
        {food.originalPrice && (
          <span className="text-gray-400 line-through text-lg">₹{food.originalPrice}</span>
        )}
        {discount > 0 && <span className="badge-gold">{discount}% OFF</span>}
      </div>

      {/* Qty selector */}
      <div className="flex items-center gap-4 mb-5">
        <span className="text-sm font-medium text-gray-600">Quantity:</span>
        <div className="flex items-center gap-3 bg-white border border-gray-200 rounded-xl px-4 py-2">
          <button
            onClick={() => setQty((q) => Math.max(1, q - 1))}
            className="text-gray-500 hover:text-[#D4A853] transition-colors"
          >
            <Minus size={16} />
          </button>
          <span className="font-bold text-[#0F172A] w-6 text-center">{qty}</span>
          <button
            onClick={() => setQty((q) => q + 1)}
            className="text-gray-500 hover:text-[#D4A853] transition-colors"
          >
            <Plus size={16} />
          </button>
        </div>
        <span className="text-sm text-gray-500">Total: <strong className="text-[#D4A853]">₹{total}</strong></span>
      </div>

      {/* CTA */}
      <div className="flex gap-3">
        <Link href={`/order?foodId=${food.id}&qty=${qty}`} className="btn-gold flex-1 justify-center">
          <ShoppingCart size={17} /> Order Now
        </Link>
        <Link href="/restaurant" className="btn-outline-gold !py-2 !px-4">
          Back to Menu
        </Link>
      </div>

      <p className="text-xs text-gray-400 mt-3 text-center">
        🚴 Fast delivery · 🍽️ Dine-in available
      </p>
    </div>
  );
}
