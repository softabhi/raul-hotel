"use client";
import { useState } from "react";
import Link from "next/link";
import { X, Plus, Minus, ShoppingCart, Trash2, ArrowRight } from "lucide-react";
import Image from "next/image";

export default function CartSidebar({ open, onClose, cart, setCart }) {
  const updateQty = (id, delta) => {
    setCart((c) =>
      c
        .map((i) => (i.id === id ? { ...i, qty: i.qty + delta } : i))
        .filter((i) => i.qty > 0)
    );
  };
  const remove = (id) => setCart((c) => c.filter((i) => i.id !== id));
  const clear = () => setCart([]);

  const subtotal = cart.reduce((s, i) => s + i.price * i.qty, 0);
  const gst = Math.round(subtotal * 0.05);
  const total = subtotal + gst;

  return (
    <>
      {/* Overlay */}
      {open && <div className="fixed inset-0 bg-black/50 z-40 backdrop-blur-sm" onClick={onClose} />}

      {/* Sidebar */}
      <div className={`fixed top-0 right-0 h-full w-full max-w-sm bg-white z-50 shadow-2xl flex flex-col transition-transform duration-300 ${open ? "translate-x-0" : "translate-x-full"}`}>
        {/* Header */}
        <div className="flex items-center justify-between px-5 py-4 border-b border-gray-100 bg-[#0F172A]">
          <div className="flex items-center gap-2 text-white">
            <ShoppingCart size={20} className="text-[#D4A853]" />
            <span className="font-semibold">Your Order</span>
            {cart.length > 0 && (
              <span className="bg-[#D4A853] text-white text-xs w-5 h-5 rounded-full flex items-center justify-center font-bold">
                {cart.reduce((s, i) => s + i.qty, 0)}
              </span>
            )}
          </div>
          <button onClick={onClose} className="text-gray-400 hover:text-white transition-colors">
            <X size={20} />
          </button>
        </div>

        {/* Items */}
        <div className="flex-1 overflow-y-auto p-4 space-y-3">
          {cart.length === 0 ? (
            <div className="text-center py-16">
              <ShoppingCart size={48} className="text-gray-200 mx-auto mb-4" />
              <p className="text-gray-500 font-medium">Your cart is empty</p>
              <p className="text-gray-400 text-sm mt-1">Add some delicious dishes!</p>
              <button onClick={onClose} className="btn-gold mt-4">Browse Menu</button>
            </div>
          ) : (
            <>
              {cart.map((item) => (
                <div key={item.id} className="flex items-center gap-3 bg-[#FAFAF8] rounded-xl p-3 border border-gray-100">
                  <div className="relative w-14 h-14 rounded-lg overflow-hidden shrink-0">
                    <Image src={item.images[0]} alt={item.name} fill className="object-cover" />
                  </div>
                  <div className="flex-1 min-w-0">
                    <div className="flex items-start gap-1">
                      <div className={`w-3 h-3 rounded-sm border ${item.type === "veg" ? "border-green-500" : "border-red-500"} flex items-center justify-center shrink-0 mt-0.5`}>
                        <div className={`w-1.5 h-1.5 rounded-full ${item.type === "veg" ? "bg-green-500" : "bg-red-500"}`} />
                      </div>
                      <p className="text-sm font-medium text-[#0F172A] leading-tight truncate">{item.name}</p>
                    </div>
                    <p className="text-xs text-gray-400 mt-0.5">₹{item.price} each</p>
                    <div className="flex items-center justify-between mt-2">
                      <div className="flex items-center gap-2">
                        <button onClick={() => updateQty(item.id, -1)} className="w-6 h-6 rounded-full bg-gray-200 flex items-center justify-center hover:bg-[#D4A853] hover:text-white transition-colors">
                          <Minus size={12} />
                        </button>
                        <span className="text-sm font-bold w-4 text-center">{item.qty}</span>
                        <button onClick={() => updateQty(item.id, 1)} className="w-6 h-6 rounded-full bg-[#D4A853]/20 flex items-center justify-center hover:bg-[#D4A853] hover:text-white transition-colors">
                          <Plus size={12} />
                        </button>
                      </div>
                      <div className="flex items-center gap-2">
                        <span className="text-sm font-bold text-[#0F172A]">₹{item.price * item.qty}</span>
                        <button onClick={() => remove(item.id)} className="text-gray-300 hover:text-red-400 transition-colors">
                          <Trash2 size={14} />
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              ))}
              <button onClick={clear} className="text-xs text-red-400 hover:text-red-600 flex items-center gap-1 mt-2">
                <Trash2 size={12} /> Clear all items
              </button>
            </>
          )}
        </div>

        {/* Footer */}
        {cart.length > 0 && (
          <div className="border-t border-gray-100 p-4">
            <div className="space-y-2 text-sm mb-4">
              <div className="flex justify-between text-gray-500">
                <span>Subtotal</span><span>₹{subtotal}</span>
              </div>
              <div className="flex justify-between text-gray-500">
                <span>GST (5%)</span><span>₹{gst}</span>
              </div>
              <div className="flex justify-between font-bold text-[#0F172A] pt-2 border-t border-gray-100">
                <span>Total</span><span className="text-[#D4A853]">₹{total}</span>
              </div>
            </div>
            <Link
              href={`/order?items=${encodeURIComponent(JSON.stringify(cart.map(i => ({id: i.id, qty: i.qty}))))}`}
              onClick={onClose}
              className="btn-gold w-full justify-center"
            >
              Proceed to Order <ArrowRight size={16} />
            </Link>
          </div>
        )}
      </div>
    </>
  );
}
