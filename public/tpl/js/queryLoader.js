var QueryLoader = {
	overlay: "",
	loadBar: "",
	preloader: "",
	items: new Array(),
	doneStatus: 0,
	doneNow: 0,
	selectorPreload: "body",
	ieLoadFixTime: 2000,
	ieTimeout: "",
		
	init: function() {
		if (QueryLoader.selectorPreload == "body") {
			QueryLoader.spawnLoader();
			QueryLoader.getImages(QueryLoader.selectorPreload);
			QueryLoader.createPreloading();
		}
	},
	
	imgCallback: function() {
		QueryLoader.doneNow++;
		QueryLoader.animateLoader();
	},
	
	getImages: function(selector) {
		$(selector).find("*:not(script)").each(function() {
			if($(this).closest('#children-block').length > 0) return;
			var url = "";

            if ($(this).css("background-image") != "none") {
                var url = $(this).css("background-image");
            } else if (typeof($(this).attr("src")) != "undefined") {
                var url = $(this).attr("src");
            }
                url = url.replace("url(\"", "");
                url = url.replace("url(", "");
                url = url.replace("\")", "");
                url = url.replace(")", "");

                if (url.length > 0) {
                	QueryLoader.items.push(url);
                }
                });
	},
	
	createPreloading: function() {
		QueryLoader.preloader = $("<div></div>").appendTo(QueryLoader.selectorPreload);
		$(QueryLoader.preloader).css({
			height: 	"0px",
			width:		"0px",
			overflow:	"hidden"
		});
		
		var length = QueryLoader.items.length; 
		QueryLoader.doneStatus = length;
		
		for (var i = 0; i < length; i++) {
			var imgLoad = $("<img></img>");
			$(imgLoad).attr("src", QueryLoader.items[i]);
			$(imgLoad).unbind("load");
			$(imgLoad).bind("load", function() {
				QueryLoader.imgCallback();
			});
			$(imgLoad).appendTo($(QueryLoader.preloader));
		}
	},

	spawnLoader: function() {
                //QueryLoader.overlay = $('.QOverlay');
                //QueryLoader.loadBar = $('#QLoader');
	},
	
	animateLoader: function() {
                var perc = (100 / QueryLoader.doneStatus) * QueryLoader.doneNow;

                if (perc > 99) {
                    QueryLoader.doneLoad();
                }
        },
	
    doneLoad: function() {
        setTimeout(function() {
            $('#bg').hide();
            loader.hide();
        }, 10);

        setTimeout(function() {
            $('#loader').hide();

            if ($('.menu-list-item').length > 0) {
                $.checkMenu();
            }

            if ($('.news-list-item').length > 0) {
                $.checkNews();
            }

            if ($('.promotion-content').length > 0) {
                $.checkTilDate();
            }

            setTimeout(function() {
                $('#zone-map').append('<iframe src="https://www.google.com/maps/d/embed?mid=1DTbICqTMe8-f9mbUUtMOn037mZU" width="100%" height="250"></iframe>');
            }, 1500);
        }, 800);

        $(QueryLoader.preloader).remove();
    }
}