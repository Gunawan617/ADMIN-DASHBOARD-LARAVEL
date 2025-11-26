# React Website Integration Setup

The Full Website Clone has been integrated into your Laravel project using Vite.

## What Was Done

1. ✅ Copied React source files to `resources/react-website/`
2. ✅ Updated `package.json` with React and shadcn/ui dependencies
3. ✅ Updated `vite.config.js` to support React + TypeScript
4. ✅ Created TypeScript configuration files
5. ✅ Created Blade template at `resources/views/website.blade.php`
6. ✅ Updated routes to serve React app at homepage (`/`)
7. ✅ Updated Tailwind config to include React components

## Installation Steps

Run these commands in the `ADMIN-DASHBOARD-LARAVEL` directory:

```bash
# Install dependencies
npm install

# Build assets for production
npm run build

# OR run development server
npm run dev
```

## Access Points

- **React Website**: `http://your-domain/` (homepage)
- **Old Welcome Page**: `http://your-domain/welcome` (if needed)
- **Admin Dashboard**: `http://your-domain/admin` (requires login)

## Development

When developing, run:
```bash
npm run dev
```

This will watch for changes in both:
- Vue components (existing admin dashboard)
- React components (new website clone)

## File Structure

```
resources/
├── react-website/          # React app source
│   ├── components/         # React components
│   │   ├── ui/            # shadcn/ui components
│   │   ├── Header.tsx
│   │   ├── Hero.tsx
│   │   └── ...
│   ├── App.tsx            # Main React app
│   ├── main.tsx           # React entry point
│   └── index.css          # Styles
└── views/
    └── website.blade.php  # Blade template for React
```

## Notes

- The React app uses TypeScript and shadcn/ui components
- Vite handles both Vue (admin) and React (website) compilation
- Both apps share the same Tailwind CSS configuration
