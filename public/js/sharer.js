// https://ellisonleao.github.io/sharer.js/
(function (g, r) {
  "use strict";
  var s = function (t) {
    this.elem = t;
  };
  s.init = function () {
    var t = r.querySelectorAll("[data-sharer]"),
      e,
      a = t.length;
    for (e = 0; e < a; e++) {
      t[e].addEventListener("click", s.add);
    }
  };
  s.add = function (t) {
    var e = t.currentTarget || t.srcElement;
    var a = new s(e);
    a.share();
  };
  s.prototype = {
    constructor: s,
    getValue: function (t) {
      var e = this.elem.getAttribute("data-" + t);
      if (e && t === "hashtag") {
        if (!e.startsWith("#")) {
          e = "#" + e;
        }
      }
      return e;
    },
    // https://www.linkedin.com/shareArticle?mini=true&amp;url=
    share: function () {
      var t = this.getValue("sharer").toLowerCase(),
        e = {
          facebook: {
            shareUrl: "https://www.facebook.com/sharer/sharer.php",
            params: {
              u: this.getValue("url"),
              hashtag: this.getValue("hashtag"),
            },
          },
          instagram: {
            shareUrl: "https://www.instagram.com",
            params: {
              url: this.getValue("url"),
              hashtag: this.getValue("hashtag"),
            },
          },
          linkedin: {
            shareUrl: "https://www.linkedin.com/sharing/share-offsite/",
            params: { url: this.getValue("url"), mini: true },
          },
          twitter: {
            shareUrl: "https://twitter.com/intent/tweet/",
            params: {
              text: this.getValue("title"),
              url: this.getValue("url"),
              hashtags: this.getValue("hashtags"),
              via: this.getValue("via"),
            },
          },
          email: {
            shareUrl: "mailto:",
            params: {
              subject: this.getValue("subject"),
              body: this.getValue("title") + "\n" + this.getValue("url"),
            },
            isLink: true,
          },
          whatsapp: {
            shareUrl:
              this.getValue("web") !== null
                ? "https://api.whatsapp.com/send"
                : "https://wa.me/",
            params: {
              text: this.getValue("title") + " " + this.getValue("url"),
            },
            isLink: true,
          },
        },
        a = e[t];
      if (a) {
        a.width = this.getValue("width");
        a.height = this.getValue("height");
      }
      return a !== undefined ? this.urlSharer(a) : false;
    },
    urlSharer: function (t) {
      var e = t.params || {},
        a = Object.keys(e),
        r,
        s = a.length > 0 ? "?" : "";
      for (r = 0; r < a.length; r++) {
        if (s !== "?") {
          s += "&";
        }
        if (e[a[r]]) {
          s += a[r] + "=" + encodeURIComponent(e[a[r]]);
        }
      }
      t.shareUrl += s;
      if (!t.isLink) {
        var l = t.width || 600,
          i = t.height || 480,
          h = g.innerWidth / 2 - l / 2 + g.screenX,
          u = g.innerHeight / 2 - i / 2 + g.screenY,
          o =
            "scrollbars=no, width=" +
            l +
            ", height=" +
            i +
            ", top=" +
            u +
            ", left=" +
            h,
          p = g.open(t.shareUrl, "", o);
        if (g.focus) {
          p.focus();
        }
      } else {
        g.location.href = t.shareUrl;
      }
    },
  };
  if (r.readyState === "complete" || r.readyState !== "loading") {
    s.init();
  } else {
    r.addEventListener("DOMContentLoaded", s.init);
  }
  g.Sharer = s;
})(window, document);
