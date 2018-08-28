$(document).ready( function(){

			generateAllNendo();

			var menu = $(".menu");
			var menuW = menu.width();
			var menuCloseButton = $(".menuCloseButton");
			var menuOpenButton = $(".menuOpenButton");
			var profilButton = $(".getProfil");
			var listUsersButton = $(".getUsers");
			var listNendoroidsButton = $(".getNendoroids");
			var loadScreen = $('.loadScreen');
			var rangeButton = $(".rangeButton");
			var rightColumn = $(".rightColumn");
			var leftColumn = $(".leftColumn");
			var blockResponse = $(".response");
			var header = $("header");
			var headerH = $("header").height();
			var rangeButtonH = rangeButton.height();

			// rightColumn.css("display","none");
			// loadScreen.css("display","none");

			$(".delog").on("mouseover", function(){
				$(".delog p").delay(200).fadeIn(100);
			});

			$(".delog").on("mouseleave", function(){
				$(".delog p").fadeOut(100);
			});

			$(".userr").on("mouseover", function(){
				$(".userr p").delay(250).fadeIn(100);
			});

			$(".userr").on("mouseleave", function(){
				$(".userr p").fadeOut(100);
			});

			$(".rangeSet").on("click",function(){
				// $(".rangeButton").animate({opacity:1},300);
				$("#001-100").animate({top: rangeButtonH*2,opacity:1},500,);
				$("#101-200").animate({top: rangeButtonH*3,opacity:1},500,);
				$("#201-300").animate({top: rangeButtonH*4,opacity:1},500,);
				$("#301-400").animate({top: rangeButtonH*5,opacity:1},500,);
				$("#401-500").animate({top: rangeButtonH*6,opacity:1},500,);
				$("#501-600").animate({top: rangeButtonH*7,opacity:1},500,);
				$("#601-700").animate({top: rangeButtonH*8,opacity:1},500,);
				$("#701-800").animate({top: rangeButtonH*9,opacity:1},500,);
				$("#801-900").animate({top: rangeButtonH*10,opacity:1},500,);
			});

			$(".rangeButton").on("click", function(){
				$(".rangeButton").removeClass("buttonActive");
				$(this).addClass("buttonActive");
				var mavar = $(this).text();
				$(".rangeSet").text(mavar);
				var mav2 = $(".rangeButton").height();
				$(".rangeButton").animate({top:mav2*2, opacity:0},300);
			});



			$(".showListButton").on("click", function(){
				$(".rightColumn").animate({height:"94%"}, 500);
				header.animate({top:0},500);
			});

			menuOpenButton.on("click", function(){
				menu.animate({ left : 0 }, 250);
				$(".desactivApp").fadeIn(250);
			});

			menuCloseButton.on("click", function(){
				menu.animate({ left : -menuW - 5 }, 250);
				$(".desactivApp").fadeOut(250);
			});

			$(".desactivApp").on("click", function(){
				menu.animate({ left : -menuW - 5 }, 250);
				$(this).fadeOut(250);
			});

			// $("#801-900").addClass("buttonActive");
			
			
			profilButton.on("click", function(){
				loadScreen.fadeIn();
			});

			$(".userr").on("click", function(){
				// $(".leftColumn").fadeOut();
				generateAllUsers();
			});

			listNendoroidsButton.on("click", function(){
				generateAllNendo();
				$(".leftColumn").fadeIn();
			});


			$("input").keyup(function(){
				var mot = $( this ).val();
				if (mot !== ''){
					$.ajax({
						url: "{{ path('search_nendoroid_ajax') }}",
						method: "post",
						data: {key : mot}
					})
					.done(function(data){
						var nendoroids = data['nendoroids'];
						generateNendoroidCard(nendoroids);
						$(".leftColumn").fadeIn();
					});
				} 
				else 
				{
					$(".leftColumn").fadeIn();
					generateAllNendo();
				}
			});

			$(".rangeButton").on("click",function(){
				$(".leftColumn").fadeIn();
				var page = $(this).attr("id");
				$.ajax({
					url: "{{ path('generate_list_range_ajax') }}",
					method: "post",
					data: {range : page}
				})
				.done(function(data){
					var nendoroids = data['nendoroids'];
					generateNendoroidCard(nendoroids);
				});
			});
		});

		function generateNendoroidCard(nendoroids){
			var rightColumn = $(".rightColumn");
			var leftColumn = $(".leftColumn");
			var blockResponse = $(".response");
			var nendoroid = nendoroids;
			console.log(nendoroids);
			rightColumn.html('');

			$.each(nendoroids, function(n, nendoroid){
				$("<div/>", {
					id: nendoroid['id'],
					"class": "cardNendo",
					style: "background-image: url('/otakuProject/web/images/nendoroids/"+nendoroid['number']+".jpg');",
					mouseover: function(){
						$(".cardNendoNumber"+nendoroid['id']+", .cardNendoName"+nendoroid['id']).addClass("testeffect");
						$(".cardNendoMoreInformations"+nendoroid['id']).addClass("testeffect2");

					},
					mouseleave: function(){
						$(".cardNendoNumber"+nendoroid['id']+", .cardNendoName"+nendoroid['id']).removeClass("testeffect");
						$(".cardNendoMoreInformations"+nendoroid['id']).removeClass("testeffect2");
					}
				}).appendTo(".rightColumn");

				$("<div/>", {
					"class": "cardNendoContent cardNendoContent"+nendoroid['id']
				}).appendTo("#"+nendoroid['id']);

				$("<div/>", {
					"class": "cardNendoInnerBorder cardNendoInnerBorder"+nendoroid['id']
				}).appendTo(".cardNendoContent"+nendoroid['id']);

				$("<div/>", {
					"class": "cardNendoLikeButtonBox cardNendoLikeButtonBox"+nendoroid['id']
				}).appendTo(".cardNendoInnerBorder"+nendoroid['id']);

				$("<i/>", {
					"class": "far fa-heart cardNendoLikeButton"+nendoroid['id']+" hvr-shrink",
					click: function(){
 						$(this).addClass("hvr-push");
 						$.ajax({
 							url: "{{ path('nendoroid_ajax') }}",
 							method: "post",
 							data: {idNendo : nendoroid['id'], action : "addLike"}
 						})
 						.done(function(data){
 							$(".cardNendoLikeButton"+nendoroid['id']).addClass('fas');

 							var response = data['message'];
 							blockResponse.css("background-color", "lightgreen");
 							blockResponse.text(response[0]['message']);
 							blockResponse.addClass("responseActive");
 							setTimeout(function () {
 								$('.response').removeClass("responseActive");
 							}, 1500);
 						})
 						.fail(function(){
 							blockResponse.text("Something went wrong");
 							blockResponse.css("background-color", "red");
 							blockResponse.addClass("responseActive");
 							setTimeout(function () {
 								blockResponse.removeClass("responseActive");
 							}, 1500);
 						});
 					}
				}).appendTo(".cardNendoLikeButtonBox"+nendoroid['id']);

				$("<div/>", {
					"class": "cardNendoNumber cardNendoNumber"+nendoroid['id'],
					text: "#"+nendoroid['number']
				}).appendTo(".cardNendoInnerBorder"+nendoroid['id']);
				
				$("<div/>", {
					"class": "cardNendoName cardNendoName"+nendoroid['id'],
					text: nendoroid['name']
				}).appendTo(".cardNendoInnerBorder"+nendoroid['id']);

				$("<div/>", {
					"class": "cardNendoMoreInformations cardNendoMoreInformations"+nendoroid['id']+" hvr-shrink",
					text: "info",
					click: function(){
						var headerH = $("header").height();

						$(".leftColumn").html("");
						$(".rightColumn").animate({height:"0%"},500);
						$("header").animate({top: -headerH},500);

						$("<div/>", {
							"class": "leftColumnContent"
						}).appendTo(".leftColumn");

						$("<div/>", {
							"class": "informationsName",
							text: nendoroid['name']
						}).appendTo(".leftColumnContent");

						$("<div/>", {
							"class": "imgContent"
						}).appendTo(".leftColumnContent");

						$("<img/>", {
							src: "/otakuProject/web/images/nendoroids/"+nendoroid['number']+".jpg"
						}).appendTo(".imgContent");

						$("<div/>", {
							"class": "actionButtons"
						}).appendTo(".leftColumnContent");

						$("<div/>", {
							"class": "addLikeButton"
						}).appendTo(".actionButtons");

						$("<div/>", {
							"class": "addCollectionButton"
						}).appendTo(".actionButtons");

						$("<div/>", {
							"class": "informationsNumber",
							text: "#"+nendoroid['number']
						}).appendTo(".leftColumnContent");
					}
				}).appendTo(".cardNendoInnerBorder"+nendoroid['id']);
			});
		}	

		function generateUser(users){
			var rightColumn = $(".rightColumn");
			var leftColumn = $(".leftColumn");
			var blockResponse = $(".response");
			
			console.log(users);
			rightColumn.html('');

			$.each(users, function(u, user){
				$("<div/>", {
					id: "user"+user['id'],
					"class": "cardUser hvr-shrink",
					text: user['username'],
					
					click: function(){

						var myuser = user['username'];
						var url = '{{ path("otaku_project_user", {'username': 'parameterValue'}) }}'; 
    					url = url.replace("parameterValue", myuser);
						window.location.href = url;
					}
				}).appendTo(".rightColumn");
			});
			
			$("<i/>", {
				"class": "fas fa-user"					
			}).appendTo(".cardUser");
		}

		function generateAllNendo(nendoroids){
			$.ajax({
				url: "{{ path('generate_list_ajax') }}",
				method: "post"
			})
			.done(function(data){
				var nendoroids = data['nendoroids'];
				generateNendoroidCard(nendoroids);
				getAllLists();
				$('.loadScreen').fadeOut(1000);
			});
		}

		function generateAllUsers(users){
			$.ajax({
				url: "{{ path('list_users_ajax') }}",
				method: "post"
			})
			.done(function(data){
				var users = data['users'];
				generateUser(users);
				$('.loadScreen').fadeOut(1000);
			});
		}

		function getAllLists() {
			$.ajax({
				url: "{{ path('get_all_lists') }}",
				method: "post"
			})
			.done(function(data){
				var allLists = data['nendoroids'];
				console.log(allLists);
				$.each(allLists, function(n, nendoroid){
					$(".cardNendoLikeButton"+nendoroid['id']).addClass('fas');
				});
			});
		}