"use client";
import { useState, useEffect } from "react";
import Link from "next/link";
import { usePathname } from "next/navigation";
import {
  Hotel,
  UtensilsCrossed,
  Menu,
  X,
  Phone,
  ChevronDown,
  Star,
} from "lucide-react";

const navLinks = [
  { label: "Home", href: "/" },
  {
    label: "Hotel",
    href: "/hotel",
    sub: [
      { label: "All Rooms", href: "/hotel" },
      { label: "Room Booking", href: "/booking" },
      { label: "Gallery", href: "/gallery" },
    ],
  },
  {
    label: "Restaurant",
    href: "/restaurant",
    sub: [
      { label: "Our Menu", href: "/restaurant" },
      { label: "Place Order", href: "/order" },
    ],
  },
  { label: "About", href: "/about" },
  { label: "Contact", href: "/contact" },
];

export default function Navbar() {
  const [scrolled, setScrolled] = useState(false);
  const [mobileOpen, setMobileOpen] = useState(false);
  const [openDropdown, setOpenDropdown] = useState(null);
  const pathname = usePathname();

  useEffect(() => {
    const handleScroll = () => setScrolled(window.scrollY > 50);
    window.addEventListener("scroll", handleScroll);
    return () => window.removeEventListener("scroll", handleScroll);
  }, []);

  const isHome = pathname === "/";

  return (
    <>
      <div className="bg-[#0F172A] text-xs text-gray-400 py-1.5 hidden md:block">
        <div className="max-w-7xl mx-auto px-6 lg:px-10 flex justify-between items-center">
          <span className="flex items-center gap-1">
            <Star size={11} className="text-yellow-400 fill-yellow-400" />
            <Star size={11} className="text-yellow-400 fill-yellow-400" />
            <Star size={11} className="text-yellow-400 fill-yellow-400" />
            <Star size={11} className="text-yellow-400 fill-yellow-400" />
            <Star size={11} className="text-yellow-400 fill-yellow-400" />
            &nbsp; 5-Star Luxury Hotel & Restaurant
          </span>
          <span className="flex items-center gap-4">
            <span className="flex items-center gap-1">
              <Phone size={11} /> +91 98765 43210
            </span>
            <span>Mon–Sun 24/7</span>
          </span>
        </div>
      </div>

      <nav
        className={`fixed top-0 left-0 right-0 z-50 transition-all duration-500 ${scrolled || !isHome
          ? "bg-[#0F172A]/95 backdrop-blur-xl shadow-2xl py-3 top-0"
          : "bg-transparent py-5 top-7"
          }`}
      >
        <div className="max-w-7xl mx-auto px-6 lg:px-10 flex items-center justify-between">
          {/* Logo */}
          <Link href="/" className="flex items-center gap-2 group">
            <div className="flex items-center gap-1">
              <Hotel size={22} className="text-[#D4A853]" />
              <UtensilsCrossed size={18} className="text-[#D4A853]" />
            </div>
            <div>
              <span className="font-playfair text-xl font-700 text-white tracking-wide">
                Raul’s Boutique <span className="text-[#D4A853]">Hotel</span>
              </span>
              <span className="text-[#D4A853] font-playfair text-xl"> & Dine</span>
            </div>
          </Link>

          {/* Desktop Nav */}
          <div className="hidden lg:flex items-center gap-1">
            {navLinks.map((link) => (
              <div
                key={link.href}
                className="relative"
                onMouseEnter={() => link.sub && setOpenDropdown(link.label)}
                onMouseLeave={() => setOpenDropdown(null)}
              >
                <Link
                  href={link.href}
                  className={`flex items-center gap-1 px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 ${pathname === link.href || pathname.startsWith(link.href + "/")
                    ? "text-[#D4A853]"
                    : "text-gray-300 hover:text-white"
                    }`}
                >
                  {link.label}
                  {link.sub && <ChevronDown size={14} className={`transition-transform ${openDropdown === link.label ? "rotate-180" : ""}`} />}
                </Link>

                {link.sub && openDropdown === link.label && (
                  <div className="absolute top-full left-0 mt-2 w-48 bg-[#1E293B] border border-[#D4A853]/20 rounded-xl shadow-2xl overflow-hidden">
                    {link.sub.map((s) => (
                      <Link
                        key={s.href}
                        href={s.href}
                        className="block px-4 py-2.5 text-sm text-gray-300 hover:text-[#D4A853] hover:bg-[#D4A853]/10 transition-all"
                      >
                        {s.label}
                      </Link>
                    ))}
                  </div>
                )}
              </div>
            ))}
          </div>

          {/* CTA Buttons */}
          <div className="hidden lg:flex items-center gap-3">
            <Link href="/restaurant" className="btn-outline-gold !py-2 !px-4 !text-sm">
              <UtensilsCrossed size={15} /> Order Food
            </Link>
            <Link href="/booking" className="btn-gold !py-2 !px-4 !text-sm">
              <Hotel size={15} /> Book Room
            </Link>
          </div>

          {/* Mobile toggle */}
          <button
            className="lg:hidden text-white p-2"
            onClick={() => setMobileOpen(!mobileOpen)}
            aria-label="Toggle menu"
          >
            {mobileOpen ? <X size={24} /> : <Menu size={24} />}
          </button>
        </div>

        {/* Mobile menu */}
        {mobileOpen && (
          <div className="lg:hidden bg-[#0F172A]/98 backdrop-blur-xl border-t border-[#D4A853]/20 mt-2">
            <div className="px-6 py-4 space-y-1">
              {navLinks.map((link) => (
                <div key={link.href}>
                  <Link
                    href={link.href}
                    onClick={() => setMobileOpen(false)}
                    className={`block px-4 py-3 rounded-lg text-sm font-medium ${pathname === link.href ? "text-[#D4A853] bg-[#D4A853]/10" : "text-gray-300"
                      }`}
                  >
                    {link.label}
                  </Link>
                  {link.sub && (
                    <div className="pl-6 space-y-1">
                      {link.sub.map((s) => (
                        <Link
                          key={s.href}
                          href={s.href}
                          onClick={() => setMobileOpen(false)}
                          className="block px-4 py-2 text-xs text-gray-400 hover:text-[#D4A853]"
                        >
                          → {s.label}
                        </Link>
                      ))}
                    </div>
                  )}
                </div>
              ))}
              <div className="pt-4 flex flex-col gap-3">
                <Link href="/restaurant" onClick={() => setMobileOpen(false)} className="btn-outline-gold justify-center">
                  <UtensilsCrossed size={15} /> Order Food
                </Link>
                <Link href="/booking" onClick={() => setMobileOpen(false)} className="btn-gold justify-center">
                  <Hotel size={15} /> Book Room
                </Link>
              </div>
            </div>
          </div>
        )}
      </nav>
    </>
  );
}
