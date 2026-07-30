/** @type {import('next').NextConfig} */
const nextConfig = {
  images: {
    remotePatterns: [
      {
        protocol: "https",
        hostname: "images.unsplash.com",
        pathname: "/**",
      },
      {
        protocol: "https",
        hostname: "raulsboutiquehotel.com",
        pathname: "/storage/**",
      },
    ],
  },
};

export default nextConfig;