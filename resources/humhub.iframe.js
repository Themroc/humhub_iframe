humhub.module('iframe', function(module, require, $) {
	var init= function() {
		$(window).on("resize", function (e) { humhub.modules.iframe.resize() });
		setTimeout(function (e) { humhub.modules.iframe.resize() }, 100);
		tick();
	};

	var frame= function () {
		var fr= RegExp('frame=' + '(.+?)(&|$)').exec(window.location.href);

		return fr!=null ? fr[1] : '';
	}

	var tick= function () {
		var fe= $(".iframe-frame");
		if (fe.length) {
			var uframe= humhub.modules.iframe.frame();
			var hframe= jQuery.data(fe[0], "humhub.iframe.frame");
			if (uframe != hframe) {
				jQuery.data(fe[0], "humhub.iframe.frame", uframe);
				humhub.modules.iframe.resize();
			}
		}
		setTimeout(function (e) { humhub.modules.iframe.tick() }, 100);
	}

	var resize= function () {
		var fe= $(".iframe-frame");
		if (fe.length) {
			var cfg= humhub.modules.iframe.config;
			var frame= humhub.modules.iframe.frame();
			var height= $(window).height();
			var top= 0;
			top+= 1 * $("#topbar-first").css("height").match(/[0-9]+/);
			top+= 1 * $("#topbar-second").css("height").match(/[0-9]+/);
			if (cfg[frame]!=1) {
				top+= 25;
				height-= 25;
			}
			height-= top;
			$("body").css("padding-top", top + "px");
			fe.css("height", (height-5) + "px");
		}
	}

	module.export({
		init: init,
		frame: frame,
		tick: tick,
		resize: resize,
	});
});
