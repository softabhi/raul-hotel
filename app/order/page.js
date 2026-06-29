"use client";
import { Suspense, useState } from "react";
import { useSearchParams } from "next/navigation";
import Image from "next/image";
import Link from "next/link";
import Navbar from "@/components/layout/Navbar";
import Footer from "@/components/layout/Footer";
import { getFoodById, foods } from "@/data/foods";
import { CheckCircle, ShoppingCart, User, MapPin, Plus, Minus, Trash2 } from "lucide-react";

function OrderContent() {
  const params = useSearchParams();
  const foodId = params.get("foodId");
  const qty = Number(params.get("qty")) || 1;

  const initCart = foodId
    ? [{ ...getFoodById(foodId), qty }]
    : foods.slice(0, 3).map((f, i) => ({ ...f, qty: i === 0 ? 2 : 1 }));

  const [cart, setCart] = useState(initCart.filter(Boolean));
  const [step, setStep] = useState(1);
  const [confirmed, setConfirmed] = useState(false);
  const [orderType, setOrderType] = useState("dine-in");
  const [form, setForm] = useState({ name: "", phone: "", email: "", address: "", notes: "" });

  const handleChange = (e) => setForm((f) => ({ ...f, [e.target.name]: e.target.value }));
  const updateQty = (id, d) => setCart((c) => c.map((i) => i.id === id ? { ...i, qty: Math.max(1, i.qty + d) } : i).filter(i => i.qty > 0));
  const remove = (id) => setCart((c) => c.filter((i) => i.id !== id));

  const subtotal = cart.reduce((s, i) => s + i.price * i.qty, 0);
  const gst = Math.round(subtotal * 0.05);
  const delivery = orderType === "delivery" ? 49 : 0;
  const total = subtotal + gst + delivery;

  if (confirmed) {
    return (
      <div className="min-h-screen flex items-center justify-center bg-[#FAFAF8] px-6 pt-24">
        <div className="max-w-md w-full text-center bg-white rounded-3xl shadow-2xl p-10">
          <div className="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
            <CheckCircle size={40} className="text-green-500" />
          </div>
          <h2 className="font-playfair text-3xl text-[#0F172A] mb-2">Order Placed!</h2>
          <p className="text-gray-500 mb-4">Your delicious food is being prepared.</p>
          <div className="bg-[#FAFAF8] rounded-xl p-4 text-sm text-left mb-6">
            <p><strong>Order ID:</strong> RST-{Math.floor(Math.random() * 900000) + 100000}</p>
            <p><strong>Items:</strong> {cart.reduce((s, i) => s + i.qty, 0)}</p>
            <p><strong>Total:</strong> ₹{total.toLocaleString()}</p>
            <p><strong>Type:</strong> {orderType === "dine-in" ? "Dine In" : "Delivery"}</p>
            {orderType === "dine-in" ? <p><strong>ETA:</strong> 25–35 mins</p> : <p><strong>Delivery:</strong> 40–50 mins</p>}
          </div>
          <Link href="/restaurant" className="btn-gold w-full justify-center">Order More Food</Link>
        </div>
      </div>
    );
  }

  return (
    <div className="min-h-screen bg-[#FAFAF8] pt-24 pb-16">
      <div className="max-w-5xl mx-auto px-6 lg:px-10">
        <h1 className="font-playfair text-3xl text-[#0F172A] mb-2">Your Food Order</h1>
        <p className="text-gray-500 text-sm mb-8">Review your items and complete the order</p>

        <div className="grid grid-cols-1 lg:grid-cols-3 gap-8">
          {/* Left */}
          <div className="lg:col-span-2 space-y-5">
            {/* Order type */}
            <div className="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
              <h2 className="font-semibold text-[#0F172A] mb-4">Order Type</h2>
              <div className="grid grid-cols-2 gap-3">
                {[
                  { value: "dine-in", label: "🍽️ Dine In", sub: "Eat at our restaurant" },
                  { value: "delivery", label: "🚴 Delivery", sub: "Delivered to your address (+₹49)" },
                ].map((t) => (
                  <button
                    key={t.value}
                    onClick={() => setOrderType(t.value)}
                    className={`p-4 rounded-xl border-2 text-left transition-all ${
                      orderType === t.value
                        ? "border-[#D4A853] bg-[#D4A853]/5"
                        : "border-gray-200 hover:border-gray-300"
                    }`}
                  >
                    <p className="font-semibold text-sm">{t.label}</p>
                    <p className="text-xs text-gray-400 mt-0.5">{t.sub}</p>
                  </button>
                ))}
              </div>
            </div>

            {/* Cart items */}
            <div className="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
              <h2 className="font-semibold text-[#0F172A] mb-4 flex items-center gap-2">
                <ShoppingCart size={18} className="text-[#D4A853]" /> Order Items ({cart.reduce((s, i) => s + i.qty, 0)})
              </h2>
              <div className="space-y-3">
                {cart.map((item) => (
                  <div key={item.id} className="flex items-center gap-3 border-b border-gray-50 pb-3">
                    <div className="relative w-16 h-16 rounded-xl overflow-hidden shrink-0">
                      <Image src={item.images[0]} alt={item.name} fill className="object-cover" />
                    </div>
                    <div className="flex-1">
                      <p className="font-medium text-sm text-[#0F172A]">{item.name}</p>
                      <p className="text-xs text-gray-400">₹{item.price} each</p>
                      <div className="flex items-center gap-2 mt-1.5">
                        <button onClick={() => updateQty(item.id, -1)} className="w-6 h-6 rounded-full bg-gray-100 flex items-center justify-center hover:bg-[#D4A853]/20 transition-colors">
                          <Minus size={12} />
                        </button>
                        <span className="text-sm font-bold">{item.qty}</span>
                        <button onClick={() => updateQty(item.id, 1)} className="w-6 h-6 rounded-full bg-gray-100 flex items-center justify-center hover:bg-[#D4A853]/20 transition-colors">
                          <Plus size={12} />
                        </button>
                      </div>
                    </div>
                    <div className="text-right">
                      <p className="font-bold text-[#0F172A]">₹{item.price * item.qty}</p>
                      <button onClick={() => remove(item.id)} className="text-gray-300 hover:text-red-400 transition-colors mt-1">
                        <Trash2 size={14} />
                      </button>
                    </div>
                  </div>
                ))}
              </div>
              <Link href="/restaurant" className="text-sm text-[#D4A853] hover:underline mt-3 inline-block">+ Add more items</Link>
            </div>

            {/* Customer Details */}
            <div className="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
              <h2 className="font-semibold text-[#0F172A] mb-4 flex items-center gap-2">
                <User size={18} className="text-[#D4A853]" /> Your Details
              </h2>
              <div className="grid grid-cols-2 gap-4">
                <div className="col-span-2 md:col-span-1">
                  <label className="text-xs text-gray-500 mb-1 block">Full Name *</label>
                  <input name="name" value={form.name} onChange={handleChange} placeholder="Your name" className="input-field" />
                </div>
                <div className="col-span-2 md:col-span-1">
                  <label className="text-xs text-gray-500 mb-1 block">Phone *</label>
                  <input name="phone" type="tel" value={form.phone} onChange={handleChange} placeholder="+91 98765 43210" className="input-field" />
                </div>
                <div className="col-span-2">
                  <label className="text-xs text-gray-500 mb-1 block">Email</label>
                  <input name="email" type="email" value={form.email} onChange={handleChange} placeholder="your@email.com" className="input-field" />
                </div>
                {orderType === "delivery" && (
                  <div className="col-span-2">
                    <label className="text-xs text-gray-500 mb-1 block flex items-center gap-1">
                      <MapPin size={11} /> Delivery Address *
                    </label>
                    <textarea name="address" value={form.address} onChange={handleChange} rows={2} placeholder="Full delivery address" className="input-field resize-none" />
                  </div>
                )}
                <div className="col-span-2">
                  <label className="text-xs text-gray-500 mb-1 block">Special Instructions</label>
                  <textarea name="notes" value={form.notes} onChange={handleChange} rows={2} placeholder="Allergies, preferences, etc." className="input-field resize-none" />
                </div>
              </div>
            </div>
          </div>

          {/* Summary */}
          <div className="lg:col-span-1">
            <div className="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 sticky top-28">
              <h3 className="font-semibold text-[#0F172A] mb-4">Order Summary</h3>
              <div className="space-y-2 text-sm">
                <div className="flex justify-between text-gray-500">
                  <span>Subtotal ({cart.reduce((s, i) => s + i.qty, 0)} items)</span>
                  <span>₹{subtotal}</span>
                </div>
                <div className="flex justify-between text-gray-500">
                  <span>GST (5%)</span>
                  <span>₹{gst}</span>
                </div>
                {orderType === "delivery" && (
                  <div className="flex justify-between text-gray-500">
                    <span>Delivery charge</span>
                    <span>₹{delivery}</span>
                  </div>
                )}
                <div className="flex justify-between font-bold text-[#0F172A] pt-3 border-t border-gray-100 text-base">
                  <span>Total</span>
                  <span className="text-[#D4A853]">₹{total}</span>
                </div>
              </div>

              <button
                onClick={() => setConfirmed(true)}
                disabled={cart.length === 0}
                className="btn-gold w-full justify-center mt-5 disabled:opacity-50 disabled:cursor-not-allowed"
              >
                Place Order — ₹{total}
              </button>

              <p className="text-xs text-center text-gray-400 mt-3">
                {orderType === "dine-in" ? "⏱️ Ready in 25–35 mins" : "🚴 Delivered in 40–50 mins"}
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}

export default function OrderPage() {
  return (
    <>
      <Navbar />
      <Suspense fallback={<div className="pt-24 text-center py-20 text-gray-400">Loading your order...</div>}>
        <OrderContent />
      </Suspense>
      <Footer />
    </>
  );
}
