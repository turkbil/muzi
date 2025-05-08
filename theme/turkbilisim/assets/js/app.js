/*---------------------------------------------"
// Template Name: Realtor
// Description:  Realtor Html Template
// Version: 1.0.0

--------------------------------------------*/
(function (window, document, $, undefined) {
  "use strict";
    $(document).pjax('a[data-pjax]', '#pjax-container',{
    fragment: '#pjax-container',
    timeout: 1000
});
    
  var MyScroll = "";
  var Init = {
    i: function (e) {
      Init.s();
      Init.methods();
    },
    s: function (e) {
      (this._window = $(window)),
        (this._document = $(document)),
        (this._body = $("body")),
        (this._html = $("html"));
    },
    methods: function (e) {
      Init.w();
      Init.preloader();
      Init.BackToTop();
      Init.uiHeader();
      Init.slick();
      Init.countdownInit(".countdown", "2025/06/01");
      Init.addFavorite();
       Init.addToPlaylist();
      // Init.audioPlayer();
    },

    w: function (e) {
      this._window.on("load", Init.l).on("scroll", Init.res);
    },

    // =================
    // Preloader
    // =================
    preloader: function () {
      setTimeout(function () {
        $("#preloader").hide("slow");
      }, 2500);
    },

    // =================
    // Bak to top
    // =================
    BackToTop: function () {
      let scrollTop = $(".scroll-top path");
      if (scrollTop.length) {
        var e = document.querySelector(".scroll-top path"),
          t = e.getTotalLength();
        (e.style.transition = e.style.WebkitTransition = "none"),
          (e.style.strokeDasharray = t + " " + t),
          (e.style.strokeDashoffset = t),
          e.getBoundingClientRect(),
          (e.style.transition = e.style.WebkitTransition =
            "stroke-dashoffset 10ms linear");
        var o = function () {
          var o = $(window).scrollTop(),
            r = $(document).height() - $(window).height(),
            i = t - (o * t) / r;
          e.style.strokeDashoffset = i;
        };
        o(), $(window).scroll(o);
        var back = $(".scroll-top"),
          body = $("body, html");
        $(window).on("scroll", function () {
          if ($(window).scrollTop() > $(window).height()) {
            back.addClass("scroll-top--active");
          } else {
            back.removeClass("scroll-top--active");
          }
        });
      }
    },

    // =======================
    //  UI Header
    // =======================
    uiHeader: function () {
      function dynamicCurrentMenuClass(selector) {
        let FileName = window.location.href.split("/").reverse()[0];

        selector.find("li").each(function () {
          let anchor = $(this).find("a");
          if ($(anchor).attr("href") == FileName) {
            $(this).addClass("current");
          }
        });
        selector.children("li").each(function () {
          if ($(this).find(".current").length) {
            $(this).addClass("current");
          }
        });
        if ("" == FileName) {
          selector.find("li").eq(0).addClass("current");
        }
      }

      if ($(".main-menu__list").length) {
        let mainNavUL = $(".main-menu__list");
        dynamicCurrentMenuClass(mainNavUL);
      }

      if ($(".main-menu__nav").length && $(".sidebar-nav__container").length) {
        let navContent = document.querySelector(".main-menu__nav").innerHTML;
        let mobileNavContainer = document.querySelector(".sidebar-nav__container");
        mobileNavContainer.innerHTML = navContent;
      }
      if ($(".sticky-header__content").length) {
        let navContent = document.querySelector(".main-menu").innerHTML;
        let mobileNavContainer = document.querySelector(".sticky-header__content");
        mobileNavContainer.innerHTML = navContent;
      }

      if ($(".sidebar-nav__container .main-menu__list").length) {
        let dropdownAnchor = $(
          ".sidebar-nav__container .main-menu__list .dropdown > a"
        );
        
        dropdownAnchor.each(function () {
          let $anchor = $(this);
        
          // İkonu oluştur ve jQuery ile ekle
          let $toggleIcon = $("<i>").addClass("fa fa-angle-down");
        
          $anchor.attr("aria-label", "dropdown toggler");
          $anchor.append($toggleIcon);
        
          $anchor.on("click", function (e) {
            e.preventDefault();
        
            let $this = $(this);
            $this.toggleClass("expanded");
            $this.parent().toggleClass("expanded");
        
            // Menü içeriğini toggle et (altındaki UL'yi hedef al)
            $this.siblings("ul").slideToggle();
          });
        });
      }

      if ($(".sidebar-nav__toggler").length) {
        $(".sidebar-nav__toggler").on("click", function (e) {
          e.preventDefault();
          $(".sidebar-nav__wrapper").toggleClass("expanded");
          $("body").toggleClass("locked");
        });
      }

      $(window).on("scroll", function () {
        if ($(".stricked-menu").length) {
          var headerScrollPos = 130;
          var stricky = $(".stricked-menu");
          if ($(window).scrollTop() > headerScrollPos) {
            stricky.addClass("stricky-fixed");
          } else if ($(this).scrollTop() <= headerScrollPos) {
            stricky.removeClass("stricky-fixed");
          }
        }
      });
    },


    // =======================
    //  Slick Slider
    // =======================
    slick: function () {
      if ($(".music-slider").length) {
        $('.music-slider').slick({
          slidesToScroll: 1,
          variableWidth: true,
          dots: false,
          arrows: true,
          swipe: true,
          lazyLoad: 'progressive',
          autoplaySpeed: 4000,
          speed: 1000,
        });
      }
    },

    // =======================
    //  Audio Player Function
    // =======================
    audioPlayer: function () {
      if ($(".songs-list").length) {
        var trackPlaying = '',
          audioPlayer = document.getElementById('audio-player');
        var checkelement = '';

        function changeAudio(clickEl, sourceUrl, posterUrl, trackTitle, trackSinger, playAudio = true) {
          var audio = $("#audio-player"),
            playerId = audio.closest('.mejs__container').attr('id'),
            playerObject = mejs.players[playerId];

          if (clickEl == checkelement) {

            if (playerObject.node.paused) {
              playerObject.play();
              jQuery(clickEl).find('i').removeClass('fas fa-play').addClass('far fa-pause');
            } else {
              playerObject.pause();
              jQuery(clickEl).find('i').removeClass('far fa-pause').addClass('fas fa-play');
            }

            return true;
          } else {
            checkelement = clickEl;

            jQuery('.track-list').find('i').removeClass('far fa-pause').addClass('fas fa-play');
          }

          trackPlaying = sourceUrl;

          audio.attr('poster', posterUrl);
          audio.attr('title', trackTitle);

          jQuery('.mejs__layers').html('').html('<div class="mejs-track-artwork"><img src="' + posterUrl + '" alt="Track Poster" /></div><div class="mejs-track-details"><h3>' + trackTitle + '<br><span>' + trackSinger + '</span></h3></div>');

          if (sourceUrl != '') {
            playerObject.setSrc(sourceUrl);
          }
          playerObject.pause();
          playerObject.load();

          if (playAudio == true) {
            playerObject.play();
            jQuery(clickEl).find('i').removeClass('fas fa-play').addClass('far fa-pause');
          }
        }

        

        jQuery(window).on('load', function () {
          var trackOnload = jQuery('#track-onload');

          if (trackOnload.length > 0) {
            var audioTrack = trackOnload.attr('data-track'), // Track url
              posterUrl = trackOnload.attr('data-poster'), // Track Poster Image
              trackTitle = trackOnload.attr('data-title'); // Track Title
            trackSinger = trackOnload.attr('data-singer'); // Track Singer Name

            setTimeout(function () {
              changeAudio(trackOnload, audioTrack, posterUrl, trackTitle, trackSinger, false);
            }, 500);
          }
        });
      }
    },
    // =======================
    //  Coming Soon Countdown
    // =======================
    countdownInit: function (countdownSelector, countdownTime) {
      var eventCounter = $(countdownSelector);
      if (eventCounter.length) {
        eventCounter.countdown(countdownTime, function (e) {
          $(this).html(
            e.strftime(
              '<li><div><h5>%D</h5><h6>Days</h6></div></li>\
              <li><div><h5>%H</h5><h6>Hrs</h6></div></li>\
              <li><div><h5>%M</h5><h6>Min</h6></div></li>\
              <li><div><h5>%S</h5><h6>Sec</h6></div></li>'
            )
          );
        });
      }
    },
    
    addFavorite: function(){
        jQuery('.songs-list').on('click','.add-to-favorite', function () {
            var elem = $(this);
             var song_id = $(this).data("id");
             var status = $(this).attr("data-status");
             if(status == 'true'){
                 status = false;
             }
             else{
                 status = true;
             }
            console.log(status,$(this).attr("data-status"));

             $.ajax({
                url: SITEURL+"/ajax/controller.php",
                type: 'POST',
                data: { process:"add_favorite", song_id : song_id, status : status},
                dataType: 'json', // Dönen veri tipi
                success: function(response) { // Başarılı olursa
                console.log(response);
                    elem.attr("data-status",response.status);
                },
                error: function(xhr, status, error) { // Hata olursa
                    //console.log("Hata:", error);
                }
            });  
        });
    },
    
    
    
    addToPlaylist: function(){
        jQuery('.songs-list').on('click', '.add-to-playlist', function () {
            var song_id = $(this).data("id");
        
            $.ajax({
                url: SITEURL+"/ajax/controller.php",
                type: 'POST',
                data: { process:"get_user_playlists", song_id : song_id},
                dataType: 'json',
                
                success: function(response) {
                    openPlaylistModal(response.playlists, response.song_playlists,song_id);
                },
                error: function(xhr) {
                    console.error('Hata:', xhr.responseText);
                }
            });
        });
        
       $(document).on('change', '.pl-checkbox', function() {
            var pl_id = $(this).data('id');
            var pl_name = $(this).data('name');
            var song_id = $(this).data('song-id');
            var checked = $(this).is(':checked');
    
            $.ajax({
                url: SITEURL+"/ajax/controller.php",
                type: 'POST',
                data: { process:"add_to_playlist", playlist_id : pl_id, playlist_name: pl_name, song_id : song_id, status: checked},
                dataType: 'json',
                success: function(response) {
                     $("#addPlaylist .modal-footer .playlist-response .response").html(response.message).slideDown('fast').delay(3000).slideUp('fast'); 
                },
                error: function(xhr) {
                    console.error('Hata:', xhr.responseText);
                }
            });
        });
        
        $(document).on('click', '#addNewPlaylistBtn', function() {
            $('#addPlaylist').modal('hide');   // Yeni modalı kapat
            $('#addNewPlaylist').modal('show');         // Eski modalı geri aç
        });
        $(document).on('click', '#cancelNewPlaylist', function() {
            $('#addNewPlaylist').modal('hide');   // Yeni modalı kapat
            $('#addPlaylist').modal('show');         // Eski modalı geri aç
        });
        
        $(document).on('click', '#createNewPlaylist', function() {
            var playlistName = $('#newPlaylistName').val().trim();
            var song_id = $(this).data('song-id');
            
            $.ajax({
                url: SITEURL+"/ajax/controller.php",
                type: 'POST',
                data: { process:"create_playlist", playlist_name : playlistName, song_id : song_id},
                dataType: 'json',
                success: function(response) {
                    let html = '';
                    html += `<div class="pl-checkbox-wrapper">
                        <label>
                            <input type="checkbox" class="pl-checkbox" data-id="${response.playlist_id}" data-name="${playlistName}" checked data-song-id="${song_id}"> ${playlistName}
                        </label>
                    </div>`;
                    $('#addNewPlaylist').modal('hide');   
                    $('#addPlaylist').modal('show');    
                    $('#addPlaylist .modal-body').html($('#addPlaylist .modal-body').html()+html);
                    $("#addPlaylist .modal-footer .playlist-response .response").html(response.message).slideDown('fast').delay(3000).slideUp('fast');
                },
                error: function(xhr) {
                    console.error('Liste oluşturulamadı: ' + xhr.responseText);
                }
            });
        });
        
        function openPlaylistModal(playlists, songPlaylists,songID) {
            let html = '';
        
            playlists.forEach(function(playlist) {
                let isChecked = songPlaylists.includes(playlist.id) ? 'checked' : '';
                html += `
                    <div class="pl-checkbox-wrapper">
                        <label>
                            <input type="checkbox" class="pl-checkbox" data-id="${playlist.id}" ${isChecked} data-name="${playlist.title_tr}" data-song-id="${songID}"> ${playlist.title_tr}
                        </label>
                    </div>
                `;
            });
        
            $('#addPlaylist .modal-body').html(html); // modal-body içine yerleştir
            $('#addPlaylist #addNewPlaylistBtn').attr("data-song-id",songID); // modal-body içine yerleştir
            $('#addPlaylist').modal('show'); // modalı aç
            $('#addNewPlaylist #createNewPlaylist').attr("data-song-id",songID); // modal-body içine yerleştir
        }
    },
    
   

  };

  Init.i();
  
  $(document).on('pjax:end', function() {
    console.log("Pjax sayfa yüklendi!");
    Init.i();
});



    $('.playlists-section .more a').on('click', function() {
        var button = $(this);
        var currentPage = parseInt(button.attr('data-page'));
        var nextPage = currentPage + 1;
        var _button_text = button.html();
        button.text('Yükleniyor...');

        $.ajax({
            url:  SITEURL+"/ajax/controller.php",
            type: 'POST',
            data: { process:"load_more_playlist", next_page : nextPage},
            dataType: 'json',
            success: function(data) {
               
                     if (data.more === 0) {
                        button.hide(); // Gösterilecek içerik kalmadı
                     }
                    var template = $('#playlist-template').html();

                    // Her bir öğeyi post-list'e ekle
                    data.playlists.forEach(function (item) {
                        var html = template
                            .replace('{{slug}}', item.slug)
                            .replace('{{title}}', item.title)
                            .replace('{{thumb}}', item.thumb)
                            .replace('{{count}}', item.song_count);
                        $('.playlists-list').append(html);
                    });
                    
                    

                    button.attr('data-page', nextPage);
                    button.html(_button_text);
                
            },
            error: function() {
                button.text('Hata oluştu. Tekrar dene.');
            }
        });
    });
    
    $('.songs-section .more a').on('click', function() {
        var button = $(this);
        var currentPage = parseInt(button.attr('data-page'));
        var nextPage = currentPage + 1;
        var _button_text = button.html();
        button.text('Yükleniyor...');

        $.ajax({
            url:  SITEURL+"/ajax/controller.php",
            type: 'POST',
            data: { process:"load_more_songs", next_page : nextPage},
            dataType: 'json',
            success: function(data) {
               
                     if (data.more === 0) {
                        button.hide(); // Gösterilecek içerik kalmadı
                     }
                     Init.addFavorite();
                    Init.addToPlaylist();
                    var template = $('#song-template').html();
                    // Her bir öğeyi post-list'e ekle
                    data.songs.forEach(function (item) {
                        var html = template
                            .replaceAll('{{i}}', item.i)
                            .replaceAll('{{title}}', item.title)
                            .replaceAll('{{track_path}}', item.file_path)
                            .replaceAll('{{thumb}}', item.thumb)
                            .replaceAll('{{artist_name}}', item.artist_name)
                            .replaceAll('{{duration}}', item.duration)
                            .replaceAll('{{song_id}}', item.song_id)
                            .replaceAll('{{favorite_status}}', item.favorite_status);
                        $('.songs-list').append(html);
                    });
                    
                    

                    button.attr('data-page', nextPage);
                    button.html(_button_text);
                
            },
            error: function() {
                button.text('Hata oluştu. Tekrar dene.');
            }
        });
    });



})(window, document, jQuery);
