 <meta property="og:url" content="{{ url()->current() }}">
 <meta property="og:type" content="{{ isset($meta['type']) ? $meta['type'] : 'website' }}">
 <meta property="og:title" content="{{ isset($meta['title']) ? $meta['title'] : __('pages.title') }}">
 <meta property="og:description"
     content="{{ isset($meta['description']) ? $meta['description'] : __('pages.description') }}">
 <meta property="og:image"
     content="{{ $_SERVER['APP_URL'] . (isset($meta['img']) ? '/storage/' . $meta['img'] : '/images/og-white.png') }}">
