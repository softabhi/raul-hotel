import Link from "next/link";
import { rooms } from "@/data/rooms";
import RoomCard from "@/components/hotel/RoomCard";
import { ArrowRight, Hotel } from "lucide-react";

export default function RoomsPreview() {
  const featured = rooms.slice(0, 3);

  return (
    <section className="py-20 bg-[#FAFAF8]">
      <div className="max-w-7xl mx-auto px-6 lg:px-10">
        {/* Header */}
        <div className="flex flex-col md:flex-row items-start md:items-end justify-between gap-6 mb-12">
          <div>
            <span className="section-label flex items-center gap-2">
              <Hotel size={14} /> Our Rooms
            </span>
            <h2 className="font-playfair text-4xl md:text-5xl text-[#0F172A] mt-1">
              Rooms & <span className="gold-text">Suites</span>
            </h2>
            <div className="gold-divider !mx-0 mt-3" />
            <p className="text-gray-500 mt-3 max-w-lg">
              Choose from our carefully curated selection of rooms and suites, each designed to provide the ultimate in comfort and luxury.
            </p>
          </div>
          <Link href="/hotel" className="btn-outline-gold whitespace-nowrap">
            View All Rooms <ArrowRight size={16} />
          </Link>
        </div>

        {/* Room cards */}
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-7">
          {featured.map((room) => (
            <RoomCard key={room.id} room={room} />
          ))}
        </div>

        {/* Stats bar */}
        <div className="mt-14 grid grid-cols-2 md:grid-cols-4 gap-6">
          {[
            { value: "50+", label: "Luxury Rooms" },
            { value: "4", label: "Room Categories" },
            { value: "98%", label: "Guest Satisfaction" },
            { value: "24/7", label: "Concierge Service" },
          ].map((s) => (
            <div key={s.label} className="text-center p-5 bg-white rounded-2xl shadow-sm border border-gray-100">
              <div className="font-playfair text-3xl font-bold gold-text">{s.value}</div>
              <div className="text-gray-500 text-sm mt-1">{s.label}</div>
            </div>
          ))}
        </div>
      </div>
    </section>
  );
}
