"use client";
import Link from "next/link";
import ImageSlider from "@/components/ui/ImageSlider";
import StarRating from "@/components/ui/StarRating";
import { Users, Maximize, BedDouble, MapPin, Wifi, CheckCircle } from "lucide-react";

export default function RoomCard({ room }) {
  const discount = Math.round(((room.originalPrice - room.price) / room.originalPrice) * 100);

  return (
    <div className="card-hover bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 flex flex-col">
      {/* Image Slider */}
      <div className="relative">
        <ImageSlider images={room.images} alt={room.name} height={240} />
        {/* Badges */}
        <div className="absolute top-3 left-3 flex gap-2 z-10">
          <span className="badge-navy">{room.category}</span>
          {discount > 0 && <span className="badge-gold">{discount}% OFF</span>}
          {!room.available && <span className="bg-red-100 text-red-700 text-xs font-semibold px-2 py-0.5 rounded-full">Sold Out</span>}
        </div>
      </div>

      {/* Content */}
      <div className="p-5 flex flex-col flex-1">
        <div className="flex items-start justify-between gap-2 mb-2">
          <h3 className="font-playfair text-lg font-600 text-[#0F172A] leading-tight">{room.name}</h3>
          <StarRating rating={room.rating} count={room.reviewCount} size={12} />
        </div>

        {/* Room Info */}
        <div className="grid grid-cols-2 gap-2 mb-4">
          <div className="flex items-center gap-1.5 text-xs text-gray-500">
            <Users size={13} className="text-[#D4A853]" />
            <span>{room.capacity} Guests</span>
          </div>
          <div className="flex items-center gap-1.5 text-xs text-gray-500">
            <Maximize size={13} className="text-[#D4A853]" />
            <span>{room.size}</span>
          </div>
          <div className="flex items-center gap-1.5 text-xs text-gray-500">
            <BedDouble size={13} className="text-[#D4A853]" />
            <span>{room.bed}</span>
          </div>
          <div className="flex items-center gap-1.5 text-xs text-gray-500">
            <MapPin size={13} className="text-[#D4A853]" />
            <span>{room.view}</span>
          </div>
        </div>

        {/* Amenities */}
        <div className="flex flex-wrap gap-1.5 mb-4">
          {room.amenities.slice(0, 4).map((a) => (
            <span key={a} className="flex items-center gap-1 text-xs bg-gray-50 text-gray-600 px-2 py-1 rounded-lg border border-gray-100">
              {a === "Free WiFi" && <Wifi size={10} className="text-[#D4A853]" />}
              {a}
            </span>
          ))}
          {room.amenities.length > 4 && (
            <span className="text-xs bg-gray-50 text-gray-500 px-2 py-1 rounded-lg border border-gray-100">
              +{room.amenities.length - 4} more
            </span>
          )}
        </div>

        {/* Price & CTA */}
        <div className="mt-auto flex items-center justify-between pt-4 border-t border-gray-100">
          <div>
            <div className="flex items-baseline gap-1.5">
              <span className="text-2xl font-bold text-[#0F172A]">₹{room.price.toLocaleString()}</span>
              <span className="text-xs text-gray-400 line-through">₹{room.originalPrice.toLocaleString()}</span>
            </div>
            <p className="text-xs text-gray-400">per night + taxes</p>
          </div>
          <div className="flex gap-2">
            <Link href={`/hotel/${room.id}`} className="btn-outline-gold !py-2 !px-3 !text-xs">
              Details
            </Link>
            <Link
              href={room.available ? `/booking?room=${room.id}` : "#"}
              className={room.available ? "btn-gold !py-2 !px-3 !text-xs" : "bg-gray-200 text-gray-400 py-2 px-3 rounded-lg text-xs cursor-not-allowed"}
            >
              {room.available ? "Book Now" : "Unavailable"}
            </Link>
          </div>
        </div>
      </div>
    </div>
  );
}
