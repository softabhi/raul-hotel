import { Star } from "lucide-react";

export default function StarRating({ rating = 0, count = null, size = 14, showNumber = true }) {
  const full = Math.floor(rating);
  const hasHalf = rating % 1 >= 0.5;
  const empty = 5 - full - (hasHalf ? 1 : 0);

  return (
    <div className="flex items-center gap-1">
      <div className="flex items-center">
        {Array.from({ length: full }).map((_, i) => (
          <Star key={`f-${i}`} size={size} className="text-yellow-400 fill-yellow-400" />
        ))}
        {hasHalf && (
          <div className="relative">
            <Star size={size} className="text-gray-300 fill-gray-200" />
            <div className="absolute inset-0 overflow-hidden w-1/2">
              <Star size={size} className="text-yellow-400 fill-yellow-400" />
            </div>
          </div>
        )}
        {Array.from({ length: empty }).map((_, i) => (
          <Star key={`e-${i}`} size={size} className="text-gray-300 fill-gray-200" />
        ))}
      </div>
      {showNumber && (
        <span className="text-xs text-gray-600 font-medium">
          {rating.toFixed(1)}{count !== null && <span className="text-gray-400"> ({count})</span>}
        </span>
      )}
    </div>
  );
}
