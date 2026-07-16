"use client";
import { useState, useMemo, useEffect } from "react";
import { fetchFoods } from "@/data/api";
import { foodCategories, foodTypes, cuisineTypes } from "@/data/foods";
import Navbar from "@/components/layout/Navbar";
import Footer from "@/components/layout/Footer";
import FoodCard from "@/components/restaurant/FoodCard";
import CartSidebar from "@/components/restaurant/CartSidebar";
import { UtensilsCrossed, Search, ShoppingCart, X } from "lucide-react";
import Image from "next/image";
import Link from "next/link";

export default function RestaurantPage() {
  const [foods, setFoods] = useState([]);
  const [activeCategory, setActiveCategory] = useState("All");
  const [activeType, setActiveType] = useState("all");
  const [activeCuisine, setActiveCuisine] = useState("All Cuisines");
  const [search, setSearch] = useState("");
  const [cart, setCart] = useState([]);
  const [cartOpen, setCartOpen] = useState(false);

  useEffect(() => {
    fetchFoods().then(setFoods);
  }, []);

  const filtered = useMemo(() => {
    return foods.filter((f) => {
      if (activeCategory !== "All" && f.category !== activeCategory) return false;
      if (activeType !== "all" && f.type !== activeType) return false;
      if (activeCuisine !== "All Cuisines" && f.cuisine !== activeCuisine) return false;
      if (search && !f.name.toLowerCase().includes(search.toLowerCase())) return false;
      return true;
    });
  }, [activeCategory, activeType, activeCuisine, search]);

  const addToCart = (food) => {
    setCart((c) => {
      const ex = c.find((i) => i.id === food.id);
      if (ex) return c.map((i) => i.id === food.id ? { ...i, qty: i.qty + 1 } : i);
      return [...c, { ...food, qty: 1 }];
    });
  };

  const cartCount = cart.reduce((s, i) => s + i.qty, 0);

  return (
    <>
      <Navbar />
      <main>
        {/* Hero Banner */}
        <div className="relative h-72 md:h-80">
          <Image src="https://images.unsplash.com/photo-1414235077428-338989a2e8c0?w=1920&q=85" alt="Restaurant" fill className="object-cover" priority />
          <div className="absolute inset-0 bg-[#0F172A]/70" />
          <div className="absolute inset-0 flex items-center justify-center text-center px-6 pt-16 pb-6">
            <div>
              <span className="section-label flex items-center justify-center gap-2">
                <UtensilsCrossed size={14} /> Our Menu
              </span>
              <h1 className="font-playfair text-4xl md:text-6xl text-white mt-2 mb-3">
                Fine <span className="gold-text">Dining</span>
              </h1>
              <p className="text-gray-300 text-lg max-w-xl mx-auto">
                Crafted with passion, served with love — explore our award-winning cuisine.
              </p>
            </div>
          </div>
        </div>

        <div className="max-w-7xl mx-auto px-6 lg:px-10 py-12">
          {/* Search + Cart toggle */}
          <div className="flex items-center gap-3 mb-8 flex-wrap">
            <div className="relative max-w-sm w-full sm:w-72">
              <Search size={18} className="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400" />
              <input
                type="text"
                placeholder="Search dishes..."
                value={search}
                onChange={(e) => setSearch(e.target.value)}
                className="input-field !pl-10"
              />
              {search && (
                <button onClick={() => setSearch("")} className="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                  <X size={15} />
                </button>
              )}
            </div>
            <span className="text-sm text-gray-500">
              <strong className="text-[#0F172A]">{filtered.length}</strong> dishes found
            </span>
            <button
              onClick={() => setCartOpen(true)}
              className="ml-auto relative btn-gold !py-2.5 !px-5"
            >
              <ShoppingCart size={18} />
              Cart
              {cartCount > 0 && (
                <span className="absolute -top-2 -right-2 w-5 h-5 bg-red-500 text-white text-xs rounded-full flex items-center justify-center font-bold">
                  {cartCount}
                </span>
              )}
            </button>
          </div>

          {/* Veg/Non-veg toggle */}
          <div className="flex items-center gap-3 mb-5 flex-wrap">
            <span className="text-sm font-medium text-gray-600">Filter by type:</span>
            <div className="flex gap-2">
              {[
                { value: "all", label: "All" },
                { value: "veg", label: "🟢 Veg" },
                { value: "non-veg", label: "🔴 Non-Veg" },
              ].map((t) => (
                <button
                  key={t.value}
                  onClick={() => setActiveType(t.value)}
                  className={`px-4 py-2 rounded-full text-sm font-medium transition-all border ${
                    activeType === t.value
                      ? t.value === "veg" ? "bg-green-600 text-white border-green-600" : t.value === "non-veg" ? "bg-red-600 text-white border-red-600" : "bg-[#0F172A] text-white border-[#0F172A]"
                      : "bg-white border-gray-200 text-gray-600 hover:border-gray-400"
                  }`}
                >
                  {t.label}
                </button>
              ))}
            </div>
          </div>

          {/* Category tabs */}
          <div className="flex flex-wrap gap-2 mb-5">
            {foodCategories.map((cat) => (
              <button
                key={cat}
                onClick={() => setActiveCategory(cat)}
                className={`px-4 py-2 rounded-full text-sm font-medium transition-all ${
                  activeCategory === cat
                    ? "bg-[#D4A853] text-white shadow-lg shadow-[#D4A853]/30"
                    : "bg-white text-gray-600 border border-gray-200 hover:border-[#D4A853]"
                }`}
              >
                {cat}
              </button>
            ))}
          </div>

          {/* Cuisine tabs */}
          <div className="flex flex-wrap gap-2 mb-8">
            {cuisineTypes.map((c) => (
              <button
                key={c}
                onClick={() => setActiveCuisine(c)}
                className={`px-3 py-1.5 rounded-lg text-xs font-medium border transition-all ${
                  activeCuisine === c ? "bg-[#0F172A] text-white border-[#0F172A]" : "border-gray-200 text-gray-500 hover:border-gray-400"
                }`}
              >
                {c}
              </button>
            ))}
          </div>

          {/* Food grid */}
          {filtered.length > 0 ? (
            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
              {filtered.map((food) => (
                <FoodCard key={food.id} food={food} onAddToCart={addToCart} />
              ))}
            </div>
          ) : (
            <div className="text-center py-20">
              <UtensilsCrossed size={48} className="text-gray-300 mx-auto mb-4" />
              <h3 className="text-xl font-semibold text-gray-600 mb-2">No dishes found</h3>
              <p className="text-gray-400 text-sm">Try changing your filters</p>
            </div>
          )}

          {/* Cart sticky bar */}
          {cartCount > 0 && (
            <div className="fixed bottom-6 left-1/2 -translate-x-1/2 z-50">
              <button
                onClick={() => setCartOpen(true)}
                className="btn-gold !py-3.5 !px-8 shadow-2xl rounded-full text-base animate-pulse-gold"
              >
                <ShoppingCart size={20} />
                {cartCount} item{cartCount > 1 ? "s" : ""} in cart — View Order
              </button>
            </div>
          )}
        </div>
      </main>

      {/* Cart Sidebar */}
      <CartSidebar
        open={cartOpen}
        onClose={() => setCartOpen(false)}
        cart={cart}
        setCart={setCart}
      />

      <Footer />
    </>
  );
}
