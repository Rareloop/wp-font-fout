<?php

namespace Rareloop;

class FontFout
{
    public static $fontsLoaded = false;

    public static $fontFamilies;
    public static $cookieName;
    public static $cookieDuration;

    /**
     * Instantiates the plugin
     */
    public static function init($fontFamilies = [], $cookieName = 'fonts-loaded', $cookieDuration = 86400)
    {
        // Setup the static variables we need
        static::$fontFamilies = $fontFamilies;
        static::$cookieName = $cookieName;

        // Google Font's serves fonts with an expiration of 1 day (our default)
        static::$cookieDuration = $cookieDuration;

        // Hook into the footer action so that we can inject some custom JavaScript
        add_action('wp_footer', [static::class, 'echoFooterJavaScript'], 100);

        add_shortcode('fontfout-htmlclass', [static::class, 'shortcodeHandler']);
    }

    /**
     * If the fonts are already loaded returns a class to add to the HTML element
     *
     * @return String
     */
    public static function htmlClass()
    {
        if (isset($_COOKIE[static::$cookieName])) {
            static::$fontsLoaded = true;
            return 'fonts-loaded';
        } else {
            return '';
        }
    }

    /**
     * Outputs the JavaScript code needed to monitor the font loading
     *
     * @return null
     */
    public static function echoFooterJavaScript()
    {
        // If we don't have any font families then exit early
        if (empty(static::$fontFamilies)) {
            return;
        }

        // If the cookie is set then don't add any extra payload
        if (static::$fontsLoaded) {
            return;
        }

        ?>
        <script>
            /* FontFaceObserver is licensed under the BSD License. Copyright 2014-2015 Bram Stein. All rights reserved. */
            (function(){'use strict';var f,g=[];function l(a){g.push(a);1==g.length&&f()}function m(){for(;g.length;)g[0](),g.shift()}f=function(){setTimeout(m)};function n(a){this.a=p;this.b=void 0;this.f=[];var b=this;try{a(function(a){q(b,a)},function(a){r(b,a)})}catch(c){r(b,c)}}var p=2;function t(a){return new n(function(b,c){c(a)})}function u(a){return new n(function(b){b(a)})}function q(a,b){if(a.a==p){if(b==a)throw new TypeError;var c=!1;try{var d=b&&b.then;if(null!=b&&"object"==typeof b&&"function"==typeof d){d.call(b,function(b){c||q(a,b);c=!0},function(b){c||r(a,b);c=!0});return}}catch(e){c||r(a,e);return}a.a=0;a.b=b;v(a)}}
            function r(a,b){if(a.a==p){if(b==a)throw new TypeError;a.a=1;a.b=b;v(a)}}function v(a){l(function(){if(a.a!=p)for(;a.f.length;){var b=a.f.shift(),c=b[0],d=b[1],e=b[2],b=b[3];try{0==a.a?"function"==typeof c?e(c.call(void 0,a.b)):e(a.b):1==a.a&&("function"==typeof d?e(d.call(void 0,a.b)):b(a.b))}catch(h){b(h)}}})}n.prototype.g=function(a){return this.c(void 0,a)};n.prototype.c=function(a,b){var c=this;return new n(function(d,e){c.f.push([a,b,d,e]);v(c)})};
            function w(a){return new n(function(b,c){function d(c){return function(d){h[c]=d;e+=1;e==a.length&&b(h)}}var e=0,h=[];0==a.length&&b(h);for(var k=0;k<a.length;k+=1)u(a[k]).c(d(k),c)})}function x(a){return new n(function(b,c){for(var d=0;d<a.length;d+=1)u(a[d]).c(b,c)})};window.Promise||(window.Promise=n,window.Promise.resolve=u,window.Promise.reject=t,window.Promise.race=x,window.Promise.all=w,window.Promise.prototype.then=n.prototype.c,window.Promise.prototype["catch"]=n.prototype.g);}());

            (function(){'use strict';function h(a){document.body?a():document.addEventListener("DOMContentLoaded",a)};function k(a){this.a=document.createElement("div");this.a.setAttribute("aria-hidden","true");this.a.appendChild(document.createTextNode(a));this.b=document.createElement("span");this.c=document.createElement("span");this.h=document.createElement("span");this.g=document.createElement("span");this.f=-1;this.b.style.cssText="display:inline-block;position:absolute;height:100%;width:100%;overflow:scroll;font-size:16px;";this.c.style.cssText="display:inline-block;position:absolute;height:100%;width:100%;overflow:scroll;font-size:16px;";
            this.g.style.cssText="display:inline-block;position:absolute;height:100%;width:100%;overflow:scroll;font-size:16px;";this.h.style.cssText="display:inline-block;width:200%;height:200%;font-size:16px;";this.b.appendChild(this.h);this.c.appendChild(this.g);this.a.appendChild(this.b);this.a.appendChild(this.c)}
            function p(a,b){a.a.style.cssText="min-width:20px;min-height:20px;display:inline-block;overflow:hidden;position:absolute;width:auto;margin:0;padding:0;top:-999px;left:-999px;white-space:nowrap;font:"+b+";"}function x(a){var b=a.a.offsetWidth,c=b+100;a.g.style.width=c+"px";a.c.scrollLeft=c;a.b.scrollLeft=a.b.scrollWidth+100;return a.f!==b?(a.f=b,!0):!1}
            function y(a,b){a.b.addEventListener("scroll",function(){x(a)&&null!==a.a.parentNode&&b(a.f)},!1);a.c.addEventListener("scroll",function(){x(a)&&null!==a.a.parentNode&&b(a.f)},!1);x(a)};function z(a,b){var c=b||{};this.family=a;this.style=c.style||"normal";this.weight=c.weight||"normal";this.stretch=c.stretch||"normal"}var A=null,B=null,F=!!window.FontFace;function G(){if(null===B){var a=document.createElement("div");a.style.font="condensed 100px sans-serif";B=""!==a.style.font}return B}function H(a,b){return[a.style,a.weight,G()?a.stretch:"","100px",b].join(" ")}
            z.prototype.check=function(a,b){var c=this,r=a||"BESbswy",C=b||3E3,D=Date.now();return new Promise(function(a,b){if(F){var q=function(){Date.now()-D>=C?b(c):document.fonts.load(H(c,c.family),r).then(function(b){1<=b.length?a(c):setTimeout(q,25)}).catch(function(){b(c)})};q()}else h(function(){function t(){var b;if(b=-1!=e&&-1!=f||-1!=e&&-1!=g||-1!=f&&-1!=g)(b=e!=f&&e!=g&&f!=g)||(null===A&&(b=/AppleWebKit\/([0-9]+)(?:\.([0-9]+))/.exec(window.navigator.userAgent),A=!!b&&(536>parseInt(b[1],10)||536===
            parseInt(b[1],10)&&11>=parseInt(b[2],10))),b=A&&(e==u&&f==u&&g==u||e==v&&f==v&&g==v||e==w&&f==w&&g==w)),b=!b;b&&(null!==d.parentNode&&d.parentNode.removeChild(d),clearTimeout(E),a(c))}function q(){if(Date.now()-D>=C)null!==d.parentNode&&d.parentNode.removeChild(d),b(c);else{var a=document.hidden;if(!0===a||void 0===a)e=l.a.offsetWidth,f=m.a.offsetWidth,g=n.a.offsetWidth,t();E=setTimeout(q,50)}}var l=new k(r),m=new k(r),n=new k(r),e=-1,f=-1,g=-1,u=-1,v=-1,w=-1,d=document.createElement("div"),E=0;d.dir=
            "ltr";p(l,H(c,"sans-serif"));p(m,H(c,"serif"));p(n,H(c,"monospace"));d.appendChild(l.a);d.appendChild(m.a);d.appendChild(n.a);document.body.appendChild(d);u=l.a.offsetWidth;v=m.a.offsetWidth;w=n.a.offsetWidth;q();y(l,function(a){e=a;t()});p(l,H(c,'"'+c.family+'",sans-serif'));y(m,function(a){f=a;t()});p(m,H(c,'"'+c.family+'",serif'));y(n,function(a){g=a;t()});p(n,H(c,'"'+c.family+'",monospace'))})})};"undefined"!==typeof module?(module.exports=z,module.exports.prototype.check=z.prototype.check):(window.FontFaceObserver=z,window.FontFaceObserver.prototype.check=z.prototype.check);}());
        <?php

        // Work out which version of the JS we need to output
        if (count(static::$fontFamilies) === 1) {
            static::echoSingleFamilyCheck();
        } else {
            static::echoMultiFamilyCheck();
        }

        ?>
</script>
        <?php
    }

    /**
     * Outputs the JavaScript for checking a single font family
     *
     * @return null
     */
    public static function echoSingleFamilyCheck()
    {
        ?>
            
            var o = new FontFaceObserver('<?php echo static::$fontFamilies[0]?>');
            o.check().then(function() {
        <?php
            static::echoFontLoadedCode();
        ?>
    });
        <?php
    }

    /**
     * Outputs the JavaScript for checking multiple font families
     *
     * @return null
     */
    public static function echoMultiFamilyCheck()
    {
        $observers = [];

        // Shortern the output
        ?>

            var _f = FontFaceObserver;
        <?php

        // Get an observer for each font family
        for ($i = 0; $i < count(static::$fontFamilies); $i++) :
            $family = static::$fontFamilies[$i];
            $observers[] = "o$i.check()";
        ?>
    var o<?php echo $i ?> = new _f('<?php echo $family ?>');
        <?php
        endfor;

        // Create a promise that resolves when all fonts are loaded
        ?>

            Promise.all([<?php echo implode($observers, ', ') ?>]).then(function() {
        <?php
            static::echoFontLoadedCode();
        ?>
    });
        <?php
    }

    /**
     * Outputs the JavaScript code that runs once all fonts are loaded
     *
     * @return null
     */
    public static function echoFontLoadedCode()
    {
        ?>
        document.documentElement.className += ' fonts-loaded';
                var t = new Date();
                t.setSeconds(t.getSeconds() + <?php echo static::$cookieDuration; ?>);
                document.cookie = '<?php echo static::$cookieName; ?>=1; expires=' + t + '; path=<?php echo home_url('/', 'relative'); ?>';
        <?php
    }

    /**
     * Handler for the `fontfout-htmlclass` shortcode
     */
    public static function shortcodeHandler($attr, $content = null)
    {
        return static::htmlClass();
    }
}