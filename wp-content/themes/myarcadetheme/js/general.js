/* * Picker v3.1.2 - 2014-11-25 * A jQuery plugin for replacing default checkboxes and radios. Part of the formstone library. * http://formstone.it/picker/ * * Copyright 2014 Ben Plum; MIT Licensed */
!function(a){"use strict";function b(b){b=a.extend({},k,b);for(var d=a(this),e=0,f=d.length;f>e;e++)c(d.eq(e),b);return d}function c(b,c){if(!b.data("picker")){c=a.extend({},c,b.data("picker-options"));var f=b.closest("label"),j=f.length?f.eq(0):a("label[for="+b.attr("id")+"]"),k=b.attr("type"),l="picker-"+("radio"===k?"radio":"checkbox"),m=b.attr("name"),n='<div class="picker-handle"><div class="picker-flag" /></div>';c.toggle&&(l+=" picker-toggle",n='<span class="picker-toggle-label on">'+c.labels.on+'</span><span class="picker-toggle-label off">'+c.labels.off+"</span>"+n),b.addClass("picker-element"),j.length?j.wrap('<div class="picker '+l+" "+c.customClass+'" />').before(n).addClass("picker-label"):b.before('<div class="picker '+l+" "+c.customClass+'">'+n+"</div>");var o=j.length?j.parents(".picker"):b.prev(".picker"),p=o.find(".picker-handle"),q=o.find(".picker-toggle-label");b.is(":checked")&&o.addClass("checked"),b.is(":disabled")&&o.addClass("disabled");var r=a.extend({},c,{$picker:o,$input:b,$handle:p,$label:j,$labels:q,group:m,isRadio:"radio"===k,isCheckbox:"checkbox"===k});r.$input.on("focus.picker",r,h).on("blur.picker",r,i).on("change.picker",r,e).on("click.picker",r,d).on("deselect.picker",r,g).data("picker",r),r.$picker.on("click.picker",r,d)}}function d(b){b.stopPropagation();var c=b.data;a(b.target).is(c.$input)||(b.preventDefault(),c.$input.trigger("click"))}function e(a){var b=a.data;if(!b.$input.is(":disabled")){var c=b.$input.is(":checked");b.isCheckbox?c?f(a,!0):g(a,!0):(c||j&&!c)&&f(a)}}function f(b){var c=b.data;"undefined"!=typeof c.group&&c.isRadio&&a('input[name="'+c.group+'"]').not(c.$input).trigger("deselect"),c.$picker.addClass("checked")}function g(a){var b=a.data;b.$picker.removeClass("checked")}function h(a){a.data.$picker.addClass("focus")}function i(a){a.data.$picker.removeClass("focus")}var j=document.all&&document.querySelector&&!document.addEventListener,k={customClass:"",toggle:!1,labels:{on:"ON",off:"OFF"}},l={defaults:function(b){return k=a.extend(k,b||{}),"object"==typeof this?a(this):!0},destroy:function(){return a(this).each(function(b,c){var d=a(c).data("picker");d&&(d.$picker.off(".picker"),d.$handle.remove(),d.$labels.remove(),d.$input.off(".picker").removeClass("picker-element").data("picker",null),d.$label.removeClass("picker-label").unwrap())})},disable:function(){return a(this).each(function(b,c){var d=a(c).data("picker");d&&(d.$input.prop("disabled",!0),d.$picker.addClass("disabled"))})},enable:function(){return a(this).each(function(b,c){var d=a(c).data("picker");d&&(d.$input.prop("disabled",!1),d.$picker.removeClass("disabled"))})},update:function(){return a(this).each(function(b,c){var d=a(c).data("picker");d&&!d.$input.is(":disabled")&&(d.$input.is(":checked")?f({data:d},!0):g({data:d},!0))})}};a.fn.picker=function(a){return l[a]?l[a].apply(this,Array.prototype.slice.call(arguments,1)):"object"!=typeof a&&a?this:b.apply(this,arguments)},a.picker=function(a){"defaults"===a&&l.defaults.apply(this,Array.prototype.slice.call(arguments,1))}}(jQuery);/*js*/jQuery(document).ready(function($){$("input[type=radio], input[type=checkbox]").picker();});
/*  * Selecter v3.2.3 - 2014-10-24  * A jQuery plugin for replacing default select elements. Part of the Formstone Library.  * http://formstone.it/selecter/  *  * Copyright 2014 Ben Plum; MIT Licensed */
!function(a,b){"use strict";function c(b){b=a.extend({},D,b||{}),null===C&&(C=a("body"));for(var c=a(this),e=0,f=c.length;f>e;e++)d(c.eq(e),b);return c}function d(b,c){if(!b.hasClass("selecter-element")){c=a.extend({},c,b.data("selecter-options")),c.multiple=b.prop("multiple"),c.disabled=b.is(":disabled"),c.external&&(c.links=!0);var d=b.find("[selected]").not(":disabled"),g=b.find("option").index(d);c.multiple||""===c.label?c.label="":(b.prepend('<option value="" class="selecter-placeholder" selected>'+c.label+"</option>"),g>-1&&g++);var h=b.find("option, optgroup"),j=h.filter("option");d.length||(d=j.eq(0));var k=g>-1?g:0,q=""!==c.label?c.label:d.text(),s="div";c.tabIndex=b[0].tabIndex,b[0].tabIndex=-1;var t="",u="";u+="<"+s+' class="selecter '+c.customClass,A?u+=" mobile":c.cover&&(u+=" cover"),u+=c.multiple?" multiple":" closed",c.disabled&&(u+=" disabled"),u+='" tabindex="'+c.tabIndex+'">',u+="</"+s+">",c.multiple||(t+='<span class="selecter-selected">',t+=a("<span></span>").text(v(q,c.trim)).html(),t+="</span>"),t+='<div class="selecter-options">',t+="</div>",b.addClass("selecter-element").wrap(u).after(t);var w=b.parent(".selecter"),y=a.extend({$select:b,$allOptions:h,$options:j,$selecter:w,$selected:w.find(".selecter-selected"),$itemsWrapper:w.find(".selecter-options"),index:-1,guid:x++},c);e(y),y.multiple||r(k,y),void 0!==a.fn.scroller&&y.$itemsWrapper.scroller(),y.$selecter.on("touchstart.selecter",".selecter-selected",y,f).on("click.selecter",".selecter-selected",y,i).on("click.selecter",".selecter-item",y,m).on("close.selecter",y,l).data("selecter",y),y.$select.on("change.selecter",y,n),A||(y.$selecter.on("focusin.selecter",y,o).on("blur.selecter",y,p),y.$select.on("focusin.selecter",y,function(a){a.data.$selecter.trigger("focus")}))}}function e(b){for(var c="",d=b.links?"a":"span",e=0,f=0,g=b.$allOptions.length;g>f;f++){var h=b.$allOptions.eq(f);if("OPTGROUP"===h[0].tagName)c+='<span class="selecter-group',h.is(":disabled")&&(c+=" disabled"),c+='">'+h.attr("label")+"</span>";else{var i=h.val();h.attr("value")||h.attr("value",i),c+="<"+d+' class="selecter-item',h.hasClass("selecter-placeholder")&&(c+=" placeholder"),h.is(":selected")&&(c+=" selected"),h.is(":disabled")&&(c+=" disabled"),c+='" ',c+=b.links?'href="'+i+'"':'data-value="'+i+'"',c+=">"+a("<span></span>").text(v(h.text(),b.trim)).html()+"</"+d+">",e++}}b.$itemsWrapper.html(c),b.$items=b.$selecter.find(".selecter-item")}function f(a){a.stopPropagation();var b=a.data;b.touchStartEvent=a.originalEvent,b.touchStartX=b.touchStartEvent.touches[0].clientX,b.touchStartY=b.touchStartEvent.touches[0].clientY,b.$selecter.on("touchmove.selecter",".selecter-selected",b,g).on("touchend.selecter",".selecter-selected",b,h)}function g(a){var b=a.data,c=a.originalEvent;(Math.abs(c.touches[0].clientX-b.touchStartX)>10||Math.abs(c.touches[0].clientY-b.touchStartY)>10)&&b.$selecter.off("touchmove.selecter touchend.selecter")}function h(a){var b=a.data;b.touchStartEvent.preventDefault(),b.$selecter.off("touchmove.selecter touchend.selecter"),i(a)}function i(c){c.preventDefault(),c.stopPropagation();var d=c.data;if(!d.$select.is(":disabled"))if(a(".selecter").not(d.$selecter).trigger("close.selecter",[d]),d.mobile||!A||B)d.$selecter.hasClass("closed")?j(c):d.$selecter.hasClass("open")&&l(c);else{var e=d.$select[0];if(b.document.createEvent){var f=b.document.createEvent("MouseEvents");f.initMouseEvent("mousedown",!1,!0,b,0,0,0,0,0,!1,!1,!1,!1,0,null),e.dispatchEvent(f)}else e.fireEvent&&e.fireEvent("onmousedown")}}function j(a){a.preventDefault(),a.stopPropagation();var b=a.data;if(!b.$selecter.hasClass("open")){{var c=b.$selecter.offset(),d=C.outerHeight(),e=b.$itemsWrapper.outerHeight(!0);b.index>=0?b.$items.eq(b.index).position():{left:0,top:0}}c.top+e>d&&b.$selecter.addClass("bottom"),b.$itemsWrapper.show(),b.$selecter.removeClass("closed").addClass("open"),C.on("click.selecter-"+b.guid,":not(.selecter-options)",b,k),s(b)}}function k(b){b.preventDefault(),b.stopPropagation(),0===a(b.currentTarget).parents(".selecter").length&&l(b)}function l(a){a.preventDefault(),a.stopPropagation();var b=a.data;b.$selecter.hasClass("open")&&(b.$itemsWrapper.hide(),b.$selecter.removeClass("open bottom").addClass("closed"),C.off(".selecter-"+b.guid))}function m(b){b.preventDefault(),b.stopPropagation();var c=a(this),d=b.data;if(!d.$select.is(":disabled")){if(d.$itemsWrapper.is(":visible")){var e=d.$items.index(c);e!==d.index&&(r(e,d),t(d))}d.multiple||l(b)}}function n(b,c){var d=a(this),e=b.data;if(!c&&!e.multiple){var f=e.$options.index(e.$options.filter("[value='"+w(d.val())+"']"));r(f,e),t(e)}}function o(b){b.preventDefault(),b.stopPropagation();var c=b.data;c.$select.is(":disabled")||c.multiple||(c.$selecter.addClass("focus").on("keydown.selecter-"+c.guid,c,q),a(".selecter").not(c.$selecter).trigger("close.selecter",[c]))}function p(b){b.preventDefault(),b.stopPropagation();var c=b.data;c.$selecter.removeClass("focus").off("keydown.selecter-"+c.guid),a(".selecter").not(c.$selecter).trigger("close.selecter",[c])}function q(b){var c=b.data;if(13===b.keyCode)c.$selecter.hasClass("open")&&(l(b),r(c.index,c)),t(c);else if(!(9===b.keyCode||b.metaKey||b.altKey||b.ctrlKey||b.shiftKey)){b.preventDefault(),b.stopPropagation();var d=c.$items.length-1,e=c.index<0?0:c.index;if(a.inArray(b.keyCode,z?[38,40,37,39]:[38,40])>-1)e+=38===b.keyCode||z&&37===b.keyCode?-1:1,0>e&&(e=0),e>d&&(e=d);else{var f,g,h=String.fromCharCode(b.keyCode).toUpperCase();for(g=c.index+1;d>=g;g++)if(f=c.$options.eq(g).text().charAt(0).toUpperCase(),f===h){e=g;break}if(0>e||e===c.index)for(g=0;d>=g;g++)if(f=c.$options.eq(g).text().charAt(0).toUpperCase(),f===h){e=g;break}}e>=0&&(r(e,c),s(c))}}function r(a,b){var c=b.$items.eq(a),d=c.hasClass("selected"),e=c.hasClass("disabled");if(!e)if(b.multiple)d?(b.$options.eq(a).prop("selected",null),c.removeClass("selected")):(b.$options.eq(a).prop("selected",!0),c.addClass("selected"));else if(a>-1&&a<b.$items.length){{var f=c.html();c.data("value")}b.$selected.html(f).removeClass("placeholder"),b.$items.filter(".selected").removeClass("selected"),b.$select[0].selectedIndex=a,c.addClass("selected"),b.index=a}else""!==b.label&&b.$selected.html(b.label)}function s(b){var c=b.$items.eq(b.index),d=b.index>=0&&!c.hasClass("placeholder")?c.position():{left:0,top:0};void 0!==a.fn.scroller?b.$itemsWrapper.scroller("scroll",b.$itemsWrapper.find(".scroller-content").scrollTop()+d.top,0).scroller("reset"):b.$itemsWrapper.scrollTop(b.$itemsWrapper.scrollTop()+d.top)}function t(a){a.links?u(a):(a.callback.call(a.$selecter,a.$select.val(),a.index),a.$select.trigger("change",[!0]))}function u(a){var c=a.$select.val();a.external?b.open(c):b.location.href=c}function v(a,b){return 0===b?a:a.length>b?a.substring(0,b)+"...":a}function w(a){return"string"==typeof a?a.replace(/([;&,\.\+\*\~':"\!\^#$%@\[\]\(\)=>\|])/g,"\\$1"):a}var x=0,y=b.navigator.userAgent||b.navigator.vendor||b.opera,z=/Firefox/i.test(y),A=/Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(y),B=z&&A,C=null,D={callback:a.noop,cover:!1,customClass:"",label:"",external:!1,links:!1,mobile:!0,trim:0},E={defaults:function(b){return D=a.extend(D,b||{}),a(this)},disable:function(b){return a(this).each(function(c,d){var e=a(d).parent(".selecter").data("selecter");if(e)if("undefined"!=typeof b){var f=e.$items.index(e.$items.filter("[data-value="+b+"]"));e.$items.eq(f).addClass("disabled"),e.$options.eq(f).prop("disabled",!0)}else e.$selecter.hasClass("open")&&e.$selecter.find(".selecter-selected").trigger("click.selecter"),e.$selecter.addClass("disabled"),e.$select.prop("disabled",!0)})},destroy:function(){return a(this).each(function(b,c){var d=a(c).parent(".selecter").data("selecter");d&&(d.$selecter.hasClass("open")&&d.$selecter.find(".selecter-selected").trigger("click.selecter"),void 0!==a.fn.scroller&&d.$selecter.find(".selecter-options").scroller("destroy"),d.$select[0].tabIndex=d.tabIndex,d.$select.find(".selecter-placeholder").remove(),d.$selected.remove(),d.$itemsWrapper.remove(),d.$selecter.off(".selecter"),d.$select.off(".selecter").removeClass("selecter-element").show().unwrap())})},enable:function(b){return a(this).each(function(c,d){var e=a(d).parent(".selecter").data("selecter");if(e)if("undefined"!=typeof b){var f=e.$items.index(e.$items.filter("[data-value="+b+"]"));e.$items.eq(f).removeClass("disabled"),e.$options.eq(f).prop("disabled",!1)}else e.$selecter.removeClass("disabled"),e.$select.prop("disabled",!1)})},refresh:function(){return E.update.apply(a(this))},update:function(){return a(this).each(function(b,c){var d=a(c).parent(".selecter").data("selecter");if(d){var f=d.index;d.$allOptions=d.$select.find("option, optgroup"),d.$options=d.$allOptions.filter("option"),d.index=-1,f=d.$options.index(d.$options.filter(":selected")),e(d),d.multiple||r(f,d)}})}};a.fn.selecter=function(a){return E[a]?E[a].apply(this,Array.prototype.slice.call(arguments,1)):"object"!=typeof a&&a?this:c.apply(this,arguments)},a.selecter=function(a){"defaults"===a&&E.defaults.apply(this,Array.prototype.slice.call(arguments,1))}}(jQuery,window);/*js*/jQuery(document).ready(function($){$("select").selecter({customClass:"mt-slct"});});
/*!* Bootstrap v3.3.1 (http://getbootstrap.com)* Copyright 2011-2014 Twitter, Inc.* Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)*//*!* Generated using the BootstrapCustomizer (http://getbootstrap.com/customize/?id=758e5178290c8f72f3e0)* Config saved to config.json and https://gist.github.com/758e5178290c8f72f3e0*/
if("undefined"==typeof jQuery)throw new Error("Bootstrap's JavaScript requires jQuery");+function(t){var e=t.fn.jquery.split(" ")[0].split(".");if(e[0]<2&&e[1]<9||1==e[0]&&9==e[1]&&e[2]<1)throw new Error("Bootstrap's JavaScript requires jQuery version 1.9.1 or higher")}(jQuery),+function(t){"use strict";function e(e){e&&3===e.which||(t(n).remove(),t(s).each(function(){var i=t(this),n=o(i),s={relatedTarget:this};n.hasClass("open")&&(n.trigger(e=t.Event("hide.bs.dropdown",s)),e.isDefaultPrevented()||(i.attr("aria-expanded","false"),n.removeClass("open").trigger("hidden.bs.dropdown",s)))}))}function o(e){var o=e.attr("data-target");o||(o=e.attr("href"),o=o&&/#[A-Za-z]/.test(o)&&o.replace(/.*(?=#[^\s]*$)/,""));var i=o&&t(o);return i&&i.length?i:e.parent()}function i(e){return this.each(function(){var o=t(this),i=o.data("bs.dropdown");i||o.data("bs.dropdown",i=new r(this)),"string"==typeof e&&i[e].call(o)})}var n=".dropdown-backdrop",s='[data-toggle="dropdown"]',r=function(e){t(e).on("click.bs.dropdown",this.toggle)};r.VERSION="3.3.1",r.prototype.toggle=function(i){var n=t(this);if(!n.is(".disabled, :disabled")){var s=o(n),r=s.hasClass("open");if(e(),!r){"ontouchstart"in document.documentElement&&!s.closest(".navbar-nav").length&&t('<div class="dropdown-backdrop"/>').insertAfter(t(this)).on("click",e);var a={relatedTarget:this};if(s.trigger(i=t.Event("show.bs.dropdown",a)),i.isDefaultPrevented())return;n.trigger("focus").attr("aria-expanded","true"),s.toggleClass("open").trigger("shown.bs.dropdown",a)}return!1}},r.prototype.keydown=function(e){if(/(38|40|27|32)/.test(e.which)&&!/input|textarea/i.test(e.target.tagName)){var i=t(this);if(e.preventDefault(),e.stopPropagation(),!i.is(".disabled, :disabled")){var n=o(i),r=n.hasClass("open");if(!r&&27!=e.which||r&&27==e.which)return 27==e.which&&n.find(s).trigger("focus"),i.trigger("click");var a=" li:not(.divider):visible a",d=n.find('[role="menu"]'+a+', [role="listbox"]'+a);if(d.length){var h=d.index(e.target);38==e.which&&h>0&&h--,40==e.which&&h<d.length-1&&h++,~h||(h=0),d.eq(h).trigger("focus")}}}};var a=t.fn.dropdown;t.fn.dropdown=i,t.fn.dropdown.Constructor=r,t.fn.dropdown.noConflict=function(){return t.fn.dropdown=a,this},t(document).on("click.bs.dropdown.data-api",e).on("click.bs.dropdown.data-api",".dropdown form",function(t){t.stopPropagation()}).on("click.bs.dropdown.data-api",s,r.prototype.toggle).on("keydown.bs.dropdown.data-api",s,r.prototype.keydown).on("keydown.bs.dropdown.data-api",'[role="menu"]',r.prototype.keydown).on("keydown.bs.dropdown.data-api",'[role="listbox"]',r.prototype.keydown)}(jQuery),+function(t){"use strict";function e(e,i){return this.each(function(){var n=t(this),s=n.data("bs.modal"),r=t.extend({},o.DEFAULTS,n.data(),"object"==typeof e&&e);s||n.data("bs.modal",s=new o(this,r)),"string"==typeof e?s[e](i):r.show&&s.show(i)})}var o=function(e,o){this.options=o,this.$body=t(document.body),this.$element=t(e),this.$backdrop=this.isShown=null,this.scrollbarWidth=0,this.options.remote&&this.$element.find(".modal-content").load(this.options.remote,t.proxy(function(){this.$element.trigger("loaded.bs.modal")},this))};o.VERSION="3.3.1",o.TRANSITION_DURATION=300,o.BACKDROP_TRANSITION_DURATION=150,o.DEFAULTS={backdrop:!0,keyboard:!0,show:!0},o.prototype.toggle=function(t){return this.isShown?this.hide():this.show(t)},o.prototype.show=function(e){var i=this,n=t.Event("show.bs.modal",{relatedTarget:e});this.$element.trigger(n),this.isShown||n.isDefaultPrevented()||(this.isShown=!0,this.checkScrollbar(),this.setScrollbar(),this.$body.addClass("modal-open"),this.escape(),this.resize(),this.$element.on("click.dismiss.bs.modal",'[data-dismiss="modal"]',t.proxy(this.hide,this)),this.backdrop(function(){var n=t.support.transition&&i.$element.hasClass("fade");i.$element.parent().length||i.$element.appendTo(i.$body),i.$element.show().scrollTop(0),i.options.backdrop&&i.adjustBackdrop(),i.adjustDialog(),n&&i.$element[0].offsetWidth,i.$element.addClass("in").attr("aria-hidden",!1),i.enforceFocus();var s=t.Event("shown.bs.modal",{relatedTarget:e});n?i.$element.find(".modal-dialog").one("bsTransitionEnd",function(){i.$element.trigger("focus").trigger(s)}).emulateTransitionEnd(o.TRANSITION_DURATION):i.$element.trigger("focus").trigger(s)}))},o.prototype.hide=function(e){e&&e.preventDefault(),e=t.Event("hide.bs.modal"),this.$element.trigger(e),this.isShown&&!e.isDefaultPrevented()&&(this.isShown=!1,this.escape(),this.resize(),t(document).off("focusin.bs.modal"),this.$element.removeClass("in").attr("aria-hidden",!0).off("click.dismiss.bs.modal"),t.support.transition&&this.$element.hasClass("fade")?this.$element.one("bsTransitionEnd",t.proxy(this.hideModal,this)).emulateTransitionEnd(o.TRANSITION_DURATION):this.hideModal())},o.prototype.enforceFocus=function(){t(document).off("focusin.bs.modal").on("focusin.bs.modal",t.proxy(function(t){this.$element[0]===t.target||this.$element.has(t.target).length||this.$element.trigger("focus")},this))},o.prototype.escape=function(){this.isShown&&this.options.keyboard?this.$element.on("keydown.dismiss.bs.modal",t.proxy(function(t){27==t.which&&this.hide()},this)):this.isShown||this.$element.off("keydown.dismiss.bs.modal")},o.prototype.resize=function(){this.isShown?t(window).on("resize.bs.modal",t.proxy(this.handleUpdate,this)):t(window).off("resize.bs.modal")},o.prototype.hideModal=function(){var t=this;this.$element.hide(),this.backdrop(function(){t.$body.removeClass("modal-open"),t.resetAdjustments(),t.resetScrollbar(),t.$element.trigger("hidden.bs.modal")})},o.prototype.removeBackdrop=function(){this.$backdrop&&this.$backdrop.remove(),this.$backdrop=null},o.prototype.backdrop=function(e){var i=this,n=this.$element.hasClass("fade")?"fade":"";if(this.isShown&&this.options.backdrop){var s=t.support.transition&&n;if(this.$backdrop=t('<div class="modal-backdrop '+n+'" />').prependTo(this.$element).on("click.dismiss.bs.modal",t.proxy(function(t){t.target===t.currentTarget&&("static"==this.options.backdrop?this.$element[0].focus.call(this.$element[0]):this.hide.call(this))},this)),s&&this.$backdrop[0].offsetWidth,this.$backdrop.addClass("in"),!e)return;s?this.$backdrop.one("bsTransitionEnd",e).emulateTransitionEnd(o.BACKDROP_TRANSITION_DURATION):e()}else if(!this.isShown&&this.$backdrop){this.$backdrop.removeClass("in");var r=function(){i.removeBackdrop(),e&&e()};t.support.transition&&this.$element.hasClass("fade")?this.$backdrop.one("bsTransitionEnd",r).emulateTransitionEnd(o.BACKDROP_TRANSITION_DURATION):r()}else e&&e()},o.prototype.handleUpdate=function(){this.options.backdrop&&this.adjustBackdrop(),this.adjustDialog()},o.prototype.adjustBackdrop=function(){this.$backdrop.css("height",0).css("height",this.$element[0].scrollHeight)},o.prototype.adjustDialog=function(){var t=this.$element[0].scrollHeight>document.documentElement.clientHeight;this.$element.css({paddingLeft:!this.bodyIsOverflowing&&t?this.scrollbarWidth:"",paddingRight:this.bodyIsOverflowing&&!t?this.scrollbarWidth:""})},o.prototype.resetAdjustments=function(){this.$element.css({paddingLeft:"",paddingRight:""})},o.prototype.checkScrollbar=function(){this.bodyIsOverflowing=document.body.scrollHeight>document.documentElement.clientHeight,this.scrollbarWidth=this.measureScrollbar()},o.prototype.setScrollbar=function(){var t=parseInt(this.$body.css("padding-right")||0,10);this.bodyIsOverflowing&&this.$body.css("padding-right",t+this.scrollbarWidth)},o.prototype.resetScrollbar=function(){this.$body.css("padding-right","")},o.prototype.measureScrollbar=function(){var t=document.createElement("div");t.className="modal-scrollbar-measure",this.$body.append(t);var e=t.offsetWidth-t.clientWidth;return this.$body[0].removeChild(t),e};var i=t.fn.modal;t.fn.modal=e,t.fn.modal.Constructor=o,t.fn.modal.noConflict=function(){return t.fn.modal=i,this},t(document).on("click.bs.modal.data-api",'[data-toggle="modal"]',function(o){var i=t(this),n=i.attr("href"),s=t(i.attr("data-target")||n&&n.replace(/.*(?=#[^\s]+$)/,"")),r=s.data("bs.modal")?"toggle":t.extend({remote:!/#/.test(n)&&n},s.data(),i.data());i.is("a")&&o.preventDefault(),s.one("show.bs.modal",function(t){t.isDefaultPrevented()||s.one("hidden.bs.modal",function(){i.is(":visible")&&i.trigger("focus")})}),e.call(s,r,this)})}(jQuery),+function(t){"use strict";function e(){var t=document.createElement("bootstrap"),e={WebkitTransition:"webkitTransitionEnd",MozTransition:"transitionend",OTransition:"oTransitionEnd otransitionend",transition:"transitionend"};for(var o in e)if(void 0!==t.style[o])return{end:e[o]};return!1}t.fn.emulateTransitionEnd=function(e){var o=!1,i=this;t(this).one("bsTransitionEnd",function(){o=!0});var n=function(){o||t(i).trigger(t.support.transition.end)};return setTimeout(n,e),this},t(function(){t.support.transition=e(),t.support.transition&&(t.event.special.bsTransitionEnd={bindType:t.support.transition.end,delegateType:t.support.transition.end,handle:function(e){return t(e.target).is(this)?e.handleObj.handler.apply(this,arguments):void 0}})})}(jQuery);/*js*/jQuery(document).ready( function($) {$(".botn-gtop").hide();$(function(){$(window).scroll(function(){if($(this).scrollTop()>100){$('.botn-gtop').fadeIn()}else{$('.botn-gtop').fadeOut()}});$('body').delegate( '.botn-gtop', 'click', function(e){e.preventDefault();$('html,body').animate({scrollTop:0},800);});});});
/** Search Modal Focus */
jQuery(document).ready( function($) {$('#modl-srch').on('shown.bs.modal', function () {$('#s').focus();});});
/** Menu */
jQuery(document).ready(function(e){var n=!1;e(document.body).on("click","#header_magazine .menu-botn",function(n){n.preventDefault(),e(".menu > ul").toggleClass("in")}),e("#header_magazine .menu").hover(function(){n=!0},function(){n=!1}),e("body").mouseup(function(){n||e("#header_magazine .menu > ul").removeClass("in")}),e("#header_magazine .menu-item-has-children > a").click(function(n){n.preventDefault(),e(this).toggleClass("submdbact"),e(this).next().toggleClass("submdb")});var a=!1;e("#header_horizontal .menu-botn").click(function(){a?(e("#header_horizontal .menu").animate({left:"-350px"},100),a=!1):(e("#header_horizontal .cont .menu").animate({left:"0px"},100),a=!0)})});
/** Promoted games */
jQuery(document).ready(function($){$( "#friv_style_games" ).change(function() {if(MtAjax.friv_banner){$('#cntpromotedgames ul li:not(:first)').remove();}else {$('#cntpromotedgames ul li').remove();}$('#cntpromotedgames ul').before('<span id="loadingpromotedgames">'+MtAjax.loading+'</span>');$('#cntpromotedgames .wp-pagenavi').remove();var value = $('#friv_style_games option:selected').val();var url = window.location.href;$.post(MtAjax.ajaxurl, { 'action': 'myarcadetheme_ajax_action', 'location':'index', 'value': value, 'type': 'sort', 'nonce': MtAjax.nonce }, function(html){if(MtAjax.friv_banner){$('#cntpromotedgames ul li:last').after(html);}else{$('#cntpromotedgames ul').html(html);};$('#cntpromotedgames').append('<div id="mt-wp-pagenavi"></div>');$( "#mt-wp-pagenavi" ).load(url+" #cntpromotedgames .wp-pagenavi", function() {$('#loadingpromotedgames').remove();$('#cntpromotedgames .lst-gams-friv li').show();if(typeof(echo)!=='undefined'){echo.render();}});});});$( "#promoted_games" ).change(function() {var value = $('#promoted_games option:selected').val();$('#cntpromotedgames ul').html('<li id="loadingpromotedgames">'+MtAjax.loading+'</li>');$.post(MtAjax.ajaxurl, { 'action': 'myarcadetheme_ajax_action', 'location':'index', 'value': value, 'type': 'sort', 'nonce': MtAjax.nonce }, function(html){$('#cntpromotedgames > ul').html(html);$('#cntpromotedgames .lst-gams li').show();if( typeof(echo) !== 'undefined' ){echo.render();}});});
/** Register */
$(document.body).on('click', '#mt_register_theme button' ,function(e){e.preventDefault();$(this).text(MtAjax.loading);var username = $('#mt_register_theme input[name=username]').val();var email = $('#mt_register_theme input[name=email]').val();var pass = $('#mt_register_theme input[name=pass]').val();var passb = $('#mt_register_theme input[name=passb]').val();$.post(MtAjax.ajaxurl, { 'action': 'myarcadetheme_ajax_action', 'username': username, 'email': email, 'pass': pass, 'passb': passb, 'type': 'register', 'nonce': MtAjax.nonce }, function(html){$('#mt_register_theme button').text(MtAjax.register);var myArray = html.split('|');if(myArray[0]!=''){if(myArray[0]==1){$('#mt_register_theme input[name=username]').parent().removeClass('frm-ok').addClass('frm-no');}if(myArray[0]==0){$('#mt_register_theme input[name=username]').parent().removeClass('frm-no').addClass('frm-ok');}if(myArray[1]==1){$('#mt_register_theme input[name=email]').parent().removeClass('frm-ok').addClass('frm-no');}if(myArray[1]==0){$('#mt_register_theme input[name=email]').parent().removeClass('frm-no').addClass('frm-ok');}if(myArray[2]==1){$('#mt_register_theme input[name=pass],#mt_register_theme input[name=passb]').parent().removeClass('frm-ok').addClass('frm-no');}if(myArray[2]==0){$('#mt_register_theme input[name=pass],#mt_register_theme input[name=passb]').parent().removeClass('frm-no').addClass('frm-ok');}}if(myArray.length==1){$('#mt_register_theme input[name=username]').parent().removeClass('frm-no').addClass('frm-ok');$('#mt_register_theme input[name=email]').parent().removeClass('frm-no').addClass('frm-ok');$('#mt_register_theme input[name=pass],#mt_register_theme input[name=passb]').parent().removeClass('frm-no').addClass('frm-ok');$('#mt_register_theme .modl-titl').append(html);$('#mt_register_theme button').remove();}});});
/** Login */
$(document.body).on('click', '#mt_login_theme button' ,function(e){e.preventDefault();$(this).text(MtAjax.loading);var username = $('#mt_login_theme input[name=log]').val();var forever = $('#mt_login_theme input[name=rememberme]');var pass = $('#mt_login_theme input[name=pwd]').val();if(forever.is(':checked')) { var forever='forever'; }else{ var forever=0; }$.post(MtAjax.ajaxurl, { 'action': 'myarcadetheme_ajax_action', 'log': username, 'pwd': pass, rememberme: forever, 'type': 'login', 'nonce': MtAjax.nonce }, function(html){if(html==1){$('#mt_login_theme button').text(MtAjax.register);$('#mt_login_theme input[name=log],#mt_login_theme input[name=pwd]').parent().removeClass('frm-ok').addClass('frm-no');}else{$('#mt_login_theme input[name=log],#mt_login_theme input[name=pwd]').parent().removeClass('frm-no').addClass('frm-ok');$.post($( "#mt_login_theme" ).attr( "action" ), { 'log': $('#mt_login_theme input[name=log]').val(), 'pwd': $('#mt_login_theme input[name=pwd]').val(), rememberme: $('#mt_login_theme input[name=rememberme]').val(), 'user-cookie': 1 }, function(html){window.location = $('#redirect_to').val();});}});});});
jQuery(document).ready(function($) {$("#game_opts a.fa-share-alt").on("click", function(e) {e.preventDefault();});});
jQuery(document).ready(function ($) {
    $(".css-hzvvev").hover(function () {
        let thumb = this.id;
        let split = thumb.split("-");
        let id = '#pre-video-' + split[1];

        $(id).css("display", "block");
    }, function () {

        let thumb = this.id;
        let split = thumb.split("-");
        let id = '#pre-video-' + split[1];
        $(id).css("display", "none");
    });
});