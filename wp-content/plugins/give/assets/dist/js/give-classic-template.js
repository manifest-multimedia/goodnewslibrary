(()=>{var e={28483:function(e){e.exports=function(){"use strict";var e=["area","base","br","col","command","embed","hr","img","input","keygen","link","meta","param","source","track","wbr"],t=function(e){return String(e).replace(/[&<>"']/g,(function(e){return"&"+n[e]+";"}))},n={"&":"amp","<":"lt",">":"gt",'"':"quot","'":"apos"},o="dangerouslySetInnerHTML",r={className:"class",htmlFor:"for"},i={};function a(n,a){var c=[],l="";a=a||{};for(var u=arguments.length;u-- >2;)c.push(arguments[u]);if("function"==typeof n)return a.children=c.reverse(),n(a);if(n){if(l+="<"+n,a)for(var s in a)!1!==a[s]&&null!=a[s]&&s!==o&&(l+=" "+(r[s]?r[s]:t(s))+'="'+t(a[s])+'"');l+=">"}if(-1===e.indexOf(n)){if(a[o])l+=a[o].__html;else for(;c.length;){var d=c.pop();if(d)if(d.pop)for(var m=d.length;m--;)c.push(d[m]);else l+=!0===i[d]?d:t(d)}l+=n?"</"+n+">":""}return i[l]=!0,l}return a}()}},t={};function n(o){var r=t[o];if(void 0!==r)return r.exports;var i=t[o]={exports:{}};return e[o].call(i.exports,i,i.exports,n),i.exports}n.n=e=>{var t=e&&e.__esModule?()=>e.default:()=>e;return n.d(t,{a:t}),t},n.d=(e,t)=>{for(var o in t)n.o(t,o)&&!n.o(e,o)&&Object.defineProperty(e,o,{enumerable:!0,get:t[o]})},n.o=(e,t)=>Object.prototype.hasOwnProperty.call(e,t),(()=>{"use strict";var e=n(28483),t=n.n(e);function o(e,t){t.parentNode.insertBefore(e,t.nextSibling)}function r(e){null==e||e.parentNode.removeChild(e)}function i(e){var t=document.createElement("template");return e.trim(),t.innerHTML=e,t.content.firstChild}var a,c,l,u;function s(e){var t=arguments.length>1&&void 0!==arguments[1]?arguments[1]:"textContent",n=document.createElement("canvas").getContext("2d"),o=window.getComputedStyle(e),r=o.fontWeight,i=o.fontSize,a=o.fontFamily;return n.font="".concat(r," ").concat(i," ").concat(a),n.measureText(e[t]).width}var d,m,v=null===(a=document.querySelector('[name="give-fee-recovery-settings"]'))||void 0===a?void 0:a.value,p="give_fee_recovery_object"in window&&v&&(null===(c=JSON.parse(v))||void 0===c?void 0:c.fee_recovery),f="Give_Recurring_Vars"in window,y="enabled"===window.classicTemplateOptions.payment_information.donation_summary_enabled,g=(null===(l=window)||void 0===l||null===(u=l.give_cs_json_obj)||void 0===u?void 0:u.length)>20;function w(e){return function(e){if(Array.isArray(e))return _(e)}(e)||function(e){if("undefined"!=typeof Symbol&&null!=e[Symbol.iterator]||null!=e["@@iterator"])return Array.from(e)}(e)||h(e)||function(){throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}()}function b(e,t){return function(e){if(Array.isArray(e))return e}(e)||function(e,t){var n=e&&("undefined"!=typeof Symbol&&e[Symbol.iterator]||e["@@iterator"]);if(null==n)return;var o,r,i=[],a=!0,c=!1;try{for(n=n.call(e);!(a=(o=n.next()).done)&&(i.push(o.value),!t||i.length!==t);a=!0);}catch(e){c=!0,r=e}finally{try{a||null==n.return||n.return()}finally{if(c)throw r}}return i}(e,t)||h(e,t)||function(){throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}()}function h(e,t){if(e){if("string"==typeof e)return _(e,t);var n=Object.prototype.toString.call(e).slice(8,-1);return"Object"===n&&e.constructor&&(n=e.constructor.name),"Map"===n||"Set"===n?Array.from(e):"Arguments"===n||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)?_(e,t):void 0}}function _(e,t){(null==t||t>e.length)&&(t=e.length);for(var n=0,o=new Array(t);n<t;n++)o[n]=e[n];return o}function S(){classicTemplateOptions.donor_information.headline&&(document.querySelector(".give-personal-info-section legend:first-of-type").textContent=classicTemplateOptions.donor_information.headline)}function q(){classicTemplateOptions.donor_information.description&&o(i(t()("p",{className:"give-personal-info-description"},classicTemplateOptions.donor_information.description)),document.querySelector("#give_checkout_user_info legend:first-of-type"))}function T(e){var n=e.symbol,o=void 0===n?window.Give.fn.getGlobalVar("currency_sign"):n,r=e.symbolPosition,a=void 0===r?window.Give.fn.getGlobalVar("currency_pos"):r,c=e.decimalSeparator,l=void 0===c?window.Give.fn.getGlobalVar("decimal_separator"):c;document.querySelectorAll(".give-donation-level-btn:not(.give-btn-level-custom)").forEach((function(e){e.innerHTML!==("before"===a?o+e.value:e.value+o)&&function(e){var n=e.parentNode;if(!e.getAttribute("has-tooltip")){var o=i(t()("span",{className:"give-tooltip hint--top hint--bounce","aria-label":e.innerHTML}));e.innerHTML.length<50&&o.classList.add("narrow"),n.replaceChild(o,e),o.appendChild(e),e.setAttribute("has-tooltip","true")}}(e);var n=e.getAttribute("value"),r=b(n.split(l),2),c=r[0],u=r[1],s="before"===a?"".concat(o).concat(n):"".concat(n).concat(o);e.parentNode&&e.parentNode.getAttribute("aria-label")==e.getAttribute("aria-label")&&e.parentNode.setAttribute("aria-label",s),e.setAttribute("aria-label",s);var d=function(e){var n=e.position;return t()("span",{className:"give-currency-symbol-".concat(n)},o)};e.innerHTML=t()("span",{className:"give-formatted-currency","aria-hidden":!0},"before"===a&&t()(d,{position:"before"}),t()("span",{className:"give-amount-formatted"},t()("span",{className:"give-amount-without-decimals"},c),t()("span",{className:"give-amount-decimal"},u)),"after"===a&&t()(d,{position:"after"}))}))}function C(){document.querySelector('[data-tag="amount"]').innerHTML=document.querySelector("#give-amount").value}function N(){window.GiveDonationSummary.handleFees(document.querySelector(".give_fee_mode_checkbox"),jQuery(".give-form"))}"give_stripe_vars"in window&&(window.give_stripe_vars.element_font_styles={cssSrc:null===(d=document.querySelector("#give-google-font-css"))||void 0===d?void 0:d.href},Object.assign(window.give_stripe_vars.element_base_styles,{color:"#828382",fontFamily:window.getComputedStyle(document.body).fontFamily,fontWeight:400})),m=function(){var e,n,a,c,l,u,d,m;document.getElementById("give-receipt")||(document.body.classList.add("give-container-".concat(window.classicTemplateOptions.visual_appearance.container_style)),o(document.querySelector(".give-personal-info-section"),document.querySelector(".give-donation-amount-section")),document.querySelector(".give-payment-details-section").append(document.querySelector("#give_purchase_form_wrap")),o(document.querySelector(".give-donate-now-button-section"),document.querySelector(".give-payment-details-section")),classicTemplateOptions.donation_amount.description&&document.querySelector(".give-amount-heading").after(i(t()("p",{className:"give-amount-description"},classicTemplateOptions.donation_amount.description))),S(),q(),classicTemplateOptions.payment_information.headline&&(document.querySelector(".give-payment-mode-label").textContent=classicTemplateOptions.payment_information.headline),classicTemplateOptions.payment_information.description&&o(i('<p class="give-payment-mode-description">'.concat(classicTemplateOptions.payment_information.description,"</p>")),document.querySelector(".give-payment-mode-label")),function(){if(g){var e=JSON.parse(window.give_cs_json_obj).supported_currency,t=document.querySelector("input[name=give-cs-form-currency]"),n=new MutationObserver((function(t){var n=b(t,1)[0].target.value,o=e[n];T({symbol:o.symbol,decimalSeparator:o.setting.decimal_separator,precision:o.setting.number_decimals})})),o=e[t.value];T({symbol:o.symbol,decimalSeparator:o.setting.decimal_separator,precision:o.setting.number_decimals}),n.observe(t,{attributeFilter:["value"]})}else T({})}(),function(){var e;j(O()),(e=document.querySelector(".give-gateway-details")).append.apply(e,w(document.querySelectorAll("#give_purchase_form_wrap fieldset:not(.give-donation-submit)"))),r(document.querySelector("#give_purchase_form_wrap"))}(),y&&(d=document.querySelector(".give-donation-form-summary-section"),m=document.querySelector(".give-payment-details-section"),d.closest(".give-donate-now-button-section")?o(d,m):d.closest(".give-personal-info-section")&&m.parentNode.insertBefore(d,m),C()),p&&void((e=document.querySelector(".give_fee_mode_checkbox"))?(e.addEventListener("change",N),new MutationObserver(N).observe(document.querySelector(".give-fee-message-label-text"),{childList:!0})):jQuery(".js-give-donation-summary-fees").hide())&&N(),f&&((u=document.querySelector('[name="give-recurring-period"]'))&&(u.addEventListener("change",(function(e){window.GiveDonationSummary.handleDonorsChoiceRecurringFrequency(e.target,jQuery(".give-form"))})),null===(c=document.querySelector(".give-recurring-donors-choice-period"))||void 0===c||c.addEventListener("change",(function(){window.GiveDonationSummary.handleDonorsChoiceRecurringFrequency(u,jQuery(".give-form"))})),null===(l=document.querySelector('[name="give-price-id"]'))||void 0===l||l.addEventListener("change",(function(e){window.GiveDonationSummary.handleAdminDefinedRecurringFrequency(e.target,jQuery(".give-form"))})))),jQuery.ajaxPrefilter((function(e,t){e.url.includes("?payment-mode=")&&(e.beforeSend=function(){jQuery(".give-donate-now-button-section").block({message:null,overlayCSS:{background:"#fff",opacity:.6}}),r(document.querySelector(".give-gateway-details")),t.beforeSend instanceof Function&&t.beforeSend()},e.success=function(e){var n,o;t.success(e),r(document.querySelector("#give_purchase_form_wrap"));var i,a,c,l,u=O();u.innerHTML=e,(n=document.querySelector(".give-personal-info-section")).replaceChildren.apply(n,w(u.removeChild(u.querySelector(".give-personal-info-section")).children)),S(),q(),(o=document.querySelector(".give-donate-now-button-section")).replaceWith.apply(o,w(u.removeChild(u.querySelector("#give_purchase_submit")).children)),L(),y&&((i=document.querySelector(".give-donation-form-summary-section")).replaceChildren.apply(i,w(u.removeChild(u.querySelector(".give-donation-form-summary-section")).children)),window.GiveDonationSummary.initTotal(),C(),p&&N()),r(document.querySelector(".give-gateway-details")),j(u),f&&(a=jQuery(".give-form"),c=document.querySelector('[name="give-recurring-period"]'),l=document.querySelector('[name="give-price-id"]'),c&&window.GiveDonationSummary.handleDonorsChoiceRecurringFrequency(c,a),l&&window.GiveDonationSummary.handleAdminDefinedRecurringFrequency(l,a)),jQuery(".give-donate-now-button-section").unblock()})})),g&&(window.Give_Currency_Switcher.adjust_dropdown_width=function(){var e,t,n=document.querySelector(".give-cs-select-currency"),o=document.querySelector(".give-currency-symbol");n.style.setProperty("--currency-text-width",(e=s(o),t=window.getComputedStyle(document.documentElement).fontSize,"".concat(Number.parseFloat(e)/Number.parseFloat(t),"rem"))),n.style.width=null},window.Give_Currency_Switcher.adjust_dropdown_width()),f&&function(){var e=document.querySelector(".give-recurring-donors-choice-period");if(e){var t=function(){var t,n,o;e.style.setProperty("--selected-text-width",(t=s(e,"value"),n=e,o=window.getComputedStyle(n).fontSize,"".concat(Number.parseFloat(t)/Number.parseFloat(o),"em")))};document.fonts.ready.then(t),e.addEventListener("change",t)}}(),L(),(n=document.querySelector("#give_error_test_mode"))&&document.querySelector(".give-payment-mode-label").after(n),g&&(a=document.querySelector(".give-currency-switcher-msg-wrap")).parentNode.after(a),document.querySelectorAll('.give-donation-amount-section input[type="checkbox"]').forEach((function(e){return e.addEventListener("change",(function(e){e.target.parentNode.classList.toggle("checked-within")}))})))},"loading"!==document.readyState?window.setTimeout(m,0):document.addEventListener("DOMContentLoaded",m);var O=function(){return i('<div class="give-gateway-details"></div>')},j=function(e){return document.querySelector(".give-gateway-option-selected > .give-gateway-option").after(e)};function L(){"enabled"===window.classicTemplateOptions.visual_appearance.secure_badge&&document.querySelector(".give-donate-now-button-section").lastChild.after(i(t()("aside",{className:"give-secure-donation-badge-bottom"},t()("svg",{className:"give-form-secure-icon"},t()("use",{href:"#give-icon-lock"})),window.classicTemplateOptions.visual_appearance.secure_badge_text)))}window.GiveClassicTemplate={share:function(e){var t=parent.window.location.toString();return window.Give.fn.getParameterByName("giveDonationAction",t)&&(t=window.Give.fn.removeURLParameter(t,"giveDonationAction"),t=window.Give.fn.removeURLParameter(t,"payment-confirmation"),t=window.Give.fn.removeURLParameter(t,"payment-id")),e.classList.contains("facebook-btn")?window.Give.share.fn.facebook(t):e.classList.contains("twitter-btn")&&window.Give.share.fn.twitter(t,classicTemplateOptions.donation_receipt.twitter_message),!1}}})()})();