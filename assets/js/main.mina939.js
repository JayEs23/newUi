function Layzr(a) {
  (this._lastScroll = 0),
    (this._ticking = !1),
    (a = a || {}),
    (this._optionsContainer = document.querySelector(a.container) || window),
    (this._optionsSelector = a.selector || "[data-layzr]"),
    (this._optionsAttr = a.attr || "data-layzr"),
    (this._optionsAttr = a.attr || "data-layzr- "),
    (this._optionsAttrRetina = a.retinaAttr || "data-layzr-retina"),
    (this._optionsAttrBg = a.bgAttr || "data-layzr-bg"),
    (this._optionsAttrHidden = a.hiddenAttr || "data-layzr-hidden"),
    (this._optionsThreshold = a.threshold || 0),
    (this._optionsBefore = a.before || null),
    (this._optionsAfter = a.after || null),
    (this._optionsCallback = a.callback || null),
    (this._retina = window.devicePixelRatio > 1),
    (this._srcAttr = this._retina
      ? this._optionsAttrRetina
      : this._optionsAttr),
    (this._nodes = document.querySelectorAll(this._optionsSelector)),
    (this._handlerBind = this._requestScroll.bind(this)),
    this._create();
}
function simple_tooltip(a, b) {
  jQuery(a).each(function(a) {
    jQuery("body").append(
      "<div class='" +
        b +
        "' id='" +
        b +
        a +
        "'>" +
        jQuery(this)
          .find("span.tooltip-c")
          .html() +
        "</div>"
    );
    var c = jQuery("#" + b + a);
    jQuery(this)
      .removeAttr("title")
      .mouseover(function() {
        c.css({ opacity: 1, display: "none" }).fadeIn(400);
      })
      .mousemove(function(a) {
        var b,
          d,
          e = jQuery(window).scrollTop(),
          f = jQuery(window).width(),
          g = 15;
        (b =
          f - 2 * g >= c.width() + a.pageX ? a.pageX + g : f - c.width() - g),
          (d =
            e + 2 * g >= a.pageY - c.height()
              ? e + g
              : a.pageY - c.height() - 2.2 * g),
          c.css({ left: b, top: d });
      })
      .mouseout(function() {
        c.css({ left: "-9999px" });
      });
  });
}
(jQuery.easing.jswing = jQuery.easing.swing),
  jQuery.extend(jQuery.easing, {
    def: "easeOutQuad",
    swing: function(a, b, c, d, e) {
      return jQuery.easing[jQuery.easing.def](a, b, c, d, e);
    },
    easeInQuad: function(a, b, c, d, e) {
      return d * (b /= e) * b + c;
    },
    easeOutQuad: function(a, b, c, d, e) {
      return -d * (b /= e) * (b - 2) + c;
    },
    easeInOutQuad: function(a, b, c, d, e) {
      return (b /= e / 2) < 1
        ? (d / 2) * b * b + c
        : (-d / 2) * (--b * (b - 2) - 1) + c;
    },
    easeInCubic: function(a, b, c, d, e) {
      return d * (b /= e) * b * b + c;
    },
    easeOutCubic: function(a, b, c, d, e) {
      return d * ((b = b / e - 1) * b * b + 1) + c;
    },
    easeInOutCubic: function(a, b, c, d, e) {
      return (b /= e / 2) < 1
        ? (d / 2) * b * b * b + c
        : (d / 2) * ((b -= 2) * b * b + 2) + c;
    },
    easeInQuart: function(a, b, c, d, e) {
      return d * (b /= e) * b * b * b + c;
    },
    easeOutQuart: function(a, b, c, d, e) {
      return -d * ((b = b / e - 1) * b * b * b - 1) + c;
    },
    easeInOutQuart: function(a, b, c, d, e) {
      return (b /= e / 2) < 1
        ? (d / 2) * b * b * b * b + c
        : (-d / 2) * ((b -= 2) * b * b * b - 2) + c;
    },
    easeInQuint: function(a, b, c, d, e) {
      return d * (b /= e) * b * b * b * b + c;
    },
    easeOutQuint: function(a, b, c, d, e) {
      return d * ((b = b / e - 1) * b * b * b * b + 1) + c;
    },
    easeInOutQuint: function(a, b, c, d, e) {
      return (b /= e / 2) < 1
        ? (d / 2) * b * b * b * b * b + c
        : (d / 2) * ((b -= 2) * b * b * b * b + 2) + c;
    },
    easeInSine: function(a, b, c, d, e) {
      return -d * Math.cos((b / e) * (Math.PI / 2)) + d + c;
    },
    easeOutSine: function(a, b, c, d, e) {
      return d * Math.sin((b / e) * (Math.PI / 2)) + c;
    },
    easeInOutSine: function(a, b, c, d, e) {
      return (-d / 2) * (Math.cos((Math.PI * b) / e) - 1) + c;
    },
    easeInExpo: function(a, b, c, d, e) {
      return 0 == b ? c : d * Math.pow(2, 10 * (b / e - 1)) + c;
    },
    easeOutExpo: function(a, b, c, d, e) {
      return b == e ? c + d : d * (-Math.pow(2, (-10 * b) / e) + 1) + c;
    },
    easeInOutExpo: function(a, b, c, d, e) {
      return 0 == b
        ? c
        : b == e
        ? c + d
        : (b /= e / 2) < 1
        ? (d / 2) * Math.pow(2, 10 * (b - 1)) + c
        : (d / 2) * (-Math.pow(2, -10 * --b) + 2) + c;
    },
    easeInCirc: function(a, b, c, d, e) {
      return -d * (Math.sqrt(1 - (b /= e) * b) - 1) + c;
    },
    easeOutCirc: function(a, b, c, d, e) {
      return d * Math.sqrt(1 - (b = b / e - 1) * b) + c;
    },
    easeInOutCirc: function(a, b, c, d, e) {
      return (b /= e / 2) < 1
        ? (-d / 2) * (Math.sqrt(1 - b * b) - 1) + c
        : (d / 2) * (Math.sqrt(1 - (b -= 2) * b) + 1) + c;
    },
    easeInElastic: function(a, b, c, d, e) {
      var f = 1.70158,
        g = 0,
        h = d;
      if (0 == b) return c;
      if (1 == (b /= e)) return c + d;
      if ((g || (g = 0.3 * e), h < Math.abs(d))) {
        h = d;
        var f = g / 4;
      } else var f = (g / (2 * Math.PI)) * Math.asin(d / h);
      return (
        -(
          h *
          Math.pow(2, 10 * (b -= 1)) *
          Math.sin((2 * (b * e - f) * Math.PI) / g)
        ) + c
      );
    },
    easeOutElastic: function(a, b, c, d, e) {
      var f = 1.70158,
        g = 0,
        h = d;
      if (0 == b) return c;
      if (1 == (b /= e)) return c + d;
      if ((g || (g = 0.3 * e), h < Math.abs(d))) {
        h = d;
        var f = g / 4;
      } else var f = (g / (2 * Math.PI)) * Math.asin(d / h);
      return (
        h * Math.pow(2, -10 * b) * Math.sin((2 * (b * e - f) * Math.PI) / g) +
        d +
        c
      );
    },
    easeInOutElastic: function(a, b, c, d, e) {
      var f = 1.70158,
        g = 0,
        h = d;
      if (0 == b) return c;
      if (2 == (b /= e / 2)) return c + d;
      if ((g || (g = 0.3 * e * 1.5), h < Math.abs(d))) {
        h = d;
        var f = g / 4;
      } else var f = (g / (2 * Math.PI)) * Math.asin(d / h);
      return b < 1
        ? -0.5 *
            h *
            Math.pow(2, 10 * (b -= 1)) *
            Math.sin((2 * (b * e - f) * Math.PI) / g) +
            c
        : h *
            Math.pow(2, -10 * (b -= 1)) *
            Math.sin((2 * (b * e - f) * Math.PI) / g) *
            0.5 +
            d +
            c;
    },
    easeInBack: function(a, b, c, d, e, f) {
      return (
        void 0 == f && (f = 1.70158), d * (b /= e) * b * ((f + 1) * b - f) + c
      );
    },
    easeOutBack: function(a, b, c, d, e, f) {
      return (
        void 0 == f && (f = 1.70158),
        d * ((b = b / e - 1) * b * ((f + 1) * b + f) + 1) + c
      );
    },
    easeInOutBack: function(a, b, c, d, e, f) {
      return (
        void 0 == f && (f = 1.70158),
        (b /= e / 2) < 1
          ? (d / 2) * b * b * (((f *= 1.525) + 1) * b - f) + c
          : (d / 2) * ((b -= 2) * b * (((f *= 1.525) + 1) * b + f) + 2) + c
      );
    },
    easeInBounce: function(a, b, c, d, e) {
      return d - jQuery.easing.easeOutBounce(a, e - b, 0, d, e) + c;
    },
    easeOutBounce: function(a, b, c, d, e) {
      return (b /= e) < 1 / 2.75
        ? 7.5625 * d * b * b + c
        : b < 2 / 2.75
        ? d * (7.5625 * (b -= 1.5 / 2.75) * b + 0.75) + c
        : b < 2.5 / 2.75
        ? d * (7.5625 * (b -= 2.25 / 2.75) * b + 0.9375) + c
        : d * (7.5625 * (b -= 2.625 / 2.75) * b + 0.984375) + c;
    },
    easeInOutBounce: function(a, b, c, d, e) {
      return b < e / 2
        ? 0.5 * jQuery.easing.easeInBounce(a, 2 * b, 0, d, e) + c
        : 0.5 * jQuery.easing.easeOutBounce(a, 2 * b - e, 0, d, e) +
            0.5 * d +
            c;
    }
  }),
  (function() {
    for (
      var a = 0, b = ["ms", "moz", "webkit", "o"], c = 0;
      c < b.length && !window.requestAnimationFrame;
      ++c
    )
      (window.requestAnimationFrame = window[b[c] + "RequestAnimationFrame"]),
        (window.cancelAnimationFrame =
          window[b[c] + "CancelAnimationFrame"] ||
          window[b[c] + "CancelRequestAnimationFrame"]);
    window.requestAnimationFrame ||
      (window.requestAnimationFrame = function(b, c) {
        var d = new Date().getTime(),
          e = Math.max(0, 16 - (d - a)),
          f = window.setTimeout(function() {
            b(d + e);
          }, e);
        return (a = d + e), f;
      }),
      window.cancelAnimationFrame ||
        (window.cancelAnimationFrame = function(a) {
          clearTimeout(a);
        });
  })(),
  (Layzr.prototype._requestScroll = function() {
    this._optionsContainer === window
      ? (this._lastScroll = window.pageYOffset)
      : (this._lastScroll =
          this._optionsContainer.scrollTop +
          this._getOffset(this._optionsContainer)),
      this._requestTick();
  }),
  (Layzr.prototype._requestTick = function() {
    this._ticking ||
      (requestAnimationFrame(this.update.bind(this)), (this._ticking = !0));
  }),
  (Layzr.prototype._getOffset = function(a) {
    if (a.hasAttribute("data-src"))
      var b = a.getAttribute("data-src"),
        c = b.substring(b.lastIndexOf(".") + 1);
    return (
      "png" == c && a.parentNode.classList.add("layzr-bg-transparent"),
      a.getBoundingClientRect().top + window.pageYOffset
    );
  }),
  (Layzr.prototype._getContainerHeight = function() {
    return (
      this._optionsContainer.innerHeight || this._optionsContainer.offsetHeight
    );
  }),
  (Layzr.prototype._create = function() {
    this._handlerBind(),
      this._optionsContainer.addEventListener("scroll", this._handlerBind, !1),
      this._optionsContainer.addEventListener("resize", this._handlerBind, !1);
  }),
  (Layzr.prototype._destroy = function() {
    this._optionsContainer.removeEventListener("scroll", this._handlerBind, !1),
      this._optionsContainer.removeEventListener(
        "resize",
        this._handlerBind,
        !1
      );
  }),
  (Layzr.prototype._inViewport = function(a) {
    var b = this._lastScroll,
      c = b + this._getContainerHeight(),
      d = this._getOffset(a),
      e = d + this._getContainerHeight(),
      f = (this._optionsThreshold / 100) * window.innerHeight;
    return e >= b - f && d <= c + f && !a.hasAttribute(this._optionsAttrHidden);
  }),
  (Layzr.prototype._reveal = function(a) {
    var b = a.getAttribute(this._srcAttr) || a.getAttribute(this._optionsAttr),
      c = this;
    if ("function" == typeof this._optionsCallback) {
      a.addEventListener
        ? a.addEventListener("load", function() {
            c._optionsCallback.call(a);
          })
        : a.attachEvent("onload", function() {
            c._optionsCallback.call(a);
          });
    }
    "function" == typeof this._optionsBefore && this._optionsBefore.call(a),
      a.hasAttribute(this._optionsAttrBg)
        ? (a.style.backgroundImage = "url(" + b + ")")
        : (b && a.setAttribute("src", b),
          a.hasAttribute(this._optionsAttr) &&
            a.setAttribute(" ", a.getAttribute(this._optionsAttr))),
      "function" == typeof this._optionsAfter && this._optionsAfter.call(a),
      a.removeAttribute(this._optionsAttr),
      a.removeAttribute(this._optionsAttr),
      a.removeAttribute(this._optionsAttrRetina),
      a.removeAttribute(this._optionsAttrBg),
      a.removeAttribute(this._optionsAttrHidden);
  }),
  (Layzr.prototype.updateSelector = function() {
    this._nodes = document.querySelectorAll(this._optionsSelector);
  }),
  (Layzr.prototype.update = function() {
    for (var a = this._nodes.length, b = 0; b < a; b++) {
      var c = this._nodes[b];
      (c.hasAttribute(this._optionsAttr) ||
        c.hasAttribute(this._optionsAttr) ||
        c.hasAttribute(this._optionsAttrRetina)) &&
        this._inViewport(c) &&
        this._reveal(c);
    }
    this._ticking = !1;
  }),
  !(function(a, b) {
    "function" == typeof define && define.amd
      ? define(b)
      : "object" == typeof exports
      ? (module.exports = b())
      : (a.PhotoSwipe = b());
  })(this, function() {
    "use strict";
    var a = function(a, b, c, d) {
      var e = {
        features: null,
        bind: function(a, b, c, d) {
          var e = (d ? "remove" : "add") + "EventListener";
          b = b.split(" ");
          for (var f = 0; f < b.length; f++) b[f] && a[e](b[f], c, !1);
        },
        isArray: function(a) {
          return a instanceof Array;
        },
        createEl: function(a, b) {
          var c = document.createElement(b || "div");
          return a && (c.className = a), c;
        },
        getScrollY: function() {
          var a = window.pageYOffset;
          return void 0 !== a ? a : document.documentElement.scrollTop;
        },
        unbind: function(a, b, c) {
          e.bind(a, b, c, !0);
        },
        removeClass: function(a, b) {
          var c = new RegExp("(\\s|^)" + b + "(\\s|$)");
          a.className = a.className
            .replace(c, " ")
            .replace(/^\s\s*/, "")
            .replace(/\s\s*$/, "");
        },
        addClass: function(a, b) {
          e.hasClass(a, b) || (a.className += (a.className ? " " : "") + b);
        },
        hasClass: function(a, b) {
          return (
            a.className &&
            new RegExp("(^|\\s)" + b + "(\\s|$)").test(a.className)
          );
        },
        getChildByClass: function(a, b) {
          for (var c = a.firstChild; c; ) {
            if (e.hasClass(c, b)) return c;
            c = c.nextSibling;
          }
        },
        arraySearch: function(a, b, c) {
          for (var d = a.length; d--; ) if (a[d][c] === b) return d;
          return -1;
        },
        extend: function(a, b, c) {
          for (var d in b)
            if (b.hasOwnProperty(d)) {
              if (c && a.hasOwnProperty(d)) continue;
              a[d] = b[d];
            }
        },
        easing: {
          sine: {
            out: function(a) {
              return Math.sin(a * (Math.PI / 2));
            },
            inOut: function(a) {
              return -(Math.cos(Math.PI * a) - 1) / 2;
            }
          },
          cubic: {
            out: function(a) {
              return --a * a * a + 1;
            }
          }
        },
        detectFeatures: function() {
          if (e.features) return e.features;
          var a = e.createEl(),
            b = a.style,
            c = "",
            d = {};
          if (
            ((d.oldIE = document.all && !document.addEventListener),
            (d.touch =
              "ontouchstart" in document.documentElement ||
              navigator.maxTouchPoints > 0),
            window.requestAnimationFrame &&
              ((d.raf = window.requestAnimationFrame),
              (d.caf = window.cancelAnimationFrame)),
            (d.pointerEvent =
              navigator.pointerEnabled || navigator.msPointerEnabled),
            !d.pointerEvent)
          ) {
            var f = navigator.userAgent;
            if (/iP(hone|od)/.test(navigator.platform)) {
              var g = navigator.appVersion.match(/OS (\d+)_(\d+)_?(\d+)?/);
              g &&
                g.length > 0 &&
                ((g = parseInt(g[1], 10)),
                g >= 1 && g < 8 && (d.isOldIOSPhone = !0));
            }
            var h = f.match(/Android\s([0-9\.]*)/),
              i = h ? h[1] : 0;
            (i = parseFloat(i)),
              i >= 1 &&
                (i < 4.4 && (d.isOldAndroid = !0), (d.androidVersion = i)),
              (d.isMobileOpera = /opera mini|opera mobi/i.test(f));
          }
          for (
            var j,
              k,
              l = ["transform", "perspective", "animationName"],
              m = ["", "webkit", "Moz", "ms", "O"],
              n = 0;
            n < 4;
            n++
          ) {
            c = m[n];
            for (var o = 0; o < 3; o++)
              (j = l[o]),
                (k = c + (c ? j.charAt(0).toUpperCase() + j.slice(1) : j)),
                !d[j] && k in b && (d[j] = k);
            c &&
              !d.raf &&
              ((c = c.toLowerCase()),
              (d.raf = window[c + "RequestAnimationFrame"]),
              d.raf &&
                (d.caf =
                  window[c + "CancelAnimationFrame"] ||
                  window[c + "CancelRequestAnimationFrame"]));
          }
          if (!d.raf) {
            var p = 0;
            (d.raf = function(a) {
              var b = new Date().getTime(),
                c = Math.max(0, 16 - (b - p)),
                d = window.setTimeout(function() {
                  a(b + c);
                }, c);
              return (p = b + c), d;
            }),
              (d.caf = function(a) {
                clearTimeout(a);
              });
          }
          return (
            (d.svg =
              !!document.createElementNS &&
              !!document.createElementNS("http://www.w3.org/2000/svg", "svg")
                .createSVGRect),
            (e.features = d),
            d
          );
        }
      };
      e.detectFeatures(),
        e.features.oldIE &&
          (e.bind = function(a, b, c, d) {
            b = b.split(" ");
            for (
              var e,
                f = (d ? "detach" : "attach") + "Event",
                g = function() {
                  c.handleEvent.call(c);
                },
                h = 0;
              h < b.length;
              h++
            )
              if ((e = b[h]))
                if ("object" == typeof c && c.handleEvent) {
                  if (d) {
                    if (!c["oldIE" + e]) return !1;
                  } else c["oldIE" + e] = g;
                  a[f]("on" + e, c["oldIE" + e]);
                } else a[f]("on" + e, c);
          });
      var f = this,
        g = 25,
        h = 3,
        i = {
          allowPanToNext: !0,
          spacing: 0.12,
          bgOpacity: 1,
          mouseUsed: !1,
          loop: !0,
          pinchToClose: !0,
          closeOnScroll: !0,
          closeOnVerticalDrag: !0,
          verticalDragRange: 0.75,
          hideAnimationDuration: 333,
          showAnimationDuration: 333,
          showHideOpacity: !1,
          focus: !0,
          escKey: !0,
          arrowKeys: !0,
          mainScrollEndFriction: 0.35,
          panEndFriction: 0.35,
          isClickableElement: function(a) {
            return "A" === a.tagName;
          },
          getDoubleTapZoom: function(a, b) {
            return a ? 1 : b.initialZoomLevel < 0.7 ? 1 : 1.33;
          },
          maxSpreadZoom: 1.33,
          modal: !0,
          scaleMode: "fit"
        };
      e.extend(i, d);
      var j,
        k,
        l,
        m,
        n,
        o,
        p,
        q,
        r,
        s,
        t,
        u,
        v,
        w,
        x,
        y,
        z,
        A,
        B,
        C,
        D,
        E,
        F,
        G,
        H,
        I,
        J,
        K,
        L,
        M,
        N,
        O,
        P,
        Q,
        R,
        S,
        T,
        U,
        V,
        W,
        X,
        Y,
        Z,
        $,
        _,
        aa,
        ba,
        ca,
        da,
        ea,
        fa,
        ga,
        ha,
        ia,
        ja,
        ka,
        la,
        ma = function() {
          return { x: 0, y: 0 };
        },
        na = ma(),
        oa = ma(),
        pa = ma(),
        qa = {},
        ra = 0,
        sa = {},
        ta = ma(),
        ua = 0,
        va = !0,
        wa = [],
        xa = {},
        ya = !1,
        za = function(a, b) {
          e.extend(f, b.publicMethods), wa.push(a);
        },
        Aa = function(a) {
          var b = ac();
          return a > b - 1 ? a - b : a < 0 ? b + a : a;
        },
        Ba = {},
        Ca = function(a, b) {
          return Ba[a] || (Ba[a] = []), Ba[a].push(b);
        },
        Da = function(a) {
          var b = Ba[a];
          if (b) {
            var c = Array.prototype.slice.call(arguments);
            c.shift();
            for (var d = 0; d < b.length; d++) b[d].apply(f, c);
          }
        },
        Ea = function() {
          return new Date().getTime();
        },
        Fa = function(a) {
          (ja = a), (f.bg.style.opacity = a * i.bgOpacity);
        },
        Ga = function(a, b, c, d, e) {
          (!ya || (e && e !== f.currItem)) &&
            (d /= e ? e.fitRatio : f.currItem.fitRatio),
            (a[E] = u + b + "px, " + c + "px" + v + " scale(" + d + ")");
        },
        Ha = function(a) {
          ea &&
            (a &&
              (s > f.currItem.fitRatio
                ? ya || (mc(f.currItem, !1, !0), (ya = !0))
                : ya && (mc(f.currItem), (ya = !1))),
            Ga(ea, pa.x, pa.y, s));
        },
        Ia = function(a) {
          a.container &&
            Ga(
              a.container.style,
              a.initialPosition.x,
              a.initialPosition.y,
              a.initialZoomLevel,
              a
            );
        },
        Ja = function(a, b) {
          b[E] = u + a + "px, 0px" + v;
        },
        Ka = function(a, b) {
          if (!i.loop && b) {
            var c = m + (ta.x * ra - a) / ta.x,
              d = Math.round(a - tb.x);
            ((c < 0 && d > 0) || (c >= ac() - 1 && d < 0)) &&
              (a = tb.x + d * i.mainScrollEndFriction);
          }
          (tb.x = a), Ja(a, n);
        },
        La = function(a, b) {
          var c = ub[a] - sa[a];
          return oa[a] + na[a] + c - c * (b / t);
        },
        Ma = function(a, b) {
          (a.x = b.x), (a.y = b.y), b.id && (a.id = b.id);
        },
        Na = function(a) {
          (a.x = Math.round(a.x)), (a.y = Math.round(a.y));
        },
        Oa = null,
        Pa = function() {
          Oa &&
            (e.unbind(document, "mousemove", Pa),
            e.addClass(a, "pswp--has_mouse"),
            (i.mouseUsed = !0),
            Da("mouseUsed")),
            (Oa = setTimeout(function() {
              Oa = null;
            }, 100));
        },
        Qa = function() {
          e.bind(document, "keydown", f),
            N.transform && e.bind(f.scrollWrap, "click", f),
            i.mouseUsed || e.bind(document, "mousemove", Pa),
            e.bind(window, "resize scroll orientationchange", f),
            Da("bindEvents");
        },
        Ra = function() {
          e.unbind(window, "resize scroll orientationchange", f),
            e.unbind(window, "scroll", r.scroll),
            e.unbind(document, "keydown", f),
            e.unbind(document, "mousemove", Pa),
            N.transform && e.unbind(f.scrollWrap, "click", f),
            V && e.unbind(window, p, f),
            clearTimeout(O),
            Da("unbindEvents");
        },
        Sa = function(a, b) {
          var c = ic(f.currItem, qa, a);
          return b && (da = c), c;
        },
        Ta = function(a) {
          return a || (a = f.currItem), a.initialZoomLevel;
        },
        Ua = function(a) {
          return a || (a = f.currItem), a.w > 0 ? i.maxSpreadZoom : 1;
        },
        Va = function(a, b, c, d) {
          return d === f.currItem.initialZoomLevel
            ? ((c[a] = f.currItem.initialPosition[a]), !0)
            : ((c[a] = La(a, d)),
              c[a] > b.min[a]
                ? ((c[a] = b.min[a]), !0)
                : c[a] < b.max[a] && ((c[a] = b.max[a]), !0));
        },
        Wa = function() {
          if (E) {
            var b = N.perspective && !G;
            return (
              (u = "translate" + (b ? "3d(" : "(")),
              void (v = N.perspective ? ", 0px)" : ")")
            );
          }
          (E = "left"),
            e.addClass(a, "pswp--ie"),
            (Ja = function(a, b) {
              b.left = a + "px";
            }),
            (Ia = function(a) {
              var b = a.fitRatio > 1 ? 1 : a.fitRatio,
                c = a.container.style,
                d = b * a.w,
                e = b * a.h;
              (c.width = d + "px"),
                (c.height = e + "px"),
                (c.left = a.initialPosition.x + "px"),
                (c.top = a.initialPosition.y + "px");
            }),
            (Ha = function() {
              if (ea) {
                var a = ea,
                  b = f.currItem,
                  c = b.fitRatio > 1 ? 1 : b.fitRatio,
                  d = c * b.w,
                  e = c * b.h;
                (a.width = d + "px"),
                  (a.height = e + "px"),
                  (a.left = pa.x + "px"),
                  (a.top = pa.y + "px");
              }
            });
        },
        Xa = function(a) {
          var b = "";
          i.escKey && 27 === a.keyCode
            ? (b = "close")
            : i.arrowKeys &&
              (37 === a.keyCode
                ? (b = "prev")
                : 39 === a.keyCode && (b = "next")),
            b &&
              (a.ctrlKey ||
                a.altKey ||
                a.shiftKey ||
                a.metaKey ||
                (a.preventDefault ? a.preventDefault() : (a.returnValue = !1),
                f[b]()));
        },
        Ya = function(a) {
          a && (Y || X || fa || T) && (a.preventDefault(), a.stopPropagation());
        },
        Za = function() {
          f.setScrollOffset(0, e.getScrollY());
        },
        $a = {},
        _a = 0,
        ab = function(a) {
          $a[a] && ($a[a].raf && I($a[a].raf), _a--, delete $a[a]);
        },
        bb = function(a) {
          $a[a] && ab(a), $a[a] || (_a++, ($a[a] = {}));
        },
        cb = function() {
          for (var a in $a) $a.hasOwnProperty(a) && ab(a);
        },
        db = function(a, b, c, d, e, f, g) {
          var h,
            i = Ea();
          bb(a);
          var j = function() {
            if ($a[a]) {
              if (((h = Ea() - i), h >= d)) return ab(a), f(c), void (g && g());
              f((c - b) * e(h / d) + b), ($a[a].raf = H(j));
            }
          };
          j();
        },
        eb = {
          shout: Da,
          listen: Ca,
          viewportSize: qa,
          options: i,
          isMainScrollAnimating: function() {
            return fa;
          },
          getZoomLevel: function() {
            return s;
          },
          getCurrentIndex: function() {
            return m;
          },
          isDragging: function() {
            return V;
          },
          isZooming: function() {
            return aa;
          },
          setScrollOffset: function(a, b) {
            (sa.x = a), (M = sa.y = b), Da("updateScrollOffset", sa);
          },
          applyZoomPan: function(a, b, c, d) {
            (pa.x = b), (pa.y = c), (s = a), Ha(d);
          },
          init: function() {
            if (!j && !k) {
              var c;
              (f.framework = e),
                (f.template = a),
                (f.bg = e.getChildByClass(a, "pswp__bg")),
                (J = a.className),
                (j = !0),
                (N = e.detectFeatures()),
                (H = N.raf),
                (I = N.caf),
                (E = N.transform),
                (L = N.oldIE),
                (f.scrollWrap = e.getChildByClass(a, "pswp__scroll-wrap")),
                (f.container = e.getChildByClass(
                  f.scrollWrap,
                  "pswp__container"
                )),
                (n = f.container.style),
                (f.itemHolders = y = [
                  { el: f.container.children[0], wrap: 0, index: -1 },
                  { el: f.container.children[1], wrap: 0, index: -1 },
                  { el: f.container.children[2], wrap: 0, index: -1 }
                ]),
                (y[0].el.style.display = y[2].el.style.display = "none"),
                Wa(),
                (r = {
                  resize: f.updateSize,
                  orientationchange: function() {
                    clearTimeout(O),
                      (O = setTimeout(function() {
                        qa.x !== f.scrollWrap.clientWidth && f.updateSize();
                      }, 500));
                  },
                  scroll: Za,
                  keydown: Xa,
                  click: Ya
                });
              var d = N.isOldIOSPhone || N.isOldAndroid || N.isMobileOpera;
              for (
                (N.animationName && N.transform && !d) ||
                  (i.showAnimationDuration = i.hideAnimationDuration = 0),
                  c = 0;
                c < wa.length;
                c++
              )
                f["init" + wa[c]]();
              if (b) {
                var g = (f.ui = new b(f, e));
                g.init();
              }
              Da("firstUpdate"),
                (m = m || i.index || 0),
                (isNaN(m) || m < 0 || m >= ac()) && (m = 0),
                (f.currItem = _b(m)),
                (N.isOldIOSPhone || N.isOldAndroid) && (va = !1),
                a.setAttribute("aria-hidden", "false"),
                i.modal &&
                  (va
                    ? (a.style.position = "fixed")
                    : ((a.style.position = "absolute"),
                      (a.style.top = e.getScrollY() + "px"))),
                void 0 === M && (Da("initialLayout"), (M = K = e.getScrollY()));
              var l = "pswp--open ";
              for (
                i.mainClass && (l += i.mainClass + " "),
                  i.showHideOpacity && (l += "pswp--animate_opacity "),
                  l += G ? "pswp--touch" : "pswp--notouch",
                  l += N.animationName ? " pswp--css_animation" : "",
                  l += N.svg ? " pswp--svg" : "",
                  e.addClass(a, l),
                  f.updateSize(),
                  o = -1,
                  ua = null,
                  c = 0;
                c < h;
                c++
              )
                Ja((c + o) * ta.x, y[c].el.style);
              L || e.bind(f.scrollWrap, q, f),
                Ca("initialZoomInEnd", function() {
                  f.setContent(y[0], m - 1),
                    f.setContent(y[2], m + 1),
                    (y[0].el.style.display = y[2].el.style.display = "block"),
                    i.focus && a.focus(),
                    Qa();
                }),
                f.setContent(y[1], m),
                f.updateCurrItem(),
                Da("afterInit"),
                va ||
                  (w = setInterval(function() {
                    _a ||
                      V ||
                      aa ||
                      s !== f.currItem.initialZoomLevel ||
                      f.updateSize();
                  }, 1e3)),
                e.addClass(a, "pswp--visible");
            }
          },
          close: function() {
            j &&
              ((j = !1),
              (k = !0),
              Da("close"),
              Ra(),
              cc(f.currItem, null, !0, f.destroy));
          },
          destroy: function() {
            Da("destroy"),
              Xb && clearTimeout(Xb),
              a.setAttribute("aria-hidden", "true"),
              (a.className = J),
              w && clearInterval(w),
              e.unbind(f.scrollWrap, q, f),
              e.unbind(window, "scroll", f),
              zb(),
              cb(),
              (Ba = null);
          },
          panTo: function(a, b, c) {
            c ||
              (a > da.min.x ? (a = da.min.x) : a < da.max.x && (a = da.max.x),
              b > da.min.y ? (b = da.min.y) : b < da.max.y && (b = da.max.y)),
              (pa.x = a),
              (pa.y = b),
              Ha();
          },
          handleEvent: function(a) {
            (a = a || window.event), r[a.type] && r[a.type](a);
          },
          goTo: function(a) {
            a = Aa(a);
            var b = a - m;
            (ua = b),
              (m = a),
              (f.currItem = _b(m)),
              (ra -= b),
              Ka(ta.x * ra),
              cb(),
              (fa = !1),
              f.updateCurrItem();
          },
          next: function() {
            f.goTo(m + 1);
          },
          prev: function() {
            f.goTo(m - 1);
          },
          updateCurrZoomItem: function(a) {
            if ((a && Da("beforeChange", 0), y[1].el.children.length)) {
              var b = y[1].el.children[0];
              ea = e.hasClass(b, "pswp__zoom-wrap") ? b.style : null;
            } else ea = null;
            (da = f.currItem.bounds),
              (t = s = f.currItem.initialZoomLevel),
              (pa.x = da.center.x),
              (pa.y = da.center.y),
              a && Da("afterChange");
          },
          invalidateCurrItems: function() {
            x = !0;
            for (var a = 0; a < h; a++)
              y[a].item && (y[a].item.needsUpdate = !0);
          },
          updateCurrItem: function(a) {
            if (0 !== ua) {
              var b,
                c = Math.abs(ua);
              if (!(a && c < 2)) {
                (f.currItem = _b(m)),
                  (ya = !1),
                  Da("beforeChange", ua),
                  c >= h && ((o += ua + (ua > 0 ? -h : h)), (c = h));
                for (var d = 0; d < c; d++)
                  ua > 0
                    ? ((b = y.shift()),
                      (y[h - 1] = b),
                      o++,
                      Ja((o + 2) * ta.x, b.el.style),
                      f.setContent(b, m - c + d + 1 + 1))
                    : ((b = y.pop()),
                      y.unshift(b),
                      o--,
                      Ja(o * ta.x, b.el.style),
                      f.setContent(b, m + c - d - 1 - 1));
                if (ea && 1 === Math.abs(ua)) {
                  var e = _b(z);
                  e.initialZoomLevel !== s && (ic(e, qa), mc(e), Ia(e));
                }
                (ua = 0), f.updateCurrZoomItem(), (z = m), Da("afterChange");
              }
            }
          },
          updateSize: function(b) {
            if (!va && i.modal) {
              var c = e.getScrollY();
              if (
                (M !== c && ((a.style.top = c + "px"), (M = c)),
                !b && xa.x === window.innerWidth && xa.y === window.innerHeight)
              )
                return;
              (xa.x = window.innerWidth),
                (xa.y = window.innerHeight),
                (a.style.height = xa.y + "px");
            }
            if (
              ((qa.x = f.scrollWrap.clientWidth),
              (qa.y = f.scrollWrap.clientHeight),
              Za(),
              (ta.x = qa.x + Math.round(qa.x * i.spacing)),
              (ta.y = qa.y),
              Ka(ta.x * ra),
              Da("beforeResize"),
              void 0 !== o)
            ) {
              for (var d, g, j, k = 0; k < h; k++)
                (d = y[k]),
                  Ja((k + o) * ta.x, d.el.style),
                  (j = m + k - 1),
                  i.loop && ac() > 2 && (j = Aa(j)),
                  (g = _b(j)),
                  g && (x || g.needsUpdate || !g.bounds)
                    ? (f.cleanSlide(g),
                      f.setContent(d, j),
                      1 === k && ((f.currItem = g), f.updateCurrZoomItem(!0)),
                      (g.needsUpdate = !1))
                    : d.index === -1 && j >= 0 && f.setContent(d, j),
                  g && g.container && (ic(g, qa), mc(g), Ia(g));
              x = !1;
            }
            (t = s = f.currItem.initialZoomLevel),
              (da = f.currItem.bounds),
              da && ((pa.x = da.center.x), (pa.y = da.center.y), Ha(!0)),
              Da("resize");
          },
          zoomTo: function(a, b, c, d, f) {
            b &&
              ((t = s),
              (ub.x = Math.abs(b.x) - pa.x),
              (ub.y = Math.abs(b.y) - pa.y),
              Ma(oa, pa));
            var g = Sa(a, !1),
              h = {};
            Va("x", g, h, a), Va("y", g, h, a);
            var i = s,
              j = { x: pa.x, y: pa.y };
            Na(h);
            var k = function(b) {
              1 === b
                ? ((s = a), (pa.x = h.x), (pa.y = h.y))
                : ((s = (a - i) * b + i),
                  (pa.x = (h.x - j.x) * b + j.x),
                  (pa.y = (h.y - j.y) * b + j.y)),
                f && f(b),
                Ha(1 === b);
            };
            c ? db("customZoomTo", 0, 1, c, d || e.easing.sine.inOut, k) : k(1);
          }
        },
        fb = 30,
        gb = 10,
        hb = {},
        ib = {},
        jb = {},
        kb = {},
        lb = {},
        mb = [],
        nb = {},
        ob = [],
        pb = {},
        qb = 0,
        rb = ma(),
        sb = 0,
        tb = ma(),
        ub = ma(),
        vb = ma(),
        wb = function(a, b) {
          return a.x === b.x && a.y === b.y;
        },
        xb = function(a, b) {
          return Math.abs(a.x - b.x) < g && Math.abs(a.y - b.y) < g;
        },
        yb = function(a, b) {
          return (
            (pb.x = Math.abs(a.x - b.x)),
            (pb.y = Math.abs(a.y - b.y)),
            Math.sqrt(pb.x * pb.x + pb.y * pb.y)
          );
        },
        zb = function() {
          Z && (I(Z), (Z = null));
        },
        Ab = function() {
          V && ((Z = H(Ab)), Qb());
        },
        Bb = function() {
          return !("fit" === i.scaleMode && s === f.currItem.initialZoomLevel);
        },
        Cb = function(a, b) {
          return (
            !(!a || a === document) &&
            !(
              a.getAttribute("class") &&
              a.getAttribute("class").indexOf("pswp__scroll-wrap") > -1
            ) &&
            (b(a) ? a : Cb(a.parentNode, b))
          );
        },
        Db = {},
        Eb = function(a, b) {
          return (
            (Db.prevent = !Cb(a.target, i.isClickableElement)),
            Da("preventDragEvent", a, b, Db),
            Db.prevent
          );
        },
        Fb = function(a, b) {
          return (b.x = a.pageX), (b.y = a.pageY), (b.id = a.identifier), b;
        },
        Gb = function(a, b, c) {
          (c.x = 0.5 * (a.x + b.x)), (c.y = 0.5 * (a.y + b.y));
        },
        Hb = function(a, b, c) {
          if (a - Q > 50) {
            var d = ob.length > 2 ? ob.shift() : {};
            (d.x = b), (d.y = c), ob.push(d), (Q = a);
          }
        },
        Ib = function() {
          var a = pa.y - f.currItem.initialPosition.y;
          return 1 - Math.abs(a / (qa.y / 2));
        },
        Jb = {},
        Kb = {},
        Lb = [],
        Mb = function(a) {
          for (; Lb.length > 0; ) Lb.pop();
          return (
            F
              ? ((la = 0),
                mb.forEach(function(a) {
                  0 === la ? (Lb[0] = a) : 1 === la && (Lb[1] = a), la++;
                }))
              : a.type.indexOf("touch") > -1
              ? a.touches &&
                a.touches.length > 0 &&
                ((Lb[0] = Fb(a.touches[0], Jb)),
                a.touches.length > 1 && (Lb[1] = Fb(a.touches[1], Kb)))
              : ((Jb.x = a.pageX),
                (Jb.y = a.pageY),
                (Jb.id = ""),
                (Lb[0] = Jb)),
            Lb
          );
        },
        Nb = function(a, b) {
          var c,
            d,
            e,
            g,
            h = 0,
            j = pa[a] + b[a],
            k = b[a] > 0,
            l = tb.x + b.x,
            m = tb.x - nb.x;
          return (
            (c = j > da.min[a] || j < da.max[a] ? i.panEndFriction : 1),
            (j = pa[a] + b[a] * c),
            (!i.allowPanToNext && s !== f.currItem.initialZoomLevel) ||
            (ea
              ? "h" !== ga ||
                "x" !== a ||
                X ||
                (k
                  ? (j > da.min[a] &&
                      ((c = i.panEndFriction),
                      (h = da.min[a] - j),
                      (d = da.min[a] - oa[a])),
                    (d <= 0 || m < 0) && ac() > 1
                      ? ((g = l), m < 0 && l > nb.x && (g = nb.x))
                      : da.min.x !== da.max.x && (e = j))
                  : (j < da.max[a] &&
                      ((c = i.panEndFriction),
                      (h = j - da.max[a]),
                      (d = oa[a] - da.max[a])),
                    (d <= 0 || m > 0) && ac() > 1
                      ? ((g = l), m > 0 && l < nb.x && (g = nb.x))
                      : da.min.x !== da.max.x && (e = j)))
              : (g = l),
            "x" !== a)
              ? void (
                  fa ||
                  $ ||
                  (s > f.currItem.fitRatio && (pa[a] += b[a] * c))
                )
              : (void 0 !== g && (Ka(g, !0), ($ = g !== nb.x)),
                da.min.x !== da.max.x &&
                  (void 0 !== e ? (pa.x = e) : $ || (pa.x += b.x * c)),
                void 0 !== g)
          );
        },
        Ob = function(a) {
          if (!("mousedown" === a.type && a.button > 0)) {
            if ($b) return void a.preventDefault();
            if (!U || "mousedown" !== a.type) {
              if ((Eb(a, !0) && a.preventDefault(), Da("pointerDown"), F)) {
                var b = e.arraySearch(mb, a.pointerId, "id");
                b < 0 && (b = mb.length),
                  (mb[b] = { x: a.pageX, y: a.pageY, id: a.pointerId });
              }
              var c = Mb(a),
                d = c.length;
              (_ = null),
                cb(),
                (V && 1 !== d) ||
                  ((V = ha = !0),
                  e.bind(window, p, f),
                  (S = ka = ia = T = $ = Y = W = X = !1),
                  (ga = null),
                  Da("firstTouchStart", c),
                  Ma(oa, pa),
                  (na.x = na.y = 0),
                  Ma(kb, c[0]),
                  Ma(lb, kb),
                  (nb.x = ta.x * ra),
                  (ob = [{ x: kb.x, y: kb.y }]),
                  (Q = P = Ea()),
                  Sa(s, !0),
                  zb(),
                  Ab()),
                !aa &&
                  d > 1 &&
                  !fa &&
                  !$ &&
                  ((t = s),
                  (X = !1),
                  (aa = W = !0),
                  (na.y = na.x = 0),
                  Ma(oa, pa),
                  Ma(hb, c[0]),
                  Ma(ib, c[1]),
                  Gb(hb, ib, vb),
                  (ub.x = Math.abs(vb.x) - pa.x),
                  (ub.y = Math.abs(vb.y) - pa.y),
                  (ba = ca = yb(hb, ib)));
            }
          }
        },
        Pb = function(a) {
          if ((a.preventDefault(), F)) {
            var b = e.arraySearch(mb, a.pointerId, "id");
            if (b > -1) {
              var c = mb[b];
              (c.x = a.pageX), (c.y = a.pageY);
            }
          }
          if (V) {
            var d = Mb(a);
            if (ga || Y || aa) _ = d;
            else if (tb.x !== ta.x * ra) ga = "h";
            else {
              var f = Math.abs(d[0].x - kb.x) - Math.abs(d[0].y - kb.y);
              Math.abs(f) >= gb && ((ga = f > 0 ? "h" : "v"), (_ = d));
            }
          }
        },
        Qb = function() {
          if (_) {
            var a = _.length;
            if (0 !== a)
              if (
                (Ma(hb, _[0]),
                (jb.x = hb.x - kb.x),
                (jb.y = hb.y - kb.y),
                aa && a > 1)
              ) {
                if (
                  ((kb.x = hb.x), (kb.y = hb.y), !jb.x && !jb.y && wb(_[1], ib))
                )
                  return;
                Ma(ib, _[1]), X || ((X = !0), Da("zoomGestureStarted"));
                var b = yb(hb, ib),
                  c = Vb(b);
                c >
                  f.currItem.initialZoomLevel +
                    f.currItem.initialZoomLevel / 15 && (ka = !0);
                var d = 1,
                  e = Ta(),
                  g = Ua();
                if (c < e)
                  if (
                    i.pinchToClose &&
                    !ka &&
                    t <= f.currItem.initialZoomLevel
                  ) {
                    var h = e - c,
                      j = 1 - h / (e / 1.2);
                    Fa(j), Da("onPinchClose", j), (ia = !0);
                  } else
                    (d = (e - c) / e), d > 1 && (d = 1), (c = e - d * (e / 3));
                else
                  c > g &&
                    ((d = (c - g) / (6 * e)),
                    d > 1 && (d = 1),
                    (c = g + d * e));
                d < 0 && (d = 0),
                  (ba = b),
                  Gb(hb, ib, rb),
                  (na.x += rb.x - vb.x),
                  (na.y += rb.y - vb.y),
                  Ma(vb, rb),
                  (pa.x = La("x", c)),
                  (pa.y = La("y", c)),
                  (S = c > s),
                  (s = c),
                  Ha();
              } else {
                if (!ga) return;
                if (
                  (ha &&
                    ((ha = !1),
                    Math.abs(jb.x) >= gb && (jb.x -= _[0].x - lb.x),
                    Math.abs(jb.y) >= gb && (jb.y -= _[0].y - lb.y)),
                  (kb.x = hb.x),
                  (kb.y = hb.y),
                  0 === jb.x && 0 === jb.y)
                )
                  return;
                if ("v" === ga && i.closeOnVerticalDrag && !Bb()) {
                  (na.y += jb.y), (pa.y += jb.y);
                  var k = Ib();
                  return (T = !0), Da("onVerticalDrag", k), Fa(k), void Ha();
                }
                Hb(Ea(), hb.x, hb.y), (Y = !0), (da = f.currItem.bounds);
                var l = Nb("x", jb);
                l || (Nb("y", jb), Na(pa), Ha());
              }
          }
        },
        Rb = function(a) {
          if (N.isOldAndroid) {
            if (U && "mouseup" === a.type) return;
            a.type.indexOf("touch") > -1 &&
              (clearTimeout(U),
              (U = setTimeout(function() {
                U = 0;
              }, 600)));
          }
          Da("pointerUp"), Eb(a, !1) && a.preventDefault();
          var b;
          if (F) {
            var c = e.arraySearch(mb, a.pointerId, "id");
            if (c > -1)
              if (((b = mb.splice(c, 1)[0]), navigator.pointerEnabled))
                b.type = a.pointerType || "mouse";
              else {
                var d = { 4: "mouse", 2: "touch", 3: "pen" };
                (b.type = d[a.pointerType]),
                  b.type || (b.type = a.pointerType || "mouse");
              }
          }
          var g,
            h = Mb(a),
            j = h.length;
          if (("mouseup" === a.type && (j = 0), 2 === j)) return (_ = null), !0;
          1 === j && Ma(lb, h[0]),
            0 !== j ||
              ga ||
              fa ||
              (b ||
                ("mouseup" === a.type
                  ? (b = { x: a.pageX, y: a.pageY, type: "mouse" })
                  : a.changedTouches &&
                    a.changedTouches[0] &&
                    (b = {
                      x: a.changedTouches[0].pageX,
                      y: a.changedTouches[0].pageY,
                      type: "touch"
                    })),
              Da("touchRelease", a, b));
          var k = -1;
          if (
            (0 === j &&
              ((V = !1),
              e.unbind(window, p, f),
              zb(),
              aa ? (k = 0) : sb !== -1 && (k = Ea() - sb)),
            (sb = 1 === j ? Ea() : -1),
            (g = k !== -1 && k < 150 ? "zoom" : "swipe"),
            aa &&
              j < 2 &&
              ((aa = !1),
              1 === j && (g = "zoomPointerUp"),
              Da("zoomGestureEnded")),
            (_ = null),
            Y || X || fa || T)
          )
            if ((cb(), R || (R = Sb()), R.calculateSwipeSpeed("x"), T)) {
              var l = Ib();
              if (l < i.verticalDragRange) f.close();
              else {
                var m = pa.y,
                  n = ja;
                db("verticalDrag", 0, 1, 300, e.easing.cubic.out, function(a) {
                  (pa.y = (f.currItem.initialPosition.y - m) * a + m),
                    Fa((1 - n) * a + n),
                    Ha();
                }),
                  Da("onVerticalDrag", 1);
              }
            } else {
              if (($ || fa) && 0 === j) {
                var o = Ub(g, R);
                if (o) return;
                g = "zoomPointerUp";
              }
              if (!fa)
                return "swipe" !== g
                  ? void Wb()
                  : void (!$ && s > f.currItem.fitRatio && Tb(R));
            }
        },
        Sb = function() {
          var a,
            b,
            c = {
              lastFlickOffset: {},
              lastFlickDist: {},
              lastFlickSpeed: {},
              slowDownRatio: {},
              slowDownRatioReverse: {},
              speedDecelerationRatio: {},
              speedDecelerationRatioAbs: {},
              distanceOffset: {},
              backAnimDestination: {},
              backAnimStarted: {},
              calculateSwipeSpeed: function(d) {
                ob.length > 1
                  ? ((a = Ea() - Q + 50), (b = ob[ob.length - 2][d]))
                  : ((a = Ea() - P), (b = lb[d])),
                  (c.lastFlickOffset[d] = kb[d] - b),
                  (c.lastFlickDist[d] = Math.abs(c.lastFlickOffset[d])),
                  c.lastFlickDist[d] > 20
                    ? (c.lastFlickSpeed[d] = c.lastFlickOffset[d] / a)
                    : (c.lastFlickSpeed[d] = 0),
                  Math.abs(c.lastFlickSpeed[d]) < 0.1 &&
                    (c.lastFlickSpeed[d] = 0),
                  (c.slowDownRatio[d] = 0.95),
                  (c.slowDownRatioReverse[d] = 1 - c.slowDownRatio[d]),
                  (c.speedDecelerationRatio[d] = 1);
              },
              calculateOverBoundsAnimOffset: function(a, b) {
                c.backAnimStarted[a] ||
                  (pa[a] > da.min[a]
                    ? (c.backAnimDestination[a] = da.min[a])
                    : pa[a] < da.max[a] &&
                      (c.backAnimDestination[a] = da.max[a]),
                  void 0 !== c.backAnimDestination[a] &&
                    ((c.slowDownRatio[a] = 0.7),
                    (c.slowDownRatioReverse[a] = 1 - c.slowDownRatio[a]),
                    c.speedDecelerationRatioAbs[a] < 0.05 &&
                      ((c.lastFlickSpeed[a] = 0),
                      (c.backAnimStarted[a] = !0),
                      db(
                        "bounceZoomPan" + a,
                        pa[a],
                        c.backAnimDestination[a],
                        b || 300,
                        e.easing.sine.out,
                        function(b) {
                          (pa[a] = b), Ha();
                        }
                      ))));
              },
              calculateAnimOffset: function(a) {
                c.backAnimStarted[a] ||
                  ((c.speedDecelerationRatio[a] =
                    c.speedDecelerationRatio[a] *
                    (c.slowDownRatio[a] +
                      c.slowDownRatioReverse[a] -
                      (c.slowDownRatioReverse[a] * c.timeDiff) / 10)),
                  (c.speedDecelerationRatioAbs[a] = Math.abs(
                    c.lastFlickSpeed[a] * c.speedDecelerationRatio[a]
                  )),
                  (c.distanceOffset[a] =
                    c.lastFlickSpeed[a] *
                    c.speedDecelerationRatio[a] *
                    c.timeDiff),
                  (pa[a] += c.distanceOffset[a]));
              },
              panAnimLoop: function() {
                if (
                  $a.zoomPan &&
                  (($a.zoomPan.raf = H(c.panAnimLoop)),
                  (c.now = Ea()),
                  (c.timeDiff = c.now - c.lastNow),
                  (c.lastNow = c.now),
                  c.calculateAnimOffset("x"),
                  c.calculateAnimOffset("y"),
                  Ha(),
                  c.calculateOverBoundsAnimOffset("x"),
                  c.calculateOverBoundsAnimOffset("y"),
                  c.speedDecelerationRatioAbs.x < 0.05 &&
                    c.speedDecelerationRatioAbs.y < 0.05)
                )
                  return (
                    (pa.x = Math.round(pa.x)),
                    (pa.y = Math.round(pa.y)),
                    Ha(),
                    void ab("zoomPan")
                  );
              }
            };
          return c;
        },
        Tb = function(a) {
          return (
            a.calculateSwipeSpeed("y"),
            (da = f.currItem.bounds),
            (a.backAnimDestination = {}),
            (a.backAnimStarted = {}),
            Math.abs(a.lastFlickSpeed.x) <= 0.05 &&
            Math.abs(a.lastFlickSpeed.y) <= 0.05
              ? ((a.speedDecelerationRatioAbs.x = a.speedDecelerationRatioAbs.y = 0),
                a.calculateOverBoundsAnimOffset("x"),
                a.calculateOverBoundsAnimOffset("y"),
                !0)
              : (bb("zoomPan"), (a.lastNow = Ea()), void a.panAnimLoop())
          );
        },
        Ub = function(a, b) {
          var c;
          fa || (qb = m);
          var d;
          if ("swipe" === a) {
            var g = kb.x - lb.x,
              h = b.lastFlickDist.x < 10;
            g > fb && (h || b.lastFlickOffset.x > 20)
              ? (d = -1)
              : g < -fb && (h || b.lastFlickOffset.x < -20) && (d = 1);
          }
          var j;
          d &&
            ((m += d),
            m < 0
              ? ((m = i.loop ? ac() - 1 : 0), (j = !0))
              : m >= ac() && ((m = i.loop ? 0 : ac() - 1), (j = !0)),
            (j && !i.loop) || ((ua += d), (ra -= d), (c = !0)));
          var k,
            l = ta.x * ra,
            n = Math.abs(l - tb.x);
          return (
            c || l > tb.x == b.lastFlickSpeed.x > 0
              ? ((k =
                  Math.abs(b.lastFlickSpeed.x) > 0
                    ? n / Math.abs(b.lastFlickSpeed.x)
                    : 333),
                (k = Math.min(k, 400)),
                (k = Math.max(k, 250)))
              : (k = 333),
            qb === m && (c = !1),
            (fa = !0),
            Da("mainScrollAnimStart"),
            db("mainScroll", tb.x, l, k, e.easing.cubic.out, Ka, function() {
              cb(),
                (fa = !1),
                (qb = -1),
                (c || qb !== m) && f.updateCurrItem(),
                Da("mainScrollAnimComplete");
            }),
            c && f.updateCurrItem(!0),
            c
          );
        },
        Vb = function(a) {
          return (1 / ca) * a * t;
        },
        Wb = function() {
          var a = s,
            b = Ta(),
            c = Ua();
          s < b ? (a = b) : s > c && (a = c);
          var d,
            g = 1,
            h = ja;
          return ia && !S && !ka && s < b
            ? (f.close(), !0)
            : (ia &&
                (d = function(a) {
                  Fa((g - h) * a + h);
                }),
              f.zoomTo(a, 0, 200, e.easing.cubic.out, d),
              !0);
        };
      za("Gestures", {
        publicMethods: {
          initGestures: function() {
            var a = function(a, b, c, d, e) {
              (A = a + b), (B = a + c), (C = a + d), (D = e ? a + e : "");
            };
            (F = N.pointerEvent),
              F && N.touch && (N.touch = !1),
              F
                ? navigator.pointerEnabled
                  ? a("pointer", "down", "move", "up", "cancel")
                  : a("MSPointer", "Down", "Move", "Up", "Cancel")
                : N.touch
                ? (a("touch", "start", "move", "end", "cancel"), (G = !0))
                : a("mouse", "down", "move", "up"),
              (p = B + " " + C + " " + D),
              (q = A),
              F &&
                !G &&
                (G =
                  navigator.maxTouchPoints > 1 ||
                  navigator.msMaxTouchPoints > 1),
              (f.likelyTouchDevice = G),
              (r[A] = Ob),
              (r[B] = Pb),
              (r[C] = Rb),
              D && (r[D] = r[C]),
              N.touch &&
                ((q += " mousedown"),
                (p += " mousemove mouseup"),
                (r.mousedown = r[A]),
                (r.mousemove = r[B]),
                (r.mouseup = r[C])),
              G || (i.allowPanToNext = !1);
          }
        }
      });
      var Xb,
        Yb,
        Zb,
        $b,
        _b,
        ac,
        bc,
        cc = function(b, c, d, g) {
          Xb && clearTimeout(Xb), ($b = !0), (Zb = !0);
          var h;
          b.initialLayout
            ? ((h = b.initialLayout), (b.initialLayout = null))
            : (h = i.getThumbBoundsFn && i.getThumbBoundsFn(m));
          var j = d ? i.hideAnimationDuration : i.showAnimationDuration,
            k = function() {
              ab("initialZoom"),
                d
                  ? (f.template.removeAttribute("style"),
                    f.bg.removeAttribute("style"))
                  : (Fa(1),
                    c && (c.style.display = "block"),
                    e.addClass(a, "pswp--animated-in"),
                    Da("initialZoom" + (d ? "OutEnd" : "InEnd"))),
                g && g(),
                ($b = !1);
            };
          if (!j || !h || void 0 === h.x)
            return (
              Da("initialZoom" + (d ? "Out" : "In")),
              (s = b.initialZoomLevel),
              Ma(pa, b.initialPosition),
              Ha(),
              (a.style.opacity = d ? 0 : 1),
              Fa(1),
              void (j
                ? setTimeout(function() {
                    k();
                  }, j)
                : k())
            );
          var n = function() {
            var c = l,
              g = !f.currItem.src || f.currItem.loadError || i.showHideOpacity;
            b.miniImg && (b.miniImg.style.webkitBackfaceVisibility = "hidden"),
              d ||
                ((s = h.w / b.w),
                (pa.x = h.x),
                (pa.y = h.y - K),
                (f[g ? "template" : "bg"].style.opacity = 0.001),
                Ha()),
              bb("initialZoom"),
              d && !c && e.removeClass(a, "pswp--animated-in"),
              g &&
                (d
                  ? e[(c ? "remove" : "add") + "Class"](
                      a,
                      "pswp--animate_opacity"
                    )
                  : setTimeout(function() {
                      e.addClass(a, "pswp--animate_opacity");
                    }, 30)),
              (Xb = setTimeout(
                function() {
                  if ((Da("initialZoom" + (d ? "Out" : "In")), d)) {
                    var f = h.w / b.w,
                      i = { x: pa.x, y: pa.y },
                      l = s,
                      m = ja,
                      n = function(b) {
                        1 === b
                          ? ((s = f), (pa.x = h.x), (pa.y = h.y - M))
                          : ((s = (f - l) * b + l),
                            (pa.x = (h.x - i.x) * b + i.x),
                            (pa.y = (h.y - M - i.y) * b + i.y)),
                          Ha(),
                          g ? (a.style.opacity = 1 - b) : Fa(m - b * m);
                      };
                    c
                      ? db("initialZoom", 0, 1, j, e.easing.cubic.out, n, k)
                      : (n(1), (Xb = setTimeout(k, j + 20)));
                  } else
                    (s = b.initialZoomLevel),
                      Ma(pa, b.initialPosition),
                      Ha(),
                      Fa(1),
                      g ? (a.style.opacity = 1) : Fa(1),
                      (Xb = setTimeout(k, j + 20));
                },
                d ? 25 : 90
              ));
          };
          n();
        },
        dc = {},
        ec = [],
        fc = {
          index: 0,
          errorMsg:
            '<div class="pswp__error-msg"><a href="%url%" target="_blank">The image</a> could not be loaded.</div>',
          forceProgressiveLoading: !1,
          preload: [1, 1],
          getNumItemsFn: function() {
            return Yb.length;
          }
        },
        gc = function() {
          return {
            center: { x: 0, y: 0 },
            max: { x: 0, y: 0 },
            min: { x: 0, y: 0 }
          };
        },
        hc = function(a, b, c) {
          var d = a.bounds;
          (d.center.x = Math.round((dc.x - b) / 2)),
            (d.center.y = Math.round((dc.y - c) / 2) + a.vGap.top),
            (d.max.x = b > dc.x ? Math.round(dc.x - b) : d.center.x),
            (d.max.y =
              c > dc.y ? Math.round(dc.y - c) + a.vGap.top : d.center.y),
            (d.min.x = b > dc.x ? 0 : d.center.x),
            (d.min.y = c > dc.y ? a.vGap.top : d.center.y);
        },
        ic = function(a, b, c) {
          if (a.src && !a.loadError) {
            var d = !c;
            if (
              (d &&
                (a.vGap || (a.vGap = { top: 0, bottom: 0 }),
                Da("parseVerticalMargin", a)),
              (dc.x = b.x),
              (dc.y = b.y - a.vGap.top - a.vGap.bottom),
              d)
            ) {
              var e = dc.x / a.w,
                f = dc.y / a.h;
              a.fitRatio = e < f ? e : f;
              var g = i.scaleMode;
              "orig" === g ? (c = 1) : "fit" === g && (c = a.fitRatio),
                c > 1 && (c = 1),
                (a.initialZoomLevel = c),
                a.bounds || (a.bounds = gc());
            }
            if (!c) return;
            return (
              hc(a, a.w * c, a.h * c),
              d &&
                c === a.initialZoomLevel &&
                (a.initialPosition = a.bounds.center),
              a.bounds
            );
          }
          return (
            (a.w = a.h = 0),
            (a.initialZoomLevel = a.fitRatio = 1),
            (a.bounds = gc()),
            (a.initialPosition = a.bounds.center),
            a.bounds
          );
        },
        jc = function(a, b, c, d, e, g) {
          b.loadError ||
            (d &&
              ((b.imageAppended = !0),
              mc(b, d, b === f.currItem && ya),
              c.appendChild(d),
              g &&
                setTimeout(function() {
                  b &&
                    b.loaded &&
                    b.placeholder &&
                    ((b.placeholder.style.display = "none"),
                    (b.placeholder = null));
                }, 500)));
        },
        kc = function(a) {
          (a.loading = !0), (a.loaded = !1);
          var b = (a.img = e.createEl("pswp__img", "img")),
            c = function() {
              (a.loading = !1),
                (a.loaded = !0),
                a.loadComplete ? a.loadComplete(a) : (a.img = null),
                (b.onload = b.onerror = null),
                (b = null);
            };
          return (
            (b.onload = c),
            (b.onerror = function() {
              (a.loadError = !0), c();
            }),
            (b.src = a.src),
            b
          );
        },
        lc = function(a, b) {
          if (a.src && a.loadError && a.container)
            return (
              b && (a.container.innerHTML = ""),
              (a.container.innerHTML = i.errorMsg.replace("%url%", a.src)),
              !0
            );
        },
        mc = function(a, b, c) {
          if (a.src) {
            b || (b = a.container.lastChild);
            var d = c ? a.w : Math.round(a.w * a.fitRatio),
              e = c ? a.h : Math.round(a.h * a.fitRatio);
            a.placeholder &&
              !a.loaded &&
              ((a.placeholder.style.width = d + "px"),
              (a.placeholder.style.height = e + "px")),
              (b.style.width = d + "px"),
              (b.style.height = e + "px");
          }
        },
        nc = function() {
          if (ec.length) {
            for (var a, b = 0; b < ec.length; b++)
              (a = ec[b]),
                a.holder.index === a.index &&
                  jc(a.index, a.item, a.baseDiv, a.img, !1, a.clearPlaceholder);
            ec = [];
          }
        };
      za("Controller", {
        publicMethods: {
          lazyLoadItem: function(a) {
            a = Aa(a);
            var b = _b(a);
            b &&
              ((!b.loaded && !b.loading) || x) &&
              (Da("gettingData", a, b), b.src && kc(b));
          },
          initController: function() {
            e.extend(i, fc, !0),
              (f.items = Yb = c),
              (_b = f.getItemAt),
              (ac = i.getNumItemsFn),
              (bc = i.loop),
              ac() < 3 && (i.loop = !1),
              Ca("beforeChange", function(a) {
                var b,
                  c = i.preload,
                  d = null === a || a >= 0,
                  e = Math.min(c[0], ac()),
                  g = Math.min(c[1], ac());
                for (b = 1; b <= (d ? g : e); b++) f.lazyLoadItem(m + b);
                for (b = 1; b <= (d ? e : g); b++) f.lazyLoadItem(m - b);
              }),
              Ca("initialLayout", function() {
                f.currItem.initialLayout =
                  i.getThumbBoundsFn && i.getThumbBoundsFn(m);
              }),
              Ca("mainScrollAnimComplete", nc),
              Ca("initialZoomInEnd", nc),
              Ca("destroy", function() {
                for (var a, b = 0; b < Yb.length; b++)
                  (a = Yb[b]),
                    a.container && (a.container = null),
                    a.placeholder && (a.placeholder = null),
                    a.img && (a.img = null),
                    a.preloader && (a.preloader = null),
                    a.loadError && (a.loaded = a.loadError = !1);
                ec = null;
              });
          },
          getItemAt: function(a) {
            return a >= 0 && void 0 !== Yb[a] && Yb[a];
          },
          allowProgressiveImg: function() {
            return (
              i.forceProgressiveLoading ||
              !G ||
              i.mouseUsed ||
              screen.width > 1200
            );
          },
          setContent: function(a, b) {
            i.loop && (b = Aa(b));
            var c = f.getItemAt(a.index);
            c && (c.container = null);
            var d,
              g = f.getItemAt(b);
            if (!g) return void (a.el.innerHTML = "");
            Da("gettingData", b, g), (a.index = b), (a.item = g);
            var h = (g.container = e.createEl("pswp__zoom-wrap"));
            if (
              (!g.src &&
                g.html &&
                (g.html.tagName
                  ? h.appendChild(g.html)
                  : (h.innerHTML = g.html)),
              lc(g),
              ic(g, qa),
              !g.src || g.loadError || g.loaded)
            )
              g.src &&
                !g.loadError &&
                ((d = e.createEl("pswp__img", "img")),
                (d.style.opacity = 1),
                (d.src = g.src),
                mc(g, d),
                jc(b, g, h, d, !0));
            else {
              if (
                ((g.loadComplete = function(c) {
                  if (j) {
                    if (a && a.index === b) {
                      if (lc(c, !0))
                        return (
                          (c.loadComplete = c.img = null),
                          ic(c, qa),
                          Ia(c),
                          void (a.index === m && f.updateCurrZoomItem())
                        );
                      c.imageAppended
                        ? !$b &&
                          c.placeholder &&
                          ((c.placeholder.style.display = "none"),
                          (c.placeholder = null))
                        : N.transform && (fa || $b)
                        ? ec.push({
                            item: c,
                            baseDiv: h,
                            img: c.img,
                            index: b,
                            holder: a,
                            clearPlaceholder: !0
                          })
                        : jc(b, c, h, c.img, fa || $b, !0);
                    }
                    (c.loadComplete = null),
                      (c.img = null),
                      Da("imageLoadComplete", b, c);
                  }
                }),
                e.features.transform)
              ) {
                var k = "pswp__img pswp__img--placeholder";
                k += g.msrc ? "" : " pswp__img--placeholder--blank";
                var l = e.createEl(k, g.msrc ? "img" : "");
                g.msrc && (l.src = g.msrc),
                  mc(g, l),
                  h.appendChild(l),
                  (g.placeholder = l);
              }
              g.loading || kc(g),
                f.allowProgressiveImg() &&
                  (!Zb && N.transform
                    ? ec.push({
                        item: g,
                        baseDiv: h,
                        img: g.img,
                        index: b,
                        holder: a
                      })
                    : jc(b, g, h, g.img, !0, !0));
            }
            Zb || b !== m ? Ia(g) : ((ea = h.style), cc(g, d || g.img)),
              (a.el.innerHTML = ""),
              a.el.appendChild(h);
          },
          cleanSlide: function(a) {
            a.img && (a.img.onload = a.img.onerror = null),
              (a.loaded = a.loading = a.img = a.imageAppended = !1);
          }
        }
      });
      var oc,
        pc = {},
        qc = function(a, b, c) {
          var d = document.createEvent("CustomEvent"),
            e = {
              origEvent: a,
              target: a.target,
              releasePoint: b,
              pointerType: c || "touch"
            };
          d.initCustomEvent("pswpTap", !0, !0, e), a.target.dispatchEvent(d);
        };
      za("Tap", {
        publicMethods: {
          initTap: function() {
            Ca("firstTouchStart", f.onTapStart),
              Ca("touchRelease", f.onTapRelease),
              Ca("destroy", function() {
                (pc = {}), (oc = null);
              });
          },
          onTapStart: function(a) {
            a.length > 1 && (clearTimeout(oc), (oc = null));
          },
          onTapRelease: function(a, b) {
            if (b && !Y && !W && !_a) {
              var c = b;
              if (oc && (clearTimeout(oc), (oc = null), xb(c, pc)))
                return void Da("doubleTap", c);
              if ("mouse" === b.type) return void qc(a, b, "mouse");
              var d = a.target.tagName.toUpperCase();
              if ("BUTTON" === d || e.hasClass(a.target, "pswp__single-tap"))
                return void qc(a, b);
              Ma(pc, c),
                (oc = setTimeout(function() {
                  qc(a, b), (oc = null);
                }, 300));
            }
          }
        }
      });
      var rc;
      za("DesktopZoom", {
        publicMethods: {
          initDesktopZoom: function() {
            L ||
              (G
                ? Ca("mouseUsed", function() {
                    f.setupDesktopZoom();
                  })
                : f.setupDesktopZoom(!0));
          },
          setupDesktopZoom: function(b) {
            rc = {};
            var c = "wheel mousewheel DOMMouseScroll";
            Ca("bindEvents", function() {
              e.bind(a, c, f.handleMouseWheel);
            }),
              Ca("unbindEvents", function() {
                rc && e.unbind(a, c, f.handleMouseWheel);
              }),
              (f.mouseZoomedIn = !1);
            var d,
              g = function() {
                f.mouseZoomedIn &&
                  (e.removeClass(a, "pswp--zoomed-in"), (f.mouseZoomedIn = !1)),
                  s < 1
                    ? e.addClass(a, "pswp--zoom-allowed")
                    : e.removeClass(a, "pswp--zoom-allowed"),
                  h();
              },
              h = function() {
                d && (e.removeClass(a, "pswp--dragging"), (d = !1));
              };
            Ca("resize", g),
              Ca("afterChange", g),
              Ca("pointerDown", function() {
                f.mouseZoomedIn && ((d = !0), e.addClass(a, "pswp--dragging"));
              }),
              Ca("pointerUp", h),
              b || g();
          },
          handleMouseWheel: function(a) {
            if (s <= f.currItem.fitRatio)
              return (
                i.modal &&
                  (!i.closeOnScroll || _a || V
                    ? a.preventDefault()
                    : E && Math.abs(a.deltaY) > 2 && ((l = !0), f.close())),
                !0
              );
            if ((a.stopPropagation(), (rc.x = 0), "deltaX" in a))
              1 === a.deltaMode
                ? ((rc.x = 18 * a.deltaX), (rc.y = 18 * a.deltaY))
                : ((rc.x = a.deltaX), (rc.y = a.deltaY));
            else if ("wheelDelta" in a)
              a.wheelDeltaX && (rc.x = -0.16 * a.wheelDeltaX),
                a.wheelDeltaY
                  ? (rc.y = -0.16 * a.wheelDeltaY)
                  : (rc.y = -0.16 * a.wheelDelta);
            else {
              if (!("detail" in a)) return;
              rc.y = a.detail;
            }
            Sa(s, !0);
            var b = pa.x - rc.x,
              c = pa.y - rc.y;
            (i.modal ||
              (b <= da.min.x &&
                b >= da.max.x &&
                c <= da.min.y &&
                c >= da.max.y)) &&
              a.preventDefault(),
              f.panTo(b, c);
          },
          toggleDesktopZoom: function(b) {
            b = b || { x: qa.x / 2 + sa.x, y: qa.y / 2 + sa.y };
            var c = i.getDoubleTapZoom(!0, f.currItem),
              d = s === c;
            (f.mouseZoomedIn = !d),
              f.zoomTo(d ? f.currItem.initialZoomLevel : c, b, 333),
              e[(d ? "remove" : "add") + "Class"](a, "pswp--zoomed-in");
          }
        }
      });
      var sc,
        tc,
        uc,
        vc,
        wc,
        xc,
        yc,
        zc,
        Ac,
        Bc,
        Cc,
        Dc,
        Ec = { history: !0, galleryUID: 1 },
        Fc = function() {
          return Cc.hash.substring(1);
        },
        Gc = function() {
          sc && clearTimeout(sc), uc && clearTimeout(uc);
        },
        Hc = function() {
          var a = Fc(),
            b = {};
          if (a.length < 5) return b;
          var c,
            d = a.split("&");
          for (c = 0; c < d.length; c++)
            if (d[c]) {
              var e = d[c].split("=");
              e.length < 2 || (b[e[0]] = e[1]);
            }
          if (i.galleryPIDs) {
            var f = b.pid;
            for (b.pid = 0, c = 0; c < Yb.length; c++)
              if (Yb[c].pid === f) {
                b.pid = c;
                break;
              }
          } else b.pid = parseInt(b.pid, 10) - 1;
          return b.pid < 0 && (b.pid = 0), b;
        },
        Ic = function() {
          if ((uc && clearTimeout(uc), _a || V))
            return void (uc = setTimeout(Ic, 500));
          vc ? clearTimeout(tc) : (vc = !0);
          var a = m + 1,
            b = _b(m);
          b.hasOwnProperty("pid") && (a = b.pid);
          var c = yc + "&gid=" + i.galleryUID + "&pid=" + a;
          zc || (Cc.hash.indexOf(c) === -1 && (Bc = !0));
          var d = Cc.href.split("#")[0] + "#" + c;
          Dc
            ? "#" + c !== window.location.hash &&
              history[zc ? "replaceState" : "pushState"]("", document.title, d)
            : zc
            ? Cc.replace(d)
            : (Cc.hash = c),
            (zc = !0),
            (tc = setTimeout(function() {
              vc = !1;
            }, 60));
        };
      za("History", {
        publicMethods: {
          initHistory: function() {
            if ((e.extend(i, Ec, !0), i.history)) {
              (Cc = window.location),
                (Bc = !1),
                (Ac = !1),
                (zc = !1),
                (yc = Fc()),
                (Dc = "pushState" in history),
                yc.indexOf("gid=") > -1 &&
                  ((yc = yc.split("&gid=")[0]), (yc = yc.split("?gid=")[0])),
                Ca("afterChange", f.updateURL),
                Ca("unbindEvents", function() {
                  e.unbind(window, "hashchange", f.onHashChange);
                });
              var a = function() {
                (xc = !0),
                  Ac ||
                    (Bc
                      ? history.back()
                      : yc
                      ? (Cc.hash = yc)
                      : Dc
                      ? history.pushState(
                          "",
                          document.title,
                          Cc.pathname + Cc.search
                        )
                      : (Cc.hash = "")),
                  Gc();
              };
              Ca("unbindEvents", function() {
                l && a();
              }),
                Ca("destroy", function() {
                  xc || a();
                }),
                Ca("firstUpdate", function() {
                  m = Hc().pid;
                });
              var b = yc.indexOf("pid=");
              b > -1 &&
                ((yc = yc.substring(0, b)),
                "&" === yc.slice(-1) && (yc = yc.slice(0, -1))),
                setTimeout(function() {
                  j && e.bind(window, "hashchange", f.onHashChange);
                }, 40);
            }
          },
          onHashChange: function() {
            return Fc() === yc
              ? ((Ac = !0), void f.close())
              : void (vc || ((wc = !0), f.goTo(Hc().pid), (wc = !1)));
          },
          updateURL: function() {
            Gc(), wc || (zc ? (sc = setTimeout(Ic, 800)) : Ic());
          }
        }
      }),
        e.extend(f, eb);
    };
    return a;
  }),
  !(function(a, b) {
    "function" == typeof define && define.amd
      ? define(b)
      : "object" == typeof exports
      ? (module.exports = b())
      : (a.PhotoSwipeUI_Default = b());
  })(this, function() {
    "use strict";
    var a = function(a, b) {
      var c,
        d,
        e,
        f,
        g,
        h,
        i,
        j,
        k,
        l,
        m,
        n,
        o,
        p,
        q,
        r,
        s,
        t,
        u,
        v = this,
        w = !1,
        x = !0,
        y = !0,
        z = {
          barsSize: { top: 44, bottom: "auto" },
          closeElClasses: ["item", "caption", "zoom-wrap", "ui", "top-bar"],
          timeToIdle: 4e3,
          timeToIdleOutside: 1e3,
          loadingIndicatorDelay: 1e3,
          addCaptionHTMLFn: function(a, b) {
            return a.title
              ? ((b.children[0].innerHTML = a.title), !0)
              : ((b.children[0].innerHTML = ""), !1);
          },
          closeEl: !0,
          captionEl: !0,
          fullscreenEl: !0,
          zoomEl: !0,
          shareEl: !0,
          counterEl: !0,
          arrowEl: !0,
          preloaderEl: !0,
          tapToClose: !1,
          tapToToggleControls: !0,
          clickToCloseNonZoomable: !0,
          shareButtons: [
            {
              id: "facebook",
              label: "Share on Facebook",
              url: "https://www.facebook.com/sharer/sharer.php?u={{url}}"
            },
            {
              id: "twitter",
              label: "Tweet",
              url: "https://twitter.com/intent/tweet?text={{text}}&url={{url}}"
            },
            {
              id: "pinterest",
              label: "Pin it",
              url:
                "http://www.pinterest.com/pin/create/button/?url={{url}}&media={{image_url}}&description={{text}}"
            },
            {
              id: "download",
              label: "Download image",
              url: "{{raw_image_url}}",
              download: !0
            }
          ],
          getImageURLForShare: function() {
            return a.currItem.src || "";
          },
          getPageURLForShare: function() {
            return window.location.href;
          },
          getTextForShare: function() {
            return a.currItem.title || "";
          },
          indexIndicatorSep: " / ",
          fitControlsWidth: 1200
        },
        A = function(a) {
          if (r) return !0;
          (a = a || window.event), q.timeToIdle && q.mouseUsed && !k && K();
          for (
            var c,
              d,
              e = a.target || a.srcElement,
              f = e.getAttribute("class") || "",
              g = 0;
            g < S.length;
            g++
          )
            (c = S[g]),
              c.onTap &&
                f.indexOf("pswp__" + c.name) > -1 &&
                (c.onTap(), (d = !0));
          if (d) {
            a.stopPropagation && a.stopPropagation(), (r = !0);
            var h = b.features.isOldAndroid ? 600 : 30;
            s = setTimeout(function() {
              r = !1;
            }, h);
          }
        },
        B = function() {
          return (
            !a.likelyTouchDevice ||
            q.mouseUsed ||
            screen.width > q.fitControlsWidth
          );
        },
        C = function(a, c, d) {
          b[(d ? "add" : "remove") + "Class"](a, "pswp__" + c);
        },
        D = function() {
          var a = 1 === q.getNumItemsFn();
          a !== p && (C(d, "ui--one-slide", a), (p = a));
        },
        E = function() {
          C(i, "share-modal--hidden", y);
        },
        F = function() {
          return (
            (y = !y),
            y
              ? (b.removeClass(i, "pswp__share-modal--fade-in"),
                setTimeout(function() {
                  y && E();
                }, 300))
              : (E(),
                setTimeout(function() {
                  y || b.addClass(i, "pswp__share-modal--fade-in");
                }, 30)),
            y || H(),
            !1
          );
        },
        G = function(b) {
          b = b || window.event;
          var c = b.target || b.srcElement;
          return (
            a.shout("shareLinkClick", b, c),
            !(
              !c.href ||
              (!c.hasAttribute("download") &&
                (window.open(
                  c.href,
                  "pswp_share",
                  "scrollbars=yes,resizable=yes,toolbar=no,location=yes,width=550,height=420,top=100,left=" +
                    (window.screen ? Math.round(screen.width / 2 - 275) : 100)
                ),
                y || F(),
                1))
            )
          );
        },
        H = function() {
          for (var a, b, c, d, e, f = "", g = 0; g < q.shareButtons.length; g++)
            (a = q.shareButtons[g]),
              (c = q.getImageURLForShare(a)),
              (d = q.getPageURLForShare(a)),
              (e = q.getTextForShare(a)),
              (b = a.url
                .replace("{{url}}", encodeURIComponent(d))
                .replace("{{image_url}}", encodeURIComponent(c))
                .replace("{{raw_image_url}}", c)
                .replace("{{text}}", encodeURIComponent(e))),
              (f +=
                '<a href="' +
                b +
                '" target="_blank" class="pswp__share--' +
                a.id +
                '"' +
                (a.download ? "download" : "") +
                ">" +
                a.label +
                "</a>"),
              q.parseShareButtonOut && (f = q.parseShareButtonOut(a, f));
          (i.children[0].innerHTML = f), (i.children[0].onclick = G);
        },
        I = function(a) {
          for (var c = 0; c < q.closeElClasses.length; c++)
            if (b.hasClass(a, "pswp__" + q.closeElClasses[c])) return !0;
        },
        J = 0,
        K = function() {
          clearTimeout(u), (J = 0), k && v.setIdle(!1);
        },
        L = function(a) {
          a = a ? a : window.event;
          var b = a.relatedTarget || a.toElement;
          (b && "HTML" !== b.nodeName) ||
            (clearTimeout(u),
            (u = setTimeout(function() {
              v.setIdle(!0);
            }, q.timeToIdleOutside)));
        },
        M = function() {
          q.fullscreenEl &&
            !b.features.isOldAndroid &&
            (c || (c = v.getFullscreenAPI()),
            c
              ? (b.bind(document, c.eventK, v.updateFullscreen),
                v.updateFullscreen(),
                b.addClass(a.template, "pswp--supports-fs"))
              : b.removeClass(a.template, "pswp--supports-fs"));
        },
        N = function() {
          q.preloaderEl &&
            (O(!0),
            l("beforeChange", function() {
              clearTimeout(o),
                (o = setTimeout(function() {
                  a.currItem && a.currItem.loading
                    ? (!a.allowProgressiveImg() ||
                        (a.currItem.img && !a.currItem.img.naturalWidth)) &&
                      O(!1)
                    : O(!0);
                }, q.loadingIndicatorDelay));
            }),
            l("imageLoadComplete", function(b, c) {
              a.currItem === c && O(!0);
            }));
        },
        O = function(a) {
          n !== a && (C(m, "preloader--active", !a), (n = a));
        },
        P = function(a) {
          var c = a.vGap;
          if (B()) {
            var g = q.barsSize;
            if (q.captionEl && "auto" === g.bottom)
              if (
                (f ||
                  ((f = b.createEl("pswp__caption pswp__caption--fake")),
                  f.appendChild(b.createEl("pswp__caption__center")),
                  d.insertBefore(f, e),
                  b.addClass(d, "pswp__ui--fit")),
                q.addCaptionHTMLFn(a, f, !0))
              ) {
                var h = f.clientHeight;
                c.bottom = parseInt(h, 10) || 44;
              } else c.bottom = g.top;
            else c.bottom = "auto" === g.bottom ? 0 : g.bottom;
            c.top = g.top;
          } else c.top = c.bottom = 0;
        },
        Q = function() {
          q.timeToIdle &&
            l("mouseUsed", function() {
              b.bind(document, "mousemove", K),
                b.bind(document, "mouseout", L),
                (t = setInterval(function() {
                  J++, 2 === J && v.setIdle(!0);
                }, q.timeToIdle / 2));
            });
        },
        R = function() {
          l("onVerticalDrag", function(a) {
            x && a < 0.95
              ? v.hideControls()
              : !x && a >= 0.95 && v.showControls();
          });
          var a;
          l("onPinchClose", function(b) {
            x && b < 0.9
              ? (v.hideControls(), (a = !0))
              : a && !x && b > 0.9 && v.showControls();
          }),
            l("zoomGestureEnded", function() {
              (a = !1), a && !x && v.showControls();
            });
        },
        S = [
          {
            name: "caption",
            option: "captionEl",
            onInit: function(a) {
              e = a;
            }
          },
          {
            name: "share-modal",
            option: "shareEl",
            onInit: function(a) {
              i = a;
            },
            onTap: function() {
              F();
            }
          },
          {
            name: "button--share",
            option: "shareEl",
            onInit: function(a) {
              h = a;
            },
            onTap: function() {
              F();
            }
          },
          {
            name: "button--zoom",
            option: "zoomEl",
            onTap: a.toggleDesktopZoom
          },
          {
            name: "counter",
            option: "counterEl",
            onInit: function(a) {
              g = a;
            }
          },
          { name: "button--close", option: "closeEl", onTap: a.close },
          { name: "button--arrow--left", option: "arrowEl", onTap: a.prev },
          { name: "button--arrow--right", option: "arrowEl", onTap: a.next },
          {
            name: "button--fs",
            option: "fullscreenEl",
            onTap: function() {
              c.isFullscreen() ? c.exit() : c.enter();
            }
          },
          {
            name: "preloader",
            option: "preloaderEl",
            onInit: function(a) {
              m = a;
            }
          }
        ],
        T = function() {
          var a,
            c,
            e,
            f = function(d) {
              if (d)
                for (var f = d.length, g = 0; g < f; g++) {
                  (a = d[g]), (c = a.className);
                  for (var h = 0; h < S.length; h++)
                    (e = S[h]),
                      c.indexOf("pswp__" + e.name) > -1 &&
                        (q[e.option]
                          ? (b.removeClass(a, "pswp__element--disabled"),
                            e.onInit && e.onInit(a))
                          : b.addClass(a, "pswp__element--disabled"));
                }
            };
          f(d.children);
          var g = b.getChildByClass(d, "pswp__top-bar");
          g && f(g.children);
        };
      (v.init = function() {
        b.extend(a.options, z, !0),
          (q = a.options),
          (d = b.getChildByClass(a.scrollWrap, "pswp__ui")),
          (l = a.listen),
          R(),
          l("beforeChange", v.update),
          l("doubleTap", function(b) {
            var c = a.currItem.initialZoomLevel;
            a.getZoomLevel() !== c
              ? a.zoomTo(c, b, 333)
              : a.zoomTo(q.getDoubleTapZoom(!1, a.currItem), b, 333);
          }),
          l("preventDragEvent", function(a, b, c) {
            var d = a.target || a.srcElement;
            d &&
              d.getAttribute("class") &&
              a.type.indexOf("mouse") > -1 &&
              (d.getAttribute("class").indexOf("__caption") > 0 ||
                /(SMALL|STRONG|EM)/i.test(d.tagName)) &&
              (c.prevent = !1);
          }),
          l("bindEvents", function() {
            b.bind(d, "pswpTap click", A),
              b.bind(a.scrollWrap, "pswpTap", v.onGlobalTap),
              a.likelyTouchDevice ||
                b.bind(a.scrollWrap, "mouseover", v.onMouseOver);
          }),
          l("unbindEvents", function() {
            y || F(),
              t && clearInterval(t),
              b.unbind(document, "mouseout", L),
              b.unbind(document, "mousemove", K),
              b.unbind(d, "pswpTap click", A),
              b.unbind(a.scrollWrap, "pswpTap", v.onGlobalTap),
              b.unbind(a.scrollWrap, "mouseover", v.onMouseOver),
              c &&
                (b.unbind(document, c.eventK, v.updateFullscreen),
                c.isFullscreen() && ((q.hideAnimationDuration = 0), c.exit()),
                (c = null));
          }),
          l("destroy", function() {
            q.captionEl &&
              (f && d.removeChild(f), b.removeClass(e, "pswp__caption--empty")),
              i && (i.children[0].onclick = null),
              b.removeClass(d, "pswp__ui--over-close"),
              b.addClass(d, "pswp__ui--hidden"),
              v.setIdle(!1);
          }),
          q.showAnimationDuration || b.removeClass(d, "pswp__ui--hidden"),
          l("initialZoomIn", function() {
            q.showAnimationDuration && b.removeClass(d, "pswp__ui--hidden");
          }),
          l("initialZoomOut", function() {
            b.addClass(d, "pswp__ui--hidden");
          }),
          l("parseVerticalMargin", P),
          T(),
          q.shareEl && h && i && (y = !0),
          D(),
          Q(),
          M(),
          N();
      }),
        (v.setIdle = function(a) {
          (k = a), C(d, "ui--idle", a);
        }),
        (v.update = function() {
          x && a.currItem
            ? (v.updateIndexIndicator(),
              q.captionEl &&
                (q.addCaptionHTMLFn(a.currItem, e),
                C(e, "caption--empty", !a.currItem.title)),
              (w = !0))
            : (w = !1),
            y || F(),
            D();
        }),
        (v.updateFullscreen = function(d) {
          d &&
            setTimeout(function() {
              a.setScrollOffset(0, b.getScrollY());
            }, 50),
            b[(c.isFullscreen() ? "add" : "remove") + "Class"](
              a.template,
              "pswp--fs"
            );
        }),
        (v.updateIndexIndicator = function() {
          q.counterEl &&
            (g.innerHTML =
              a.getCurrentIndex() +
              1 +
              q.indexIndicatorSep +
              q.getNumItemsFn());
        }),
        (v.onGlobalTap = function(c) {
          c = c || window.event;
          var d = c.target || c.srcElement;
          if (!r)
            if (c.detail && "mouse" === c.detail.pointerType) {
              if (I(d)) return void a.close();
              b.hasClass(d, "pswp__img") &&
                (1 === a.getZoomLevel() &&
                a.getZoomLevel() <= a.currItem.fitRatio
                  ? q.clickToCloseNonZoomable && a.close()
                  : a.toggleDesktopZoom(c.detail.releasePoint));
            } else if (
              (q.tapToToggleControls &&
                (x ? v.hideControls() : v.showControls()),
              q.tapToClose && (b.hasClass(d, "pswp__img") || I(d)))
            )
              return void a.close();
        }),
        (v.onMouseOver = function(a) {
          a = a || window.event;
          var b = a.target || a.srcElement;
          C(d, "ui--over-close", I(b));
        }),
        (v.hideControls = function() {
          b.addClass(d, "pswp__ui--hidden"), (x = !1);
        }),
        (v.showControls = function() {
          (x = !0), w || v.update(), b.removeClass(d, "pswp__ui--hidden");
        }),
        (v.supportsFullscreen = function() {
          var a = document;
          return !!(
            a.exitFullscreen ||
            a.mozCancelFullScreen ||
            a.webkitExitFullscreen ||
            a.msExitFullscreen
          );
        }),
        (v.getFullscreenAPI = function() {
          var b,
            c = document.documentElement,
            d = "fullscreenchange";
          return (
            c.requestFullscreen
              ? (b = {
                  enterK: "requestFullscreen",
                  exitK: "exitFullscreen",
                  elementK: "fullscreenElement",
                  eventK: d
                })
              : c.mozRequestFullScreen
              ? (b = {
                  enterK: "mozRequestFullScreen",
                  exitK: "mozCancelFullScreen",
                  elementK: "mozFullScreenElement",
                  eventK: "moz" + d
                })
              : c.webkitRequestFullscreen
              ? (b = {
                  enterK: "webkitRequestFullscreen",
                  exitK: "webkitExitFullscreen",
                  elementK: "webkitFullscreenElement",
                  eventK: "webkit" + d
                })
              : c.msRequestFullscreen &&
                (b = {
                  enterK: "msRequestFullscreen",
                  exitK: "msExitFullscreen",
                  elementK: "msFullscreenElement",
                  eventK: "MSFullscreenChange"
                }),
            b &&
              ((b.enter = function() {
                return (
                  (j = q.closeOnScroll),
                  (q.closeOnScroll = !1),
                  "webkitRequestFullscreen" !== this.enterK
                    ? a.template[this.enterK]()
                    : void a.template[this.enterK](Element.ALLOW_KEYBOARD_INPUT)
                );
              }),
              (b.exit = function() {
                return (q.closeOnScroll = j), document[this.exitK]();
              }),
              (b.isFullscreen = function() {
                return document[this.elementK];
              })),
            b
          );
        });
    };
    return a;
  }),
  jQuery(document).ready(function(a) {
    a(".twentytwenty-container").length > 0 &&
      (a.fn.twentytwenty = function(b) {
        var b = a.extend(
          {
            default_offset_pct: 0.5,
            orientation: "horizontal",
            navigation_follow: !1
          },
          b
        );
        return this.each(function() {
          var c = b.default_offset_pct,
            d = a(this),
            e = b.orientation,
            f = "vertical" === e ? "down" : "left",
            g = "vertical" === e ? "up" : "right",
            h = b.navigation_follow;
          d.wrap(
            "<div class='twentytwenty-wrapper twentytwenty-" + e + "'></div>"
          );
          var i = d.find("img:first"),
            j = d.find("img:last"),
            k = i.attr("title"),
            l = j.attr("title");
          d.append("<div class='twentytwenty-handle'></div>");
          var m = d.find(".twentytwenty-handle");
          m.append("<span class='twentytwenty-" + f + "-arrow'></span>"),
            m.append("<span class='twentytwenty-" + g + "-arrow'></span>"),
            d.addClass("twentytwenty-container"),
            i.addClass("twentytwenty-before"),
            j.addClass("twentytwenty-after"),
            "undefined" != typeof k &&
              k &&
              k.length > 0 &&
              d.append(
                "<div class='twentytwenty-before-label'>" + k + "</div>"
              ),
            "undefined" != typeof l &&
              l &&
              l.length > 0 &&
              d.append("<div class='twentytwenty-after-label'>" + l + "</div>");
          var n = function(a) {
              var b = i.width(),
                c = i.height();
              return {
                w: b + "px",
                h: c + "px",
                cw: a * b + "px",
                ch: a * c + "px"
              };
            },
            o = function(a) {
              "vertical" === e
                ? i.css("clip", "rect(0," + a.w + "," + a.ch + ",0)")
                : i.css("clip", "rect(0," + a.cw + "," + a.h + ",0)"),
                d.css("height", a.h);
            },
            p = function(a) {
              var b = n(a);
              m.css(
                "vertical" === e ? "top" : "left",
                "vertical" === e ? b.ch : b.cw
              ),
                o(b);
            };
          a(window).on("resize.twentytwenty", function(a) {
            p(c);
          });
          var q = 0,
            r = 0;
          m.on("movestart", function(a) {
            ((a.distX > a.distY && a.distX < -a.distY) ||
              (a.distX < a.distY && a.distX > -a.distY)) &&
            "vertical" !== e
              ? a.preventDefault()
              : ((a.distX < a.distY && a.distX < -a.distY) ||
                  (a.distX > a.distY && a.distX > -a.distY)) &&
                "vertical" === e &&
                a.preventDefault(),
              d.addClass("active"),
              d.removeClass("active-click"),
              (q = d.offset().left),
              (offsetY = d.offset().top),
              (r = i.width()),
              (imgHeight = i.height());
          }),
            m.on("moveend", function(a) {
              d.removeClass("active");
            }),
            m.on("move", function(a) {
              d.hasClass("active") &&
                ((c =
                  "vertical" === e
                    ? (a.pageY - offsetY) / imgHeight
                    : (a.pageX - q) / r),
                c < 0 && (c = 0),
                c > 1 && (c = 1),
                p(c));
            }),
            h ||
              d.hasClass("active") ||
              (d.on("mouseup", function(a) {
                d.removeClass("active-click");
              }),
              d.on("mousedown", function(a) {
                d.addClass("active-click"),
                  (q = d.offset().left),
                  (offsetY = d.offset().top),
                  (r = i.width()),
                  (imgHeight = i.height()),
                  (c =
                    "vertical" === e
                      ? (a.pageY - offsetY) / imgHeight
                      : (a.pageX - q) / r),
                  c < 0 && (c = 0),
                  c > 1 && (c = 1),
                  p(c);
              })),
            d.find("img").on("mousedown", function(a) {
              a.preventDefault();
            }),
            h &&
              (d.on("mouseenter", function(a) {
                d.addClass("active"),
                  (q = d.offset().left),
                  (offsetY = d.offset().top),
                  (r = i.width()),
                  (imgHeight = i.height());
              }),
              d.on("mouseleave", function(a) {
                d.removeClass("active");
              }),
              d.on("mousemove", function(a) {
                d.hasClass("active") &&
                  ((c =
                    "vertical" === e
                      ? (a.pageY - offsetY) / imgHeight
                      : (a.pageX - q) / r),
                  c < 0 && (c = 0),
                  c > 1 && (c = 1),
                  p(c));
              })),
            a(window).trigger("resize.twentytwenty");
        });
      });
  }),
  jQuery(document).ready(function(a) {
    "ontouchstart" in window ||
      !(
        "on" == dtLocal.themeSettings.smoothScroll ||
        ("on_parallax" == dtLocal.themeSettings.smoothScroll &&
          a(".stripe-parallax-bg").length > 0)
      ) ||
      a("body").css({ "scroll-behavior": "smooth" });
  }),
  jQuery(document).ready(function(a) {
    var b = a(window),
      c = b.height();
    b.resize(function() {
      c = b.height();
    }),
      (a.fn.parallax = function(d, e, f) {
        function g() {
          var b = dtGlobals.winScrollTop;
          k.each(function() {
            var f = a(this),
              g = f.offset().top,
              i = h(f);
            g + i < b ||
              g > b + c ||
              k.css(
                "backgroundPosition",
                d + " " + Math.round((g - b) * e) + "px"
              );
          });
        }
        var h,
          i,
          j,
          k = a(this);
        k.each(function() {
          i = k.offset().top;
        }),
          (h = f
            ? function(a) {
                return a.outerHeight(!0);
              }
            : function(a) {
                return a.height();
              }),
          (arguments.length < 1 || null === d) && (d = "50%"),
          (arguments.length < 2 || null === e) && (e = 0.1),
          (arguments.length < 3 || null === f) && (f = !0),
          b
            .bind("scroll", g)
            .resize(function() {
              g();
            })
            .bind("debouncedresize", function() {
              clearTimeout(j),
                (j = setTimeout(function() {
                  g();
                }, 20));
            }),
          g();
      });
  }),
  (function(a) {
    "undefined" != typeof module && module.exports
      ? (module.exports = a)
      : a(jQuery, window, document);
  })(function(a) {
    !(function(a) {
      !(function(a) {
        "function" == typeof define && define.amd
          ? define(["jquery"], a)
          : "object" == typeof exports
          ? (module.exports = a)
          : a(jQuery);
      })(function(a) {
        function b(b) {
          var g = b || window.event,
            h = i.call(arguments, 1),
            j = 0,
            l = 0,
            m = 0,
            n = 0,
            o = 0,
            p = 0;
          if (
            ((b = a.event.fix(g)),
            (b.type = "mousewheel"),
            "detail" in g && (m = -1 * g.detail),
            "wheelDelta" in g && (m = g.wheelDelta),
            "wheelDeltaY" in g && (m = g.wheelDeltaY),
            "wheelDeltaX" in g && (l = -1 * g.wheelDeltaX),
            "axis" in g &&
              g.axis === g.HORIZONTAL_AXIS &&
              ((l = -1 * m), (m = 0)),
            (j = 0 === m ? l : m),
            "deltaY" in g && ((m = -1 * g.deltaY), (j = m)),
            "deltaX" in g && ((l = g.deltaX), 0 === m && (j = -1 * l)),
            0 !== m || 0 !== l)
          ) {
            if (1 === g.deltaMode) {
              var q = a.data(this, "mousewheel-line-height");
              (j *= q), (m *= q), (l *= q);
            } else if (2 === g.deltaMode) {
              var r = a.data(this, "mousewheel-page-height");
              (j *= r), (m *= r), (l *= r);
            }
            if (
              ((n = Math.max(Math.abs(m), Math.abs(l))),
              (!f || f > n) && ((f = n), d(g, n) && (f /= 40)),
              d(g, n) && ((j /= 40), (l /= 40), (m /= 40)),
              (j = Math[j >= 1 ? "floor" : "ceil"](j / f)),
              (l = Math[l >= 1 ? "floor" : "ceil"](l / f)),
              (m = Math[m >= 1 ? "floor" : "ceil"](m / f)),
              k.settings.normalizeOffset && this.getBoundingClientRect)
            ) {
              var s = this.getBoundingClientRect();
              (o = b.clientX - s.left), (p = b.clientY - s.top);
            }
            return (
              (b.deltaX = l),
              (b.deltaY = m),
              (b.deltaFactor = f),
              (b.offsetX = o),
              (b.offsetY = p),
              (b.deltaMode = 0),
              h.unshift(b, j, l, m),
              e && clearTimeout(e),
              (e = setTimeout(c, 200)),
              (a.event.dispatch || a.event.handle).apply(this, h)
            );
          }
        }
        function c() {
          f = null;
        }
        function d(a, b) {
          return (
            k.settings.adjustOldDeltas &&
            "mousewheel" === a.type &&
            b % 120 === 0
          );
        }
        var e,
          f,
          g = ["wheel", "mousewheel", "DOMMouseScroll", "MozMousePixelScroll"],
          h =
            "onwheel" in document || document.documentMode >= 9
              ? ["wheel"]
              : ["mousewheel", "DomMouseScroll", "MozMousePixelScroll"],
          i = Array.prototype.slice;
        if (a.event.fixHooks)
          for (var j = g.length; j; )
            a.event.fixHooks[g[--j]] = a.event.mouseHooks;
        var k = (a.event.special.mousewheel = {
          version: "3.1.12",
          setup: function() {
            if (this.addEventListener)
              for (var c = h.length; c; ) this.addEventListener(h[--c], b, !1);
            else this.onmousewheel = b;
            a.data(this, "mousewheel-line-height", k.getLineHeight(this)),
              a.data(this, "mousewheel-page-height", k.getPageHeight(this));
          },
          teardown: function() {
            if (this.removeEventListener)
              for (var c = h.length; c; )
                this.removeEventListener(h[--c], b, !1);
            else this.onmousewheel = null;
            a.removeData(this, "mousewheel-line-height"),
              a.removeData(this, "mousewheel-page-height");
          },
          getLineHeight: function(b) {
            var c = a(b),
              d = c["offsetParent" in a.fn ? "offsetParent" : "parent"]();
            return (
              d.length || (d = a("body")),
              parseInt(d.css("fontSize"), 10) ||
                parseInt(c.css("fontSize"), 10) ||
                16
            );
          },
          getPageHeight: function(b) {
            return a(b).height();
          },
          settings: { adjustOldDeltas: !0, normalizeOffset: !0 }
        });
        a.fn.extend({
          mousewheel: function(a) {
            return a ? this.bind("mousewheel", a) : this.trigger("mousewheel");
          },
          unmousewheel: function(a) {
            return this.unbind("mousewheel", a);
          }
        });
      }),
        a();
    })(function() {
      var b,
        c = "mCustomScrollbar",
        d = "mCS",
        e = ".mCustomScrollbar",
        f = {
          setTop: 0,
          setLeft: 0,
          axis: "y",
          scrollbarPosition: "inside",
          scrollInertia: 950,
          autoDraggerLength: !0,
          alwaysShowScrollbar: 0,
          snapOffset: 0,
          mouseWheel: {
            enable: !0,
            scrollAmount: "auto",
            axis: "y",
            deltaFactor: "auto",
            disableOver: ["select", "option", "keygen", "datalist", "textarea"]
          },
          scrollButtons: { scrollType: "stepless", scrollAmount: "auto" },
          keyboard: {
            enable: !0,
            scrollType: "stepless",
            scrollAmount: "auto"
          },
          contentTouchScroll: 25,
          advanced: {
            autoScrollOnFocus:
              "input,textarea,select,button,datalist,keygen,a[tabindex],area,object,[contenteditable='true']",
            updateOnContentResize: !0,
            updateOnImageLoad: !0,
            autoUpdateTimeout: 60
          },
          theme: "light",
          callbacks: {
            onTotalScrollOffset: 0,
            onTotalScrollBackOffset: 0,
            alwaysTriggerOffsets: !0
          }
        },
        g = 0,
        h = {},
        i = window.attachEvent && !window.addEventListener ? 1 : 0,
        j = !1,
        k = [
          "mCSB_dragger_onDrag",
          "mCSB_scrollTools_onDrag",
          "mCS_img_loaded",
          "mCS_disabled",
          "mCS_destroyed",
          "mCS_no_scrollbar",
          "mCS-autoHide",
          "mCS-dir-rtl",
          "mCS_no_scrollbar_y",
          "mCS_no_scrollbar_x",
          "mCS_y_hidden",
          "mCS_x_hidden",
          "mCSB_draggerContainer",
          "mCSB_buttonUp",
          "mCSB_buttonDown",
          "mCSB_buttonLeft",
          "mCSB_buttonRight"
        ],
        l = {
          init: function(b) {
            var b = a.extend(!0, {}, f, b),
              c = m.call(this);
            if (b.live) {
              var i = b.liveSelector || this.selector || e,
                j = a(i);
              if ("off" === b.live) return void o(i);
              h[i] = setTimeout(function() {
                j.mCustomScrollbar(b), "once" === b.live && j.length && o(i);
              }, 500);
            } else o(i);
            return (
              (b.setWidth = b.set_width ? b.set_width : b.setWidth),
              (b.setHeight = b.set_height ? b.set_height : b.setHeight),
              (b.axis = b.horizontalScroll ? "x" : p(b.axis)),
              (b.scrollInertia =
                b.scrollInertia > 0 && b.scrollInertia < 17
                  ? 17
                  : b.scrollInertia),
              "object" != typeof b.mouseWheel &&
                1 == b.mouseWheel &&
                (b.mouseWheel = {
                  enable: !0,
                  scrollAmount: "auto",
                  axis: "y",
                  preventDefault: !1,
                  deltaFactor: "auto",
                  normalizeDelta: !1,
                  invert: !1
                }),
              (b.mouseWheel.scrollAmount = b.mouseWheelPixels
                ? b.mouseWheelPixels
                : b.mouseWheel.scrollAmount),
              (b.mouseWheel.normalizeDelta = b.advanced.normalizeMouseWheelDelta
                ? b.advanced.normalizeMouseWheelDelta
                : b.mouseWheel.normalizeDelta),
              (b.scrollButtons.scrollType = q(b.scrollButtons.scrollType)),
              n(b),
              a(c).each(function() {
                var c = a(this);
                if (!c.data(d)) {
                  c.data(d, {
                    idx: ++g,
                    opt: b,
                    scrollRatio: { y: null, x: null },
                    overflowed: null,
                    contentReset: { y: null, x: null },
                    bindEvents: !1,
                    tweenRunning: !1,
                    sequential: {},
                    langDir: c.css("direction"),
                    cbOffsets: null,
                    trigger: null
                  });
                  var e = c.data(d),
                    f = e.opt,
                    h = c.data("mcs-axis"),
                    i = c.data("mcs-scrollbar-position"),
                    j = c.data("mcs-theme");
                  h && (f.axis = h),
                    i && (f.scrollbarPosition = i),
                    j && ((f.theme = j), n(f)),
                    r.call(this),
                    a(
                      "#mCSB_" + e.idx + "_container img:not(." + k[2] + ")"
                    ).addClass(k[2]),
                    l.update.call(null, c);
                }
              })
            );
          },
          update: function(b, c) {
            var e = b || m.call(this);
            return a(e).each(function() {
              var b = a(this);
              if (b.data(d)) {
                var e = b.data(d),
                  f = e.opt,
                  g = a("#mCSB_" + e.idx + "_container"),
                  h = [
                    a("#mCSB_" + e.idx + "_dragger_vertical"),
                    a("#mCSB_" + e.idx + "_dragger_horizontal")
                  ];
                if (!g.length) return;
                e.tweenRunning && V(b),
                  b.hasClass(k[3]) && b.removeClass(k[3]),
                  b.hasClass(k[4]) && b.removeClass(k[4]),
                  v.call(this),
                  t.call(this),
                  "y" === f.axis ||
                    f.advanced.autoExpandHorizontalScroll ||
                    g.css("width", s(g.children())),
                  (e.overflowed = z.call(this)),
                  D.call(this),
                  f.autoDraggerLength && w.call(this),
                  x.call(this),
                  B.call(this);
                var i = [Math.abs(g[0].offsetTop), Math.abs(g[0].offsetLeft)];
                "x" !== f.axis &&
                  (e.overflowed[0]
                    ? h[0].height() > h[0].parent().height()
                      ? A.call(this)
                      : (W(b, i[0].toString(), {
                          dir: "y",
                          dur: 0,
                          overwrite: "none"
                        }),
                        (e.contentReset.y = null))
                    : (A.call(this),
                      "y" === f.axis
                        ? C.call(this)
                        : "yx" === f.axis &&
                          e.overflowed[1] &&
                          W(b, i[1].toString(), {
                            dir: "x",
                            dur: 0,
                            overwrite: "none"
                          }))),
                  "y" !== f.axis &&
                    (e.overflowed[1]
                      ? h[1].width() > h[1].parent().width()
                        ? A.call(this)
                        : (W(b, i[1].toString(), {
                            dir: "x",
                            dur: 0,
                            overwrite: "none"
                          }),
                          (e.contentReset.x = null))
                      : (A.call(this),
                        "x" === f.axis
                          ? C.call(this)
                          : "yx" === f.axis &&
                            e.overflowed[0] &&
                            W(b, i[0].toString(), {
                              dir: "y",
                              dur: 0,
                              overwrite: "none"
                            }))),
                  c &&
                    e &&
                    (2 === c &&
                    f.callbacks.onImageLoad &&
                    "function" == typeof f.callbacks.onImageLoad
                      ? f.callbacks.onImageLoad.call(this)
                      : 3 === c &&
                        f.callbacks.onSelectorChange &&
                        "function" == typeof f.callbacks.onSelectorChange
                      ? f.callbacks.onSelectorChange.call(this)
                      : f.callbacks.onUpdate &&
                        "function" == typeof f.callbacks.onUpdate &&
                        f.callbacks.onUpdate.call(this)),
                  T.call(this);
              }
            });
          },
          scrollTo: function(b, c) {
            if ("undefined" != typeof b && null != b) {
              var e = m.call(this);
              return a(e).each(function() {
                var e = a(this);
                if (e.data(d)) {
                  var f = e.data(d),
                    g = f.opt,
                    h = {
                      trigger: "external",
                      scrollInertia: g.scrollInertia,
                      scrollEasing: "mcsEaseInOut",
                      moveDragger: !1,
                      timeout: 60,
                      callbacks: !0,
                      onStart: !0,
                      onUpdate: !0,
                      onComplete: !0
                    },
                    i = a.extend(!0, {}, h, c),
                    j = R.call(this, b),
                    k =
                      i.scrollInertia > 0 && i.scrollInertia < 17
                        ? 17
                        : i.scrollInertia;
                  (j[0] = S.call(this, j[0], "y")),
                    (j[1] = S.call(this, j[1], "x")),
                    i.moveDragger &&
                      ((j[0] *= f.scrollRatio.y), (j[1] *= f.scrollRatio.x)),
                    (i.dur = k),
                    setTimeout(function() {
                      null !== j[0] &&
                        "undefined" != typeof j[0] &&
                        "x" !== g.axis &&
                        f.overflowed[0] &&
                        ((i.dir = "y"),
                        (i.overwrite = "all"),
                        W(e, j[0].toString(), i)),
                        null !== j[1] &&
                          "undefined" != typeof j[1] &&
                          "y" !== g.axis &&
                          f.overflowed[1] &&
                          ((i.dir = "x"),
                          (i.overwrite = "none"),
                          W(e, j[1].toString(), i));
                    }, i.timeout);
                }
              });
            }
          },
          stop: function() {
            var b = m.call(this);
            return a(b).each(function() {
              var b = a(this);
              b.data(d) && V(b);
            });
          },
          disable: function(b) {
            var c = m.call(this);
            return a(c).each(function() {
              var c = a(this);
              if (c.data(d)) {
                c.data(d);
                T.call(this, "remove"),
                  C.call(this),
                  b && A.call(this),
                  D.call(this, !0),
                  c.addClass(k[3]);
              }
            });
          },
          destroy: function() {
            var b = m.call(this);
            return a(b).each(function() {
              var e = a(this);
              if (e.data(d)) {
                var f = e.data(d),
                  g = f.opt,
                  h = a("#mCSB_" + f.idx),
                  i = a("#mCSB_" + f.idx + "_container"),
                  j = a(".mCSB_" + f.idx + "_scrollbar");
                g.live && o(g.liveSelector || a(b).selector),
                  T.call(this, "remove"),
                  C.call(this),
                  A.call(this),
                  e.removeData(d),
                  $(this, "mcs"),
                  j.remove(),
                  i.find("img." + k[2]).removeClass(k[2]),
                  h.replaceWith(i.contents()),
                  e
                    .removeClass(
                      c +
                        " _" +
                        d +
                        "_" +
                        f.idx +
                        " " +
                        k[6] +
                        " " +
                        k[7] +
                        " " +
                        k[5] +
                        " " +
                        k[3]
                    )
                    .addClass(k[4]);
              }
            });
          }
        },
        m = function() {
          return "object" != typeof a(this) || a(this).length < 1 ? e : this;
        },
        n = function(b) {
          var c = [
              "rounded",
              "rounded-dark",
              "rounded-dots",
              "rounded-dots-dark"
            ],
            d = [
              "rounded-dots",
              "rounded-dots-dark",
              "3d",
              "3d-dark",
              "3d-thick",
              "3d-thick-dark",
              "inset",
              "inset-dark",
              "inset-2",
              "inset-2-dark",
              "inset-3",
              "inset-3-dark"
            ],
            e = ["minimal", "minimal-dark"],
            f = ["minimal", "minimal-dark"],
            g = ["minimal", "minimal-dark"];
          (b.autoDraggerLength =
            !(a.inArray(b.theme, c) > -1) && b.autoDraggerLength),
            (b.autoExpandScrollbar =
              !(a.inArray(b.theme, d) > -1) && b.autoExpandScrollbar),
            (b.scrollButtons.enable =
              !(a.inArray(b.theme, e) > -1) && b.scrollButtons.enable),
            (b.autoHideScrollbar =
              a.inArray(b.theme, f) > -1 || b.autoHideScrollbar),
            (b.scrollbarPosition =
              a.inArray(b.theme, g) > -1 ? "outside" : b.scrollbarPosition);
        },
        o = function(a) {
          h[a] && (clearTimeout(h[a]), $(h, a));
        },
        p = function(a) {
          return "yx" === a || "xy" === a || "auto" === a
            ? "yx"
            : "x" === a || "horizontal" === a
            ? "x"
            : "y";
        },
        q = function(a) {
          return "stepped" === a ||
            "pixels" === a ||
            "step" === a ||
            "click" === a
            ? "stepped"
            : "stepless";
        },
        r = function() {
          var b = a(this),
            e = b.data(d),
            f = e.opt,
            g = f.autoExpandScrollbar ? " " + k[1] + "_expand" : "",
            h = [
              "<div id='mCSB_" +
                e.idx +
                "_scrollbar_vertical' class='mCSB_scrollTools mCSB_" +
                e.idx +
                "_scrollbar mCS-" +
                f.theme +
                " mCSB_scrollTools_vertical" +
                g +
                "'><div class='" +
                k[12] +
                "'><div id='mCSB_" +
                e.idx +
                "_dragger_vertical' class='mCSB_dragger' style='position:absolute;' oncontextmenu='return false;'><div class='mCSB_dragger_bar' /></div><div class='mCSB_draggerRail' /></div></div>",
              "<div id='mCSB_" +
                e.idx +
                "_scrollbar_horizontal' class='mCSB_scrollTools mCSB_" +
                e.idx +
                "_scrollbar mCS-" +
                f.theme +
                " mCSB_scrollTools_horizontal" +
                g +
                "'><div class='" +
                k[12] +
                "'><div id='mCSB_" +
                e.idx +
                "_dragger_horizontal' class='mCSB_dragger' style='position:absolute;' oncontextmenu='return false;'><div class='mCSB_dragger_bar' /></div><div class='mCSB_draggerRail' /></div></div>"
            ],
            i =
              "yx" === f.axis
                ? "mCSB_vertical_horizontal"
                : "x" === f.axis
                ? "mCSB_horizontal"
                : "mCSB_vertical",
            j = "yx" === f.axis ? h[0] + h[1] : "x" === f.axis ? h[1] : h[0],
            l =
              "yx" === f.axis
                ? "<div id='mCSB_" +
                  e.idx +
                  "_container_wrapper' class='mCSB_container_wrapper' />"
                : "",
            m = f.autoHideScrollbar ? " " + k[6] : "",
            n = "x" !== f.axis && "rtl" === e.langDir ? " " + k[7] : "";
          f.setWidth && b.css("width", f.setWidth),
            f.setHeight && b.css("height", f.setHeight),
            (f.setLeft =
              "y" !== f.axis && "rtl" === e.langDir ? "989999px" : f.setLeft),
            b
              .addClass(c + " _" + d + "_" + e.idx + m + n)
              .wrapInner(
                "<div id='mCSB_" +
                  e.idx +
                  "' class='mCustomScrollBox mCS-" +
                  f.theme +
                  " " +
                  i +
                  "'><div id='mCSB_" +
                  e.idx +
                  "_container' class='mCSB_container' style='position:relative; top:" +
                  f.setTop +
                  "; left:" +
                  f.setLeft +
                  ";' dir=" +
                  e.langDir +
                  " /></div>"
              );
          var o = a("#mCSB_" + e.idx),
            p = a("#mCSB_" + e.idx + "_container");
          "y" === f.axis ||
            f.advanced.autoExpandHorizontalScroll ||
            p.css("width", s(p.children())),
            "outside" === f.scrollbarPosition
              ? ("static" === b.css("position") &&
                  b.css("position", "relative"),
                b.css("overflow", "visible"),
                o.addClass("mCSB_outside").after(j))
              : (o.addClass("mCSB_inside").append(j), p.wrap(l)),
            u.call(this);
          var q = [
            a("#mCSB_" + e.idx + "_dragger_vertical"),
            a("#mCSB_" + e.idx + "_dragger_horizontal")
          ];
          q[0].css("min-height", q[0].height()),
            q[1].css("min-width", q[1].width());
        },
        s = function(b) {
          return Math.max.apply(
            Math,
            b
              .map(function() {
                return a(this).outerWidth(!0);
              })
              .get()
          );
        },
        t = function() {
          var b = a(this),
            c = b.data(d),
            e = c.opt,
            f = a("#mCSB_" + c.idx + "_container");
          e.advanced.autoExpandHorizontalScroll &&
            "y" !== e.axis &&
            f
              .css({ position: "absolute", width: "auto" })
              .wrap(
                "<div class='mCSB_h_wrapper' style='position:relative; left:0; width:999999px;' />"
              )
              .css({
                width:
                  Math.ceil(f[0].getBoundingClientRect().right + 0.4) -
                  Math.floor(f[0].getBoundingClientRect().left),
                position: "relative"
              })
              .unwrap();
        },
        u = function() {
          var b = a(this),
            c = b.data(d),
            e = c.opt,
            f = a(".mCSB_" + c.idx + "_scrollbar:first"),
            g = ba(e.scrollButtons.tabindex)
              ? "tabindex='" + e.scrollButtons.tabindex + "'"
              : "",
            h = [
              "<a href='#' class='" +
                k[13] +
                "' oncontextmenu='return false;' " +
                g +
                " />",
              "<a href='#' class='" +
                k[14] +
                "' oncontextmenu='return false;' " +
                g +
                " />",
              "<a href='#' class='" +
                k[15] +
                "' oncontextmenu='return false;' " +
                g +
                " />",
              "<a href='#' class='" +
                k[16] +
                "' oncontextmenu='return false;' " +
                g +
                " />"
            ],
            i = [
              "x" === e.axis ? h[2] : h[0],
              "x" === e.axis ? h[3] : h[1],
              h[2],
              h[3]
            ];
          e.scrollButtons.enable &&
            f
              .prepend(i[0])
              .append(i[1])
              .next(".mCSB_scrollTools")
              .prepend(i[2])
              .append(i[3]);
        },
        v = function() {
          var b = a(this),
            c = b.data(d),
            e = a("#mCSB_" + c.idx),
            f = b.css("max-height") || "none",
            g = f.indexOf("%") !== -1,
            h = b.css("box-sizing");
          if ("none" !== f) {
            var i = g ? (b.parent().height() * parseInt(f)) / 100 : parseInt(f);
            "border-box" === h &&
              (i -=
                b.innerHeight() -
                b.height() +
                (b.outerHeight() - b.innerHeight())),
              e.css("max-height", Math.round(i));
          }
        },
        w = function() {
          var b = a(this),
            c = b.data(d),
            e = a("#mCSB_" + c.idx),
            f = a("#mCSB_" + c.idx + "_container"),
            g = [
              a("#mCSB_" + c.idx + "_dragger_vertical"),
              a("#mCSB_" + c.idx + "_dragger_horizontal")
            ],
            h = [e.height() / f.outerHeight(!1), e.width() / f.outerWidth(!1)],
            j = [
              parseInt(g[0].css("min-height")),
              Math.round(h[0] * g[0].parent().height()),
              parseInt(g[1].css("min-width")),
              Math.round(h[1] * g[1].parent().width())
            ],
            k = i && j[1] < j[0] ? j[0] : j[1],
            l = i && j[3] < j[2] ? j[2] : j[3];
          g[0]
            .css({ height: k, "max-height": g[0].parent().height() - 10 })
            .find(".mCSB_dragger_bar")
            .css({ "line-height": j[0] + "px" }),
            g[1].css({ width: l, "max-width": g[1].parent().width() - 10 });
        },
        x = function() {
          var b = a(this),
            c = b.data(d),
            e = a("#mCSB_" + c.idx),
            f = a("#mCSB_" + c.idx + "_container"),
            g = [
              a("#mCSB_" + c.idx + "_dragger_vertical"),
              a("#mCSB_" + c.idx + "_dragger_horizontal")
            ],
            h = [f.outerHeight(!1) - e.height(), f.outerWidth(!1) - e.width()],
            i = [
              h[0] / (g[0].parent().height() - g[0].height()),
              h[1] / (g[1].parent().width() - g[1].width())
            ];
          c.scrollRatio = { y: i[0], x: i[1] };
        },
        y = function(a, b, c) {
          var d = c ? k[0] + "_expanded" : "",
            e = a.closest(".mCSB_scrollTools");
          "active" === b
            ? (a.toggleClass(k[0] + " " + d),
              e.toggleClass(k[1]),
              (a[0]._draggable = a[0]._draggable ? 0 : 1))
            : a[0]._draggable ||
              ("hide" === b
                ? (a.removeClass(k[0]), e.removeClass(k[1]))
                : (a.addClass(k[0]), e.addClass(k[1])));
        },
        z = function() {
          var b = a(this),
            c = b.data(d),
            e = a("#mCSB_" + c.idx),
            f = a("#mCSB_" + c.idx + "_container"),
            g = null == c.overflowed ? f.height() : f.outerHeight(!1),
            h = null == c.overflowed ? f.width() : f.outerWidth(!1);
          return [g > e.height(), h > e.width()];
        },
        A = function() {
          var b = a(this),
            c = b.data(d),
            e = c.opt,
            f = a("#mCSB_" + c.idx),
            g = a("#mCSB_" + c.idx + "_container"),
            h = [
              a("#mCSB_" + c.idx + "_dragger_vertical"),
              a("#mCSB_" + c.idx + "_dragger_horizontal")
            ];
          if (
            (V(b),
            (("x" !== e.axis && !c.overflowed[0]) ||
              ("y" === e.axis && c.overflowed[0])) &&
              (h[0].add(g).css("top", 0), W(b, "_resetY")),
            ("y" !== e.axis && !c.overflowed[1]) ||
              ("x" === e.axis && c.overflowed[1]))
          ) {
            var i = (dx = 0);
            "rtl" === c.langDir &&
              ((i = f.width() - g.outerWidth(!1)),
              (dx = Math.abs(i / c.scrollRatio.x))),
              g.css("left", i),
              h[1].css("left", dx),
              W(b, "_resetX");
          }
        },
        B = function() {
          function b() {
            g = setTimeout(function() {
              a.event.special.mousewheel
                ? (clearTimeout(g), I.call(c[0]))
                : b();
            }, 100);
          }
          var c = a(this),
            e = c.data(d),
            f = e.opt;
          if (!e.bindEvents) {
            if (
              (F.call(this),
              f.contentTouchScroll && G.call(this),
              H.call(this),
              f.mouseWheel.enable)
            ) {
              var g;
              b();
            }
            L.call(this),
              N.call(this),
              f.advanced.autoScrollOnFocus && M.call(this),
              f.scrollButtons.enable && O.call(this),
              f.keyboard.enable && P.call(this),
              (e.bindEvents = !0);
          }
        },
        C = function() {
          var b = a(this),
            c = b.data(d),
            e = c.opt,
            f = d + "_" + c.idx,
            g = ".mCSB_" + c.idx + "_scrollbar",
            h = a(
              "#mCSB_" +
                c.idx +
                ",#mCSB_" +
                c.idx +
                "_container,#mCSB_" +
                c.idx +
                "_container_wrapper," +
                g +
                " ." +
                k[12] +
                ",#mCSB_" +
                c.idx +
                "_dragger_vertical,#mCSB_" +
                c.idx +
                "_dragger_horizontal," +
                g +
                ">a"
            ),
            i = a("#mCSB_" + c.idx + "_container");
          e.advanced.releaseDraggableSelectors &&
            h.add(a(e.advanced.releaseDraggableSelectors)),
            c.bindEvents &&
              (a(document).unbind("." + f),
              h.each(function() {
                a(this).unbind("." + f);
              }),
              clearTimeout(b[0]._focusTimeout),
              $(b[0], "_focusTimeout"),
              clearTimeout(c.sequential.step),
              $(c.sequential, "step"),
              clearTimeout(i[0].onCompleteTimeout),
              $(i[0], "onCompleteTimeout"),
              (c.bindEvents = !1));
        },
        D = function(b) {
          var c = a(this),
            e = c.data(d),
            f = e.opt,
            g = a("#mCSB_" + e.idx + "_container_wrapper"),
            h = g.length ? g : a("#mCSB_" + e.idx + "_container"),
            i = [
              a("#mCSB_" + e.idx + "_scrollbar_vertical"),
              a("#mCSB_" + e.idx + "_scrollbar_horizontal")
            ],
            j = [i[0].find(".mCSB_dragger"), i[1].find(".mCSB_dragger")];
          "x" !== f.axis &&
            (e.overflowed[0] && !b
              ? (i[0]
                  .add(j[0])
                  .add(i[0].children("a"))
                  .css("display", "block"),
                h.removeClass(k[8] + " " + k[10]))
              : (f.alwaysShowScrollbar
                  ? (2 !== f.alwaysShowScrollbar && j[0].css("display", "none"),
                    h.removeClass(k[10]))
                  : (i[0].css("display", "none"), h.addClass(k[10])),
                h.addClass(k[8]))),
            "y" !== f.axis &&
              (e.overflowed[1] && !b
                ? (i[1]
                    .add(j[1])
                    .add(i[1].children("a"))
                    .css("display", "block"),
                  h.removeClass(k[9] + " " + k[11]))
                : (f.alwaysShowScrollbar
                    ? (2 !== f.alwaysShowScrollbar &&
                        j[1].css("display", "none"),
                      h.removeClass(k[11]))
                    : (i[1].css("display", "none"), h.addClass(k[11])),
                  h.addClass(k[9]))),
            e.overflowed[0] || e.overflowed[1]
              ? c.removeClass(k[5])
              : c.addClass(k[5]);
        },
        E = function(a) {
          var b = a.type;
          switch (b) {
            case "pointerdown":
            case "MSPointerDown":
            case "pointermove":
            case "MSPointerMove":
            case "pointerup":
            case "MSPointerUp":
              return a.target.ownerDocument !== document
                ? [a.originalEvent.screenY, a.originalEvent.screenX, !1]
                : [a.originalEvent.pageY, a.originalEvent.pageX, !1];
            case "touchstart":
            case "touchmove":
            case "touchend":
              var c =
                  a.originalEvent.touches[0] ||
                  a.originalEvent.changedTouches[0],
                d =
                  a.originalEvent.touches.length ||
                  a.originalEvent.changedTouches.length;
              return a.target.ownerDocument !== document
                ? [c.screenY, c.screenX, d > 1]
                : [c.pageY, c.pageX, d > 1];
            default:
              return [a.pageY, a.pageX, !1];
          }
        },
        F = function() {
          function b(a) {
            var b = o.find("iframe");
            if (b.length) {
              var c = a ? "auto" : "none";
              b.css("pointer-events", c);
            }
          }
          function c(a, b, c, d) {
            if (
              ((o[0].idleTimer = l.scrollInertia < 233 ? 250 : 0),
              e.attr("id") === n[1])
            )
              var f = "x",
                g = (e[0].offsetLeft - b + d) * k.scrollRatio.x;
            else
              var f = "y",
                g = (e[0].offsetTop - a + c) * k.scrollRatio.y;
            W(h, g.toString(), { dir: f, drag: !0 });
          }
          var e,
            f,
            g,
            h = a(this),
            k = h.data(d),
            l = k.opt,
            m = d + "_" + k.idx,
            n = [
              "mCSB_" + k.idx + "_dragger_vertical",
              "mCSB_" + k.idx + "_dragger_horizontal"
            ],
            o = a("#mCSB_" + k.idx + "_container"),
            p = a("#" + n[0] + ",#" + n[1]),
            q = l.advanced.releaseDraggableSelectors
              ? p.add(a(l.advanced.releaseDraggableSelectors))
              : p;
          p
            .bind(
              "mousedown." +
                m +
                " touchstart." +
                m +
                " pointerdown." +
                m +
                " MSPointerDown." +
                m,
              function(c) {
                if ((c.stopImmediatePropagation(), c.preventDefault(), _(c))) {
                  (j = !0),
                    i &&
                      (document.onselectstart = function() {
                        return !1;
                      }),
                    b(!1),
                    V(h),
                    (e = a(this));
                  var d = e.offset(),
                    k = E(c)[0] - d.top,
                    m = E(c)[1] - d.left,
                    n = e.height() + d.top,
                    o = e.width() + d.left;
                  k < n && k > 0 && m < o && m > 0 && ((f = k), (g = m)),
                    y(e, "active", l.autoExpandScrollbar);
                }
              }
            )
            .bind("touchmove." + m, function(a) {
              a.stopImmediatePropagation(), a.preventDefault();
              var b = e.offset(),
                d = E(a)[0] - b.top,
                h = E(a)[1] - b.left;
              c(f, g, d, h);
            }),
            a(document)
              .bind(
                "mousemove." + m + " pointermove." + m + " MSPointerMove." + m,
                function(a) {
                  if (e) {
                    var b = e.offset(),
                      d = E(a)[0] - b.top,
                      h = E(a)[1] - b.left;
                    if (f === d) return;
                    c(f, g, d, h);
                  }
                }
              )
              .add(q)
              .bind(
                "mouseup." +
                  m +
                  " touchend." +
                  m +
                  " pointerup." +
                  m +
                  " MSPointerUp." +
                  m,
                function(a) {
                  e && (y(e, "active", l.autoExpandScrollbar), (e = null)),
                    (j = !1),
                    i && (document.onselectstart = null),
                    b(!0);
                }
              );
        },
        G = function() {
          function c(a) {
            if (!aa(a) || j || E(a)[2]) return void (b = 0);
            (b = 1), (v = 0), (w = 0), x.removeClass("mCS_touch_action");
            var c = C.offset();
            (k = E(a)[0] - c.top),
              (l = E(a)[1] - c.left),
              (K = [E(a)[0], E(a)[1]]);
          }
          function e(a) {
            if (
              aa(a) &&
              !j &&
              !E(a)[2] &&
              (a.stopImmediatePropagation(), !w || v)
            ) {
              p = Y();
              var b = B.offset(),
                c = E(a)[0] - b.top,
                d = E(a)[1] - b.left,
                e = "mcsLinearOut";
              if (
                (F.push(c),
                G.push(d),
                (K[2] = Math.abs(E(a)[0] - K[0])),
                (K[3] = Math.abs(E(a)[1] - K[1])),
                y.overflowed[0])
              )
                var f = D[0].parent().height() - D[0].height(),
                  g =
                    k - c > 0 &&
                    c - k > -(f * y.scrollRatio.y) &&
                    (2 * K[3] < K[2] || "yx" === z.axis);
              if (y.overflowed[1])
                var h = D[1].parent().width() - D[1].width(),
                  m =
                    l - d > 0 &&
                    d - l > -(h * y.scrollRatio.x) &&
                    (2 * K[2] < K[3] || "yx" === z.axis);
              g || m
                ? (a.preventDefault(), (v = 1))
                : ((w = 1), x.addClass("mCS_touch_action")),
                (t =
                  "yx" === z.axis
                    ? [k - c, l - d]
                    : "x" === z.axis
                    ? [null, l - d]
                    : [k - c, null]),
                (C[0].idleTimer = 250),
                y.overflowed[0] && i(t[0], H, e, "y", "all", !0),
                y.overflowed[1] && i(t[1], H, e, "x", I, !0);
            }
          }
          function f(a) {
            if (!aa(a) || j || E(a)[2]) return void (b = 0);
            (b = 1), a.stopImmediatePropagation(), V(x), (o = Y());
            var c = B.offset();
            (m = E(a)[0] - c.top), (n = E(a)[1] - c.left), (F = []), (G = []);
          }
          function g(a) {
            if (aa(a) && !j && !E(a)[2]) {
              a.stopImmediatePropagation(), (v = 0), (w = 0), (q = Y());
              var b = B.offset(),
                c = E(a)[0] - b.top,
                d = E(a)[1] - b.left;
              if (!(q - p > 30)) {
                s = 1e3 / (q - o);
                var e = "mcsEaseOut",
                  f = s < 2.5,
                  g = f ? [F[F.length - 2], G[G.length - 2]] : [0, 0];
                r = f ? [c - g[0], d - g[1]] : [c - m, d - n];
                var k = [Math.abs(r[0]), Math.abs(r[1])];
                s = f ? [Math.abs(r[0] / 4), Math.abs(r[1] / 4)] : [s, s];
                var l = [
                  Math.abs(C[0].offsetTop) - r[0] * h(k[0] / s[0], s[0]),
                  Math.abs(C[0].offsetLeft) - r[1] * h(k[1] / s[1], s[1])
                ];
                (t =
                  "yx" === z.axis
                    ? [l[0], l[1]]
                    : "x" === z.axis
                    ? [null, l[1]]
                    : [l[0], null]),
                  (u = [
                    4 * k[0] + z.scrollInertia,
                    4 * k[1] + z.scrollInertia
                  ]);
                var x = parseInt(z.contentTouchScroll) || 0;
                (t[0] = k[0] > x ? t[0] : 0),
                  (t[1] = k[1] > x ? t[1] : 0),
                  y.overflowed[0] && i(t[0], u[0], e, "y", I, !1),
                  y.overflowed[1] && i(t[1], u[1], e, "x", I, !1);
              }
            }
          }
          function h(a, b) {
            var c = [1.5 * b, 2 * b, b / 1.5, b / 2];
            return a > 90
              ? b > 4
                ? c[0]
                : c[3]
              : a > 60
              ? b > 3
                ? c[3]
                : c[2]
              : a > 30
              ? b > 8
                ? c[1]
                : b > 6
                ? c[0]
                : b > 4
                ? b
                : c[2]
              : b > 8
              ? b
              : c[3];
          }
          function i(a, b, c, d, e, f) {
            a &&
              W(x, a.toString(), {
                dur: b,
                scrollEasing: c,
                dir: d,
                overwrite: e,
                drag: f
              });
          }
          var k,
            l,
            m,
            n,
            o,
            p,
            q,
            r,
            s,
            t,
            u,
            v,
            w,
            x = a(this),
            y = x.data(d),
            z = y.opt,
            A = d + "_" + y.idx,
            B = a("#mCSB_" + y.idx),
            C = a("#mCSB_" + y.idx + "_container"),
            D = [
              a("#mCSB_" + y.idx + "_dragger_vertical"),
              a("#mCSB_" + y.idx + "_dragger_horizontal")
            ],
            F = [],
            G = [],
            H = 0,
            I = "yx" === z.axis ? "none" : "all",
            K = [],
            L = C.find("iframe"),
            M = [
              "touchstart." + A + " pointerdown." + A + " MSPointerDown." + A,
              "touchmove." + A + " pointermove." + A + " MSPointerMove." + A,
              "touchend." + A + " pointerup." + A + " MSPointerUp." + A
            ];
          C.bind(M[0], function(a) {
            c(a);
          }).bind(M[1], function(a) {
            e(a);
          }),
            B.bind(M[0], function(a) {
              f(a);
            }).bind(M[2], function(a) {
              g(a);
            }),
            L.length &&
              L.each(function() {
                a(this).load(function() {
                  J(this) &&
                    a(this.contentDocument || this.contentWindow.document)
                      .bind(M[0], function(a) {
                        c(a), f(a);
                      })
                      .bind(M[1], function(a) {
                        e(a);
                      })
                      .bind(M[2], function(a) {
                        g(a);
                      });
                });
              });
        },
        H = function() {
          function c() {
            return window.getSelection
              ? window.getSelection().toString()
              : document.selection && "Control" != document.selection.type
              ? document.selection.createRange().text
              : 0;
          }
          function e(a, b, c) {
            (k.type = c && f ? "stepped" : "stepless"),
              (k.scrollAmount = 10),
              Q(g, a, b, "mcsLinearOut", c ? 60 : null);
          }
          var f,
            g = a(this),
            h = g.data(d),
            i = h.opt,
            k = h.sequential,
            l = d + "_" + h.idx,
            m = a("#mCSB_" + h.idx + "_container"),
            n = m.parent();
          m.bind("mousedown." + l, function(a) {
            b || f || ((f = 1), (j = !0));
          })
            .add(document)
            .bind("mousemove." + l, function(a) {
              if (!b && f && c()) {
                var d = m.offset(),
                  g = E(a)[0] - d.top + m[0].offsetTop,
                  j = E(a)[1] - d.left + m[0].offsetLeft;
                g > 0 && g < n.height() && j > 0 && j < n.width()
                  ? k.step && e("off", null, "stepped")
                  : ("x" !== i.axis &&
                      h.overflowed[0] &&
                      (g < 0 ? e("on", 38) : g > n.height() && e("on", 40)),
                    "y" !== i.axis &&
                      h.overflowed[1] &&
                      (j < 0 ? e("on", 37) : j > n.width() && e("on", 39)));
              }
            })
            .bind("mouseup." + l, function(a) {
              b || (f && ((f = 0), e("off", null)), (j = !1));
            });
        },
        I = function() {
          function b(b, d) {
            if ((V(c), !K(c, b.target))) {
              var g =
                "auto" !== f.mouseWheel.deltaFactor
                  ? parseInt(f.mouseWheel.deltaFactor)
                  : i && b.deltaFactor < 100
                  ? 100
                  : b.deltaFactor || 100;
              if ("x" === f.axis || "x" === f.mouseWheel.axis)
                var k = "x",
                  l = [
                    Math.round(g * e.scrollRatio.x),
                    parseInt(f.mouseWheel.scrollAmount)
                  ],
                  m =
                    "auto" !== f.mouseWheel.scrollAmount
                      ? l[1]
                      : l[0] >= h.width()
                      ? 0.9 * h.width()
                      : l[0],
                  n = Math.abs(
                    a("#mCSB_" + e.idx + "_container")[0].offsetLeft
                  ),
                  o = j[1][0].offsetLeft,
                  p = j[1].parent().width() - j[1].width(),
                  q = b.deltaX || b.deltaY || d;
              else
                var k = "y",
                  l = [
                    Math.round(g * e.scrollRatio.y),
                    parseInt(f.mouseWheel.scrollAmount)
                  ],
                  m =
                    "auto" !== f.mouseWheel.scrollAmount
                      ? l[1]
                      : l[0] >= h.height()
                      ? 0.9 * h.height()
                      : l[0],
                  n = Math.abs(a("#mCSB_" + e.idx + "_container")[0].offsetTop),
                  o = j[0][0].offsetTop,
                  p = j[0].parent().height() - j[0].height(),
                  q = b.deltaY || d;
              ("y" === k && !e.overflowed[0]) ||
                ("x" === k && !e.overflowed[1]) ||
                ((f.mouseWheel.invert || b.webkitDirectionInvertedFromDevice) &&
                  (q = -q),
                f.mouseWheel.normalizeDelta && (q = q < 0 ? -1 : 1),
                ((q > 0 && 0 !== o) ||
                  (q < 0 && o !== p) ||
                  f.mouseWheel.preventDefault) &&
                  (b.stopImmediatePropagation(), b.preventDefault()),
                W(c, (n - q * m).toString(), { dir: k }));
            }
          }
          if (a(this).data(d)) {
            var c = a(this),
              e = c.data(d),
              f = e.opt,
              g = d + "_" + e.idx,
              h = a("#mCSB_" + e.idx),
              j = [
                a("#mCSB_" + e.idx + "_dragger_vertical"),
                a("#mCSB_" + e.idx + "_dragger_horizontal")
              ],
              k = a("#mCSB_" + e.idx + "_container").find("iframe");
            k.length &&
              k.each(function() {
                a(this).load(function() {
                  J(this) &&
                    a(this.contentDocument || this.contentWindow.document).bind(
                      "mousewheel." + g,
                      function(a, c) {
                        b(a, c);
                      }
                    );
                });
              }),
              h.bind("mousewheel." + g, function(a, c) {
                b(a, c);
              });
          }
        },
        J = function(a) {
          var b = null;
          try {
            var c = a.contentDocument || a.contentWindow.document;
            b = c.body.innerHTML;
          } catch (a) {}
          return null !== b;
        },
        K = function(b, c) {
          var e = c.nodeName.toLowerCase(),
            f = b.data(d).opt.mouseWheel.disableOver,
            g = ["select", "textarea"];
          return (
            a.inArray(e, f) > -1 &&
            !(a.inArray(e, g) > -1 && !a(c).is(":focus"))
          );
        },
        L = function() {
          var b = a(this),
            c = b.data(d),
            e = d + "_" + c.idx,
            f = a("#mCSB_" + c.idx + "_container"),
            g = f.parent(),
            h = a(".mCSB_" + c.idx + "_scrollbar ." + k[12]);
          h.bind(
            "touchstart." + e + " pointerdown." + e + " MSPointerDown." + e,
            function(a) {
              j = !0;
            }
          )
            .bind(
              "touchend." + e + " pointerup." + e + " MSPointerUp." + e,
              function(a) {
                j = !1;
              }
            )
            .bind("click." + e, function(d) {
              if (
                a(d.target).hasClass(k[12]) ||
                a(d.target).hasClass("mCSB_draggerRail")
              ) {
                V(b);
                var e = a(this),
                  h = e.find(".mCSB_dragger");
                if (e.parent(".mCSB_scrollTools_horizontal").length > 0) {
                  if (!c.overflowed[1]) return;
                  var i = "x",
                    j = d.pageX > h.offset().left ? -1 : 1,
                    l = Math.abs(f[0].offsetLeft) - j * (0.9 * g.width());
                } else {
                  if (!c.overflowed[0]) return;
                  var i = "y",
                    j = d.pageY > h.offset().top ? -1 : 1,
                    l = Math.abs(f[0].offsetTop) - j * (0.9 * g.height());
                }
                W(b, l.toString(), { dir: i, scrollEasing: "mcsEaseInOut" });
              }
            });
        },
        M = function() {
          var b = a(this),
            c = b.data(d),
            e = c.opt,
            f = d + "_" + c.idx,
            g = a("#mCSB_" + c.idx + "_container"),
            h = g.parent();
          g.bind("focusin." + f, function(c) {
            var d = a(document.activeElement),
              f = g.find(".mCustomScrollBox").length,
              i = 0;
            d.is(e.advanced.autoScrollOnFocus) &&
              (V(b),
              clearTimeout(b[0]._focusTimeout),
              (b[0]._focusTimer = f ? (i + 17) * f : 0),
              (b[0]._focusTimeout = setTimeout(function() {
                var a = [ca(d)[0], ca(d)[1]],
                  c = [g[0].offsetTop, g[0].offsetLeft],
                  f = [
                    c[0] + a[0] >= 0 &&
                      c[0] + a[0] < h.height() - d.outerHeight(!1),
                    c[1] + a[1] >= 0 &&
                      c[0] + a[1] < h.width() - d.outerWidth(!1)
                  ],
                  j = "yx" !== e.axis || f[0] || f[1] ? "all" : "none";
                "x" === e.axis ||
                  f[0] ||
                  W(b, a[0].toString(), {
                    dir: "y",
                    scrollEasing: "mcsEaseInOut",
                    overwrite: j,
                    dur: i
                  }),
                  "y" === e.axis ||
                    f[1] ||
                    W(b, a[1].toString(), {
                      dir: "x",
                      scrollEasing: "mcsEaseInOut",
                      overwrite: j,
                      dur: i
                    });
              }, b[0]._focusTimer)));
          });
        },
        N = function() {
          var b = a(this),
            c = b.data(d),
            e = d + "_" + c.idx,
            f = a("#mCSB_" + c.idx + "_container").parent();
          f.bind("scroll." + e, function(b) {
            (0 === f.scrollTop() && 0 === f.scrollLeft()) ||
              a(".mCSB_" + c.idx + "_scrollbar").css("visibility", "hidden");
          });
        },
        O = function() {
          var b = a(this),
            c = b.data(d),
            e = c.opt,
            f = c.sequential,
            g = d + "_" + c.idx,
            h = ".mCSB_" + c.idx + "_scrollbar",
            i = a(h + ">a");
          i.bind(
            "mousedown." +
              g +
              " touchstart." +
              g +
              " pointerdown." +
              g +
              " MSPointerDown." +
              g +
              " mouseup." +
              g +
              " touchend." +
              g +
              " pointerup." +
              g +
              " MSPointerUp." +
              g +
              " mouseout." +
              g +
              " pointerout." +
              g +
              " MSPointerOut." +
              g +
              " click." +
              g,
            function(d) {
              function g(a, c) {
                (f.scrollAmount = e.snapAmount || e.scrollButtons.scrollAmount),
                  Q(b, a, c);
              }
              if ((d.preventDefault(), _(d))) {
                var h = a(this).attr("class");
                switch (((f.type = e.scrollButtons.scrollType), d.type)) {
                  case "mousedown":
                  case "touchstart":
                  case "pointerdown":
                  case "MSPointerDown":
                    if ("stepped" === f.type) return;
                    (j = !0), (c.tweenRunning = !1), g("on", h);
                    break;
                  case "mouseup":
                  case "touchend":
                  case "pointerup":
                  case "MSPointerUp":
                  case "mouseout":
                  case "pointerout":
                  case "MSPointerOut":
                    if ("stepped" === f.type) return;
                    (j = !1), f.dir && g("off", h);
                    break;
                  case "click":
                    if ("stepped" !== f.type || c.tweenRunning) return;
                    g("on", h);
                }
              }
            }
          );
        },
        P = function() {
          function b(b) {
            function d(a, b) {
              (g.type = f.keyboard.scrollType),
                (g.scrollAmount = f.snapAmount || f.keyboard.scrollAmount),
                ("stepped" === g.type && e.tweenRunning) || Q(c, a, b);
            }
            switch (b.type) {
              case "blur":
                e.tweenRunning && g.dir && d("off", null);
                break;
              case "keydown":
              case "keyup":
                var h = b.keyCode ? b.keyCode : b.which,
                  i = "on";
                if (
                  ("x" !== f.axis && (38 === h || 40 === h)) ||
                  ("y" !== f.axis && (37 === h || 39 === h))
                ) {
                  if (
                    ((38 === h || 40 === h) && !e.overflowed[0]) ||
                    ((37 === h || 39 === h) && !e.overflowed[1])
                  )
                    return;
                  "keyup" === b.type && (i = "off"),
                    a(document.activeElement).is(l) ||
                      (b.preventDefault(),
                      b.stopImmediatePropagation(),
                      d(i, h));
                } else if (33 === h || 34 === h) {
                  if (
                    ((e.overflowed[0] || e.overflowed[1]) &&
                      (b.preventDefault(), b.stopImmediatePropagation()),
                    "keyup" === b.type)
                  ) {
                    V(c);
                    var m = 34 === h ? -1 : 1;
                    if (
                      "x" === f.axis ||
                      ("yx" === f.axis && e.overflowed[1] && !e.overflowed[0])
                    )
                      var n = "x",
                        o = Math.abs(j[0].offsetLeft) - m * (0.9 * k.width());
                    else
                      var n = "y",
                        o = Math.abs(j[0].offsetTop) - m * (0.9 * k.height());
                    W(c, o.toString(), {
                      dir: n,
                      scrollEasing: "mcsEaseInOut"
                    });
                  }
                } else if (
                  (35 === h || 36 === h) &&
                  !a(document.activeElement).is(l) &&
                  ((e.overflowed[0] || e.overflowed[1]) &&
                    (b.preventDefault(), b.stopImmediatePropagation()),
                  "keyup" === b.type)
                ) {
                  if (
                    "x" === f.axis ||
                    ("yx" === f.axis && e.overflowed[1] && !e.overflowed[0])
                  )
                    var n = "x",
                      o = 35 === h ? Math.abs(k.width() - j.outerWidth(!1)) : 0;
                  else
                    var n = "y",
                      o =
                        35 === h ? Math.abs(k.height() - j.outerHeight(!1)) : 0;
                  W(c, o.toString(), { dir: n, scrollEasing: "mcsEaseInOut" });
                }
            }
          }
          var c = a(this),
            e = c.data(d),
            f = e.opt,
            g = e.sequential,
            h = d + "_" + e.idx,
            i = a("#mCSB_" + e.idx),
            j = a("#mCSB_" + e.idx + "_container"),
            k = j.parent(),
            l =
              "input,textarea,select,datalist,keygen,[contenteditable='true']",
            m = j.find("iframe"),
            n = ["blur." + h + " keydown." + h + " keyup." + h];
          m.length &&
            m.each(function() {
              a(this).load(function() {
                J(this) &&
                  a(this.contentDocument || this.contentWindow.document).bind(
                    n[0],
                    function(a) {
                      b(a);
                    }
                  );
              });
            }),
            i.attr("tabindex", "0").bind(n[0], function(a) {
              b(a);
            });
        },
        Q = function(b, c, e, f, g) {
          function h(a) {
            var c = "stepped" !== m.type,
              d = g ? g : a ? (c ? p / 1.5 : q) : 1e3 / 60,
              e = a ? (c ? 7.5 : 40) : 2.5,
              i = [Math.abs(n[0].offsetTop), Math.abs(n[0].offsetLeft)],
              k = [
                j.scrollRatio.y > 10 ? 10 : j.scrollRatio.y,
                j.scrollRatio.x > 10 ? 10 : j.scrollRatio.x
              ],
              l =
                "x" === m.dir[0]
                  ? i[1] + m.dir[1] * (k[1] * e)
                  : i[0] + m.dir[1] * (k[0] * e),
              o =
                "x" === m.dir[0]
                  ? i[1] + m.dir[1] * parseInt(m.scrollAmount)
                  : i[0] + m.dir[1] * parseInt(m.scrollAmount),
              r = "auto" !== m.scrollAmount ? o : l,
              s = f
                ? f
                : a
                ? c
                  ? "mcsLinearOut"
                  : "mcsEaseInOut"
                : "mcsLinear",
              t = !!a;
            return (
              a && d < 17 && (r = "x" === m.dir[0] ? i[1] : i[0]),
              W(b, r.toString(), {
                dir: m.dir[0],
                scrollEasing: s,
                dur: d,
                onComplete: t
              }),
              a
                ? void (m.dir = !1)
                : (clearTimeout(m.step),
                  void (m.step = setTimeout(function() {
                    h();
                  }, d)))
            );
          }
          function i() {
            clearTimeout(m.step), $(m, "step"), V(b);
          }
          var j = b.data(d),
            l = j.opt,
            m = j.sequential,
            n = a("#mCSB_" + j.idx + "_container"),
            o = "stepped" === m.type,
            p = l.scrollInertia < 26 ? 26 : l.scrollInertia,
            q = l.scrollInertia < 1 ? 17 : l.scrollInertia;
          switch (c) {
            case "on":
              if (
                ((m.dir = [
                  e === k[16] || e === k[15] || 39 === e || 37 === e
                    ? "x"
                    : "y",
                  e === k[13] || e === k[15] || 38 === e || 37 === e ? -1 : 1
                ]),
                V(b),
                ba(e) && "stepped" === m.type)
              )
                return;
              h(o);
              break;
            case "off":
              i(), (o || (j.tweenRunning && m.dir)) && h(!0);
          }
        },
        R = function(b) {
          var c = a(this).data(d).opt,
            e = [];
          return (
            "function" == typeof b && (b = b()),
            b instanceof Array
              ? (e =
                  b.length > 1
                    ? [b[0], b[1]]
                    : "x" === c.axis
                    ? [null, b[0]]
                    : [b[0], null])
              : ((e[0] = b.y ? b.y : b.x || "x" === c.axis ? null : b),
                (e[1] = b.x ? b.x : b.y || "y" === c.axis ? null : b)),
            "function" == typeof e[0] && (e[0] = e[0]()),
            "function" == typeof e[1] && (e[1] = e[1]()),
            e
          );
        },
        S = function(b, c) {
          if (null != b && "undefined" != typeof b) {
            var e = a(this),
              f = e.data(d),
              g = f.opt,
              h = a("#mCSB_" + f.idx + "_container"),
              i = h.parent(),
              j = typeof b;
            c || (c = "x" === g.axis ? "x" : "y");
            var k = "x" === c ? h.outerWidth(!1) : h.outerHeight(!1),
              m = "x" === c ? h[0].offsetLeft : h[0].offsetTop,
              n = "x" === c ? "left" : "top";
            switch (j) {
              case "function":
                return b();
              case "object":
                var o = b.jquery ? b : a(b);
                if (!o.length) return;
                return "x" === c ? ca(o)[1] : ca(o)[0];
              case "string":
              case "number":
                if (ba(b)) return Math.abs(b);
                if (b.indexOf("%") !== -1)
                  return Math.abs((k * parseInt(b)) / 100);
                if (b.indexOf("-=") !== -1)
                  return Math.abs(m - parseInt(b.split("-=")[1]));
                if (b.indexOf("+=") !== -1) {
                  var p = m + parseInt(b.split("+=")[1]);
                  return p >= 0 ? 0 : Math.abs(p);
                }
                if (b.indexOf("px") !== -1 && ba(b.split("px")[0]))
                  return Math.abs(b.split("px")[0]);
                if ("top" === b || "left" === b) return 0;
                if ("bottom" === b)
                  return Math.abs(i.height() - h.outerHeight(!1));
                if ("right" === b)
                  return Math.abs(i.width() - h.outerWidth(!1));
                if ("first" === b || "last" === b) {
                  var o = h.find(":" + b);
                  return "x" === c ? ca(o)[1] : ca(o)[0];
                }
                return a(b).length
                  ? "x" === c
                    ? ca(a(b))[1]
                    : ca(a(b))[0]
                  : (h.css(n, b), void l.update.call(null, e[0]));
            }
          }
        },
        T = function(b) {
          function c() {
            return (
              clearTimeout(n[0].autoUpdate),
              0 === i.parents("html").length
                ? void (i = null)
                : void (n[0].autoUpdate = setTimeout(function() {
                    return m.advanced.updateOnSelectorChange &&
                      ((o = g()), o !== u)
                      ? (h(3), void (u = o))
                      : (m.advanced.updateOnContentResize &&
                          ((p = [
                            n.outerHeight(!1),
                            n.outerWidth(!1),
                            r.height(),
                            r.width(),
                            t()[0],
                            t()[1]
                          ]),
                          (p[0] === v[0] &&
                            p[1] === v[1] &&
                            p[2] === v[2] &&
                            p[3] === v[3] &&
                            p[4] === v[4] &&
                            p[5] === v[5]) ||
                            (h(p[0] !== v[0] || p[1] !== v[1]), (v = p))),
                        m.advanced.updateOnImageLoad &&
                          ((q = e()),
                          q !== w &&
                            (n.find("img").each(function() {
                              f(this);
                            }),
                            (w = q))),
                        void (
                          (m.advanced.updateOnSelectorChange ||
                            m.advanced.updateOnContentResize ||
                            m.advanced.updateOnImageLoad) &&
                          c()
                        ));
                  }, m.advanced.autoUpdateTimeout))
            );
          }
          function e() {
            var a = 0;
            return (
              m.advanced.updateOnImageLoad && (a = n.find("img").length), a
            );
          }
          function f(b) {
            function c(a, b) {
              return function() {
                return b.apply(a, arguments);
              };
            }
            function d() {
              (this.onload = null), a(b).addClass(k[2]), h(2);
            }
            if (a(b).hasClass(k[2])) return void h();
            var e = new Image();
            (e.onload = c(e, d)), (e.src = b.src);
          }
          function g() {
            m.advanced.updateOnSelectorChange === !0 &&
              (m.advanced.updateOnSelectorChange = "*");
            var b = 0,
              c = n.find(m.advanced.updateOnSelectorChange);
            return (
              m.advanced.updateOnSelectorChange &&
                c.length > 0 &&
                c.each(function() {
                  b += a(this).height() + a(this).width();
                }),
              b
            );
          }
          function h(a) {
            clearTimeout(n[0].autoUpdate), l.update.call(null, i[0], a);
          }
          var i = a(this),
            j = i.data(d),
            m = j.opt,
            n = a("#mCSB_" + j.idx + "_container");
          if (b)
            return clearTimeout(n[0].autoUpdate), void $(n[0], "autoUpdate");
          var o,
            p,
            q,
            r = n.parent(),
            s = [
              a("#mCSB_" + j.idx + "_scrollbar_vertical"),
              a("#mCSB_" + j.idx + "_scrollbar_horizontal")
            ],
            t = function() {
              return [
                s[0].is(":visible") ? s[0].outerHeight(!0) : 0,
                s[1].is(":visible") ? s[1].outerWidth(!0) : 0
              ];
            },
            u = g(),
            v = [
              n.outerHeight(!1),
              n.outerWidth(!1),
              r.height(),
              r.width(),
              t()[0],
              t()[1]
            ],
            w = e();
          c();
        },
        U = function(a, b, c) {
          return Math.round(a / b) * b - c;
        },
        V = function(b) {
          var c = b.data(d),
            e = a(
              "#mCSB_" +
                c.idx +
                "_container,#mCSB_" +
                c.idx +
                "_container_wrapper,#mCSB_" +
                c.idx +
                "_dragger_vertical,#mCSB_" +
                c.idx +
                "_dragger_horizontal"
            );
          e.each(function() {
            Z.call(this);
          });
        },
        W = function(b, c, e) {
          function f(a) {
            return i && j.callbacks[a] && "function" == typeof j.callbacks[a];
          }
          function g() {
            return [
              j.callbacks.alwaysTriggerOffsets || t >= u[0] + w,
              j.callbacks.alwaysTriggerOffsets || t <= -x
            ];
          }
          function h() {
            var a = [n[0].offsetTop, n[0].offsetLeft],
              c = [r[0].offsetTop, r[0].offsetLeft],
              d = [n.outerHeight(!1), n.outerWidth(!1)],
              f = [m.height(), m.width()];
            b[0].mcs = {
              content: n,
              top: a[0],
              left: a[1],
              draggerTop: c[0],
              draggerLeft: c[1],
              topPct: Math.round(
                (100 * Math.abs(a[0])) / (Math.abs(d[0]) - f[0])
              ),
              leftPct: Math.round(
                (100 * Math.abs(a[1])) / (Math.abs(d[1]) - f[1])
              ),
              direction: e.dir
            };
          }
          var i = b.data(d),
            j = i.opt,
            k = {
              trigger: "internal",
              dir: "y",
              scrollEasing: "mcsEaseOut",
              drag: !1,
              dur: j.scrollInertia,
              overwrite: "all",
              callbacks: !0,
              onStart: !0,
              onUpdate: !0,
              onComplete: !0
            },
            e = a.extend(k, e),
            l = [e.dur, e.drag ? 0 : e.dur],
            m = a("#mCSB_" + i.idx),
            n = a("#mCSB_" + i.idx + "_container"),
            o = n.parent(),
            p = j.callbacks.onTotalScrollOffset
              ? R.call(b, j.callbacks.onTotalScrollOffset)
              : [0, 0],
            q = j.callbacks.onTotalScrollBackOffset
              ? R.call(b, j.callbacks.onTotalScrollBackOffset)
              : [0, 0];
          if (
            ((i.trigger = e.trigger),
            (0 === o.scrollTop() && 0 === o.scrollLeft()) ||
              (a(".mCSB_" + i.idx + "_scrollbar").css("visibility", "visible"),
              o.scrollTop(0).scrollLeft(0)),
            "_resetY" !== c ||
              i.contentReset.y ||
              (f("onOverflowYNone") && j.callbacks.onOverflowYNone.call(b[0]),
              (i.contentReset.y = 1)),
            "_resetX" !== c ||
              i.contentReset.x ||
              (f("onOverflowXNone") && j.callbacks.onOverflowXNone.call(b[0]),
              (i.contentReset.x = 1)),
            "_resetY" !== c && "_resetX" !== c)
          ) {
            switch (
              ((!i.contentReset.y && b[0].mcs) ||
                !i.overflowed[0] ||
                (f("onOverflowY") && j.callbacks.onOverflowY.call(b[0]),
                (i.contentReset.x = null)),
              (!i.contentReset.x && b[0].mcs) ||
                !i.overflowed[1] ||
                (f("onOverflowX") && j.callbacks.onOverflowX.call(b[0]),
                (i.contentReset.x = null)),
              j.snapAmount && (c = U(c, j.snapAmount, j.snapOffset)),
              e.dir)
            ) {
              case "x":
                var r = a("#mCSB_" + i.idx + "_dragger_horizontal"),
                  s = "left",
                  t = n[0].offsetLeft,
                  u = [
                    m.width() - n.outerWidth(!1),
                    r.parent().width() - r.width()
                  ],
                  v = [c, 0 === c ? 0 : c / i.scrollRatio.x],
                  w = p[1],
                  x = q[1],
                  z = w > 0 ? w / i.scrollRatio.x : 0,
                  A = x > 0 ? x / i.scrollRatio.x : 0;
                break;
              case "y":
                var r = a("#mCSB_" + i.idx + "_dragger_vertical"),
                  s = "top",
                  t = n[0].offsetTop,
                  u = [
                    m.height() - n.outerHeight(!1),
                    r.parent().height() - r.height()
                  ],
                  v = [c, 0 === c ? 0 : c / i.scrollRatio.y],
                  w = p[0],
                  x = q[0],
                  z = w > 0 ? w / i.scrollRatio.y : 0,
                  A = x > 0 ? x / i.scrollRatio.y : 0;
            }
            v[1] < 0 || (0 === v[0] && 0 === v[1])
              ? (v = [0, 0])
              : v[1] >= u[1]
              ? (v = [u[0], u[1]])
              : (v[0] = -v[0]),
              b[0].mcs || (h(), f("onInit") && j.callbacks.onInit.call(b[0])),
              clearTimeout(n[0].onCompleteTimeout),
              (!i.tweenRunning &&
                ((0 === t && v[0] >= 0) || (t === u[0] && v[0] <= u[0]))) ||
                (X(r[0], s, Math.round(v[1]), l[1], e.scrollEasing),
                X(
                  n[0],
                  s,
                  Math.round(v[0]),
                  l[0],
                  e.scrollEasing,
                  e.overwrite,
                  {
                    onStart: function() {
                      e.callbacks &&
                        e.onStart &&
                        !i.tweenRunning &&
                        (f("onScrollStart") &&
                          (h(), j.callbacks.onScrollStart.call(b[0])),
                        (i.tweenRunning = !0),
                        y(r),
                        (i.cbOffsets = g()));
                    },
                    onUpdate: function() {
                      e.callbacks &&
                        e.onUpdate &&
                        f("whileScrolling") &&
                        (h(), j.callbacks.whileScrolling.call(b[0]));
                    },
                    onComplete: function() {
                      if (e.callbacks && e.onComplete) {
                        "yx" === j.axis && clearTimeout(n[0].onCompleteTimeout);
                        var a = n[0].idleTimer || 0;
                        n[0].onCompleteTimeout = setTimeout(function() {
                          f("onScroll") &&
                            (h(), j.callbacks.onScroll.call(b[0])),
                            f("onTotalScroll") &&
                              v[1] >= u[1] - z &&
                              i.cbOffsets[0] &&
                              (h(), j.callbacks.onTotalScroll.call(b[0])),
                            f("onTotalScrollBack") &&
                              v[1] <= A &&
                              i.cbOffsets[1] &&
                              (h(), j.callbacks.onTotalScrollBack.call(b[0])),
                            (i.tweenRunning = !1),
                            (n[0].idleTimer = 0),
                            y(r, "hide");
                        }, a);
                      }
                    }
                  }
                ));
          }
        },
        X = function(a, b, c, d, e, f, g) {
          function h() {
            v.stop ||
              (s || o.call(),
              (s = Y() - r),
              i(),
              s >= v.time &&
                ((v.time = s > v.time ? s + m - (s - v.time) : s + m - 1),
                v.time < s + 1 && (v.time = s + 1)),
              v.time < d ? (v.id = n(h)) : q.call());
          }
          function i() {
            d > 0
              ? ((v.currVal = l(v.time, t, w, d, e)),
                (u[b] = Math.round(v.currVal) + "px"))
              : (u[b] = c + "px"),
              p.call();
          }
          function j() {
            (m = 1e3 / 60),
              (v.time = s + m),
              (n = window.requestAnimationFrame
                ? window.requestAnimationFrame
                : function(a) {
                    return i(), setTimeout(a, 0.01);
                  }),
              (v.id = n(h));
          }
          function k() {
            null != v.id &&
              (window.requestAnimationFrame
                ? window.cancelAnimationFrame(v.id)
                : clearTimeout(v.id),
              (v.id = null));
          }
          function l(a, b, c, d, e) {
            switch (e) {
              case "linear":
              case "mcsLinear":
                return (c * a) / d + b;
              case "mcsLinearOut":
                return (a /= d), a--, c * Math.sqrt(1 - a * a) + b;
              case "easeInOutSmooth":
                return (
                  (a /= d / 2),
                  a < 1
                    ? (c / 2) * a * a + b
                    : (a--, (-c / 2) * (a * (a - 2) - 1) + b)
                );
              case "easeInOutStrong":
                return (
                  (a /= d / 2),
                  a < 1
                    ? (c / 2) * Math.pow(2, 10 * (a - 1)) + b
                    : (a--, (c / 2) * (-Math.pow(2, -10 * a) + 2) + b)
                );
              case "easeInOut":
              case "mcsEaseInOut":
                return (
                  (a /= d / 2),
                  a < 1
                    ? (c / 2) * a * a * a + b
                    : ((a -= 2), (c / 2) * (a * a * a + 2) + b)
                );
              case "easeOutSmooth":
                return (a /= d), a--, -c * (a * a * a * a - 1) + b;
              case "easeOutStrong":
                return c * (-Math.pow(2, (-10 * a) / d) + 1) + b;
              case "easeOut":
              case "mcsEaseOut":
              default:
                var f = (a /= d) * a,
                  g = f * a;
                return (
                  b +
                  c *
                    (0.499999999999997 * g * f +
                      -2.5 * f * f +
                      5.5 * g +
                      -6.5 * f +
                      4 * a)
                );
            }
          }
          a._mTween || (a._mTween = { top: {}, left: {} });
          var m,
            n,
            g = g || {},
            o = g.onStart || function() {},
            p = g.onUpdate || function() {},
            q = g.onComplete || function() {},
            r = Y(),
            s = 0,
            t = a.offsetTop,
            u = a.style,
            v = a._mTween[b];
          "left" === b && (t = a.offsetLeft);
          var w = c - t;
          (v.stop = 0), "none" !== f && k(), j();
        },
        Y = function() {
          return window.performance && window.performance.now
            ? window.performance.now()
            : window.performance && window.performance.webkitNow
            ? window.performance.webkitNow()
            : Date.now
            ? Date.now()
            : new Date().getTime();
        },
        Z = function() {
          var a = this;
          a._mTween || (a._mTween = { top: {}, left: {} });
          for (var b = ["top", "left"], c = 0; c < b.length; c++) {
            var d = b[c];
            a._mTween[d].id &&
              (window.requestAnimationFrame
                ? window.cancelAnimationFrame(a._mTween[d].id)
                : clearTimeout(a._mTween[d].id),
              (a._mTween[d].id = null),
              (a._mTween[d].stop = 1));
          }
        },
        $ = function(a, b) {
          try {
            delete a[b];
          } catch (c) {
            a[b] = null;
          }
        },
        _ = function(a) {
          return !(a.which && 1 !== a.which);
        },
        aa = function(a) {
          var b = a.originalEvent.pointerType;
          return !(b && "touch" !== b && 2 !== b);
        },
        ba = function(a) {
          return !isNaN(parseFloat(a)) && isFinite(a);
        },
        ca = function(a) {
          var b = a.parents(".mCSB_container");
          return [
            a.offset().top - b.offset().top,
            a.offset().left - b.offset().left
          ];
        };
      (a.fn[c] = function(b) {
        return l[b]
          ? l[b].apply(this, Array.prototype.slice.call(arguments, 1))
          : "object" != typeof b && b
          ? void a.error("Method " + b + " does not exist")
          : l.init.apply(this, arguments);
      }),
        (a[c] = function(b) {
          return l[b]
            ? l[b].apply(this, Array.prototype.slice.call(arguments, 1))
            : "object" != typeof b && b
            ? void a.error("Method " + b + " does not exist")
            : l.init.apply(this, arguments);
        }),
        (a[c].defaults = f),
        (window[c] = !0),
        a(window).load(function() {
          a(e)[c](),
            a.extend(a.expr[":"], {
              mcsInView:
                a.expr[":"].mcsInView ||
                function(b) {
                  var c,
                    d,
                    e = a(b),
                    f = e.parents(".mCSB_container");
                  if (f.length)
                    return (
                      (c = f.parent()),
                      (d = [f[0].offsetTop, f[0].offsetLeft]),
                      d[0] + ca(e)[0] >= 0 &&
                        d[0] + ca(e)[0] < c.height() - e.outerHeight(!1) &&
                        d[1] + ca(e)[1] >= 0 &&
                        d[1] + ca(e)[1] < c.width() - e.outerWidth(!1)
                    );
                },
              mcsOverflow:
                a.expr[":"].mcsOverflow ||
                function(b) {
                  var c = a(b).data(d);
                  if (c) return c.overflowed[0] || c.overflowed[1];
                }
            });
        });
    });
  }),
  jQuery(document).ready(function(a) {
    a.fn.extend({
      customSelect: function(b) {
        if ("undefined" == typeof document.body.style.maxHeight) return this;
        var c = { customClass: "customSelect", mapClass: !0, mapStyle: !0 },
          b = a.extend(c, b),
          d = b.customClass,
          e = function(b, c) {
            var d = b.find(":selected"),
              e = c.children(":first"),
              g = d.html() || "&nbsp;";
            e.html(g),
              d.attr("disabled")
                ? c.addClass(f("DisabledOption"))
                : c.removeClass(f("DisabledOption")),
              setTimeout(function() {
                c.removeClass(f("Open")),
                  a(document).off("mouseup." + f("Open"));
              }, 60);
          },
          f = function(a) {
            return d + a;
          };
        return this.each(function() {
          var c = a(this),
            g = a("<span />").addClass(f("Inner")),
            h = a("<span />");
          c.after(h.append(g)),
            h.addClass(d),
            b.mapClass && h.addClass(c.attr("class")),
            b.mapStyle && h.attr("style", c.attr("style")),
            c
              .addClass("hasCustomSelect")
              .on("update", function() {
                e(c, h);
                var a =
                  parseInt(c.outerWidth(), 10) -
                  (parseInt(h.outerWidth(), 10) - parseInt(h.width(), 10));
                h.css({ display: "inline-block" });
                var b = h.outerHeight();
                c.attr("disabled")
                  ? h.addClass(f("Disabled"))
                  : h.removeClass(f("Disabled")),
                  g.css({ width: a, display: "inline-block" }),
                  c.css({
                    "-webkit-appearance": "menulist-button",
                    width: h.outerWidth(),
                    position: "absolute",
                    opacity: 0,
                    height: b,
                    fontSize: h.css("font-size")
                  });
              })
              .on("change", function() {
                h.addClass(f("Changed")), e(c, h);
              })
              .on("keyup", function(a) {
                h.hasClass(f("Open"))
                  ? (13 != a.which && 27 != a.which) || e(c, h)
                  : (c.blur(), c.focus());
              })
              .on("mousedown", function(a) {
                h.removeClass(f("Changed"));
              })
              .on("mouseup", function(b) {
                h.hasClass(f("Open")) ||
                  (a("." + f("Open")).not(h).length > 0 &&
                  "undefined" != typeof InstallTrigger
                    ? c.focus()
                    : (h.addClass(f("Open")),
                      b.stopPropagation(),
                      a(document).one("mouseup." + f("Open"), function(b) {
                        b.target != c.get(0) &&
                        a.inArray(b.target, c.find("*").get()) < 0
                          ? c.blur()
                          : e(c, h);
                      })));
              })
              .focus(function() {
                h.removeClass(f("Changed")).addClass(f("Focus"));
              })
              .blur(function() {
                h.removeClass(f("Focus") + " " + f("Open"));
              })
              .hover(
                function() {
                  h.addClass(f("Hover"));
                },
                function() {
                  h.removeClass(f("Hover"));
                }
              )
              .trigger("update");
        });
      }
    });
  }),
  (function(a, b) {
    "use strict";
    "function" == typeof define && define.amd
      ? define("jquery-bridget/jquery-bridget", ["jquery"], function(c) {
          b(a, c);
        })
      : "object" == typeof module && module.exports
      ? (module.exports = b(a, require("jquery")))
      : (a.jQueryBridget = b(a, a.jQuery));
  })(window, function(a, b) {
    "use strict";
    function c(c, f, h) {
      function i(a, b, d) {
        var e,
          f = "$()." + c + '("' + b + '")';
        return (
          a.each(function(a, i) {
            var j = h.data(i, c);
            if (!j)
              return void g(
                c + " not initialized. Cannot call methods, i.e. " + f
              );
            var k = j[b];
            if (!k || "_" == b.charAt(0))
              return void g(f + " is not a valid method");
            var l = k.apply(j, d);
            e = void 0 === e ? l : e;
          }),
          void 0 !== e ? e : a
        );
      }
      function j(a, b) {
        a.each(function(a, d) {
          var e = h.data(d, c);
          e ? (e.option(b), e._init()) : ((e = new f(d, b)), h.data(d, c, e));
        });
      }
      (h = h || b || a.jQuery),
        h &&
          (f.prototype.option ||
            (f.prototype.option = function(a) {
              h.isPlainObject(a) &&
                (this.options = h.extend(!0, this.options, a));
            }),
          (h.fn[c] = function(a) {
            if ("string" == typeof a) {
              var b = e.call(arguments, 1);
              return i(this, a, b);
            }
            return j(this, a), this;
          }),
          d(h));
    }
    function d(a) {
      !a || (a && a.bridget) || (a.bridget = c);
    }
    var e = Array.prototype.slice,
      f = a.console,
      g =
        "undefined" == typeof f
          ? function() {}
          : function(a) {
              f.error(a);
            };
    return d(b || a.jQuery), c;
  }),
  (function(a, b) {
    "function" == typeof define && define.amd
      ? define("ev-emitter/ev-emitter", b)
      : "object" == typeof module && module.exports
      ? (module.exports = b())
      : (a.EvEmitter = b());
  })(this, function() {
    function a() {}
    var b = a.prototype;
    return (
      (b.on = function(a, b) {
        if (a && b) {
          var c = (this._events = this._events || {}),
            d = (c[a] = c[a] || []);
          return d.indexOf(b) == -1 && d.push(b), this;
        }
      }),
      (b.once = function(a, b) {
        if (a && b) {
          this.on(a, b);
          var c = (this._onceEvents = this._onceEvents || {}),
            d = (c[a] = c[a] || {});
          return (d[b] = !0), this;
        }
      }),
      (b.off = function(a, b) {
        var c = this._events && this._events[a];
        if (c && c.length) {
          var d = c.indexOf(b);
          return d != -1 && c.splice(d, 1), this;
        }
      }),
      (b.emitEvent = function(a, b) {
        var c = this._events && this._events[a];
        if (c && c.length) {
          var d = 0,
            e = c[d];
          b = b || [];
          for (var f = this._onceEvents && this._onceEvents[a]; e; ) {
            var g = f && f[e];
            g && (this.off(a, e), delete f[e]),
              e.apply(this, b),
              (d += g ? 0 : 1),
              (e = c[d]);
          }
          return this;
        }
      }),
      a
    );
  }),
  (function(a, b) {
    "use strict";
    "function" == typeof define && define.amd
      ? define("get-size/get-size", [], function() {
          return b();
        })
      : "object" == typeof module && module.exports
      ? (module.exports = b())
      : (a.getSize = b());
  })(window, function() {
    "use strict";
    function a(a) {
      var b = parseFloat(a),
        c = a.indexOf("%") == -1 && !isNaN(b);
      return c && b;
    }
    function b() {}
    function c() {
      for (
        var a = {
            width: 0,
            height: 0,
            innerWidth: 0,
            innerHeight: 0,
            outerWidth: 0,
            outerHeight: 0
          },
          b = 0;
        b < j;
        b++
      ) {
        var c = i[b];
        a[c] = 0;
      }
      return a;
    }
    function d(a) {
      var b = getComputedStyle(a);
      return (
        b ||
          h(
            "Style returned " +
              b +
              ". Are you running this code in a hidden iframe on Firefox? See http://bit.ly/getsizebug1"
          ),
        b
      );
    }
    function e() {
      if (!k) {
        k = !0;
        var b = document.createElement("div");
        (b.style.width = "200px"),
          (b.style.padding = "1px 2px 3px 4px"),
          (b.style.borderStyle = "solid"),
          (b.style.borderWidth = "1px 2px 3px 4px"),
          (b.style.boxSizing = "border-box");
        var c = document.body || document.documentElement;
        c.appendChild(b);
        var e = d(b);
        (f.isBoxSizeOuter = g = 200 == a(e.width)), c.removeChild(b);
      }
    }
    function f(b) {
      if (
        (e(),
        "string" == typeof b && (b = document.querySelector(b)),
        b && "object" == typeof b && b.nodeType)
      ) {
        var f = d(b);
        if ("none" == f.display) return c();
        var h = {};
        (h.width = b.offsetWidth), (h.height = b.offsetHeight);
        for (
          var k = (h.isBorderBox = "border-box" == f.boxSizing), l = 0;
          l < j;
          l++
        ) {
          var m = i[l],
            n = f[m],
            o = parseFloat(n);
          h[m] = isNaN(o) ? 0 : o;
        }
        var p = h.paddingLeft + h.paddingRight,
          q = h.paddingTop + h.paddingBottom,
          r = h.marginLeft + h.marginRight,
          s = h.marginTop + h.marginBottom,
          t = h.borderLeftWidth + h.borderRightWidth,
          u = h.borderTopWidth + h.borderBottomWidth,
          v = k && g,
          w = a(f.width);
        w !== !1 && (h.width = w + (v ? 0 : p + t));
        var x = a(f.height);
        return (
          x !== !1 && (h.height = x + (v ? 0 : q + u)),
          (h.innerWidth = h.width - (p + t)),
          (h.innerHeight = h.height - (q + u)),
          (h.outerWidth = h.width + r),
          (h.outerHeight = h.height + s),
          h
        );
      }
    }
    var g,
      h =
        "undefined" == typeof console
          ? b
          : function(a) {
              console.error(a);
            },
      i = [
        "paddingLeft",
        "paddingRight",
        "paddingTop",
        "paddingBottom",
        "marginLeft",
        "marginRight",
        "marginTop",
        "marginBottom",
        "borderLeftWidth",
        "borderRightWidth",
        "borderTopWidth",
        "borderBottomWidth"
      ],
      j = i.length,
      k = !1;
    return f;
  }),
  (function(a, b) {
    "use strict";
    "function" == typeof define && define.amd
      ? define("desandro-matches-selector/matches-selector", b)
      : "object" == typeof module && module.exports
      ? (module.exports = b())
      : (a.matchesSelector = b());
  })(window, function() {
    "use strict";
    var a = (function() {
      var a = Element.prototype;
      if (a.matches) return "matches";
      if (a.matchesSelector) return "matchesSelector";
      for (var b = ["webkit", "moz", "ms", "o"], c = 0; c < b.length; c++) {
        var d = b[c],
          e = d + "MatchesSelector";
        if (a[e]) return e;
      }
    })();
    return function(b, c) {
      return b[a](c);
    };
  }),
  (function(a, b) {
    "function" == typeof define && define.amd
      ? define("fizzy-ui-utils/utils", [
          "desandro-matches-selector/matches-selector"
        ], function(c) {
          return b(a, c);
        })
      : "object" == typeof module && module.exports
      ? (module.exports = b(a, require("desandro-matches-selector")))
      : (a.fizzyUIUtils = b(a, a.matchesSelector));
  })(window, function(a, b) {
    var c = {};
    (c.extend = function(a, b) {
      for (var c in b) a[c] = b[c];
      return a;
    }),
      (c.modulo = function(a, b) {
        return ((a % b) + b) % b;
      }),
      (c.makeArray = function(a) {
        var b = [];
        if (Array.isArray(a)) b = a;
        else if (a && "number" == typeof a.length)
          for (var c = 0; c < a.length; c++) b.push(a[c]);
        else b.push(a);
        return b;
      }),
      (c.removeFrom = function(a, b) {
        var c = a.indexOf(b);
        c != -1 && a.splice(c, 1);
      }),
      (c.getParent = function(a, c) {
        for (; a != document.body; )
          if (((a = a.parentNode), b(a, c))) return a;
      }),
      (c.getQueryElement = function(a) {
        return "string" == typeof a ? document.querySelector(a) : a;
      }),
      (c.handleEvent = function(a) {
        var b = "on" + a.type;
        this[b] && this[b](a);
      }),
      (c.filterFindElements = function(a, d) {
        a = c.makeArray(a);
        var e = [];
        return (
          a.forEach(function(a) {
            if (a instanceof HTMLElement) {
              if (!d) return void e.push(a);
              b(a, d) && e.push(a);
              for (var c = a.querySelectorAll(d), f = 0; f < c.length; f++)
                e.push(c[f]);
            }
          }),
          e
        );
      }),
      (c.debounceMethod = function(a, b, c) {
        var d = a.prototype[b],
          e = b + "Timeout";
        a.prototype[b] = function() {
          var a = this[e];
          a && clearTimeout(a);
          var b = arguments,
            f = this;
          this[e] = setTimeout(function() {
            d.apply(f, b), delete f[e];
          }, c || 100);
        };
      }),
      (c.docReady = function(a) {
        "complete" == document.readyState
          ? a()
          : document.addEventListener("DOMContentLoaded", a);
      }),
      (c.toDashed = function(a) {
        return a
          .replace(/(.)([A-Z])/g, function(a, b, c) {
            return b + "-" + c;
          })
          .toLowerCase();
      });
    var d = a.console;
    return (
      (c.htmlInit = function(b, e) {
        c.docReady(function() {
          var f = c.toDashed(e),
            g = "data-" + f,
            h = document.querySelectorAll("[" + g + "]"),
            i = document.querySelectorAll(".js-" + f),
            j = c.makeArray(h).concat(c.makeArray(i)),
            k = g + "-options",
            l = a.jQuery;
          j.forEach(function(a) {
            var c,
              f = a.getAttribute(g) || a.getAttribute(k);
            try {
              c = f && JSON.parse(f);
            } catch (b) {
              return void (
                d &&
                d.error("Error parsing " + g + " on " + a.className + ": " + b)
              );
            }
            var h = new b(a, c);
            l && l.data(a, e, h);
          });
        });
      }),
      c
    );
  }),
  (function(a, b) {
    "function" == typeof define && define.amd
      ? define("outlayer/item", [
          "ev-emitter/ev-emitter",
          "get-size/get-size"
        ], b)
      : "object" == typeof module && module.exports
      ? (module.exports = b(require("ev-emitter"), require("get-size")))
      : ((a.Outlayer = {}), (a.Outlayer.Item = b(a.EvEmitter, a.getSize)));
  })(window, function(a, b) {
    "use strict";
    function c(a) {
      for (var b in a) return !1;
      return (b = null), !0;
    }
    function d(a, b) {
      a &&
        ((this.element = a),
        (this.layout = b),
        (this.position = { x: 0, y: 0 }),
        this._create());
    }
    function e(a) {
      return a.replace(/([A-Z])/g, function(a) {
        return "-" + a.toLowerCase();
      });
    }
    var f = document.documentElement.style,
      g = "string" == typeof f.transition ? "transition" : "WebkitTransition",
      h = "string" == typeof f.transform ? "transform" : "WebkitTransform",
      i = {
        WebkitTransition: "webkitTransitionEnd",
        transition: "transitionend"
      }[g],
      j = {
        transform: h,
        transition: g,
        transitionDuration: g + "Duration",
        transitionProperty: g + "Property",
        transitionDelay: g + "Delay"
      },
      k = (d.prototype = Object.create(a.prototype));
    (k.constructor = d),
      (k._create = function() {
        (this._transn = { ingProperties: {}, clean: {}, onEnd: {} }),
          this.css({ position: "absolute" });
      }),
      (k.handleEvent = function(a) {
        var b = "on" + a.type;
        this[b] && this[b](a);
      }),
      (k.getSize = function() {
        this.size = b(this.element);
      }),
      (k.css = function(a) {
        var b = this.element.style;
        for (var c in a) {
          var d = j[c] || c;
          b[d] = a[c];
        }
      }),
      (k.getPosition = function() {
        var a = getComputedStyle(this.element),
          b = this.layout._getOption("originLeft"),
          c = this.layout._getOption("originTop"),
          d = a[b ? "left" : "right"],
          e = a[c ? "top" : "bottom"],
          f = this.layout.size,
          g =
            d.indexOf("%") != -1
              ? (parseFloat(d) / 100) * f.width
              : parseInt(d, 10),
          h =
            e.indexOf("%") != -1
              ? (parseFloat(e) / 100) * f.height
              : parseInt(e, 10);
        (g = isNaN(g) ? 0 : g),
          (h = isNaN(h) ? 0 : h),
          (g -= b ? f.paddingLeft : f.paddingRight),
          (h -= c ? f.paddingTop : f.paddingBottom),
          (this.position.x = g),
          (this.position.y = h);
      }),
      (k.layoutPosition = function() {
        var a = this.layout.size,
          b = {},
          c = this.layout._getOption("originLeft"),
          d = this.layout._getOption("originTop"),
          e = c ? "paddingLeft" : "paddingRight",
          f = c ? "left" : "right",
          g = c ? "right" : "left",
          h = this.position.x + a[e];
        (b[f] = this.getXValue(h)), (b[g] = "");
        var i = d ? "paddingTop" : "paddingBottom",
          j = d ? "top" : "bottom",
          k = d ? "bottom" : "top",
          l = this.position.y + a[i];
        (b[j] = this.getYValue(l)),
          (b[k] = ""),
          this.css(b),
          this.emitEvent("layout", [this]);
      }),
      (k.getXValue = function(a) {
        var b = this.layout._getOption("horizontal");
        return this.layout.options.percentPosition && !b
          ? (a / this.layout.size.width) * 100 + "%"
          : a + "px";
      }),
      (k.getYValue = function(a) {
        var b = this.layout._getOption("horizontal");
        return this.layout.options.percentPosition && b
          ? (a / this.layout.size.height) * 100 + "%"
          : a + "px";
      }),
      (k._transitionTo = function(a, b) {
        this.getPosition();
        var c = this.position.x,
          d = this.position.y,
          e = parseInt(a, 10),
          f = parseInt(b, 10),
          g = e === this.position.x && f === this.position.y;
        if ((this.setPosition(a, b), g && !this.isTransitioning))
          return void this.layoutPosition();
        var h = a - c,
          i = b - d,
          j = {};
        (j.transform = this.getTranslate(h, i)),
          this.transition({
            to: j,
            onTransitionEnd: { transform: this.layoutPosition },
            isCleaning: !0
          });
      }),
      (k.getTranslate = function(a, b) {
        var c = this.layout._getOption("originLeft"),
          d = this.layout._getOption("originTop");
        return (
          (a = c ? a : -a),
          (b = d ? b : -b),
          "translate3d(" + a + "px, " + b + "px, 0)"
        );
      }),
      (k.goTo = function(a, b) {
        this.setPosition(a, b), this.layoutPosition();
      }),
      (k.moveTo = k._transitionTo),
      (k.setPosition = function(a, b) {
        (this.position.x = parseInt(a, 10)),
          (this.position.y = parseInt(b, 10));
      }),
      (k._nonTransition = function(a) {
        this.css(a.to), a.isCleaning && this._removeStyles(a.to);
        for (var b in a.onTransitionEnd) a.onTransitionEnd[b].call(this);
      }),
      (k.transition = function(a) {
        if (!parseFloat(this.layout.options.transitionDuration))
          return void this._nonTransition(a);
        var b = this._transn;
        for (var c in a.onTransitionEnd) b.onEnd[c] = a.onTransitionEnd[c];
        for (c in a.to)
          (b.ingProperties[c] = !0), a.isCleaning && (b.clean[c] = !0);
        if (a.from) {
          this.css(a.from);
          var d = this.element.offsetHeight;
          d = null;
        }
        this.enableTransition(a.to),
          this.css(a.to),
          (this.isTransitioning = !0);
      });
    var l = "opacity," + e(h);
    (k.enableTransition = function() {
      if (!this.isTransitioning) {
        var a = this.layout.options.transitionDuration;
        (a = "number" == typeof a ? a + "ms" : a),
          this.css({
            transitionProperty: l,
            transitionDuration: a,
            transitionDelay: this.staggerDelay || 0
          }),
          this.element.addEventListener(i, this, !1);
      }
    }),
      (k.onwebkitTransitionEnd = function(a) {
        this.ontransitionend(a);
      }),
      (k.onotransitionend = function(a) {
        this.ontransitionend(a);
      });
    var m = { "-webkit-transform": "transform" };
    (k.ontransitionend = function(a) {
      if (a.target === this.element) {
        var b = this._transn,
          d = m[a.propertyName] || a.propertyName;
        if (
          (delete b.ingProperties[d],
          c(b.ingProperties) && this.disableTransition(),
          d in b.clean &&
            ((this.element.style[a.propertyName] = ""), delete b.clean[d]),
          d in b.onEnd)
        ) {
          var e = b.onEnd[d];
          e.call(this), delete b.onEnd[d];
        }
        this.emitEvent("transitionEnd", [this]);
      }
    }),
      (k.disableTransition = function() {
        this.removeTransitionStyles(),
          this.element.removeEventListener(i, this, !1),
          (this.isTransitioning = !1);
      }),
      (k._removeStyles = function(a) {
        var b = {};
        for (var c in a) b[c] = "";
        this.css(b);
      });
    var n = {
      transitionProperty: "",
      transitionDuration: "",
      transitionDelay: ""
    };
    return (
      (k.removeTransitionStyles = function() {
        this.css(n);
      }),
      (k.stagger = function(a) {
        (a = isNaN(a) ? 0 : a), (this.staggerDelay = a + "ms");
      }),
      (k.removeElem = function() {
        this.element.parentNode.removeChild(this.element),
          this.css({ display: "" }),
          this.emitEvent("remove", [this]);
      }),
      (k.remove = function() {
        return g && parseFloat(this.layout.options.transitionDuration)
          ? (this.once("transitionEnd", function() {
              this.removeElem();
            }),
            void this.hide())
          : void this.removeElem();
      }),
      (k.reveal = function() {
        delete this.isHidden, this.css({ display: "" });
        var a = this.layout.options,
          b = {},
          c = this.getHideRevealTransitionEndProperty("visibleStyle");
        (b[c] = this.onRevealTransitionEnd),
          this.transition({
            from: a.hiddenStyle,
            to: a.visibleStyle,
            isCleaning: !0,
            onTransitionEnd: b
          });
      }),
      (k.onRevealTransitionEnd = function() {
        this.isHidden || this.emitEvent("reveal");
      }),
      (k.getHideRevealTransitionEndProperty = function(a) {
        var b = this.layout.options[a];
        if (b.opacity) return "opacity";
        for (var c in b) return c;
      }),
      (k.hide = function() {
        (this.isHidden = !0), this.css({ display: "" });
        var a = this.layout.options,
          b = {},
          c = this.getHideRevealTransitionEndProperty("hiddenStyle");
        (b[c] = this.onHideTransitionEnd),
          this.transition({
            from: a.visibleStyle,
            to: a.hiddenStyle,
            isCleaning: !0,
            onTransitionEnd: b
          });
      }),
      (k.onHideTransitionEnd = function() {
        this.isHidden &&
          (this.css({ display: "none" }), this.emitEvent("hide"));
      }),
      (k.destroy = function() {
        this.css({
          position: "",
          left: "",
          right: "",
          top: "",
          bottom: "",
          transition: "",
          transform: ""
        });
      }),
      d
    );
  }),
  (function(a, b) {
    "use strict";
    "function" == typeof define && define.amd
      ? define("outlayer/outlayer", [
          "ev-emitter/ev-emitter",
          "get-size/get-size",
          "fizzy-ui-utils/utils",
          "./item"
        ], function(c, d, e, f) {
          return b(a, c, d, e, f);
        })
      : "object" == typeof module && module.exports
      ? (module.exports = b(
          a,
          require("ev-emitter"),
          require("get-size"),
          require("fizzy-ui-utils"),
          require("./item")
        ))
      : (a.Outlayer = b(
          a,
          a.EvEmitter,
          a.getSize,
          a.fizzyUIUtils,
          a.Outlayer.Item
        ));
  })(window, function(a, b, c, d, e) {
    "use strict";
    function f(a, b) {
      var c = d.getQueryElement(a);
      if (!c)
        return void (
          i &&
          i.error(
            "Bad element for " + this.constructor.namespace + ": " + (c || a)
          )
        );
      (this.element = c),
        j && (this.$element = j(this.element)),
        (this.options = d.extend({}, this.constructor.defaults)),
        this.option(b);
      var e = ++l;
      (this.element.outlayerGUID = e), (m[e] = this), this._create();
      var f = this._getOption("initLayout");
      f && this.layout();
    }
    function g(a) {
      function b() {
        a.apply(this, arguments);
      }
      return (
        (b.prototype = Object.create(a.prototype)),
        (b.prototype.constructor = b),
        b
      );
    }
    function h(a) {
      if ("number" == typeof a) return a;
      var b = a.match(/(^\d*\.?\d*)(\w*)/),
        c = b && b[1],
        d = b && b[2];
      if (!c.length) return 0;
      c = parseFloat(c);
      var e = o[d] || 1;
      return c * e;
    }
    var i = a.console,
      j = a.jQuery,
      k = function() {},
      l = 0,
      m = {};
    (f.namespace = "outlayer"),
      (f.Item = e),
      (f.defaults = {
        containerStyle: { position: "relative" },
        initLayout: !0,
        originLeft: !0,
        originTop: !0,
        resize: !0,
        resizeContainer: !0,
        equalheight: !1,
        transitionDuration: "0.4s",
        hiddenStyle: { opacity: 0, transform: "scale(0.001)" },
        visibleStyle: { opacity: 1, transform: "scale(1)" }
      });
    var n = f.prototype;
    d.extend(n, b.prototype),
      (n.option = function(a) {
        d.extend(this.options, a);
      }),
      (n._getOption = function(a) {
        var b = this.constructor.compatOptions[a];
        return b && void 0 !== this.options[b]
          ? this.options[b]
          : this.options[a];
      }),
      (f.compatOptions = {
        initLayout: "isInitLayout",
        horizontal: "isHorizontal",
        layoutInstant: "isLayoutInstant",
        originLeft: "isOriginLeft",
        originTop: "isOriginTop",
        resize: "isResizeBound",
        resizeContainer: "isResizingContainer"
      }),
      (n._create = function() {
        this.reloadItems(),
          (this.stamps = []),
          this.stamp(this.options.stamp),
          d.extend(this.element.style, this.options.containerStyle);
        var a = this._getOption("resize");
        a && this.bindResize();
      }),
      (n.reloadItems = function() {
        this.items = this._itemize(this.element.children);
      }),
      (n._itemize = function(a) {
        for (
          var b = this._filterFindItemElements(a),
            c = this.constructor.Item,
            d = [],
            e = 0;
          e < b.length;
          e++
        ) {
          var f = b[e],
            g = new c(f, this);
          d.push(g);
        }
        return d;
      }),
      (n._filterFindItemElements = function(a) {
        return d.filterFindElements(a, this.options.itemSelector);
      }),
      (n.getItemElements = function() {
        return this.items.map(function(a) {
          return a.element;
        });
      }),
      (n.layout = function() {
        this._resetLayout(), this._manageStamps();
        var a = this._getOption("layoutInstant"),
          b = void 0 !== a ? a : !this._isLayoutInited;
        this.layoutItems(this.items, b), (this._isLayoutInited = !0);
      }),
      (n._init = n.layout),
      (n._resetLayout = function() {
        this.getSize();
      }),
      (n.getSize = function() {
        this.size = c(this.element);
      }),
      (n._getMeasurement = function(a, b) {
        var d,
          e = this.options[a];
        e
          ? ("string" == typeof e
              ? (d = this.element.querySelector(e))
              : e instanceof HTMLElement && (d = e),
            (this[a] = d ? c(d)[b] : e))
          : (this[a] = 0);
      }),
      (n.layoutItems = function(a, b) {
        (a = this._getItemsForLayout(a)),
          this._layoutItems(a, b),
          this._postLayout();
      }),
      (n._getItemsForLayout = function(a) {
        return a.filter(function(a) {
          return !a.isIgnored;
        });
      }),
      (n._layoutItems = function(a, b) {
        if ((this._emitCompleteOnItems("layout", a), a && a.length)) {
          var c = [];
          a.forEach(function(a) {
            var d = this._getItemLayoutPosition(a);
            (d.item = a), (d.isInstant = b || a.isLayoutInstant), c.push(d);
          }, this),
            this._processLayoutQueue(c);
        }
      }),
      (n._getItemLayoutPosition = function() {
        return { x: 0, y: 0 };
      }),
      (n._processLayoutQueue = function(a) {
        this.updateStagger(),
          a.forEach(function(a, b) {
            this._positionItem(a.item, a.x, a.y, a.isInstant, b);
          }, this);
      }),
      (n.updateStagger = function() {
        var a = this.options.stagger;
        return null === a || void 0 === a
          ? void (this.stagger = 0)
          : ((this.stagger = h(a)), this.stagger);
      }),
      (n._positionItem = function(a, b, c, d, e) {
        d ? a.goTo(b, c) : (a.stagger(e * this.stagger), a.moveTo(b, c));
      }),
      (n._postLayout = function() {
        this.resizeContainer();
      }),
      (n.resizeContainer = function() {
        var a = this._getOption("resizeContainer");
        if (a) {
          var b = this._getContainerSize();
          b &&
            (this._setContainerMeasure(b.width, !0),
            this._setContainerMeasure(b.height, !1));
        }
      }),
      (n._getContainerSize = k),
      (n._setContainerMeasure = function(a, b) {
        if (void 0 !== a) {
          var c = this.size;
          c.isBorderBox &&
            (a += b
              ? c.paddingLeft +
                c.paddingRight +
                c.borderLeftWidth +
                c.borderRightWidth
              : c.paddingBottom +
                c.paddingTop +
                c.borderTopWidth +
                c.borderBottomWidth),
            (a = Math.max(a, 0)),
            (this.element.style[b ? "width" : "height"] = a + "px");
        }
      }),
      (n._emitCompleteOnItems = function(a, b) {
        function c() {
          e.dispatchEvent(a + "Complete", null, [b]);
        }
        function d() {
          g++, g == f && c();
        }
        var e = this,
          f = b.length;
        if (!b || !f) return void c();
        var g = 0;
        b.forEach(function(b) {
          b.once(a, d);
        });
      }),
      (n.dispatchEvent = function(a, b, c) {
        var d = b ? [b].concat(c) : c;
        if ((this.emitEvent(a, d), j))
          if (((this.$element = this.$element || j(this.element)), b)) {
            var e = j.Event(b);
            (e.type = a), this.$element.trigger(e, c);
          } else this.$element.trigger(a, c);
      }),
      (n.ignore = function(a) {
        var b = this.getItem(a);
        b && (b.isIgnored = !0);
      }),
      (n.unignore = function(a) {
        var b = this.getItem(a);
        b && delete b.isIgnored;
      }),
      (n.stamp = function(a) {
        (a = this._find(a)),
          a &&
            ((this.stamps = this.stamps.concat(a)),
            a.forEach(this.ignore, this));
      }),
      (n.unstamp = function(a) {
        (a = this._find(a)),
          a &&
            a.forEach(function(a) {
              d.removeFrom(this.stamps, a), this.unignore(a);
            }, this);
      }),
      (n._find = function(a) {
        if (a)
          return (
            "string" == typeof a && (a = this.element.querySelectorAll(a)),
            (a = d.makeArray(a))
          );
      }),
      (n._manageStamps = function() {
        this.stamps &&
          this.stamps.length &&
          (this._getBoundingRect(),
          this.stamps.forEach(this._manageStamp, this));
      }),
      (n._getBoundingRect = function() {
        var a = this.element.getBoundingClientRect(),
          b = this.size;
        this._boundingRect = {
          left: a.left + b.paddingLeft + b.borderLeftWidth,
          top: a.top + b.paddingTop + b.borderTopWidth,
          right: a.right - (b.paddingRight + b.borderRightWidth),
          bottom: a.bottom - (b.paddingBottom + b.borderBottomWidth)
        };
      }),
      (n._manageStamp = k),
      (n._getElementOffset = function(a) {
        var b = a.getBoundingClientRect(),
          d = this._boundingRect,
          e = c(a),
          f = {
            left: b.left - d.left - e.marginLeft,
            top: b.top - d.top - e.marginTop,
            right: d.right - b.right - e.marginRight,
            bottom: d.bottom - b.bottom - e.marginBottom
          };
        return f;
      }),
      (n.handleEvent = d.handleEvent),
      (n.bindResize = function() {
        a.addEventListener("resize", this), (this.isResizeBound = !0);
      }),
      (n.unbindResize = function() {
        a.removeEventListener("resize", this), (this.isResizeBound = !1);
      }),
      (n.onresize = function() {
        this.resize();
      }),
      d.debounceMethod(f, "onresize", 100),
      (n.resize = function() {
        this.isResizeBound && this.needsResizeLayout() && this.layout();
      }),
      (n.needsResizeLayout = function() {
        var a = c(this.element),
          b = this.size && a;
        return b && a.innerWidth !== this.size.innerWidth;
      }),
      (n.addItems = function(a) {
        var b = this._itemize(a);
        return b.length && (this.items = this.items.concat(b)), b;
      }),
      (n.appended = function(a) {
        var b = this.addItems(a);
        b.length && (this.layoutItems(b, !0), this.reveal(b));
      }),
      (n.prepended = function(a) {
        var b = this._itemize(a);
        if (b.length) {
          var c = this.items.slice(0);
          (this.items = b.concat(c)),
            this._resetLayout(),
            this._manageStamps(),
            this.layoutItems(b, !0),
            this.reveal(b),
            this.layoutItems(c);
        }
      }),
      (n.reveal = function(a) {
        if ((this._emitCompleteOnItems("reveal", a), a && a.length)) {
          var b = this.updateStagger();
          a.forEach(function(a, c) {
            a.stagger(c * b), a.reveal();
          });
        }
      }),
      (n.hide = function(a) {
        if ((this._emitCompleteOnItems("hide", a), a && a.length)) {
          var b = this.updateStagger();
          a.forEach(function(a, c) {
            a.stagger(c * b), a.hide();
          });
        }
      }),
      (n.revealItemElements = function(a) {
        var b = this.getItems(a);
        this.reveal(b);
      }),
      (n.hideItemElements = function(a) {
        var b = this.getItems(a);
        this.hide(b);
      }),
      (n.getItem = function(a) {
        for (var b = 0; b < this.items.length; b++) {
          var c = this.items[b];
          if (c.element == a) return c;
        }
      }),
      (n.getItems = function(a) {
        a = d.makeArray(a);
        var b = [];
        return (
          a.forEach(function(a) {
            var c = this.getItem(a);
            c && b.push(c);
          }, this),
          b
        );
      }),
      (n.remove = function(a) {
        var b = this.getItems(a);
        this._emitCompleteOnItems("remove", b),
          b &&
            b.length &&
            b.forEach(function(a) {
              a.remove(), d.removeFrom(this.items, a);
            }, this);
      }),
      (n.destroy = function() {
        var a = this.element.style;
        (a.height = ""),
          (a.position = ""),
          (a.width = ""),
          this.items.forEach(function(a) {
            a.destroy();
          }),
          this.unbindResize();
        var b = this.element.outlayerGUID;
        delete m[b],
          delete this.element.outlayerGUID,
          j && j.removeData(this.element, this.constructor.namespace);
      }),
      (f.data = function(a) {
        a = d.getQueryElement(a);
        var b = a && a.outlayerGUID;
        return b && m[b];
      }),
      (f.create = function(a, b) {
        var c = g(f);
        return (
          (c.defaults = d.extend({}, f.defaults)),
          d.extend(c.defaults, b),
          (c.compatOptions = d.extend({}, f.compatOptions)),
          (c.namespace = a),
          (c.data = f.data),
          (c.Item = g(e)),
          d.htmlInit(c, a),
          j && j.bridget && j.bridget(a, c),
          c
        );
      });
    var o = { ms: 1, s: 1e3 };
    return (f.Item = e), f;
  }),
  (function(a, b) {
    "function" == typeof define && define.amd
      ? define("isotope/item", ["outlayer/outlayer"], b)
      : "object" == typeof module && module.exports
      ? (module.exports = b(require("outlayer")))
      : ((a.Isotope = a.Isotope || {}), (a.Isotope.Item = b(a.Outlayer)));
  })(window, function(a) {
    "use strict";
    function b() {
      a.Item.apply(this, arguments);
    }
    var c = (b.prototype = Object.create(a.Item.prototype)),
      d = c._create;
    (c._create = function() {
      (this.id = this.layout.itemGUID++), d.call(this), (this.sortData = {});
    }),
      (c.updateSortData = function() {
        if (!this.isIgnored) {
          (this.sortData.id = this.id),
            (this.sortData["original-order"] = this.id),
            (this.sortData.random = Math.random());
          var a = this.layout.options.getSortData,
            b = this.layout._sorters;
          for (var c in a) {
            var d = b[c];
            this.sortData[c] = d(this.element, this);
          }
        }
      });
    var e = c.destroy;
    return (
      (c.destroy = function() {
        e.apply(this, arguments), this.css({ display: "" });
      }),
      b
    );
  }),
  (function(a, b) {
    "function" == typeof define && define.amd
      ? define("isotope/layout-mode", [
          "get-size/get-size",
          "outlayer/outlayer"
        ], b)
      : "object" == typeof module && module.exports
      ? (module.exports = b(require("get-size"), require("outlayer")))
      : ((a.Isotope = a.Isotope || {}),
        (a.Isotope.LayoutMode = b(a.getSize, a.Outlayer)));
  })(window, function(a, b) {
    "use strict";
    function c(a) {
      (this.isotope = a),
        a &&
          ((this.options = a.options[this.namespace]),
          (this.element = a.element),
          (this.items = a.filteredItems),
          (this.size = a.size));
    }
    var d = c.prototype,
      e = [
        "_resetLayout",
        "_getItemLayoutPosition",
        "_manageStamp",
        "_getContainerSize",
        "_getElementOffset",
        "needsResizeLayout",
        "_getOption"
      ];
    return (
      e.forEach(function(a) {
        d[a] = function() {
          return b.prototype[a].apply(this.isotope, arguments);
        };
      }),
      (d.needsVerticalResizeLayout = function() {
        var b = a(this.isotope.element),
          c = this.isotope.size && b;
        return c && b.innerHeight != this.isotope.size.innerHeight;
      }),
      (d._getMeasurement = function() {
        this.isotope._getMeasurement.apply(this, arguments);
      }),
      (d.getColumnWidth = function() {
        this.getSegmentSize("column", "Width");
      }),
      (d.getRowHeight = function() {
        this.getSegmentSize("row", "Height");
      }),
      (d.getSegmentSize = function(a, b) {
        var c = a + b,
          d = "outer" + b;
        if ((this._getMeasurement(c, d), !this[c])) {
          var e = this.getFirstItemSize();
          this[c] = (e && e[d]) || this.isotope.size["inner" + b];
        }
      }),
      (d.getFirstItemSize = function() {
        var b = this.isotope.filteredItems[0];
        return b && b.element && a(b.element);
      }),
      (d.layout = function() {
        this.isotope.layout.apply(this.isotope, arguments);
      }),
      (d.getSize = function() {
        this.isotope.getSize(), (this.size = this.isotope.size);
      }),
      (c.modes = {}),
      (c.create = function(a, b) {
        function e() {
          c.apply(this, arguments);
        }
        return (
          (e.prototype = Object.create(d)),
          (e.prototype.constructor = e),
          b && (e.options = b),
          (e.prototype.namespace = a),
          (c.modes[a] = e),
          e
        );
      }),
      c
    );
  }),
  (function(a, b) {
    "function" == typeof define && define.amd
      ? define("masonry/masonry", ["outlayer/outlayer", "get-size/get-size"], b)
      : "object" == typeof module && module.exports
      ? (module.exports = b(require("outlayer"), require("get-size")))
      : (a.Masonry = b(a.Outlayer, a.getSize));
  })(window, function(a, b) {
    var c = a.create("masonry");
    return (
      (c.compatOptions.fitWidth = "isFitWidth"),
      (c.prototype._resetLayout = function() {
        this.getSize(),
          this._getMeasurement("columnWidth", "outerWidth"),
          this._getMeasurement("gutter", "outerWidth"),
          this.measureColumns(),
          (this.colYs = []);
        for (var a = 0; a < this.cols; a++) this.colYs.push(0);
        this.maxY = 0;
      }),
      (c.prototype.measureColumns = function() {
        if ((this.getContainerWidth(), !this.columnWidth)) {
          var a = this.items[0],
            c = a && a.element;
          this.columnWidth = (c && b(c).outerWidth) || this.containerWidth;
        }
        var d = (this.columnWidth += this.gutter),
          e = this.containerWidth + this.gutter,
          f = e / d,
          g = d - (e % d),
          h = g && g < 1 ? "round" : "floor";
        (f = Math[h](f)), (this.cols = Math.max(f, 1));
      }),
      (c.prototype.getContainerWidth = function() {
        var a = this._getOption("fitWidth"),
          c = a ? this.element.parentNode : this.element,
          d = b(c);
        this.containerWidth = d && d.innerWidth;
      }),
      (c.prototype._getItemLayoutPosition = function(a) {
        a.getSize();
        var b = a.size.outerWidth % this.columnWidth,
          c = b && b < 1 ? "round" : "ceil",
          d = Math[c](a.size.outerWidth / this.columnWidth);
        d = Math.min(d, this.cols);
        for (
          var e = this._getColGroup(d),
            f = Math.min.apply(Math, e),
            g = e.indexOf(f),
            h = { x: this.columnWidth * g, y: f },
            i = f + a.size.outerHeight,
            j = this.cols + 1 - e.length,
            k = 0;
          k < j;
          k++
        )
          this.colYs[g + k] = i;
        return h;
      }),
      (c.prototype._getColGroup = function(a) {
        if (a < 2) return this.colYs;
        for (var b = [], c = this.cols + 1 - a, d = 0; d < c; d++) {
          var e = this.colYs.slice(d, d + a);
          b[d] = Math.max.apply(Math, e);
        }
        return b;
      }),
      (c.prototype._manageStamp = function(a) {
        var c = b(a),
          d = this._getElementOffset(a),
          e = this._getOption("originLeft"),
          f = e ? d.left : d.right,
          g = f + c.outerWidth,
          h = Math.floor(f / this.columnWidth);
        h = Math.max(0, h);
        var i = Math.floor(g / this.columnWidth);
        (i -= g % this.columnWidth ? 0 : 1), (i = Math.min(this.cols - 1, i));
        for (
          var j = this._getOption("originTop"),
            k = (j ? d.top : d.bottom) + c.outerHeight,
            l = h;
          l <= i;
          l++
        )
          this.colYs[l] = Math.max(k, this.colYs[l]);
      }),
      (c.prototype._getContainerSize = function() {
        this.maxY = Math.max.apply(Math, this.colYs);
        var a = { height: this.maxY };
        return (
          this._getOption("fitWidth") &&
            (a.width = this._getContainerFitWidth()),
          a
        );
      }),
      (c.prototype._getContainerFitWidth = function() {
        for (var a = 0, b = this.cols; --b && 0 === this.colYs[b]; ) a++;
        return (this.cols - a) * this.columnWidth - this.gutter;
      }),
      (c.prototype.needsResizeLayout = function() {
        var a = this.containerWidth;
        return this.getContainerWidth(), a != this.containerWidth;
      }),
      c
    );
  }),
  (function(a, b) {
    "function" == typeof define && define.amd
      ? define("isotope/layout-modes/masonry", [
          "../layout-mode",
          "masonry/masonry"
        ], b)
      : "object" == typeof module && module.exports
      ? (module.exports = b(
          require("../layout-mode"),
          require("masonry-layout")
        ))
      : b(a.Isotope.LayoutMode, a.Masonry);
  })(window, function(a, b) {
    "use strict";
    var c = a.create("masonry"),
      d = c.prototype,
      e = { _getElementOffset: !0, layout: !0, _getMeasurement: !0 };
    for (var f in b.prototype) e[f] || (d[f] = b.prototype[f]);
    var g = d.measureColumns;
    d.measureColumns = function() {
      (this.items = this.isotope.filteredItems), g.call(this);
    };
    var h = d._getOption;
    return (
      (d._getOption = function(a) {
        return "fitWidth" == a
          ? void 0 !== this.options.isFitWidth
            ? this.options.isFitWidth
            : this.options.fitWidth
          : h.apply(this.isotope, arguments);
      }),
      c
    );
  }),
  (function(a, b) {
    "function" == typeof define && define.amd
      ? define("isotope/layout-modes/fit-rows", ["../layout-mode"], b)
      : "object" == typeof exports
      ? (module.exports = b(require("../layout-mode")))
      : b(a.Isotope.LayoutMode);
  })(window, function(a) {
    "use strict";
    var b = a.create("fitRows"),
      c = b.prototype;
    return (
      (c._resetLayout = function() {
        (this.x = 0),
          (this.y = 0),
          (this.maxY = 0),
          this._getMeasurement("gutter", "outerWidth");
      }),
      (c._getItemLayoutPosition = function(a) {
        a.getSize();
        var b = a.size.outerWidth + this.gutter,
          c = this.isotope.size.innerWidth + this.gutter;
        0 !== this.x && b + this.x > c && ((this.x = 0), (this.y = this.maxY));
        var d = { x: this.x, y: this.y };
        return (
          (this.maxY = Math.max(this.maxY, this.y + a.size.outerHeight)),
          (this.x += b),
          d
        );
      }),
      (c._getContainerSize = function() {
        return { height: this.maxY };
      }),
      b
    );
  }),
  (function(a, b) {
    "function" == typeof define && define.amd
      ? define("isotope/layout-modes/vertical", ["../layout-mode"], b)
      : "object" == typeof module && module.exports
      ? (module.exports = b(require("../layout-mode")))
      : b(a.Isotope.LayoutMode);
  })(window, function(a) {
    "use strict";
    var b = a.create("vertical", { horizontalAlignment: 0 }),
      c = b.prototype;
    return (
      (c._resetLayout = function() {
        this.y = 0;
      }),
      (c._getItemLayoutPosition = function(a) {
        a.getSize();
        var b =
            (this.isotope.size.innerWidth - a.size.outerWidth) *
            this.options.horizontalAlignment,
          c = this.y;
        return (this.y += a.size.outerHeight), { x: b, y: c };
      }),
      (c._getContainerSize = function() {
        return { height: this.y };
      }),
      b
    );
  }),
  (function(a, b) {
    "function" == typeof define && define.amd
      ? define([
          "outlayer/outlayer",
          "get-size/get-size",
          "desandro-matches-selector/matches-selector",
          "fizzy-ui-utils/utils",
          "./item",
          "./layout-mode",
          "./layout-modes/masonry",
          "./layout-modes/fit-rows",
          "./layout-modes/vertical"
        ], function(c, d, e, f, g, h) {
          return b(a, c, d, e, f, g, h);
        })
      : "object" == typeof module && module.exports
      ? (module.exports = b(
          a,
          require("outlayer"),
          require("get-size"),
          require("desandro-matches-selector"),
          require("fizzy-ui-utils"),
          require("./item"),
          require("./layout-mode"),
          require("./layout-modes/masonry"),
          require("./layout-modes/fit-rows"),
          require("./layout-modes/vertical")
        ))
      : (a.Isotope = b(
          a,
          a.Outlayer,
          a.getSize,
          a.matchesSelector,
          a.fizzyUIUtils,
          a.Isotope.Item,
          a.Isotope.LayoutMode
        ));
  })(window, function(a, b, c, d, e, f, g) {
    function h(a, b) {
      return function(c, d) {
        for (var e = 0; e < a.length; e++) {
          var f = a[e],
            g = c.sortData[f],
            h = d.sortData[f];
          if (g > h || g < h) {
            var i = void 0 !== b[f] ? b[f] : b,
              j = i ? 1 : -1;
            return (g > h ? 1 : -1) * j;
          }
        }
        return 0;
      };
    }
    function i(a) {
      var b = a.create("fitRows");
      return (
        (b.prototype._resetLayout = function() {
          if (
            ((this.x = 0),
            (this.y = 0),
            (this.maxY = 0),
            (this.row = 0),
            (this.rows = []),
            this._getMeasurement("gutter", "outerWidth"),
            this.isotope.options.equalheight)
          )
            for (var a = 0; a < this.isotope.items.length; a++)
              this.isotope.items[a].css({ height: "auto" });
        }),
        (b.prototype._getItemLayoutPosition = function(a) {
          a.getSize();
          var b = a.size.outerWidth,
            c = Math.ceil(this.isotope.size.innerWidth + 1);
          0 !== this.x &&
            b + this.x > c &&
            ((this.x = 0), (this.y = this.maxY)),
            0 == this.x && 0 != this.y && this.row++;
          var d = { x: this.x, y: this.y };
          return (
            (this.maxY = Math.max(this.maxY, this.y + a.size.outerHeight)),
            (this.x += b),
            "undefined" == typeof this.rows[this.row]
              ? ((this.rows[this.row] = []),
                (this.rows[this.row].start = this.y),
                (this.rows[this.row].end = this.maxY))
              : (this.rows[this.row].end = Math.max(
                  this.rows[this.row].end,
                  this.maxY
                )),
            (a.row = this.row),
            d
          );
        }),
        (b.prototype._equalHeight = function() {
          for (var a = 0; a < this.isotope.items.length; a++) {
            var b = this.isotope.items[a].row,
              c = this.rows[b];
            if (c) {
              var d = c.end - c.start;
              (d -=
                this.isotope.items[a].size.borderTopWidth +
                this.isotope.items[a].size.borderBottomWidth),
                (d -=
                  this.isotope.items[a].size.marginTop +
                  this.isotope.items[a].size.marginBottom),
                (d -= this.gutter.height || 0),
                0 == this.isotope.items[a].size.isBorderBox &&
                  (d -=
                    this.isotope.items[a].size.paddingTop +
                    this.isotope.items[a].size.paddingBottom),
                (this.isotope.items[a].size.height = d),
                this.isotope.items[a].css({ height: d.toString() + "px" });
            }
          }
        }),
        (b.prototype._getContainerSize = function() {
          return (
            this.isotope.options.equalheight && this._equalHeight(),
            { height: this.maxY }
          );
        }),
        b
      );
    }
    var j = a.jQuery,
      k = String.prototype.trim
        ? function(a) {
            return a.trim();
          }
        : function(a) {
            return a.replace(/^\s+|\s+$/g, "");
          },
      l = b.create("isotope", {
        layoutMode: "masonry",
        isJQueryFiltering: !0,
        sortAscending: !0
      });
    (l.Item = f), (l.LayoutMode = g);
    var m = l.prototype;
    (m._create = function() {
      (this.itemGUID = 0),
        (this._sorters = {}),
        this._getSorters(),
        b.prototype._create.call(this),
        (this.modes = {}),
        (this.filteredItems = this.items),
        (this.sortHistory = ["original-order"]);
      for (var a in g.modes) this._initLayoutMode(a);
    }),
      (m.reloadItems = function() {
        (this.itemGUID = 0), b.prototype.reloadItems.call(this);
      }),
      (m._itemize = function() {
        for (
          var a = b.prototype._itemize.apply(this, arguments), c = 0;
          c < a.length;
          c++
        ) {
          var d = a[c];
          d.id = this.itemGUID++;
        }
        return this._updateItemsSortData(a), a;
      }),
      (m._initLayoutMode = function(a) {
        var b = g.modes[a],
          c = this.options[a] || {};
        (this.options[a] = b.options ? e.extend(b.options, c) : c),
          (this.modes[a] = new b(this));
      }),
      (m.layout = function() {
        return !this._isLayoutInited && this._getOption("initLayout")
          ? void this.arrange()
          : void this._layout();
      }),
      (m._layout = function() {
        var a = this._getIsInstant();
        this._resetLayout(),
          this._manageStamps(),
          this.layoutItems(this.filteredItems, a),
          (this._isLayoutInited = !0);
      }),
      (m.arrange = function(a) {
        this.option(a), this._getIsInstant();
        var b = this._filter(this.items);
        (this.filteredItems = b.matches),
          this._bindArrangeComplete(),
          this._isInstant
            ? this._noTransition(this._hideReveal, [b])
            : this._hideReveal(b),
          this._sort(),
          this._layout();
      }),
      (m._init = m.arrange),
      (m._hideReveal = function(a) {
        this.reveal(a.needReveal), this.hide(a.needHide);
      }),
      (m._getIsInstant = function() {
        var a = this._getOption("layoutInstant"),
          b = void 0 !== a ? a : !this._isLayoutInited;
        return (this._isInstant = b), b;
      }),
      (m._bindArrangeComplete = function() {
        function a() {
          b &&
            c &&
            d &&
            e.dispatchEvent("arrangeComplete", null, [e.filteredItems]);
        }
        var b,
          c,
          d,
          e = this;
        this.once("layoutComplete", function() {
          (b = !0), a();
        }),
          this.once("hideComplete", function() {
            (c = !0), a();
          }),
          this.once("revealComplete", function() {
            (d = !0), a();
          });
      }),
      (m._filter = function(a) {
        var b = this.options.filter;
        b = b || "*";
        for (
          var c = [], d = [], e = [], f = this._getFilterTest(b), g = 0;
          g < a.length;
          g++
        ) {
          var h = a[g];
          if (!h.isIgnored) {
            var i = f(h);
            i && c.push(h),
              i && h.isHidden ? d.push(h) : i || h.isHidden || e.push(h);
          }
        }
        return { matches: c, needReveal: d, needHide: e };
      }),
      (m._getFilterTest = function(a) {
        return j && this.options.isJQueryFiltering
          ? function(b) {
              return j(b.element).is(a);
            }
          : "function" == typeof a
          ? function(b) {
              return a(b.element);
            }
          : function(b) {
              return d(b.element, a);
            };
      }),
      (m.updateSortData = function(a) {
        var b;
        a ? ((a = e.makeArray(a)), (b = this.getItems(a))) : (b = this.items),
          this._getSorters(),
          this._updateItemsSortData(b);
      }),
      (m._getSorters = function() {
        var a = this.options.getSortData;
        for (var b in a) {
          var c = a[b];
          this._sorters[b] = n(c);
        }
      }),
      (m._updateItemsSortData = function(a) {
        for (var b = a && a.length, c = 0; b && c < b; c++) {
          var d = a[c];
          d.updateSortData();
        }
      });
    var n = (function() {
      function a(a) {
        if ("string" != typeof a) return a;
        var c = k(a).split(" "),
          d = c[0],
          e = d.match(/^\[(.+)\]$/),
          f = e && e[1],
          g = b(f, d),
          h = l.sortDataParsers[c[1]];
        return (a = h
          ? function(a) {
              return a && h(g(a));
            }
          : function(a) {
              return a && g(a);
            });
      }
      function b(a, b) {
        return a
          ? function(b) {
              return b.getAttribute(a);
            }
          : function(a) {
              var c = a.querySelector(b);
              return c && c.textContent;
            };
      }
      return a;
    })();
    (l.sortDataParsers = {
      parseInt: function(a) {
        return parseInt(a, 10);
      },
      parseFloat: function(a) {
        return parseFloat(a);
      }
    }),
      (m._sort = function() {
        var a = this.options.sortBy;
        if (a) {
          var b = [].concat.apply(a, this.sortHistory),
            c = h(b, this.options.sortAscending);
          this.filteredItems.sort(c),
            a != this.sortHistory[0] && this.sortHistory.unshift(a);
        }
      }),
      (m._mode = function() {
        var a = this.options.layoutMode,
          b = this.modes[a];
        if (!b) throw new Error("No layout mode: " + a);
        return (b.options = this.options[a]), b;
      }),
      (m._resetLayout = function() {
        b.prototype._resetLayout.call(this), this._mode()._resetLayout();
      }),
      (m._getItemLayoutPosition = function(a) {
        return this._mode()._getItemLayoutPosition(a);
      }),
      (m._manageStamp = function(a) {
        this._mode()._manageStamp(a);
      }),
      (m._getContainerSize = function() {
        return this._mode()._getContainerSize();
      }),
      (m.needsResizeLayout = function() {
        return this._mode().needsResizeLayout();
      }),
      (m.appended = function(a) {
        var b = this.addItems(a);
        if (b.length) {
          var c = this._filterRevealAdded(b);
          this.filteredItems = this.filteredItems.concat(c);
        }
      }),
      (m.prepended = function(a) {
        var b = this._itemize(a);
        if (b.length) {
          this._resetLayout(), this._manageStamps();
          var c = this._filterRevealAdded(b);
          this.layoutItems(this.filteredItems),
            (this.filteredItems = c.concat(this.filteredItems)),
            (this.items = b.concat(this.items));
        }
      }),
      (m._filterRevealAdded = function(a) {
        var b = this._filter(a);
        return (
          this.hide(b.needHide),
          this.reveal(b.matches),
          this.layoutItems(b.matches, !0),
          b.matches
        );
      }),
      (m.insert = function(a) {
        var b = this.addItems(a);
        if (b.length) {
          var c,
            d,
            e = b.length;
          for (c = 0; c < e; c++)
            (d = b[c]), this.element.appendChild(d.element);
          var f = this._filter(b).matches;
          for (c = 0; c < e; c++) b[c].isLayoutInstant = !0;
          for (this.arrange(), c = 0; c < e; c++) delete b[c].isLayoutInstant;
          this.reveal(f);
        }
      });
    var o = m.remove;
    return (
      (m.remove = function(a) {
        a = e.makeArray(a);
        var b = this.getItems(a);
        o.call(this, a);
        for (var c = b && b.length, d = 0; c && d < c; d++) {
          var f = b[d];
          e.removeFrom(this.filteredItems, f);
        }
      }),
      (m.shuffle = function() {
        for (var a = 0; a < this.items.length; a++) {
          var b = this.items[a];
          b.sortData.random = Math.random();
        }
        (this.options.sortBy = "random"), this._sort(), this._layout();
      }),
      (m._noTransition = function(a, b) {
        var c = this.options.transitionDuration;
        this.options.transitionDuration = 0;
        var d = a.apply(this, b);
        return (this.options.transitionDuration = c), d;
      }),
      (m.getFilteredItemElements = function() {
        return this.filteredItems.map(function(a) {
          return a.element;
        });
      }),
      "function" == typeof define && define.amd
        ? define(["../layout-mode"], i)
        : "object" == typeof exports
        ? (module.exports = i(require("../layout-mode")))
        : i(a.Isotope.LayoutMode),
      l
    );
  }),
  (function(a, b, c, d) {
    var e = (a(c), a(b));
    return (a.fn.Filterade = function(b) {
      var c, d, f, g, h, i, j, k, l, m, n, o, p, q, r, s, t, u, v, w, x, y;
      (i = {
        useFilters: !1,
        useSorting: !1,
        filterControls: ".filter-controls",
        sortControls: ".sort-controls",
        orderControls: ".order-controls",
        controlsSelecter: "input",
        controlsSelecterChecked: 'input[checked="checked"]',
        defaultFilter: "all",
        defaultSort: "date",
        defaultOrder: "desc",
        selectAll: "all",
        paginationMode: "pages",
        pageLimit: 15,
        pageControls: ".page-controls",
        previousButtonClass: "nav-prev",
        previousButtonLabel:
          '<i class="dt-icon-the7-arrow-0-42" aria-hidden="true"></i>',
        nextButtonClass: "nav-next",
        nextButtonLabel:
          '<i class="dt-icon-the7-arrow-0-41" aria-hidden="true"></i>',
        loadMoreButtonClass: "button-load-more",
        loadMoreButtonLabel: "Load more",
        pagerClass: "page",
        activeClass: "act",
        log: !1
      }),
        (h = a(this)),
        (s = b.paginationMode || i.paginationMode),
        (t = a(b.pageControls || i.pageControls)),
        (j = a(b.filterControls || i.filterControls)),
        (k = a(b.sortControls || i.sortControls)),
        (l = a(b.orderControls || i.orderControls)),
        (m = b.controlsSelecter || i.controlsSelecter),
        (n = b.controlsSelecterChecked || i.controlsSelecterChecked),
        (d = 1);
      var z = a(".phantom-sticky").exists(),
        A = a(".sticky-top-line").exists();
      if (z || A) var B = a(".masthead");
      else var B = a("#phantom");
      return (
        (r = a([])),
        (r.$nodesCache = a([])),
        h.find("> article, .wf-cell").each(function() {
          var b = a(this);
          r.push({
            node: this,
            $node: b,
            name: b.attr("data-name"),
            date: new Date(b.attr("data-date"))
          }),
            r.$nodesCache.push(this);
        }),
        (u = Math.ceil(r.length / b.pageLimit)),
        (p = function() {
          var a;
          ("pages" !== s && "load-more" !== s) ||
            ((a = 0),
            r.each(function() {
              if (this.$node.hasClass("visible")) return a++;
            }),
            (u = Math.ceil(a / (b.pageLimit || i.pageLimit))));
        }),
        (v = function() {
          if ("pages" === s) {
            var c, e;
            if ((t.empty(), u > 1)) {
              1 !== d &&
                t.prepend(
                  '<a href="#" class="' +
                    (b.previousButtonClass || i.previousButtonClass) +
                    '">' +
                    (b.previousButtonLabel || i.previousButtonLabel) +
                    "</a>"
                );
              var f = 5,
                g = f - 1,
                j = Math.floor(g / 2),
                k = Math.ceil(g / 2),
                l = Math.max(d - j, 1),
                m = d + k;
              l <= j && (m = l + g),
                m > u && ((l = Math.max(u - g, 1)), (m = u));
              var n = a('<div style="display: none;"></div>'),
                o = a('<div style="display: none;"></div>');
              for (c = e = 1; 1 <= u ? e <= u : e >= u; c = 1 <= u ? ++e : --e)
                c < l && 1 != c
                  ? n.append(
                      '<a href="#" class="' +
                        (b.pagerClass || i.pagerClass) +
                        '" data-page="' +
                        +c +
                        '">' +
                        c +
                        "</a>"
                    )
                  : (c == l && n.children().length && t.append(n),
                    c > m && c != u
                      ? o.append(
                          '<a href="#" class="' +
                            (b.pagerClass || i.pagerClass) +
                            '" data-page="' +
                            +c +
                            '">' +
                            c +
                            "</a>"
                        )
                      : (c == u && o.children().length && t.append(o),
                        t.append(
                          '<a href="#" class="' +
                            (b.pagerClass || i.pagerClass) +
                            '" data-page="' +
                            +c +
                            '">' +
                            c +
                            "</a>"
                        )));
              return (
                d < u &&
                  t.append(
                    '<a href="#" class="' +
                      (b.nextButtonClass || i.nextButtonClass) +
                      '">' +
                      (b.nextButtonLabel || i.nextButtonLabel) +
                      "</a>"
                  ),
                t
                  .find('a[data-page="' + d + '"]')
                  .addClass(b.activeClass || i.activeClass),
                t
                  .find("a." + (b.pagerClass || i.pagerClass))
                  .click(function(c) {
                    if (
                      (c.preventDefault(),
                      (d = parseInt(a(this).attr("data-page"))),
                      t
                        .find("a." + (b.activeClass || i.activeClass))
                        .removeClass(b.activeClass || i.activeClass),
                      t
                        .find('a[data-page="' + d + '"]')
                        .addClass(b.activeClass || i.activeClass),
                      h.hasClass("dt-css-grid"))
                    )
                      var e = h.parent().offset().top - 40;
                    else var e = h.offset().top - 40;
                    return (
                      a("html, body").animate(
                        { scrollTop: e - B.height() },
                        400
                      ),
                      x()
                    );
                  }),
                t
                  .find("a." + (b.previousButtonClass || i.previousButtonClass))
                  .click(function(b) {
                    if ((b.preventDefault(), d--, h.hasClass("dt-css-grid")))
                      var c = h.parent().offset().top - 40;
                    else var c = h.offset().top - 40;
                    return (
                      a("html, body").animate(
                        { scrollTop: c - B.height() },
                        400
                      ),
                      x()
                    );
                  }),
                t
                  .find("a." + (b.nextButtonClass || i.nextButtonClass))
                  .click(function(b) {
                    if ((b.preventDefault(), d++, h.hasClass("dt-css-grid")))
                      var c = h.parent().offset().top - 40;
                    else var c = h.offset().top - 40;
                    return (
                      a("html, body").animate(
                        { scrollTop: c - B.height() },
                        400
                      ),
                      x()
                    );
                  })
              );
            }
          } else if ("load-more" === s && (t.empty(), u > 1))
            return (
              d < u
                ? t.append(
                    '<a href="#" class="' +
                      (b.loadMoreButtonClass || i.loadMoreButtonClass) +
                      '"><span class="stick"></span><span class="button-caption">' +
                      (b.loadMoreButtonLabel || i.loadMoreButtonLabel) +
                      "</span></a>"
                  )
                : t.css("display", "none"),
              t
                .find("a." + (b.loadMoreButtonClass || i.loadMoreButtonClass))
                .click(function(a) {
                  return a.preventDefault(), d++, x();
                })
            );
        }),
        (w = function() {
          if ("pages" === s || "load-more" === s) {
            var c = 0,
              e = a([]),
              f = a([]);
            r.each(function(a) {
              this.$node.hasClass("visible") &&
                (c++,
                "pages" === s &&
                c >
                  d * (b.pageLimit || i.pageLimit) -
                    (b.pageLimit || i.pageLimit) &&
                c <= (b.pageLimit || i.pageLimit) * d
                  ? f.push(this.node)
                  : "load-more" === s && c <= (b.pageLimit || i.pageLimit) * d
                  ? f.push(this.node)
                  : e.push(this.node));
            }),
              e.removeClass("visible").addClass("hidden"),
              f.removeClass("hidden").addClass("visible"),
              f.removeClass("first"),
              f.first().addClass("first"),
              h.trigger("updateReady");
          }
        }),
        (o = function() {
          var d = a([]),
            e = a([]);
          b.useFilters || i.useFilters
            ? c === (b.selectAll || i.selectAll)
              ? (e = r.$nodesCache)
              : r.each(function(a) {
                  this.$node.hasClass(c)
                    ? e.push(this.node)
                    : d.push(this.node);
                })
            : (e = r.$nodesCache),
            d.removeClass("visible").addClass("hidden"),
            e.removeClass("hidden").addClass("visible");
        }),
        (y = function() {
          "date" === f && "desc" === g
            ? r.sort(function(a, b) {
                return b.date - a.date;
              })
            : "date" === f && "asc" === g
            ? r.sort(function(a, b) {
                return a.date - b.date;
              })
            : "name" === f && "desc" === g
            ? r.sort(function(a, b) {
                var c = a.name.toLowerCase(),
                  d = b.name.toLowerCase();
                return c > d ? -1 : c < d ? 1 : 0;
              })
            : "name" === f &&
              "asc" === g &&
              r.sort(function(a, b) {
                var c = a.name.toLowerCase(),
                  d = b.name.toLowerCase();
                return c < d ? -1 : c > d ? 1 : 0;
              }),
            (r.$nodesCache = a([])),
            r.each(function() {
              r.$nodesCache.push(this.node);
            }),
            h.find(".paginator").length > 0
              ? r.$nodesCache.detach().insertBefore(h.find(".paginator"))
              : r.$nodesCache.detach().appendTo(h);
        }),
        (x = function() {
          if ((o(), p(), w(), v(), h.hasClass("lazy-loading-mode"))) {
            var b = h.find(".button-load-more").offset();
            b &&
              dtGlobals.winScrollTop > (b.top - e.height()) / 2 &&
              h.find(".button-load-more").trigger("click");
          }
          a(
            ".layzr-loading-on .blog-shortcode.jquery-filter.mode-list .visible:not(.shown)"
          ).layzrBlogInitialisation(),
            a(
              ".layzr-loading-on .jquery-filter.dt-css-grid-wrap .wf-cell.visible"
            ).layzrBlogInitialisation(),
            h.trigger("updateReady");
        }),
        (q = function() {
          return (
            (b.useFilters || i.useFilters) &&
              ((c =
                j.find(n).attr("data-filter") ||
                b.defaultFilter ||
                i.defaultFilter),
              j.find(m).click(function(b) {
                (c = a(this).attr("data-filter")), (d = 1), x();
              })),
            (b.useSorting || i.useSorting) &&
              ((f =
                k.find(n).attr("data-by") || b.defaultSort || i.defaultSort),
              (g =
                l.find(n).attr("data-sort") ||
                b.defaultOrder ||
                i.defaultOrder),
              k.find(m).click(function(a) {
                (f = "date" === this.getAttribute("data-by") ? "date" : "name"),
                  y(),
                  (d = 1),
                  x();
              }),
              l.find(m).click(function(a) {
                (g =
                  "desc" === this.getAttribute("data-sort") ? "desc" : "asc"),
                  y(),
                  (d = 1),
                  x();
              })),
            x()
          );
        })()
      );
    });
  })(jQuery, window, document),
  (function(a, b) {
    "function" == typeof define && define.amd
      ? define(b)
      : "object" == typeof exports
      ? (module.exports = b())
      : (a.ResizeSensor = b());
  })("undefined" != typeof window ? window : this, function() {
    function a(a, b) {
      var c = Object.prototype.toString.call(a),
        d =
          "[object Array]" === c ||
          "[object NodeList]" === c ||
          "[object HTMLCollection]" === c ||
          "[object Object]" === c ||
          ("undefined" != typeof jQuery && a instanceof jQuery) ||
          ("undefined" != typeof Elements && a instanceof Elements),
        e = 0,
        f = a.length;
      if (d) for (; e < f; e++) b(a[e]);
      else b(a);
    }
    function b(a) {
      if (!a.getBoundingClientRect)
        return { width: a.offsetWidth, height: a.offsetHeight };
      var b = a.getBoundingClientRect();
      return { width: Math.round(b.width), height: Math.round(b.height) };
    }
    if ("undefined" == typeof window) return null;
    var c =
        window.requestAnimationFrame ||
        window.mozRequestAnimationFrame ||
        window.webkitRequestAnimationFrame ||
        function(a) {
          return window.setTimeout(a, 20);
        },
      d = function(e, f) {
        function g() {
          var a = [];
          this.add = function(b) {
            a.push(b);
          };
          var b, c;
          (this.call = function(d) {
            for (b = 0, c = a.length; b < c; b++) a[b].call(this, d);
          }),
            (this.remove = function(d) {
              var e = [];
              for (b = 0, c = a.length; b < c; b++) a[b] !== d && e.push(a[b]);
              a = e;
            }),
            (this.length = function() {
              return a.length;
            });
        }
        function h(a, d) {
          if (a) {
            if (a.resizedAttached) return void a.resizedAttached.add(d);
            (a.resizedAttached = new g()),
              a.resizedAttached.add(d),
              (a.resizeSensor = document.createElement("div")),
              (a.resizeSensor.dir = "ltr"),
              (a.resizeSensor.className = "resize-sensor");
            var e =
                "pointer-events: none; position: absolute; left: 0px; top: 0px; right: 0; bottom: 0; overflow: hidden; z-index: -1; visibility: hidden; max-width: 100%;",
              f = "position: absolute; left: 0; top: 0; transition: 0s;";
            (a.resizeSensor.style.cssText = e),
              (a.resizeSensor.innerHTML =
                '<div class="resize-sensor-expand" style="' +
                e +
                '"><div style="' +
                f +
                '"></div></div><div class="resize-sensor-shrink" style="' +
                e +
                '"><div style="' +
                f +
                ' width: 200%; height: 200%"></div></div>'),
              a.appendChild(a.resizeSensor);
            var h = window.getComputedStyle(a),
              i = h ? h.getPropertyValue("position") : null;
            "absolute" !== i &&
              "relative" !== i &&
              "fixed" !== i &&
              (a.style.position = "relative");
            var j,
              k,
              l = a.resizeSensor.childNodes[0],
              m = l.childNodes[0],
              n = a.resizeSensor.childNodes[1],
              o = b(a),
              p = o.width,
              q = o.height,
              r = !0,
              s = 0,
              t = function() {
                var b = a.offsetWidth,
                  c = a.offsetHeight;
                (m.style.width = b + 10 + "px"),
                  (m.style.height = c + 10 + "px"),
                  (l.scrollLeft = b + 10),
                  (l.scrollTop = c + 10),
                  (n.scrollLeft = b + 10),
                  (n.scrollTop = c + 10);
              },
              u = function() {
                if (r) {
                  var b = 0 === a.offsetWidth && 0 === a.offsetHeight;
                  if (b)
                    return void (
                      s ||
                      (s = c(function() {
                        (s = 0), u();
                      }))
                    );
                  r = !1;
                }
                t();
              };
            a.resizeSensor.resetSensor = u;
            var v = function() {
                (k = 0),
                  j &&
                    ((p = o.width),
                    (q = o.height),
                    a.resizedAttached && a.resizedAttached.call(o));
              },
              w = function() {
                (o = b(a)),
                  (j = o.width !== p || o.height !== q),
                  j && !k && (k = c(v)),
                  u();
              },
              x = function(a, b, c) {
                a.attachEvent
                  ? a.attachEvent("on" + b, c)
                  : a.addEventListener(b, c);
              };
            x(l, "scroll", w), x(n, "scroll", w), c(u);
          }
        }
        a(e, function(a) {
          h(a, f);
        }),
          (this.detach = function(a) {
            d.detach(e, a);
          }),
          (this.reset = function() {
            e.resizeSensor.resetSensor();
          });
      };
    if (
      ((d.reset = function(b) {
        a(b, function(a) {
          a.resizeSensor.resetSensor();
        });
      }),
      (d.detach = function(b, c) {
        a(b, function(a) {
          a &&
            ((a.resizedAttached &&
              "function" == typeof c &&
              (a.resizedAttached.remove(c), a.resizedAttached.length())) ||
              (a.resizeSensor &&
                (a.contains(a.resizeSensor) && a.removeChild(a.resizeSensor),
                delete a.resizeSensor,
                delete a.resizedAttached)));
        });
      }),
      "undefined" != typeof MutationObserver)
    ) {
      var e = new MutationObserver(function(a) {
        for (var b in a)
          if (a.hasOwnProperty(b))
            for (var c = a[b].addedNodes, e = 0; e < c.length; e++)
              c[e].resizeSensor && d.reset(c[e]);
      });
      document.addEventListener("DOMContentLoaded", function(a) {
        e.observe(document.body, { childList: !0, subtree: !0 });
      });
    }
    return d;
  }),
  !(function(a, b) {
    "object" == typeof exports && "undefined" != typeof module
      ? b(exports)
      : "function" == typeof define && define.amd
      ? define(["exports"], b)
      : b((a.StickySidebar = {}));
  })(this, function(a) {
    "use strict";
    "undefined" != typeof window
      ? window
      : "undefined" != typeof global
      ? global
      : "undefined" != typeof self && self;
    var b,
      c,
      d =
        ((function(a, b) {
          !(function(a) {
            Object.defineProperty(a, "__esModule", { value: !0 });
            var b,
              c,
              d = (function() {
                function a(a, b) {
                  for (var c = 0; c < b.length; c++) {
                    var d = b[c];
                    (d.enumerable = d.enumerable || !1),
                      (d.configurable = !0),
                      "value" in d && (d.writable = !0),
                      Object.defineProperty(a, d.key, d);
                  }
                }
                return function(b, c, d) {
                  return c && a(b.prototype, c), d && a(b, d), b;
                };
              })(),
              e =
                ((b = ".stickySidebar"),
                (c = {
                  topSpacing: 0,
                  bottomSpacing: 0,
                  containerSelector: !1,
                  innerWrapperSelector: ".inner-wrapper-sticky",
                  stickyClass: "is-affixed",
                  resizeSensor: !0,
                  minWidth: !1
                }),
                (function() {
                  function a(b) {
                    var d = this,
                      e =
                        1 < arguments.length && void 0 !== arguments[1]
                          ? arguments[1]
                          : {};
                    if (
                      ((function(a, b) {
                        if (!(a instanceof b))
                          throw new TypeError(
                            "Cannot call a class as a function"
                          );
                      })(this, a),
                      (this.options = a.extend(c, e)),
                      (this.sidebar =
                        "string" == typeof b ? document.querySelector(b) : b),
                      void 0 === this.sidebar)
                    )
                      throw new Error("There is no specific sidebar element.");
                    (this.sidebarInner = !1),
                      (this.container = this.sidebar.parentElement),
                      (this.affixedType = "STATIC"),
                      (this.direction = "down"),
                      (this.support = { transform: !1, transform3d: !1 }),
                      (this._initialized = !1),
                      (this._reStyle = !1),
                      (this._breakpoint = !1),
                      (this.dimensions = {
                        translateY: 0,
                        maxTranslateY: 0,
                        topSpacing: 0,
                        lastTopSpacing: 0,
                        bottomSpacing: 0,
                        lastBottomSpacing: 0,
                        sidebarHeight: 0,
                        sidebarWidth: 0,
                        containerTop: 0,
                        containerHeight: 0,
                        viewportHeight: 0,
                        viewportTop: 0,
                        lastViewportTop: 0
                      }),
                      ["handleEvent"].forEach(function(a) {
                        d[a] = d[a].bind(d);
                      }),
                      this.initialize();
                  }
                  return (
                    d(
                      a,
                      [
                        {
                          key: "initialize",
                          value: function() {
                            var a = this;
                            if (
                              (this._setSupportFeatures(),
                              this.options.innerWrapperSelector &&
                                ((this.sidebarInner = this.sidebar.querySelector(
                                  this.options.innerWrapperSelector
                                )),
                                null === this.sidebarInner &&
                                  (this.sidebarInner = !1)),
                              !this.sidebarInner)
                            ) {
                              var b = document.createElement("div");
                              for (
                                b.setAttribute("class", "inner-wrapper-sticky"),
                                  this.sidebar.appendChild(b);
                                this.sidebar.firstChild != b;

                              )
                                b.appendChild(this.sidebar.firstChild);
                              this.sidebarInner = this.sidebar.querySelector(
                                ".inner-wrapper-sticky"
                              );
                            }
                            if (this.options.containerSelector) {
                              var c = document.querySelectorAll(
                                this.options.containerSelector
                              );
                              if (
                                ((c = Array.prototype.slice.call(c)).forEach(
                                  function(b, c) {
                                    b.contains(a.sidebar) && (a.container = b);
                                  }
                                ),
                                !c.length)
                              )
                                throw new Error(
                                  "The container does not contains on the sidebar."
                                );
                            }
                            "function" != typeof this.options.topSpacing &&
                              (this.options.topSpacing =
                                parseInt(this.options.topSpacing) || 0),
                              "function" != typeof this.options.bottomSpacing &&
                                (this.options.bottomSpacing =
                                  parseInt(this.options.bottomSpacing) || 0),
                              this._widthBreakpoint(),
                              this.calcDimensions(),
                              this.stickyPosition(),
                              this.bindEvents(),
                              (this._initialized = !0);
                          }
                        },
                        {
                          key: "bindEvents",
                          value: function() {
                            window.addEventListener("resize", this, {
                              passive: !0,
                              capture: !1
                            }),
                              window.addEventListener("scroll", this, {
                                passive: !0,
                                capture: !1
                              }),
                              this.sidebar.addEventListener("update" + b, this),
                              this.options.resizeSensor &&
                                "undefined" != typeof ResizeSensor &&
                                (new ResizeSensor(
                                  this.sidebarInner,
                                  this.handleEvent
                                ),
                                new ResizeSensor(
                                  this.container,
                                  this.handleEvent
                                ));
                          }
                        },
                        {
                          key: "handleEvent",
                          value: function(a) {
                            this.updateSticky(a);
                          }
                        },
                        {
                          key: "calcDimensions",
                          value: function() {
                            if (!this._breakpoint) {
                              var b = this.dimensions;
                              (b.containerTop = a.offsetRelative(
                                this.container
                              ).top),
                                (b.containerHeight = this.container.clientHeight),
                                (b.containerBottom =
                                  b.containerTop + b.containerHeight),
                                (b.sidebarHeight = this.sidebarInner.offsetHeight),
                                (b.sidebarWidth = this.sidebarInner.offsetWidth),
                                (b.viewportHeight = window.innerHeight),
                                (b.maxTranslateY =
                                  b.containerHeight - b.sidebarHeight),
                                this._calcDimensionsWithScroll();
                            }
                          }
                        },
                        {
                          key: "_calcDimensionsWithScroll",
                          value: function() {
                            var b = this.dimensions;
                            (b.sidebarLeft = a.offsetRelative(
                              this.sidebar
                            ).left),
                              (b.viewportTop =
                                document.documentElement.scrollTop ||
                                document.body.scrollTop),
                              (b.viewportBottom =
                                b.viewportTop + b.viewportHeight),
                              (b.viewportLeft =
                                document.documentElement.scrollLeft ||
                                document.body.scrollLeft),
                              (b.topSpacing = this.options.topSpacing),
                              (b.bottomSpacing = this.options.bottomSpacing),
                              "function" == typeof b.topSpacing &&
                                (b.topSpacing =
                                  parseInt(b.topSpacing(this.sidebar)) || 0),
                              "function" == typeof b.bottomSpacing &&
                                (b.bottomSpacing =
                                  parseInt(b.bottomSpacing(this.sidebar)) || 0),
                              "VIEWPORT-TOP" === this.affixedType
                                ? b.topSpacing < b.lastTopSpacing &&
                                  ((b.translateY +=
                                    b.lastTopSpacing - b.topSpacing),
                                  (this._reStyle = !0))
                                : "VIEWPORT-BOTTOM" === this.affixedType &&
                                  b.bottomSpacing < b.lastBottomSpacing &&
                                  ((b.translateY +=
                                    b.lastBottomSpacing - b.bottomSpacing),
                                  (this._reStyle = !0)),
                              (b.lastTopSpacing = b.topSpacing),
                              (b.lastBottomSpacing = b.bottomSpacing);
                          }
                        },
                        {
                          key: "isSidebarFitsViewport",
                          value: function() {
                            var a = this.dimensions,
                              b =
                                "down" === this.scrollDirection
                                  ? a.lastBottomSpacing
                                  : a.lastTopSpacing;
                            return (
                              this.dimensions.sidebarHeight + b <
                              this.dimensions.viewportHeight
                            );
                          }
                        },
                        {
                          key: "observeScrollDir",
                          value: function() {
                            var a = this.dimensions;
                            if (a.lastViewportTop !== a.viewportTop) {
                              var b =
                                "down" === this.direction ? Math.min : Math.max;
                              a.viewportTop ===
                                b(a.viewportTop, a.lastViewportTop) &&
                                (this.direction =
                                  "down" === this.direction ? "up" : "down");
                            }
                          }
                        },
                        {
                          key: "getAffixType",
                          value: function() {
                            this._calcDimensionsWithScroll();
                            var a = this.dimensions,
                              b = a.viewportTop + a.topSpacing,
                              c = this.affixedType;
                            return (
                              b <= a.containerTop ||
                              a.containerHeight <= a.sidebarHeight
                                ? ((a.translateY = 0), (c = "STATIC"))
                                : (c =
                                    "up" === this.direction
                                      ? this._getAffixTypeScrollingUp()
                                      : this._getAffixTypeScrollingDown()),
                              (a.translateY = Math.max(0, a.translateY)),
                              (a.translateY = Math.min(
                                a.containerHeight,
                                a.translateY
                              )),
                              (a.translateY = Math.round(a.translateY)),
                              (a.lastViewportTop = a.viewportTop),
                              c
                            );
                          }
                        },
                        {
                          key: "_getAffixTypeScrollingDown",
                          value: function() {
                            var a = this.dimensions,
                              b = a.sidebarHeight + a.containerTop,
                              c = a.viewportTop + a.topSpacing,
                              d = a.viewportBottom - a.bottomSpacing,
                              e = this.affixedType;
                            return (
                              this.isSidebarFitsViewport()
                                ? a.sidebarHeight + c >= a.containerBottom
                                  ? ((a.translateY = a.containerBottom - b),
                                    (e = "CONTAINER-BOTTOM"))
                                  : c >= a.containerTop &&
                                    ((a.translateY = c - a.containerTop),
                                    (e = "VIEWPORT-TOP"))
                                : a.containerBottom <= d
                                ? ((a.translateY = a.containerBottom - b),
                                  (e = "CONTAINER-BOTTOM"))
                                : b + a.translateY <= d
                                ? ((a.translateY = d - b),
                                  (e = "VIEWPORT-BOTTOM"))
                                : a.containerTop + a.translateY <= c &&
                                  0 !== a.translateY &&
                                  a.maxTranslateY !== a.translateY &&
                                  (e = "VIEWPORT-UNBOTTOM"),
                              e
                            );
                          }
                        },
                        {
                          key: "_getAffixTypeScrollingUp",
                          value: function() {
                            var a = this.dimensions,
                              b = a.sidebarHeight + a.containerTop,
                              c = a.viewportTop + a.topSpacing,
                              d = a.viewportBottom - a.bottomSpacing,
                              e = this.affixedType;
                            return (
                              c <= a.translateY + a.containerTop
                                ? ((a.translateY = c - a.containerTop),
                                  (e = "VIEWPORT-TOP"))
                                : a.containerBottom <= d
                                ? ((a.translateY = a.containerBottom - b),
                                  (e = "CONTAINER-BOTTOM"))
                                : this.isSidebarFitsViewport() ||
                                  (a.containerTop <= c &&
                                    0 !== a.translateY &&
                                    a.maxTranslateY !== a.translateY &&
                                    (e = "VIEWPORT-UNBOTTOM")),
                              e
                            );
                          }
                        },
                        {
                          key: "_getStyle",
                          value: function(b) {
                            if (void 0 !== b) {
                              var c = { inner: {}, outer: {} },
                                d = this.dimensions;
                              switch (b) {
                                case "VIEWPORT-TOP":
                                  c.inner = {
                                    position: "fixed",
                                    top: d.topSpacing,
                                    left: d.sidebarLeft - d.viewportLeft,
                                    width: d.sidebarWidth
                                  };
                                  break;
                                case "VIEWPORT-BOTTOM":
                                  c.inner = {
                                    position: "fixed",
                                    top: "auto",
                                    left: d.sidebarLeft,
                                    bottom: d.bottomSpacing,
                                    width: d.sidebarWidth
                                  };
                                  break;
                                case "CONTAINER-BOTTOM":
                                case "VIEWPORT-UNBOTTOM":
                                  var e = this._getTranslate(
                                    0,
                                    d.translateY + "px"
                                  );
                                  c.inner = e
                                    ? { transform: e }
                                    : {
                                        position: "absolute",
                                        top: d.translateY,
                                        width: d.sidebarWidth
                                      };
                              }
                              switch (b) {
                                case "VIEWPORT-TOP":
                                case "VIEWPORT-BOTTOM":
                                case "VIEWPORT-UNBOTTOM":
                                case "CONTAINER-BOTTOM":
                                  c.outer = {
                                    height: d.sidebarHeight,
                                    position: "relative"
                                  };
                              }
                              return (
                                (c.outer = a.extend(
                                  { height: "", position: "" },
                                  c.outer
                                )),
                                (c.inner = a.extend(
                                  {
                                    position: "relative",
                                    top: "",
                                    left: "",
                                    bottom: "",
                                    width: "",
                                    transform: ""
                                  },
                                  c.inner
                                )),
                                c
                              );
                            }
                          }
                        },
                        {
                          key: "stickyPosition",
                          value: function(c) {
                            if (!this._breakpoint) {
                              (c = this._reStyle || c || !1),
                                this.options.topSpacing,
                                this.options.bottomSpacing;
                              var d = this.getAffixType(),
                                e = this._getStyle(d);
                              if ((this.affixedType != d || c) && d) {
                                var f =
                                  "affix." +
                                  d.toLowerCase().replace("viewport-", "") +
                                  b;
                                for (var g in (a.eventTrigger(this.sidebar, f),
                                "STATIC" === d
                                  ? a.removeClass(
                                      this.sidebar,
                                      this.options.stickyClass
                                    )
                                  : a.addClass(
                                      this.sidebar,
                                      this.options.stickyClass
                                    ),
                                e.outer)) {
                                  var h =
                                    "number" == typeof e.outer[g] ? "px" : "";
                                  this.sidebar.style[g] = e.outer[g] + h;
                                }
                                for (var i in e.inner) {
                                  var j =
                                    "number" == typeof e.inner[i] ? "px" : "";
                                  this.sidebarInner.style[i] = e.inner[i] + j;
                                }
                                var k =
                                  "affixed." +
                                  d.toLowerCase().replace("viewport-", "") +
                                  b;
                                a.eventTrigger(this.sidebar, k);
                              } else
                                this._initialized &&
                                  (this.sidebarInner.style.left = e.inner.left);
                              this.affixedType = d;
                            }
                          }
                        },
                        {
                          key: "_widthBreakpoint",
                          value: function() {
                            window.innerWidth <= this.options.minWidth
                              ? ((this._breakpoint = !0),
                                (this.affixedType = "STATIC"),
                                this.sidebar.removeAttribute("style"),
                                a.removeClass(
                                  this.sidebar,
                                  this.options.stickyClass
                                ),
                                this.sidebarInner.removeAttribute("style"))
                              : (this._breakpoint = !1);
                          }
                        },
                        {
                          key: "updateSticky",
                          value: function() {
                            var a,
                              b = this,
                              c =
                                0 < arguments.length && void 0 !== arguments[0]
                                  ? arguments[0]
                                  : {};
                            this._running ||
                              ((this._running = !0),
                              (a = c.type),
                              requestAnimationFrame(function() {
                                switch (a) {
                                  case "scroll":
                                    b._calcDimensionsWithScroll(),
                                      b.observeScrollDir(),
                                      b.stickyPosition();
                                    break;
                                  case "resize":
                                  default:
                                    b._widthBreakpoint(),
                                      b.calcDimensions(),
                                      b.stickyPosition(!0);
                                }
                                b._running = !1;
                              }));
                          }
                        },
                        {
                          key: "_setSupportFeatures",
                          value: function() {
                            var b = this.support;
                            (b.transform = a.supportTransform()),
                              (b.transform3d = a.supportTransform(!0));
                          }
                        },
                        {
                          key: "_getTranslate",
                          value: function() {
                            var a =
                                0 < arguments.length && void 0 !== arguments[0]
                                  ? arguments[0]
                                  : 0,
                              b =
                                1 < arguments.length && void 0 !== arguments[1]
                                  ? arguments[1]
                                  : 0,
                              c =
                                2 < arguments.length && void 0 !== arguments[2]
                                  ? arguments[2]
                                  : 0;
                            return this.support.transform3d
                              ? "translate3d(" + a + ", " + b + ", " + c + ")"
                              : !!this.support.translate &&
                                  "translate(" + a + ", " + b + ")";
                          }
                        },
                        {
                          key: "destroy",
                          value: function() {
                            window.removeEventListener("resize", this, {
                              capture: !1
                            }),
                              window.removeEventListener("scroll", this, {
                                capture: !1
                              }),
                              this.sidebar.classList.remove(
                                this.options.stickyClass
                              ),
                              (this.sidebar.style.minHeight = ""),
                              this.sidebar.removeEventListener(
                                "update" + b,
                                this
                              );
                            var a = { inner: {}, outer: {} };
                            for (var c in ((a.inner = {
                              position: "",
                              top: "",
                              left: "",
                              bottom: "",
                              width: "",
                              transform: ""
                            }),
                            (a.outer = { height: "", position: "" }),
                            a.outer))
                              this.sidebar.style[c] = a.outer[c];
                            for (var d in a.inner)
                              this.sidebarInner.style[d] = a.inner[d];
                            this.options.resizeSensor &&
                              "undefined" != typeof ResizeSensor &&
                              (ResizeSensor.detach(
                                this.sidebarInner,
                                this.handleEvent
                              ),
                              ResizeSensor.detach(
                                this.container,
                                this.handleEvent
                              ));
                          }
                        }
                      ],
                      [
                        {
                          key: "supportTransform",
                          value: function(a) {
                            var b = !1,
                              c = a ? "perspective" : "transform",
                              d = c.charAt(0).toUpperCase() + c.slice(1),
                              e = document.createElement("support").style;
                            return (
                              (
                                c +
                                " " +
                                ["Webkit", "Moz", "O", "ms"].join(d + " ") +
                                d
                              )
                                .split(" ")
                                .forEach(function(a, c) {
                                  if (void 0 !== e[a]) return (b = a), !1;
                                }),
                              b
                            );
                          }
                        },
                        {
                          key: "eventTrigger",
                          value: function(a, b, c) {
                            try {
                              var d = new CustomEvent(b, { detail: c });
                            } catch (a) {
                              (d = document.createEvent(
                                "CustomEvent"
                              )).initCustomEvent(b, !0, !0, c);
                            }
                            a.dispatchEvent(d);
                          }
                        },
                        {
                          key: "extend",
                          value: function(a, b) {
                            var c = {};
                            for (var d in a)
                              void 0 !== b[d] ? (c[d] = b[d]) : (c[d] = a[d]);
                            return c;
                          }
                        },
                        {
                          key: "offsetRelative",
                          value: function(a) {
                            var b = { left: 0, top: 0 };
                            do {
                              var c = a.offsetTop,
                                d = a.offsetLeft;
                              isNaN(c) || (b.top += c),
                                isNaN(d) || (b.left += d),
                                (a =
                                  "BODY" === a.tagName
                                    ? a.parentElement
                                    : a.offsetParent);
                            } while (a);
                            return b;
                          }
                        },
                        {
                          key: "addClass",
                          value: function(b, c) {
                            a.hasClass(b, c) ||
                              (b.classList
                                ? b.classList.add(c)
                                : (b.className += " " + c));
                          }
                        },
                        {
                          key: "removeClass",
                          value: function(b, c) {
                            a.hasClass(b, c) &&
                              (b.classList
                                ? b.classList.remove(c)
                                : (b.className = b.className.replace(
                                    new RegExp(
                                      "(^|\\b)" +
                                        c.split(" ").join("|") +
                                        "(\\b|$)",
                                      "gi"
                                    ),
                                    " "
                                  )));
                          }
                        },
                        {
                          key: "hasClass",
                          value: function(a, b) {
                            return a.classList
                              ? a.classList.contains(b)
                              : new RegExp("(^| )" + b + "( |$)", "gi").test(
                                  a.className
                                );
                          }
                        },
                        {
                          key: "defaults",
                          get: function() {
                            return c;
                          }
                        }
                      ]
                    ),
                    a
                  );
                })());
            (a.default = e), (window.StickySidebar = e);
          })(b);
        })((b = { exports: {} }), b.exports),
        b.exports),
      e =
        (c = d) &&
        c.__esModule &&
        Object.prototype.hasOwnProperty.call(c, "default")
          ? c.default
          : c;
    (a.default = e),
      (a.__moduleExports = d),
      Object.defineProperty(a, "__esModule", { value: !0 });
  }),
  (function(a) {
    dtGlobals.isInViewport = function(b) {
      var c = a(window),
        d = b,
        e = c.scrollTop(),
        f = c.scrollTop() + c.height(),
        g = d.offset().top + 20;
      return f >= g && e <= g;
    };
  })(jQuery),
  jQuery(document).ready(function(a) {
    function b() {
      if (dtGlobals.isMobile)
        a(".skills").length > 0 && a(".skills").animateSkills();
      else if (
        a(".animation-at-the-same-time").length > 0 ||
        a(".animate-element").length > 0
      ) {
        var b = -1;
        a(".animation-at-the-same-time:in-viewport").each(function() {
          var b = a(this),
            c = b.find(".animate-element");
          c.addClass("animation-triggered"),
            b
              .find(".animate-element:not(.start-animation)")
              .addClass("start-animation");
        }),
          a(".animate-element:not(.start-animation):in-viewport").each(
            function() {
              var c = a(this);
              !c.parents(".animation-at-the-same-time").length > 0 &&
                (c.hasClass("start-animation") ||
                  c.hasClass("animation-triggered") ||
                  (c.addClass("animation-triggered"),
                  b++,
                  setTimeout(function() {
                    c.addClass("start-animation"),
                      c.hasClass("skills") && c.animateSkills();
                  }, 200 * b)));
            }
          );
      }
    }
    function c() {
      var b = v.width(),
        c = (b - y.innerWidth()) / 2,
        d = a(".side-header-menu-icon").length > 0;
      if ((b - y.innerWidth()) / 2 > 0) var c = (b - y.innerWidth()) / 2;
      else var c = "";
      if (
        (x.hasClass("header-side-right") &&
          y.hasClass("boxed") &&
          !I.length > 0 &&
          L.css({ right: c }),
        navigator.userAgent.match(/Trident.*rv\:11\./) && O && N)
      ) {
        G.insertAfter(K);
        var e = G.attr("style");
        G.not(".sticky-on").attr(
          "style",
          e + "; top:" + K.height() + "px !important;"
        );
      }
      a(".floating-menu-icon-right").length > 0 &&
        y.hasClass("boxed") &&
        (Q.css({ right: c }), a(".branding").css({ left: c })),
        y.hasClass("boxed") &&
          d &&
          !a(".floating-menu-icon-right").length > 0 &&
          (a(".floating-logo .branding").css({ right: c }), Q.css({ left: c })),
        H.length > 0 &&
          d &&
          y.hasClass("boxed") &&
          (Q.css({ right: c }), a(".floating-logo .branding").css({ left: c })),
        x.hasClass("right-side-line") &&
          y.hasClass("boxed") &&
          a(".side-header-v-stroke").css({ right: c });
    }
    function d() {
      if (
        window.innerWidth <=
          dtLocal.themeSettings.mobileHeader.firstSwitchPoint &&
        !x.hasClass("responsive-off")
      )
        return !1;
      var a = dtGlobals.winScrollTop;
      if (a > La + 1 && !Ma && !dtGlobals.isHovering) {
        if (
          (I.removeClass("sticky-off").addClass("sticky-on"),
          N || Oa.removeClass("sticky-space-off").addClass("sticky-space-on"),
          x.hasClass("floating-top-bar")
            ? I.css({ top: Ia })
            : I.css({ top: Ia - da }),
          (Ma = !0),
          ta &&
            N &&
            (I.css({ transform: "translateY(0)" }),
            navigator.userAgent.match(/Trident.*rv\:11\./)))
        ) {
          var b = I.attr("style");
          I.attr("style", b + "; top:" + da + "px !important;");
        }
      } else if (
        a <= La + 1 &&
        Ma &&
        (I.removeClass("sticky-on").addClass("sticky-off"),
        N || Oa.removeClass("sticky-space-on").addClass("sticky-space-off"),
        I.css({ top: 0 }),
        (Ma = !1),
        ta &&
          N &&
          (I.css({ transform: "translateY(-100%)" }),
          navigator.userAgent.match(/Trident.*rv\:11\./)))
      ) {
        var b = I.attr("style");
        I.not(".sticky-on").attr(
          "style",
          b + "; top:" + K.height() + "px !important;"
        );
      }
      a > La + 1 &&
      a <= La + 1 + Ka - dtLocal.themeSettings.floatingHeader.height
        ? ((Na = "changing"),
          Fa.css({ transition: "none", height: La + Ka - a }))
        : a > La + 1 + dtLocal.themeSettings.floatingHeader.height &&
          "end" !== Na
        ? ((Na = "end"),
          Fa.css({
            height: dtLocal.themeSettings.floatingHeader.height,
            transition: "all 0.3s ease"
          }))
        : a <= La + 1 &&
          "start" !== Na &&
          ((Na = "start"), Fa.css({ height: Ka, transition: "all 0.1s ease" }));
    }
    function e() {
      a(".full-width-wrap").length > 0 &&
        a(".full-width-wrap").each(function() {
          var b,
            c,
            d = a(this),
            e = window.innerWidth,
            f = v.width(),
            g = a(".content").width();
          if (a(".boxed").length > 0)
            b = (parseInt(a("#main").width()) - parseInt(g)) / 2;
          else if (
            (a(".side-header-v-stroke").length &&
              e > dtLocal.themeSettings.mobileHeader.firstSwitchPoint &&
              !x.hasClass("responsive-off")) ||
            (a(".side-header-v-stroke").length && x.hasClass("responsive-off"))
          ) {
            var h =
              e <= parseInt(g)
                ? parseInt(g)
                : f - a(".side-header-v-stroke").width();
            b = Math.ceil((h - parseInt(g)) / 2);
          } else if (
            (a(".sticky-header .side-header").length &&
              e > dtLocal.themeSettings.mobileHeader.firstSwitchPoint &&
              !x.hasClass("responsive-off")) ||
            (a(".sticky-header .side-header").length &&
              x.hasClass("responsive-off"))
          ) {
            var h = f <= parseInt(g) ? parseInt(g) : f;
            b = Math.ceil((f - parseInt(g)) / 2);
          } else if (
            ((a(".header-side-left").length && e) ||
              (a(".header-side-right").length && e)) >
            dtLocal.themeSettings.mobileHeader.firstSwitchPoint
          ) {
            var h =
              e <= parseInt(g) ? parseInt(g) : f - a(".side-header").width();
            b = Math.ceil((h - parseInt(g)) / 2);
          } else {
            var h = f <= parseInt(g) ? parseInt(g) : f;
            b = Math.ceil((f - parseInt(g)) / 2);
          }
          a(".sidebar-left").length > 0 || a(".sidebar-right").length > 0
            ? ((c = a(".content").width()), (b = 0))
            : (c = a("#main").innerWidth());
          var i = x.hasClass("rtl") ? "margin-right" : "margin-left";
          d.css({ width: c, opacity: 1 }),
            d.css(i, -b),
            d
              .find(".full-width-wrap")
              .css({ width: "", opacity: 1, "padding-left": b }),
            d.find(".full-width-wrap").css(i, ""),
            d.find(".ts-wrap").each(function() {
              var b = a(this).data("thePhotoSlider");
              "undefined" != typeof b && b.update();
            });
        });
    }
    function f(b, c) {
      b.addClass("dt-hovered"),
        y.width() - (c.offset().left - y.offset().left) - c.width() < 0 &&
          c.addClass("right-overflow"),
        v.height() -
          (c.offset().top - dtGlobals.winScrollTop) -
          c.innerHeight() <
          0 &&
          c.innerHeight() <= v.height() &&
          c.addClass("bottom-overflow"),
        b.parents(".dt-mobile-header").length > 0 &&
          c.css({ top: b.position().top - 13 - c.height() }),
        c.height() > v.height() - c.position().top &&
          c.addClass("show-top-buttons"),
        a(".searchform .submit", qb).removeClass("act"),
        a(".mini-search").removeClass("act"),
        a(".mini-search.popup-search .popup-search-wrap", qb)
          .stop()
          .animate({ opacity: 0 }, 150, function() {
            a(this).css("visibility", "hidden");
          }),
        clearTimeout(ob),
        clearTimeout(pb),
        (ob = setTimeout(function() {
          b.hasClass("dt-hovered") &&
            c
              .stop()
              .css("visibility", "visible")
              .animate({ opacity: 1 }, 150);
        }, 100));
    }
    function g(b, c) {
      b.removeClass("dt-hovered"),
        clearTimeout(ob),
        clearTimeout(pb),
        (pb = setTimeout(function() {
          b.hasClass("dt-hovered") ||
            (c.stop().animate({ opacity: 0 }, 150, function() {
              a(this).css("visibility", "hidden");
            }),
            setTimeout(function() {
              b.hasClass("dt-hovered") ||
                (c.removeClass("right-overflow"),
                c.removeClass("bottom-overflow"),
                c.removeClass("show-top-buttons"));
            }, 400));
        }, 150)),
        b.removeClass("dt-clicked");
    }
    function h() {
      a(".mobile-false .shopping-cart.show-sub-cart").each(function() {
        var b = a(this),
          c = b.children(".shopping-cart-wrap");
        b.on("mouseenter tap", function(a) {
          "tap" == a.type && a.stopPropagation(), f(b, c);
        }),
          b.on("mouseleave", function(b) {
            var c = a(this),
              d = c.children(".shopping-cart-wrap");
            g(c, d);
          });
      });
    }
    function j() {
      dtGlobals.isMobile && a(".skills").animateSkills();
    }
    function k(a) {
      if ("undefined" != typeof window.addEventListener)
        window.addEventListener("load", a, !1);
      else if ("undefined" != typeof window.attachEvent)
        window.attachEvent("onload", a);
      else if (null != window.onload) {
        var b = window.onload;
        window.onload = function(c) {
          b(c), window[a]();
        };
      } else window.onload = a;
    }
    function l() {
      a(
        ".album-share-overlay, .project-share-overlay:not(.allways-visible-icons)"
      ).each(function() {
        var b = a(this);
        b.find(".share-button").on("click", function(a) {
          a.preventDefault();
        }),
          b.on("mouseover tap", function(b) {
            "tap" == b.type && b.stopPropagation();
            var c = a(this);
            c.addClass("dt-hovered"),
              clearTimeout(wb),
              clearTimeout(xb),
              (wb = setTimeout(function() {
                c.hasClass("dt-hovered") &&
                  (c.find(".soc-ico a").css("display", "inline-block"),
                  c
                    .find(".soc-ico")
                    .stop()
                    .css("visibility", "visible")
                    .animate({ opacity: 1 }, 200));
              }, 100));
          }),
          b.on("mouseleave ", function(b) {
            var c = a(this);
            c.removeClass("dt-hovered"),
              clearTimeout(wb),
              clearTimeout(xb),
              (xb = setTimeout(function() {
                c.hasClass("dt-hovered") ||
                  c
                    .find(".soc-ico")
                    .stop()
                    .animate({ opacity: 0 }, 150, function() {
                      c.find(".soc-ico a").css("display", "none"),
                        a(this).css("visibility", "hidden");
                    });
              }, 50));
          });
      });
    }
    function m() {
      a(".preload-me").loaded(
        null,
        function() {
          var b = a(".floating-content"),
            c = Ab.siblings(".project-wide-col").height(),
            d = Ab.height();
          if (a(".floating-content").length > 0) {
            var e = b.offset();
            if (F.length > 0 && a(".phantom-sticky").length > 0)
              var f = F.height();
            else var f = 0;
            var g = a(".project-post").offset();
            v.on("scroll", function() {
              window.innerWidth > 1050
                ? dtGlobals.winScrollTop + $a.height() > e.top
                  ? dtGlobals.winScrollTop + $a.height() + d + 40 < g.top + c
                    ? b.css(
                        "transform",
                        "translateY(" +
                          (dtGlobals.winScrollTop -
                            e.top +
                            $a.height() +
                            5 -
                            f) +
                          "px)"
                      )
                    : b.css(
                        "transform",
                        "translateY(" + (c - d - 40 - f) + "px)"
                      )
                  : b.css("transform", "translateY(0px)")
                : b.css({
                    transform: "translateY(0)",
                    "-webkit-transform": "translateY(0)"
                  });
            });
          }
        },
        !0
      );
    }
    function n(b) {
      var c = a(".shopping-cart-wrap");
      c.each(function() {
        var d = a(this);
        d.find(".cart_list").hasClass("empty") ||
          (y.width() - (d.offset().left - y.offset().left) - d.width() < 0 &&
            d.addClass("right-overflow"),
          setTimeout(function() {
            d.stop()
              .css("visibility", "visible")
              .animate({ opacity: 1 }, 200);
          }, 300),
          clearTimeout(pb),
          (pb = setTimeout(function() {
            c.stop().animate({ opacity: 0 }, 200, function() {
              c.css("visibility", "hidden"), c.removeClass("right-overflow");
            });
          }, b)));
      });
    }
    function o() {
      Ub =
        window.innerWidth <
          dtLocal.themeSettings.mobileHeader.firstSwitchPoint &&
        !x.hasClass("responsive-off")
          ? Tb
            ? $a.height()
            : 0
          : "block" == $a.css("display") ||
            "-ms-flexbox" == $a.css("display") ||
            Da
          ? $a.height()
          : Sb
          ? a(".sticky-top-line").height()
          : 0;
    }
    function p() {
      var b = a(".dt-isotope"),
        c = a(
          ".iso-grid .wf-cell:not(.shown), .dt-css-grid .wf-cell:not(.shown)"
        );
      if ((c.exists() && q(c), b.exists())) {
        var d = 0;
        b.each(function() {
          d++;
          var b = a(this).find(".wf-cell");
          b.exists() && q(b, function() {});
        });
      } else {
        var e = a(".iso-item:not(.shown)");
        if (!e.exists()) return;
        q(e);
      }
    }
    function q(b, c) {
      var d = 0;
      b.each(function() {
        var b = a(this);
        a(".mobile-true").length > 0 ||
        b.parents(".loading-effect-none").length > 0
          ? b.hasClass("shown") ||
            b.hasClass("animation-triggered") ||
            (b.addClass("animation-triggered"),
            setTimeout(function() {
              b.hasClass("animation-triggered") &&
                b.removeClass("animation-triggered").addClass("shown");
            }, 200))
          : b.hasClass("shown") ||
            b.hasClass("animation-triggered") ||
            !dtGlobals.isInViewport(b) ||
            b.hasClass("hidden") ||
            (b.addClass("animation-triggered"),
            d++,
            setTimeout(function() {
              b.hasClass("animation-triggered") &&
                b.removeClass("animation-triggered").addClass("shown");
            }, 100 * d)),
          "function" == typeof c && c.call(this);
      });
    }
    function r(b) {
      var c = b.find(".filter.with-ajax").first(),
        d = b.find(".wf-container.with-ajax, .articles-list.with-ajax").first(),
        e = c.find(".filter-categories a.act"),
        f = c.find(".filter-by a.act"),
        g = c.find(".filter-sorting a.act"),
        h = parseInt(d.attr("data-cur-page")),
        i = new Array(),
        j =
          e.length > 0
            ? e
                .attr("data-filter")
                .replace(".category-", "")
                .replace("*", "")
            : "";
      return (
        "0" == j && (j = "none"),
        d.hasClass("dt-isotope") &&
          a(".wf-cell", d).each(function() {
            i.push(a(this).attr("data-post-id"));
          }),
        {
          visibleItems: i,
          postID: dtLocal.postID,
          paged: h,
          term: j,
          orderBy: f.length > 0 ? f.attr("data-by") : "",
          order: g.length > 0 ? g.attr("data-sort") : "",
          ajaxurl: dtLocal.ajaxurl,
          nonce: dtLocal.ajaxNonce,
          pageData: dtLocal.pageData,
          layout: dtLocal.pageData.layout,
          targetContainer: d,
          isPhone: dtGlobals.isPhone
        }
      );
    }
    function s() {
      if (dtGlobals.loadMoreButton && dtGlobals.loadMoreButton.exists()) {
        var a = dtGlobals.loadMoreButton.offset();
        a &&
          v.scrollTop() > (a.top - v.height()) / 2 &&
          !dtGlobals.loadMoreButton.hasClass("animate-load") &&
          dtGlobals.loadMoreButton.trigger("click");
      }
    }
    var t,
      u = a(document),
      v = a(window),
      w = a("html"),
      x = a("body"),
      y = a("#page");
    !dtGlobals.isMobile || dtGlobals.isWindowsPhone || dtGlobals.isAndroid
      ? v.on("resize", function() {
          clearTimeout(t),
            (t = setTimeout(function() {
              v.trigger("debouncedresize");
            }, 200));
        })
      : v.bind("orientationchange", function(a) {
          clearTimeout(t),
            (t = setTimeout(function() {
              v.trigger("debouncedresize");
            }, 200));
        }),
      (a.fn.layzrCarouselInitialisation = function(b) {
        return this.each(function() {
          var c = a(this);
          c.find("img").addClass("owl-thumb-lazy-load-show");
          new Layzr({
            container: b,
            selector: ".owl-thumb-lazy-load-show",
            attr: "data-src",
            attr: "data- ",
            retinaAttr: "data-src-retina",
            hiddenAttr: "data-src-hidden",
            threshold: 30,
            before: function() {
              this.setAttribute("sizes", a(this).attr("width") + "px"),
                (this.style.willChange = "opacity");
            },
            callback: function() {
              this.classList.add("is-loaded");
              var b = a(this);
              setTimeout(function() {
                b.parent().removeClass("layzr-bg"),
                  b.css("will-change", "auto");
              }, 350);
            }
          });
        });
      }),
      (a.fn.layzrInitialisation = function(b) {
        return this.each(function() {
          a(this),
            new Layzr({
              container: b,
              selector: ".lazy-load",
              attr: "data-src",
              attr: "data- ",
              retinaAttr: "data-src-retina",
              hiddenAttr: "data-src-hidden",
              threshold: 0,
              before: function() {
                (this.style.willChange = "opacity"),
                  a(this).parents(".blog-shortcode.mode-list").length > 0 ||
                  a(this).parents(".blog-media").length > 0
                    ? this.setAttribute("sizes", this.width + "px")
                    : a(this).parents(".woocom-project").length > 0 &&
                      this.setAttribute(
                        "sizes",
                        "(max-width:" +
                          a(this).attr("width") +
                          "px) 100vw," +
                          a(this).attr("width") +
                          "px"
                      );
              },
              callback: function() {
                this.classList.add("is-loaded");
                var b = a(this);
                b
                  .parents(".fancy-media-wrap.photoswipe-wrapper")
                  .initPhotoswipe(),
                  setTimeout(function() {
                    b.parents().removeClass("layzr-bg"),
                      b.css("will-change", "auto");
                  }, 350),
                  b.parents().hasClass("owl-carousel") &&
                    b.parents(".owl-carousel").trigger("refresh.owl.carousel");
              },
              after: function() {
                var b = a(this);
                this.complete &&
                  !b.hasClass("is-loaded") &&
                  (this.classList.add("is-loaded"),
                  setTimeout(function() {
                    var b = a(this);
                    b.parents().removeClass("layzr-bg"),
                      b.css("will-change", "auto");
                  }, 350));
              }
            });
        });
      }),
      a(".layzr-loading-on, .vc_single_image-img").layzrInitialisation(),
      (a.fn.layzrBlogInitialisation = function(b) {
        return this.each(function() {
          var c = a(this);
          c.find("img").addClass("blog-thumb-lazy-load-show");
          new Layzr({
            container: b,
            selector: ".blog-thumb-lazy-load-show",
            attr: "data-src",
            attr: "data- ",
            retinaAttr: "data-src-retina",
            hiddenAttr: "data-src-hidden",
            threshold: 30,
            before: function() {
              this.setAttribute("sizes", this.width + "px"),
                (this.style.willChange = "opacity");
            },
            callback: function() {
              if (
                a(this)
                  .parents(".post")
                  .first()
                  .hasClass("visible")
              ) {
                this.classList.add("is-loaded");
                var b = a(this);
                setTimeout(function() {
                  b.parent().removeClass("layzr-bg"),
                    b.css("will-change", "auto");
                }, 350);
              }
            }
          });
        });
      }),
      a(
        ".layzr-loading-on .blog-shortcode.jquery-filter.mode-list .visible"
      ).layzrBlogInitialisation(),
      (window.vc_rowBehaviour = function() {
        function a() {
          var a = e('[data-vc-full-width="true"]');
          e.each(a, function(a, b) {
            var c = e(this);
            if (
              (c.addClass("vc_hidden"),
              c.parents().hasClass("vc_ie-flexbox-fixer"))
            )
              var d = c
                .parents(".vc_ie-flexbox-fixer")
                .next(".vc_row-full-width");
            else var d = c.next(".vc_row-full-width");
            if (d.length > 0 && "undefined" != typeof d) {
              var f = parseInt(c.css("margin-left"), 10),
                g = parseInt(c.css("margin-right"), 10),
                h = 0 - d.offset().left - f;
              e(window).width();
              if (c.parent().hasClass("vc_section"))
                var f = parseInt(c.parent().css("margin-left"), 10),
                  g = parseInt(c.parent().css("margin-right"), 10);
              var i,
                j,
                k = window.innerWidth,
                l = v.width(),
                m = e("#content").width();
              if (e(".boxed").length > 0)
                i = (parseInt(e("#main").width()) - parseInt(m)) / 2;
              else if (
                (e(".side-header-v-stroke").length &&
                  "none" !== e(".side-header-v-stroke").css("display") &&
                  k > dtLocal.themeSettings.mobileHeader.firstSwitchPoint &&
                  !x.hasClass("responsive-off")) ||
                (e(".side-header-v-stroke").length &&
                  x.hasClass("responsive-off"))
              ) {
                var n =
                  k <= parseInt(m)
                    ? parseInt(m)
                    : l - e(".side-header-v-stroke").width();
                i = Math.ceil((n - parseInt(m)) / 2);
              } else if (
                (e(".sticky-header .side-header").length &&
                  k > dtLocal.themeSettings.mobileHeader.firstSwitchPoint &&
                  !x.hasClass("responsive-off")) ||
                (e(".sticky-header .side-header").length &&
                  x.hasClass("responsive-off"))
              ) {
                var n = l <= parseInt(m) ? parseInt(m) : l;
                i = Math.ceil((l - parseInt(m)) / 2);
              } else if (
                (e(".header-side-left").length &&
                  "none" !== e(".side-header").css("display") &&
                  k > dtLocal.themeSettings.mobileHeader.firstSwitchPoint) ||
                (e(".header-side-right").length &&
                  "none" !== e(".side-header").css("display") &&
                  k > dtLocal.themeSettings.mobileHeader.firstSwitchPoint)
              ) {
                var n =
                  k <= parseInt(m)
                    ? parseInt(m)
                    : l - e(".side-header").width();
                i = Math.ceil((n - parseInt(m)) / 2);
              } else {
                var n = l <= parseInt(m) ? parseInt(m) : l;
                i = Math.ceil((n - parseInt(m)) / 2);
              }
              e(".sidebar-left").length > 0 || e(".sidebar-right").length > 0
                ? ((j = e("#content").width()), (i = 0))
                : (j = e("#main").innerWidth());
              var h = 0 - i - f,
                o = "rtl" == jQuery(document).attr("dir") ? "right" : "left";
              if (
                (c.css(o, h),
                c.css({
                  position: "relative",
                  "box-sizing": "border-box",
                  width: j
                }),
                !c.data("vcStretchContent"))
              ) {
                var p = -1 * h;
                0 > p && (p = 0);
                var q = j - p - d.width() + f + g;
                0 > q && (q = 0),
                  c.css({
                    "padding-left": p + "px",
                    "padding-right": q + "px"
                  });
              }
              if (
                c.data("vcStretchContent") &&
                c.find(".upb_row_bg").length > 0
              ) {
                var r = c.find(".upb_row_bg"),
                  s = r.data("bg-override"),
                  t = j;
                "full" == s && (r.css({ "min-width": t + "px" }), r.css(o, 0));
              }
              c.attr("data-vc-full-width-init", "true"),
                c.removeClass("vc_hidden"),
                c.find(".ts-wrap").each(function() {
                  var a = e(this).data("thePhotoSlider");
                  "undefined" != typeof a && a.update();
                });
            }
          });
        }
        function b() {
          var a,
            b = !1;
          return (
            window.vcParallaxSkroll && window.vcParallaxSkroll.destroy(),
            e(".vc_parallax-inner").remove(),
            e("[data-5p-top-bottom]").removeAttr(
              "data-5p-top-bottom data-30p-top-bottom"
            ),
            e("[data-vc-parallax]").each(function() {
              var a, c, d, f, g, h, i;
              (b = !0),
                "on" === e(this).data("vcParallaxOFade") &&
                  e(this)
                    .children()
                    .attr("data-5p-top-bottom", "opacity:0;")
                    .attr("data-30p-top-bottom", "opacity:1;"),
                (c = 100 * e(this).data("vcParallax")),
                (g = e("<div />")
                  .addClass("vc_parallax-inner")
                  .appendTo(e(this))),
                g.height(c + "%"),
                (h = e(this).data("vcParallaxImage")),
                (i = vcExtractYoutubeId(h)),
                i
                  ? insertYoutubeVideoAsBackground(g, i)
                  : "undefined" != typeof h &&
                    g.css("background-image", "url(" + h + ")"),
                (a = c - 100),
                (d = -a),
                (f = 0),
                g
                  .attr("data-bottom-top", "top: " + d + "%;")
                  .attr("data-top-bottom", "top: " + f + "%;");
            }),
            !(!b || !window.skrollr) &&
              ((a = {
                forceHeight: !1,
                smoothScrolling: !1,
                mobileCheck: function() {
                  return !1;
                }
              }),
              (window.vcParallaxSkroll = skrollr.init(a)),
              window.vcParallaxSkroll)
          );
        }
        function c() {
          e(".vc_row-o-full-height:first").each(function() {
            var a, b, c, d;
            (a = e(window)),
              (b = a.height()),
              (c = e(this).offset().top),
              b > c &&
                ((d = 100 - c / (b / 100)),
                e(this).css("min-height", d + "vh"));
          });
        }
        function d() {
          var a = window.navigator.userAgent,
            b = a.indexOf("MSIE ");
          (b > 0 || navigator.userAgent.match(/Trident.*rv\:11\./)) &&
            e(".vc_row-o-full-height").each(function() {
              "flex" === e(this).css("display") &&
                e(this).wrap('<div class="vc_ie-flexbox-fixer"></div>');
            });
        }
        var e = window.jQuery;
        e(window)
          .off("resize.vcRowBehaviour")
          .on("resize.vcRowBehaviour", a)
          .on("resize.vcRowBehaviour", c),
          a(),
          c(),
          d(),
          vc_initVideoBackgrounds(),
          b();
      }),
      ((a('div[data-vc-stretch-content="true"]').length > 0 &&
        a('div[data-vc-full-width-init="false"]').length > 0) ||
        (a('div[data-vc-full-width="true"]').length > 0 &&
          a('div[data-vc-full-width-init="false"]').length > 0)) &&
        vc_rowBehaviour(),
      (a.fn.clickOverlayGradient = function() {
        return this.each(function() {
          var b = a(this),
            c =
              b.find(".entry-excerpt").height() +
              b.find(".post-details").innerHeight();
          b.css({ transform: "translateY(" + c + "px)" }),
            b
              .parents(".post")
              .first()
              .on("mouseenter tap", function(a) {
                b.css("transform", "translateY(0px)");
              }),
            b
              .parents(".post")
              .first()
              .on("mouseleave tap", function(a) {
                b.css("transform", "translateY(" + c + "px)");
              });
        });
      }),
      k(function() {
        a(
          ".content-rollover-layout-list:not(.disable-layout-hover) .dt-css-grid .post-entry-wrapper"
        ).clickOverlayGradient();
      }),
      (dtGlobals.touches = {}),
      (dtGlobals.touches.touching = !1),
      (dtGlobals.touches.touch = !1),
      (dtGlobals.touches.currX = 0),
      (dtGlobals.touches.currY = 0),
      (dtGlobals.touches.cachedX = 0),
      (dtGlobals.touches.cachedY = 0),
      (dtGlobals.touches.count = 0),
      (dtGlobals.resizeCounter = 0),
      u.on("touchstart", function(b) {
        1 == b.originalEvent.touches.length &&
          ((dtGlobals.touches.touch = b.originalEvent.touches[0]),
          (dtGlobals.touches.cachedX = dtGlobals.touches.touch.pageX),
          (dtGlobals.touches.cachedY = dtGlobals.touches.touch.pageY),
          (dtGlobals.touches.touching = !0),
          setTimeout(function() {
            (dtGlobals.touches.currX = dtGlobals.touches.touch.pageX),
              (dtGlobals.touches.currY = dtGlobals.touches.touch.pageY),
              dtGlobals.touches.cachedX !== dtGlobals.touches.currX ||
                dtGlobals.touches.touching ||
                dtGlobals.touches.cachedY !== dtGlobals.touches.currY ||
                (dtGlobals.touches.count++, a(b.target).trigger("tap"));
          }, 200));
      }),
      u.on("touchend touchcancel", function(a) {
        dtGlobals.touches.touching = !1;
      }),
      u.on("touchmove", function(a) {
        (dtGlobals.touches.touch = a.originalEvent.touches[0]),
          dtGlobals.touches.touching;
      }),
      u.on("tap", function(b) {
        a(".dt-hovered").trigger("mouseout");
      }),
      (function(a) {
        "function" == typeof define && define.amd
          ? define(["jquery"], a)
          : a(jQuery);
      })(function(a, b) {
        function c(a) {
          function b(a) {
            d ? (c(), M(b), (e = !0), (d = !1)) : (e = !1);
          }
          var c = a,
            d = !1,
            e = !1;
          (this.kick = function(a) {
            (d = !0), e || b();
          }),
            (this.end = function(a) {
              var b = c;
              a &&
                (e
                  ? ((c = d
                      ? function() {
                          b(), a();
                        }
                      : a),
                    (d = !0))
                  : a());
            });
        }
        function d() {
          return !0;
        }
        function e() {
          return !1;
        }
        function f(a) {
          a.preventDefault();
        }
        function g(a) {
          N[a.target.tagName.toLowerCase()] || a.preventDefault();
        }
        function h(a) {
          return 1 === a.which && !a.ctrlKey && !a.altKey;
        }
        function i(a, b) {
          var c, d;
          if (a.identifiedTouch) return a.identifiedTouch(b);
          for (c = -1, d = a.length; ++c < d; )
            if (a[c].identifier === b) return a[c];
        }
        function j(a, b) {
          var c = i(a.changedTouches, b.identifier);
          if (c && (c.pageX !== b.pageX || c.pageY !== b.pageY)) return c;
        }
        function k(a) {
          var b;
          h(a) &&
            ((b = {
              target: a.target,
              startX: a.pageX,
              startY: a.pageY,
              timeStamp: a.timeStamp
            }),
            J(document, O.move, l, b),
            J(document, O.cancel, m, b));
        }
        function l(a) {
          var b = a.data;
          s(a, b, a, n);
        }
        function m(a) {
          n();
        }
        function n() {
          K(document, O.move, l), K(document, O.cancel, m);
        }
        function o(a) {
          var b, c;
          N[a.target.tagName.toLowerCase()] ||
            ((b = a.changedTouches[0]),
            (c = {
              target: b.target,
              startX: b.pageX,
              startY: b.pageY,
              timeStamp: a.timeStamp,
              identifier: b.identifier
            }),
            J(document, P.move + "." + b.identifier, p, c),
            J(document, P.cancel + "." + b.identifier, q, c));
        }
        function p(a) {
          var b = a.data,
            c = j(a, b);
          c && s(a, b, c, r);
        }
        function q(a) {
          var b = a.data,
            c = i(a.changedTouches, b.identifier);
          c && r(b.identifier);
        }
        function r(a) {
          K(document, "." + a, p), K(document, "." + a, q);
        }
        function s(a, b, c, d) {
          var e = c.pageX - b.startX,
            f = c.pageY - b.startY;
          e * e + f * f < I * I || v(a, b, c, e, f, d);
        }
        function t() {
          return (this._handled = d), !1;
        }
        function u(a) {
          a._handled();
        }
        function v(a, b, c, d, e, f) {
          var g, h;
          b.target;
          (g = a.targetTouches),
            (h = a.timeStamp - b.timeStamp),
            (b.type = "movestart"),
            (b.distX = d),
            (b.distY = e),
            (b.deltaX = d),
            (b.deltaY = e),
            (b.pageX = c.pageX),
            (b.pageY = c.pageY),
            (b.velocityX = d / h),
            (b.velocityY = e / h),
            (b.targetTouches = g),
            (b.finger = g ? g.length : 1),
            (b._handled = t),
            (b._preventTouchmoveDefault = function() {
              a.preventDefault();
            }),
            L(b.target, b),
            f(b.identifier);
        }
        function w(a) {
          var b = a.data.timer;
          (a.data.touch = a), (a.data.timeStamp = a.timeStamp), b.kick();
        }
        function x(a) {
          var b = a.data.event,
            c = a.data.timer;
          y(),
            D(b, c, function() {
              setTimeout(function() {
                K(b.target, "click", e);
              }, 0);
            });
        }
        function y(a) {
          K(document, O.move, w), K(document, O.end, x);
        }
        function z(a) {
          var b = a.data.event,
            c = a.data.timer,
            d = j(a, b);
          d &&
            (a.preventDefault(),
            (b.targetTouches = a.targetTouches),
            (a.data.touch = d),
            (a.data.timeStamp = a.timeStamp),
            c.kick());
        }
        function A(a) {
          var b = a.data.event,
            c = a.data.timer,
            d = i(a.changedTouches, b.identifier);
          d && (B(b), D(b, c));
        }
        function B(a) {
          K(document, "." + a.identifier, z),
            K(document, "." + a.identifier, A);
        }
        function C(a, b, c, d) {
          var e = c - a.timeStamp;
          (a.type = "move"),
            (a.distX = b.pageX - a.startX),
            (a.distY = b.pageY - a.startY),
            (a.deltaX = b.pageX - a.pageX),
            (a.deltaY = b.pageY - a.pageY),
            (a.velocityX = 0.3 * a.velocityX + (0.7 * a.deltaX) / e),
            (a.velocityY = 0.3 * a.velocityY + (0.7 * a.deltaY) / e),
            (a.pageX = b.pageX),
            (a.pageY = b.pageY);
        }
        function D(a, b, c) {
          b.end(function() {
            return (a.type = "moveend"), L(a.target, a), c && c();
          });
        }
        function E(a, b, c) {
          return J(this, "movestart.move", u), !0;
        }
        function F(a) {
          return (
            K(this, "dragstart drag", f),
            K(this, "mousedown touchstart", g),
            K(this, "movestart", u),
            !0
          );
        }
        function G(a) {
          "move" !== a.namespace &&
            "moveend" !== a.namespace &&
            (J(
              this,
              "dragstart." + a.guid + " drag." + a.guid,
              f,
              b,
              a.selector
            ),
            J(this, "mousedown." + a.guid, g, b, a.selector));
        }
        function H(a) {
          "move" !== a.namespace &&
            "moveend" !== a.namespace &&
            (K(this, "dragstart." + a.guid + " drag." + a.guid),
            K(this, "mousedown." + a.guid));
        }
        var I = 6,
          J = a.event.add,
          K = a.event.remove,
          L = function(b, c, d) {
            a.event.trigger(c, d, b);
          },
          M = (function() {
            return (
              window.requestAnimationFrame ||
              window.webkitRequestAnimationFrame ||
              window.mozRequestAnimationFrame ||
              window.oRequestAnimationFrame ||
              window.msRequestAnimationFrame ||
              function(a, b) {
                return window.setTimeout(function() {
                  a();
                }, 25);
              }
            );
          })(),
          N = { textarea: !0, input: !0, select: !0, button: !0 },
          O = {
            move: "mousemove",
            cancel: "mouseup dragstart",
            end: "mouseup"
          },
          P = { move: "touchmove", cancel: "touchend", end: "touchend" };
        (a.event.special.movestart = {
          setup: E,
          teardown: F,
          add: G,
          remove: H,
          _default: function(a) {
            function d(b) {
              C(f, g.touch, g.timeStamp), L(a.target, f);
            }
            var f, g;
            a._handled() &&
              ((f = {
                target: a.target,
                startX: a.startX,
                startY: a.startY,
                pageX: a.pageX,
                pageY: a.pageY,
                distX: a.distX,
                distY: a.distY,
                deltaX: a.deltaX,
                deltaY: a.deltaY,
                velocityX: a.velocityX,
                velocityY: a.velocityY,
                timeStamp: a.timeStamp,
                identifier: a.identifier,
                targetTouches: a.targetTouches,
                finger: a.finger
              }),
              (g = { event: f, timer: new c(d), touch: b, timeStamp: b }),
              a.identifier === b
                ? (J(a.target, "click", e),
                  J(document, O.move, w, g),
                  J(document, O.end, x, g))
                : (a._preventTouchmoveDefault(),
                  J(document, P.move + "." + a.identifier, z, g),
                  J(document, P.end + "." + a.identifier, A, g)));
          }
        }),
          (a.event.special.move = {
            setup: function() {
              J(this, "movestart.move", a.noop);
            },
            teardown: function() {
              K(this, "movestart.move", a.noop);
            }
          }),
          (a.event.special.moveend = {
            setup: function() {
              J(this, "movestart.moveend", a.noop);
            },
            teardown: function() {
              K(this, "movestart.moveend", a.noop);
            }
          }),
          J(document, "mousedown.move", k),
          J(document, "touchstart.move", o),
          "function" == typeof Array.prototype.indexOf &&
            !(function(a, b) {
              for (
                var c = ["changedTouches", "targetTouches"], d = c.length;
                d--;

              )
                a.event.props.indexOf(c[d]) === -1 && a.event.props.push(c[d]);
            })(a);
      }),
      (a.belowthefold = function(b, c) {
        var d = v.height() + v.scrollTop();
        return d <= a(b).offset().top - c.threshold;
      }),
      (a.abovethetop = function(b, c) {
        var d = v.scrollTop();
        return d >= a(b).offset().top + a(b).height() - c.threshold;
      }),
      (a.rightofscreen = function(b, c) {
        var d = v.width() + v.scrollLeft();
        return d <= a(b).offset().left - c.threshold;
      }),
      (a.leftofscreen = function(b, c) {
        var d = v.scrollLeft();
        return d >= a(b).offset().left + a(b).width() - c.threshold;
      }),
      (a.inviewport = function(b, c) {
        return !(
          a.rightofscreen(b, c) ||
          a.leftofscreen(b, c) ||
          a.belowthefold(b, c) ||
          a.abovethetop(b, c)
        );
      }),
      a.extend(a.expr[":"], {
        "below-the-fold": function(b, c, d) {
          return a.belowthefold(b, { threshold: 0 });
        },
        "above-the-top": function(b, c, d) {
          return a.abovethetop(b, { threshold: 0 });
        },
        "left-of-screen": function(b, c, d) {
          return a.leftofscreen(b, { threshold: 0 });
        },
        "right-of-screen": function(b, c, d) {
          return a.rightofscreen(b, { threshold: 0 });
        },
        "in-viewport": function(b, c, d) {
          return a.inviewport(b, { threshold: -30 });
        }
      }),
      (a.fn.checkInViewport = function() {
        if (!dtGlobals.isMobile) {
          var b = -1;
          return this.each(function() {
            var c = a(this);
            c.hasClass("animation-ready") ||
              (c.parents(".animation-at-the-same-time").length > 0
                ? (($thisElem = c.find(".animate-element")),
                  $thisElem.addClass("animation-triggered"),
                  c
                    .find(".animate-element:not(.start-animation)")
                    .addClass("start-animation"))
                : c.hasClass("start-animation") ||
                  c.hasClass("animation-triggered") ||
                  (c.addClass("animation-triggered"),
                  b++,
                  setTimeout(function() {
                    c.addClass("start-animation"),
                      c.hasClass("skills") && c.animateSkills();
                  }, 200 * b)),
              c.addClass("animation-ready"));
          });
        }
        a(".skills").animateSkills();
      });
    var z;
    clearTimeout(z),
      (z = setTimeout(function() {
        b();
      }, 50)),
      dtGlobals.isMobile ||
        v.on("scroll", function() {
          b();
        }),
      (a.fn.exists = function() {
        return a(this).length > 0;
      }),
      (a.fn.loaded = function(b, c, d) {
        var e = this.length;
        return e > 0
          ? this.each(function() {
              var d = this,
                f = a(d);
              f.on("load.dt", function(d) {
                a(this).off("load.dt"),
                  "function" == typeof b && b.call(this),
                  --e <= 0 && "function" == typeof c && c.call(this);
              }),
                d.complete && void 0 !== d.complete
                  ? f.trigger("load.dt")
                  : (d.src = d.src);
            })
          : d
          ? ("function" == typeof c && c.call(this), this)
          : void 0;
      }),
      (a.fn.addPhotoswipeWrap = function() {
        return this.each(function(b, c) {
          var d = a(this);
          d.on("click", function(a) {
            a.preventDefault();
          }),
            d
              .parents("figure")
              .first()
              .addClass("photoswipe-item"),
            d.hasClass("pspw-wrap-ready") ||
              (d.parents().hasClass("dt-gallery-container") ||
                d.parent().addClass("photoswipe-wrapper"),
              d.addClass("pspw-wrap-ready"));
        });
      }),
      a(".dt-pswp-item, figure .dt-gallery-container a").addPhotoswipeWrap();
    var A = [
      {
        id: "facebook",
        label:
          '<i class="icomoon-the7-font-facebook" aria-hidden="true"></i> ' +
          dtShare.shareButtonText.facebook,
        url:
          "https://www.facebook.com/sharer/sharer.php?u={{url}}&picture={{raw_image_url}}&description={{text}}"
      },
      {
        id: "twitter",
        label:
          '<i class="icomoon-the7-font-twitter" aria-hidden="true"></i> ' +
          dtShare.shareButtonText.twitter,
        url: "https://twitter.com/intent/tweet?text={{text}}&url={{url}}"
      },
      {
        id: "pinterest",
        label:
          '<i class="icomoon-the7-font-pinterest" aria-hidden="true"></i> ' +
          dtShare.shareButtonText.pinterest,
        url:
          "http://www.pinterest.com/pin/create/button/?url={{url}}&media={{image_url}}&description={{text}}"
      },
      {
        id: "linkedin",
        label:
          '<i class="icomoon-the7-font-linkedin" aria-hidden="true"></i> ' +
          dtShare.shareButtonText.linkedin,
        url:
          "http://www.linkedin.com/shareArticle?mini=true&url={{url}}&title={{text}}"
      },
      {
        id: "whatsapp",
        label:
          '<i class="icomoon-the7-font-whatsapp" aria-hidden="true"></i> ' +
          dtShare.shareButtonText.whatsapp,
        url: "whatsapp://send?text={{url}}"
      }
    ];
    dtShare.shareButtonText.download &&
      A.push({
        id: "download",
        label:
          '<i class="dt-icon-the7-misc-006-244" aria-hidden="true"></i> ' +
          dtShare.shareButtonText.download,
        url: "{{raw_image_url}}",
        download: !0
      });
    var B = {
      youtube: {
        index: "youtube.com",
        id: "v=",
        src: "//www.youtube.com/embed/%id%",
        type: "youtube"
      },
      vimeo: {
        index: "vimeo.com/",
        id: "/",
        src: "//player.vimeo.com/video/%id%",
        type: "vimeo"
      },
      gmaps: { index: "//maps.google.", src: "%id%&output=embed" }
    };
    if (
      ((a.fn.photoswipeGallery = function(b) {
        function c(a, b) {
          return (" " + a.className + " ").indexOf(" " + b + " ") > -1;
        }
        for (
          var d = function(b) {
              for (
                var c,
                  d,
                  e,
                  f = a(b)
                    .find(".photoswipe-item")
                    .get(),
                  g = f.length,
                  h = [],
                  i = 0;
                i < g;
                i++
              )
                if (((c = f[i]), 1 === c.nodeType)) {
                  d = c.children[0];
                  var j =
                      "undefined" !=
                        typeof a(d).attr("data-large_image_width") &&
                      a(d).attr("data-large_image_width").length > 0 &&
                      "" != a(d).attr("data-large_image_width")
                        ? a(d).attr("data-large_image_width")
                        : a(d)
                            .find("img")
                            .attr("width"),
                    k =
                      "undefined" !=
                        typeof a(d).attr("data-large_image_height") &&
                      a(d).attr("data-large_image_height").length > 0 &&
                      "" != a(d).attr("data-large_image_height")
                        ? a(d).attr("data-large_image_height")
                        : a(d)
                            .find("img")
                            .attr("height"),
                    l =
                      "undefined" != typeof a(d).attr("title") &&
                      a(d).attr("title").length > 0
                        ? "<h5>" + a(d).attr("title") + "</h5>\n"
                        : "",
                    m =
                      "undefined" != typeof a(d).attr("data-dt-img-description")
                        ? a(d).attr("data-dt-img-description")
                        : "",
                    n = l + m || "";
                  if (a(d).hasClass("pswp-video")) {
                    var o,
                      p = d.href;
                    a(".video-wrapper iframe");
                    a.each(B, function() {
                      if (p.indexOf(this.index) > -1)
                        return (
                          this.id &&
                            ("string" == typeof this.id
                              ? ((p = p.substr(
                                  p.lastIndexOf(this.id) + this.id.length,
                                  p.length
                                )),
                                (o = this.type))
                              : ((p = this.id.call(this, p)), (o = this.type))),
                          (p = this.src.replace("%id%", p)),
                          !1
                        );
                    });
                    var e = {
                      html:
                        '<div class="pswp-video-wrap " data-type="' +
                        o +
                        '"><div class="video-wrapper"><iframe class="pswp__video"src=" ' +
                        p +
                        ' " frameborder="0" allowfullscreen></iframe></div></div>',
                      title: n
                    };
                  } else
                    var e = {
                      src: d.getAttribute("href"),
                      w: j,
                      h: k,
                      title: n
                    };
                  d.children.length > 0 &&
                    (e.msrc = d.children[0].getAttribute("src")),
                    (e.el = c),
                    h.push(e);
                }
              return h;
            },
            e = function a(b, c) {
              return b && (c(b) ? b : a(b.parentNode, c));
            },
            f = function(b) {
              var d = b.target || b.srcElement,
                f = e(d, function(a) {
                  return c(a, "photoswipe-item");
                });
              if (f) {
                for (
                  var g,
                    i = a(f).closest(".dt-gallery-container")[0],
                    j = a(a(f).closest(".dt-gallery-container")[0])
                      .find(".photoswipe-item")
                      .get(),
                    k = j.length,
                    l = 0,
                    m = 0;
                  m < k;
                  m++
                )
                  if (1 === j[m].nodeType) {
                    if (j[m] === f) {
                      g = l;
                      break;
                    }
                    l++;
                  }
                return g >= 0 && h(g, i), !1;
              }
            },
            g = function() {
              var a = window.location.hash.substring(1),
                b = {};
              if (a.length < 5) return b;
              for (var c = a.split("&"), d = 0; d < c.length; d++)
                if (c[d]) {
                  var e = c[d].split("=");
                  e.length < 2 || (b[e[0]] = e[1]);
                }
              return b.gid && (b.gid = parseInt(b.gid, 10)), b;
            },
            h = function(b, c, e, f) {
              var g,
                h,
                i,
                j = document.querySelectorAll(".pswp")[0];
              i = d(c);
              var k = a(c).attr("data-pretty-share")
                ? a(c)
                    .attr("data-pretty-share")
                    .split(",")
                : new Array();
              k.length <= 0 || "undefined" == typeof k
                ? a(".pswp__scroll-wrap").addClass("hide-pspw-share")
                : k.push("download");
              for (var l in k) {
                var m = k[l];
                switch (m) {
                  case "facebook":
                    a(".pswp__share-tooltip").addClass("show-share-fb");
                    break;
                  case "twitter":
                    a(".pswp__share-tooltip").addClass("show-share-tw");
                    break;
                  case "pinterest":
                    a(".pswp__share-tooltip").addClass("show-share-pin");
                    break;
                  case "linkedin":
                    a(".pswp__share-tooltip").addClass("show-share-in");
                    break;
                  case "whatsapp":
                    a(".pswp__share-tooltip").addClass("show-share-wp");
                    break;
                  case "download":
                    a(".pswp__share-tooltip").addClass("show-share-d");
                    break;
                  default:
                    a(".pswp__share-tooltip").removeClass(
                      "show-share-in show-share-pin show-share-tw show-share-fb show-share-g show-share-wp"
                    );
                }
              }
              if (
                ((h = {
                  closeOnScroll: !1,
                  galleryUID: c.getAttribute("data-pswp-uid"),
                  bgOpacity: dtShare.overlayOpacity / 100,
                  loop: !0,
                  history: !1,
                  showHideOpacity: !0,
                  showAnimationDuration: 0,
                  shareButtons: A,
                  getImageURLForShare: function(b) {
                    return (
                      g.currItem.src ||
                      a(g.currItem.el)
                        .find("a")
                        .attr("data-dt-location") ||
                      ""
                    );
                  },
                  getPageURLForShare: function(b) {
                    return "linkedin" == b.id
                      ? a(g.currItem.el)
                          .find("a")
                          .attr("data-dt-location") || window.location.href
                      : a(g.currItem.el)
                          .find("a")
                          .attr("data-dt-location") || window.location.href;
                  },
                  getTextForShare: function(a) {
                    var b = g.currItem.title,
                      c =
                        "undefined" != typeof b
                          ? b.replace(/<[^>]+>/g, "")
                          : "";
                    return c || "";
                  },
                  parseShareButtonOut: function(a, b) {
                    return b;
                  }
                }),
                f)
              )
                if (h.galleryPIDs) {
                  for (var n = 0; n < i.length; n++)
                    if (i[n].pid == b) {
                      h.index = n;
                      break;
                    }
                } else h.index = parseInt(b, 10) - 1;
              else h.index = parseInt(b, 10);
              if (!isNaN(h.index)) {
                e && (h.showAnimationDuration = 0),
                  (g = new PhotoSwipe(j, PhotoSwipeUI_Default, i, h)),
                  g.init(),
                  a(".pswp__zoom-wrap").removeClass("active-item"),
                  a(".pswp__video").removeClass("active");
                var o = a(g.currItem.container);
                if (
                  (o.addClass("active-item"), o.find(".pswp__video").length > 0)
                ) {
                  o.find(".pswp__video").addClass("active"),
                    o.parents(".pswp").addClass("video-active");
                  var p = o.find(".pswp__video").prop("src");
                  (p += "?autoplay=1"), o.find(".pswp__video").prop("src", p);
                }
                g.listen("beforeChange", function() {
                  var b = a(g.currItem.container);
                  a(".pswp__zoom-wrap").removeClass("active-item"),
                    b.addClass("active-item"),
                    a(".pswp__video").removeClass("active"),
                    a(".pswp").removeClass("video-active"),
                    b.find(".pswp__video").addClass("active");
                  b.find(".pswp__video");
                  b.find(".pswp__video").length > 0 &&
                    (b.parents(".pswp").addClass("video-active"),
                    ($runVideo = 0)),
                    a(".pswp__video").each(function() {
                      var b = a(this);
                      if (!b.hasClass("active")) {
                        var c = b.prop("src");
                        (c =
                          "youtube" ==
                            b.parents(".pswp-video-wrap ").attr("data-type") ||
                          "vimeo" ==
                            b.parents(".pswp-video-wrap ").attr("data-type")
                            ? c.replace("?autoplay=1", "?enablejsapi=1")
                            : c.replace("?autoplay=1", "")),
                          b.prop("src", ""),
                          b.prop("src", c);
                        var d = b[0].contentWindow;
                        b.hasClass("active")
                          ? (func = "playVideo")
                          : (func = "pauseVideo"),
                          d.postMessage(
                            '{"event":"command","func":"' +
                              func +
                              '","args":""}',
                            "*"
                          );
                      }
                    });
                });
                var q, r;
                g.listen("close", function() {
                  a(".pswp__video").each(function() {
                    var b = a(this);
                    b.attr("src", a(this).attr("src"));
                    var c = b.prop("src");
                    (c =
                      "youtube" ==
                        b.parents(".pswp-video-wrap ").attr("data-type") ||
                      "vimeo" ==
                        b.parents(".pswp-video-wrap ").attr("data-type")
                        ? c.replace("?autoplay=1", "?enablejsapi=1")
                        : c.replace("?autoplay=1", "")),
                      b.prop("src", ""),
                      b.prop("src", c),
                      a(".pswp__video").removeClass("active");
                    var d = a(this)[0].contentWindow;
                    a(this).hasClass("active")
                      ? (func = "playVideo")
                      : (func = "pauseVideo"),
                      d.postMessage(
                        '{"event":"command","func":"' + func + '","args":""}',
                        "*"
                      ),
                      clearTimeout(q),
                      (q = setTimeout(function() {
                        a(".pswp-video-wrap").remove();
                      }, 200));
                  });
                }),
                  g.listen("destroy", function() {
                    clearTimeout(r),
                      (r = setTimeout(function() {
                        a(".pswp")
                          .removeClass()
                          .addClass("pswp");
                      }, 100));
                  });
              }
            },
            i = document.querySelectorAll(b),
            j = 0,
            k = i.length;
          j < k;
          j++
        )
          i[j].setAttribute("data-pswp-uid", j + 1), (i[j].onclick = f);
        var l = g();
        l.pid && l.gid && h(l.pid, i[l.gid - 1], !0, !0);
      }),
      a(".dt-gallery-container.wf-container").photoswipeGallery(
        ".dt-gallery-container.wf-container"
      ),
      (a.fn.photoswipe = function(b) {
        var c = [],
          d = b,
          e = function(b, d) {
            (c = []),
              b.each(function(b, d) {
                c.push({ id: b, items: [] });
                var e = a(d).find(".dt-pswp-item");
                e.each(function(d, e) {
                  var f = a(e),
                    g =
                      "undefined" != typeof f.attr("data-large_image_width") &&
                      f.attr("data-large_image_width").length > 0 &&
                      "" != f.attr("data-large_image_width") &&
                      0 != f.attr("data-large_image_width")
                        ? f.attr("data-large_image_width")
                        : f.find("img").attr("width"),
                    h =
                      "undefined" != typeof f.attr("data-large_image_height") &&
                      f.attr("data-large_image_height").length > 0 &&
                      "" != f.attr("data-large_image_height") &&
                      0 != f.attr("data-large_image_height")
                        ? f.attr("data-large_image_height")
                        : f.find("img").attr("height"),
                    i =
                      "undefined" != typeof f.attr("title") &&
                      f.attr("title").length > 0
                        ? "<h5>" + f.attr("title") + "</h5>"
                        : "",
                    j =
                      "undefined" != typeof f.attr("data-dt-img-description")
                        ? f.attr("data-dt-img-description")
                        : "",
                    k = i + j || "";
                  if (
                    (f.data("gallery-id", b + 1),
                    f.data("photo-id", d),
                    "undefined" == typeof g)
                  )
                    var g = f.find("img").width();
                  if ("undefined" == typeof h) var h = f.find("img").height();
                  if (a(e).hasClass("pswp-video")) {
                    var l,
                      m = e.href;
                    a(".video-wrapper iframe");
                    a.each(B, function() {
                      if (m.indexOf(this.index) > -1)
                        return (
                          this.id &&
                            ("string" == typeof this.id
                              ? ((m = m.substr(
                                  m.lastIndexOf(this.id) + this.id.length,
                                  m.length
                                )),
                                (l = this.type))
                              : ((m = this.id.call(this, m)), (l = this.type))),
                          (m = this.src.replace("%id%", m)),
                          !1
                        );
                    });
                    var n = {
                      html:
                        '<div class="pswp-video-wrap " data-type="' +
                        l +
                        '"><div class="video-wrapper"><iframe class="pswp__video"src="' +
                        m +
                        ' " frameborder="0" allowfullscreen></iframe></div></div>',
                      title: k,
                      shareLink:
                        f.attr("data-dt-location") ||
                        f
                          .parents(".fancy-media-wrap")
                          .find("img")
                          .attr("data-dt-location") ||
                        ""
                    };
                  } else var n = { src: e.href, w: g, h: h, title: k, shareLink: f.attr("data-dt-location") || f.find("img").attr("data-dt-location") || "" };
                  c[b].items.push(n);
                }),
                  a(d)
                    .prev()
                    .hasClass("dt-gallery-pswp")
                    ? a(d)
                        .prev(".dt-gallery-pswp")
                        .on("click", function(b) {
                          b.preventDefault();
                          var c = a(this),
                            e = a(this)
                              .next(a(d))
                              .find(".dt-pswp-item"),
                            f = e.data("gallery-id"),
                            h = e.data("photo-id");
                          c
                            .parents(".ts-wrap")
                            .hasClass("ts-interceptClicks") || g(f, h, c);
                        })
                    : a(d).on("click", ".dt-pswp-item", function(b) {
                        var c = a(this);
                        b.preventDefault();
                        var d = a(this).data("gallery-id"),
                          e = a(this).data("photo-id");
                        c.parents(".ts-wrap").hasClass("ts-interceptClicks") ||
                          g(d, e, c);
                      });
              });
          },
          f = function() {
            var a = window.location.hash.substring(1),
              b = {};
            if (a.length < 5) return b;
            for (var c = a.split("&"), d = 0; d < c.length; d++)
              if (c[d]) {
                var e = c[d].split("=");
                e.length < 2 || (b[e[0]] = e[1]);
              }
            return (
              b.gid && (b.gid = parseInt(b.gid, 10)),
              b.hasOwnProperty("pid") ? ((b.pid = parseInt(b.pid, 10)), b) : b
            );
          },
          g = function(b, e, f) {
            var g = document.querySelectorAll(".pswp")[0],
              h = c[b - 1].items,
              i = {
                index: e,
                galleryUID: b,
                shareEl: !0,
                closeOnScroll: !1,
                history: !1,
                shareButtons: A,
                getImageURLForShare: function(a) {
                  return m.currItem.src || "";
                },
                getPageURLForShare: function(a) {
                  return "linkedin" == a.id
                    ? m.currItem.shareLink || window.location.href
                    : m.currItem.shareLink || window.location.href;
                },
                getTextForShare: function(a) {
                  var b = m.currItem.title,
                    c =
                      "undefined" != typeof b ? b.replace(/<[^>]+>/g, "") : "";
                  return c || "";
                },
                parseShareButtonOut: function(a, b) {
                  return b;
                }
              },
              j = "";
            if (
              "undefined" !=
              typeof a(f)
                .next(".dt-gallery-container")
                .attr("data-pretty-share")
            )
              var j = a(f)
                .next(".dt-gallery-container")
                .attr("data-pretty-share")
                .split(",");
            if (
              "undefined" !=
              typeof a(f)
                .parents(".dt-gallery-container")
                .attr("data-pretty-share")
            )
              var j = a(f)
                .parents(".dt-gallery-container")
                .attr("data-pretty-share")
                .split(",");
            else if (
              "undefined" !=
              typeof a(f)
                .parents(".shortcode-single-image-wrap")
                .attr("data-pretty-share")
            )
              var j = a(f)
                .parents(".shortcode-single-image-wrap")
                .attr("data-pretty-share")
                .split(",");
            else if ("undefined" != typeof a(f).attr("data-pretty-share"))
              var j = a(f)
                .attr("data-pretty-share")
                .split(",");
            j.length <= 0 || "undefined" == typeof j
              ? a(".pswp__scroll-wrap").addClass("hide-pspw-share")
              : j.push("download");
            for (var k in j) {
              var l = j[k];
              switch (l) {
                case "facebook":
                  a(".pswp__share-tooltip").addClass("show-share-fb");
                  break;
                case "twitter":
                  a(".pswp__share-tooltip").addClass("show-share-tw");
                  break;
                case "pinterest":
                  a(".pswp__share-tooltip").addClass("show-share-pin");
                  break;
                case "linkedin":
                  a(".pswp__share-tooltip").addClass("show-share-in");
                  break;
                case "whatsapp":
                  a(".pswp__share-tooltip").addClass("show-share-wp");
                  break;
                case "download":
                  a(".pswp__share-tooltip").addClass("show-share-d");
                  break;
                default:
                  a(".pswp__share-tooltip").removeClass(
                    "show-share-in show-share-pin show-share-tw show-share-fb show-share-g show-share-wp"
                  );
              }
            }
            a.extend(i, d);
            var m = new PhotoSwipe(g, PhotoSwipeUI_Default, h, i);
            m.init(), a(".pswp__video").removeClass("active");
            var n = a(m.currItem.container);
            if (
              (n.find(".pswp__video").length > 0 &&
                n.parents(".pswp").addClass("video-active"),
              a(".pswp__zoom-wrap").removeClass("active-item"),
              n.addClass("active-item"),
              n.find(".pswp__video").length > 0)
            ) {
              n.find(".pswp__video").addClass("active"),
                n.parents(".pswp").addClass("video-active");
              var o = n.find(".pswp__video").prop("src");
              (o += "?autoplay=1"), n.find(".pswp__video").prop("src", o);
            }
            m.listen("beforeChange", function() {
              var b = a(m.currItem.container);
              a(".pswp__zoom-wrap").removeClass("active-item"),
                b.addClass("active-item"),
                a(".pswp__video").removeClass("active"),
                a(".pswp").removeClass("video-active");
              b.find(".pswp__video").addClass("active");
              b.find(".pswp__video").length > 0 &&
                b.parents(".pswp").addClass("video-active"),
                a(".pswp__video").each(function() {
                  var b = a(this);
                  if (!b.hasClass("active")) {
                    var c = b.prop("src");
                    (c = c.replace("?autoplay=1", "?enablejsapi=1")),
                      b.prop("src", ""),
                      b.prop("src", c),
                      a(".pswp__video").removeClass("active");
                    var d = a(this)[0].contentWindow;
                    b.hasClass("active")
                      ? (func = "playVideo")
                      : (func = "pauseVideo"),
                      d.postMessage(
                        '{"event":"command","func":"' + func + '","args":""}',
                        "*"
                      );
                  }
                });
            });
            var p, q;
            m.listen("close", function() {
              a(".pswp__video").each(function() {
                var b = a(this);
                b.attr("src", b.attr("src"));
                var c = b.prop("src");
                (c = c.replace("?autoplay=1", "?enablejsapi=1")),
                  b.prop("src", ""),
                  b.prop("src", c),
                  a(".pswp__video").removeClass("active");
                var d = a(this)[0].contentWindow;
                b.hasClass("active")
                  ? (func = "playVideo")
                  : (func = "stopVideo"),
                  d.postMessage(
                    '{"event":"command","func":"' + func + '","args":""}',
                    "*"
                  ),
                  clearTimeout(p),
                  (p = setTimeout(function() {
                    a(".pswp-video-wrap").remove();
                  }, 200));
              });
            }),
              m.listen("destroy", function() {
                clearTimeout(q),
                  (q = setTimeout(function() {
                    a(".pswp")
                      .removeClass()
                      .addClass("pswp");
                  }, 100));
              });
          };
        e(this);
        var h = f();
        return h.pid > 0 && h.gid > 0 && g(h.gid, h.pid), this;
      }),
      (a.fn.initPhotoswipe = function() {
        return this.each(function() {
          var b = a(this);
          b.photoswipe({
            bgOpacity: dtShare.overlayOpacity / 100,
            loop: !0,
            showHideOpacity: !0
          });
        });
      }),
      k(function() {
        a(
          ".photoswipe-wrapper, .photoswipe-item .dt-gallery-container, .shortcode-gallery.dt-gallery-container:not(.owl-carousel), .dt-gallery-container.gallery, .instagram-photos.dt-gallery-container, .images-container .dt-gallery-container, .shortcode-instagram.dt-gallery-container, .gallery-shortcode:not(.owl-carousel)"
        ).initPhotoswipe();
      }),
      (a.fn.photoswipeCarousel = function(b) {
        var c = [],
          d = b,
          e = function(b, d) {
            (c = []),
              b.each(function(b, d) {
                c.push({ id: b, items: [] });
                var e = a(d).find(".dt-owl-item.cloned .dt-pswp-item");
                e.each(function(d, e) {
                  var f = a(e),
                    g =
                      "undefined" != typeof f.attr("data-large_image_width") &&
                      f.attr("data-large_image_width").length > 0 &&
                      "" != f.attr("data-large_image_width") &&
                      0 != f.attr("data-large_image_width")
                        ? f.attr("data-large_image_width")
                        : f.find("img").attr("width"),
                    h =
                      "undefined" != typeof f.attr("data-large_image_height") &&
                      f.attr("data-large_image_height").length > 0 &&
                      "" != f.attr("data-large_image_height") &&
                      0 != f.attr("data-large_image_height")
                        ? f.attr("data-large_image_height")
                        : f.find("img").attr("height"),
                    i =
                      "undefined" != typeof f.attr("title") &&
                      f.attr("title").length > 0
                        ? "<h5>" + f.attr("title") + "</h5>"
                        : "",
                    j =
                      "undefined" != typeof f.attr("data-dt-img-description")
                        ? f.attr("data-dt-img-description")
                        : "",
                    k = i + j || "";
                  if (
                    (f.data("gallery-id", b + 1),
                    f.data("photo-id", d),
                    "undefined" == typeof g)
                  )
                    var g = f.find("img").width();
                  if ("undefined" == typeof h) var h = f.find("img").height();
                  if (a(e).hasClass("pswp-video")) {
                    var l,
                      m = e.href;
                    a(".video-wrapper iframe");
                    a.each(B, function() {
                      if (m.indexOf(this.index) > -1)
                        return (
                          this.id &&
                            ("string" == typeof this.id
                              ? ((m = m.substr(
                                  m.lastIndexOf(this.id) + this.id.length,
                                  m.length
                                )),
                                (l = this.type))
                              : ((m = this.id.call(this, m)), (l = this.type))),
                          (m = this.src.replace("%id%", m)),
                          !1
                        );
                    });
                    var n = {
                      html:
                        '<div class="pswp-video-wrap " data-type="' +
                        l +
                        '"><div class="video-wrapper"><iframe class="pswp__video"src="' +
                        m +
                        ' " frameborder="0" allowfullscreen></iframe></div></div>',
                      title: k,
                      shareLink:
                        f.attr("data-dt-location") ||
                        f
                          .parents(".fancy-media-wrap")
                          .find("img")
                          .attr("data-dt-location") ||
                        ""
                    };
                  } else var n = { src: e.href, w: g, h: h, title: k, shareLink: f.attr("data-dt-location") || f.find("img").attr("data-dt-location") || "" };
                  c[b].items.push(n);
                }),
                  a(d)
                    .prev()
                    .hasClass("dt-gallery-pswp")
                    ? a(d)
                        .prev(".dt-gallery-pswp")
                        .on("click", function(b) {
                          b.preventDefault();
                          var c = a(this),
                            e = a(this)
                              .next(a(d))
                              .find(".dt-owl-item.cloned .dt-pswp-item"),
                            f = e.data("gallery-id"),
                            h = e.data("photo-id");
                          c
                            .parents(".ts-wrap")
                            .hasClass("ts-interceptClicks") || g(f, h, c);
                        })
                    : a(d).on(
                        "click",
                        ".dt-owl-item.cloned .dt-pswp-item",
                        function(b) {
                          var c = a(this);
                          b.preventDefault();
                          var d = a(this).data("gallery-id"),
                            e = a(this).data("photo-id");
                          c
                            .parents(".ts-wrap")
                            .hasClass("ts-interceptClicks") || g(d, e, c);
                        }
                      );
              });
          },
          f = function() {
            var a = window.location.hash.substring(1),
              b = {};
            if (a.length < 5) return b;
            for (var c = a.split("&"), d = 0; d < c.length; d++)
              if (c[d]) {
                var e = c[d].split("=");
                e.length < 2 || (b[e[0]] = e[1]);
              }
            return (
              b.gid && (b.gid = parseInt(b.gid, 10)),
              b.hasOwnProperty("pid") ? ((b.pid = parseInt(b.pid, 10)), b) : b
            );
          },
          g = function(b, e, f) {
            var g = document.querySelectorAll(".pswp")[0],
              h = c[b - 1].items,
              i = {
                index: e,
                galleryUID: b,
                shareEl: !0,
                closeOnScroll: !1,
                history: !1,
                shareButtons: A,
                getImageURLForShare: function(a) {
                  return m.currItem.src || "";
                },
                getPageURLForShare: function(a) {
                  return "linkedin" == a.id
                    ? m.currItem.shareLink || window.location.href
                    : m.currItem.shareLink || window.location.href;
                },
                getTextForShare: function(a) {
                  var b = m.currItem.title,
                    c =
                      "undefined" != typeof b ? b.replace(/<[^>]+>/g, "") : "";
                  return c || "";
                },
                parseShareButtonOut: function(a, b) {
                  return b;
                }
              },
              j = "";
            if (
              "undefined" !=
              typeof a(f)
                .next(".dt-gallery-container")
                .attr("data-pretty-share")
            )
              var j = a(f)
                .next(".dt-gallery-container")
                .attr("data-pretty-share")
                .split(",");
            if (
              "undefined" !=
              typeof a(f)
                .parents(".dt-gallery-container")
                .attr("data-pretty-share")
            )
              var j = a(f)
                .parents(".dt-gallery-container")
                .attr("data-pretty-share")
                .split(",");
            else if (
              "undefined" !=
              typeof a(f)
                .parents(".shortcode-single-image-wrap")
                .attr("data-pretty-share")
            )
              var j = a(f)
                .parents(".shortcode-single-image-wrap")
                .attr("data-pretty-share")
                .split(",");
            else if ("undefined" != typeof a(f).attr("data-pretty-share"))
              var j = a(f)
                .attr("data-pretty-share")
                .split(",");
            j.length <= 0 || "undefined" == typeof j
              ? a(".pswp__scroll-wrap").addClass("hide-pspw-share")
              : j.push("download");
            for (var k in j) {
              var l = j[k];
              switch (l) {
                case "facebook":
                  a(".pswp__share-tooltip").addClass("show-share-fb");
                  break;
                case "twitter":
                  a(".pswp__share-tooltip").addClass("show-share-tw");
                  break;
                case "pinterest":
                  a(".pswp__share-tooltip").addClass("show-share-pin");
                  break;
                case "linkedin":
                  a(".pswp__share-tooltip").addClass("show-share-in");
                  break;
                case "whatsapp":
                  a(".pswp__share-tooltip").addClass("show-share-wp");
                  break;
                case "download":
                  a(".pswp__share-tooltip").addClass("show-share-d");
                  break;
                default:
                  a(".pswp__share-tooltip").removeClass(
                    "show-share-in show-share-pin show-share-tw show-share-fb show-share-g show-share-wp"
                  );
              }
            }
            a.extend(i, d);
            var m = new PhotoSwipe(g, PhotoSwipeUI_Default, h, i);
            m.init(), a(".pswp__video").removeClass("active");
            var n = a(m.currItem.container);
            if (
              (n.find(".pswp__video").length > 0 &&
                n.parents(".pswp").addClass("video-active"),
              a(".pswp__zoom-wrap").removeClass("active-item"),
              n.addClass("active-item"),
              n.find(".pswp__video").length > 0)
            ) {
              n.find(".pswp__video").addClass("active"),
                n.parents(".pswp").addClass("video-active");
              var o = n.find(".pswp__video").prop("src");
              (o += "?autoplay=1"), n.find(".pswp__video").prop("src", o);
            }
            m.listen("beforeChange", function() {
              var b = a(m.currItem.container);
              a(".pswp__zoom-wrap").removeClass("active-item"),
                b.addClass("active-item"),
                a(".pswp__video").removeClass("active"),
                a(".pswp").removeClass("video-active");
              b.find(".pswp__video").addClass("active");
              b.find(".pswp__video").length > 0 &&
                b.parents(".pswp").addClass("video-active"),
                a(".pswp__video").each(function() {
                  var b = a(this);
                  if (!b.hasClass("active")) {
                    var c = b.prop("src");
                    (c = c.replace("?autoplay=1", "?enablejsapi=1")),
                      b.prop("src", ""),
                      b.prop("src", c),
                      a(".pswp__video").removeClass("active");
                    var d = a(this)[0].contentWindow;
                    b.hasClass("active")
                      ? (func = "playVideo")
                      : (func = "pauseVideo"),
                      d.postMessage(
                        '{"event":"command","func":"' + func + '","args":""}',
                        "*"
                      );
                  }
                });
            });
            var p, q;
            m.listen("close", function() {
              a(".pswp__video").each(function() {
                var b = a(this);
                b.attr("src", b.attr("src"));
                var c = b.prop("src");
                (c = c.replace("?autoplay=1", "?enablejsapi=1")),
                  b.prop("src", ""),
                  b.prop("src", c),
                  a(".pswp__video").removeClass("active");
                var d = a(this)[0].contentWindow;
                b.hasClass("active")
                  ? (func = "playVideo")
                  : (func = "stopVideo"),
                  d.postMessage(
                    '{"event":"command","func":"' + func + '","args":""}',
                    "*"
                  ),
                  clearTimeout(p),
                  (p = setTimeout(function() {
                    a(".pswp-video-wrap").remove();
                  }, 200));
              });
            }),
              m.listen("destroy", function() {
                clearTimeout(q),
                  (q = setTimeout(function() {
                    a(".pswp")
                      .removeClass()
                      .addClass("pswp");
                  }, 100));
              });
          };
        e(this);
        var h = f();
        return h.pid > 0 && h.gid > 0 && g(h.gid, h.pid), this;
      }),
      (a.fn.initCarouselPhotoswipe = function() {
        return this.each(function() {
          var b = a(this);
          b.photoswipe({
            bgOpacity: dtShare.overlayOpacity / 100,
            loop: !0,
            showHideOpacity: !0
          });
        });
      }),
      (a.fn.initCarouselClonedPhotoswipe = function() {
        return this.each(function() {
          var b = a(this);
          b.photoswipeCarousel({
            bgOpacity: dtShare.overlayOpacity / 100,
            loop: !0,
            showHideOpacity: !0
          });
        });
      }),
      a(
        ".shortcode-gallery.dt-gallery-container:not(.owl-loaded), .gallery-shortcode:not(.owl-loaded)"
      ).initCarouselPhotoswipe(),
      a(".dt-trigger-first-pswp")
        .addClass("pspw-ready")
        .on("click", function(b) {
          var c = a(this),
            d = c.parents("article.post").first();
          if (!c.parents(".ts-wrap").hasClass("ts-interceptClicks")) {
            if (d.length > 0) {
              if (d.find(".dt-gallery-container").length > 0)
                var e = d.find(".dt-gallery-container a.dt-pswp-item");
              else var e = d.find("a.dt-pswp-item");
              e.length > 0 && d.find(".rollover-click-target").trigger("click");
            }
            return !1;
          }
        }),
      a(".dt-owl-carousel-call").length > 0 ||
        a(".slider-content").length > 0 ||
        a(".dt-owl-carousel-init").length > 0)
    ) {
      var C = a.fn.owlCarousel;
      !(function(a, b, c, d) {
        function e(b, c) {
          (this.settings = null),
            (this.options = a.extend({}, e.Defaults, c)),
            (this.$element = a(b)),
            (this._handlers = {}),
            (this._plugins = {}),
            (this._supress = {}),
            (this._current = null),
            (this._speed = null),
            (this._coordinates = []),
            (this._breakpoint = null),
            (this._width = null),
            (this._items = []),
            (this._clones = []),
            (this._mergers = []),
            (this._widths = []),
            (this._invalidated = {}),
            (this._pipe = []),
            (this._drag = {
              time: null,
              target: null,
              pointer: null,
              stage: { start: null, current: null },
              direction: null
            }),
            (this._states = {
              current: {},
              tags: {
                initializing: ["busy"],
                animating: ["busy"],
                dragging: ["interacting"]
              }
            }),
            a.each(
              ["onResize", "onThrottledResize"],
              a.proxy(function(b, c) {
                this._handlers[c] = a.proxy(this[c], this);
              }, this)
            ),
            a.each(
              e.Plugins,
              a.proxy(function(a, b) {
                this._plugins[a.charAt(0).toLowerCase() + a.slice(1)] = new b(
                  this
                );
              }, this)
            ),
            a.each(
              e.Workers,
              a.proxy(function(b, c) {
                this._pipe.push({
                  filter: c.filter,
                  run: a.proxy(c.run, this)
                });
              }, this)
            ),
            this.setup(),
            this.initialize();
        }
        (e.Defaults = {
          items: 3,
          loop: !1,
          center: !1,
          rewind: !1,
          checkVisibility: !0,
          mouseDrag: !0,
          touchDrag: !0,
          pullDrag: !0,
          freeDrag: !1,
          margin: 0,
          stagePadding: 0,
          merge: !1,
          mergeFit: !0,
          autoWidth: !1,
          startPosition: 0,
          rtl: !1,
          smartSpeed: 250,
          fluidSpeed: !1,
          dragEndSpeed: !1,
          responsive: {},
          responsiveRefreshRate: 200,
          responsiveBaseElement: b,
          fallbackEasing: "swing",
          slideTransition: "",
          info: !1,
          nestedItemSelector: !1,
          itemElement: "div",
          stageElement: "div",
          refreshClass: "owl-refresh",
          loadedClass: "owl-loaded",
          loadingClass: "owl-loading",
          rtlClass: "owl-rtl",
          responsiveClass: "owl-responsive",
          dragClass: "owl-drag",
          itemClass: "dt-owl-item",
          stageClass: "owl-stage",
          stageOuterClass: "owl-stage-outer",
          grabClass: "owl-grab"
        }),
          (e.Width = { Default: "default", Inner: "inner", Outer: "outer" }),
          (e.Type = { Event: "event", State: "state" }),
          (e.Plugins = {}),
          (e.Workers = [
            {
              filter: ["width", "settings"],
              run: function() {
                this._width = this.$element.width();
              }
            },
            {
              filter: ["width", "items", "settings"],
              run: function(a) {
                a.current =
                  this._items && this._items[this.relative(this._current)];
              }
            },
            {
              filter: ["items", "settings"],
              run: function() {
                this.$stage.children(".cloned").remove();
              }
            },
            {
              filter: ["width", "items", "settings"],
              run: function(a) {
                var b = this.settings.margin || "",
                  c = !this.settings.autoWidth,
                  d = this.settings.rtl,
                  e = {
                    width: "auto",
                    "margin-left": d ? b : "",
                    "margin-right": d ? "" : b
                  };
                !c && this.$stage.children().css(e), (a.css = e);
              }
            },
            {
              filter: ["width", "items", "settings"],
              run: function(a) {
                var b =
                    (this.width() / this.settings.items).toFixed(3) -
                    this.settings.margin,
                  c = null,
                  d = this._items.length,
                  e = !this.settings.autoWidth,
                  f = [];
                for (a.items = { merge: !1, width: b }; d--; )
                  (c = this._mergers[d]),
                    (c =
                      (this.settings.mergeFit &&
                        Math.min(c, this.settings.items)) ||
                      c),
                    (a.items.merge = c > 1 || a.items.merge),
                    (f[d] = e ? b * c : this._items[d].width());
                this._widths = f;
              }
            },
            {
              filter: ["items", "settings"],
              run: function() {
                var b = [],
                  c = this._items,
                  d = this.settings,
                  e = Math.max(2 * d.items, 4),
                  f = 2 * Math.ceil(c.length / 2),
                  g = d.loop && c.length ? (d.rewind ? e : Math.max(e, f)) : 0,
                  h = "",
                  i = "";
                for (g /= 2; g > 0; )
                  b.push(this.normalize(b.length / 2, !0)),
                    (h += c[b[b.length - 1]][0].outerHTML),
                    b.push(
                      this.normalize(c.length - 1 - (b.length - 1) / 2, !0)
                    ),
                    (i = c[b[b.length - 1]][0].outerHTML + i),
                    (g -= 1);
                (this._clones = b),
                  a(h)
                    .addClass("cloned")
                    .appendTo(this.$stage),
                  a(i)
                    .addClass("cloned")
                    .prependTo(this.$stage);
              }
            },
            {
              filter: ["width", "items", "settings"],
              run: function() {
                for (
                  var a = this.settings.rtl ? 1 : -1,
                    b = this._clones.length + this._items.length,
                    c = -1,
                    d = 0,
                    e = 0,
                    f = [];
                  ++c < b;

                )
                  (d = f[c - 1] || 0),
                    (e = this._widths[this.relative(c)] + this.settings.margin),
                    f.push(d + e * a);
                this._coordinates = f;
              }
            },
            {
              filter: ["width", "items", "settings"],
              run: function() {
                var a = this.settings.stagePadding,
                  b = this._coordinates,
                  c = {
                    width: Math.ceil(Math.abs(b[b.length - 1])) + 2 * a,
                    "padding-left": a || "",
                    "padding-right": a || ""
                  };
                this.$stage.css(c);
              }
            },
            {
              filter: ["width", "items", "settings"],
              run: function(a) {
                var b = this._coordinates.length,
                  c = !this.settings.autoWidth,
                  d = this.$stage.children();
                if (c && a.items.merge)
                  for (; b--; )
                    (a.css.width = this._widths[this.relative(b)]),
                      d.eq(b).css(a.css);
                else c && ((a.css.width = a.items.width), d.css(a.css));
              }
            },
            {
              filter: ["items"],
              run: function() {
                this._coordinates.length < 1 && this.$stage.removeAttr("style");
              }
            },
            {
              filter: ["width", "items", "settings"],
              run: function(a) {
                (a.current = a.current
                  ? this.$stage.children().index(a.current)
                  : 0),
                  (a.current = Math.max(
                    this.minimum(),
                    Math.min(this.maximum(), a.current)
                  )),
                  this.reset(a.current);
              }
            },
            {
              filter: ["position"],
              run: function() {
                this.animate(this.coordinates(this._current));
              }
            },
            {
              filter: ["width", "position", "items", "settings"],
              run: function() {
                var a,
                  b,
                  c,
                  d,
                  e = this.settings.rtl ? 1 : -1,
                  f = 2 * this.settings.stagePadding,
                  g = this.coordinates(this.current()) + f,
                  h = g + this.width() * e,
                  i = [];
                for (c = 0, d = this._coordinates.length; c < d; c++)
                  (a = this._coordinates[c - 1] || 0),
                    (b = Math.abs(this._coordinates[c]) + f * e),
                    ((this.op(a, "<=", g) && this.op(a, ">", h)) ||
                      (this.op(b, "<", g) && this.op(b, ">", h))) &&
                      i.push(c);
                this.$stage.children(".active").removeClass("active"),
                  this.$stage
                    .children(":eq(" + i.join("), :eq(") + ")")
                    .addClass("active"),
                  this.$stage.children(".center").removeClass("center"),
                  this.settings.center &&
                    this.$stage
                      .children()
                      .eq(this.current())
                      .addClass("center");
              }
            }
          ]),
          (e.prototype.initializeStage = function() {
            (this.$stage = this.$element.find("." + this.settings.stageClass)),
              this.$stage.length ||
                (this.$element.addClass(this.options.loadingClass),
                (this.$stage = a("<" + this.settings.stageElement + ">", {
                  class: this.settings.stageClass
                }).wrap(a("<div/>", { class: this.settings.stageOuterClass }))),
                this.$element.append(this.$stage.parent()));
          }),
          (e.prototype.initializeItems = function() {
            var b = this.$element.find(".dt-owl-item");
            return b.length
              ? ((this._items = b.get().map(function(b) {
                  return a(b);
                })),
                (this._mergers = this._items.map(function() {
                  return 1;
                })),
                void this.refresh())
              : (this.replace(
                  this.$element.children().not(this.$stage.parent())
                ),
                this.isVisible() ? this.refresh() : this.invalidate("width"),
                void this.$element
                  .removeClass(this.options.loadingClass)
                  .addClass(this.options.loadedClass));
          }),
          (e.prototype.initialize = function() {
            if (
              (this.enter("initializing"),
              this.trigger("initialize"),
              this.$element.toggleClass(
                this.settings.rtlClass,
                this.settings.rtl
              ),
              this.settings.autoWidth && !this.is("pre-loading"))
            ) {
              var a, b, c;
              (a = this.$element.find("img")),
                (b = this.settings.nestedItemSelector
                  ? "." + this.settings.nestedItemSelector
                  : d),
                (c = this.$element.children(b).width()),
                a.length && c <= 0 && this.preloadAutoWidthImages(a);
            }
            this.initializeStage(),
              this.initializeItems(),
              this.registerEventHandlers(),
              this.leave("initializing"),
              this.trigger("initialized");
          }),
          (e.prototype.isVisible = function() {
            return (
              !this.settings.checkVisibility || this.$element.is(":visible")
            );
          }),
          (e.prototype.setup = function() {
            var b = this.viewport(),
              c = this.options.responsive,
              d = -1,
              e = null;
            c
              ? (a.each(c, function(a) {
                  a <= b && a > d && (d = Number(a));
                }),
                (e = a.extend({}, this.options, c[d])),
                "function" == typeof e.stagePadding &&
                  (e.stagePadding = e.stagePadding()),
                delete e.responsive,
                e.responsiveClass &&
                  this.$element.attr(
                    "class",
                    this.$element
                      .attr("class")
                      .replace(
                        new RegExp(
                          "(" + this.options.responsiveClass + "-)\\S+\\s",
                          "g"
                        ),
                        "$1" + d
                      )
                  ))
              : (e = a.extend({}, this.options)),
              this.trigger("change", {
                property: { name: "settings", value: e }
              }),
              (this._breakpoint = d),
              (this.settings = e),
              this.invalidate("settings"),
              this.trigger("changed", {
                property: { name: "settings", value: this.settings }
              });
          }),
          (e.prototype.optionsLogic = function() {
            this.settings.autoWidth &&
              ((this.settings.stagePadding = !1), (this.settings.merge = !1));
          }),
          (e.prototype.prepare = function(b) {
            var c = this.trigger("prepare", { content: b });
            return (
              c.data ||
                (c.data = a("<" + this.settings.itemElement + "/>")
                  .addClass(this.options.itemClass)
                  .append(b)),
              this.trigger("prepared", { content: c.data }),
              c.data
            );
          }),
          (e.prototype.update = function() {
            for (
              var b = 0,
                c = this._pipe.length,
                d = a.proxy(function(a) {
                  return this[a];
                }, this._invalidated),
                e = {};
              b < c;

            )
              (this._invalidated.all ||
                a.grep(this._pipe[b].filter, d).length > 0) &&
                this._pipe[b].run(e),
                b++;
            (this._invalidated = {}), !this.is("valid") && this.enter("valid");
          }),
          (e.prototype.width = function(a) {
            switch ((a = a || e.Width.Default)) {
              case e.Width.Inner:
              case e.Width.Outer:
                return this._width;
              default:
                return (
                  this._width -
                  2 * this.settings.stagePadding +
                  this.settings.margin
                );
            }
          }),
          (e.prototype.refresh = function() {
            this.enter("refreshing"),
              this.trigger("refresh"),
              this.setup(),
              this.optionsLogic(),
              this.$element.addClass(this.options.refreshClass),
              this.update(),
              this.$element.removeClass(this.options.refreshClass),
              this.leave("refreshing"),
              this.trigger("refreshed");
          }),
          (e.prototype.onThrottledResize = function() {
            b.clearTimeout(this.resizeTimer),
              (this.resizeTimer = b.setTimeout(
                this._handlers.onResize,
                this.settings.responsiveRefreshRate
              ));
          }),
          (e.prototype.onResize = function() {
            return (
              !!this._items.length &&
              this._width !== this.$element.width() &&
                !!this.isVisible() &&
                  (this.enter("resizing"),
                  this.trigger("resize").isDefaultPrevented()
                    ? (this.leave("resizing"), !1)
                    : (this.invalidate("width"),
                      this.refresh(),
                      this.leave("resizing"),
                      void this.trigger("resized")))
            );
          }),
          (e.prototype.registerEventHandlers = function() {
            a.support.transition &&
              this.$stage.on(
                a.support.transition.end + ".owl.core",
                a.proxy(this.onTransitionEnd, this)
              ),
              this.settings.responsive !== !1 &&
                this.on(b, "resize", this._handlers.onThrottledResize),
              this.settings.mouseDrag &&
                (this.$element.addClass(this.options.dragClass),
                this.$stage.on(
                  "mousedown.owl.core",
                  a.proxy(this.onDragStart, this)
                ),
                this.$stage.on(
                  "dragstart.owl.core selectstart.owl.core",
                  function() {
                    return !1;
                  }
                )),
              this.settings.touchDrag &&
                (this.$stage.on(
                  "touchstart.owl.core",
                  a.proxy(this.onDragStart, this)
                ),
                this.$stage.on(
                  "touchcancel.owl.core",
                  a.proxy(this.onDragEnd, this)
                ));
          }),
          (e.prototype.onDragStart = function(b) {
            var d = null;
            3 !== b.which &&
              (a.support.transform
                ? ((d = this.$stage
                    .css("transform")
                    .replace(/.*\(|\)| /g, "")
                    .split(",")),
                  (d = {
                    x: d[16 === d.length ? 12 : 4],
                    y: d[16 === d.length ? 13 : 5]
                  }))
                : ((d = this.$stage.position()),
                  (d = {
                    x: this.settings.rtl
                      ? d.left +
                        this.$stage.width() -
                        this.width() +
                        this.settings.margin
                      : d.left,
                    y: d.top
                  })),
              this.is("animating") &&
                (a.support.transform ? this.animate(d.x) : this.$stage.stop(),
                this.invalidate("position")),
              this.$element.toggleClass(
                this.options.grabClass,
                "mousedown" === b.type
              ),
              this.speed(0),
              (this._drag.time = new Date().getTime()),
              (this._drag.target = a(b.target)),
              (this._drag.stage.start = d),
              (this._drag.stage.current = d),
              (this._drag.pointer = this.pointer(b)),
              a(c).on(
                "mouseup.owl.core touchend.owl.core",
                a.proxy(this.onDragEnd, this)
              ),
              a(c).one(
                "mousemove.owl.core touchmove.owl.core",
                a.proxy(function(b) {
                  var d = this.difference(this._drag.pointer, this.pointer(b));
                  a(c).on(
                    "mousemove.owl.core touchmove.owl.core",
                    a.proxy(this.onDragMove, this)
                  ),
                    (Math.abs(d.x) < Math.abs(d.y) && this.is("valid")) ||
                      (b.preventDefault(),
                      this.enter("dragging"),
                      this.trigger("drag"));
                }, this)
              ));
          }),
          (e.prototype.onDragMove = function(a) {
            var b = null,
              c = null,
              d = null,
              e = this.difference(this._drag.pointer, this.pointer(a)),
              f = this.difference(this._drag.stage.start, e);
            this.is("dragging") &&
              (a.preventDefault(),
              this.settings.loop
                ? ((b = this.coordinates(this.minimum())),
                  (c = this.coordinates(this.maximum() + 1) - b),
                  (f.x = ((((f.x - b) % c) + c) % c) + b))
                : ((b = this.settings.rtl
                    ? this.coordinates(this.maximum())
                    : this.coordinates(this.minimum())),
                  (c = this.settings.rtl
                    ? this.coordinates(this.minimum())
                    : this.coordinates(this.maximum())),
                  (d = this.settings.pullDrag ? (-1 * e.x) / 5 : 0),
                  (f.x = Math.max(Math.min(f.x, b + d), c + d))),
              (this._drag.stage.current = f),
              this.animate(f.x));
          }),
          (e.prototype.onDragEnd = function(b) {
            var d = this.difference(this._drag.pointer, this.pointer(b)),
              e = this._drag.stage.current,
              f = (d.x > 0) ^ this.settings.rtl ? "left" : "right";
            a(c).off(".owl.core"),
              this.$element.removeClass(this.options.grabClass),
              ((0 !== d.x && this.is("dragging")) || !this.is("valid")) &&
                (this.speed(
                  this.settings.dragEndSpeed || this.settings.smartSpeed
                ),
                this.current(
                  this.closest(e.x, 0 !== d.x ? f : this._drag.direction)
                ),
                this.invalidate("position"),
                this.update(),
                (this._drag.direction = f),
                (Math.abs(d.x) > 3 ||
                  new Date().getTime() - this._drag.time > 300) &&
                  this._drag.target.one("click.owl.core", function() {
                    return !1;
                  })),
              this.is("dragging") &&
                (this.leave("dragging"), this.trigger("dragged"));
          }),
          (e.prototype.closest = function(b, c) {
            var e = -1,
              f = 30,
              g = this.width(),
              h = this.coordinates();
            return (
              this.settings.freeDrag ||
                a.each(
                  h,
                  a.proxy(function(a, i) {
                    return (
                      "left" === c && b > i - f && b < i + f
                        ? (e = a)
                        : "right" === c && b > i - g - f && b < i - g + f
                        ? (e = a + 1)
                        : this.op(b, "<", i) &&
                          this.op(b, ">", h[a + 1] !== d ? h[a + 1] : i - g) &&
                          (e = "left" === c ? a + 1 : a),
                      e === -1
                    );
                  }, this)
                ),
              this.settings.loop ||
                (this.op(b, ">", h[this.minimum()])
                  ? (e = b = this.minimum())
                  : this.op(b, "<", h[this.maximum()]) &&
                    (e = b = this.maximum())),
              e
            );
          }),
          (e.prototype.animate = function(b) {
            var c = this.speed() > 0;
            this.is("animating") && this.onTransitionEnd(),
              c && (this.enter("animating"), this.trigger("translate")),
              a.support.transform3d && a.support.transition
                ? this.$stage.css({
                    transform: "translate3d(" + b + "px,0px,0px)",
                    transition:
                      this.speed() / 1e3 +
                      "s" +
                      (this.settings.slideTransition
                        ? " " + this.settings.slideTransition
                        : "")
                  })
                : c
                ? this.$stage.animate(
                    { left: b + "px" },
                    this.speed(),
                    this.settings.fallbackEasing,
                    a.proxy(this.onTransitionEnd, this)
                  )
                : this.$stage.css({ left: b + "px" });
          }),
          (e.prototype.is = function(a) {
            return this._states.current[a] && this._states.current[a] > 0;
          }),
          (e.prototype.current = function(a) {
            if (a === d) return this._current;
            if (0 === this._items.length) return d;
            if (((a = this.normalize(a)), this._current !== a)) {
              var b = this.trigger("change", {
                property: { name: "position", value: a }
              });
              b.data !== d && (a = this.normalize(b.data)),
                (this._current = a),
                this.invalidate("position"),
                this.trigger("changed", {
                  property: { name: "position", value: this._current }
                });
            }
            return this._current;
          }),
          (e.prototype.invalidate = function(b) {
            return (
              "string" === a.type(b) &&
                ((this._invalidated[b] = !0),
                this.is("valid") && this.leave("valid")),
              a.map(this._invalidated, function(a, b) {
                return b;
              })
            );
          }),
          (e.prototype.reset = function(a) {
            (a = this.normalize(a)),
              a !== d &&
                ((this._speed = 0),
                (this._current = a),
                this.suppress(["translate", "translated"]),
                this.animate(this.coordinates(a)),
                this.release(["translate", "translated"]));
          }),
          (e.prototype.normalize = function(a, b) {
            var c = this._items.length,
              e = b ? 0 : this._clones.length;
            return (
              !this.isNumeric(a) || c < 1
                ? (a = d)
                : (a < 0 || a >= c + e) &&
                  (a = ((((a - e / 2) % c) + c) % c) + e / 2),
              a
            );
          }),
          (e.prototype.relative = function(a) {
            return (a -= this._clones.length / 2), this.normalize(a, !0);
          }),
          (e.prototype.maximum = function(a) {
            var b,
              c,
              d,
              e = this.settings,
              f = this._coordinates.length;
            if (e.loop) f = this._clones.length / 2 + this._items.length - 1;
            else if (e.autoWidth || e.merge) {
              if ((b = this._items.length))
                for (
                  c = this._items[--b].width(), d = this.$element.width();
                  b-- &&
                  ((c += this._items[b].width() + this.settings.margin),
                  !(c > d));

                );
              f = b + 1;
            } else
              f = e.center
                ? this._items.length - 1
                : this._items.length - e.items;
            return a && (f -= this._clones.length / 2), Math.max(f, 0);
          }),
          (e.prototype.minimum = function(a) {
            return a ? 0 : this._clones.length / 2;
          }),
          (e.prototype.items = function(a) {
            return a === d
              ? this._items.slice()
              : ((a = this.normalize(a, !0)), this._items[a]);
          }),
          (e.prototype.mergers = function(a) {
            return a === d
              ? this._mergers.slice()
              : ((a = this.normalize(a, !0)), this._mergers[a]);
          }),
          (e.prototype.clones = function(b) {
            var c = this._clones.length / 2,
              e = c + this._items.length,
              f = function(a) {
                return a % 2 === 0 ? e + a / 2 : c - (a + 1) / 2;
              };
            return b === d
              ? a.map(this._clones, function(a, b) {
                  return f(b);
                })
              : a.map(this._clones, function(a, c) {
                  return a === b ? f(c) : null;
                });
          }),
          (e.prototype.speed = function(a) {
            return a !== d && (this._speed = a), this._speed;
          }),
          (e.prototype.coordinates = function(b) {
            var c,
              e = 1,
              f = b - 1;
            return b === d
              ? a.map(
                  this._coordinates,
                  a.proxy(function(a, b) {
                    return this.coordinates(b);
                  }, this)
                )
              : (this.settings.center
                  ? (this.settings.rtl && ((e = -1), (f = b + 1)),
                    (c = this._coordinates[b]),
                    (c +=
                      ((this.width() - c + (this._coordinates[f] || 0)) / 2) *
                      e))
                  : (c = this._coordinates[f] || 0),
                (c = Math.ceil(c)));
          }),
          (e.prototype.duration = function(a, b, c) {
            return 0 === c
              ? 0
              : Math.min(Math.max(Math.abs(b - a), 1), 6) *
                  Math.abs(c || this.settings.smartSpeed);
          }),
          (e.prototype.to = function(a, b) {
            var c = this.current(),
              d = null,
              e = a - this.relative(c),
              f = (e > 0) - (e < 0),
              g = this._items.length,
              h = this.minimum(),
              i = this.maximum();
            this.settings.loop
              ? (!this.settings.rewind &&
                  Math.abs(e) > g / 2 &&
                  (e += f * -1 * g),
                (a = c + e),
                (d = ((((a - h) % g) + g) % g) + h),
                d !== a &&
                  d - e <= i &&
                  d - e > 0 &&
                  ((c = d - e), (a = d), this.reset(c)))
              : this.settings.rewind
              ? ((i += 1), (a = ((a % i) + i) % i))
              : (a = Math.max(h, Math.min(i, a))),
              this.speed(this.duration(c, a, b)),
              this.current(a),
              this.isVisible() && this.update();
          }),
          (e.prototype.next = function(a) {
            (a = a || !1), this.to(this.relative(this.current()) + 1, a);
          }),
          (e.prototype.prev = function(a) {
            (a = a || !1), this.to(this.relative(this.current()) - 1, a);
          }),
          (e.prototype.onTransitionEnd = function(a) {
            return (
              (a === d ||
                (a.stopPropagation(),
                (a.target || a.srcElement || a.originalTarget) ===
                  this.$stage.get(0))) &&
              (this.leave("animating"), void this.trigger("translated"))
            );
          }),
          (e.prototype.viewport = function() {
            var d;
            return (
              this.options.responsiveBaseElement !== b
                ? (d = a(this.options.responsiveBaseElement).width())
                : b.innerWidth
                ? (d = b.innerWidth)
                : c.documentElement && c.documentElement.clientWidth
                ? (d = c.documentElement.clientWidth)
                : console.warn("Can not detect viewport width."),
              d
            );
          }),
          (e.prototype.replace = function(b) {
            this.$stage.empty(),
              (this._items = []),
              b && (b = b instanceof jQuery ? b : a(b)),
              this.settings.nestedItemSelector &&
                (b = b.find("." + this.settings.nestedItemSelector)),
              b
                .filter(function() {
                  return 1 === this.nodeType;
                })
                .each(
                  a.proxy(function(a, b) {
                    (b = this.prepare(b)),
                      this.$stage.append(b),
                      this._items.push(b),
                      this._mergers.push(
                        1 *
                          b
                            .find("[data-merge]")
                            .addBack("[data-merge]")
                            .attr("data-merge") || 1
                      );
                  }, this)
                ),
              this.reset(
                this.isNumeric(this.settings.startPosition)
                  ? this.settings.startPosition
                  : 0
              ),
              this.invalidate("items");
          }),
          (e.prototype.add = function(b, c) {
            var e = this.relative(this._current);
            (c = c === d ? this._items.length : this.normalize(c, !0)),
              (b = b instanceof jQuery ? b : a(b)),
              this.trigger("add", { content: b, position: c }),
              (b = this.prepare(b)),
              0 === this._items.length || c === this._items.length
                ? (0 === this._items.length && this.$stage.append(b),
                  0 !== this._items.length && this._items[c - 1].after(b),
                  this._items.push(b),
                  this._mergers.push(
                    1 *
                      b
                        .find("[data-merge]")
                        .addBack("[data-merge]")
                        .attr("data-merge") || 1
                  ))
                : (this._items[c].before(b),
                  this._items.splice(c, 0, b),
                  this._mergers.splice(
                    c,
                    0,
                    1 *
                      b
                        .find("[data-merge]")
                        .addBack("[data-merge]")
                        .attr("data-merge") || 1
                  )),
              this._items[e] && this.reset(this._items[e].index()),
              this.invalidate("items"),
              this.trigger("added", { content: b, position: c });
          }),
          (e.prototype.remove = function(a) {
            (a = this.normalize(a, !0)),
              a !== d &&
                (this.trigger("remove", {
                  content: this._items[a],
                  position: a
                }),
                this._items[a].remove(),
                this._items.splice(a, 1),
                this._mergers.splice(a, 1),
                this.invalidate("items"),
                this.trigger("removed", { content: null, position: a }));
          }),
          (e.prototype.preloadAutoWidthImages = function(b) {
            b.each(
              a.proxy(function(b, c) {
                this.enter("pre-loading"),
                  (c = a(c)),
                  a(new Image())
                    .one(
                      "load",
                      a.proxy(function(a) {
                        c.attr("src", a.target.src),
                          c.css("opacity", 1),
                          this.leave("pre-loading"),
                          !this.is("pre-loading") &&
                            !this.is("initializing") &&
                            this.refresh();
                      }, this)
                    )
                    .attr(
                      "src",
                      c.attr("src") ||
                        c.attr("data-src") ||
                        c.attr("data-src-retina")
                    );
              }, this)
            );
          }),
          (e.prototype.destroy = function() {
            this.$element.off(".owl.core"),
              this.$stage.off(".owl.core"),
              a(c).off(".owl.core"),
              this.settings.responsive !== !1 &&
                (b.clearTimeout(this.resizeTimer),
                this.off(b, "resize", this._handlers.onThrottledResize));
            for (var d in this._plugins) this._plugins[d].destroy();
            this.$stage.children(".cloned").remove(),
              this.$stage.unwrap(),
              this.$stage
                .children()
                .contents()
                .unwrap(),
              this.$stage.children().unwrap(),
              this.$stage.remove(),
              this.$element
                .removeClass(this.options.refreshClass)
                .removeClass(this.options.loadingClass)
                .removeClass(this.options.loadedClass)
                .removeClass(this.options.rtlClass)
                .removeClass(this.options.dragClass)
                .removeClass(this.options.grabClass)
                .attr(
                  "class",
                  this.$element
                    .attr("class")
                    .replace(
                      new RegExp(
                        this.options.responsiveClass + "-\\S+\\s",
                        "g"
                      ),
                      ""
                    )
                )
                .removeData("owl.carousel");
          }),
          (e.prototype.op = function(a, b, c) {
            var d = this.settings.rtl;
            switch (b) {
              case "<":
                return d ? a > c : a < c;
              case ">":
                return d ? a < c : a > c;
              case ">=":
                return d ? a <= c : a >= c;
              case "<=":
                return d ? a >= c : a <= c;
            }
          }),
          (e.prototype.on = function(a, b, c, d) {
            a.addEventListener
              ? a.addEventListener(b, c, d)
              : a.attachEvent && a.attachEvent("on" + b, c);
          }),
          (e.prototype.off = function(a, b, c, d) {
            a.removeEventListener
              ? a.removeEventListener(b, c, d)
              : a.detachEvent && a.detachEvent("on" + b, c);
          }),
          (e.prototype.trigger = function(b, c, d, f, g) {
            var h = {
                item: { count: this._items.length, index: this.current() }
              },
              i = a.camelCase(
                a
                  .grep(["on", b, d], function(a) {
                    return a;
                  })
                  .join("-")
                  .toLowerCase()
              ),
              j = a.Event(
                [b, "owl", d || "carousel"].join(".").toLowerCase(),
                a.extend({ relatedTarget: this }, h, c)
              );
            return (
              this._supress[b] ||
                (a.each(this._plugins, function(a, b) {
                  b.onTrigger && b.onTrigger(j);
                }),
                this.register({ type: e.Type.Event, name: b }),
                this.$element.trigger(j),
                this.settings &&
                  "function" == typeof this.settings[i] &&
                  this.settings[i].call(this, j)),
              j
            );
          }),
          (e.prototype.enter = function(b) {
            a.each(
              [b].concat(this._states.tags[b] || []),
              a.proxy(function(a, b) {
                this._states.current[b] === d && (this._states.current[b] = 0),
                  this._states.current[b]++;
              }, this)
            );
          }),
          (e.prototype.leave = function(b) {
            a.each(
              [b].concat(this._states.tags[b] || []),
              a.proxy(function(a, b) {
                this._states.current[b]--;
              }, this)
            );
          }),
          (e.prototype.register = function(b) {
            if (b.type === e.Type.Event) {
              if (
                (a.event.special[b.name] || (a.event.special[b.name] = {}),
                !a.event.special[b.name].owl)
              ) {
                var c = a.event.special[b.name]._default;
                (a.event.special[b.name]._default = function(a) {
                  return !c ||
                    !c.apply ||
                    (a.namespace && a.namespace.indexOf("owl") !== -1)
                    ? a.namespace && a.namespace.indexOf("owl") > -1
                    : c.apply(this, arguments);
                }),
                  (a.event.special[b.name].owl = !0);
              }
            } else
              b.type === e.Type.State &&
                (this._states.tags[b.name]
                  ? (this._states.tags[b.name] = this._states.tags[
                      b.name
                    ].concat(b.tags))
                  : (this._states.tags[b.name] = b.tags),
                (this._states.tags[b.name] = a.grep(
                  this._states.tags[b.name],
                  a.proxy(function(c, d) {
                    return a.inArray(c, this._states.tags[b.name]) === d;
                  }, this)
                )));
          }),
          (e.prototype.suppress = function(b) {
            a.each(
              b,
              a.proxy(function(a, b) {
                this._supress[b] = !0;
              }, this)
            );
          }),
          (e.prototype.release = function(b) {
            a.each(
              b,
              a.proxy(function(a, b) {
                delete this._supress[b];
              }, this)
            );
          }),
          (e.prototype.pointer = function(a) {
            var c = { x: null, y: null };
            return (
              (a = a.originalEvent || a || b.event),
              (a =
                a.touches && a.touches.length
                  ? a.touches[0]
                  : a.changedTouches && a.changedTouches.length
                  ? a.changedTouches[0]
                  : a),
              a.pageX
                ? ((c.x = a.pageX), (c.y = a.pageY))
                : ((c.x = a.clientX), (c.y = a.clientY)),
              c
            );
          }),
          (e.prototype.isNumeric = function(a) {
            return !isNaN(parseFloat(a));
          }),
          (e.prototype.difference = function(a, b) {
            return { x: a.x - b.x, y: a.y - b.y };
          }),
          (a.fn.owlCarousel = function(b) {
            var c = Array.prototype.slice.call(arguments, 1);
            return this.each(function() {
              var d = a(this),
                f = d.data("owl.carousel");
              f ||
                ((f = new e(this, "object" == typeof b && b)),
                d.data("owl.carousel", f),
                a.each(
                  [
                    "next",
                    "prev",
                    "to",
                    "destroy",
                    "refresh",
                    "replace",
                    "add",
                    "remove"
                  ],
                  function(b, c) {
                    f.register({ type: e.Type.Event, name: c }),
                      f.$element.on(
                        c + ".owl.carousel.core",
                        a.proxy(function(a) {
                          a.namespace &&
                            a.relatedTarget !== this &&
                            (this.suppress([c]),
                            f[c].apply(this, [].slice.call(arguments, 1)),
                            this.release([c]));
                        }, f)
                      );
                  }
                )),
                "string" == typeof b && "_" !== b.charAt(0) && f[b].apply(f, c);
            });
          }),
          (a.fn.owlCarousel.Constructor = e);
      })(window.Zepto || window.jQuery, window, document),
        (function(a, b, c, d) {
          var e = function(b) {
            (this._core = b),
              (this._interval = null),
              (this._visible = null),
              (this._handlers = {
                "initialized.owl.carousel": a.proxy(function(a) {
                  a.namespace &&
                    this._core.settings.autoRefresh &&
                    this.watch();
                }, this)
              }),
              (this._core.options = a.extend(
                {},
                e.Defaults,
                this._core.options
              )),
              this._core.$element.on(this._handlers);
          };
          (e.Defaults = { autoRefresh: !0, autoRefreshInterval: 500 }),
            (e.prototype.watch = function() {
              this._interval ||
                ((this._visible = this._core.isVisible()),
                (this._interval = b.setInterval(
                  a.proxy(this.refresh, this),
                  this._core.settings.autoRefreshInterval
                )));
            }),
            (e.prototype.refresh = function() {
              this._core.isVisible() !== this._visible &&
                ((this._visible = !this._visible),
                this._core.$element.toggleClass("owl-hidden", !this._visible),
                this._visible &&
                  this._core.invalidate("width") &&
                  this._core.refresh());
            }),
            (e.prototype.destroy = function() {
              var a, c;
              b.clearInterval(this._interval);
              for (a in this._handlers)
                this._core.$element.off(a, this._handlers[a]);
              for (c in Object.getOwnPropertyNames(this))
                "function" != typeof this[c] && (this[c] = null);
            }),
            (a.fn.owlCarousel.Constructor.Plugins.AutoRefresh = e);
        })(window.Zepto || window.jQuery, window, document),
        (function(a, b, c, d) {
          var e = function(b) {
            (this._core = b),
              (this._loaded = []),
              (this._handlers = {
                "initialized.owl.carousel change.owl.carousel resized.owl.carousel": a.proxy(
                  function(b) {
                    if (
                      b.namespace &&
                      this._core.settings &&
                      this._core.settings.lazyLoad &&
                      ((b.property && "position" == b.property.name) ||
                        "initialized" == b.type)
                    ) {
                      var c = this._core.settings,
                        e = (c.center && Math.ceil(c.items / 2)) || c.items,
                        f = (c.center && e * -1) || 0,
                        g =
                          (b.property && b.property.value !== d
                            ? b.property.value
                            : this._core.current()) + f,
                        h = this._core.clones().length,
                        i = a.proxy(function(a, b) {
                          this.load(b);
                        }, this);
                      for (
                        c.lazyLoadEager > 0 &&
                        ((e += c.lazyLoadEager),
                        c.loop && ((g -= c.lazyLoadEager), e++));
                        f++ < e;

                      )
                        this.load(h / 2 + this._core.relative(g)),
                          h &&
                            a.each(
                              this._core.clones(this._core.relative(g)),
                              i
                            ),
                          g++;
                    }
                  },
                  this
                )
              }),
              (this._core.options = a.extend(
                {},
                e.Defaults,
                this._core.options
              )),
              this._core.$element.on(this._handlers);
          };
          (e.Defaults = { lazyLoad: !1, lazyLoadEager: 0 }),
            (e.prototype.load = function(c) {
              var d = this._core.$stage.children().eq(c),
                e = d && d.find(".owl-lazy");
              !e ||
                a.inArray(d.get(0), this._loaded) > -1 ||
                (e.each(
                  a.proxy(function(c, d) {
                    var e,
                      f = a(d),
                      g =
                        (b.devicePixelRatio > 1 && f.attr("data-src-retina")) ||
                        f.attr("data-src") ||
                        f.attr("data- ");
                    this._core.trigger("load", { element: f, url: g }, "lazy"),
                      f.is("img")
                        ? f
                            .one(
                              "load.owl.lazy",
                              a.proxy(function() {
                                f.css("opacity", 1),
                                  this._core.trigger(
                                    "loaded",
                                    { element: f, url: g },
                                    "lazy"
                                  );
                              }, this)
                            )
                            .attr("src", g)
                        : f.is("source")
                        ? f
                            .one(
                              "load.owl.lazy",
                              a.proxy(function() {
                                this._core.trigger(
                                  "loaded",
                                  { element: f, url: g },
                                  "lazy"
                                );
                              }, this)
                            )
                            .attr(" ", g)
                        : ((e = new Image()),
                          (e.onload = a.proxy(function() {
                            f.css({
                              "background-image": 'url("' + g + '")',
                              opacity: "1"
                            }),
                              this._core.trigger(
                                "loaded",
                                { element: f, url: g },
                                "lazy"
                              );
                          }, this)),
                          (e.src = g));
                  }, this)
                ),
                this._loaded.push(d.get(0)));
            }),
            (e.prototype.destroy = function() {
              var a, b;
              for (a in this.handlers)
                this._core.$element.off(a, this.handlers[a]);
              for (b in Object.getOwnPropertyNames(this))
                "function" != typeof this[b] && (this[b] = null);
            }),
            (a.fn.owlCarousel.Constructor.Plugins.Lazy = e);
        })(window.Zepto || window.jQuery, window, document),
        (function(a, b, c, d) {
          var e = function(c) {
            (this._core = c),
              (this._previousHeight = null),
              (this._handlers = {
                "initialized.owl.carousel refreshed.owl.carousel": a.proxy(
                  function(a) {
                    a.namespace &&
                      this._core.settings.autoHeight &&
                      this.update();
                  },
                  this
                ),
                "changed.owl.carousel": a.proxy(function(a) {
                  a.namespace &&
                    this._core.settings.autoHeight &&
                    "position" === a.property.name &&
                    this.update();
                }, this),
                "loaded.owl.lazy": a.proxy(function(a) {
                  a.namespace &&
                    this._core.settings.autoHeight &&
                    a.element
                      .closest("." + this._core.settings.itemClass)
                      .index() === this._core.current() &&
                    this.update();
                }, this)
              }),
              (this._core.options = a.extend(
                {},
                e.Defaults,
                this._core.options
              )),
              this._core.$element.on(this._handlers),
              (this._intervalId = null);
            var d = this;
            a(b).on("load", function() {
              d._core.settings.autoHeight && d.update();
            }),
              a(b).resize(function() {
                d._core.settings.autoHeight &&
                  (null != d._intervalId && clearTimeout(d._intervalId),
                  (d._intervalId = setTimeout(function() {
                    d.update();
                  }, 250)));
              });
          };
          (e.Defaults = { autoHeight: !1, autoHeightClass: "owl-height" }),
            (e.prototype.update = function() {
              var b = this._core._current,
                c = b + this._core.settings.items,
                d = this._core.settings.lazyLoad,
                e = this._core.$stage
                  .children()
                  .toArray()
                  .slice(b, c),
                f = [],
                g = 0;
              a.each(e, function(b, c) {
                f.push(a(c).height());
              }),
                (g = Math.max.apply(null, f)),
                g <= 1 &&
                  d &&
                  this._previousHeight &&
                  (g = this._previousHeight),
                (this._previousHeight = g),
                this._core.$stage
                  .parent()
                  .height(g)
                  .addClass(this._core.settings.autoHeightClass);
            }),
            (e.prototype.destroy = function() {
              var a, b;
              for (a in this._handlers)
                this._core.$element.off(a, this._handlers[a]);
              for (b in Object.getOwnPropertyNames(this))
                "function" != typeof this[b] && (this[b] = null);
            }),
            (a.fn.owlCarousel.Constructor.Plugins.AutoHeight = e);
        })(window.Zepto || window.jQuery, window, document),
        (function(a, b, c, d) {
          var e = function(b) {
            (this._core = b),
              (this._videos = {}),
              (this._playing = null),
              (this._handlers = {
                "initialized.owl.carousel": a.proxy(function(a) {
                  a.namespace &&
                    this._core.register({
                      type: "state",
                      name: "playing",
                      tags: ["interacting"]
                    });
                }, this),
                "resize.owl.carousel": a.proxy(function(a) {
                  a.namespace &&
                    this._core.settings.video &&
                    this.isInFullScreen() &&
                    a.preventDefault();
                }, this),
                "refreshed.owl.carousel": a.proxy(function(a) {
                  a.namespace &&
                    this._core.is("resizing") &&
                    this._core.$stage.find(".cloned .owl-video-frame").remove();
                }, this),
                "changed.owl.carousel": a.proxy(function(a) {
                  a.namespace &&
                    "position" === a.property.name &&
                    this._playing &&
                    this.stop();
                }, this),
                "prepared.owl.carousel": a.proxy(function(b) {
                  if (b.namespace) {
                    var c = a(b.content).find(".owl-video");
                    c.length &&
                      (c.css("display", "none"), this.fetch(c, a(b.content)));
                  }
                }, this)
              }),
              (this._core.options = a.extend(
                {},
                e.Defaults,
                this._core.options
              )),
              this._core.$element.on(this._handlers),
              this._core.$element.on(
                "click.owl.video",
                ".owl-video-play-icon",
                a.proxy(function(a) {
                  this.play(a);
                }, this)
              );
          };
          (e.Defaults = { video: !1, videoHeight: !1, videoWidth: !1 }),
            (e.prototype.fetch = function(a, b) {
              var c = (function() {
                  return a.attr("data-vimeo-id")
                    ? "vimeo"
                    : a.attr("data-vzaar-id")
                    ? "vzaar"
                    : "youtube";
                })(),
                d =
                  a.attr("data-vimeo-id") ||
                  a.attr("data-youtube-id") ||
                  a.attr("data-vzaar-id"),
                e = a.attr("data-width") || this._core.settings.videoWidth,
                f = a.attr("data-height") || this._core.settings.videoHeight,
                g = a.attr("href");
              if (!g) throw new Error("Missing video URL.");
              if (
                ((d = g.match(
                  /(http:|https:|)\/\/(player.|www.|app.)?(vimeo\.com|youtu(be\.com|\.be|be\.googleapis\.com|be\-nocookie\.com)|vzaar\.com)\/(video\/|videos\/|embed\/|channels\/.+\/|groups\/.+\/|watch\?v=|v\/)?([A-Za-z0-9._%-]*)(\&\S+)?/
                )),
                d[3].indexOf("youtu") > -1)
              )
                c = "youtube";
              else if (d[3].indexOf("vimeo") > -1) c = "vimeo";
              else {
                if (!(d[3].indexOf("vzaar") > -1))
                  throw new Error("Video URL not supported.");
                c = "vzaar";
              }
              (d = d[6]),
                (this._videos[g] = { type: c, id: d, width: e, height: f }),
                b.attr("data-video", g),
                this.thumbnail(a, this._videos[g]);
            }),
            (e.prototype.thumbnail = function(b, c) {
              var d,
                e,
                f,
                g =
                  c.width && c.height
                    ? "width:" + c.width + "px;height:" + c.height + "px;"
                    : "",
                h = b.find("img"),
                i = "src",
                j = "",
                k = this._core.settings,
                l = function(c) {
                  (e = '<div class="owl-video-play-icon"></div>'),
                    (d = k.lazyLoad
                      ? a("<div/>", { class: "owl-video-tn " + j, srcType: c })
                      : a("<div/>", {
                          class: "owl-video-tn",
                          style: "opacity:1;background-image:url(" + c + ")"
                        })),
                    b.after(d),
                    b.after(e);
                };
              return (
                b.wrap(a("<div/>", { class: "owl-video-wrapper", style: g })),
                this._core.settings.lazyLoad &&
                  ((i = "data-src"), (j = "owl-lazy")),
                h.length
                  ? (l(h.attr(i)), h.remove(), !1)
                  : void ("youtube" === c.type
                      ? ((f =
                          "//img.youtube.com/vi/" + c.id + "/hqdefault.jpg"),
                        l(f))
                      : "vimeo" === c.type
                      ? a.ajax({
                          type: "GET",
                          url: "//vimeo.com/api/v2/video/" + c.id + ".json",
                          jsonp: "callback",
                          dataType: "jsonp",
                          success: function(a) {
                            (f = a[0].thumbnail_large), l(f);
                          }
                        })
                      : "vzaar" === c.type &&
                        a.ajax({
                          type: "GET",
                          url: "//vzaar.com/api/videos/" + c.id + ".json",
                          jsonp: "callback",
                          dataType: "jsonp",
                          success: function(a) {
                            (f = a.framegrab_url), l(f);
                          }
                        }))
              );
            }),
            (e.prototype.stop = function() {
              this._core.trigger("stop", null, "video"),
                this._playing.find(".owl-video-frame").remove(),
                this._playing.removeClass("owl-video-playing"),
                (this._playing = null),
                this._core.leave("playing"),
                this._core.trigger("stopped", null, "video");
            }),
            (e.prototype.play = function(b) {
              var c,
                d,
                e = a(b.target),
                f = e.closest("." + this._core.settings.itemClass),
                g = this._videos[f.attr("data-video")],
                h = g.width || "100%",
                i = g.height || this._core.$stage.height();
              this._playing ||
                (this._core.enter("playing"),
                this._core.trigger("play", null, "video"),
                (f = this._core.items(this._core.relative(f.index()))),
                this._core.reset(f.index()),
                (c = a(
                  '<iframe frameborder="0" allowfullscreen mozallowfullscreen webkitAllowFullScreen ></iframe>'
                )),
                c.attr("height", i),
                c.attr("width", h),
                "youtube" === g.type
                  ? c.attr(
                      "src",
                      "//www.youtube.com/embed/" +
                        g.id +
                        "?autoplay=1&rel=0&v=" +
                        g.id
                    )
                  : "vimeo" === g.type
                  ? c.attr(
                      "src",
                      "//player.vimeo.com/video/" + g.id + "?autoplay=1"
                    )
                  : "vzaar" === g.type &&
                    c.attr(
                      "src",
                      "//view.vzaar.com/" + g.id + "/player?autoplay=true"
                    ),
                (d = a(c)
                  .wrap('<div class="owl-video-frame" />')
                  .insertAfter(f.find(".owl-video"))),
                (this._playing = f.addClass("owl-video-playing")));
            }),
            (e.prototype.isInFullScreen = function() {
              var b =
                c.fullscreenElement ||
                c.mozFullScreenElement ||
                c.webkitFullscreenElement;
              return (
                b &&
                a(b)
                  .parent()
                  .hasClass("owl-video-frame")
              );
            }),
            (e.prototype.destroy = function() {
              var a, b;
              this._core.$element.off("click.owl.video");
              for (a in this._handlers)
                this._core.$element.off(a, this._handlers[a]);
              for (b in Object.getOwnPropertyNames(this))
                "function" != typeof this[b] && (this[b] = null);
            }),
            (a.fn.owlCarousel.Constructor.Plugins.Video = e);
        })(window.Zepto || window.jQuery, window, document),
        (function(a, b, c, d) {
          var e = function(b) {
            (this.core = b),
              (this.core.options = a.extend({}, e.Defaults, this.core.options)),
              (this.swapping = !0),
              (this.previous = d),
              (this.next = d),
              (this.handlers = {
                "change.owl.carousel": a.proxy(function(a) {
                  a.namespace &&
                    "position" == a.property.name &&
                    ((this.previous = this.core.current()),
                    (this.next = a.property.value));
                }, this),
                "drag.owl.carousel dragged.owl.carousel translated.owl.carousel": a.proxy(
                  function(a) {
                    a.namespace && (this.swapping = "translated" == a.type);
                  },
                  this
                ),
                "translate.owl.carousel": a.proxy(function(a) {
                  a.namespace &&
                    this.swapping &&
                    (this.core.options.animateOut ||
                      this.core.options.animateIn) &&
                    this.swap();
                }, this)
              }),
              this.core.$element.on(this.handlers);
          };
          (e.Defaults = { animateOut: !1, animateIn: !1 }),
            (e.prototype.swap = function() {
              if (
                1 === this.core.settings.items &&
                a.support.animation &&
                a.support.transition
              ) {
                this.core.speed(0);
                var b,
                  c = a.proxy(this.clear, this),
                  d = this.core.$stage.children().eq(this.previous),
                  e = this.core.$stage.children().eq(this.next),
                  f = this.core.settings.animateIn,
                  g = this.core.settings.animateOut;
                this.core.current() !== this.previous &&
                  (g &&
                    ((b =
                      this.core.coordinates(this.previous) -
                      this.core.coordinates(this.next)),
                    d
                      .one(a.support.animation.end, c)
                      .css({ left: b + "px" })
                      .addClass("animated owl-animated-out")
                      .addClass(g)),
                  f &&
                    e
                      .one(a.support.animation.end, c)
                      .addClass("animated owl-animated-in")
                      .addClass(f));
              }
            }),
            (e.prototype.clear = function(b) {
              a(b.target)
                .css({ left: "" })
                .removeClass("animated owl-animated-out owl-animated-in")
                .removeClass(this.core.settings.animateIn)
                .removeClass(this.core.settings.animateOut),
                this.core.onTransitionEnd();
            }),
            (e.prototype.destroy = function() {
              var a, b;
              for (a in this.handlers)
                this.core.$element.off(a, this.handlers[a]);
              for (b in Object.getOwnPropertyNames(this))
                "function" != typeof this[b] && (this[b] = null);
            }),
            (a.fn.owlCarousel.Constructor.Plugins.Animate = e);
        })(window.Zepto || window.jQuery, window, document),
        (function(a, b, c, d) {
          var e = function(b) {
            (this._core = b),
              (this._call = null),
              (this._time = 0),
              (this._timeout = 0),
              (this._paused = !0),
              (this._handlers = {
                "changed.owl.carousel": a.proxy(function(a) {
                  a.namespace && "settings" === a.property.name
                    ? this._core.settings.autoplay
                      ? this.play()
                      : this.stop()
                    : a.namespace &&
                      "position" === a.property.name &&
                      this._paused &&
                      (this._time = 0);
                }, this),
                "initialized.owl.carousel": a.proxy(function(a) {
                  a.namespace && this._core.settings.autoplay && this.play();
                }, this),
                "play.owl.autoplay": a.proxy(function(a, b, c) {
                  a.namespace && this.play(b, c);
                }, this),
                "stop.owl.autoplay": a.proxy(function(a) {
                  a.namespace && this.stop();
                }, this),
                "mouseover.owl.autoplay": a.proxy(function() {
                  this._core.settings.autoplayHoverPause &&
                    this._core.is("rotating") &&
                    this.pause();
                }, this),
                "mouseleave.owl.autoplay": a.proxy(function() {
                  this._core.settings.autoplayHoverPause &&
                    this._core.is("rotating") &&
                    this.play();
                }, this),
                "touchstart.owl.core": a.proxy(function() {
                  this._core.settings.autoplayHoverPause &&
                    this._core.is("rotating") &&
                    this.pause();
                }, this),
                "touchend.owl.core": a.proxy(function() {
                  this._core.settings.autoplayHoverPause && this.play();
                }, this)
              }),
              this._core.$element.on(this._handlers),
              (this._core.options = a.extend(
                {},
                e.Defaults,
                this._core.options
              ));
          };
          (e.Defaults = {
            autoplay: !1,
            autoplayTimeout: 5e3,
            autoplayHoverPause: !1,
            autoplaySpeed: !1
          }),
            (e.prototype._next = function(d) {
              (this._call = b.setTimeout(
                a.proxy(this._next, this, d),
                this._timeout * (Math.round(this.read() / this._timeout) + 1) -
                  this.read()
              )),
                this._core.is("interacting") ||
                  c.hidden ||
                  this._core.next(d || this._core.settings.autoplaySpeed);
            }),
            (e.prototype.read = function() {
              return new Date().getTime() - this._time;
            }),
            (e.prototype.play = function(c, d) {
              var e;
              this._core.is("rotating") || this._core.enter("rotating"),
                (c = c || this._core.settings.autoplayTimeout),
                (e = Math.min(this._time % (this._timeout || c), c)),
                this._paused
                  ? ((this._time = this.read()), (this._paused = !1))
                  : b.clearTimeout(this._call),
                (this._time += (this.read() % c) - e),
                (this._timeout = c),
                (this._call = b.setTimeout(
                  a.proxy(this._next, this, d),
                  c - e
                ));
            }),
            (e.prototype.stop = function() {
              this._core.is("rotating") &&
                ((this._time = 0),
                (this._paused = !0),
                b.clearTimeout(this._call),
                this._core.leave("rotating"));
            }),
            (e.prototype.pause = function() {
              this._core.is("rotating") &&
                !this._paused &&
                ((this._time = this.read()),
                (this._paused = !0),
                b.clearTimeout(this._call));
            }),
            (e.prototype.destroy = function() {
              var a, b;
              this.stop();
              for (a in this._handlers)
                this._core.$element.off(a, this._handlers[a]);
              for (b in Object.getOwnPropertyNames(this))
                "function" != typeof this[b] && (this[b] = null);
            }),
            (a.fn.owlCarousel.Constructor.Plugins.autoplay = e);
        })(window.Zepto || window.jQuery, window, document),
        (function(a, b, c, d) {
          "use strict";
          var e = function(b) {
            (this._core = b),
              (this._initialized = !1),
              (this._pages = []),
              (this._controls = {}),
              (this._templates = []),
              (this.$element = this._core.$element),
              (this._overrides = {
                next: this._core.next,
                prev: this._core.prev,
                to: this._core.to
              }),
              (this._handlers = {
                "prepared.owl.carousel": a.proxy(function(b) {
                  b.namespace &&
                    this._core.settings.dotsData &&
                    this._templates.push(
                      '<div class="' +
                        this._core.settings.dotClass +
                        '">' +
                        a(b.content)
                          .find("[data-dot]")
                          .addBack("[data-dot]")
                          .attr("data-dot") +
                        "</div>"
                    );
                }, this),
                "added.owl.carousel": a.proxy(function(a) {
                  a.namespace &&
                    this._core.settings.dotsData &&
                    this._templates.splice(
                      a.position,
                      0,
                      this._templates.pop()
                    );
                }, this),
                "remove.owl.carousel": a.proxy(function(a) {
                  a.namespace &&
                    this._core.settings.dotsData &&
                    this._templates.splice(a.position, 1);
                }, this),
                "changed.owl.carousel": a.proxy(function(a) {
                  a.namespace && "position" == a.property.name && this.draw();
                }, this),
                "initialized.owl.carousel": a.proxy(function(a) {
                  a.namespace &&
                    !this._initialized &&
                    (this._core.trigger("initialize", null, "navigation"),
                    this.initialize(),
                    this.update(),
                    this.draw(),
                    (this._initialized = !0),
                    this._core.trigger("initialized", null, "navigation"));
                }, this),
                "refreshed.owl.carousel": a.proxy(function(a) {
                  a.namespace &&
                    this._initialized &&
                    (this._core.trigger("refresh", null, "navigation"),
                    this.update(),
                    this.draw(),
                    this._core.trigger("refreshed", null, "navigation"));
                }, this)
              }),
              (this._core.options = a.extend(
                {},
                e.Defaults,
                this._core.options
              )),
              this.$element.on(this._handlers);
          };
          (e.Defaults = {
            nav: !1,
            navText: [
              '<span aria-label="Previous">&#x2039;</span>',
              '<span aria-label="Next">&#x203a;</span>'
            ],
            navSpeed: !1,
            navElement: 'button type="button" role="presentation"',
            navContainer: !1,
            navContainerClass: "owl-nav",
            navClass: ["owl-prev", "owl-next"],
            slideBy: 1,
            dotClass: "owl-dot",
            dotsClass: "owl-dots",
            dots: !0,
            dotsEach: !1,
            dotsData: !1,
            dotsSpeed: !1,
            dotsContainer: !1
          }),
            (e.prototype.initialize = function() {
              var b,
                c = this._core.settings;
              (this._controls.$relative = (c.navContainer
                ? a(c.navContainer)
                : a("<div>")
                    .addClass(c.navContainerClass)
                    .appendTo(this.$element)
              ).addClass("disabled")),
                (this._controls.$previous = a("<" + c.navElement + ">")
                  .addClass(c.navClass[0])
                  .html(c.navText[0])
                  .prependTo(this._controls.$relative)
                  .on(
                    "click",
                    a.proxy(function(a) {
                      this.prev(c.navSpeed);
                    }, this)
                  )),
                (this._controls.$next = a("<" + c.navElement + ">")
                  .addClass(c.navClass[1])
                  .html(c.navText[1])
                  .appendTo(this._controls.$relative)
                  .on(
                    "click",
                    a.proxy(function(a) {
                      this.next(c.navSpeed);
                    }, this)
                  )),
                c.dotsData ||
                  (this._templates = [
                    a('<button role="button">')
                      .addClass(c.dotClass)
                      .append(a("<span>"))
                      .prop("outerHTML")
                  ]),
                (this._controls.$absolute = (c.dotsContainer
                  ? a(c.dotsContainer)
                  : a("<div>")
                      .addClass(c.dotsClass)
                      .appendTo(this.$element)
                ).addClass("disabled")),
                this._controls.$absolute.on(
                  "click",
                  "button",
                  a.proxy(function(b) {
                    var d = a(b.target)
                      .parent()
                      .is(this._controls.$absolute)
                      ? a(b.target).index()
                      : a(b.target)
                          .parent()
                          .index();
                    b.preventDefault(), this.to(d, c.dotsSpeed);
                  }, this)
                );
              for (b in this._overrides) this._core[b] = a.proxy(this[b], this);
            }),
            (e.prototype.destroy = function() {
              var a, b, c, d, e;
              e = this._core.settings;
              for (a in this._handlers) this.$element.off(a, this._handlers[a]);
              for (b in this._controls)
                "$relative" === b && e.navContainer
                  ? this._controls[b].html("")
                  : this._controls[b].remove();
              for (d in this.overides) this._core[d] = this._overrides[d];
              for (c in Object.getOwnPropertyNames(this))
                "function" != typeof this[c] && (this[c] = null);
            }),
            (e.prototype.update = function() {
              var a,
                b,
                c,
                d = this._core.clones().length / 2,
                e = d + this._core.items().length,
                f = this._core.maximum(!0),
                g = this._core.settings,
                h =
                  g.center || g.autoWidth || g.dotsData
                    ? 1
                    : g.dotsEach || g.items;
              if (
                ("page" !== g.slideBy &&
                  (g.slideBy = Math.min(g.slideBy, g.items)),
                g.dots || "page" == g.slideBy)
              )
                for (this._pages = [], a = d, b = 0, c = 0; a < e; a++) {
                  if (b >= h || 0 === b) {
                    if (
                      (this._pages.push({
                        start: Math.min(f, a - d),
                        end: a - d + h - 1
                      }),
                      Math.min(f, a - d) === f)
                    )
                      break;
                    (b = 0), ++c;
                  }
                  b += this._core.mergers(this._core.relative(a));
                }
            }),
            (e.prototype.draw = function() {
              var b,
                c = this._core.settings,
                d = this._core.items().length <= c.items,
                e = this._core.relative(this._core.current()),
                f = c.loop || c.rewind;
              this._controls.$relative.toggleClass("disabled", !c.nav || d),
                c.nav &&
                  (this._controls.$previous.toggleClass(
                    "disabled",
                    !f && e <= this._core.minimum(!0)
                  ),
                  this._controls.$next.toggleClass(
                    "disabled",
                    !f && e >= this._core.maximum(!0)
                  )),
                this._controls.$absolute.toggleClass("disabled", !c.dots || d),
                c.dots &&
                  ((b =
                    this._pages.length -
                    this._controls.$absolute.children().length),
                  c.dotsData && 0 !== b
                    ? this._controls.$absolute.html(this._templates.join(""))
                    : b > 0
                    ? this._controls.$absolute.append(
                        new Array(b + 1).join(this._templates[0])
                      )
                    : b < 0 &&
                      this._controls.$absolute
                        .children()
                        .slice(b)
                        .remove(),
                  this._controls.$absolute
                    .find(".active")
                    .removeClass("active"),
                  this._controls.$absolute
                    .children()
                    .eq(a.inArray(this.current(), this._pages))
                    .addClass("active"));
            }),
            (e.prototype.onTrigger = function(b) {
              var c = this._core.settings;
              b.page = {
                index: a.inArray(this.current(), this._pages),
                count: this._pages.length,
                size:
                  c &&
                  (c.center || c.autoWidth || c.dotsData
                    ? 1
                    : c.dotsEach || c.items)
              };
            }),
            (e.prototype.current = function() {
              var b = this._core.relative(this._core.current());
              return a
                .grep(
                  this._pages,
                  a.proxy(function(a, c) {
                    return a.start <= b && a.end >= b;
                  }, this)
                )
                .pop();
            }),
            (e.prototype.getPosition = function(b) {
              var c,
                d,
                e = this._core.settings;
              return (
                "page" == e.slideBy
                  ? ((c = a.inArray(this.current(), this._pages)),
                    (d = this._pages.length),
                    b ? ++c : --c,
                    (c = this._pages[((c % d) + d) % d].start))
                  : ((c = this._core.relative(this._core.current())),
                    (d = this._core.items().length),
                    b ? (c += e.slideBy) : (c -= e.slideBy)),
                c
              );
            }),
            (e.prototype.next = function(b) {
              a.proxy(this._overrides.to, this._core)(this.getPosition(!0), b);
            }),
            (e.prototype.prev = function(b) {
              a.proxy(this._overrides.to, this._core)(this.getPosition(!1), b);
            }),
            (e.prototype.to = function(b, c, d) {
              var e;
              !d && this._pages.length
                ? ((e = this._pages.length),
                  a.proxy(this._overrides.to, this._core)(
                    this._pages[((b % e) + e) % e].start,
                    c
                  ))
                : a.proxy(this._overrides.to, this._core)(b, c);
            }),
            (a.fn.owlCarousel.Constructor.Plugins.Navigation = e);
        })(window.Zepto || window.jQuery, window, document),
        (function(a, b, c, d) {
          "use strict";
          var e = function(c) {
            (this._core = c),
              (this._hashes = {}),
              (this.$element = this._core.$element),
              (this._handlers = {
                "initialized.owl.carousel": a.proxy(function(c) {
                  c.namespace &&
                    "URLHash" === this._core.settings.startPosition &&
                    a(b).trigger("hashchange.owl.navigation");
                }, this),
                "prepared.owl.carousel": a.proxy(function(b) {
                  if (b.namespace) {
                    var c = a(b.content)
                      .find("[data-hash]")
                      .addBack("[data-hash]")
                      .attr("data-hash");
                    if (!c) return;
                    this._hashes[c] = b.content;
                  }
                }, this),
                "changed.owl.carousel": a.proxy(function(c) {
                  if (c.namespace && "position" === c.property.name) {
                    var d = this._core.items(
                        this._core.relative(this._core.current())
                      ),
                      e = a
                        .map(this._hashes, function(a, b) {
                          return a === d ? b : null;
                        })
                        .join();
                    if (!e || b.location.hash.slice(1) === e) return;
                    b.location.hash = e;
                  }
                }, this)
              }),
              (this._core.options = a.extend(
                {},
                e.Defaults,
                this._core.options
              )),
              this.$element.on(this._handlers),
              a(b).on(
                "hashchange.owl.navigation",
                a.proxy(function(a) {
                  var c = b.location.hash.substring(1),
                    e = this._core.$stage.children(),
                    f = this._hashes[c] && e.index(this._hashes[c]);
                  f !== d &&
                    f !== this._core.current() &&
                    this._core.to(this._core.relative(f), !1, !0);
                }, this)
              );
          };
          (e.Defaults = { URLhashListener: !1 }),
            (e.prototype.destroy = function() {
              var c, d;
              a(b).off("hashchange.owl.navigation");
              for (c in this._handlers)
                this._core.$element.off(c, this._handlers[c]);
              for (d in Object.getOwnPropertyNames(this))
                "function" != typeof this[d] && (this[d] = null);
            }),
            (a.fn.owlCarousel.Constructor.Plugins.Hash = e);
        })(window.Zepto || window.jQuery, window, document),
        (function(a, b, c, d) {
          function e(b, c) {
            var e = !1,
              f = b.charAt(0).toUpperCase() + b.slice(1);
            return (
              a.each((b + " " + h.join(f + " ") + f).split(" "), function(
                a,
                b
              ) {
                if (g[b] !== d) return (e = !c || b), !1;
              }),
              e
            );
          }
          function f(a) {
            return e(a, !0);
          }
          var g = a("<support>").get(0).style,
            h = "Webkit Moz O ms".split(" "),
            i = {
              transition: {
                end: {
                  WebkitTransition: "webkitTransitionEnd",
                  MozTransition: "transitionend",
                  OTransition: "oTransitionEnd",
                  transition: "transitionend"
                }
              },
              animation: {
                end: {
                  WebkitAnimation: "webkitAnimationEnd",
                  MozAnimation: "animationend",
                  OAnimation: "oAnimationEnd",
                  animation: "animationend"
                }
              }
            },
            j = {
              csstransforms: function() {
                return !!e("transform");
              },
              csstransforms3d: function() {
                return !!e("perspective");
              },
              csstransitions: function() {
                return !!e("transition");
              },
              cssanimations: function() {
                return !!e("animation");
              }
            };
          j.csstransitions() &&
            ((a.support.transition = new String(f("transition"))),
            (a.support.transition.end =
              i.transition.end[a.support.transition])),
            j.cssanimations() &&
              ((a.support.animation = new String(f("animation"))),
              (a.support.animation.end = i.animation.end[a.support.animation])),
            j.csstransforms() &&
              ((a.support.transform = new String(f("transform"))),
              (a.support.transform3d = j.csstransforms3d()));
        })(window.Zepto || window.jQuery, window, document);
    }
    (a.fn.scrollerSlideSize = function() {
      return this.each(function() {
        var b = a(this),
          c = b.find("img").eq(0),
          d = parseInt(c.attr("width")),
          e = b.parents(".slider-wrapper"),
          f = e.width(),
          g = e.attr("data-max-width"),
          h = parseInt(e.attr("data-padding-side")),
          i = parseInt(
            c
              .parents(".wf-td")
              .eq(0)
              .css("paddingLeft")
          ),
          j = parseInt(
            c
              .parents(".wf-td")
              .eq(0)
              .css("paddingRight")
          ),
          k = 0;
        if ((i > 0 && j > 0 && (k = i + j), "undefined" != typeof g))
          var l = (f * parseFloat(g)) / 100 - k - h;
        if (d > l) var m = l;
        else {
          var m = parseInt(c.attr("width"));
          c.exists() || (m = 280);
        }
        b.parents(".slider-wrapper").attr("data-width", m + k),
          b.css({ width: m + k });
      });
    }),
      a(
        ".slider-wrapper.description-under-image:not(.related-projects) article"
      ).scrollerSlideSize();
    var D = a(".slider-wrapper:not(.related-projects)");
    D.each(function() {
      function b(a) {
        var b = parseInt(e.attr("data-max-width")),
          c = (D.width() * parseFloat(b)) / 100 - f,
          d = parseInt(e.find("img").attr("width")),
          g = parseInt(e.find("img").attr("height"));
        b &&
          c < d &&
          (e.find("article").css({ "max-width": c + "px" }),
          e.find("img").css({ "max-width": c + "px", height: (c * g) / d }));
      }
      function c(a) {
        var b = e.find(".owl-stage"),
          c = b.width(),
          d = e.find(".dt-owl-item"),
          f = 0;
        (f = (d.width() + parseInt(d.css("margin-right"))) * a.item.count),
          f > c && b.width(f);
      }
      var d,
        e = a(this),
        f = e.attr("data-padding-side")
          ? parseInt(e.attr("data-padding-side"))
          : 0,
        g = "true" === e.attr("data-autoslide"),
        h = e.attr("data-delay") ? parseInt(e.attr("data-delay")) : 6e3,
        i = "true" === e.attr("data-arrows"),
        j = e.attr("data-width")
          ? D.width() / parseInt(e.attr("data-width"))
          : D.width() / D.find("article img").attr("width"),
        k = "rtl" == jQuery(document).attr("dir"),
        l = e.attr("data-next-icon")
          ? e.attr("data-next-icon")
          : "icon-ar-018-r",
        m = e.attr("data-prev-icon")
          ? e.attr("data-prev-icon")
          : "icon-ar-018-l";
      (j = e.attr("data-width")
        ? D.width() / parseInt(e.attr("data-width"))
        : e.attr("data-max-width")
        ? D.width() / parseInt(e.attr("data-max-width"))
        : D.width() / D.find("article img").attr("width")),
        e
          .owlCarousel({
            rtl: k,
            items: j,
            autoHeight: !1,
            margin: f,
            loadedClass: "owl-loaded",
            slideBy: "page",
            loop: !1,
            smartSpeed: 600,
            merge: !0,
            autoWidth: !0,
            responsive: { 678: { mergeFit: !0 }, 1e3: { mergeFit: !1 } },
            autoplay: g,
            autoplayTimeout: h,
            nav: i,
            navElement: "a",
            navText: ['<i class="' + m + '"></i>', '<i class="' + l + '"></i>'],
            dots: !1,
            onInitialize: b,
            onInitialized: c,
            onRefreshed: c
          })
          .trigger("refresh.owl.carousel"),
        e.on("drag.owl.carousel translate.owl.carousel", function(a) {
          e.addClass("ts-interceptClicks");
        }),
        e.on("dragged.owl.carousel translated.owl.carousel", function(a) {
          clearTimeout(d),
            (d = setTimeout(function() {
              e.removeClass("ts-interceptClicks");
            }, 400));
        }),
        e.on("changed.owl.carousel", function(b) {
          a(".dt-owl-item.cloned .is-loaded", e)
            .parents()
            .hasClass("layzr-bg") &&
            a(".dt-owl-item.cloned .is-loaded", e)
              .parents()
              .removeClass("layzr-bg"),
            a(
              ".dt-owl-item.cloned .photoswipe-wrapper, .dt-owl-item.cloned .photoswipe-item .dt-gallery-container",
              e
            ).initPhotoswipe(),
            a(
              ".animate-element:not(.start-animation):in-viewport",
              e
            ).checkInViewport();
        }),
        e.find(".dt-owl-item").on("mouseenter", function(a) {
          g && e.trigger("stop.owl.autoplay");
        }),
        e.find(".dt-owl-item").on("mouseleave", function(a) {
          g && e.trigger("play.owl.autoplay", [h]);
        }),
        e.find(".owl-nav a").on("mouseenter", function(a) {
          g && e.trigger("stop.owl.autoplay");
        }),
        e.find(".owl-nav a").on("mouseleave", function(a) {
          g && e.trigger("play.owl.autoplay", [h]);
        }),
        e.on("mouseenter", function(a) {
          e.addClass("show-arrows");
        }),
        e.on("mouseleave", function(a) {
          e.removeClass("show-arrows");
        });
    }),
      (a.fn.postTypeScroller = function() {
        var b = a(this),
          c = "rtl" == jQuery(document).attr("dir"),
          d = b.attr("data-next-icon")
            ? b.attr("data-next-icon")
            : "icon-ar-018-r",
          e = b.attr("data-prev-icon")
            ? b.attr("data-prev-icon")
            : "icon-ar-018-l",
          f =
            (b.attr("data-padding-side")
              ? parseInt(b.attr("data-padding-side"))
              : 0,
            "true" != b.attr("data-paused") &&
              "undefined" != typeof b.attr("data-autoslide")),
          g =
            ("true" !== b.attr("data-paused"),
            b.attr("data-autoslide") && parseInt(b.attr("data-autoslide")) > 999
              ? parseInt(b.attr("data-autoslide"))
              : 5e3),
          h =
            ("undefined" != typeof b.attr("data-autoslide"),
            b.attr("data-width") ? parseInt(b.attr("data-width")) : 800),
          i = b.attr("data-height") ? parseInt(b.attr("data-height")) : 400,
          j = b.attr("data-img-mode") ? b.attr("data-img-mode") : "fill";
        b.owlCarousel({
          rtl: c,
          items: 1,
          autoHeight: !1,
          center: !1,
          margin: 0,
          loadedClass: "owl-loaded",
          slideBy: 1,
          loop: !0,
          smartSpeed: 600,
          autoplay: f,
          autoplayTimeout: g,
          nav: !0,
          navElement: "a",
          navText: ['<i class="' + e + '"></i>', '<i class="' + d + '"></i>'],
          dots: !1
        }),
          v.on("debouncedresize", function() {
            b.find(".dt-owl-item").each(function(c) {
              var d = a(this),
                e = d.find("img");
              if ((e.css({ opacity: 0 }), !e)) return !1;
              var f = 1;
              (f = i < h ? i / h : i / h),
                "fit" == j
                  ? d.css({ height: f * d.width() })
                  : d.css({ height: f * b.width() });
              var g,
                k,
                l,
                m,
                n,
                o = parseInt(e.attr("width")),
                p = parseInt(e.attr("height")),
                q = d.width(),
                r = f * d.width(),
                s = {};
              (g = q / o),
                (k = r / p),
                (l =
                  "fill" == b.attr("data-img-mode")
                    ? g > k
                      ? g
                      : k
                    : "fit" == b.attr("data-img-mode")
                    ? g < k
                      ? g
                      : k
                    : g > k
                    ? g
                    : k),
                (m = Math.ceil(o * l, 10)),
                (n = Math.ceil(p * l, 10)),
                (s.width = m),
                (s.height = n),
                (s.opacity = 1),
                e.css(s),
                b.trigger("refresh.owl.carousel");
            });
          }),
          "undefined" != typeof b.attr("data-autoslide") &&
            a('<div class="psPlay"></div>').appendTo(b),
          "true" === b.attr("data-paused") &&
            (a(".psPlay", b).addClass("paused"),
            b.trigger("stop.owl.autoplay")),
          a(".psPlay", b).on("click", function(b) {
            b.preventDefault();
            var c = a(this);
            c.hasClass("paused")
              ? (c.removeClass("paused"),
                (f = !0),
                c.trigger("play.owl.autoplay", [g, 600]))
              : (c.addClass("paused"), c.trigger("stop.owl.autoplay"));
          });
      }),
      a(".slider-simple:not(.slider-masonry)").each(function() {
        a(this).postTypeScroller();
      });
    var E = a(
      "#main .slider-content, #footer .slider-content, .side-header:not(.sub-downwards) .mega-full-width > .dt-mega-menu-wrap  .slider-content, .side-header:not(.sub-downwards) .mega-auto-width > .dt-mega-menu-wrap  .slider-content"
    );
    (a.fn.widgetScroller = function() {
      return this.each(function() {
        var b = a(this),
          c = "undefined" != typeof b.attr("data-autoslide"),
          d = b.attr("data-autoslide")
            ? parseInt(b.attr("data-autoslide"))
            : 6e3,
          e = "rtl" == jQuery(document).attr("dir");
        b.owlCarousel({
          rtl: e,
          items: 1,
          autoHeight: !0,
          margin: 0,
          loadedClass: "owl-loaded",
          slideBy: "page",
          loop: b.children().length > 1,
          smartSpeed: 600,
          autoplay: c,
          autoplayTimeout: d,
          autoplayHoverPause: !1,
          nav: !1,
          dots: !0,
          dotsEach: !0
        });
      });
    }),
      E.widgetScroller().css("visibility", "visible");
    a(".dt-owl-carousel-call, .related-projects").each(function(b) {
      var c,
        d,
        e,
        f = a(this),
        g = f.attr("data-col-gap") ? parseInt(f.attr("data-col-gap")) : 0,
        h = "true" === f.attr("data-auto-height"),
        i = f.attr("data-speed") ? parseInt(f.attr("data-speed")) : 600,
        j = "true" === f.attr("data-autoplay"),
        l = f.attr("data-autoplay_speed")
          ? parseInt(f.attr("data-autoplay_speed"))
          : 6e3,
        m = "true" === f.attr("data-arrows"),
        n = "true" === f.attr("data-bullet"),
        o = f.attr("data-wide-col-num")
          ? parseInt(f.attr("data-wide-col-num"))
          : 3,
        p = f.attr("data-col-num") ? parseInt(f.attr("data-col-num")) : 3,
        q = f.attr("data-laptop-col") ? parseInt(f.attr("data-laptop-col")) : 3,
        r = f.attr("data-h-tablet-columns-num")
          ? parseInt(f.attr("data-h-tablet-columns-num"))
          : 3,
        s = f.attr("data-v-tablet-columns-num")
          ? parseInt(f.attr("data-v-tablet-columns-num"))
          : 2,
        t = f.attr("data-phone-columns-num")
          ? parseInt(f.attr("data-phone-columns-num"))
          : 1,
        u = "rtl" == jQuery(document).attr("dir"),
        v =
          "1" == f.attr("data-scroll-mode")
            ? parseInt(f.attr("data-scroll-mode"))
            : "page",
        w = f.attr("data-next-icon")
          ? f.attr("data-next-icon")
          : "icon-ar-002-r",
        x = f.attr("data-prev-icon")
          ? f.attr("data-prev-icon")
          : "icon-ar-001-l",
        y = !("1" != f.attr("data-scroll-mode") || !n);
      if ("undefined" != typeof f.attr("data-stage-padding"))
        var z = f.hasClass("enable-img-shadow")
          ? parseInt(f.attr("data-stage-padding")) +
            parseInt(f.attr("data-col-gap")) / 2
          : parseInt(f.attr("data-stage-padding"));
      else var z = 0;
      (g = f.attr("data-col-gap")
        ? parseInt(f.attr("data-col-gap"))
        : f.attr("data-padding-side")
        ? parseInt(f.attr("data-padding-side"))
        : 0),
        f.on("initialize.owl.carousel", function(b) {
          a(f[0])
            .find("script, style")
            .each(function() {
              var b = a(this);
              b.siblings().first();
              a(b).prev().length > 0
                ? a(b)
                    .prev()
                    .andSelf()
                    .wrapAll("<div class='carousel-item-wrap' />")
                : a(b).next().length > 0 &&
                  a(b)
                    .next()
                    .andSelf()
                    .wrapAll("<div class='carousel-item-wrap' />");
            });
        }),
        f.owlCarousel({
          rtl: u,
          items: o,
          autoHeight: h,
          margin: g,
          stagePadding: z,
          loadedClass: "owl-loaded",
          slideBy: v,
          loop: !0,
          smartSpeed: i,
          responsive: {
            0: { items: t, loop: f.children().length > t, stagePadding: 0 },
            481: { loop: f.children().length > s, items: s, stagePadding: 0 },
            769: {
              loop: f.children().length > r,
              items: r,
              stagePadding: z / 2
            },
            1025: { loop: f.children().length > q, items: q },
            1100: { loop: f.children().length > p, items: p },
            1450: { loop: f.children().length > o, items: o }
          },
          autoplay: j,
          autoplayTimeout: l,
          nav: m,
          navElement: "a",
          navText: ['<i class="' + x + '" ></i>', '<i class="' + w + '"></i>'],
          dots: n,
          dotsEach: y
        }),
        f.hasClass("content-rollover-layout-list") &&
          !f.hasClass("disable-layout-hover") &&
          f.find(".post-entry-wrapper").clickOverlayGradient(),
        clearTimeout(e),
        (e = setTimeout(function() {
          f.trigger("refresh.owl.carousel");
        }, i)),
        k(function() {
          f.trigger("refresh.owl.carousel"),
            a(
              ".layzr-loading-on .dt-owl-carousel-call:not(.carousel-shortcode) .dt-owl-item.active"
            ).layzrCarouselInitialisation(),
            a(
              ".layzr-loading-on .dt-owl-carousel-call:not(.carousel-shortcode) .dt-owl-item.active"
            )
              .next()
              .layzrCarouselInitialisation(),
            a(
              ".layzr-loading-on .dt-owl-carousel-call:not(.carousel-shortcode) .dt-owl-item.active"
            )
              .prev()
              .layzrCarouselInitialisation(),
            f.hasClass("content-rollover-layout-list") &&
              !f.hasClass("disable-layout-hover") &&
              f.find(".post-entry-wrapper").clickOverlayGradient(),
            clearTimeout(c),
            (c = setTimeout(function() {
              a(
                ".dt-owl-item.cloned .animate-element.animation-triggered:not(.start-animation)"
              ).addClass("start-animation");
            }, 50));
        }),
        f.on("changed.owl.carousel", function(b) {
          a(
            ".dt-owl-item.cloned .photoswipe-wrapper, .dt-owl-item.cloned .photoswipe-item .dt-gallery-container",
            f
          ).initPhotoswipe(),
            a(
              ".animate-element:not(.start-animation):in-viewport",
              f
            ).checkInViewport(),
            f.hasClass("gallery-shortcode") &&
              a(f).initCarouselClonedPhotoswipe();
        }),
        f.on("change.owl.carousel", function(b) {
          clearTimeout(d),
            (d = setTimeout(function() {
              a(
                ".layzr-loading-on .dt-owl-carousel-call:not(.carousel-shortcode) .dt-owl-item.active"
              ).layzrCarouselInitialisation(),
                a(
                  ".layzr-loading-on .dt-owl-carousel-call:not(.carousel-shortcode) .dt-owl-item.active"
                )
                  .next()
                  .layzrCarouselInitialisation(),
                a(
                  ".layzr-loading-on .dt-owl-carousel-call:not(.carousel-shortcode) .dt-owl-item.active"
                )
                  .prev()
                  .layzrCarouselInitialisation();
            }, 20));
        }),
        f.find(".dt-owl-item").on("mouseenter", function(a) {
          j && f.trigger("stop.owl.autoplay");
        }),
        f.find(".dt-owl-item").on("mouseleave", function(a) {
          j && f.trigger("play.owl.autoplay", [l]);
        }),
        f.find(".owl-nav a").on("mouseenter", function(a) {
          j && f.trigger("stop.owl.autoplay");
        }),
        f.find(".owl-nav a").on("mouseleave", function(a) {
          j && f.trigger("play.owl.autoplay", [l]);
        });
    });
    var t;
    !dtGlobals.isMobile ||
      dtGlobals.isWindowsPhone ||
      dtGlobals.isAndroid ||
      v.bind("orientationchange", function(b) {
        clearTimeout(t),
          (t = setTimeout(function() {
            a(".dt-owl-carousel-call, .related-projects").trigger(
              "refresh.owl.carousel"
            );
          }, 200));
      });
    var F = a(".top-bar"),
      G = a(".masthead"),
      H = a(".overlay-navigation"),
      I = a(".sticky-header"),
      J = a(".sticky-top-line"),
      K = a("#main-slideshow, .photo-scroller"),
      L =
        (a(".header-side-left").length > 0,
        a(".header-side-right").length > 0,
        a(
          "#main, #main-slideshow, .photo-scroller, .page-title, .fancy-header, .footer"
        ),
        a(
          ".floating-logo.side-header-menu-icon .branding, .side-header-h-stroke, #phantom"
        ),
        a(".side-header")),
      M = a(".page-template-template-microsite").length > 0,
      N = x.hasClass("transparent"),
      O = a(".floating-navigation-below-slider").exists();
    if (a(".side-header-v-stroke").length > 0) {
      L.width() - a(".side-header-v-stroke").width();
    } else {
      L.width();
    }
    if (
      ((a.closeSideHeader = function() {
        y.removeClass("show-header"),
          y.addClass("closed-header"),
          a(".sticky-header-overlay").removeClass("active");
      }),
      (a.closeMobileHeader = function() {
        y.removeClass("show-mobile-header"),
          y.addClass("closed-mobile-header"),
          x
            .removeClass("show-sticky-mobile-header show-overlay-mobile-header")
            .addClass("closed-overlay-mobile-header"),
          a(
            ".mobile-sticky-header-overlay, .dt-mobile-menu-icon, .menu-toggle"
          ).removeClass("active");
      }),
      I.length > 0 || H.length > 0)
    ) {
      if (
        (a(
          '<div class="lines-button x"><span class="lines"></span></div>'
        ).appendTo(".menu-toggle"),
        I.length > 0 &&
          (x.append('<div class="sticky-header-overlay"></div>'),
          !a(".header-under-side-line").length > 0 &&
            a(".mixed-header").length > 0))
      ) {
        a(".mixed-header")
          .find(".menu-toggle")
          .position().top;
        a(".mixed-header")
          .find(".menu-toggle")
          .clone(!0)
          .prependTo(".side-header");
      }
      H.length > 0 &&
        (a(L).append('<div class="hide-overlay"></div>'),
        a(
          '<div class="lines-button x"><span class="lines"></span></div>'
        ).appendTo(".hide-overlay"));
      var P = a(".menu-toggle .lines-button"),
        Q = a(".menu-toggle:not(.active)"),
        R = a(".sticky-header-overlay");
      P.on("click", function() {
        if (!a(".header-under-side-line").length > 0)
          var b = a(".side-header .menu-toggle");
        else var b = a(".menu-toggle");
        b.hasClass("active")
          ? (b.removeClass("active"),
            y.removeClass("show-header").addClass("closed-header"),
            R.removeClass("active"),
            a(".hide-overlay").removeClass("active"))
          : (Q.removeClass("active"),
            b.addClass("active").css({ left: "", right: "" }),
            y.addClass("show-header").removeClass("closed-header"),
            R.addClass("active"),
            a(".hide-overlay").addClass("active"));
      }),
        R.on("click", function() {
          a(this).hasClass("active") &&
            (Q.removeClass("active"),
            y.removeClass("show-header").addClass("closed-header"),
            R.removeClass("active"));
        }),
        a(".hide-overlay").on("click", function() {
          a(this).hasClass("active") &&
            (Q.removeClass("active"),
            y.removeClass("show-header"),
            y.addClass("closed-header"),
            R.removeClass("active"));
        });
    }
    if (
      (c(),
      v.on("resize", function() {
        c();
      }),
      O && x.hasClass("footer-overlap") && G.insertAfter(K),
      navigator.userAgent.match(/Trident.*rv\:11\./) && O && N)
    ) {
      G.insertAfter(K);
      var S = G.attr("style");
      G.attr("style", S + "; top:" + K.height() + "px !important;");
    }
    if (a(".mixed-header").length > 0) var T = a(".mixed-header");
    else var T = G;
    var U = 0,
      V = !1;
    if (
      ((window.clickMenuToggle = function(b, c) {
        if (a(".show-mobile-header").length > 0) var d = a(".dt-mobile-header");
        else var d = L;
        a(".menu-item > a").each(function() {
          a(this)
            .attr("href")
            .match("#!") && (V = !0);
        }),
          M || V
            ? w.hasClass("onepage-menu-open")
              ? w.removeClass("onepage-menu-open")
              : w.addClass("onepage-menu-open")
            : w.hasClass("menu-open")
            ? (w.removeClass("menu-open"),
              dtGlobals.isiOS &&
                (v.off("touchstart.dt"), v.off("touchmove.dt")))
            : ((U = dtGlobals.winScrollTop),
              w.addClass("menu-open"),
              dtGlobals.isiOS &&
                v.on("touchstart.dt", function(a) {
                  v.off("touchmove.dt"),
                    d[0].offsetHeight >= d[0].scrollHeight
                      ? v.on("touchmove.dt", function(a) {
                          a.preventDefault();
                        })
                      : d[0].scrollTop <= 0
                      ? (d[0].scrollTop += 1)
                      : d[0].scrollTop + d[0].offsetHeight >=
                          d[0].scrollHeight && (d[0].scrollTop -= 1);
                }));
      }),
      x.on(
        "click",
        ".menu-toggle .lines-button, .sticky-header-overlay, .hide-overlay",
        function(b) {
          clickMenuToggle(a(this), b);
        }
      ),
      a(".side-header .header-bar").wrap(
        "<div class='header-scrollbar-wrap'></div>"
      ),
      L.length > 0 &&
        !dtGlobals.isMobile &&
        (a(".header-scrollbar-wrap").mCustomScrollbar({
          scrollInertia: 150,
          callbacks: {
            whileScrolling: function() {
              a(".header-scrollbar-wrap").layzrInitialisation();
            }
          }
        }),
        a(".sub-downwards .main-nav")
          .find(".slider-content")
          .widgetScroller()
          .css("visibility", "visible")),
      L.length > 0 &&
        !a(".mCSB_container").length > 0 &&
        a(".side-header .header-scrollbar-wrap .header-bar").wrap(
          "<div class='mCSB_container'></div>"
        ),
      !x.hasClass("responsive-off"))
    ) {
      var W = a(".mixed-header"),
        X = a(".masthead .near-logo-first-switch")
          .clone(!0)
          .addClass("show-on-first-switch"),
        Y = a(".masthead .near-logo-second-switch")
          .clone(!0)
          .addClass("show-on-second-switch"),
        Z = G.find(".in-menu-first-switch")
          .clone(!0)
          .addClass(
            "hide-on-desktop hide-on-second-switch show-on-first-switch"
          ),
        $ = G.find(".in-menu-second-switch")
          .clone(!0)
          .addClass(
            "hide-on-desktop hide-on-first-switch show-on-second-switch"
          ),
        _ = G.find(".in-top-bar")
          .clone(!0)
          .addClass(
            "hide-on-desktop hide-on-first-switch show-on-second-switch"
          ),
        aa = G.find(".in-top-bar-left")
          .clone(!0)
          .addClass("hide-on-desktop show-on-first-switch"),
        ba = G.find(".in-top-bar-right")
          .clone(!0)
          .addClass("hide-on-desktop  show-on-first-switch");
      if (W.length > 0)
        var ca = W.find(".branding > a, .branding > img").clone(!0),
          T = W;
      else
        var ca = a(".masthead:not(.mixed-header)")
            .find(".branding > a, .branding > img")
            .clone(!0),
          T = G;
      if (F.length > 0 && "none" != F.css("display")) var da = F.innerHeight();
      else var da = 0;
      a(
        "<div class='mobile-header-bar'><div class='mobile-navigation'></div><div class='mobile-mini-widgets'></div><div class='mobile-branding'></div></div>"
      ).appendTo(".masthead"),
        a(".mobile-header-bar .mobile-navigation").append(
          "<a href='#' class='dt-mobile-menu-icon' aria-label='Mobile menu icon'><span class='lines'></span></a>"
        ),
        a(X).appendTo(".mobile-header-bar .mobile-mini-widgets"),
        a(Y).appendTo(".mobile-header-bar .mobile-mini-widgets"),
        a(".left-widgets", F).append(_),
        a(".left-widgets", F).append(aa),
        a(".right-widgets", F)
          .append(ba)
          .removeClass(
            "select-type-menu list-type-menu select-type-menu-second-switch list-type-menu-second-switch"
          ),
        a(".right-widgets", F)
          .append(ba)
          .removeClass(
            "select-type-menu list-type-menu select-type-menu-second-switch list-type-menu-second-switch"
          ),
        a(Z).appendTo(".mobile-mini-widgets-in-menu"),
        a($).appendTo(".mobile-mini-widgets-in-menu"),
        Z.removeClass(
          "select-type-menu list-type-menu select-type-menu-second-switch list-type-menu-second-switch"
        ),
        $.removeClass(
          "select-type-menu list-type-menu select-type-menu-first-switch list-type-menu-first-switch"
        ),
        a(".mobile-header-bar .mobile-branding").append(ca);
      var ea = a(".dt-mobile-header");
      if (
        (ea.siblings().hasClass("dt-parent-menu-clickable") &&
          ea.addClass("dt-parent-menu-clickable"),
        X.removeClass(
          "select-type-menu list-type-menu select-type-menu-second-switch list-type-menu-second-switch"
        ),
        Y.removeClass(
          "select-type-menu list-type-menu select-type-menu-first-switch list-type-menu-first-switch"
        ),
        _.removeClass(
          "show-on-desktop select-type-menu list-type-menu select-type-menu-first-switch list-type-menu-first-switch in-top-bar-left"
        ).addClass("hide-on-desktop hide-on-first-switch"),
        aa
          .removeClass(
            "show-on-desktop select-type-menu list-type-menu select-type-menu-second-switch list-type-menu-second-switch in-top-bar"
          )
          .addClass("hide-on-desktop hide-on-second-switch"),
        ba
          .removeClass(
            "show-on-desktop select-type-menu list-type-menu  select-type-menu-second-switch list-type-menu-second-switch"
          )
          .addClass("hide-on-desktop"),
        a(".header-bar .mini-widgets > .mini-nav ").removeClass(
          "select-type-menu-second-switch list-type-menu-second-switch select-type-menu-first-switch list-type-menu-first-switch"
        ),
        a(
          ".mini-nav.show-on-desktop:not(.show-on-first-switch):not(.show-on-second-switch)",
          F
        ).removeClass(
          "select-type-menu-second-switch list-type-menu-second-switch select-type-menu-first-switch list-type-menu-first-switch"
        ),
        a(".masthead .hide-on-desktop").addClass("display-none"),
        a(".mobile-main-nav ")
          .find("li")
          .each(function() {
            var b = a(this),
              c = b.find(" > .dt-mega-menu-wrap > .sub-nav");
            if (b.hasClass("new-column")) {
              var d = b.prev().find(" > .sub-nav");
              a(" > .sub-nav > *", b).appendTo(d);
            }
            c.unwrap();
          })
          .removeClass("dt-mega-menu dt-mega-parent hide-mega-title")
          .find(" > .sub-nav")
          .removeClass(" hover-style-bg"),
        ea.length > 0)
      ) {
        dtGlobals.mobileMenuPoint = 50;
        var fa = (a(".dt-mobile-header"), a(".dt-mobile-menu-icon")),
          ga = !1,
          ha = T.offset().top;
        if (
          !a(".floating-btn").length > 0 &&
          a(".floating-mobile-menu-icon").length > 0
        ) {
          var ia = fa.first().clone(!0);
          ia.appendTo(".masthead:not(#phantom)").addClass("floating-btn");
        }
        var ja = a(".floating-btn");
        v.scroll(function() {
          (dtGlobals.mobileMenuPoint = ha + T.height() + 50),
            dtGlobals.winScrollTop > dtGlobals.mobileMenuPoint && ga === !1
              ? (ja.parents(".masthead").addClass("show-floating-icon"),
                (ga = !0))
              : dtGlobals.winScrollTop <= dtGlobals.mobileMenuPoint &&
                ga === !0 &&
                (ja.parents(".masthead").removeClass("show-floating-icon"),
                (ga = !1));
        });
        var fa = a(".dt-mobile-menu-icon");
        !a(".mobile-sticky-header-overlay").length > 0 &&
          x.append('<div class="mobile-sticky-header-overlay"></div>');
        var ka = a(".mobile-sticky-header-overlay");
        fa.on("click", function(b) {
          b.preventDefault();
          var c = a(this);
          c.hasClass("active")
            ? (c.removeClass("active"),
              y
                .removeClass("show-mobile-header")
                .addClass("closed-mobile-header"),
              x
                .removeClass("show-mobile-overlay-header")
                .addClass("closed-overlay-mobile-header"),
              c.parents("body").removeClass("show-sticky-mobile-header"),
              ka.removeClass("active"))
            : (fa.removeClass("active"),
              c.addClass("active"),
              y
                .addClass("show-mobile-header")
                .removeClass("closed-mobile-header"),
              x
                .removeClass("closed-overlay-mobile-header")
                .addClass("show-overlay-mobile-header"),
              ka.removeClass("active"),
              c.parents("body").addClass("show-sticky-mobile-header"),
              ka.addClass("active"));
        }),
          ka.on("click", function() {
            a(this).hasClass("active") &&
              (fa.removeClass("active"),
              y
                .removeClass("show-mobile-header")
                .addClass("closed-mobile-header"),
              x
                .removeClass("show-sticky-mobile-header")
                .addClass("closed-overlay-mobile-header")
                .addClass("closed-overlay-mobile-header"),
              ka.removeClass("active"));
          }),
          a(".dt-close-mobile-menu-icon span").on("click", function() {
            y.removeClass("show-mobile-header"),
              y.addClass("closed-mobile-header"),
              x.removeClass("show-sticky-mobile-header"),
              x
                .removeClass("show-overlay-mobile-header")
                .addClass("closed-overlay-mobile-header"),
              ka.removeClass("active"),
              fa.removeClass("active");
          }),
          a(".dt-mobile-header").wrapInner(
            "<div class='mobile-header-scrollbar-wrap'></div>"
          ),
          ea.on("scroll", function() {
            a(".mobile-header-scrollbar-wrap").layzrInitialisation();
          }),
          ea
            .find(".slider-content")
            .widgetScroller()
            .css("visibility", "visible");
      }
    }
    a(".l-to-r-line > li:not(.menu-item-language) > a > span:last-child")
      .not(".l-to-r-line > li > a > span.mega-icon")
      .append("<i class='underline'></i>"),
      a(".not-clickable-item").on("click", function(a) {
        a.preventDefault(), a.stopPropagation();
      }),
      (a(".active-line-decoration").length > 0 ||
        a(".hover-line-decoration").length > 0) &&
        a(".main-nav > .menu-item > a").append(
          "<span class='decoration-line'></span>"
        );
    var la = a(
        ".main-nav, .mini-nav, .mini-wpml .wpml-ls-item-legacy-dropdown"
      ),
      ma = a(
        ".masthead:not(.sub-downwards) .main-nav, .mini-nav, .mini-wpml .wpml-ls-item-legacy-dropdown"
      ),
      na = a(".main-nav"),
      L = a(".side-header");
    a(".menu-item-language").each(function() {
      var b = a(this);
      b.children(".submenu-languages").length > 0 && b.addClass("has-children");
    });
    na.clone(), a(".mini-nav").clone();
    a(".mini-nav select").change(function() {
      window.location.href = a(this).val();
    }),
      (dtGlobals.isHovering = !1),
      a(".main-nav li", L).each(function() {
        var b = a(this);
        if (b.hasClass("new-column")) {
          var c = b.prev().find(" > .sub-nav");
          a(" > .sub-nav > *", b).appendTo(c);
        }
      }),
      a(".sub-downwards .main-nav > li").each(function() {
        var b = a(this),
          c = b.find(" > .dt-mega-menu-wrap > .sub-nav");
        c.unwrap();
      });
    var oa = a(
        ".select-type-menu, .select-type-menu-first-switch, .select-type-menu-second-switch, .mini-wpml .wpml-ls-item-legacy-dropdown"
      ),
      pa = "mini-sub-nav";
    oa.find("> ul").addClass(pa),
      a(".mini-wpml .wpml-ls-item-legacy-dropdown")
        .find("> ul")
        .addClass(pa),
      ma.each(function() {
        var b = a(this);
        a(".act", b)
          .parents("li")
          .addClass("act"),
          a(" li.has-children ", b).each(function() {
            var b = a(this),
              c = b.find("> a");
            if (
              b.parent().hasClass("main-nav") &&
              !b.parents().hasClass("side-header")
            )
              var c = b.find("> a");
            else if (
              b.parent().hasClass("main-nav") &&
              b.parents().hasClass("side-header")
            )
              var c = b;
            else if (
              b.parent().hasClass("sub-nav") ||
              b.parents().hasClass("mini-nav")
            )
              var c = b;
            (dtGlobals.isMobile || dtGlobals.isWindowsPhone) &&
              b.find("> a").on("click", function(b) {
                a(this).hasClass("dt-clicked")
                  ? b.stopPropagation()
                  : (b.preventDefault(),
                    la.find(".dt-clicked").removeClass("dt-clicked"),
                    a(this).addClass("dt-clicked"));
              });
            var d, e;
            if (
              la.parents().hasClass("full-width") &&
              b.hasClass("mega-full-width")
            ) {
              if (la.parents(".header-bar").length > 0)
                var f = la.parents(".header-bar").innerWidth();
              else var f = la.parents(".ph-wrap").innerWidth();
              !L.length > 0 && b.find(".sub-nav-widgets").css({ width: f });
            }
            c.on("mouseenter tap", function(b) {
              var c = a(this);
              if (
                ("tap" == b.type && b.stopPropagation(),
                c.parent("li").length > 0)
              )
                var f = c.parent(),
                  g = c.siblings("div.dt-mega-menu-wrap, ul");
              else
                var f = c,
                  h = c.find("> a"),
                  g = h.siblings("div.dt-mega-menu-wrap, ul");
              var i = c.offset().left,
                h = c.offset().left,
                j = c.parents(".masthead");
              if (
                (f.addClass("dt-hovered"),
                f.hasClass("dt-mega-menu") && f.addClass("show-mega-menu"),
                (dtGlobals.isHovering = !0),
                y.width() - (g.offset().left - y.offset().left) - g.width() <
                  0 && g.addClass("right-overflow"),
                v.height() -
                  (g.offset().top - dtGlobals.winScrollTop) -
                  g.innerHeight() <
                  0 &&
                  !g.parents().hasClass("sub-sideways") &&
                  g.addClass("bottom-overflow"),
                v.height() -
                  (g.offset().top - dtGlobals.winScrollTop) -
                  g.innerHeight() <
                  0 &&
                  !f.hasClass("dt-mega-menu") &&
                  g.addClass("bottom-overflow"),
                (f.find(".dt-mega-menu-wrap").length > 0 &&
                  f.find(".dt-mega-menu-wrap").offset().top +
                    f.find(".dt-mega-menu-wrap").innerHeight()) > v.height() &&
                  g.parents().hasClass("sub-sideways") &&
                  f.hasClass("dt-mega-menu") &&
                  (c.find(".dt-mega-menu-wrap").height() <= v.height()
                    ? f
                        .find(".dt-mega-menu-wrap")
                        .css({
                          top: -(
                            c.offset().top +
                            c.find(".dt-mega-menu-wrap").height() -
                            v.height() +
                            5
                          )
                        })
                    : f
                        .find(".dt-mega-menu-wrap")
                        .css({ top: -(c.position().top - 5) })),
                !L.length > 0 && g.not(".right-overflow").css({ left: h - i }),
                c.parents(".dt-mobile-header").length > 0 &&
                  g.css({ top: c.position().top - 13 - g.height() }),
                f.hasClass("mega-auto-width"))
              ) {
                var k = (f.width(), j.offset().left),
                  l = f.offset().left;
                if ((($_this_parents_ofs = f.offset().left - k), !L.length)) {
                  var m = y.width();
                  if (a(".boxed").length > 0) {
                    var l = f.position().left;
                    g.innerWidth() > m - f.position().left &&
                      g.css({ left: -(g.innerWidth() - (m - l) + 20) });
                  } else {
                    var l = f.offset().left;
                    g.innerWidth() > m - f.offset().left &&
                      g.css({ left: -(g.innerWidth() - (m - l) + 20) });
                  }
                  g.innerWidth() > m &&
                    (a(".boxed").length > 0
                      ? g.css({
                          width: j.width() - 40,
                          left: -(f.position().left + 20)
                        })
                      : g.css({ width: j.width() - 40, left: -(l - k + 20) }));
                }
                void 0 != typeof g.find(".slider-content") &&
                  g
                    .find(".slider-content")
                    .widgetScroller()
                    .css("visibility", "visible"),
                  g.layzrInitialisation();
              }
              if (f.hasClass("mega-full-width")) {
                var l = f.offset().left;
                if (c.parents(".header-bar").length > 0)
                  if (c.parents(".masthead").hasClass("full-width"))
                    var n = c.parents(".header-bar").innerWidth() - 40,
                      k = c.parents(".header-bar").offset().left + 20;
                  else
                    var n = c.parents(".header-bar").innerWidth(),
                      k = c.parents(".header-bar").offset().left;
                else if (c.parents(".masthead").hasClass("full-width"))
                  var n = c.parents(".ph-wrap").innerWidth() - 40,
                    k = c.parents(".ph-wrap").offset().left + 20;
                else
                  var n = c.parents(".ph-wrap").innerWidth(),
                    k = c.parents(".ph-wrap").offset().left;
                !L.length > 0 && g.css({ width: n, left: -(l - k) }),
                  void 0 != typeof g.find(".slider-content") &&
                    g
                      .find(".slider-content")
                      .widgetScroller()
                      .css("visibility", "visible"),
                  g.layzrInitialisation();
              }
              clearTimeout(d),
                clearTimeout(e),
                (d = setTimeout(function() {
                  f.hasClass("dt-hovered") &&
                    (g
                      .stop()
                      .css("visibility", "visible")
                      .animate({ opacity: 1 }, 150, function() {
                        f.addClass("show-mega-menu-content");
                      }),
                    a(".searchform .submit", qb).removeClass("act"),
                    a(".mini-search").removeClass("act"),
                    a(".mini-search.popup-search .popup-search-wrap", qb)
                      .stop()
                      .animate({ opacity: 0 }, 150, function() {
                        a(this).css("visibility", "hidden");
                      }));
                }, 100));
            }),
              b.on("mouseleave", function(b) {
                var c = a(this),
                  f = c.find("> a"),
                  g = f.siblings("div.dt-mega-menu-wrap, ul");
                c.removeClass("dt-hovered"),
                  (dtGlobals.isHovering = !1),
                  clearTimeout(d),
                  clearTimeout(e),
                  (e = setTimeout(function() {
                    c.hasClass("dt-hovered") ||
                      (g.stop().animate({ opacity: 0 }, 150, function() {
                        a(this).css("visibility", "hidden");
                      }),
                      c.removeClass("show-mega-menu"),
                      c.removeClass("show-mega-menu-content"),
                      setTimeout(function() {
                        c.hasClass("dt-hovered") ||
                          (g.removeClass("right-overflow"),
                          g.removeClass("bottom-overflow"),
                          c.find(".dt-mega-menu-wrap").css({ top: "" }),
                          c.hasClass("mega-auto-width") &&
                            g.css({ width: "", left: "" }));
                      }, 400));
                  }, 150)),
                  c.find("> a").removeClass("dt-clicked");
              });
          });
      }),
      (a.fn.touchMenuItem = function() {
        return this.each(function() {
          var b = a(this);
          if (!b.hasClass("item-ready")) {
            x.on("touchend", function(b) {
              a(".mobile-true .has-children > a").removeClass("is-clicked");
            });
            var c = a(this),
              d = c.attr("target") ? c.attr("target") : "_self";
            c.on("touchstart", function(a) {
              (origY = a.originalEvent.touches[0].pageY),
                (origX = a.originalEvent.touches[0].pageX);
            }),
              c.on("touchend", function(b) {
                var e = b.originalEvent.changedTouches[0].pageX,
                  f = b.originalEvent.changedTouches[0].pageY;
                if (origY == f || origX == e)
                  if (c.hasClass("is-clicked"));
                  else if (c.parent().hasClass("dt-hovered"))
                    return (
                      b.preventDefault(),
                      a(".mobile-true .has-children > a").removeClass(
                        "is-clicked"
                      ),
                      c.addClass("is-clicked"),
                      window.open(c.attr("href"), d),
                      !1
                    );
              }),
              b.addClass("item-ready");
          }
        });
      }),
      a(".mobile-true .has-children > a").touchMenuItem();
    var qa, ra;
    oa.on("mouseenter tap", function(b) {
      "tap" == b.type && b.stopPropagation();
      var c = a(this);
      c.addClass("dt-hovered"),
        y.width() -
          (c.children(".mini-sub-nav").offset().left - y.offset().left) -
          c.find(" > .mini-sub-nav").width() <
          0 && c.children(".mini-sub-nav").addClass("right-overflow"),
        v.height() -
          (c.children(".mini-sub-nav").offset().top - dtGlobals.winScrollTop) -
          c.children(".mini-sub-nav").height() <
          0 &&
          !c.parents(".dt-mobile-header").length > 0 &&
          c.children(".mini-sub-nav").addClass("bottom-overflow"),
        c.parents(".dt-mobile-header").length > 0 &&
          c
            .children(".mini-sub-nav")
            .css({
              top: c.position().top - 13 - c.children(".mini-sub-nav").height()
            }),
        (dtGlobals.isHovering = !0),
        clearTimeout(qa),
        clearTimeout(ra),
        (qa = setTimeout(function() {
          c.hasClass("dt-hovered") &&
            (a(".mini-sub-nav")
              .stop()
              .animate({ opacity: 0 }, 50, function() {
                a(this).css("visibility", "hidden");
              }),
            c
              .children(".mini-sub-nav")
              .stop()
              .css("visibility", "visible")
              .animate({ opacity: 1 }, 150));
        }, 100));
    }),
      oa.on("mouseleave", function(b) {
        var c = a(this);
        c.removeClass("dt-hovered"),
          (dtGlobals.isHovering = !1),
          clearTimeout(qa),
          clearTimeout(ra),
          (ra = setTimeout(function() {
            c.hasClass("dt-hovered") ||
              (c.parents().hasClass("dt-mega-menu") ||
                c
                  .children(".mini-sub-nav")
                  .stop()
                  .animate({ opacity: 0 }, 150, function() {
                    a(this).css("visibility", "hidden");
                  }),
              setTimeout(function() {
                c.hasClass("dt-hovered") ||
                  (c.children(".mini-sub-nav").removeClass("right-overflow"),
                  c.children(".mini-sub-nav").removeClass("bottom-overflow"));
              }, 400));
          }, 150));
      }),
      (dtGlobals.desktopProcessed = !1),
      (dtGlobals.mobileProcessed = !1);
    var sa = a(".sticky-mobile-header").exists();
    window.innerWidth <= dtLocal.themeSettings.mobileHeader.firstSwitchPoint &&
      !x.hasClass("responsive-off") &&
      (a(".masthead:not(.side-header):not(#phantom)").addClass(
        "masthead-mobile-header"
      ),
      a(
        "body:not(.overlay-navigation):not(.sticky-header) .side-header:not(#phantom)"
      )
        .addClass("masthead-mobile-header")
        .addClass("desktop-side-header")),
      window.innerWidth <=
        dtLocal.themeSettings.mobileHeader.firstSwitchPoint &&
      window.innerWidth >
        dtLocal.themeSettings.mobileHeader.secondSwitchPoint &&
      !x.hasClass("responsive-off")
        ? a(".left-widgets", F).find(".in-top-bar-left").length > 0 ||
          a(".right-widgets", F).find(".in-top-bar-right").length > 0
          ? F.removeClass("top-bar-empty")
          : F.addClass("top-bar-empty")
        : window.innerWidth <=
            dtLocal.themeSettings.mobileHeader.secondSwitchPoint &&
          !x.hasClass("responsive-off") &&
          (a(".left-widgets", F).find(".in-top-bar").length > 0
            ? F.removeClass("top-bar-empty")
            : F.addClass("top-bar-empty"));
    var ta = a(".floating-navigation-below-slider").exists();
    if (a(".sticky-mobile-header").exists() && !x.hasClass("responsive-off")) {
      var ua = a(
          ".masthead:not(.side-header):not(#phantom), body:not(.overlay-navigation):not(.sticky-header) .side-header:not(#phantom)"
        ),
        ea = ua.find(".mobile-header-bar");
      ($stickyMobileLogo = ua.find(".mobile-branding")),
        (mobileLogoURL = a(".mobile-branding a").attr("href")),
        !a(".sticky-mobile-logo-first-switch").exists() &&
          N &&
          dtLocal.themeSettings.stickyMobileHeaderFirstSwitch.logo.html &&
          (void 0 == mobileLogoURL
            ? a(dtLocal.themeSettings.stickyMobileHeaderFirstSwitch.logo.html)
                .addClass("sticky-mobile-logo-first-switch")
                .prependTo($stickyMobileLogo)
            : a(
                '<a class="sticky-mobile-logo-first-switch" href="' +
                  mobileLogoURL +
                  '">' +
                  dtLocal.themeSettings.stickyMobileHeaderFirstSwitch.logo
                    .html +
                  " </a>"
              ).prependTo($stickyMobileLogo)),
        !a(".sticky-mobile-logo-second-switch").exists() &&
          N &&
          dtLocal.themeSettings.stickyMobileHeaderSecondSwitch.logo.html &&
          (void 0 == mobileLogoURL
            ? a(dtLocal.themeSettings.stickyMobileHeaderSecondSwitch.logo.html)
                .addClass("sticky-mobile-logo-second-switch")
                .prependTo($stickyMobileLogo)
            : a(
                '<a class="sticky-mobile-logo-second-switch" href="' +
                  mobileLogoURL +
                  '">' +
                  dtLocal.themeSettings.stickyMobileHeaderSecondSwitch.logo
                    .html +
                  " </a>"
              ).prependTo($stickyMobileLogo));
      var va = 0,
        wa = 0,
        xa = K.height(),
        ya = 0,
        za = 0,
        Aa = 0,
        Ba = !1;
      if (!N) {
        a("<div class='mobile-header-space'></div>").insertBefore(ua);
        var Ca = a(".mobile-header-space");
      }
      a(".no-cssgridlegacy.no-cssgrid").length > 0 &&
        ta &&
        (N
          ? (ua.css({ top: xa }), Ca.css({ top: xa }))
          : (Ca.insertAfter(K), ua.insertAfter(K))),
        (dtGlobals.resetMobileSizes = function(b) {
          return window.innerWidth >
            dtLocal.themeSettings.mobileHeader.firstSwitchPoint
            ? (a(".is-safari").length > 0 &&
                ua.css({ width: "", "max-width": "" }),
              ua.removeClass("sticky-mobile-off sticky-mobile-on"),
              (Ba = !1),
              !1)
            : ((wa =
                a("#wpadminbar").exists() &&
                !Modernizr.mq("only screen and (max-width:600px)")
                  ? a("#wpadminbar").height()
                  : 0),
              (va =
                !F.exists() ||
                F.is(":hidden") ||
                F.hasClass("top-bar-empty") ||
                F.hasClass("hide-top-bar")
                  ? 0
                  : F.innerHeight()),
              window.innerWidth <
                dtLocal.themeSettings.mobileHeader.firstSwitchPoint &&
              window.innerWidth >
                dtLocal.themeSettings.mobileHeader.secondSwitchPoint
                ? ((ya =
                    dtLocal.themeSettings.mobileHeader.firstSwitchPointHeight +
                    va),
                  (za =
                    dtLocal.themeSettings.mobileHeader.firstSwitchPointHeight))
                : ((ya =
                    dtLocal.themeSettings.mobileHeader.secondSwitchPointHeight +
                    va),
                  (za =
                    dtLocal.themeSettings.mobileHeader
                      .secondSwitchPointHeight)),
              ta
                ? ta && !N
                  ? (Aa = b)
                  : ta && N
                  ? (Aa = b - ya + va)
                  : ea.offset().top
                : (Aa = va),
              ua.hasClass("sticky-mobile-on") && ua.css({ top: wa - va }),
              N || (Ca.css({ height: ya }), Ca.css({ top: b })),
              void (
                a(".is-safari").length > 0 &&
                ua.css({
                  width: document.documentElement.clientWidth,
                  "max-width": document.documentElement.clientWidth
                })
              ));
        }),
        dtGlobals.resetMobileSizes(K.height()),
        v.on("resize debouncedresize", function() {
          dtGlobals.resetMobileSizes(K.height());
        }),
        v.on("scroll", function() {
          if (
            window.innerWidth >
            dtLocal.themeSettings.mobileHeader.firstSwitchPoint
          )
            return !1;
          var b = dtGlobals.winScrollTop;
          b > Aa && !Ba && a(document).height() > a(window).height()
            ? (ua.removeClass("sticky-mobile-off").addClass("sticky-mobile-on"),
              O && sa && ua.addClass("fixed-mobile-header"),
              ua.css({ top: wa - va }),
              (Ba = !0))
            : b <= Aa &&
              Ba &&
              (ua.removeClass("sticky-mobile-on").addClass("sticky-mobile-off"),
              O && sa && ua.removeClass("fixed-mobile-header"),
              ua.css({ top: 0 }),
              a(".no-cssgridlegacy.no-cssgrid").length > 0 &&
                ta &&
                (N ? ua.css({ top: xa }) : ua.css({ top: xa })),
              (Ba = !1));
        });
    }
    dtGlobals.isMobile &&
      window.innerWidth <=
        dtLocal.themeSettings.mobileHeader.firstSwitchPoint &&
      !dtGlobals.isiPad &&
      !x.hasClass("responsive-off") &&
      (dtLocal.themeSettings.floatingHeader.showMenu &&
        a(".phantom-sticky").exists() &&
        N &&
        G.addClass("fixed-masthead"),
      (dtLocal.themeSettings.floatingHeader.showMenu = !1));
    var N = x.hasClass("transparent"),
      Da = a(".phantom-sticky").exists();
    a(".side-header").exists();
    if (dtLocal.themeSettings.floatingHeader.showMenu && Da) {
      var Ea = a(".branding a", G).attr("href"),
        I = G,
        Fa = I.find(".header-bar"),
        Ga = I.find(".branding"),
        Ha = Ga.find("img");
      Ga.find("a.same-logo").length > 0 ||
        a(".sticky-logo").exists() ||
        (dtLocal.themeSettings.floatingHeader.logo.html &&
          dtLocal.themeSettings.floatingHeader.logo.showLogo &&
          (void 0 == Ea
            ? a(dtLocal.themeSettings.floatingHeader.logo.html)
                .addClass("sticky-logo")
                .prependTo(Ga)
            : a(
                '<a class="sticky-logo" href="' +
                  Ea +
                  '">' +
                  dtLocal.themeSettings.floatingHeader.logo.html +
                  " </a>"
              ).prependTo(Ga)));
      var da = 0,
        Ia = 0,
        Ja = 0,
        Ka = 0,
        La = 0,
        Ma = !1,
        Na = "";
      if (!N) {
        a("<div class='header-space'></div>").insertAfter(I);
        var Oa = a(".header-space");
      }
      I.addClass("sticky-off fixed-masthead");
      var Pa = !1;
      (dtGlobals.resetSizes = function(b) {
        return window.innerWidth <=
          dtLocal.themeSettings.mobileHeader.firstSwitchPoint &&
          !x.hasClass("responsive-off")
          ? (Pa ||
              ((Pa = !0),
              I.removeClass("sticky-off sticky-on"),
              N || Oa.removeClass("sticky-space-off sticky-space-on"),
              I.css({ top: "", transform: "" }),
              (Ma = !1),
              (Na = ""),
              a(".is-safari").length > 0 &&
                I.css({ width: "", "max-width": "" })),
            !1)
          : (Pa && (Pa = !1),
            Ma ||
              "" !== Na ||
              (I.addClass("sticky-off"), N || Oa.addClass("sticky-space-off")),
            (Ia = a("#wpadminbar").exists() ? a("#wpadminbar").height() : 0),
            (da =
              !F.exists() ||
              F.is(":hidden") ||
              F.hasClass("top-bar-empty") ||
              F.hasClass("hide-top-bar")
                ? 0
                : F.innerHeight()),
            (Ja = dtLocal.themeSettings.desktopHeader.height + da),
            (Ka = dtLocal.themeSettings.desktopHeader.height),
            ta
              ? ta && !N
                ? (La = x.hasClass("floating-top-bar") ? b - da : b)
                : ta && N
                ? (La = x.hasClass("floating-top-bar") ? b - Ka - da : b - Ka)
                : Fa.offset().top
              : (La = x.hasClass("floating-top-bar") ? 0 : da),
            N || Oa.css({ height: Ja }),
            Fa.css({ height: Ka }),
            void (
              a(".is-safari").length > 0 &&
              (y.hasClass("boxed")
                ? I.css({ width: y.width(), "max-width": y.width() })
                : I.css({
                    width: document.documentElement.clientWidth,
                    "max-width": document.documentElement.clientWidth
                  }))
            ));
      }),
        dtGlobals.resetSizes(K.height()),
        v.on("resize debouncedresize", function() {
          dtGlobals.resetSizes(K.height());
        }),
        d(),
        v.on("scroll", function() {
          d();
        });
    }
    if (J.exists()) {
      var Qa = 0,
        Ia = 0,
        da = 0,
        Ra = !1;
      J.addClass("sticky-top-line-off"),
        a(".top-line-space").exists() ||
          N ||
          a("<div class='top-line-space'></div>").insertBefore(J);
      var Ea = a(".branding a", J).attr("href"),
        Ga = J.find(".branding"),
        Ha = Ga.find("img");
      a(dtLocal.themeSettings.topLine.floatingTopLine.logo.html).attr("src") ===
        Ha.attr("src") ||
        a(".sticky-logo").exists() ||
        (dtLocal.themeSettings.topLine.floatingTopLine.logo.html &&
          dtLocal.themeSettings.topLine.floatingTopLine.logo.showLogo &&
          (void 0 == Ea
            ? a(dtLocal.themeSettings.topLine.floatingTopLine.logo.html)
                .addClass("sticky-logo")
                .prependTo(Ga)
            : a(
                '<a class="sticky-logo" href="' +
                  Ea +
                  '">' +
                  dtLocal.themeSettings.topLine.floatingTopLine.logo.html +
                  " </a>"
              ).prependTo(Ga)));
      var Pa = !1;
      (dtGlobals.resetTopLineSizes = function(b) {
        return window.innerWidth <=
          dtLocal.themeSettings.mobileHeader.firstSwitchPoint &&
          !x.hasClass("responsive-off")
          ? (Pa ||
              ((Pa = !0),
              J.removeClass("sticky-top-line-on"),
              J.css({ top: "" }),
              (Ra = !1)),
            !1)
          : (Pa && (Pa = !1),
            (Ia = a("#wpadminbar").exists() ? a("#wpadminbar").height() : 0),
            (da =
              !F.exists() ||
              F.is(":hidden") ||
              F.hasClass("top-bar-empty") ||
              F.hasClass("hide-top-bar")
                ? 0
                : F.innerHeight()),
            (Qa = J.find(".header-bar").height() + da),
            a(".top-line-space").css({ height: Qa }),
            void (
              a(".is-safari").length > 0 &&
              (y.hasClass("boxed")
                ? J.css({
                    width: dtLocal.themeSettings.boxedWidth,
                    "max-width": dtLocal.themeSettings.boxedWidth
                  })
                : J.css({
                    width: document.documentElement.clientWidth,
                    "max-width": document.documentElement.clientWidth
                  }))
            ));
      }),
        dtGlobals.resetTopLineSizes(K.height()),
        v.on("resize debouncedresize", function() {
          dtGlobals.resetTopLineSizes(K.height());
        }),
        v.on("scroll", function() {
          if (
            window.innerWidth <=
              dtLocal.themeSettings.mobileHeader.firstSwitchPoint &&
            !x.hasClass("responsive-off")
          )
            return !1;
          var a = dtGlobals.winScrollTop,
            b = J.height(),
            c = a > b;
          c && !Ra
            ? (J.removeClass("sticky-top-line-off").addClass(
                "sticky-top-line-on"
              ),
              J.hasClass("mixed-floating-top-bar")
                ? J.css({ top: Ia })
                : J.css({ top: Ia - da }),
              (Ra = !0))
            : !c &&
              Ra &&
              (J.removeClass("sticky-top-line-on").addClass(
                "sticky-top-line-off"
              ),
              J.css({ top: Ia }),
              (Ra = !1));
        });
    }
    if (
      dtLocal.themeSettings.floatingHeader.showMenu &&
      dtLocal.themeSettings.floatingHeader.showMenu &&
      !Da
    ) {
      var Sa = a(".phantom-fade").exists(),
        Ta = a(".phantom-slide").exists(),
        Ua = a(".split-header").exists();
      if (Sa || Ta) {
        var Va = a(".masthead:not(#phantom) .main-nav").clone(!0),
          Ea = a(".branding a", G).attr("href"),
          Wa = x.hasClass("floating-top-bar")
            ? a(".masthead:not(#phantom) .top-bar").clone(!0)
            : "",
          Xa = !1;
        if (Ua) {
          var Ya = G.attr("class"),
            Za = a(".side-header-h-stroke, .split-header"),
            $a = a(
              '<div id="phantom" class="' +
                Ya +
                '"><div class="ph-wrap"></div></div>'
            ).appendTo("body"),
            _a = $a.find(".ph-wrap"),
            ab = $a.find(".widget-box"),
            bb = Va.find(".mini-widgets"),
            cb = Za.find(".branding");
          a(".phantom-custom-logo-on").length > 0 &&
            dtLocal.themeSettings.floatingHeader.logo.html &&
            dtLocal.themeSettings.floatingHeader.logo.showLogo &&
            (void 0 == Ea
              ? a(dtLocal.themeSettings.floatingHeader.logo.html).prependTo(cb)
              : a(
                  '<a class="phantom-top-line-logo" href="' +
                    Ea +
                    '">' +
                    dtLocal.themeSettings.floatingHeader.logo.html +
                    " </a>"
                ).prependTo(cb));
          var Va = a(".split-header .header-bar").clone(!0);
          Va.appendTo(_a),
            x.hasClass("floating-top-bar") && Wa.insertBefore(_a);
        } else {
          var Ya = G.attr("class"),
            $a = a(
              '<div id="phantom" class="' +
                Ya +
                '"><div class="ph-wrap"><div class="logo-box"></div><div class="menu-box"></div><div class="widget-box"></div></div></div>'
            ).appendTo("body"),
            _a = $a.find(".menu-box"),
            ab = $a.find(".widget-box");
          if (a(".classic-header").length > 0)
            var bb = a(".header-bar .navigation .mini-widgets").clone(!0);
          else if (Ua);
          else var bb = a(".header-bar .mini-widgets").clone(!0);
          Va.appendTo(_a),
            bb.appendTo(ab),
            x.hasClass("floating-top-bar") && Wa.prependTo($a),
            dtLocal.themeSettings.floatingHeader.logo.html &&
              dtLocal.themeSettings.floatingHeader.logo.showLogo &&
              ($a.find(".ph-wrap").addClass("with-logo"),
              void 0 == Ea
                ? $a
                    .find(".logo-box")
                    .html(
                      '<a href="' +
                        dtLocal.themeSettings.floatingHeader.logo.url +
                        '">' +
                        dtLocal.themeSettings.floatingHeader.logo.html +
                        " </a>"
                    )
                : $a
                    .find(".logo-box")
                    .html(
                      '<a href="' +
                        Ea +
                        '">' +
                        dtLocal.themeSettings.floatingHeader.logo.html +
                        " </a>"
                    ));
        }
        var db = a("#phantom");
        y.hasClass("boxed") &&
          $a
            .addClass("boxed")
            .find(".ph-wrap")
            .addClass("boxed");
        var eb;
        db
          .removeClass("show-phantom")
          .addClass("hide-phantom")
          .css("visibility", "hidden"),
          k(function() {
            clearTimeout(eb),
              (eb = setTimeout(function() {
                db.css("visibility", "");
              }, 150));
          }),
          _a.layzrInitialisation();
        var fb = !1,
          gb = dtGlobals.winScrollTop,
          xa = K.height(),
          hb = G.height();
        if (ta && N);
        else if (ta);
        else {
          gb <= dtLocal.themeSettings.floatingHeader.showAfter;
        }
        v.on("scroll", function() {
          if (
            window.innerWidth <=
              dtLocal.themeSettings.mobileHeader.firstSwitchPoint &&
            !x.hasClass("responsive-off")
          )
            return !1;
          var a = dtGlobals.winScrollTop,
            b = K.height(),
            c = G.height();
          if (ta && N)
            var d = a > b && Xa === !1,
              e = a <= b && Xa === !0;
          else if (ta)
            var d = a > b + c && Xa === !1,
              e = a <= b + c && Xa === !0;
          else
            var d =
                a > dtLocal.themeSettings.floatingHeader.showAfter && Xa === !1,
              e =
                a <= dtLocal.themeSettings.floatingHeader.showAfter &&
                Xa === !0;
          d
            ? w.hasClass("menu-open") ||
              dtGlobals.isHovering ||
              fb ||
              ((fb = !0),
              db.removeClass("hide-phantom").addClass("show-phantom"),
              (Xa = !0))
            : e &&
              fb &&
              (w.hasClass("menu-open") ||
                ((fb = !1),
                db.removeClass("show-phantom").addClass("hide-phantom"),
                (Xa = !1)));
        });
      }
    }
    var ib;
    k(function() {
      clearTimeout(ib),
        (ib = setTimeout(function() {
          var a = document.getElementById("load");
          null !== a && (a.className += " loader-removed");
        }, 150));
    });
    var jb,
      kb = a(
        ".main-nav li.has-children > a:not(.not-clickable-item), .level-arrows-on > li.has-children > a, .mobile-main-nav li.has-children > a"
      );
    a("<i class='next-level-button'></i>").insertAfter(kb),
      a(
        ".sub-downwards .main-nav li.has-children, .mobile-main-nav li.has-children"
      ).each(function() {
        var b = a(this),
          c = b.find(" > .sub-nav, .sub-menu");
        b.find(".sub-nav li, .sub-menu li").hasClass("act") &&
          b.addClass("active"),
          b.find(".sub-nav li.act, .sub-menu li.act").hasClass("act") &&
            (b.addClass("open-sub"),
            c.stop(!0, !0).slideDown(100),
            c.layzrInitialisation()),
          b.find(" > .next-level-button").on("click", function(b) {
            var d = a(this).parent();
            d.hasClass("active")
              ? (c.stop(!0, !0).slideUp(500, function() {
                  a(" .main-nav").layzrInitialisation();
                }),
                d.removeClass("active"),
                d.removeClass("open-sub"),
                d.find("a").removeClass("act"))
              : (d
                  .siblings()
                  .find(" .sub-nav, .dt-mega-menu-wrap, .sub-menu")
                  .stop(!0, !0)
                  .slideUp(400),
                c.stop(!0, !0).slideDown(500),
                d.siblings().removeClass("active"),
                d.addClass("active"),
                d.siblings().removeClass("open-sub"),
                d.addClass("open-sub"),
                d
                  .siblings()
                  .find("> a")
                  .removeClass("act"),
                d.find("a").addClass("act"),
                a(" .main-nav").layzrInitialisation());
          });
      }),
      !a(".dt-parent-menu-clickable").length > 0 &&
        a(
          ".sub-downwards .main-nav li > a, .mobile-main-nav li.has-children > a"
        ).each(function() {
          var b = a(this);
          b
            .parent("li")
            .find(".sub-nav li, .sub-menu li")
            .hasClass("act") && b.addClass("act"),
            b
              .parent("li")
              .find(".sub-nav li.act, .sub-menu li.act")
              .hasClass("act") &&
              (b.parent("li").addClass("open-sub"),
              b
                .siblings(".sub-nav, .sub-menu")
                .stop(!0, !0)
                .slideDown(100, function() {
                  b.siblings(".sub-nav, .sub-menu").layzrInitialisation();
                })),
            b.on("click", function(c) {
              ($menuItem = b.parent()),
                $menuItem.hasClass("has-children menu-item-language") &&
                  c.preventDefault(),
                b.hasClass("act")
                  ? (b
                      .siblings(".sub-nav, .sub-menu")
                      .stop(!0, !0)
                      .slideUp(500),
                    b.removeClass("act"),
                    b.parent("li").removeClass("open-sub"))
                  : (b
                      .parent()
                      .siblings()
                      .find(".sub-nav, .dt-mega-menu-wrap, .sub-menu")
                      .stop(!0, !0)
                      .slideUp(400),
                    b
                      .siblings(".sub-nav, .sub-menu")
                      .stop(!0, !0)
                      .slideDown(500),
                    b
                      .parent()
                      .siblings()
                      .find("> a")
                      .removeClass("act"),
                    b.addClass("act"),
                    b
                      .parent("li")
                      .siblings()
                      .removeClass("open-sub active"),
                    b.parent("li").addClass("open-sub active")),
                a(".header-bar").mCustomScrollbar("update");
            });
        }),
      a(".custom-nav > li > a").click(function(b) {
        var c = a(this).parent(),
          d = a(this);
        c.hasClass("has-children") && b.preventDefault(),
          d.hasClass("active")
            ? (d
                .next()
                .stop(!0)
                .slideUp(500),
              d.removeClass("active"))
            : (a(".custom-nav > li > ul")
                .stop(!0)
                .slideUp(400),
              d
                .next()
                .stop(!0)
                .slideDown(500),
              a(".custom-nav > li > a").removeClass("active"),
              d.addClass("active")),
          c.siblings().removeClass("act"),
          c.addClass("act");
      }),
      a(".custom-nav > li > ul").each(function() {
        clearTimeout(jb),
          ($this = a(this)),
          ($thisChildren = $this.find("li")),
          $thisChildren.hasClass("act") &&
            ($this.prev().addClass("active"),
            $this
              .parent()
              .siblings()
              .removeClass("act"),
            $this.parent().addClass("act"),
            $this.slideDown(500));
      }),
      a(".filter-categories").each(function() {
        var b = a(this);
        b.find("> a").on("click", function(b) {
          var c = a(this);
          if ("undefined" == typeof arguments.callee.dtPreventD) {
            var d = c.parents(".filter").first();
            d.hasClass("without-isotope")
              ? (arguments.callee.dtPreventD = !!d.hasClass("with-ajax"))
              : (arguments.callee.dtPreventD = !0);
          }
          b.preventDefault(),
            c.trigger("mouseleave"),
            c.hasClass("act") && !c.hasClass("show-all")
              ? (b.stopImmediatePropagation(),
                c.removeClass("act"),
                c.siblings("a.show-all").trigger("click"))
              : (c.siblings().removeClass("act"),
                c.addClass("act"),
                arguments.callee.dtPreventD ||
                  (window.location.href = c.attr("href")));
        });
      }),
      a(".filter-extras .filter-switch").each(function() {
        var b = a(this);
        b.prev(".act").length > 0
          ? b.addClass("left-act")
          : b.next(".act").length > 0
          ? b.addClass("right-act")
          : (b.removeClass("right-act"), b.removeClass("left-act"));
      }),
      a(".filter-extras").each(function() {
        a(this)
          .find("a")
          .on("click", function(b) {
            var c = a(this);
            if ("undefined" == typeof arguments.callee.dtPreventD) {
              var d = c.parents(".filter").first();
              d.hasClass("without-isotope")
                ? (arguments.callee.dtPreventD = !!d.hasClass("with-ajax"))
                : (arguments.callee.dtPreventD = !0);
            }
            arguments.callee.dtPreventD && b.preventDefault(),
              c.siblings().removeClass("act"),
              c.addClass("act"),
              a(".filter-extras .filter-switch").each(function() {
                var b = a(this);
                b.prev(c).hasClass("act")
                  ? (b.addClass("left-act"), b.removeClass("right-act"))
                  : b.next(c).hasClass("act")
                  ? (b.addClass("right-act"), b.removeClass("left-act"))
                  : (b.removeClass("right-act"), b.removeClass("left-act"));
              });
          });
      }),
      a(".filter-extras .filter-switch").each(function() {
        var b = a(this),
          c = b.parents(".filter").first();
        b.on("click", function() {
          c.hasClass("without-isotope")
            ? b.hasClass("right-act")
              ? b.prev("a")[0].click()
              : b.hasClass("left-act") && b.next("a")[0].click()
            : b.hasClass("right-act")
            ? b.prev("a").trigger("click")
            : b.hasClass("left-act") && b.next("a").trigger("click");
        });
      }),
      a(
        ".mode-list .filter-categories > a:not(.show-all), .dt-css-grid-wrap .filter-categories > a:not(.show-all)"
      ).each(function() {
        ($this = a(this)),
          ($dataFiltr = $this.attr("data-filter")),
          ($newDataFilter = $dataFiltr.substring(1, $dataFiltr.length)),
          $this.attr("data-filter", $newDataFilter),
          $this.parents().removeClass("iso-filter");
      }),
      (a.fn.shortcodesFilter = function() {
        function b() {
          if (c.hasClass("dt-css-grid")) {
            if (c.parent().hasClass("lazy-loading-mode")) {
              var a = c
                .parent()
                .find(".button-load-more")
                .offset();
              a &&
                v.scrollTop() > (a.top - v.height()) / 2 &&
                c
                  .parent()
                  .find(".button-load-more")
                  .trigger("click");
            }
          } else if (c.hasClass("lazy-loading-mode")) {
            var a = c.find(".button-load-more").offset();
            a &&
              v.scrollTop() > (a.top - v.height()) / 2 &&
              c.find(".button-load-more").trigger("click");
          }
        }
        var c = a(this);
        if (c.hasClass("dt-css-grid"))
          var d = c.parent().find(".filter-categories"),
            e = c.parent().find(".paginator"),
            f = c.parent().find(".filter-by"),
            g = c.parent().find(".filter-sorting"),
            h = c
              .parent()
              .find(".filter-by .act")
              .attr("data-by"),
            i = c
              .parent()
              .find(".filter-sorting .act")
              .attr("data-sort"),
            j = c.parent().attr("data-pagination-mode"),
            k = c.parent().attr("data-post-limit");
        else
          var d = c.find(".filter-categories"),
            e = c.find(".paginator"),
            f = c.find(".filter-by"),
            g = c.find(".filter-sorting"),
            h = c.find(".filter-by .act").attr("data-by"),
            i = c.find(".filter-sorting .act").attr("data-sort"),
            j = c.attr("data-pagination-mode"),
            k = c.attr("data-post-limit");
        c.Filterade({
          pageLimit: k,
          paginationMode: j,
          useFilters: !0,
          useSorting: !0,
          filterControls: d,
          sortControls: f,
          orderControls: g,
          pageControls: e,
          controlsSelecter: "a",
          controlsSelecterChecked: "a.act",
          defaultFilter: "*",
          selectAll: "*",
          defaultSort: h,
          defaultOrder: i,
          loadMoreButtonLabel: dtLocal.moreButtonText.loadMore
        }),
          c.on("updateReady", function() {
            p(),
              c
                .parent(
                  ".content-rollover-layout-list:not(.disable-layout-hover)"
                )
                .find(".post-entry-wrapper")
                .clickOverlayGradient();
          }),
          v.on("scroll", function() {
            b();
          }),
          b();
      }),
      a(
        ".blog-shortcode.mode-list.jquery-filter, .jquery-filter .dt-css-grid"
      ).each(function() {
        var b = a(this);
        b.shortcodesFilter();
      }),
      (a.HoverDir = function(b, c) {
        (this.$el = a(c)), this._init(b);
      }),
      (a.HoverDir.defaults = {
        speed: 300,
        easing: "ease",
        hoverDelay: 0,
        inverse: !1
      }),
      (a.HoverDir.prototype = {
        _init: function(b) {
          (this.options = a.extend(!0, {}, a.HoverDir.defaults, b)),
            (this.transitionProp =
              "all " + this.options.speed + "ms " + this.options.easing),
            (this.support = Modernizr.csstransitions),
            this._loadEvents();
        },
        _loadEvents: function() {
          var b = this;
          this.$el.on("mouseenter.hoverdir, mouseleave.hoverdir", function(c) {
            var d = a(this),
              e = d.find(
                ".rollover-content, .gallery-rollover, .post-entry-content"
              ),
              f = b._getDir(d, { x: c.pageX, y: c.pageY }),
              g = b._getStyle(f);
            "mouseenter" === c.type
              ? (e.hide().css(g.from),
                clearTimeout(b.tmhover),
                (b.tmhover = setTimeout(function() {
                  e.show(0, function() {
                    var c = a(this);
                    b.support && c.css("transition", b.transitionProp),
                      b._applyAnimation(c, g.to, b.options.speed);
                  });
                }, b.options.hoverDelay)))
              : (b.support && e.css("transition", b.transitionProp),
                clearTimeout(b.tmhover),
                b._applyAnimation(e, g.from, b.options.speed));
          });
        },
        _getDir: function(a, b) {
          var c = a.width(),
            d = a.height(),
            e = (b.x - a.offset().left - c / 2) * (c > d ? d / c : 1),
            f = (b.y - a.offset().top - d / 2) * (d > c ? c / d : 1),
            g =
              Math.round((Math.atan2(f, e) * (180 / Math.PI) + 180) / 90 + 3) %
              4;
          return g;
        },
        _getStyle: function(a) {
          var b,
            c,
            d = { left: "0px", top: "-100%" },
            e = { left: "0px", top: "100%" },
            f = { left: "-100%", top: "0px" },
            g = { left: "100%", top: "0px" },
            h = { top: "0px" },
            i = { left: "0px" };
          switch (a) {
            case 0:
              (b = this.options.inverse ? e : d), (c = h);
              break;
            case 1:
              (b = this.options.inverse ? f : g), (c = i);
              break;
            case 2:
              (b = this.options.inverse ? d : e), (c = h);
              break;
            case 3:
              (b = this.options.inverse ? g : f), (c = i);
          }
          return { from: b, to: c };
        },
        _applyAnimation: function(b, c, d) {
          (a.fn.applyStyle = this.support ? a.fn.css : a.fn.animate),
            b.stop().applyStyle(c, a.extend(!0, [], { duration: d + "ms" }));
        }
      });
    var lb = function(a) {
      window.console && window.console.error(a);
    };
    (a.fn.hoverdir = function(b) {
      var c = a.data(this, "hoverdir");
      if ("string" == typeof b) {
        var d = Array.prototype.slice.call(arguments, 1);
        this.each(function() {
          return c
            ? a.isFunction(c[b]) && "_" !== b.charAt(0)
              ? void c[b].apply(c, d)
              : void lb("no such method '" + b + "' for hoverdir instance")
            : void lb(
                "cannot call methods on hoverdir prior to initialization; attempted to call method '" +
                  b +
                  "'"
              );
        });
      } else
        this.each(function() {
          c
            ? c._init()
            : (c = a.data(this, "hoverdir", new a.HoverDir(b, this)));
        });
      return c;
    }),
      a(".mobile-false .hover-grid.gallery-shortcode figure").each(function() {
        a(this).hoverdir();
      }),
      a(".mobile-false .hover-grid-reverse.gallery-shortcode figure ").each(
        function() {
          a(this).hoverdir({ inverse: !0 });
        }
      ),
      (a.fn.addRollover = function() {
        return this.each(function() {
          var b = a(this);
          b.hasClass("this-ready") ||
            (b.append("<i></i>"),
            b.find(".rollover-thumbnails").length &&
              b.addClass("rollover-thumbnails-on"),
            b.parent().find(".links-container").length &&
              b.addClass("rollover-buttons-on"),
            b.addClass("this-ready"));
        });
      }),
      a(
        ".rollover, .rollover-video, .post-rollover, .rollover-project .show-content, .vc-item .vc-inner > a"
      ).addRollover(),
      a(".filter-grayscale .slider-masonry").on("mouseenter tap", function(b) {
        "tap" == b.type && b.stopPropagation(), a(this).addClass("dt-hovered");
      }),
      a(".filter-grayscale .slider-masonry").on("mouseleave", function(b) {
        a(this).removeClass("dt-hovered");
      }),
      (a.fn.scaleInHover = function() {
        return this.each(function() {
          var b = a(this);
          if (!b.hasClass("scale-ready")) {
            var c = b.find("img.preload-me"),
              d = parseInt(c.attr("width")),
              e = parseInt(c.attr("height")),
              f = d / e;
            f < 2 && f >= 1.5
              ? b.addClass("ratio_3-2")
              : f < 1.5 && f >= 1
              ? b.addClass("ratio_4-3")
              : f < 1 && f >= 0.75
              ? b.addClass("ratio_3-4")
              : f < 0.75 && f >= 0.6
              ? b.addClass("ratio_2-3")
              : b
                  .removeClass("ratio_2-3")
                  .removeClass("ratio_3-2")
                  .removeClass("ratio-2")
                  .removeClass("ratio_4-3")
                  .removeClass("ratio_3-4"),
              f >= 2 && b.addClass("ratio-2"),
              0.5 == f && b.addClass("ratio_0-5"),
              1 == f &&
                b
                  .removeClass("ratio_2-3")
                  .removeClass("ratio-2")
                  .removeClass("ratio_3-2")
                  .removeClass("ratio_4-3")
                  .removeClass("ratio_3-4"),
              b.addClass("scale-ready");
          }
        });
      }),
      a(".hover-scale .rollover-project, .hover-scale .post").scaleInHover(),
      a(
        ".mobile-false .albums .rollover-content a:not(.portfolio-categories a), .mobile-false .media .rollover-content, .mobile-false .dt-gallery-container .rollover-content"
      ).on("click", function(b) {
        return (
          !!a(b.target).is("a") ||
          void a(this)
            .siblings("a.dt-pswp-item")
            .first()
            .click()
        );
      }),
      (a.fn.touchNewHover = function() {
        return this.each(function() {
          var b = a(this);
          b.hasClass("this-ready") ||
            ((a(".rollover-content", this).length > 0 ||
              a(".woocom-rollover-content", this).length > 0) &&
              (x.on("touchend", function(b) {
                a(
                  ".mobile-true .rollover-content, .mobile-true .rollover-project, .mobile-true .woocom-rollover-content, .mobile-true .woocom-project"
                ).removeClass("is-clicked");
              }),
              b.on("touchstart", function(a) {
                (origY = a.originalEvent.touches[0].pageY),
                  (origX = a.originalEvent.touches[0].pageX);
              }),
              b.on("touchend", function(c) {
                var d = c.originalEvent.changedTouches[0].pageX,
                  e = c.originalEvent.changedTouches[0].pageY;
                if (origY == e || origX == d) {
                  if (!b.hasClass("is-clicked"))
                    return (
                      a(".links-container > a", b).on("touchend", function(a) {
                        a.stopPropagation(), b.addClass("is-clicked");
                      }),
                      c.preventDefault(),
                      a(
                        ".mobile-true .rollover-content, .mobile-true .rollover-project, .mobile-true .woocom-rollover-content, .mobile-true .woocom-project"
                      ).removeClass("is-clicked"),
                      b.addClass("is-clicked"),
                      b.find(".rollover-content").addClass("is-clicked"),
                      b.find(".woocom-rollover-content").addClass("is-clicked"),
                      !1
                    );
                  if (
                    (b.find(".dt-gallery-container").length > 0 &&
                      b
                        .find(".rollover-content")
                        .on("click.dtAlbums", function(c) {
                          b.find(".rollover-content").off("click.dtAlbums"),
                            a(this)
                              .find(
                                "a.dt-gallery-pspw, .dt-trigger-first-pspw, .dt-pswp-item"
                              )
                              .first()
                              .trigger("click");
                        }),
                    a(this).find(".rollover-click-target.go-to").length > 0)
                  )
                    window.location.href = a(this)
                      .find(".rollover-click-target.go-to")
                      .attr("href");
                  else if (a(this).hasClass("woocom-project")) {
                    if (a(c.target).is(".add_to_cart_button")) return !0;
                    window.location.href = a(this)
                      .find(" > a")
                      .attr("href");
                  }
                }
              })),
            b.addClass("this-ready"));
        });
      }),
      a(
        ".mobile-true .rollover-project, .mobile-true .woocom-project"
      ).touchNewHover(),
      (a.fn.touchWooHoverImage = function() {
        return this.each(function() {
          var b = a(this);
          if (!b.hasClass("woo-ready")) {
            x.on("touchend", function(b) {
              a(
                ".mobile-true .cart-btn-on-hover .woo-buttons-on-img"
              ).removeClass("is-clicked");
            });
            var c = a(this);
            c.on("touchstart", function(a) {
              (origY = a.originalEvent.touches[0].pageY),
                (origX = a.originalEvent.touches[0].pageX);
            }),
              c.on("touchend", function(b) {
                var d = b.originalEvent.changedTouches[0].pageX,
                  e = b.originalEvent.changedTouches[0].pageY;
                if (origY == e || origX == d)
                  if (c.hasClass("is-clicked"))
                    a(b.target)
                      .parent()
                      .hasClass("woo-buttons") ||
                      (a(b.target)
                        .parent()
                        .hasClass("woo-buttons-on-img")
                        ? a(b.target).trigger("click")
                        : (window.location.href = c
                            .find("a")
                            .first()
                            .attr("href")));
                  else if (
                    !a(b.target)
                      .parent()
                      .hasClass("woo-buttons")
                  )
                    return (
                      b.preventDefault(),
                      a(
                        ".mobile-true .cart-btn-on-hover .woo-buttons-on-img"
                      ).removeClass("is-clicked"),
                      c.addClass("is-clicked"),
                      !1
                    );
              }),
              b.addClass("woo-ready");
          }
        });
      }),
      a(
        ".mobile-true .cart-btn-on-hover .woo-buttons-on-img"
      ).touchWooHoverImage(),
      (a.fn.touchWooHoverBtn = function() {
        return this.each(function() {
          x.on("touchend", function(b) {
            a(".mobile-true .cart-btn-on-img .woo-buttons").removeClass(
              "is-clicked"
            );
          });
          var b = a(this);
          b.hasClass("woo-ready") ||
            (b.on("touchstart", function(a) {
              (origY = a.originalEvent.touches[0].pageY),
                (origX = a.originalEvent.touches[0].pageX);
            }),
            b.on("touchend", function(c) {
              var d = c.originalEvent.changedTouches[0].pageX,
                e = c.originalEvent.changedTouches[0].pageY;
              if (origY == e || origX == d) {
                if (
                  !(
                    b.hasClass("is-clicked") ||
                    b.find("a.added_to_cart").length > 0
                  )
                )
                  return (
                    c.preventDefault(),
                    a(".mobile-true .cart-btn-on-img .woo-buttons").removeClass(
                      "is-clicked"
                    ),
                    b.addClass("is-clicked"),
                    !1
                  );
                a(c.target)
                  .parent()
                  .hasClass("woo-buttons")
                  ? a(c.target).trigger("click")
                  : (window.location.href = b
                      .find("a")
                      .first()
                      .attr("href"));
              }
            }),
            b.addClass("woo-ready"));
        });
      }),
      a(".mobile-true .cart-btn-on-img .woo-buttons").touchWooHoverBtn(),
      (a.fn.triggerPostClick = function() {
        return this.each(function() {
          var b = a(this);
          if (!b.hasClass("post-ready")) {
            var c = b.find(".post-thumbnail-rollover").first(),
              d = b.find(".entry-meta a, .fancy-date a, .fancy-categories a");
            if (c.length > 0) {
              c.on("click", function(a) {
                a.preventDefault(),
                  a.stopPropagation(),
                  c.parents(".ts-wrap").hasClass("ts-interceptClicks");
              });
              var e = !1;
              b.on("click", function() {
                if (!b.parents(".ts-wrap").hasClass("ts-interceptClicks"))
                  return (
                    e ||
                      ((e = !0),
                      (window.location.href = c.attr("href")),
                      (e = !1)),
                    !1
                  );
              }),
                b.find(d).click(function(a) {
                  a.stopPropagation(), (window.location.href = d.attr("href"));
                });
            }
            b.addClass("post-ready");
          }
        });
      }),
      a(
        ".mobile-false .content-rollover-layout-list:not(.portfolio-shortcode):not(.albums-shortcode) .post, .mobile-false .gradient-overlay-layout-list:not(.portfolio-shortcode):not(.albums-shortcode) .post"
      ).triggerPostClick(),
      (a.fn.touchTriggerPostClick = function() {
        return this.each(function() {
          var b = a(this);
          if (!b.hasClass("touch-post-ready")) {
            var c = b.find(".post-thumbnail-rollover").first();
            b.find(".entry-meta a, .fancy-date a, .fancy-categories a"),
              b.find(".entry-excerpt").height() +
                b.find(".post-details").height();
            x.on("touchend", function(b) {
              a(".mobile-true .post").removeClass("is-clicked");
            }),
              b.on("touchstart", function(a) {
                (origY = a.originalEvent.touches[0].pageY),
                  (origX = a.originalEvent.touches[0].pageX);
              }),
              b.on("touchend", function(d) {
                var e = d.originalEvent.changedTouches[0].pageX,
                  f = d.originalEvent.changedTouches[0].pageY;
                if (origY == f || origX == e)
                  if (b.parents().hasClass("disable-layout-hover"))
                    "a" === d.target.tagName.toLowerCase()
                      ? a(d.target).trigger("click")
                      : (window.location.href = c.attr("href"));
                  else {
                    if (!b.hasClass("is-clicked"))
                      return (
                        d.preventDefault(),
                        "a" === d.target.tagName.toLowerCase() &&
                          a(d.target).trigger("click"),
                        a(".mobile-ture .post").removeClass("is-clicked"),
                        b.addClass("is-clicked"),
                        b
                          .parent()
                          .siblings()
                          .find(".post")
                          .removeClass("is-clicked"),
                        !1
                      );
                    window.location.href = c.attr("href");
                  }
              }),
              b.addClass("touch-post-ready");
          }
        });
      }),
      a(
        ".mobile-true .content-rollover-layout-list:not(.portfolio-shortcode):not(.albums-shortcode)  .post, .mobile-true .gradient-overlay-layout-list:not(.portfolio-shortcode):not(.albums-shortcode)  .post"
      ).touchTriggerPostClick(),
      (a.fn.triggerPostClickOnBefore = function() {
        return this.each(function() {
          var b = a(this),
            c = b.parents(".post");
          if (!b.hasClass("post-before-ready")) {
            var d = c.find(".post-thumbnail-rollover").first(),
              e = c.find(".entry-meta a, .fancy-date a, .fancy-categories a");
            if (d.length > 0) {
              d.on("click", function(a) {
                d.parents(".ts-wrap").hasClass("ts-interceptClicks");
              });
              var f = !1;
              b.on("mouseenter mousemove", function(a) {
                var d = b.offset().top,
                  e = a.pageY;
                d - 10 <= e && d + 125 >= e
                  ? c.hasClass("on-hover") || c.addClass("on-hover")
                  : c.removeClass("on-hover");
              }),
                b.on("mouseleave", function(a) {
                  b.offset().top, a.pageY;
                  c.removeClass("on-hover");
                }),
                b.on("click", function() {
                  if (c.hasClass("on-hover"))
                    return (
                      f ||
                        ((f = !0),
                        (window.location.href = d.attr("href")),
                        (f = !1)),
                      !1
                    );
                }),
                b.find(e).click(function(a) {
                  c.hasClass("on-hover") &&
                    (a.stopPropagation(),
                    (window.location.href = e.attr("href")));
                });
            }
            b.addClass("post-before-ready");
          }
        });
      }),
      a(
        ".mobile-false .gradient-overlap-layout-list:not(.portfolio-shortcode):not(.albums-shortcode)  .post-entry-content"
      ).triggerPostClickOnBefore();
    var mb = a("#commentform");
    mb.on("click", "a.clear-form", function(a) {
      return (
        a.preventDefault(), mb.find('input[type="text"], textarea').val(""), !1
      );
    }),
      mb.on("click", " a.dt-btn.dt-btn-m", function(a) {
        return a.preventDefault(), mb.find("#submit").trigger("click"), !1;
      }),
      a(".full-width-wrap").length > 0 &&
        (dtGlobals.isiOS
          ? v
              .bind("orientationchange", function() {
                e();
              })
              .trigger("orientationchange")
          : (v.on("resize", function() {
              e();
            }),
            e())),
      v.trigger("dt.removeLoading");
    var nb = a("#main-slideshow");
    !nb.find("> div").length > 0 && nb.addClass("empty-slider"),
      a(".rev_slider_wrapper").length > 0 &&
        (nb.find("> .rev_slider_wrapper") && nb.addClass("fix rv-slider"),
        (a(".rev_slider_wrapper").hasClass("fullscreen-container") ||
          a(".rev_slider_wrapper").hasClass("fullwidthbanner-container")) &&
          nb.removeClass("fix")),
      a(".woocommerce-billing-fields")
        .find("input[autofocus='autofocus']")
        .blur(),
      a(".woocom-project").each(function() {
        var b = a(this);
        b.find("img.show-on-hover").length > 0 &&
          b
            .find("img")
            .first()
            .addClass("hide-on-hover");
      });
    var ob, pb;
    a(document.body).on(
      "wc_fragments_loaded wc_fragments_refreshed",
      function() {
        h(), a(".mobile-true .shopping-cart.show-sub-cart").touchDropdownCart();
      }
    ),
      (a.fn.touchDropdownCart = function() {
        return this.each(function() {
          var b = a(this);
          if (!b.hasClass("item-ready")) {
            x.on("touchend", function(b) {
              a(
                ".mobile-true .shopping-cart.show-sub-cart .wc-ico-cart"
              ).removeClass("is-clicked"),
                g(c, e);
            });
            var c = a(this).find(".wc-ico-cart"),
              d = c.attr("target") ? c.attr("target") : "_self",
              e = b.children(".shopping-cart-wrap");
            g(c, e),
              c.on("touchstart", function(a) {
                (origY = a.originalEvent.touches[0].pageY),
                  (origX = a.originalEvent.touches[0].pageX);
              }),
              c.on("touchend", function(b) {
                var h = b.originalEvent.changedTouches[0].pageX,
                  i = b.originalEvent.changedTouches[0].pageY;
                if (origY == i || origX == h) {
                  if (!c.hasClass("is-clicked"))
                    return (
                      b.preventDefault(),
                      f(c, e),
                      a(
                        ".mobile-true .shopping-cart.show-sub-cart .wc-ico-cart"
                      ).removeClass("is-clicked"),
                      c.addClass("is-clicked"),
                      !1
                    );
                  g(c, e), window.open(c.attr("href"), d);
                }
              });
          }
        });
      }),
      a(document.body).on("edd_cart_item_removed edd_cart_item_added", function(
        b,
        c
      ) {
        var d = { action: "the7_edd_cart_micro_widget" };
        xhr = a.ajax({
          type: "POST",
          url: dtLocal.ajaxurl,
          data: d,
          success: function(b) {
            a(".edd-shopping-cart").replaceWith(a(b)),
              h(),
              a(
                ".mobile-true .shopping-cart.show-sub-cart"
              ).touchDropdownCart(),
              n("5000");
          }
        });
      });
    a(".quantity");
    a(".quantity").on("click", ".plus", function(b) {
      var c = a(this).prev("input.qty"),
        d = (parseInt(c.val()), parseFloat(c.attr("max"))),
        e = (parseFloat(c.attr("min")), parseInt(c.attr("step"), 10)),
        f = parseInt(c.val(), 10) + e;
      (f = f > d ? d : f), c.val(f).change();
    }),
      a(".quantity").on("click", ".minus", function(b) {
        var c = a(this).next("input.qty"),
          d =
            (parseInt(c.val()),
            parseFloat(c.attr("max")),
            parseFloat(c.attr("min"))),
          e = parseInt(c.attr("step"), 10),
          f = parseInt(c.val(), 10) - e;
        (f = f < 0 ? 0 : f), (f = f < d ? d : f), c.val(f).change();
      }),
      a(document).ajaxComplete(function() {
        a(".quantity")
          .off("click", ".plus")
          .on("click", ".plus", function(b) {
            var c = a(this).prev("input.qty"),
              d = (parseInt(c.val()), parseFloat(c.attr("max"))),
              e = (parseFloat(c.attr("min")), parseInt(c.attr("step"), 10)),
              f = parseInt(c.val(), 10) + e;
            (f = f > d ? d : f), c.val(f).change();
          }),
          a(".quantity")
            .off("click", ".minus")
            .on("click", ".minus", function(b) {
              var c = a(this).next("input.qty"),
                d =
                  (parseInt(c.val()),
                  parseFloat(c.attr("max")),
                  parseFloat(c.attr("min"))),
                e = parseInt(c.attr("step"), 10),
                f = parseInt(c.val(), 10) - e;
              (f = f < 0 ? 0 : f), (f = f < d ? d : f), c.val(f).change();
            });
      }),
      a(document).on("yith-wcan-ajax-filtered", function(b) {
        a(".layzr-loading-on, .vc_single_image-img").layzrInitialisation(),
          a(".yit-wcan-container")
            .find(".dt-css-grid")
            .IsoLayzrInitialisation(),
          (b = 0);
        var c = a(".yit-wcan-container").find(".wf-container"),
          d = parseInt(c.attr("data-width")),
          e = parseInt(c.attr("data-columns")),
          f = parseInt(c.attr("data-desktop-columns-num")),
          g = parseInt(c.attr("data-h-tablet-columns-num")),
          h = parseInt(c.attr("data-v-tablet-columns-num")),
          i = parseInt(c.attr("data-phone-columns-num")),
          j = parseInt(c.attr("data-padding"));
        c.IsoLayzrInitialisation(),
          c.addClass("cont-id-" + b).attr("data-cont-id", b),
          jQuery(window).off("columnsReady"),
          c
            .off("columnsReady.fixWooIsotope")
            .one("columnsReady.fixWooIsotope.IsoInit", function() {
              c
                .addClass("dt-isotope")
                .IsoInitialisation(".iso-item", "masonry", 400),
                c.isotope("on", "layoutComplete", function() {
                  c.trigger("IsoReady");
                });
            }),
          c.on("columnsReady.fixWooIsotope.IsoLayout", function() {
            c.isotope("layout");
          }),
          c.one("columnsReady.fixWooIsotope", function() {
            jQuery(".preload-me", c).heightHack();
          }),
          c.one("IsoReady", function() {
            c.IsoLayzrInitialisation();
          }),
          jQuery(window)
            .off("debouncedresize.fixWooIsotope")
            .on("debouncedresize.fixWooIsotope", function() {
              c.calculateColumns(d, e, j, f, g, h, i, "px");
            })
            .trigger("debouncedresize.fixWooIsotope");
      }),
      a(document).on("ixProductFilterRequestProcessed", function(b) {
        p(),
          a(".layzr-loading-on, .vc_single_image-img").layzrInitialisation(),
          (i = 0);
        var c = a(".dt-products.wf-container"),
          d = parseInt(c.attr("data-width")),
          e = parseInt(c.attr("data-columns")),
          f = parseInt(c.attr("data-desktop-columns-num")),
          g = parseInt(c.attr("data-h-tablet-columns-num")),
          h = parseInt(c.attr("data-v-tablet-columns-num")),
          j = parseInt(c.attr("data-phone-columns-num")),
          k = parseInt(c.attr("data-padding"));
        c.IsoLayzrInitialisation(),
          c.addClass("cont-id-" + i).attr("data-cont-id", i),
          jQuery(window).off("columnsReady"),
          c
            .off("columnsReady.fixWooFilter")
            .one("columnsReady.fixWooFilter.IsoInit", function() {
              c
                .addClass("dt-isotope")
                .IsoInitialisation(".iso-item", "masonry", 400),
                c.isotope("on", "layoutComplete", function() {
                  c.trigger("IsoReady");
                });
            }),
          c.on("columnsReady.fixWooFilter.IsoLayout", function() {
            c.isotope("layout");
          }),
          c.one("columnsReady.fixWooFilter", function() {
            jQuery(".preload-me", c).heightHack();
          }),
          c.one("IsoReady", function() {
            c.IsoLayzrInitialisation();
          }),
          jQuery(window)
            .off("debouncedresize.fixWooFilter")
            .on("debouncedresize.fixWooFilter", function() {
              c.calculateColumns(d, e, k, f, g, h, j, "px"),
                c.isotope("layout");
            })
            .trigger("debouncedresize.fixWooFilter");
      });
    var qb = a(".masthead, .dt-mobile-header"),
      rb = a(".popup-search", qb);
    if (
      (rb.length > 0 &&
        (x.on("click", function(b) {
          var c = a(b.target);
          c.is(".field", rb) ||
            (a(".searchform .submit", qb).removeClass("act"),
            rb.removeClass("act"),
            a(".popup-search-wrap", rb)
              .stop()
              .animate({ opacity: 0 }, 150, function() {
                a(this).css("visibility", "hidden");
              }),
            setTimeout(function() {
              a(".popup-search-wrap", rb)
                .removeClass("right-overflow bottom-overflow left-overflow")
                .css({ right: "", left: "", "max-width": "" });
            }, 400));
        }),
        a(".searchform .submit", qb).on("click", function(b) {
          b.preventDefault(), b.stopPropagation();
          var c = a(this);
          c.hasClass("act")
            ? (c.removeClass("act"),
              c.parents(".mini-search").removeClass("act"),
              c
                .siblings(".popup-search-wrap")
                .stop()
                .animate({ opacity: 0 }, 150, function() {
                  a(this).css("visibility", "hidden");
                }),
              setTimeout(function() {
                c.siblings(".popup-search-wrap")
                  .removeClass("right-overflow bottom-overflow left-overflow")
                  .css({ right: "", left: "", "max-width": "" });
              }, 400))
            : (c.addClass("act"),
              c.parents(".mini-search").addClass("act"),
              c.parents(".dt-mobile-header").length > 0 &&
                c
                  .siblings(".popup-search-wrap")
                  .css({
                    top:
                      c.parents(".mini-search").position().top -
                      c.siblings(".popup-search-wrap").innerHeight()
                  }),
              c.parents(".searchform").offset().left -
                c.siblings(".popup-search-wrap").innerWidth() <
                0 && c.siblings(".popup-search-wrap").addClass("left-overflow"),
              y.width() -
                (c.parents(".searchform").offset().left - y.offset().left) -
                c.siblings(".popup-search-wrap").innerWidth() <
                0 &&
                (c.siblings(".popup-search-wrap").addClass("right-overflow"),
                c.siblings(".popup-search-wrap").removeClass("left-overflow")),
              y.width() -
                (c.parents(".searchform").offset().left - y.offset().left) -
                c.siblings(".popup-search-wrap").innerWidth() <
                0 &&
                c.parents(".searchform").offset().left -
                  c.siblings(".popup-search-wrap").innerWidth() <
                  0 &&
                c
                  .siblings(".popup-search-wrap")
                  .css({ "max-width": c.parents(".searchform").offset().left }),
              v.height() -
                (c.siblings(".popup-search-wrap").offset().top -
                  dtGlobals.winScrollTop) -
                c.siblings(".popup-search-wrap").innerHeight() <
                0 &&
                c.siblings(".popup-search-wrap").addClass("bottom-overflow"),
              c
                .siblings(".popup-search-wrap")
                .stop()
                .css("visibility", "visible")
                .animate({ opacity: 1 }, 150),
              c
                .siblings(".popup-search-wrap")
                .find("input.searchform-s")
                .focus());
        })),
      a(".overlay-search").length > 0)
    ) {
      var sb = a(".overlay-search .searchform").first(),
        tb = sb.clone();
      a("body").append(
        "<div class='overlay-search-microwidget'><i class='overlay-close fas fa-times'></i></div>"
      );
      var ub = a(".overlay-search-microwidget");
      ub.append(tb),
        a(".overlay-search").hasClass("default-icon") &&
          ub.addClass("default-icon"),
        a(".mini-search .submit").on("click", function(b) {
          b.preventDefault(),
            ub.addClass("open"),
            a("#page").addClass("overlay-open"),
            ub.find("input.searchform-s").focus();
        }),
        a(".overlay-close", ub).on("click", function() {
          a("#page").removeClass("overlay-open"),
            a(this)
              .parent(ub)
              .removeClass("open");
        });
    }
    if (
      (a(".twentytwenty-container .preload-me").loaded(
        null,
        function() {
          a(".twentytwenty-container").each(function() {
            var b = a(this),
              c =
                b.attr("data-orientation").length > 0
                  ? b.attr("data-orientation")
                  : "horizontal",
              d =
                "undefined" != typeof b.attr("data-offset") &&
                b.attr("data-offset").length > 0
                  ? b.attr("data-offset")
                  : 0.5,
              e = !!b.attr("data-navigation");
            b.twentytwenty({
              default_offset_pct: d,
              orientation: c,
              navigation_follow: e
            });
          });
        },
        !0
      ),
      a(".wpb_tabs .iso-container").length > 0)
    ) {
      var vb;
      a(".wpb_tour_tabs_wrapper").each(function() {
        var b = a(this),
          c = b.parents(".wpb_tabs").find(".iso-container");
        b.tabs({
          activate: function(a, b) {
            c.isotope("layout");
          }
        }),
          b.find("li").each(function() {
            a(this).on("click", function() {
              clearTimeout(vb),
                v.trigger("debouncedresize"),
                a(this)
                  .parents(".wpb_tabs")
                  .find(".iso-container")
                  .isotope("layout");
            });
          });
      });
    }
    (a.fn.calcPics = function() {
      var b = a(".instagram-photos");
      return (
        !(b.length < 1) &&
        this.each(function() {
          var b = b ? b : parseInt(a(this).attr("data-image-max-width"));
          parseInt(
            a(this)
              .find("> a")
              .css("margin-left")
          );
          a(this)
            .find(" > a")
            .css({ "max-width": b, opacity: 1 });
          var c = a(this),
            d = c.width(),
            e = 100 / Math.ceil(d / b);
          c.find("a").css({ width: e + "%" });
        })
      );
    }),
      a(".instagram-photos").calcPics(),
      a(".st-accordion").each(function() {
        var b = a(this);
        b.find("ul > li > a").on("click", function(c) {
          c.preventDefault();
          var d = a(this),
            e = d.next();
          a(".st-content", b)
            .not(e)
            .slideUp("fast"),
            e.slideToggle("fast");
        });
      }),
      simple_tooltip(".shortcode-tooltip", "shortcode-tooltip-content"),
      a(
        ".widget .searchform .submit, .search-icon, form.searchform:not(.mini-widget-searchform) .submit"
      ).on("click", function(b) {
        return (
          b.preventDefault(),
          a(this)
            .closest("form")
            .find("input.searchsubmit")
            .click(),
          !1
        );
      }),
      (a.fn.animateSkills = function() {
        a(".skill-value", this).each(function() {
          var b = a(this),
            c = b.data("width");
          b.css({ width: c + "%" });
        });
      }),
      (a.fn.animateSkills = function() {
        a(".skill-value", this).each(function() {
          var b = a(this),
            c = b.data("width");
          b.css({ width: c + "%" });
        });
      }),
      j();
    var wb, xb;
    a(".project-share-overlay.allways-visible-icons .share-button").on(
      "click",
      function(a) {
        a.preventDefault();
      }
    ),
      k(function() {
        l();
      });
    var yb,
      zb,
      Ab = a(".floating-content");
    a(".project-post");
    m();
    var Bb = a(".transparent #fancy-header").exists(),
      Cb = a(".transparent .page-title").exists();
    a(".transparent .checkout-page-title").exists();
    a.fancyFeaderCalc = function() {
      a(".branding .preload-me").loaded(
        null,
        function() {
          Bb &&
            a(".transparent #fancy-header").css({
              "padding-top": a(".masthead:not(.side-header)").height()
            }),
            Cb &&
              (a(".transparent .page-title").css({
                "padding-top": a(".masthead:not(.side-header)").height()
              }),
              a(".transparent .page-title").css("visibility", "visible"));
        },
        !0
      );
    };
    var Db = a('.paginator[role="navigation"]'),
      Eb = Db.find("a.dots");
    Eb.on("click", function() {
      Db.find("div:hidden")
        .show()
        .find("a")
        .unwrap(),
        Eb.remove();
    }),
      a(".share-buttons a.pinit-marklet").click(function(b) {
        b.preventDefault(), a("#pinmarklet").remove();
        var c = document.createElement("script");
        c.setAttribute("type", "text/javascript"),
          c.setAttribute("charset", "UTF-8"),
          c.setAttribute("id", "pinmarklet"),
          c.setAttribute("async", "async"),
          c.setAttribute("defer", "defer"),
          c.setAttribute(
            "src",
            "//assets.pinterest.com/js/pinmarklet.js?r=" +
              99999999 * Math.random()
          ),
          document.body.appendChild(c);
      }),
      v.on("debouncedresize", function() {
        (window.innerWidth >
          dtLocal.themeSettings.mobileHeader.firstSwitchPoint &&
          !x.hasClass("responsive-off")) ||
        x.hasClass("responsive-off")
          ? a(".masthead:not(.side-header):not(.mixed-header)").length > 0
            ? (dtGlobals.showTopBtn =
                a(".masthead:not(.side-header):not(.mixed-header)").height() +
                150)
            : a(".masthead.side-header-h-stroke").length > 0
            ? (dtGlobals.showTopBtn = a(".side-header-h-stroke").height() + 150)
            : (dtGlobals.showTopBtn = 500)
          : (dtGlobals.showTopBtn = 500);
      }),
      v.scroll(function() {
        dtGlobals.winScrollTop > dtGlobals.showTopBtn
          ? a(".scroll-top")
              .removeClass("off")
              .addClass("on")
          : a(".scroll-top")
              .removeClass("on")
              .addClass("off");
      }),
      a(".scroll-top").click(function(b) {
        return (
          b.preventDefault(),
          a("html, body").animate({ scrollTop: 0 }, "slow"),
          !1
        );
      }),
      a('<select aria-label="Dropdown menu"/>').prependTo(
        "#bottom-bar .mini-nav .menu-select"
      ),
      a("<option />", {
        selected: "selected",
        value: "",
        text: "———"
      }).appendTo(".mini-nav .menu-select select"),
      a("#bottom-bar .mini-nav").each(function() {
        var b = a(this),
          c = b.find("select");
        a("a", b).each(function() {
          var b = a(this);
          a("<option />", {
            value: b.attr("href"),
            text: b.text(),
            "data-level": b.attr("data-level")
          }).appendTo(c);
        });
      }),
      a(".mini-nav select").change(function() {
        window.location = a(this)
          .find("option:selected")
          .val();
      }),
      a(".mini-nav select option").each(function() {
        var b = a(this),
          c = window.location.href;
        b.attr("value") == c && b.attr("selected", "selected");
      }),
      a(" #bottom-bar .mini-nav select").each(function() {
        a(this).customSelect();
      }),
      a(
        ".menu-select select, .mini-nav .customSelect1, .vc_pie_chart .vc_pie_wrapper"
      ).css("visibility", "visible"),
      a(".mini-nav option").each(function() {
        var b = a(this),
          c = b.text(),
          d = "";
        switch (parseInt(b.attr("data-level"))) {
          case 1:
            d = "";
            break;
          case 2:
            d = "— ";
            break;
          case 3:
            d = "—— ";
            break;
          case 4:
            d = "——— ";
            break;
          case 5:
            d = "———— ";
        }
        b.text(d + c);
      });
    var Fb = navigator.userAgent,
      Gb = Fb.match(/iPhone/i) ? "touchstart" : "click";
    a(".project-navigation a, .mobile-sticky-header-overlay").bind(Gb, function(
      a
    ) {}),
      a(function() {
        (a.fn.clickMaterialEffect = function() {
          return this.each(function() {
            var b,
              c,
              d,
              e,
              f = a(this),
              g = null,
              h = null;
            0 === f.find(".ink").length &&
              f.prepend("<span class='ink'></span>"),
              f.addClass("ripplelink"),
              (b = f.find(".ink")),
              b.removeClass("animate"),
              b.height() ||
                b.width() ||
                ((c = Math.max(a(this).outerWidth(), f.outerHeight())),
                b.css({ height: c, width: c })),
              f.bind("mousedown", function(a) {
                clearTimeout(g),
                  (d = a.pageX - f.offset().left - b.width() / 2),
                  (e = a.pageY - f.offset().top - b.height() / 2),
                  b.css({ top: e + "px", left: d + "px" }).addClass("animate");
              }),
              f.bind("mouseup mouseleave", function(a) {
                clearTimeout(h),
                  clearTimeout(g),
                  (f._timer = setTimeout(function() {
                    b.removeClass("animate");
                  }, 400));
              });
          });
        }),
          a(
            ".rollover.material-click-effect, .post-rollover.material-click-effect, .rollover-video.material-click-effect"
          ).clickMaterialEffect();
      }),
      a(".filter").length > 0 &&
        (a(".filter-switch").append(
          "<span class='filter-switch-toggle'></span>"
        ),
        Modernizr.touch
          ? a(".filter-switch").on("touchstart", function(b) {
              a(".filter-switch").removeClass("pressed"),
                a(this).addClass("pressed");
            })
          : a(".filter-switch").on("mousedown", function(b) {
              a(".filter-switch").removeClass("pressed"),
                a(this).addClass("pressed"),
                setTimeout(function() {
                  a(this).removeClass("pressed");
                }, 600);
            }),
        a(".filter-switch .filter-switch-toggle").on(
          "animationend webkitAnimationEnd oanimationend MSAnimationEnd",
          function(b) {
            a(this)
              .parent()
              .removeClass("pressed");
          }
        ),
        Modernizr.touch
          ? a(".filter-extras a").on("touchstart", function(b) {
              a(".filter-extras").removeClass("pressed"),
                a(this)
                  .parent(".filter-extras")
                  .addClass("pressed");
            })
          : a(".filter-extras a").each(function() {
              a(this).on("mousedown", function(b) {
                a(".filter-extras").removeClass("pressed"),
                  a(this).addClass("pressed"),
                  setTimeout(function() {
                    a(this).removeClass("pressed");
                  }, 600);
              });
            }),
        a(".filter-extras a").on(
          "animationend webkitAnimationEnd oanimationend MSAnimationEnd",
          function(b) {
            a(this).removeClass("pressed");
          }
        ));
    var Hb = (function() {
      var a = {};
      return function(b, c, d) {
        d || (d = "Don't call this twice without a uniqueId"),
          a[d] && clearTimeout(a[d]),
          (a[d] = setTimeout(b, c));
      };
    })();
    if (!dtGlobals.isMobile) {
      a(
        ".stripe-parallax-bg, .fancy-parallax-bg, .page-title-parallax-bg"
      ).each(function() {
        var b = a(this),
          c = b.data("prlx-speed");
        b.parallax("50%", c),
          b.addClass("parallax-bg-done"),
          b.css("opacity", "1");
      });
      var Ib = -1;
      a(
        "#fancy-header .fancy-title:not(.start-animation), #fancy-header .fancy-subtitle:not(.start-animation), #fancy-header .breadcrumbs:not(.start-animation)"
      ).each(function() {
        var b = a(this);
        b.hasClass("start-animation") ||
          b.hasClass("start-animation-done") ||
          (b.addClass("start-animation-done"),
          Ib++,
          setTimeout(function() {
            b.addClass("start-animation");
          }, 300 * Ib));
      });
    }
    jQuery(".wpcf7").each(function() {
      var b = a(this);
      b.on("invalid.wpcf7", function(a) {
        setTimeout(function() {
          b.find(".wpcf7-validation-errors").wrapInner(
            "<div class='wpcf7-not-valid-tip-text'></div>"
          );
        }, 100);
      }),
        b.on("mailsent.wpcf7", function(a) {
          setTimeout(function() {
            b.find(".wpcf7-mail-sent-ok").wrapInner(
              "<div class='wpcf7-valid-tip-text'></div>"
            );
          }, 100);
        });
    }),
      a(document.body).on("wc_fragments_loaded", function() {
        var b = a(".shopping-cart");
        if (b.exists()) {
          var c = dtLocal.wcCartFragmentHash,
            d = b.first().attr("data-cart-hash");
          c && c !== d && a(document.body).trigger("wc_fragment_refresh");
        }
      });
    var Jb = !!a("span.added-to-cart").length;
    if (
      (a("body").on("adding_to_cart", function() {
        Jb = !0;
      }),
      a("body").on("wc_fragments_loaded wc_fragments_refreshed", function() {
        Jb && ((Jb = !1), n("5000"));
      }),
      a("body").on(
        "wc_fragments_loaded wc_fragments_refreshed update_checkout checkout_error init_add_payment_method",
        function() {
          a(".woocommerce-error, .woocommerce-info, .woocommerce-message").each(
            function() {
              var b = a(this);
              b.find(".close-message").on("click", function() {
                a(this)
                  .parent()
                  .addClass("hide-message");
              });
            }
          );
        }
      ),
      a("body").on("wc_cart_button_updated", function(a, b) {
        b.siblings(".added_to_cart.wc-forward")
          .wrapInner('<span class="filter-popup"></span>')
          .append(b.find("i.popup-icon"));
      }),
      a(".sticky-sidebar").length > 0)
    ) {
      if (Ma) var Kb = a(".sticky-on");
      else
        var Kb = a(
          ".masthead:not(.side-header):not(.side-header-v-stroke) .header-bar"
        );
      if (
        ((da =
          !F.exists() ||
          F.is(":hidden") ||
          F.hasClass("top-bar-empty") ||
          F.hasClass("hide-top-bar")
            ? 0
            : F.innerHeight()),
        Sa || Ta)
      )
        var Lb = a($a).height() + 20;
      else if (dtLocal.themeSettings.floatingHeader.showMenu && Da)
        if (x.hasClass("floating-top-bar"))
          var Lb = dtLocal.themeSettings.floatingHeader.height + da + 20;
        else var Lb = dtLocal.themeSettings.floatingHeader.height + 20;
      else if (J.exists()) var Lb = J.find(".header-bar").height() + da + 20;
      else var Lb = 0;
      new StickySidebar("#sidebar", {
        topSpacing: Lb,
        bottomSpacing: 20,
        viewportTop: 0,
        containerSelector: ".wf-container-main",
        innerWrapperSelector: ".sidebar-content",
        minWidth: dtLocal.themeSettings.sidebar.switchPoint
      });
    }
    a("#mphb-booking-details")
      .find(
        ".mphb-booking-details-title, .mphb-check-in-date, .mphb-check-out-date"
      )
      .wrapAll('<div class="mphb-details-sidebar"></div>'),
      a("#mphb-price-details").appendTo(".mphb-details-sidebar"),
      ((a(".page-inner").length > 0 && a(".side-header").length > 0) ||
        (a(".page-inner").length > 0 && a(".dt-mobile-header").length > 0)) &&
        a(
          ".side-header, .mixed-header, .dt-mobile-header, .dt-close-mobile-menu-icon"
        ).insertBefore(".page-inner"),
      !a(".footer .widget").length > 0 && a(".footer").addClass("empty-footer"),
      (a.fn.calculateColumns = function(b, c, d, e, f, g, h, i) {
        return this.each(function() {
          var j = a(this),
            k = j.width() - 1,
            l = d !== !1 ? d : 20,
            m = j.attr("data-cont-id"),
            n = "";
          if (j.parent().hasClass("mode-masonry"))
            var o = j.parent(),
              p = a(".cont-id-" + m).parent();
          else
            var o = j,
              p = a(".cont-id-" + m);
          for (
            "undefined" == typeof b && (b = 200),
              "undefined" == typeof c && (c = 6);
            Math.floor(k / c) < b && (c--, !(c <= 1));

          );
          if (a("#col-style-id-" + m).exists())
            var q = document.getElementById("col-style-id-" + m);
          else {
            var q = document.createElement("style");
            (q.id = "col-style-id-" + m),
              q.appendChild(document.createTextNode("")),
              document.head.appendChild(q);
          }
          var r,
            s,
            t,
            u,
            v,
            w,
            x = a("#col-style-id-" + m);
          l < 10 ? ((u = 0), (w = 0)) : ((w = l - 5), (u = l - 10)),
            (v = 0 == l ? 0 : -l),
            o.hasClass("resize-by-browser-width")
              ? Modernizr.mq("only screen and (max-width:767px)")
                ? ((r = Math.floor(k / h) + "px"),
                  (s = 2 * Math.floor(k / h) + "px"),
                  (t = h))
                : Modernizr.mq("(min-width:768px) and (max-width:991px)")
                ? ((r = Math.floor(k / g) + "px"),
                  (s = 2 * Math.floor(k / g) + "px"),
                  (t = g))
                : Modernizr.mq("(min-width:992px) and (max-width:1199px)")
                ? ((r = Math.floor(k / f) + "px"),
                  (s = 2 * Math.floor(k / f) + "px"),
                  (t = f))
                : ((r = Math.floor(k / e) + "px"),
                  (s = 2 * Math.floor(k / e) + "px"),
                  (t = e))
              : "px" == i
              ? ((r = Math.floor(k / c) + "px"),
                (s = 2 * Math.floor(k / c) + "px"),
                (t = c))
              : ((r = Math.floor(1e5 / c) / 1e3 + "%"),
                (s = (2 * Math.floor(1e5 / c)) / 1e3 + "%")),
            (n = p
              .not(".bg-under-post, .content-bg-on")
              .hasClass("description-under-image")
              ? t > 1
                ? " \t\t\t\t\t\t\t.cont-id-" +
                  m +
                  " { margin: -" +
                  w +
                  "px  -" +
                  l +
                  "px -" +
                  u +
                  "px ; } \t\t\t\t\t\t\t.full-width-wrap .cont-id-" +
                  m +
                  " { margin: " +
                  -w +
                  "px " +
                  l +
                  "px " +
                  -u +
                  "px ; } \t\t\t\t\t\t\t.cont-id-" +
                  m +
                  "  .wf-cell { width: " +
                  r +
                  "; padding: " +
                  w +
                  "px " +
                  l +
                  "px " +
                  u +
                  "px; } \t\t\t\t\t\t\t.cont-id-" +
                  m +
                  "  .wf-cell.double-width { width: " +
                  s +
                  "; } \t\t\t\t\t\t"
                : " \t\t\t\t\t\t\t.cont-id-" +
                  m +
                  " { margin: -" +
                  w +
                  "px  -" +
                  u +
                  "px -" +
                  l +
                  "px ; } \t\t\t\t\t\t\t.full-width-wrap .cont-id-" +
                  m +
                  " { margin: " +
                  -w +
                  "px " +
                  l +
                  "px " +
                  -u +
                  "px ; } \t\t\t\t\t\t\t.cont-id-" +
                  m +
                  "  .wf-cell { width: " +
                  r +
                  "; padding: " +
                  w +
                  "px " +
                  u +
                  "px " +
                  l +
                  "px; } \t\t\t\t\t\t"
              : t > 1
              ? " \t\t\t\t\t\t\t.cont-id-" +
                m +
                " { margin: -" +
                l +
                "px; } \t\t\t\t\t\t\t.full-width-wrap .cont-id-" +
                m +
                " { margin: " +
                v +
                "px  " +
                l +
                "px; } \t\t\t\t\t\t\t.cont-id-" +
                m +
                " .wf-cell { width: " +
                r +
                ";  padding: " +
                l +
                "px; } \t\t\t\t\t\t\t.cont-id-" +
                m +
                " .wf-cell.double-width { width: " +
                s +
                "; } \t\t\t\t\t\t"
              : " \t\t\t\t\t\t\t.cont-id-" +
                m +
                " { margin: -" +
                l +
                "px; } \t\t\t\t\t\t\t.full-width-wrap .cont-id-" +
                m +
                " { margin: " +
                v +
                "px " +
                l +
                "px; } \t\t\t\t\t\t\t.cont-id-" +
                m +
                " .wf-cell { width: " +
                r +
                "; padding: " +
                l +
                "px; } \t\t\t\t\t\t"),
            x.html(n);
          var y = q.sheet.cssRules.length;
          q.sheet.insertRule(".webkit-hack { }", y),
            q.sheet.deleteRule(y),
            j.trigger("columnsReady");
        });
      }),
      (a.fn.initSlider = function() {
        return this.each(function() {
          var b = a(this);
          b.data("width"), b.data("height");
          b.hasClass("royalReady") ||
            (b.postTypeScroller(), b.addClass("royalReady"));
        });
      });
    var Mb = Isotope.prototype._positionItem;
    (Isotope.prototype._positionItem = function(a, b, c, d) {
      Mb(a, b, c, !0);
    }),
      (a.fn.IsoLayzrInitialisation = function(b) {
        var c = !0;
        return this.each(function() {
          var d = a(this);
          $selector = d.find("img[class*=iso-]").addClass("iso-item-lazy-load");
          new Layzr({
            container: b,
            selector: ".iso-item-lazy-load",
            attr: "data-src",
            attr: "data- ",
            retinaAttr: "data-src-retina",
            threshold: 30,
            before: function() {
              var b = a(this)
                .attr("data-src")
                .substring(
                  a(this)
                    .attr("data-src")
                    .lastIndexOf(".") + 1
                );
              "png" == b &&
                a(this)
                  .parent()
                  .addClass("layzr-bg-transparent"),
                a(this).one("load", function() {
                  a(this).parents(".woocom-project").length > 0
                    ? this.setAttribute(
                        "sizes",
                        "(max-width:" +
                          a(this).attr("width") +
                          "px) 100vw," +
                          a(this).attr("width") +
                          "px"
                      )
                    : this.setAttribute("sizes", this.width + "px"),
                    (this.style.willChange = "opacity");
                });
            },
            callback: function() {
              this.classList.add("iso-layzr-loaded");
              var b = a(this);
              b.one(
                "webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend",
                function(a) {
                  setTimeout(function() {
                    b.parent().removeClass("layzr-bg"),
                      b.css("will-change", "auto");
                  }, 200);
                }
              ),
                b.parents(".dt-isotope").length > 0 &&
                  c &&
                  (b.parents(".dt-isotope").isotope("layout"), (c = !1));
            }
          });
        });
      }),
      (a.fn.IsoLayzrJqInitialisation = function(b) {
        var c = !0;
        return this.each(function() {
          var d = a(this);
          d.find("img").addClass("thumb-lazy-load-show");
          new Layzr({
            container: b,
            selector: ".thumb-lazy-load-show",
            attr: "data-src",
            attr: "data- ",
            retinaAttr: "data-src-retina",
            threshold: 30,
            before: function() {
              var b = a(this)
                .attr("data-src")
                .substring(
                  a(this)
                    .attr("data-src")
                    .lastIndexOf(".") + 1
                );
              "png" == b &&
                a(this)
                  .parent()
                  .addClass("layzr-bg-transparent"),
                a(this).one("load", function() {
                  a(this).parents(".woocom-project").length > 0
                    ? this.setAttribute(
                        "sizes",
                        "(max-width:" +
                          a(this).attr("width") +
                          "px) 100vw," +
                          a(this).attr("width") +
                          "px"
                      )
                    : this.setAttribute("sizes", this.width + "px"),
                    (this.style.willChange = "opacity");
                });
            },
            callback: function() {
              this.classList.add("iso-layzr-loaded");
              var b = a(this);
              b.one(
                "webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend",
                function(a) {
                  setTimeout(function() {
                    b.parent().removeClass("layzr-bg"),
                      b.css("will-change", "auto");
                  }, 200);
                }
              ),
                b.parents(".dt-isotope").length > 0 &&
                  c &&
                  (b.parents(".dt-isotope").isotope("layout"), (c = !1));
            }
          });
        });
      });
    var Nb = a(".iso-container"),
      Ob = a(
        ".iso-grid:not(.jg-container, .iso-container), .blog.layout-grid .wf-container.description-under-image:not(.jg-container, .iso-container), .grid-masonry:not(.iso-container), .shortcode-blog-posts.iso-grid"
      ),
      Pb = Nb.add(Ob),
      Qb = (dtGlobals.isoPreloader = a(
        '<div class="iso-preloader dt-posts-preload dt-posts-preload-active"><div class="dt-posts-preload-activity"></div></div>'
      )
        .appendTo("body")
        .hide());
    Pb.not(".blog-grid-shortcode").addClass("dt-isotope"),
      Pb.exists() &&
        Pb.each(function(b) {
          var c = a(this);
          if (c.parent().hasClass("mode-masonry")) var d = c.parent();
          else var d = c;
          var e = a(this),
            f = parseInt(d.attr("data-width")),
            g = parseInt(d.attr("data-columns")),
            h = parseInt(d.attr("data-desktop-columns-num")),
            i = parseInt(d.attr("data-h-tablet-columns-num")),
            j = parseInt(d.attr("data-v-tablet-columns-num")),
            k = parseInt(d.attr("data-phone-columns-num")),
            l = parseInt(d.attr("data-padding"));
          e.addClass("cont-id-" + b).attr("data-cont-id", b),
            e.calculateColumns(f, g, l, h, i, j, k, "px"),
            l > 10 && e.addClass("mobile-paddings"),
            v.on("debouncedresize", function() {
              e.calculateColumns(f, g, l, h, i, j, k, "px"),
                l > 10 && e.addClass("mobile-paddings");
            });
        }),
      (a.fn.heightHack = function() {
        return this.each(function() {
          var b = a(this).not(".back-image");
          if (
            !(
              b.hasClass("height-ready") ||
              b.parents(".testimonial-thumb").exists() ||
              b.parents(".post-rollover").exists() ||
              b.parents(".slider-masonry").exists() ||
              b.parents(".rollover-thumbnails").exists()
            )
          ) {
            var c = parseInt(b.attr("width")),
              d = parseInt(b.attr("height")),
              e = c / d;
            b
              .parents(
                ".testimonial-vcard, .dt-format-gallery, .shortcode-blog-posts.iso-grid "
              )
              .exists() && b.wrap("<div />"),
              isNaN(e) && b[0] && (e = b[0].naturalWidth / b[0].naturalHeight),
              b
                .parent()
                .css({
                  "padding-bottom": 100 / e + "%",
                  height: 0,
                  display: "block"
                }),
              b.parents(".woocom-project").exists() &&
                b.parents(".woocom-project").width() > c &&
                b
                  .parent()
                  .css({
                    "padding-bottom":
                      100 / (b.parents(".woocom-project").width() / c) / e +
                      "%",
                    height: 0,
                    display: "block"
                  }),
              b.parents(".dt-team-masonry-shortcode").exists() &&
                "none" != b.parent().css("max-width") &&
                b.parents(".team-media").addClass("apply-max-width"),
              b.attr("data-ratio", e).addClass("height-ready");
          }
        });
      }),
      (a.fn.IsoInitialisation = function(b, c, d, e) {
        return this.each(function() {
          var d = a(this);
          d.hasClass("iso-item-ready") ||
            (d.isotope({
              itemSelector: b,
              layoutMode: c,
              stagger: 30,
              resize: !1,
              transitionDuration: 0,
              equalheight: e,
              hiddenStyle: { opacity: 0 },
              visibleStyle: { opacity: 1 },
              masonry: { columnWidth: 1 },
              getSortData: {
                date: function(b) {
                  return a(b).attr("data-date");
                },
                name: function(b) {
                  return a(b).attr("data-name");
                }
              }
            }),
            d.addClass("iso-item-ready"));
        });
      }),
      a(".iso-container, .portfolio-grid").each(function() {
        if (
          a(this)
            .parent()
            .hasClass("mode-masonry")
        )
          var b = null;
        else var b = a(this);
        a(
          ".filter:not(.iso-filter):not(.without-isotope):not(.with-ajax) .filter-categories a"
        ).on("click.presscorFilterCategories", function(c) {
          var d = a(this).attr("data-filter");
          return null != b && b.isotope({ filter: d }), !1;
        }),
          a(
            ".filter:not(.iso-filter):not(.without-isotope):not(.with-ajax) .filter-extras .filter-by a"
          ).on("click", function(c) {
            var d = a(this).attr("data-by"),
              e = a(this)
                .parents(".filter-extras")
                .find(".filter-sorting > a.act")
                .first()
                .attr("data-sort");
            return (
              null != b && b.isotope({ sortBy: d, sortAscending: "asc" == e }),
              !1
            );
          }),
          a(
            ".filter:not(.iso-filter):not(.without-isotope):not(.with-ajax) .filter-extras .filter-sorting a"
          ).on("click", function(c) {
            var d = a(this).attr("data-sort"),
              e = a(this)
                .parents(".filter-extras")
                .find(".filter-by > a.act")
                .first()
                .attr("data-by");
            return (
              null != b && b.isotope({ sortBy: e, sortAscending: "asc" == d }),
              !1
            );
          });
      }),
      a(".dt-css-grid .wf-cell.visible").IsoLayzrJqInitialisation(),
      (Nb.exists() || Ob.exists()) &&
        (Qb.fadeIn(50),
        Pb.not(".blog-grid-shortcode").each(function() {
          var b = a(this);
          if (b.hasClass("mode-masonry")) var c = b.find(".dt-isotope");
          else var c = b;
          a(".preload-me", c).heightHack(),
            a(".slider-masonry", c).initSlider(),
            c.one("columnsReady", function() {
              if (c.hasClass("iso-container"))
                c.IsoInitialisation(".iso-item", "masonry", 400);
              else {
                if (
                  c.parent().hasClass("gradient-overlay-layout-list") ||
                  c.parent().hasClass("content-rollover-layout-list")
                )
                  var b = !1;
                else var b = !0;
                c.IsoInitialisation(".wf-cell", "fitRows", 400, b);
              }
              c.isotope("on", "layoutComplete", function(b) {
                for (var d = 0; d < b.length; d++) {
                  b[d], a(this);
                  c.trigger("IsoReady");
                }
              }),
                c
                  .parent(
                    ".content-rollover-layout-list:not(.disable-layout-hover)"
                  )
                  .find(".post-entry-wrapper")
                  .clickOverlayGradient(),
                c.one("IsoReady", function() {
                  if (
                    (c.isotope("layout"),
                    c.parent().hasClass("jquery-filter") &&
                      "none" != c.parent().attr("data-pagination-mode"))
                  ) {
                    var a = c.find(".wf-cell.visible");
                    a.IsoLayzrJqInitialisation();
                  } else {
                    var a = c;
                    a.IsoLayzrInitialisation();
                  }
                  setTimeout(function() {
                    c.isotope("layout");
                  }, 350);
                }),
                v.on("columnsReady", function() {
                  a(".slider-masonry", c).hasClass("royalReady") &&
                    a(".slider-masonry", c).each(function() {
                      var b = a(this)
                        .parents(".ts-wrap")
                        .data("thePhotoSlider");
                      "undefined" != typeof b && b.update();
                    }),
                    c
                      .parent(
                        ".content-rollover-layout-list:not(.disable-layout-hover)"
                      )
                      .find(".post-entry-wrapper")
                      .clickOverlayGradient(),
                    c.isotope("layout");
                });
            });
        }),
        Qb.stop().fadeOut(300)),
      v
        .on("debouncedresize", function(b) {
          if (
            (dtGlobals.resizeCounter++,
            a.isFunction(a.fn.calcPics) && a(".instagram-photos").calcPics(),
            y.hasClass("boxed"))
          ) {
            var c = y.css("maxWidth"),
              d = c.indexOf("px") >= 0,
              e = c.indexOf("%") >= 0;
            d &&
              (G.addClass("width-in-pixel"),
              "undefined" != typeof $a && $a.addClass("width-in-pixel")),
              e &&
                (a(".masthead.full-width:not(.side-header)").css({
                  width: y.width()
                }),
                "undefined" != typeof $a &&
                  $a.find(".top-bar-bg").length > 0 &&
                  $a.find(".top-bar-bg").css({ width: y.width() }),
                x.hasClass("phantom-sticky") &&
                  a(".top-bar-bg").length > 0 &&
                  a(".top-bar-bg").css({ width: y.width() }));
          }
          if (
            (window.innerWidth >=
              dtLocal.themeSettings.mobileHeader.firstSwitchPoint &&
              (y.removeClass("show-mobile-header"),
              y.addClass("closed-mobile-header"),
              x.removeClass("show-sticky-mobile-header"),
              x
                .removeClass("show-overlay-mobile-header")
                .addClass("closed-overlay-mobile-header"),
              a(".mobile-sticky-header-overlay").removeClass("active"),
              a(".dt-mobile-menu-icon").removeClass("active"),
              w.removeClass("menu-open")),
            window.innerWidth <=
              dtLocal.themeSettings.mobileHeader.firstSwitchPoint &&
            !x.hasClass("responsive-off")
              ? (a(".masthead").hasClass("masthead-mobile") ||
                  a(".masthead:not(.mixed-header):not(#phantom)").addClass(
                    "masthead-mobile"
                  ),
                a(".masthead").hasClass("masthead-mobile-header") ||
                  (a(".masthead:not(.side-header):not(#phantom)").addClass(
                    "masthead-mobile-header"
                  ),
                  a(
                    "body:not(.overlay-navigation):not(.sticky-header) .side-header:not(#phantom)"
                  ).addClass("masthead-mobile-header")),
                J.exists() &&
                  (J.removeClass("sticky-top-line-on sticky-top-line-on"),
                  (Ra = !1)))
              : (a(".masthead:not(.mixed-header):not(#phantom)").removeClass(
                  "masthead-mobile"
                ),
                a(".masthead:not(.side-header):not(#phantom)").removeClass(
                  "masthead-mobile-header"
                ),
                a(
                  "body:not(.overlay-navigation):not(.sticky-header) .side-header:not(#phantom)"
                ).removeClass("masthead-mobile-header"),
                a(".masthead").hasClass("desktop-side-header") ||
                  a(
                    "body:not(.overlay-navigation):not(.sticky-header) .side-header:not(#phantom)"
                  ).addClass("desktop-side-header")),
            window.innerWidth <=
              dtLocal.themeSettings.mobileHeader.firstSwitchPoint &&
            window.innerWidth >
              dtLocal.themeSettings.mobileHeader.secondSwitchPoint &&
            !x.hasClass("responsive-off")
              ? a(".left-widgets", F).find(".in-top-bar-left").length > 0 ||
                a(".top-bar .right-widgets").find(".in-top-bar-right").length >
                  0
                ? F.removeClass("top-bar-empty")
                : F.addClass("top-bar-empty")
              : window.innerWidth <=
                  dtLocal.themeSettings.mobileHeader.secondSwitchPoint &&
                !x.hasClass("responsive-off")
              ? a(".left-widgets", F).find(".in-top-bar").length > 0
                ? F.removeClass("top-bar-empty")
                : F.addClass("top-bar-empty")
              : !a(".mini-widgets", F).find(".show-on-desktop").length > 0
              ? F.addClass("top-bar-empty")
              : F.removeClass("top-bar-empty"),
            F.exists() && (topBarMobH = F.innerHeight()),
            a(".mini-nav select").trigger("render"),
            a.fancyFeaderCalc(),
            a(".dt-default").each(function() {
              var b = a(this),
                c = b.attr("data-min-height");
              a.isNumeric(c)
                ? b.css({ minHeight: c + "px" })
                : c
                ? c.search("%") > 0
                  ? b.css({
                      minHeight: v.height() * (parseInt(c) / 100) + "px"
                    })
                  : b.css({ minHeight: c })
                : b.css({ minHeight: 0 });
            }),
            (yb = Ab.siblings(".project-wide-col").height()),
            (zb = Ab.height()),
            m(),
            a(".boxed").length > 0)
          ) {
            var f = a(".boxed");
            a(
              ".header-side-left.footer-overlap:not(.sticky-header) .boxed .footer, .left-side-line.footer-overlap .boxed .footer"
            ).css({ right: v.width() - (f.offset().left + f.outerWidth()) });
          }
          a(".footer-overlap .footer").css({ opacity: 1 }),
            a(".mobile-false .footer-overlap .page-inner").css({
              "min-height": window.innerHeight - a(".footer").innerHeight(),
              "margin-bottom": a(".footer").innerHeight()
            });
        })
        .trigger("debouncedresize");
    var Rb = a("html, body"),
      Da = a(".phantom-sticky").exists(),
      Sb = a(".sticky-top-line").exists(),
      Tb = a(".sticky-mobile-header").exists(),
      Ub = 0;
    if (Da || Sb) var $a = a(".masthead");
    else {
      var $a = a("#phantom");
      "block" == $a.css("display");
    }
    if (
      a(".mobile-header-bar").length > 0 &&
      "none" != a(".mobile-header-bar").css("display")
    ) {
      var Kb = a(".mobile-header-bar");
      if (a(".sticky-top-line").exists())
        var Kb = a(
          ".sticky-top-line.masthead-mobile-header .mobile-header-bar"
        );
      if (a(".phantom-sticky").length > 0 || a(".sticky-top-line").exists())
        if (
          a(".sticky-header .masthead.side-header").length > 0 ||
          a(".overlay-navigation .masthead.side-header").length > 0
        )
          var $a = a(".mobile-header-bar").parent(
            ".masthead:not(.side-header)"
          );
        else var $a = a(".mobile-header-bar").parent();
    } else if (x.hasClass("floating-top-bar"))
      var Kb = a(".masthead:not(.side-header):not(.side-header-v-stroke)");
    else
      var Kb = a(
        ".masthead:not(.side-header):not(.side-header-v-stroke) .header-bar"
      );
    o(),
      k(function() {
        var b = window.location.hash;
        if (b.match("^#!")) var c = b.substring(3);
        setTimeout(function() {
          "undefined" != typeof c && c.length > 0
            ? ("up" == c
                ? (a.closeMobileHeader(),
                  Rb.stop().animate({ scrollTop: 0 }, 600, "swing", function() {
                    a.closeSideHeader();
                  }))
                : setTimeout(function() {
                    Rb.stop().animate(
                      { scrollTop: a("#" + c).offset().top - Ub },
                      600,
                      "swing",
                      function() {
                        window.innerWidth <
                          dtLocal.themeSettings.mobileHeader.firstSwitchPoint &&
                        !x.hasClass("responsive-off")
                          ? Tb &&
                            (Ba
                              ? Rb.stop().animate(
                                  {
                                    scrollTop:
                                      a("#" + c).offset().top -
                                      a(
                                        ".masthead-mobile-header .mobile-header-bar"
                                      ).height()
                                  },
                                  650,
                                  "swing"
                                )
                              : Rb.stop().animate(
                                  {
                                    scrollTop:
                                      a("#" + c).offset().top -
                                      a(Kb, $a).height()
                                  },
                                  650,
                                  "swing"
                                ))
                          : (Da || Sb) &&
                            ("solid" == a($a).css("border-bottom-style")
                              ? Rb.stop().animate(
                                  {
                                    scrollTop:
                                      a("#" + c).offset().top -
                                      a(Kb, $a).height() +
                                      1
                                  },
                                  650,
                                  "swing"
                                )
                              : Rb.stop().animate(
                                  {
                                    scrollTop:
                                      a("#" + c).offset().top -
                                      a(Kb, $a).height()
                                  },
                                  650,
                                  "swing"
                                ));
                      }
                    );
                  }, 300),
              a(".menu-item a")
                .parent("li")
                .removeClass("act"),
              a('.menu-item a[href="' + b + '"]')
                .parent("li")
                .addClass("act"),
              a('.menu-item a[href*="' + b + '"]')
                .parent("li")
                .addClass("act"))
            : "undefined" == typeof c &&
              a('.menu-item > a[href="#!/up"]').length > 0 &&
              a('.menu-item > a[href="#!/up"]')
                .parent("li")
                .addClass("act");
        }, 300);
      }),
      jQuery(window).on("resize", function() {
        o();
      });
    var Vb = a('.menu-item > a[href*="#!"]');
    (window.clickAnchorLink = function(b, c) {
      var d = b.attr("href"),
        e = d.substring(3),
        f = 600,
        g = f;
      if (d.match("^#!")) var e = d.substring(3);
      else var e = d.substring(d.indexOf("#")).substring(3);
      if ((o(), "undefined" != typeof e && e && e.length > 0)) {
        if (((location.hash = d), a("#" + e).length > 0)) {
          var h = a("#" + e).offset().top + 1,
            i = b.offset(),
            j = a("#" + e).offset(),
            k = Math.abs(j.top - i.top),
            g = 150 * Math.log(1.022 ^ k);
          $newScrollPosition = h - Ub;
        }
        "up" == e
          ? x.hasClass("overlay-navigation")
            ? (a.closeMobileHeader(),
              a.closeSideHeader(),
              Rb.stop().animate({ scrollTop: h - Ub }, g, "swing"))
            : (a.closeMobileHeader(),
              Rb.stop().animate({ scrollTop: 0 }, g, "swing", function() {
                a.closeSideHeader();
              }))
          : x.hasClass("overlay-navigation")
          ? (a.closeMobileHeader(),
            a.closeSideHeader(),
            Rb.stop().animate({ scrollTop: h - Ub }, g, "swing", function() {
              window.innerWidth <
                dtLocal.themeSettings.mobileHeader.firstSwitchPoint &&
              !x.hasClass("responsive-off")
                ? Tb &&
                  (Ba
                    ? ($newScrollPosition =
                        h -
                        a(
                          ".masthead-mobile-header .mobile-header-bar"
                        ).height())
                    : ($newScrollPosition = h - a(Kb, $a).height()),
                  Rb.stop().animate(
                    { scrollTop: $newScrollPosition },
                    650,
                    "swing"
                  ))
                : Sb &&
                  (($newScrollPosition = h - a(".sticky-top-line").height()),
                  Rb.stop().animate(
                    { scrollTop: $newScrollPosition },
                    650,
                    "swing"
                  ));
            }))
          : (a.closeMobileHeader(),
            Rb.stop().animate({ scrollTop: h - Ub }, g, "swing", function() {
              if (
                (a.closeSideHeader(),
                window.innerWidth <
                  dtLocal.themeSettings.mobileHeader.firstSwitchPoint &&
                  !x.hasClass("responsive-off"))
              )
                Tb &&
                  ((b = Ba
                    ? h -
                      a(".masthead-mobile-header .mobile-header-bar").height()
                    : Ra
                    ? h - a(".sticky-top-line").height()
                    : h - a(Kb, $a).height()),
                  Rb.stop().animate({ scrollTop: b }, 650, "swing"));
              else if (Da || Sb) {
                if (Ma)
                  if (x.hasClass("floating-top-bar"))
                    var b = h - a(".masthead").height();
                  else b = h - a(".header-bar").height();
                else b = h - a(".sticky-top-line").height();
                Rb.stop().animate({ scrollTop: b }, 650, "swing");
              }
            })),
          a(".menu-item a")
            .parent("li")
            .removeClass("act"),
          b.parent("li").addClass("act");
      }
    }),
      x.on(
        "click",
        '.anchor-link[href^="#!"], .anchor-link a[href^="#!"], .logo-box a[href^="#!"], .branding a[href^="#!"], #branding-bottom a[href^="#!"], .mobile-branding a[href^="#!"]',
        function(b) {
          return clickAnchorLink(a(this), b), b.preventDefault(), !1;
        }
      ),
      Vb.on("click", function(b) {
        if (
          (clickAnchorLink(a(this), b),
          a(this)
            .attr("href")
            .match("^#!"))
        )
          return b.preventDefault(), !1;
      }),
      (a('.one-page-row div[data-anchor^="#"]').length > 0 ||
        a(".vc_row[id]").length > 0 ||
        a(".vc_section[id]").length > 0) &&
        a(".one-page-row").length > 0 &&
        v.scroll(function(b) {
          var c = null;
          if (!x.hasClass("is-scroll")) {
            var c;
            if (Xa && "solid" == a($a).css("border-bottom-style"))
              var d = a($a).height() + 1;
            else if (Xa) var d = a($a).height();
            else var d = a(Kb).height();
            if (
              (a(
                '.one-page-row .vc_row[id], .one-page-row .vc_section[id], .one-page-row div[data-anchor^="#"]'
              ).each(function() {
                var b = a(this),
                  e = b.attr("id");
                b.hasClass("wpb_animate_when_almost_visible") &&
                  b.one(
                    "webkitAnimationEnd oanimationend msAnimationEnd animationend",
                    function(f) {
                      b.is(":visible") &&
                        dtGlobals.winScrollTop >=
                          Math.floor(b.offset().top - d) &&
                        (c = "#!/" + e),
                        a('.menu-item a[href^="#!"]')
                          .parent("li")
                          .removeClass("act"),
                        a('.menu-item a[href="' + c + '"]')
                          .parent("li")
                          .addClass("act");
                    }
                  ),
                  b.is(":visible") &&
                    dtGlobals.winScrollTop >= Math.floor(b.offset().top - d) &&
                    (c = "#!/" + e);
              }),
              a('.menu-item a[href^="#!"]')
                .parent("li")
                .removeClass("act"),
              a('.menu-item a[href="' + c + '"]')
                .parent("li")
                .addClass("act"),
              a(".one-page-row div[data-anchor^='#']").length > 0)
            )
              dtGlobals.winScrollTop <
                a(".one-page-row div[data-anchor^='#']")
                  .first()
                  .offset().top -
                  d &&
                a('.menu-item > a[href="#!/up"]').length > 0 &&
                a('.menu-item > a[href="#!/up"]')
                  .parent("li")
                  .addClass("act");
            else if (
              a(".vc_row[id]").length > 0 ||
              a(".vc_section[id]").length > 0
            ) {
              var e = a(
                ".one-page-row .vc_row[id], .one-page-row .vc_section[id]"
              );
              dtGlobals.winScrollTop < e.first().offset().top - d &&
                a('.menu-item > a[href="#!/up"]').length > 0 &&
                a('.menu-item > a[href="#!/up"]')
                  .parent("li")
                  .addClass("act");
            }
            a('.menu-item a[href="#"]').length &&
              null == c &&
              a('.menu-item a[href="#"]')
                .parent("li")
                .addClass("act");
          }
        }),
      (a.fn.resetEffects = function(b) {
        return this.each(function() {
          var b = a(this);
          b.find(".iso-item.shown, .wf-cell.shown")
            .removeClass("start-animation")
            .removeClass("animation-triggered")
            .removeClass("shown");
        });
      });
    var Wb = {
      xhr: !1,
      settings: !1,
      launch: function(b) {
        var c = this;
        b && (this.settings = b), this.xhr && this.xhr.abort();
        var d = "presscore_template_ajax";
        this.xhr = a.post(
          b.ajaxurl,
          {
            action: d,
            postID: b.postID,
            paged: b.paged,
            targetPage: b.targetPage,
            term: b.term,
            orderby: b.orderBy,
            order: b.order,
            nonce: b.nonce,
            visibleItems: b.visibleItems,
            contentType: b.contentType,
            pageData: b.pageData,
            sender: b.sender
          },
          function(d) {
            if (d.success) {
              var e = jQuery(d.html),
                f = b.targetContainer;
              parseInt(f.attr("data-width")),
                parseInt(f.attr("data-max-width")),
                parseInt(f.attr("data-padding"));
              if (
                ((isIsotope = "grid" == b.layout || "masonry" == b.layout),
                (itemsToDeleteLength = 0),
                (trashItems = new Array()),
                (sortBy = d.orderby.replace("title", "name")),
                (sortAscending = "asc" == d.order.toString()),
                d.newNonce && (dtLocal.ajaxNonce = d.newNonce),
                "undefined" != typeof d.itemsToDelete &&
                  (itemsToDeleteLength = d.itemsToDelete.length),
                isIsotope && itemsToDeleteLength > 0)
              ) {
                for (var g = 0; g < d.itemsToDelete.length; g++)
                  trashItems.push(
                    '.wf-cell[data-post-id="' + d.itemsToDelete[g] + '"]'
                  );
                f.isotope("remove", f.find(trashItems.join(",")));
              } else
                isIsotope ||
                  ("filter" != b.sender && "paginator" != b.sender) ||
                  f.find(".wf-cell, article").remove();
              e.length > 0
                ? (f.append(e),
                  (dtGlobals.ajaxContainerItems = f
                    .find("div.wf-cell, .project-even, .project-odd")
                    .not(".animation-triggered")),
                  isIsotope
                    ? (a(".preload-me", f).heightHack(),
                      a(".slider-masonry", f).initSlider(),
                      a(".slider-masonry", f).css("visibility", "visible"),
                      f.isotope("addItems", e),
                      "media" != b.contentType
                        ? f.isotope({
                            sortBy: sortBy,
                            sortAscending: sortAscending
                          })
                        : f.isotope({ sortBy: "original-order" }),
                      f.isotope("layout"),
                      c.init(),
                      f.layzrInitialisation(),
                      f.IsoLayzrInitialisation())
                    : (a(".slider-masonry", f).initSlider(),
                      a("ul.photoSlider:not(.slider-masonry)").each(function() {
                        a(this).postTypeScroller();
                      }),
                      a("ul.photoSlider").css("visibility", "visible"),
                      "jgrid" == b.layout && f.collagePlus(dtGlobals.jGrid),
                      c.init(),
                      f.layzrInitialisation(),
                      f.IsoLayzrInitialisation(".mobile-true")),
                  "undefined" != typeof b.afterSuccessInit &&
                    b.afterSuccessInit(d),
                  v.trigger("dt.ajax.content.appended"))
                : isIsotope &&
                  f.isotope({ sortBy: sortBy, sortAscending: sortAscending });
            }
            "undefined" != typeof b.afterResponce && b.afterResponce(d), p();
          }
        );
      },
      init: function() {
        switch (this.settings.contentType) {
          case "portfolio":
            this.initPortfolio();
            break;
          case "albums":
            this.initAlbums();
            break;
          case "media":
            this.initMedia();
            break;
          case "blog":
            this.basicInit();
            break;
          case "testimonials":
            this.basicInit();
        }
      },
      initPortfolio: function() {
        this.basicInit();
      },
      initAlbums: function() {
        this.basicInit();
      },
      initMedia: function() {
        this.basicInit();
      },
      basicInit: function() {
        var b = this.settings.targetContainer;
        a(".dt-pswp-item, .dt-gallery-container a", b).addPhotoswipeWrap(),
          a(".dt-gallery-container", b).initPhotoswipe(),
          a(".photoswipe-wrapper", b).initPhotoswipe(),
          b.photoswipeGallery(".dt-gallery-container.wf-container"),
          a(
            ".rollover, .rollover-video, .post-rollover, .rollover-project .show-content",
            b
          ).addRollover(),
          a.isFunction(a.fn.hoverdir) &&
            (a(".mobile-false .hover-grid .rollover-project").each(function() {
              a(this).hoverdir();
            }),
            a(".mobile-false .hover-grid-reverse .rollover-project ").each(
              function() {
                a(this).hoverdir({ inverse: !0 });
              }
            )),
          a(
            ".mobile-true .rollover-project a.link.show-content, .hover-style-one article:not(.description-off) .rollover-project > a, .hover-style-two article:not(.description-off) .rollover-project > a, .hover-style-three article:not(.description-off) .rollover-project > a"
          ).on("click", function(a) {
            a.preventDefault();
          }),
          a(".dt-trigger-first-pswp", b)
            .not(".pspw-ready")
            .on("click", function() {
              var b = a(this),
                c = b.parents("article.post");
              if (c.length > 0) {
                var d = c.find("a.dt-pswp-item");
                d.length > 0 && d.first().trigger("click");
              }
              return !1;
            })
            .addClass("mfp-ready"),
          a(".mobile-true .rollover-project").touchNewHover(),
          a.isFunction(a.fn.triggerHoverClick) &&
            a(
              ".mobile-false .rollover-project:not(.rollover-active) .rollover-content, .buttons-on-img:not(.rollover-active) .rollover-content"
            ).triggerHoverClick(),
          a.isFunction(a.fn.triggerHoverClick) &&
            a(
              ".mobile-false .rollover-project.forward-post"
            ).triggerHoverClick(),
          a.isFunction(a.fn.triggerHoverClick) &&
            a(
              ".mobile-false .rollover-project.rollover-active, .mobile-false .buttons-on-img.rollover-active"
            ).followCurentLink(),
          a.isFunction(a.fn.triggerAlbumsClick) &&
            a(
              ".mobile-false .albums .rollover-project, .mobile-false .albums .buttons-on-img, .mobile-false .archive .type-dt_gallery .buttons-on-img"
            ).triggerAlbumsClick(),
          a.isFunction(a.fn.triggerAlbumsTouch) &&
            a(
              ".mobile-true .albums .rollover-project, .mobile-true .albums .buttons-on-img, .mobile-true .archive .type-dt_gallery .buttons-on-img"
            ).triggerAlbumsTouch(),
          a.isFunction(a.fn.triggerPostClick) &&
            a(
              ".mobile-false .content-rollover-layout-list:not(.portfolio-shortcode):not(.albums-shortcode) .post, .mobile-false .gradient-overlay-layout-list:not(.portfolio-shortcode):not(.albums-shortcode) .post"
            ).triggerPostClick(),
          a.isFunction(a.fn.touchforwardToPost) &&
            a(
              ".mobile-true .rollover-project.forward-post"
            ).touchforwardToPost(),
          a.isFunction(a.fn.touchHoverImage) &&
            a(".mobile-true .buttons-on-img").touchHoverImage(),
          a(".hover-scale .rollover-project").scaleInHover(),
          a.isFunction(a.fn.addIconToLinks) &&
            a(".links-container a").addIconToLinks();
      }
    };
    if (
      (a("#content").on("click", ".paginator.with-ajax a", function(b) {
        if (
          (b.preventDefault(),
          !a(b.target).hasClass("dots") && !a(b.target).hasClass("disabled"))
        ) {
          var c = a(this),
            d = c.closest(".paginator"),
            e = d.parent(),
            f = e
              .find(".wf-container.with-ajax, .articles-list.with-ajax")
              .first(),
            g = a(".button-load-more"),
            h = g.find(".button-caption").text(),
            i = d.hasClass("paginator-more-button") ? "more" : "paginator",
            j = "more" == i,
            k = r(e),
            l = j ? k.paged + 1 : c.attr("data-page-num"),
            m = dtGlobals.isoPreloader;
          if (
            (g
              .addClass("animate-load")
              .find(".button-caption")
              .text(dtLocal.moreButtonText.loading),
            m &&
              !a(".paginator-more-button").length &&
              dtGlobals.isoPreloader.fadeIn(50),
            j)
          )
            a("html, body").scrollTop(v.scrollTop() + 1);
          else {
            var n = e.find(".filter.with-ajax").first(),
              o = 44;
            n.exists() || ((n = f), (o = 50)),
              a("html, body").animate(
                { scrollTop: n.offset().top - a("#phantom").height() - o },
                400
              );
          }
          Wb.launch(
            a.extend({}, k, {
              contentType: k.pageData.template,
              targetPage: l,
              sender: i,
              visibleItems: j ? new Array() : k.visibleItems,
              afterResponce: function(b) {
                d.length > 0
                  ? (b.paginationHtml
                      ? d.html(a(b.paginationHtml).html()).show()
                      : d.html("").hide(),
                    setTimeout(function() {
                      a(".button-load-more")
                        .removeClass("animate-load")
                        .find(".button-caption")
                        .text(h);
                    }, 200))
                  : b.paginationHtml && f.parent().append(a(b.paginationHtml)),
                  d.find(".dots").on("click", function() {
                    d
                      .find("div:hidden")
                      .show()
                      .find("a")
                      .unwrap(),
                      a(this).remove();
                  }),
                  f.attr("data-cur-page", b.currentPage),
                  dtGlobals.isoPreloader.stop().fadeOut(300),
                  (dtGlobals.loadMoreButton = a(".button-load-more"));
              }
            })
          );
        }
      }),
      a(
        ".filter.with-ajax .filter-categories a, .filter.with-ajax .filter-extras a"
      ).on("click", function(b) {
        b.preventDefault();
        var c = a(this),
          d = c.closest(".filter"),
          e = d.parent(),
          f = e.find(".wf-container.with-ajax").first(),
          g = e.find(".paginator").first(),
          h = r(e),
          i = dtGlobals.isoPreloader;
        f.resetEffects(),
          i && dtGlobals.isoPreloader.fadeIn(50),
          Wb.launch(
            a.extend({}, h, {
              contentType: h.pageData.template,
              targetPage: 1,
              paged: 1,
              sender: "filter",
              afterResponce: function(b) {
                g.length > 0
                  ? b.paginationHtml
                    ? g.html(a(b.paginationHtml).html()).show()
                    : g.html("").hide()
                  : b.paginationHtml && f.parent().append(a(b.paginationHtml)),
                  g.find(".dots").on("click", function() {
                    g
                      .find("div:hidden")
                      .show()
                      .find("a")
                      .unwrap(),
                      a(this).remove();
                  }),
                  f.attr("data-cur-page", b.currentPage),
                  dtGlobals.isoPreloader.stop().fadeOut(300),
                  (dtGlobals.loadMoreButton = a(".button-load-more"));
              }
            })
          );
      }),
      "undefined" != typeof dtLocal.themeSettings.lazyLoading &&
        dtLocal.themeSettings.lazyLoading)
    ) {
      dtGlobals.loadMoreButton = a(".button-load-more");
      v.on("scroll", function() {
        s();
      }),
        s();
    }
    var Hb = (function() {
      var a = {};
      return function(b, c, d) {
        d || (d = "Don't call this twice without a uniqueId"),
          a[d] && clearTimeout(a[d]),
          (a[d] = setTimeout(b, c));
      };
    })();
    v.resize(function() {
      a(".iso-item, .iso-grid .wf-cell").addClass("animate-position"),
        Hb(
          function() {
            a(".iso-item, .iso-grid .wf-cell").removeClass("animate-position");
          },
          2500,
          ""
        );
    });
    var Xb = a(".dt-isotope"),
      Yb = a(".iso-item:not(.shown):not(.is-visible)"),
      Zb = a(
        ".iso-grid .wf-cell:not(.shown):not(.is-visible), .dt-css-grid .wf-cell:not(.shown):not(.is-visible)"
      );
    (Xb.exists() || Yb.exists() || Zb.exists()) &&
      (setTimeout(function() {
        p();
      }, 100),
      v.on("scroll", function() {
        p();
      }));
    var $b = (function() {
        function b(b) {
          var c = {
            paginatorContainer: null,
            postLimit: 1,
            curPage: 1,
            items: [],
            onPaginate: function() {}
          };
          this.config = a.extend(c, b);
        }
        return (
          (b.prototype.setCurPage = function(a) {
            this.config.curPage = parseInt(a);
          }),
          (b.prototype.getCurPage = function() {
            return this.config.curPage;
          }),
          (b.prototype.reset = function(a) {
            (this.config.items = a),
              this.setCurPage(1),
              this.appendControls(),
              this._filterByCurPage();
          }),
          (b.prototype.appendControls = function() {}),
          (b.prototype._filterByCurPage = function() {
            this.showItem(this.config.items);
          }),
          (b.prototype.hideItem = function(a) {
            a.removeClass("visible")
              .addClass("hidden")
              .hide();
          }),
          (b.prototype.showItem = function(a) {
            a.addClass("visible")
              .removeClass("hidden")
              .show();
          }),
          b
        );
      })(),
      _b = (function() {
        function b(b) {
          $b.call(this, b);
          var c = {
            previousButtonClass: "",
            previousButtonLabel: "",
            pagerClass: "",
            nextButtonClass: "",
            nextButtonLabel: "",
            activeClass: "act",
            pagesToShow: 5
          };
          (this.config = a.extend(c, this.config)),
            this.appendControls(),
            a(
              "a.act",
              this.config.paginatorContainer
            ).trigger("click.dtPostsPaginationFilter", { onSetup: !0 });
        }
        return (
          (b.prototype = new $b()),
          (b.prototype.addEvents = function() {
            var b = this;
            a("a", this.config.paginatorContainer)
              .not(".dots")
              .on("click.dtPostsPaginationFilter", { self: this }, function(
                a,
                c
              ) {
                b.config.onPaginate.call(this, a, c);
              }),
              a("a.dots", this.config.paginatorContainer).on(
                "click.dtPostsPaginationDots",
                { self: this },
                function(a) {
                  a.preventDefault(),
                    a.data.self.config.paginatorContainer
                      .find("div:hidden a")
                      .unwrap(),
                    a.data.self.config.paginatorContainer
                      .find("a.dots")
                      .remove();
                }
              );
          }),
          (b.prototype.appendControls = function() {
            var b = this.config.paginatorContainer,
              c = Math.ceil(this.config.items.length / this.config.postLimit),
              d = this.config.curPage;
            if ((b.empty(), !(c <= 1))) {
              var e, f;
              1 !== d &&
                b.prepend(
                  '<a href="#" class="' +
                    this.config.previousButtonClass +
                    '" data-page-num="' +
                    (d - 1) +
                    '">' +
                    this.config.previousButtonLabel +
                    "</a>"
                );
              var g = 5 | this.config.pagesToShow,
                h = g - 1,
                i = Math.floor(h / 2),
                j = Math.ceil(h / 2),
                k = Math.max(d - i, 1),
                l = d + j;
              k <= i && (l = k + h),
                l > c && ((k = Math.max(c - h, 1)), (l = c));
              var m = '<a href="javascript:void(0);" class="dots">…</a>',
                n = a('<div style="display: none;"></div>'),
                o = a('<div style="display: none;"></div>');
              for (e = f = 1; 1 <= c ? f <= c : f >= c; e = 1 <= c ? ++f : --f)
                e < k && 1 != e
                  ? n.append(
                      '<a href="#" class="' +
                        this.config.pagerClass +
                        '" data-page-num="' +
                        +e +
                        '">' +
                        e +
                        "</a>"
                    )
                  : (e == k && n.children().length && b.append(n).append(a(m)),
                    e > l && e != c
                      ? o.append(
                          '<a href="#" class="' +
                            this.config.pagerClass +
                            '" data-page-num="' +
                            +e +
                            '">' +
                            e +
                            "</a>"
                        )
                      : (e == c &&
                          o.children().length &&
                          b.append(o).append(a(m)),
                        b.append(
                          '<a href="#" class="' +
                            this.config.pagerClass +
                            '" data-page-num="' +
                            +e +
                            '">' +
                            e +
                            "</a>"
                        )));
              d < c &&
                b.append(
                  '<a href="#" class="' +
                    this.config.nextButtonClass +
                    '" data-page-num="' +
                    (d + 1) +
                    '">' +
                    this.config.nextButtonLabel +
                    "</a>"
                ),
                b
                  .find('a[data-page-num="' + d + '"]')
                  .addClass(this.config.activeClass),
                this.addEvents();
            }
          }),
          (b.prototype._filterByCurPage = function() {
            var b = this;
            this.config.items.get().map(function(c, d) {
              b._showOnCurPage(d + 1) ? b.showItem(a(c)) : b.hideItem(a(c));
            });
          }),
          (b.prototype._showOnCurPage = function(a) {
            return (
              this.config.postLimit <= 0 ||
              (this.config.postLimit * (this.getCurPage() - 1) < a &&
                a <= this.config.postLimit * this.getCurPage())
            );
          }),
          (b.prototype._setAsActive = function(a) {
            a.addClass("act")
              .siblings()
              .removeClass("act");
          }),
          b
        );
      })(),
      ac = (function() {
        function b(b) {
          $b.call(this, b);
          var c = { loadMoreButtonClass: "", loadMoreButtonLabel: "Load more" };
          (this.config = a.extend(c, b)),
            this.appendControls(),
            a(
              "a.act",
              this.config.paginatorContainer
            ).trigger("click.dtPostsPaginationFilter", { onSetup: !0 });
        }
        return (
          (b.prototype = new $b()),
          (b.prototype.addEvents = function() {
            a("a", this.config.paginatorContainer).on(
              "click.dtPostsPaginationFilter",
              { self: this },
              this.config.onPaginate
            );
          }),
          (b.prototype.appendControls = function() {
            var b = this.config.paginatorContainer,
              c = Math.ceil(this.config.items.length / this.config.postLimit),
              d = this.config.curPage,
              e = this;
            return (
              b.empty(),
              c <= 1
                ? (this.config.items.get().map(function(b, c) {
                    e.showItem(a(b));
                  }),
                  void e.config.items
                    .filter(".visible")
                    .IsoLayzrJqInitialisation())
                : (d < c
                    ? b
                        .append(
                          '<a href="#" class="' +
                            this.config.loadMoreButtonClass +
                            '"><span class="stick"></span><span class="button-caption">' +
                            this.config.loadMoreButtonLabel +
                            "</span></a>"
                        )
                        .css("display", "flex")
                    : b.css("display", "none"),
                  void this.addEvents())
            );
          }),
          (b.prototype._filterByCurPage = function() {
            var b = this,
              c = b.getCurPage() * b.config.postLimit;
            this.config.items.get().map(function(d, e) {
              e < c ? b.showItem(a(d)) : b.hideItem(a(d));
            });
          }),
          b
        );
      })(),
      bc = (function() {
        function b(b) {
          var c = {
            onCategoryFilter: function() {},
            onOrderFilter: function() {},
            onOrderByFilter: function() {},
            categoryContainer: null,
            orderContainer: null,
            orderByContainer: null,
            postsContainer: null,
            order: "desc",
            orderBy: "date",
            curCategory: "*"
          };
          (this.config = a.extend(c, b)), this.addEvents();
        }
        return (
          (b.prototype.addEvents = function() {
            var b = this;
            a("a", this.config.categoryContainer).on(
              "click.dtPostsCategoryFilter",
              { self: this },
              function(a) {
                b.config.onCategoryFilter.call(this, a);
              }
            ),
              a("a", this.config.orderContainer).on(
                "click.dtPostsOrderFilter",
                { self: this },
                function(a) {
                  b.config.onOrderFilter.call(this, a);
                }
              ),
              a("a", this.config.orderByContainer).on(
                "click.dtPostsOrderByFilter",
                { self: this },
                function(a) {
                  b.config.onOrderByFilter.call(this, a);
                }
              );
          }),
          (b.prototype.setOrder = function(a) {
            this.config.order = a;
          }),
          (b.prototype.setOrderBy = function(a) {
            this.config.orderBy = a;
          }),
          (b.prototype.setCurCategory = function(a) {
            this.config.curCategory = a;
          }),
          (b.prototype.getFilteredItems = function() {
            return a(
              this.config.postsContainer.isotope("getFilteredItemElements")
            );
          }),
          (b.prototype.getItems = function() {
            return a(this.config.postsContainer.isotope("getItemElements"));
          }),
          (b.prototype.layout = function() {
            this.config.postsContainer.isotope("layout");
          }),
          (b.prototype.scrollToTopOfContainer = function(b, c) {
            var d = this.config.postsContainer.parent(),
              e = a(".phantom-sticky").exists(),
              f = a(".sticky-top-line").exists();
            if (e || f) var g = a(".masthead");
            else var g = a("#phantom");
            a("html, body").animate(
              { scrollTop: d.offset().top - g.height() - 50 },
              400,
              b ? b.bind(c | this) : void 0
            );
          }),
          (b.prototype._filterPosts = function() {
            this.config.postsContainer.isotope({
              filter: this.config.curCategory,
              sortAscending: "asc" == this.config.order,
              sortBy: this.config.orderBy
            });
          }),
          (b.prototype._setAsActive = function(a) {
            a.addClass("act")
              .siblings()
              .removeClass("act");
          }),
          b
        );
      })(),
      cc = (function() {
        function b(b) {
          bc.call(this, b);
          var c = { showOnCurPage: function() {} };
          (this.config = a.extend(c, this.config)),
            (this.items = this.config.postsContainer.find(".wf-cell")),
            (this.filteredItems = this.items);
        }
        return (
          (b.prototype = new bc()),
          (b.prototype.getFilteredItems = function() {
            return this.filteredItems;
          }),
          (b.prototype.getItems = function() {
            return this.items;
          }),
          (b.prototype.layout = function() {
            var b = this;
            b.items.css("display", "none");
            var c = 0,
              d = [];
            b.filteredItems.each(function() {
              b.config.showOnCurPage(++c) &&
                (a(this).css("display", "block"), d.push(this));
            }),
              (d = a(d)),
              b.config.postsContainer.data("visibleItems", d),
              b.config.postsContainer.collage({ images: d });
          }),
          (b.prototype._filterPosts = function() {
            var a = this;
            a.filteredItems = a.items.filter(a.config.curCategory);
          }),
          b
        );
      })();
    (function() {
      function b(a) {
        bc.call(this, a),
          (this.items = this.config.postsContainer.find(".wf-cell")),
          (this.filteredItems = this.items);
      }
      return (
        (b.prototype = new bc()),
        (b.prototype.getFilteredItems = function() {
          return this.filteredItems;
        }),
        (b.prototype.getItems = function() {
          return this.items;
        }),
        (b.prototype.layout = function() {}),
        (b.prototype._filterPosts = function() {
          this.items.hide(),
            (this.filteredItems = this._sortItems(
              this.items.filter(this.config.curCategory)
            )),
            this.filteredItems.detach().prependTo(this.config.postsContainer),
            this.filteredItems.show();
        }),
        (b.prototype._sortItems = function(b) {
          var c = this.config.orderBy,
            d = this.config.order,
            e = a([]);
          return (
            (e.$nodesCache = a([])),
            b.each(function() {
              var b = a(this);
              e.push({
                node: this,
                $node: b,
                name: b.attr("data-name"),
                date: new Date(b.attr("data-date"))
              });
            }),
            "date" === c && "desc" === d
              ? e.sort(function(a, b) {
                  return b.date - a.date;
                })
              : "date" === c && "asc" === d
              ? e.sort(function(a, b) {
                  return a.date - b.date;
                })
              : "name" === c && "desc" === d
              ? e.sort(function(a, b) {
                  var c = a.name.toLowerCase(),
                    d = b.name.toLowerCase();
                  return c > d ? -1 : c < d ? 1 : 0;
                })
              : "name" === c &&
                "asc" === d &&
                e.sort(function(a, b) {
                  var c = a.name.toLowerCase(),
                    d = b.name.toLowerCase();
                  return c < d ? -1 : c > d ? 1 : 0;
                }),
            e.each(function() {
              e.$nodesCache.push(this.node);
            }),
            e.$nodesCache
          );
        }),
        b
      );
    })();
    a(".dt-shortcode.with-isotope").each(function() {
      var b = a(this),
        c = b.find(".iso-grid, .iso-container"),
        d = c.hasClass("dt-isotope"),
        e = {
          postsContainer: c,
          categoryContainer: b.find(".filter-categories"),
          curCategory: b.find(".filter-categories a.act").attr("data-filter")
        };
      if (d) {
        var f = b
          .find(".filter-extras .filter-sorting a.act")
          .attr("data-sort");
        f || (f = b.find(".filter-categories").attr("data-default-order"));
        var g = b.find(".filter-extras .filter-by a.act").attr("data-by");
        g || (g = b.find(".filter-categories").attr("data-default-orderby")),
          a.extend(e, {
            order: f,
            orderBy: g,
            orderByContainer: b.find(".filter-extras .filter-by"),
            orderContainer: b.find(".filter-extras .filter-sorting"),
            onCategoryFilter: function(b) {
              b.preventDefault();
              var c = a(this),
                d = b.data.self;
              d.config.postsContainer.resetEffects(),
                d._setAsActive(c),
                d.setCurCategory(c.attr("data-filter")),
                d._filterPosts(),
                i.hideItem(d.getItems()),
                i.reset(d.getFilteredItems()),
                d.layout(),
                d.config.postsContainer.IsoLayzrInitialisation(),
                s(),
                p();
            },
            onOrderFilter: function(b) {
              b.preventDefault();
              var c = a(this),
                d = b.data.self;
              d.config.postsContainer.resetEffects(),
                d._setAsActive(c),
                d.setOrder(c.attr("data-sort")),
                d._filterPosts(),
                i.hideItem(d.getItems()),
                i.reset(d.getFilteredItems()),
                d.layout(),
                d.config.postsContainer.IsoLayzrInitialisation(),
                s(),
                p();
            },
            onOrderByFilter: function(b) {
              b.preventDefault();
              var c = a(this),
                d = b.data.self;
              d.config.postsContainer.resetEffects(),
                d._setAsActive(c),
                d.setOrderBy(c.attr("data-by")),
                d._filterPosts(),
                i.hideItem(d.getItems()),
                i.reset(d.getFilteredItems()),
                d.layout(),
                d.config.postsContainer.IsoLayzrInitialisation(),
                s(),
                p();
            }
          });
        var h = new bc(e),
          i = new _b({
            previousButtonClass: "nav-prev",
            previousButtonLabel:
              '<i class="dt-icon-the7-arrow-0-42" aria-hidden="true"></i>',
            nextButtonClass: "nav-next",
            nextButtonLabel:
              '<i class="dt-icon-the7-arrow-0-41" aria-hidden="true"></i>',
            postLimit: c.attr("data-posts-per-page"),
            curPage: 1,
            pagesToShow: c.hasClass("show-all-pages") ? 999 : 5,
            items: h.getFilteredItems(),
            paginatorContainer: b.find(".paginator"),
            onPaginate: function(b, c) {
              b.preventDefault();
              var d = a(this),
                e = b.data.self;
              e._setAsActive(d),
                e.setCurPage(d.attr("data-page-num")),
                e._filterByCurPage(),
                h.layout(),
                c || (e.appendControls(), h.scrollToTopOfContainer());
            }
          });
      } else {
        var h = new cc(e),
          i = new _b({
            previousButtonClass: "nav-prev",
            previousButtonLabel:
              '<i class="dt-icon-the7-arrow-0-42" aria-hidden="true"></i>',
            nextButtonClass: "nav-next",
            nextButtonLabel:
              '<i class="dt-icon-the7-arrow-0-41" aria-hidden="true"></i>',
            postLimit: c.attr("data-posts-per-page"),
            curPage: 1,
            pagesToShow: c.hasClass("show-all-pages") ? 999 : 5,
            items: h.getFilteredItems(),
            paginatorContainer: b.find(".paginator")
          });
        (h.config.onCategoryFilter = function(b) {
          b.preventDefault();
          var c = a(this),
            d = b.data.self;
          d.config.postsContainer.resetEffects(),
            d._setAsActive(c),
            d.setCurCategory(c.attr("data-filter")),
            d._filterPosts(),
            i.hideItem(d.getItems()),
            i.reset(d.getFilteredItems()),
            d.layout(),
            s(),
            p();
        }),
          (h.config.showOnCurPage = function(a) {
            return i._showOnCurPage(a);
          }),
          (i.config.onPaginate = function(b, c) {
            b.preventDefault();
            var d = a(this),
              e = b.data.self;
            e._setAsActive(d),
              e.setCurPage(d.attr("data-page-num")),
              e._filterByCurPage(),
              h.layout(),
              c || (e.appendControls(), h.scrollToTopOfContainer());
          }),
          a(
            "a.act",
            i.config.paginatorContainer
          ).trigger("click.dtPostsPaginationFilter", { onSetup: !0 });
      }
    }),
      a(
        ".mode-masonry.jquery-filter, .mode-grid.jquery-filter:not(.dt-css-grid-wrap)"
      ).each(function() {
        function b() {
          if (c.hasClass("lazy-loading-mode")) {
            var a = c.find(".button-load-more").offset();
            a &&
              v.scrollTop() > (a.top - v.height()) / 2 &&
              c.find(".button-load-more").trigger("click");
          }
        }
        var c = a(this),
          d = c.find(".iso-grid, .iso-container"),
          e = c.find(".filter-extras .filter-sorting a.act").attr("data-sort");
        e || (e = c.find(".filter-categories").attr("data-default-order"));
        var f = c.find(".filter-extras .filter-by a.act").attr("data-by");
        f || (f = c.find(".filter-categories").attr("data-default-orderby"));
        var g = {
            order: e,
            orderBy: f,
            curCategory: c.find(".filter-categories a.act").attr("data-filter"),
            postsContainer: d,
            categoryContainer: c.find(".filter-categories"),
            orderByContainer: c.find(".filter-extras .filter-by"),
            orderContainer: c.find(".filter-extras .filter-sorting"),
            onCategoryFilter: function(c) {
              c.preventDefault();
              var d = a(this),
                e = c.data.self;
              e.config.postsContainer.resetEffects(),
                e._setAsActive(d),
                e.setCurCategory(d.attr("data-filter")),
                e._filterPosts(),
                i.hideItem(e.getItems()),
                i.reset(e.getFilteredItems()),
                e.layout(),
                e.config.postsContainer.IsoLayzrInitialisation(),
                b(),
                p();
            },
            onOrderFilter: function(c) {
              c.preventDefault();
              var d = a(this),
                e = c.data.self;
              e.config.postsContainer.resetEffects(),
                e._setAsActive(d),
                e.setOrder(d.attr("data-sort")),
                e._filterPosts(),
                i.hideItem(e.getItems()),
                i.reset(e.getFilteredItems()),
                e.layout(),
                e.config.postsContainer.IsoLayzrInitialisation(),
                b(),
                p();
            },
            onOrderByFilter: function(c) {
              c.preventDefault();
              var d = a(this),
                e = c.data.self;
              e.config.postsContainer.resetEffects(),
                e._setAsActive(d),
                e.setOrderBy(d.attr("data-by")),
                e._filterPosts(),
                i.hideItem(e.getItems()),
                i.reset(e.getFilteredItems()),
                e.layout(),
                e.config.postsContainer.IsoLayzrInitialisation(),
                b(),
                p();
            }
          },
          h = new bc(g);
        switch (c.attr("data-pagination-mode")) {
          case "load-more":
            var i = new ac({
              loadMoreButtonClass: "act button-load-more",
              loadMoreButtonLabel: dtLocal.moreButtonText.loadMore,
              postLimit: c.attr("data-post-limit"),
              curPage: 0,
              items: h.getFilteredItems(),
              paginatorContainer: c.find(".paginator"),
              onPaginate: function(a, b) {
                a.preventDefault();
                var c = a.data.self;
                c.setCurPage(c.getCurPage() + 1),
                  c._filterByCurPage(),
                  h.layout(),
                  b || c.appendControls(),
                  c.config.items.filter(".visible").IsoLayzrJqInitialisation(),
                  p();
              }
            });
            break;
          case "pages":
            var i = new _b({
              previousButtonClass: "nav-prev",
              previousButtonLabel:
                '<i class="dt-icon-the7-arrow-0-42" aria-hidden="true"></i>',
              nextButtonClass: "nav-next",
              nextButtonLabel:
                '<i class="dt-icon-the7-arrow-0-41" aria-hidden="true"></i>',
              postLimit: c.attr("data-post-limit"),
              curPage: 1,
              pagesToShow: c.hasClass("show-all-pages") ? 999 : 5,
              items: h.getFilteredItems(),
              paginatorContainer: c.find(".paginator"),
              onPaginate: function(b, c) {
                b.preventDefault();
                var d = a(this),
                  e = b.data.self;
                e._setAsActive(d),
                  e.setCurPage(d.attr("data-page-num")),
                  e._filterByCurPage(),
                  h.layout(),
                  c || (e.appendControls(), h.scrollToTopOfContainer()),
                  e.config.items.filter(".visible").IsoLayzrJqInitialisation(),
                  p();
              }
            });
            break;
          default:
            var i = new $b();
        }
        v.on("scroll", function() {
          b();
        }),
          b();
      }),
      "undefined" != typeof C && (a.fn.owlCarousel = C);
  });
