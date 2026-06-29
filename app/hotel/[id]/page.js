import { notFound } from "next/navigation";
import Image from "next/image";
import Link from "next/link";
import { getRoomById, rooms } from "@/data/rooms";
import Navbar from "@/components/layout/Navbar";
import Footer from "@/components/layout/Footer";
import StarRating from "@/components/ui/StarRating";
import BookingForm from "@/components/hotel/BookingForm";
import RoomCard from "@/components/hotel/RoomCard";
import { Users, Maximize, BedDouble, MapPin, CheckCircle, ArrowLeft, Wifi } from "lucide-react";

export async function generateStaticParams() {
  return rooms.map((r) => ({ id: String(r.id) }));
}

export async function generateMetadata({ params }) {
  const room = getRoomById(params.id);
  if (!room) return { title: "Room Not Found" };
  return {
    title: `${room.name} | LuxeStay Hotel`,
    description: room.description,
  };
}

export default async function RoomDetailPage({ params }) {
  const room = getRoomById(params.id);
  if (!room) notFound();

  const similar = rooms.filter((r) => r.category === room.category && r.id !== room.id).slice(0, 3);
  const discount = Math.round(((room.originalPrice - room.price) / room.originalPrice) * 100);

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
                <div className="col-span-2 relative h-72 md:h-96 rounded-2xl overflow-hidden">
                  <Image src={room.images[0]} alt={room.name} fill className="object-cover" priority />
                  <span className="absolute top-4 left-4 badge-navy">{room.category}</span>
                  {!room.available && (
                    <div className="absolute inset-0 bg-black/50 flex items-center justify-center">
                      <span className="text-white font-bold text-xl bg-red-600 px-6 py-3 rounded-xl">Currently Unavailable</span>
                    </div>
                  )}
                </div>
                {room.images.slice(1, 4).map((img, i) => (
                  <div key={i} className="relative h-36 md:h-48 rounded-xl overflow-hidden">
                    <Image src={img} alt={`${room.name} view ${i + 2}`} fill className="object-cover hover:scale-105 transition-transform duration-300" />
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
                <div className="bg-[#D4A853]/5 border border-[#D4A853]/20 rounded-2xl p-5 mb-6">
                  <h3 className="font-semibold text-[#0F172A] mb-3">Room Highlights</h3>
                  <div className="grid grid-cols-1 md:grid-cols-2 gap-2">
                    {room.highlights.map((h) => (
                      <div key={h} className="flex items-center gap-2 text-sm text-gray-700">
                        <CheckCircle size={16} className="text-[#D4A853] shrink-0" />
                        {h}
                      </div>
                    ))}
                  </div>
                </div>

                {/* All Amenities */}
                <div>
                  <h3 className="font-semibold text-[#0F172A] mb-4">All Amenities</h3>
                  <div className="flex flex-wrap gap-2">
                    {room.amenities.map((a) => (
                      <span key={a} className="flex items-center gap-1.5 text-sm bg-white border border-gray-200 text-gray-700 px-3 py-1.5 rounded-lg">
                        {a === "Free WiFi" && <Wifi size={13} className="text-[#D4A853]" />}
                        <CheckCircle size={13} className="text-green-500" />
                        {a}
                      </span>
                    ))}
                  </div>
                </div>
              </div>
            </div>

            {/* Right: Booking Form */}
            <div className="lg:col-span-1">
              <div className="sticky top-28">
                {/* Price card */}
                <div className="bg-white rounded-2xl border border-gray-200 shadow-xl overflow-hidden mb-5">
                  <div className="bg-[#0F172A] p-5">
                    <div className="flex items-baseline gap-2">
                      <span className="text-3xl font-bold text-white">₹{room.price.toLocaleString()}</span>
                      <span className="text-sm text-gray-400 line-through">₹{room.originalPrice.toLocaleString()}</span>
                      <span className="badge-gold">{discount}% OFF</span>
                    </div>
                    <p className="text-gray-400 text-xs mt-1">per night + 18% GST</p>
                  </div>
                  <div className="p-5">
                    <BookingForm room={room} />
                  </div>
                </div>

                {/* Need help */}
                <div className="bg-[#FAFAF8] rounded-2xl p-5 border border-gray-100 text-center">
                  <p className="text-sm text-gray-600 mb-3">Need help or have questions?</p>
                  <a href="tel:+919876543210" className="btn-outline-gold w-full justify-center !py-2.5">
                    📞 Call Us: +91 98765 43210
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
