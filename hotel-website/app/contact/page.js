"use client";
import { useState } from "react";
import Image from "next/image";
import Navbar from "@/components/layout/Navbar";
import Footer from "@/components/layout/Footer";
import { Phone, Mail, MapPin, Clock, Send, CheckCircle, MessageCircle, Share2, Globe } from "lucide-react";

export default function ContactPage() {
  const [form, setForm] = useState({ name: "", email: "", phone: "", subject: "", message: "" });
  const [sent, setSent] = useState(false);

  const handleChange = (e) => setForm((f) => ({ ...f, [e.target.name]: e.target.value }));
  const handleSubmit = (e) => { e.preventDefault(); setSent(true); };

  return (
    <>
      <Navbar />
      <main>
        {/* Hero */}
        <div className="relative h-64 md:h-80">
          <Image src="https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?w=1920&q=85" alt="Contact Us" fill className="object-cover" priority />
          <div className="absolute inset-0 bg-[#0F172A]/75" />
          <div className="absolute inset-0 flex items-center justify-center text-center pt-16 pb-6">
            <div>
              <span className="section-label">Get in Touch</span>
              <h1 className="font-playfair text-5xl text-white mt-2">
                Contact <span className="gold-text">Us</span>
              </h1>
            </div>
          </div>
        </div>

        <div className="max-w-7xl mx-auto px-6 lg:px-10 py-16">
          <div className="grid grid-cols-1 lg:grid-cols-3 gap-10">
            {/* Contact Info */}
            <div className="space-y-5">
              <div className="bg-[#0F172A] rounded-2xl p-6 text-white">
                <h2 className="font-playfair text-2xl mb-5">Find Us</h2>
                <div className="space-y-4">
                  <div className="flex items-start gap-3">
                    <MapPin size={20} className="text-[#D4A853] shrink-0 mt-0.5" />
                    <div>
                      <p className="font-medium text-sm">Address</p>
                      <p className="text-gray-400 text-sm">12 Luxury Avenue, Bandra West,<br />Mumbai — 400050, India</p>
                    </div>
                  </div>
                  <div className="flex items-center gap-3">
                    <Phone size={20} className="text-[#D4A853]" />
                    <div>
                      <p className="font-medium text-sm">Phone</p>
                      <a href="tel:+919876543210" className="text-gray-400 text-sm hover:text-[#D4A853]">+91 98765 43210</a>
                    </div>
                  </div>
                  <div className="flex items-center gap-3">
                    <Mail size={20} className="text-[#D4A853]" />
                    <div>
                      <p className="font-medium text-sm">Email</p>
                      <a href="mailto:hello@luxestaydine.com" className="text-gray-400 text-sm hover:text-[#D4A853]">hello@luxestaydine.com</a>
                    </div>
                  </div>
                </div>
              </div>

              <div className="bg-[#FAFAF8] rounded-2xl p-5 border border-gray-100">
                <h3 className="font-semibold text-[#0F172A] mb-4 flex items-center gap-2">
                  <Clock size={18} className="text-[#D4A853]" /> Working Hours
                </h3>
                <div className="space-y-2 text-sm">
                  {[
                    { label: "Hotel (Reception)", value: "24 × 7" },
                    { label: "Breakfast", value: "7:00 AM – 11:00 AM" },
                    { label: "Lunch", value: "12:00 PM – 3:30 PM" },
                    { label: "Dinner", value: "7:00 PM – 11:30 PM" },
                    { label: "Room Service", value: "24 × 7" },
                  ].map((h) => (
                    <div key={h.label} className="flex justify-between">
                      <span className="text-gray-500">{h.label}</span>
                      <span className="font-medium text-[#0F172A]">{h.value}</span>
                    </div>
                  ))}
                </div>
              </div>

              <div className="bg-[#FAFAF8] rounded-2xl p-5 border border-gray-100">
                <h3 className="font-semibold text-[#0F172A] mb-4">Quick Contact</h3>
                <div className="space-y-2">
                  <a href="https://wa.me/919876543210" className="flex items-center gap-2 bg-green-500 text-white rounded-xl p-3 text-sm font-medium hover:bg-green-600 transition-colors">
                    <MessageCircle size={18} /> WhatsApp Us
                  </a>
                  <a href="https://instagram.com" className="flex items-center gap-2 bg-gradient-to-r from-purple-500 to-pink-500 text-white rounded-xl p-3 text-sm font-medium hover:opacity-90 transition-opacity">
                    <Share2 size={18} /> @luxestaydine
                  </a>
                  <a href="https://facebook.com" className="flex items-center gap-2 bg-blue-600 text-white rounded-xl p-3 text-sm font-medium hover:bg-blue-700 transition-colors">
                    <Globe size={18} /> LuxeStay & Dine
                  </a>
                </div>
              </div>
            </div>

            {/* Contact Form */}
            <div className="lg:col-span-2">
              {sent ? (
                <div className="bg-white rounded-2xl shadow-sm border border-gray-100 p-10 text-center h-full flex flex-col items-center justify-center">
                  <div className="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <CheckCircle size={40} className="text-green-500" />
                  </div>
                  <h2 className="font-playfair text-2xl text-[#0F172A] mb-2">Message Sent!</h2>
                  <p className="text-gray-500 mb-5">Thank you for reaching out. Our team will get back to you within 24 hours.</p>
                  <button onClick={() => setSent(false)} className="btn-outline-gold">Send Another Message</button>
                </div>
              ) : (
                <div className="bg-white rounded-2xl shadow-sm border border-gray-100 p-7">
                  <h2 className="font-playfair text-2xl text-[#0F172A] mb-6">Send a Message</h2>
                  <form onSubmit={handleSubmit} className="space-y-4">
                    <div className="grid grid-cols-2 gap-4">
                      <div>
                        <label className="text-xs text-gray-500 mb-1 block">Full Name *</label>
                        <input name="name" required value={form.name} onChange={handleChange} placeholder="Your name" className="input-field" />
                      </div>
                      <div>
                        <label className="text-xs text-gray-500 mb-1 block">Email *</label>
                        <input name="email" type="email" required value={form.email} onChange={handleChange} placeholder="your@email.com" className="input-field" />
                      </div>
                      <div>
                        <label className="text-xs text-gray-500 mb-1 block">Phone</label>
                        <input name="phone" type="tel" value={form.phone} onChange={handleChange} placeholder="+91 98765 43210" className="input-field" />
                      </div>
                      <div>
                        <label className="text-xs text-gray-500 mb-1 block">Subject *</label>
                        <select name="subject" required value={form.subject} onChange={handleChange} className="input-field">
                          <option value="">Select topic</option>
                          <option value="room-booking">Room Booking</option>
                          <option value="restaurant">Restaurant Reservation</option>
                          <option value="event">Event Planning</option>
                          <option value="feedback">Feedback</option>
                          <option value="other">Other</option>
                        </select>
                      </div>
                    </div>
                    <div>
                      <label className="text-xs text-gray-500 mb-1 block">Message *</label>
                      <textarea name="message" required value={form.message} onChange={handleChange} rows={5} placeholder="Write your message here..." className="input-field resize-none" />
                    </div>
                    <button type="submit" className="btn-gold w-full justify-center">
                      <Send size={17} /> Send Message
                    </button>
                  </form>
                </div>
              )}
            </div>
          </div>

          {/* Map placeholder */}
          <div className="mt-12 rounded-2xl overflow-hidden border border-gray-200 h-64 bg-[#FAFAF8] flex items-center justify-center relative">
            <Image src="https://images.unsplash.com/photo-1524661135-423995f22d0b?w=1400&q=80" alt="Map" fill className="object-cover opacity-40" />
            <div className="relative z-10 text-center">
              <MapPin size={40} className="text-[#D4A853] mx-auto mb-2" />
              <p className="font-semibold text-[#0F172A]">12 Luxury Avenue, Bandra West, Mumbai</p>
              <a
                href="https://maps.google.com"
                target="_blank"
                rel="noopener noreferrer"
                className="btn-gold mt-3 inline-flex"
              >
                Open in Google Maps
              </a>
            </div>
          </div>
        </div>
      </main>
      <Footer />
    </>
  );
}
