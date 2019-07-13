[![Author](https://img.shields.io/badge/author-Daniel%20M.%20Hendricks-lightgrey.svg?colorB=9900cc&style=flat-square)](https://www.danhendricks.com/?utm_source=github.com&utm_medium=campaign&utm_content=button&utm_campaign=php-combine-scripts)
[![License](https://img.shields.io/github/license/dmhendricks/php-combine-scripts.svg?style=flat-square)](https://github.com/dmhendricks/php-combine-scripts/blob/master/LICENSE)
[![DigitalOcean](https://img.shields.io/badge/hosting-Digital%20Ocean-green.svg?style=flat-square&label=hosting&colorB=0152FF)](https://m.do.co/t/8a88362f5683?utm_source=github.com&utm_medium=campaign&utm_content=button&utm_campaign=dmhendricks%2Fphp-combine-scripts)
[![Twitter](https://img.shields.io/twitter/url/https/github.com/dmhendricks/php-combine-scripts.svg?style=social)](https://twitter.com/danielhendricks)

# PHP Combine Scripts

A simple PHP script to combine and minify multiple JS or CSS files passed via URI, inspired by [jsDelivr](https://www.jsdelivr.com/features/?utm_source=github.com&utm_medium=campaign&utm_content=button&utm_campaign=php-combine-scripts#combine).

## Setup

1. Clone or unzip the files to a directory off of your web root. For example, `/combine/`. Change to that directory.
1. `composer install`
1. Rename `.env-sample` to `.env`. Change the `COMBINE_BASEDIR` to match your web root.
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
