[![Author](https://img.shields.io/badge/author-Daniel%20M.%20Hendricks-lightgrey.svg?colorB=9900cc&style=flat-square)](https://www.danhendricks.com/?utm_source=github.com&utm_medium=campaign&utm_content=button&utm_campaign=dmhendricks%2Fphp-combine-scripts)
[![License](https://img.shields.io/github/license/dmhendricks/php-combine-scripts.svg?style=flat-square)](https://github.com/dmhendricks/php-combine-scripts/blob/master/LICENSE)
[![DigitalOcean](https://img.shields.io/badge/hosting-Digital%20Ocean-green.svg?style=flat-square&label=hosting&colorB=0152FF)](https://m.do.co/t/8a88362f5683?utm_source=github.com&utm_medium=referral&utm_content=button&utm_campaign=dmhendricks%2Fphp-combine-scripts)
[![Twitter](https://img.shields.io/twitter/url/https/github.com/dmhendricks/php-combine-scripts.svg?style=social)](https://twitter.com/danielhendricks)

# PHP Combine Scripts

A simple PHP script to combine and minify multiple JS or CSS files passed via URI, inspired by [jsDelivr](https://www.jsdelivr.com/features/?utm_source=github.com&utm_medium=referral&utm_content=link&utm_campaign=dmhendricks%2Fphp-combine-scripts#combine).

It was created for when you have multiple scripts at a static/CDN domain, allowing you to pick and bundle different libraries based on your current needs.

Generally, it is best to combine multiple assets into bundles using a task runner such as [webpack](https://webpack.js.org/?utm_source=github.com&utm_medium=referral&utm_content=link&utm_campaign=dmhendricks%2Fphp-combine-scripts) or [Gulp](https://gulpjs.com/?utm_source=github.com&utm_medium=referral&utm_content=link&utm_campaign=dmhendricks%2Fphp-combine-scripts), but it can be handy depending on your use case.

## Setup

1. Clone or unzip the files to a directory off of your web root. For example, `/combine/`. Change to that directory.
1. `composer install`
1. Rename `.env-sample` to `.env`. Set the `COMBINE_BASEDIR` to the directory that will contain your JS/CSS files that you want to allow combining/minification for.
1. Configure your web server to rewrite URLs, as shown in the examples below. Change the `/combine/` and `/minify/` paths as desired.

### Nginx

```nginx
# Rewrite combine/minify URLs
rewrite ^/combine/(.*)$ /combine/index.php?scripts=$1;
rewrite ^/minify/(.*)$ /combine/index.php?minify=true&scripts=$1;
```

### Apache

```apache
# Rewrite combine/minify URLs
RewriteRule "^/combine/(.*)$" "/combine/index.php?scripts=$1"
RewriteRule "^/minify/(.*)$" "/combine/index.php?minify=true&scripts=$1"
```

## Usage Example

For example, let's say that you set your `COMBINE_BASEDIR` to `/var/www/html/scipts/`. Withing this directory, you might have some JS or CSS libraries. We'll combine [Font Awesome](https://fontawesome.com/?utm_source=github.com&utm_medium=referral&utm_content=link&utm_campaign=dmhendricks%2Fphp-combine-scripts) with the [v4 shims](https://fontawesome.com/how-to-use/on-the-web/setup/upgrading-from-version-4/?utm_source=github.com&utm_medium=referral&utm_content=link&utm_campaign=dmhendricks%2Fphp-combine-scripts#shims) as an example, assuming that you have already [extracted them](https://github.com/FortAwesome/Font-Awesome/tree/master/css) to `/var/www/html/scipts/dist/css/`.

To combine or minify multiple scripts, separate them with commas:

```html
<!-- Combine example -->
<link rel="stylesheet" href="https://example.com/combine/dist/css/all.min.css,dist/css/v4-shims.min.css" />

<!-- Minify example -->
<link rel="stylesheet" href="https://example.com/minify/dist/css/all.css,dist/css/v4-shims.css" />
```

Of course, minification is not necessary for scripts that you already have minified versions for. It is merely an option for libraries/scripts that do not contain a minified version. If you have minified versions avaible, it is recommended to simply use the "combine" method as it consumes less system resources.
