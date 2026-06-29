import "./globals.css";

export const metadata = {
  title: {
    default: "LuxeStay & Dine | Premium Hotel & Restaurant",
    template: "%s | LuxeStay & Dine",
  },
  description:
    "Experience unparalleled luxury at LuxeStay & Dine — a 5-star hotel with world-class rooms and an award-winning restaurant serving exquisite cuisine.",
  keywords: ["luxury hotel", "hotel booking", "fine dining", "restaurant", "room booking"],
};

export default function RootLayout({ children }) {
  return (
    <html lang="en">
      <head>
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossOrigin="anonymous" />
        <link
          href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400&family=Inter:wght@300;400;500;600;700&display=swap"
          rel="stylesheet"
        />
      </head>
      <body className="antialiased">{children}</body>
    </html>
  );
}
