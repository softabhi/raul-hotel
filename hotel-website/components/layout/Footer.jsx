import Link from "next/link";
import { Hotel, UtensilsCrossed, Phone, Mail, MapPin, Share2, Globe, Rss, Heart, ArrowRight } from "lucide-react";

export default function Footer() {
  return (
    <footer className="bg-[#0A0F1E] text-gray-400">
      {/* Newsletter */}
      <div className="border-b border-[#D4A853]/20">
        <div className="max-w-7xl mx-auto px-6 lg:px-10 py-10">
          <div className="flex flex-col md:flex-row items-center justify-between gap-6">
            <div>
              <h3 className="font-playfair text-2xl text-white mb-1">
                Stay in the <span className="text-[#D4A853]">Loop</span>
              </h3>
              <p className="text-sm">Subscribe for exclusive offers, dining specials & seasonal packages.</p>
            </div>
            <div className="flex w-full md:w-auto gap-3">
              <input
                type="email"
                placeholder="Your email address"
                className="input-field !bg-[#1E293B] !border-[#D4A853]/30 !text-white placeholder:text-gray-500 flex-1 md:w-72"
              />
              <button className="btn-gold whitespace-nowrap">
                Subscribe <ArrowRight size={15} />
              </button>
            </div>
          </div>
        </div>
      </div>

      {/* Main footer */}
      <div className="max-w-7xl mx-auto px-6 lg:px-10 py-14">
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">
          {/* Brand */}
          <div className="lg:col-span-1">
            <div className="flex items-center gap-2 mb-5">
              <Hotel size={22} className="text-[#D4A853]" />
              <UtensilsCrossed size={18} className="text-[#D4A853]" />
              <span className="font-playfair text-xl text-white">
                Luxe<span className="text-[#D4A853]">Stay</span> & Dine
              </span>
            </div>
            <p className="text-sm leading-relaxed mb-6">
              A sanctuary of luxury nestled in the heart of the city. Experience world-class hospitality, exquisite dining, and timeless elegance.
            </p>
            <div className="flex gap-3">
              {[Share2, Globe, Rss, Heart].map((Icon, i) => (
                <button
                  key={i}
                  className="w-9 h-9 rounded-full bg-[#1E293B] border border-[#D4A853]/20 flex items-center justify-center text-gray-400 hover:text-[#D4A853] hover:border-[#D4A853] transition-all"
                >
                  <Icon size={16} />
                </button>
              ))}
            </div>
          </div>

          {/* Hotel Links */}
          <div>
            <h4 className="text-white font-semibold mb-5 text-sm uppercase tracking-widest flex items-center gap-2">
              <Hotel size={15} className="text-[#D4A853]" /> Hotel
            </h4>
            <ul className="space-y-3 text-sm">
              {[
                { label: "Room Types", href: "/hotel" },
                { label: "Book a Room", href: "/booking" },
                { label: "Standard Rooms", href: "/hotel?cat=Standard" },
                { label: "Deluxe Rooms", href: "/hotel?cat=Deluxe" },
                { label: "Suites", href: "/hotel?cat=Suite" },
                { label: "Photo Gallery", href: "/gallery" },
              ].map((link) => (
                <li key={link.href}>
                  <Link href={link.href} className="hover:text-[#D4A853] transition-colors flex items-center gap-1 group">
                    <ArrowRight size={12} className="opacity-0 group-hover:opacity-100 transition-opacity" />
                    {link.label}
                  </Link>
                </li>
              ))}
            </ul>
          </div>

          {/* Restaurant Links */}
          <div>
            <h4 className="text-white font-semibold mb-5 text-sm uppercase tracking-widest flex items-center gap-2">
              <UtensilsCrossed size={15} className="text-[#D4A853]" /> Restaurant
            </h4>
            <ul className="space-y-3 text-sm">
              {[
                { label: "Full Menu", href: "#" },
                { label: "Order Online", href: "#" },
                { label: "Veg Dishes", href: "#" },
                { label: "Non-Veg Dishes", href: "#" },
                { label: "Desserts", href: "#" },
                { label: "Beverages", href: "#" },
              ].map((link) => (
                <li key={link.href}>
                  <Link href={link.href} className="hover:text-[#D4A853] transition-colors flex items-center gap-1 group">
                    <ArrowRight size={12} className="opacity-0 group-hover:opacity-100 transition-opacity" />
                    {link.label}
                  </Link>
                </li>
              ))}
            </ul>
          </div>

          {/* Contact */}
          <div>
            <h4 className="text-white font-semibold mb-5 text-sm uppercase tracking-widest">Contact</h4>
            <ul className="space-y-4 text-sm">
              <li className="flex items-start gap-3">
                <MapPin size={16} className="text-[#D4A853] mt-0.5 shrink-0" />
                <span>H. No.355, Machado Cove, Lane No.-09, Dona Paula, Pannum, Goa 403004</span>
              </li>
              <li className="flex items-center gap-3">
                <Phone size={16} className="text-[#D4A853] shrink-0" />
                <a href="tel:+919876543210" className="hover:text-[#D4A853] transition-colors">+91 8830208310</a>
              </li>
              <li className="flex items-center gap-3">
                <Mail size={16} className="text-[#D4A853] shrink-0" />
                <a href="mailto:gm@raulsboutiquehotel.com" className="hover:text-[#D4A853] transition-colors">gm@raulsboutiquehotel.com</a>
              </li>
            </ul>
            <div className="mt-6 p-4 bg-[#1E293B] rounded-xl border border-[#D4A853]/20">
              <p className="text-xs text-[#D4A853] font-semibold mb-1">Restaurant Hours</p>
              <p className="text-xs">Breakfast: 7:00 AM – 11:00 AM</p>
              <p className="text-xs">Lunch: 12:00 PM – 3:30 PM</p>
              <p className="text-xs">Dinner: 7:00 PM – 11:30 PM</p>
            </div>
          </div>
        </div>
      </div>

      {/* Bottom bar */}
      <div className="border-t border-[#D4A853]/10">
        <div className="max-w-7xl mx-auto px-6 lg:px-10 py-5 flex flex-col md:flex-row justify-between items-center gap-3 text-xs">
          <p>© 2025 LuxeStay & Dine. All rights reserved.</p>
          <div className="flex gap-5">
            <Link href="/about" className="hover:text-[#D4A853] transition-colors">About Us</Link>
            <Link href="/contact" className="hover:text-[#D4A853] transition-colors">Contact</Link>
            <Link href="#" className="hover:text-[#D4A853] transition-colors">Privacy Policy</Link>
            <Link href="#" className="hover:text-[#D4A853] transition-colors">Terms</Link>
          </div>
        </div>
      </div>
    </footer>
  );
}
