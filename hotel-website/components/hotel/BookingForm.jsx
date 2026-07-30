"use client";
import { useState } from "react";
import Link from "next/link";
import { ArrowRight } from "lucide-react";

export default function BookingForm({ room }) {
  const [checkIn, setCheckIn] = useState("");
  const [checkOut, setCheckOut] = useState("");
  const [guests, setGuests] = useState(1);

  const nights =
    checkIn && checkOut
      ? Math.max(0, Math.floor((new Date(checkOut) - new Date(checkIn)) / (1000 * 60 * 60 * 24)))
      : 0;

  const subtotal = nights * room.price;
  const gst = Math.round(subtotal * 0.18);
  const total = subtotal + gst;

  return (
    <div className="space-y-4">
      <div>
        <label className="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1 block">Check In</label>
        <input
          type="date"
          value={checkIn}
          onChange={(e) => setCheckIn(e.target.value)}
          min={new Date().toISOString().split("T")[0]}
          className="input-field"
          id="check-in-date"
        />
      </div>
      <div>
        <label className="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1 block">Check Out</label>
        <input
          type="date"
          value={checkOut}
          onChange={(e) => setCheckOut(e.target.value)}
          min={checkIn || new Date().toISOString().split("T")[0]}
          className="input-field"
          id="check-out-date"
        />
      </div>
      <div>
        <label className="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1 block">Guests</label>
        <select value={guests} onChange={(e) => setGuests(Number(e.target.value))} className="input-field" id="guests-select">
          {Array.from({ length: room.capacity }, (_, i) => i + 1).map((n) => (
            <option key={n} value={n}>{n} Guest{n > 1 ? "s" : ""}</option>
          ))}
        </select>
      </div>

      {/* Price breakdown */}
      {nights > 0 && (
        <div className="bg-[#FAFAF8] rounded-xl p-4 space-y-2 border border-gray-100">
          <div className="flex justify-between text-sm text-gray-600">
            <span>₹{room.price.toLocaleString()} × {nights} night{nights > 1 ? "s" : ""}</span>
            <span>₹{subtotal.toLocaleString()}</span>
          </div>
          <div className="flex justify-between text-sm text-gray-600">
            <span>GST (5%)</span>
            <span>₹{gst.toLocaleString()}</span>
          </div>
          <div className="flex justify-between font-bold text-[#0F172A] pt-2 border-t border-gray-200">
            <span>Total</span>
            <span>₹{total.toLocaleString()}</span>
          </div>
        </div>
      )}

      <Link
        href={
          room.available
            ? `/booking?room=${room.id}&checkIn=${checkIn}&checkOut=${checkOut}&guests=${guests}&nights=${nights}`
            : "#"
        }
        className={`w-full justify-center ${room.available ? "btn-gold" : "bg-gray-200 text-gray-400 py-3 px-4 rounded-xl text-sm font-semibold cursor-not-allowed inline-flex items-center"}`}
      >
        {room.available ? (
          <><span>Reserve Now</span> <ArrowRight size={16} /></>
        ) : (
          "Room Unavailable"
        )}
      </Link>


      <p className="text-xs text-gray-400 text-center">Free cancellation up to 24 hours before check-in</p>
    </div>
  );
}
