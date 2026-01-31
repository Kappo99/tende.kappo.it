import type { NextConfig } from "next";

const nextConfig: NextConfig = {
  output: 'export',
  images: {
    unoptimized: true,
  },
  distDir: 'dist',
  trailingSlash: true,
  reactStrictMode: true,
  // Configurazione Turbopack (Next.js 16 usa Turbopack di default)
  turbopack: {},
};

export default nextConfig;
