"use client";
import { useState, useEffect } from "react";
import Link from "next/link";
import { fetchFoods } from "@/data/api";
import FoodCard from "@/components/restaurant/FoodCard";
import { ArrowRight, UtensilsCrossed } from "lucide-react";

export default function RestaurantPreview() {
  const [foods, setFoods] = useState([]);
  const [cart, setCart] = useState([]);

  useEffect(() => {
    fetchFoods().then(setFoods);
  }, []);

  const featured = foods.filter((f) => f.isBestSeller || f.isPopular).slice(0, 4);

  const addToCart = (food) => {
    setCart((c) => {
      const existing = c.find((i) => i.id === food.id);
      if (existing) return c.map((i) => i.id === food.id ? { ...i, qty: i.qty + 1 } : i);
      return [...c, { ...food, qty: 1 }];
    });
  };

  return (
    <section className="py-20 bg-white">
      <div className="max-w-7xl mx-auto px-6 lg:px-10">
        {/* Header */}
        <div className="flex flex-col md:flex-row items-start md:items-end justify-between gap-6 mb-12">
          <div>
            <span className="section-label flex items-center gap-2">
              <UtensilsCrossed size={14} /> Our Restaurant
            </span>
            <h2 className="font-playfair text-4xl md:text-5xl text-[#0F172A] mt-1">
              Taste the <span className="gold-text">Finest</span>
            </h2>
            <div className="gold-divider !mx-0 mt-3" />
            <p className="text-gray-500 mt-3 max-w-lg">
              From authentic Indian curries to continental delicacies — our chefs craft each dish with passion and the freshest ingredients.
            </p>
          </div>
          <Link href="/restaurant" className="btn-outline-gold whitespace-nowrap">
            Full Menu <ArrowRight size={16} />
          </Link>
        </div>

        {/* Veg/Non-Veg legend */}
        <div className="flex gap-5 mb-8">
          <div className="flex items-center gap-2 text-sm text-gray-600">
            <div className="w-5 h-5 rounded border-2 border-green-500 flex items-center justify-center">
              <div className="w-2.5 h-2.5 rounded-full bg-green-500" />
            </div>
            Vegetarian
          </div>
          <div className="flex items-center gap-2 text-sm text-gray-600">
            <div className="w-5 h-5 rounded border-2 border-red-500 flex items-center justify-center">
              <div className="w-2.5 h-2.5 rounded-full bg-red-500" />
            </div>
            Non-Vegetarian
          </div>
        </div>

        {/* Food cards */}
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
          {featured.map((food) => (
            <FoodCard key={food.id} food={food} onAddToCart={addToCart} />
          ))}
        </div>

        {/* Cart notification */}
        {cart.length > 0 && (
          <div className="mt-8 flex items-center justify-between bg-[#0F172A] text-white rounded-2xl px-6 py-4 shadow-xl">
            <span className="text-sm">
              🛒 <strong>{cart.reduce((sum, i) => sum + i.qty, 0)} items</strong> added to your order
            </span>
            <Link href="/order" className="btn-gold !py-2 !px-4 !text-sm">
              View Order <ArrowRight size={15} />
            </Link>
          </div>
        )}

        {/* CTA Banner */}
        <div className="mt-14 rounded-3xl overflow-hidden bg-gradient-to-r from-[#0F172A] to-[#1E293B] p-8 md:p-12 flex flex-col md:flex-row items-center gap-6 border border-[#D4A853]/20">
          <div className="flex-1">
            <p className="text-[#D4A853] text-sm font-semibold mb-2 uppercase tracking-widest">Dine In or Order Online</p>
            <h3 className="font-playfair text-3xl text-white mb-3">
              Exceptional Cuisine, <br />Delivered to Your Door
            </h3>
            <p className="text-gray-400 text-sm">
              Enjoy our award-winning recipes from the comfort of your room or at our elegant restaurant.
            </p>
          </div>
          <div className="flex flex-col gap-3">
            <Link href="/restaurant" className="btn-gold whitespace-nowrap">
              <UtensilsCrossed size={16} /> Browse Full Menu
            </Link>
            <Link href="/order" className="btn-outline-gold whitespace-nowrap">
              Place an Order
            </Link>
          </div>
        </div>
      </div>
    </section>
  );
}
