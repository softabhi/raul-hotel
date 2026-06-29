"use client";
import { Suspense, useState } from "react";
import { useSearchParams } from "next/navigation";
import Image from "next/image";
import Link from "next/link";
import Navbar from "@/components/layout/Navbar";
import Footer from "@/components/layout/Footer";
import { getRoomById } from "@/data/rooms";
import { CheckCircle, Hotel, ArrowLeft, CreditCard, User, Phone, Mail } from "lucide-react";

function BookingContent() {
  const params = useSearchParams();
  const roomId = params.get("room");
  const checkIn = params.get("checkIn") || "";
  const checkOut = params.get("checkOut") || "";
  const guests = params.get("guests") || "1";
  const nights = Number(params.get("nights")) || 1;

  const room = roomId ? getRoomById(roomId) : null;
  const [step, setStep] = useState(1);
  const [confirmed, setConfirmed] = useState(false);
  const [form, setForm] = useState({
    firstName: "", lastName: "", email: "", phone: "", requests: "",
    cardNumber: "", expiry: "", cvv: "", cardName: "",
  });

  const handleChange = (e) => setForm((f) => ({ ...f, [e.target.name]: e.target.value }));

  const subtotal = room ? nights * room.price : 0;
  const gst = Math.round(subtotal * 0.18);
  const total = subtotal + gst;

  if (confirmed) {
    return (
      <div className="min-h-screen flex items-center justify-center bg-[#FAFAF8] px-6 pt-24">
        <div className="max-w-md w-full text-center bg-white rounded-3xl shadow-2xl p-10 border border-gray-100">
          <div className="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
            <CheckCircle size={40} className="text-green-500" />
          </div>
          <h2 className="font-playfair text-3xl text-[#0F172A] mb-2">Booking Confirmed!</h2>
          <p className="text-gray-500 mb-4">Your reservation has been successfully placed.</p>
          <div className="bg-[#FAFAF8] rounded-xl p-4 text-sm text-left mb-6 border border-gray-100">
            <p><strong>Booking ID:</strong> LXS-{Math.floor(Math.random() * 900000) + 100000}</p>
            {room && <p><strong>Room:</strong> {room.name}</p>}
            {checkIn && <p><strong>Check In:</strong> {checkIn}</p>}
            {checkOut && <p><strong>Check Out:</strong> {checkOut}</p>}
            <p><strong>Total Paid:</strong> ₹{total.toLocaleString()}</p>
          </div>
          <p className="text-xs text-gray-400 mb-6">A confirmation email has been sent to {form.email}</p>
          <Link href="/" className="btn-gold w-full justify-center">Back to Home</Link>
        </div>
      </div>
    );
  }

  return (
    <div className="min-h-screen bg-[#FAFAF8] pt-24 pb-16">
      <div className="max-w-5xl mx-auto px-6 lg:px-10">
        <div className="flex items-center gap-3 mb-8">
          <Link href="/hotel" className="text-gray-400 hover:text-[#D4A853] transition-colors">
            <ArrowLeft size={20} />
          </Link>
          <div>
            <h1 className="font-playfair text-3xl text-[#0F172A]">Complete Your Booking</h1>
            <p className="text-gray-500 text-sm">Secure checkout — all data is encrypted</p>
          </div>
        </div>

        {/* Steps */}
        <div className="flex items-center gap-3 mb-8">
          {["Guest Details", "Payment", "Confirm"].map((s, i) => (
            <div key={s} className="flex items-center gap-2">
              <div className={`w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold ${step > i + 1 ? "bg-green-500 text-white" : step === i + 1 ? "bg-[#D4A853] text-white" : "bg-gray-200 text-gray-500"}`}>
                {step > i + 1 ? "✓" : i + 1}
              </div>
              <span className={`text-sm font-medium ${step === i + 1 ? "text-[#0F172A]" : "text-gray-400"}`}>{s}</span>
              {i < 2 && <div className="h-px w-8 bg-gray-200" />}
            </div>
          ))}
        </div>

        <div className="grid grid-cols-1 lg:grid-cols-3 gap-8">
          {/* Form */}
          <div className="lg:col-span-2">
            {step === 1 && (
              <div className="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <h2 className="font-semibold text-[#0F172A] mb-5 flex items-center gap-2">
                  <User size={18} className="text-[#D4A853]" /> Guest Information
                </h2>
                <div className="grid grid-cols-2 gap-4 mb-4">
                  <div>
                    <label className="text-xs font-medium text-gray-500 mb-1 block">First Name *</label>
                    <input name="firstName" value={form.firstName} onChange={handleChange} placeholder="John" className="input-field" />
                  </div>
                  <div>
                    <label className="text-xs font-medium text-gray-500 mb-1 block">Last Name *</label>
                    <input name="lastName" value={form.lastName} onChange={handleChange} placeholder="Doe" className="input-field" />
                  </div>
                  <div>
                    <label className="text-xs font-medium text-gray-500 mb-1 block flex items-center gap-1">
                      <Mail size={11} /> Email *
                    </label>
                    <input name="email" type="email" value={form.email} onChange={handleChange} placeholder="john@email.com" className="input-field" />
                  </div>
                  <div>
                    <label className="text-xs font-medium text-gray-500 mb-1 block flex items-center gap-1">
                      <Phone size={11} /> Phone *
                    </label>
                    <input name="phone" type="tel" value={form.phone} onChange={handleChange} placeholder="+91 98765 43210" className="input-field" />
                  </div>
                </div>
                <div>
                  <label className="text-xs font-medium text-gray-500 mb-1 block">Special Requests (optional)</label>
                  <textarea name="requests" value={form.requests} onChange={handleChange} rows={3} placeholder="Any special requests or preferences..." className="input-field resize-none" />
                </div>
                <button onClick={() => setStep(2)} className="btn-gold mt-5 w-full justify-center">
                  Continue to Payment
                </button>
              </div>
            )}

            {step === 2 && (
              <div className="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <h2 className="font-semibold text-[#0F172A] mb-5 flex items-center gap-2">
                  <CreditCard size={18} className="text-[#D4A853]" /> Payment Details
                </h2>
                <div className="space-y-4">
                  <div>
                    <label className="text-xs font-medium text-gray-500 mb-1 block">Cardholder Name *</label>
                    <input name="cardName" value={form.cardName} onChange={handleChange} placeholder="John Doe" className="input-field" />
                  </div>
                  <div>
                    <label className="text-xs font-medium text-gray-500 mb-1 block">Card Number *</label>
                    <input name="cardNumber" value={form.cardNumber} onChange={handleChange} placeholder="1234 5678 9012 3456" maxLength={19} className="input-field" />
                  </div>
                  <div className="grid grid-cols-2 gap-4">
                    <div>
                      <label className="text-xs font-medium text-gray-500 mb-1 block">Expiry *</label>
                      <input name="expiry" value={form.expiry} onChange={handleChange} placeholder="MM/YY" maxLength={5} className="input-field" />
                    </div>
                    <div>
                      <label className="text-xs font-medium text-gray-500 mb-1 block">CVV *</label>
                      <input name="cvv" value={form.cvv} onChange={handleChange} placeholder="123" maxLength={3} className="input-field" />
                    </div>
                  </div>
                  <div className="bg-blue-50 rounded-xl p-3 text-xs text-blue-700 border border-blue-100">
                    🔒 This is a demo. No real payment will be processed.
                  </div>
                </div>
                <div className="flex gap-3 mt-5">
                  <button onClick={() => setStep(1)} className="btn-outline-gold flex-1 justify-center">Back</button>
                  <button onClick={() => setStep(3)} className="btn-gold flex-1 justify-center">Review Booking</button>
                </div>
              </div>
            )}

            {step === 3 && (
              <div className="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <h2 className="font-semibold text-[#0F172A] mb-5">Confirm Your Booking</h2>
                <div className="space-y-3 text-sm mb-6">
                  <div className="flex justify-between py-2 border-b border-gray-100">
                    <span className="text-gray-500">Guest Name</span>
                    <span className="font-medium">{form.firstName} {form.lastName}</span>
                  </div>
                  <div className="flex justify-between py-2 border-b border-gray-100">
                    <span className="text-gray-500">Email</span>
                    <span className="font-medium">{form.email}</span>
                  </div>
                  <div className="flex justify-between py-2 border-b border-gray-100">
                    <span className="text-gray-500">Check In</span>
                    <span className="font-medium">{checkIn || "—"}</span>
                  </div>
                  <div className="flex justify-between py-2 border-b border-gray-100">
                    <span className="text-gray-500">Check Out</span>
                    <span className="font-medium">{checkOut || "—"}</span>
                  </div>
                  <div className="flex justify-between py-2 border-b border-gray-100">
                    <span className="text-gray-500">Guests</span>
                    <span className="font-medium">{guests}</span>
                  </div>
                  <div className="flex justify-between py-2 font-bold text-[#0F172A]">
                    <span>Total Amount</span>
                    <span className="text-[#D4A853]">₹{total.toLocaleString()}</span>
                  </div>
                </div>
                <div className="flex gap-3">
                  <button onClick={() => setStep(2)} className="btn-outline-gold flex-1 justify-center">Back</button>
                  <button onClick={() => setConfirmed(true)} className="btn-gold flex-1 justify-center">
                    Confirm & Pay ₹{total.toLocaleString()}
                  </button>
                </div>
              </div>
            )}
          </div>

          {/* Summary */}
          <div className="lg:col-span-1">
            <div className="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden sticky top-28">
              {room && (
                <div className="relative h-44">
                  <Image src={room.images[0]} alt={room.name} fill className="object-cover" />
                </div>
              )}
              <div className="p-5">
                <h3 className="font-playfair text-lg text-[#0F172A] mb-1">{room ? room.name : "Selected Room"}</h3>
                {checkIn && checkOut && (
                  <p className="text-xs text-gray-500 mb-4">{checkIn} → {checkOut} · {nights} night{nights > 1 ? "s" : ""}</p>
                )}
                <div className="space-y-2 text-sm border-t border-gray-100 pt-4">
                  <div className="flex justify-between text-gray-500">
                    <span>Room charge</span>
                    <span>₹{subtotal.toLocaleString()}</span>
                  </div>
                  <div className="flex justify-between text-gray-500">
                    <span>GST (18%)</span>
                    <span>₹{gst.toLocaleString()}</span>
                  </div>
                  <div className="flex justify-between font-bold text-[#0F172A] pt-2 border-t border-gray-100">
                    <span>Total</span>
                    <span className="text-[#D4A853]">₹{total.toLocaleString()}</span>
                  </div>
                </div>
                <div className="mt-4 text-xs text-gray-400 bg-green-50 rounded-lg p-3 border border-green-100">
                  ✅ Free cancellation up to 24 hours before check-in
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}

export default function BookingPage() {
  return (
    <>
      <Navbar />
      <Suspense fallback={<div className="pt-24 text-center py-20 text-gray-400">Loading booking...</div>}>
        <BookingContent />
      </Suspense>
      <Footer />
    </>
  );
}
