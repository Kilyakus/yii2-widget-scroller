window.PS_WIDGETElementDataStore = {};
window.PS_WIDGETElementDataStoreID = 0;

var PS_WIDGET = function() {

    var breakpoints = {
        sm: 544,
        md: 768,
        lg: 1024,
        xl: 1200
    };

    return {

        init: function(options) {
            if (options && options.breakpoints) {
                breakpoints = options.breakpoints;
            }
        },

        getViewPort: function() {
            var e = window,
                a = 'inner';
            if (!('innerWidth' in window)) {
                a = 'client';
                e = document.documentElement || document.body;
            }

            return {
                width: e[a + 'Width'],
                height: e[a + 'Height']
            };
        },

        isInResponsiveRange: function(mode) {
            var breakpoint = this.getViewPort().width;

            if (mode == 'general') {
                return true;
            } else if (mode == 'desktop' && breakpoint >= (this.getBreakpoint('lg') + 1)) {
                return true;
            } else if (mode == 'tablet' && (breakpoint >= (this.getBreakpoint('md') + 1) && breakpoint < this.getBreakpoint('lg'))) {
                return true;
            } else if (mode == 'mobile' && breakpoint <= this.getBreakpoint('md')) {
                return true;
            } else if (mode == 'desktop-and-tablet' && breakpoint >= (this.getBreakpoint('md') + 1)) {
                return true;
            } else if (mode == 'tablet-and-mobile' && breakpoint <= this.getBreakpoint('lg')) {
                return true;
            } else if (mode == 'minimal-desktop-and-below' && breakpoint <= this.getBreakpoint('xl')) {
                return true;
            }

            return false;
        },

        getBreakpoint: function(mode) {
            return breakpoints[mode];
        },

        get: function(query) {
            var el;

            if (query === document) {
                return document;
            }

            if (!!(query && query.nodeType === 1)) {
                return query;
            }

            if (el = document.getElementById(query)) {
                return el;
            } else if (el = document.getElementsByTagName(query)) {
                return el[0];
            } else if (el = document.getElementsByClassName(query)) {
                return el[0];
            } else {
                return null;
            }
        },

        remove: function(el) {
            if (el && el.parentNode) {
                el.parentNode.removeChild(el);
            }
        },

        data: function(element) {
            element = PS_WIDGET.get(element);

            return {
                set: function(name, data) {
                    if (element === undefined) {
                        return;
                    }

                    if (element.customDataTag === undefined) {
                        PS_WIDGETElementDataStoreID++;
                        element.customDataTag = PS_WIDGETElementDataStoreID;
                    }

                    if (PS_WIDGETElementDataStore[element.customDataTag] === undefined) {
                        PS_WIDGETElementDataStore[element.customDataTag] = {};
                    }

                    PS_WIDGETElementDataStore[element.customDataTag][name] = data;
                },

                get: function(name) {
                    if (element === undefined) {
                        return;
                    }

                    if (element.customDataTag === undefined) { 
                        return null;
                    }

                    return this.has(name) ? PS_WIDGETElementDataStore[element.customDataTag][name] : null;
                },

                has: function(name) {
                    if (element === undefined) {
                        return false;
                    }
                    
                    if (element.customDataTag === undefined) { 
                        return false;
                    }

                    return (PS_WIDGETElementDataStore[element.customDataTag] && PS_WIDGETElementDataStore[element.customDataTag][name]) ? true : false;
                },

                remove: function(name) {
                    if (element && this.has(name)) {
                        delete PS_WIDGETElementDataStore[element.customDataTag][name];
                    }
                }
            };
        },

        height: function(el) {
            return PS_WIDGET.css(el, 'height');
        },

        attr: function(el, name, value) {
            el = PS_WIDGET.get(el);

            if (el == undefined) {
                return;
            }

            if (value !== undefined) {
                el.setAttribute(name, value);
            } else {
                return el.getAttribute(name);
            }
        },

        css: function(el, styleProp, value) {
            el = PS_WIDGET.get(el);

            if (!el) {
                return;
            }

            if (value !== undefined) {
                el.style[styleProp] = value;
            } else {
                var value, defaultView = (el.ownerDocument || document).defaultView;

                if (defaultView && defaultView.getComputedStyle) {
                    styleProp = styleProp.replace(/([A-Z])/g, "-$1").toLowerCase();
                    return defaultView.getComputedStyle(el, null).getPropertyValue(styleProp);
                } else if (el.currentStyle) {
                    styleProp = styleProp.replace(/\-(\w)/g, function(str, letter) {
                        return letter.toUpperCase();
                    });
                    value = el.currentStyle[styleProp];
                    if (/^\d+(em|pt|%|ex)?$/i.test(value)) {
                        return (function(value) {
                            var oldLeft = el.style.left,
                                oldRsLeft = el.runtimeStyle.left;
                            el.runtimeStyle.left = el.currentStyle.left;
                            el.style.left = value || 0;
                            value = el.style.pixelLeft + "px";
                            el.style.left = oldLeft;
                            el.runtimeStyle.left = oldRsLeft;
                            return value;
                        })(value);
                    }
                    return value;
                }
            }
        },

        ready: function(callback) {
            if (document.attachEvent ? document.readyState === "complete" : document.readyState !== "loading") {
                callback();
            } else {
                document.addEventListener('DOMContentLoaded', callback);
            }
        },

        scrollInit: function(element, options) {
            if(!element) return;
            function init() {
                var ps;
                var height;

                if (options.height instanceof Function) {
                    height = options.height.call();
                } else {
                    height = options.height;
                }

                if ((options.mobileNativeScroll || options.disableForMobile) && PS_WIDGET.isInResponsiveRange('tablet-and-mobile')) {
                    if (ps = PS_WIDGET.data(element).get('ps')) {
                        if (options.resetHeightOnDestroy) {
                            PS_WIDGET.css(element, 'height', 'auto');
                        } else {
                            PS_WIDGET.css(element, 'overflow', 'auto');
                            if (height > 0) {
                                PS_WIDGET.css(element, 'height', height);
                            }
                        }

                        ps.destroy();
                        ps = PS_WIDGET.data(element).remove('ps');
                    } else if (height > 0){
                        PS_WIDGET.css(element, 'overflow', 'auto');
                        PS_WIDGET.css(element, 'height', height + (typeof height === "string" || height instanceof String) ? 'px' : '');
                    }

                    return;
                }

                if (height > 0) {
                    PS_WIDGET.css(element, 'height', height);
                }

                if (options.desktopNativeScroll) {
                    PS_WIDGET.css(element, 'overflow', 'auto');
                    return;
                }
                
                PS_WIDGET.css(element, 'overflow', 'hidden');

                if (ps = PS_WIDGET.data(element).get('ps')) {
                    ps.update();
                } else {
                    ps = new PerfectScrollbar(element, {
                        wheelSpeed: 0.5,
                        swipeEasing: true,
                        wheelPropagation: (options.windowScroll === false ? false : true),
                        minScrollbarLength: 40,
                        maxScrollbarLength: 300, 
                        suppressScrollX: PS_WIDGET.attr(element, 'data-scroll-x') != 'true' ? true : false
                    });

                    PS_WIDGET.data(element).set('ps', ps);
                }

                var uid = PS_WIDGET.attr(element, 'id');

                if (options.rememberPosition === true && Cookies && uid) {
                    if (Cookies.get(uid)) {
                        var pos = parseInt(Cookies.get(uid));

                        if (pos > 0) {
                            element.scrollTop = pos;
                        }
                    } 

                    element.addEventListener('ps-scroll-y', function() {
                        Cookies.set(uid, element.scrollTop);
                    });                                      
                }
            }

            // Init
            init();
        },
    }
}();

PS_WIDGET.ready(function() {
    PS_WIDGET.init();
});