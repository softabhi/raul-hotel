import Image from "next/image";
import Link from "next/link";
import Navbar from "@/components/layout/Navbar";
import Footer from "@/components/layout/Footer";
import { Award, Heart, Leaf, Users, ChevronRight } from "lucide-react";

export const metadata = {
  title: "About Us | LuxeStay & Dine",
  description:
    "Learn about LuxeStay & Dine's 15-year journey of hospitality excellence and culinary mastery.",
};

const team = [
  {
    name: "Raj Malhotra",
    role: "General Manager",
    avatar:
      "https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=300&q=80",
    exp: "20 years experience",
  },
  {
    name: "Chef Ayesha Khan",
    role: "Executive Chef",
    avatar:
      "https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=300&q=80",
    exp: "Award-winning chef",
  },
  {
    name: "Vivek Sharma",
    role: "Head of Hospitality",
    avatar:
      "https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=300&q=80",
    exp: "15 years experience",
  },
  {
    name: "Priya Iyer",
    role: "Restaurant Manager",
    avatar:
      "https://images.unsplash.com/photo-1494790108755-2616b612b786?w=300&q=80",
    exp: "12 years experience",
  },
];

const timeline = [
  {
    title: "Grand Opening",
    desc: "Our journey begins with a commitment to delivering exceptional hospitality and memorable guest experiences.",
  },
  {
    title: "Luxury Rooms",
    desc: "Beautifully designed accommodations offering modern comfort and premium amenities.",
  },
  {
    title: "Exceptional Service",
    desc: "Our dedicated team is committed to providing personalized service around the clock.",
  },
  {
    title: "Premium Amenities",
    desc: "Enjoy fine dining, elegant spaces, and facilities designed for comfort and relaxation.",
  },
  {
    title: "Guest Satisfaction",
    desc: "Every stay is an opportunity to create lasting memories and exceed expectations.",
  },
  {
    title: "Looking Ahead",
    desc: "We strive to grow into a trusted destination known for luxury, comfort, and world-class hospitality.",
  },
];


export default function AboutPage() {
  return (
    <>
      <Navbar />
      <main>
        {/* Hero */}
        <div className="relative h-72 md:h-96">
          <Image
            src="https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?w=1920&q=85"
            alt="About LuxeStay"
            fill
            className="object-cover"
            priority
          />
          <div className="absolute inset-0 bg-[#0F172A]/75" />
          <div className="absolute inset-0 flex items-center justify-center text-center pt-16 pb-6">
            <div>
              <span className="section-label">Our Story</span>
              <h1 className="font-playfair text-5xl text-white mt-2">
                About <span className="gold-text">LuxeStay & Dine</span>
              </h1>
            </div>
          </div>
        </div>

        {/* Story */}
        <section className="py-20 bg-white">
          <div className="max-w-7xl mx-auto px-6 lg:px-10">
            <div className="grid grid-cols-1 md:grid-cols-2 gap-14 items-center">
              <div>
                <span className="section-label">Who We Are</span>
                <h2 className="font-playfair text-4xl text-[#0F172A] mt-2 mb-6">
                  A New Era of <span className="gold-text">Hospitality</span>
                </h2>
                <p className="text-gray-600 leading-relaxed mb-4">
                  Welcome to Dona Paula, Goa, where lush greenery meets the vast
                  Arabian Sea. I am the General Manager of Raul's Boutique
                  Hotel. We offer a serene, intimate escape designed around
                  absolute privacy, because we believe you should be treated
                  like a king
                </p>
                <p className="text-gray-600 leading-relaxed mb-6">
                  Experience our exclusive private yacht cruises and
                  personalized service right at your fingertips. Plus, get
                  ready—our tailor-made corporate weekend packages are coming
                  very soon Come for a stay, leave with a story. Call us today
                  at 8830208310 to book your unforgettable Goan getaway
                </p>
                <div className="grid grid-cols-2 gap-4">
                  {[
                    {
                      icon: Award,
                      title: "5+ Awards",
                      desc: "National & international recognition",
                    },
                    {
                      icon: Heart,
                      title: " Guests",
                      desc: "Served with love and care",
                    },
                    {
                      icon: Leaf,
                      title: "Sustainable",
                      desc: "Eco-conscious practices",
                    },
                    {
                      icon: Users,
                      title: "20+ Staff",
                      desc: "Dedicated professionals",
                    },
                  ].map(({ icon: Icon, title, desc }) => (
                    <div
                      key={title}
                      className="bg-[#FAFAF8] rounded-xl p-4 border border-gray-100"
                    >
                      <Icon size={20} className="text-[#D4A853] mb-2" />
                      <p className="font-semibold text-sm text-[#0F172A]">
                        {title}
                      </p>
                      <p className="text-xs text-gray-400">{desc}</p>
                    </div>
                  ))}
                </div>
              </div>
              <div className="grid grid-cols-2 gap-4">
                <Image
                  src="https://images.unsplash.com/photo-1618773928121-c32242e63f39?w=600&q=80"
                  alt="Hotel Room"
                  width={300}
                  height={400}
                  className="rounded-2xl w-full h-64 object-cover"
                />
                <Image
                  src="https://images.unsplash.com/photo-1414235077428-338989a2e8c0?w=600&q=80"
                  alt="Restaurant"
                  width={300}
                  height={400}
                  className="rounded-2xl w-full h-64 object-cover mt-10"
                />
              </div>
            </div>
          </div>
        </section>

        {/* Values */}
        <section className="py-16 bg-[#0F172A]">
          <div className="max-w-7xl mx-auto px-6 lg:px-10 text-center">
            <h2 className="font-playfair text-4xl text-white mb-12">
              Our <span className="gold-text">Core Values</span>
            </h2>
            <div className="grid grid-cols-1 md:grid-cols-3 gap-7">
              {[
                {
                  emoji: "✨",
                  title: "Excellence",
                  desc: "We never settle for good when we can achieve extraordinary. Every touchpoint is an opportunity to exceed expectations.",
                },
                {
                  emoji: "🤝",
                  title: "Authenticity",
                  desc: "We serve with genuine warmth. Our hospitality comes from the heart, not a manual.",
                },
                {
                  emoji: "🌱",
                  title: "Sustainability",
                  desc: "We are committed to responsible tourism — minimizing our footprint while maximizing your experience.",
                },
              ].map((v) => (
                <div
                  key={v.title}
                  className="bg-white/5 border border-white/10 rounded-2xl p-7 hover:border-[#D4A853]/30 transition-colors"
                >
                  <div className="text-4xl mb-4">{v.emoji}</div>
                  <h3 className="font-playfair text-xl text-white mb-3">
                    {v.title}
                  </h3>
                  <p className="text-gray-400 text-sm leading-relaxed">
                    {v.desc}
                  </p>
                </div>
              ))}
            </div>
          </div>
        </section>

        {/* Timeline */}
        <section className="py-20 bg-[#FAFAF8]">
          <div className="max-w-4xl mx-auto px-6">
            <div className="text-center mb-14">
              <span className="section-label">Our Journey</span>
              <h2 className="font-playfair text-4xl text-[#0F172A] mt-2">
                The LuxeStay <span className="gold-text">Timeline</span>
              </h2>
            </div>
            <div className="relative">
              <div className="absolute left-8 top-0 bottom-0 w-0.5 bg-[#D4A853]/30" />
              <div className="space-y-10">
                {timeline.map((t, i) => (
                  <div key={t.year} className="flex gap-6 items-start">
                    <div className="relative">
                      <div className="w-16 h-16 rounded-full bg-[#D4A853] flex items-center justify-center text-white font-bold text-sm shrink-0 z-10 relative">
                        {t.year}
                      </div>
                    </div>
                    <div className="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm flex-1">
                      <h3 className="font-semibold text-[#0F172A] mb-1">
                        {t.title}
                      </h3>
                      <p className="text-gray-500 text-sm">{t.desc}</p>
                    </div>
                  </div>
                ))}
              </div>
            </div>
          </div>
        </section>

        {/* Team */}
        <section className="py-20 bg-white">
          <div className="max-w-7xl mx-auto px-6 lg:px-10">
            <div className="text-center mb-14">
              <span className="section-label">Our People</span>
              <h2 className="font-playfair text-4xl text-[#0F172A] mt-2">
                Meet the <span className="gold-text">Team</span>
              </h2>
            </div>
            <div className="grid grid-cols-2 md:grid-cols-4 gap-7">
              {team.map((m) => (
                <div key={m.name} className="text-center group">
                  <div className="relative w-32 h-32 mx-auto rounded-full overflow-hidden mb-4 border-4 border-[#D4A853]/30 group-hover:border-[#D4A853] transition-colors">
                    <Image
                      src={m.avatar}
                      alt={m.name}
                      fill
                      className="object-cover"
                    />
                  </div>
                  <h3 className="font-semibold text-[#0F172A]">{m.name}</h3>
                  <p className="text-[#D4A853] text-sm">{m.role}</p>
                  <p className="text-gray-400 text-xs mt-1">{m.exp}</p>
                </div>
              ))}
            </div>
          </div>
        </section>

        {/* CTA */}
        <div className="bg-gradient-to-r from-[#D4A853] to-[#B8923A] py-14 text-center">
          <h2 className="font-playfair text-4xl text-white mb-4">
            Ready to Experience Luxury?
          </h2>
          <p className="text-white/80 mb-7">
            Book your stay or reserve a table today.
          </p>
          <div className="flex gap-4 justify-center flex-wrap">
            <Link
              href="/booking"
              className="bg-white text-[#D4A853] py-3 px-7 rounded-xl font-semibold hover:bg-gray-50 transition-colors"
            >
              Book a Room
            </Link>
            <Link
              href="/restaurant"
              className="bg-[#0F172A] text-white py-3 px-7 rounded-xl font-semibold hover:bg-[#1E293B] transition-colors"
            >
              View Menu
            </Link>
          </div>
        </div>
      </main>
      <Footer />
    </>
  );
}
