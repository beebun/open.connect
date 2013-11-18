/*

 jQuery ajaxProgress Plugin v0.5.0
 Requires jQuery v1.5.0 or later

 http://www.kpozin.net/ajaxprogress

 (c) 2011, Konstantin Pozin. Licensed under MIT license.
*/
(function(a){if(a.support.ajaxProgress="onprogress"in a.ajaxSettings.xhr()){a.fn.ajaxProgress=function(a){return this.bind("ajaxProgress",a)};a("html").bind("ajaxSend.ajaxprogress",function(a,b,d){d.__jqXHR=b});var e=a.ajaxSettings.xhr.bind(a.ajaxSettings);a.ajaxSetup({xhr:function(){var c=this,b=e();b&&b.addEventListener("progress",function(b){c.global&&a.event.trigger("ajaxProgress",[b,c.__jqXHR]);typeof c.progress==="function"&&c.progress(c.__jqXHR,b)});return b}})}})(jQuery);