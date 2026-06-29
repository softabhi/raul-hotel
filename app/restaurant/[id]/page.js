import { notFound } from "next/navigation";
import Image from "next/image";
import Link from "next/link";
import { getFoodById, foods } from "@/data/foods";
import Navbar from "@/components/layout/Navbar";
import Footer from "@/components/layout/Footer";
import StarRating from "@/components/ui/StarRating";
import FoodOrderClient from "@/components/restaurant/FoodOrderClient";
import FoodCard from "@/components/restaurant/FoodCard";
import { Clock, Flame, Users, CheckCircle, ArrowLeft } from "lucide-react";

export async function generateStaticParams() {
  return foods.map((f) => ({ id: String(f.id) }));
}

export async function generateMetadata({ params }) {
  const food = getFoodById(params.id);
  if (!food) return { title: "Dish Not Found" };
  return {
    title: `${food.name} | LuxeStay Restaurant`,
    description: food.description,
  };
}

export default async function FoodDetailPage({ params }) {
  const food = getFoodById(params.id);
  if (!food) notFound();

  const related = foods.filter((f) => f.category === food.category && f.id !== food.id).slice(0, 4);

  return (
    <>
      <Navbar />
      <main className="pt-24 pb-16">
        <div className="max-w-7xl mx-auto px-6 lg:px-10">
          {/* Breadcrumb */}
          <div className="flex items-center gap-2 text-sm text-gray-500 mb-6">
            <Link href="/" className="hover:text-[#D4A853]">Home</Link>
            <span>/</span>
            <Link href="/restaurant" className="hover:text-[#D4A853]">Restaurant</Link>
            <span>/</span>
            <span className="text-[#0F172A]">{food.name}</span>
          </div>

          <div className="grid grid-cols-1 lg:grid-cols-2 gap-12">
            {/* Images */}
            <div>
              <div className="relative h-80 md:h-96 rounded-3xl overflow-hidden mb-3">
                <Image src={food.images[0]} alt={food.name} fill className="object-cover" priority />
                {/* Veg/Non-veg badge */}
                <div className="absolute top-4 left-4">
                  <div className={`flex items-center gap-1.5 bg-white rounded-full px-3 py-1.5 shadow-md ${food.type === "veg" ? "border-2 border-green-500" : "border-2 border-red-500"}`}>
                    <div className={`w-2.5 h-2.5 rounded-full ${food.type === "veg" ? "bg-green-500" : "bg-red-500"}`} />
                    <span className={`text-xs font-bold ${food.type === "veg" ? "text-green-700" : "text-red-700"}`}>
                      {food.type === "veg" ? "VEG" : "NON-VEG"}
                    </span>
                  </div>
                </div>
              </div>
              <div className="grid grid-cols-2 gap-3">
                {food.images.slice(1, 3).map((img, i) => (
                  <div key={i} className="relative h-36 rounded-2xl overflow-hidden">
                    <Image src={img} alt={`${food.name} ${i + 2}`} fill className="object-cover hover:scale-105 transition-transform" />
                  </div>
                ))}
              </div>
            </div>

            {/* Info */}
            <div>
              <div className="flex flex-wrap gap-2 mb-3">
                {food.isBestSeller && <span className="badge-gold">Best Seller</span>}
                {food.isPopular && <span className="badge-navy">Popular</span>}
                <span className="badge-green">{food.cuisine}</span>
              </div>

              <h1 className="font-playfair text-3xl md:text-4xl text-[#0F172A] mb-2">{food.name}</h1>
              <p className="text-gray-500 mb-4">{food.category} · {food.cuisine} Cuisine</p>

              <StarRating rating={food.rating} count={food.reviewCount} size={16} />

              {/* Quick info */}
              <div className="grid grid-cols-3 gap-3 my-5">
                {[
                  { icon: Clock, label: "Prep Time", value: food.prepTime },
                  { icon: Flame, label: "Calories", value: `${food.calories} kcal` },
                  { icon: Users, label: "Serves", value: `${food.servings} person${food.servings > 1 ? "s" : ""}` },
                ].map(({ icon: Icon, label, value }) => (
                  <div key={label} className="bg-[#FAFAF8] rounded-xl p-3 border border-gray-100 text-center">
                    <Icon size={18} className="text-[#D4A853] mx-auto mb-1" />
                    <p className="text-xs text-gray-400">{label}</p>
                    <p className="text-sm font-semibold text-[#0F172A]">{value}</p>
                  </div>
                ))}
              </div>

              <p className="text-gray-600 leading-relaxed mb-5">{food.description}</p>

              {/* Ingredients */}
              <div className="mb-5">
                <h3 className="font-semibold text-[#0F172A] mb-2 text-sm">Key Ingredients</h3>
                <div className="flex flex-wrap gap-2">
                  {food.ingredients.map((ing) => (
                    <span key={ing} className="text-xs bg-white border border-gray-200 text-gray-600 px-2.5 py-1 rounded-lg flex items-center gap-1">
                      <CheckCircle size={11} className="text-green-500" /> {ing}
                    </span>
                  ))}
                </div>
              </div>

              {/* Spice level */}
              {food.spiceLevel !== "None" && (
                <div className="mb-5 flex items-center gap-2">
                  <span className="text-sm text-gray-500">Spice Level:</span>
                  <span className={`text-sm font-medium px-3 py-1 rounded-full ${
                    food.spiceLevel === "Hot" ? "bg-red-100 text-red-700" :
                    food.spiceLevel === "Medium-Hot" ? "bg-orange-100 text-orange-700" :
                    "bg-yellow-100 text-yellow-700"
                  }`}>
                    🌶️ {food.spiceLevel}
                  </span>
                </div>
              )}

              {/* Price & Add to cart */}
              <FoodOrderClient food={food} />
            </div>
          </div>

          {/* Related */}
          {related.length > 0 && (
            <div className="mt-16">
              <h2 className="font-playfair text-3xl text-[#0F172A] mb-8">More from {food.category}</h2>
              <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                {related.map((f) => <FoodCard key={f.id} food={f} />)}
              </div>
            </div>
          )}
        </div>
      </main>
      <Footer />
    </>
  );
}
