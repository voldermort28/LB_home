# LB Home

WordPress child theme and server configuration snapshots for `laboon.vn`.

## Paths

- `wp-content/themes/kababi-child/functions.php` maps to `/www/wwwroot/laboon.vn/wp-content/themes/kababi-child/functions.php`.
- `wp-content/themes/kababi-child/style.css` maps to `/www/wwwroot/laboon.vn/wp-content/themes/kababi-child/style.css`.
- `server/nginx/panel/vhost/nginx/laboon.vn.conf` maps to `/www/server/panel/vhost/nginx/laboon.vn.conf`.
- `server/nginx/panel/vhost/nginx/0.fastcgi_cache.conf` maps to `/www/server/panel/vhost/nginx/0.fastcgi_cache.conf`.

## Current performance changes

- Enables FastCGI cache for WordPress HTML.
- Adds browser cache headers for static images, CSS, JS, and fonts.
- Adds site-wide lazy loading for below-the-fold images through the Kababi child theme.
- Preloads first-visit hero images and defers the Zalo SDK.
