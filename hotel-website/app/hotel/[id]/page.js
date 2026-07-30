"use client";
import { useState, useEffect } from "react";
import { useParams } from "next/navigation";
import Image from "next/image";
import Link from "next/link";
import { fetchRooms, fetchRoomById } from "@/data/api";
import Navbar from "@/components/layout/Navbar";
import Footer from "@/components/layout/Footer";
import StarRating from "@/components/ui/StarRating";
import BookingForm from "@/components/hotel/BookingForm";
import RoomCard from "@/components/hotel/RoomCard";
import { Users, Maximize, BedDouble, MapPin, CheckCircle, Wifi, ImageOff } from "lucide-react";

export default function RoomDetailPage() {
  const params = useParams();
  const roomId = params?.id;

  const [room, setRoom] = useState(null);
  const [similar, setSimilar] = useState([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    if (!roomId) return;
    let isMounted = true;
    setLoading(true);
    fetchRoomById(roomId).then((data) => {
      if (!isMounted) return;
      setRoom(data);
      if (data) {
        fetchRooms().then((allRooms) => {
          if (!isMounted) return;
          const sim = allRooms
            .filter((r) => r.category === data.category && String(r.id) !== String(data.id))
            .slice(0, 3);
          setSimilar(sim);
        });
      }
      setLoading(false);
    });
    return () => {
      isMounted = false;
    };
  }, [roomId]);


  if (loading) {
    return (
      <>
        <Navbar />
        <main className="pt-24 min-h-[60vh] flex items-center justify-center">
          <div className="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-[#D4A853]"></div>
        </main>
        <Footer />
      </>
    );
  }

  if (!room) {
    return (
      <>
        <Navbar />
        <main className="pt-24 min-h-[60vh] flex flex-col items-center justify-center gap-4">
          <h1 className="text-2xl font-bold text-gray-700">Room Not Found</h1>
          <Link href="/hotel" className="btn-gold">Back to Rooms</Link>
        </main>
        <Footer />
      </>
    );
  }

  // Only use actual uploaded images — no hardcoded fallbacks
  const images = (room.images && room.images.length > 0) 
    ? room.images.map(url => typeof url === "string" ? url.split('?')[0] : url) 
    : [];
  const hasImages = images.length > 0;

  // Guard against missing/zero originalPrice
  const discount =
    room.originalPrice && room.originalPrice > room.price
      ? Math.round(((room.originalPrice - room.price) / room.originalPrice) * 100)
      : 0;

  // Ensure arrays are safe to map
  const highlights = room.highlights ?? [];
  const amenities = room.amenities ?? [];

  return (
    <>
      <Navbar />
      <main className="pt-24">
        {/* Breadcrumb */}
        <div className="max-w-7xl mx-auto px-6 lg:px-10 mb-6">
          <div className="flex items-center gap-2 text-sm text-gray-500">
            <Link href="/" className="hover:text-[#D4A853]">Home</Link>
            <span>/</span>
            <Link href="/hotel" className="hover:text-[#D4A853]">Hotel</Link>
            <span>/</span>
            <span className="text-[#0F172A]">{room.name}</span>
          </div>
        </div>

        <div className="max-w-7xl mx-auto px-6 lg:px-10 pb-16">
          <div className="grid grid-cols-1 lg:grid-cols-3 gap-10">
            {/* Left: Details */}
            <div className="lg:col-span-2">
              {/* Image Gallery */}
              <div className="grid grid-cols-2 gap-3 mb-8">
                {/* Main hero image or no-image placeholder */}
                <div className="col-span-2 relative h-72 md:h-96 rounded-2xl overflow-hidden">
                  {hasImages ? (
                    <Image src={images[0]} alt={room.name} fill className="object-cover" priority unoptimized />
                  ) : (
                    <div className="w-full h-full bg-gradient-to-br from-gray-100 to-gray-200 flex flex-col items-center justify-center gap-3">
                      <ImageOff size={48} className="text-gray-300" />
                      <p className="text-gray-400 text-sm font-medium">No Image Available</p>
                    </div>
                  )}
                  <span className="absolute top-4 left-4 badge-navy">{room.category}</span>
                  {!room.available && (
                    <div className="absolute inset-0 bg-black/50 flex items-center justify-center">
                      <span className="text-white font-bold text-xl bg-red-600 px-6 py-3 rounded-xl">Currently Unavailable</span>
                    </div>
                  )}
                </div>
                {/* Thumbnails — only if more than 1 image */}
                {images.slice(1, 4).map((img, i) => (
                  <div key={i} className="relative h-36 md:h-48 rounded-xl overflow-hidden">
                    <Image src={img} alt={`${room.name} view ${i + 2}`} fill className="object-cover hover:scale-105 transition-transform duration-300" unoptimized />
                  </div>
                ))}
              </div>

              {/* Room Info */}
              <div className="mb-8">
                <div className="flex items-start justify-between flex-wrap gap-3 mb-4">
                  <div>
                    <h1 className="font-playfair text-3xl md:text-4xl text-[#0F172A]">{room.name}</h1>
                    <p className="text-gray-500 mt-1">{room.floor} · {room.view}</p>
                  </div>
                  <StarRating rating={room.rating} count={room.reviewCount} size={16} />
                </div>

                {/* Quick specs */}
                <div className="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                  {[
                    { icon: Users, label: "Capacity", value: `${room.capacity} Guests` },
                    { icon: Maximize, label: "Room Size", value: room.size },
                    { icon: BedDouble, label: "Bed Type", value: room.bed },
                    { icon: MapPin, label: "View", value: room.view },
                  ].map(({ icon: Icon, label, value }) => (
                    <div key={label} className="bg-[#FAFAF8] rounded-xl p-4 border border-gray-100">
                      <Icon size={18} className="text-[#D4A853] mb-1" />
                      <p className="text-xs text-gray-400">{label}</p>
                      <p className="text-sm font-semibold text-[#0F172A]">{value}</p>
                    </div>
                  ))}
                </div>

                <p className="text-gray-600 leading-relaxed mb-6">{room.description}</p>

                {/* Highlights */}
                {highlights.length > 0 && (
                  <div className="bg-[#D4A853]/5 border border-[#D4A853]/20 rounded-2xl p-5 mb-6">
                    <h3 className="font-semibold text-[#0F172A] mb-3">Room Highlights</h3>
                    <div className="grid grid-cols-1 md:grid-cols-2 gap-2">
                      {highlights.map((h) => (
                        <div key={h} className="flex items-center gap-2 text-sm text-gray-700">
                          <CheckCircle size={16} className="text-[#D4A853] shrink-0" />
                          {h}
                        </div>
                      ))}
                    </div>
                  </div>
                )}

                {/* All Amenities */}
                {/* {amenities.length > 0 && (
                  <div>
                    <h3 className="font-semibold text-[#0F172A] mb-4">All Amenities</h3>
                    <div className="flex flex-wrap gap-2">
                      {amenities.map((a) => (
                        <span key={a} className="flex items-center gap-1.5 text-sm bg-white border border-gray-200 text-gray-700 px-3 py-1.5 rounded-lg">
                          {a === "Free WiFi" && <Wifi size={13} className="text-[#D4A853]" />}
                          <CheckCircle size={13} className="text-green-500" />
                          {a}
                        </span>
                      ))}
                    </div>
                  </div>
                )} */}
              </div>
            </div>

            {/* Right: Booking Form */}
            <div className="lg:col-span-1">
              <div className="sticky top-28">
                {/* Price card */}
                {/* <div className="bg-white rounded-2xl border border-gray-200 shadow-xl overflow-hidden mb-5">
                  <div className="bg-[#0F172A] p-5">
                    <div className="flex items-baseline gap-2">
                      <span className="text-3xl font-bold text-white">₹{room.price?.toLocaleString()}</span>
                      {room.originalPrice > room.price && (
                        <span className="text-sm text-gray-400 line-through">₹{room.originalPrice.toLocaleString()}</span>
                      )}
                      {discount > 0 && <span className="badge-gold">{discount}% OFF</span>}
                    </div>
                    <p className="text-gray-400 text-xs mt-1">per night + 5% GST</p>
                  </div>
                  <div className="p-5">
                    <BookingForm room={room} />
                  </div>
                </div> */}

                {/* Need help */}
                <div className="bg-[#FAFAF8] rounded-2xl p-5 border border-gray-100 text-center">
                  <p className="text-sm text-gray-600 mb-3">Need help or have questions?</p>
                  <a href="tel:+918830208310" className="btn-outline-gold w-full justify-center !py-2.5">
                    📞 Call Us: +91 8830208310
                  </a>
                </div>
              </div>
            </div>
          </div>

          {/* Similar Rooms */}
          {similar.length > 0 && (
            <div className="mt-16">
              <h2 className="font-playfair text-3xl text-[#0F172A] mb-8">Similar Rooms</h2>
              <div className="grid grid-cols-1 md:grid-cols-3 gap-7">
                {similar.map((r) => <RoomCard key={r.id} room={r} />)}
              </div>
            </div>
          )}
        </div>
      </main>
      <Footer />
    </>
  );
}
