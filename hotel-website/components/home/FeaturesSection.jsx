import { Wifi, Utensils, Car, Dumbbell, Waves, Shield, Clock, Coffee, Airplay } from "lucide-react";

const features = [
  { icon: Wifi, title: "Free High-Speed WiFi", desc: "Blazing fast 1Gbps internet throughout the property" },
  { icon: Utensils, title: "Fine Dining", desc: "Award-winning restaurant open 7 days a week" },
  { icon: Car, title: "Valet Parking", desc: "Complimentary valet service for all guests" },
  { icon: Airplay, title: "App Service", desc: "Guest convinience service app" },
  { icon: Waves, title: "Infinity Pool", desc: "Rooftop pool with panoramic city views" },
  { icon: Shield, title: "24/7 Security", desc: "Round-the-clock security for your peace of mind" },
  { icon: Clock, title: "24/7 Room Service", desc: "In-room dining available around the clock" },
  { icon: Coffee, title: "Cafe & Refreshments", desc: "Tea, Coffee, Mineral Water" },
];

export default function FeaturesSection() {
  return (
    <section className="py-20 bg-[#0F172A]">
      <div className="max-w-7xl mx-auto px-6 lg:px-10">
        {/* Header */}
        <div className="text-center mb-14">
          <span className="section-label">World-Class Amenities</span>
          <h2 className="font-playfair text-4xl md:text-5xl text-white mt-2 mb-4">
            Everything You <span className="gold-text">Deserve</span>
          </h2>
          <div className="gold-divider"></div>
          <p className="text-gray-400 max-w-xl mx-auto mt-4">
            From the moment you arrive until the moment you leave, every amenity has been thoughtfully designed for your comfort.
          </p>
        </div>

        {/* Features grid */}
        <div className="grid grid-cols-2 md:grid-cols-4 gap-5">
          {features.map((f) => (
            <div
              key={f.title}
              className="group p-6 rounded-2xl bg-white/5 border border-white/10 hover:bg-[#D4A853]/10 hover:border-[#D4A853]/30 transition-all duration-300 cursor-default"
            >
              <div className="w-12 h-12 rounded-xl bg-[#D4A853]/10 flex items-center justify-center mb-4 group-hover:bg-[#D4A853]/20 transition-colors">
                <f.icon size={22} className="text-[#D4A853]" />
              </div>
              <h3 className="text-white font-semibold text-sm mb-2">{f.title}</h3>
              <p className="text-gray-400 text-xs leading-relaxed">{f.desc}</p>
            </div>
          ))}
        </div>
      </div>
    </section>
  );
}
