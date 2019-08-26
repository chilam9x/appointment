@extends('layouts.customer')

@section('content')
<div id="online-scheduling">
    <h2 class="text-center">International Students and Scholars Center</h2>
    <div class="container">
        <div class="row">
            <div class="col-sm-12 ">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h5>Online Scheduling</h5>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class=" jumbotron ">
                                <div class="container">
                                    <div id="carousel3d">
                                        <carousel-3d :perspective="0" :space="200" :display="5" :controls-visible="true" :controls-prev-html="'❬'" :controls-next-html="'❭'" :controls-width="30" :controls-height="60" :clickable="true" :autoplay="true" :autoplay-timeout="5000">
                                            <slide :index="0">
                                                <img src="{{ URL::asset('public/img/slider-1.jpg') }}">
                                            </slide>
                                            <slide :index="1">
                                                <span class="title">Web Design</span>
                                                <a href="https://www.youtube.com/channel/UCXTfDJ60DBmA932Du6B1ydg">Click Here</a>
                                            </slide>
                                            <slide :index="2">
                                                <span class="title">You know</span>
                                                <a href="https://www.youtube.com/channel/UCXTfDJ60DBmA932Du6B1ydg">Click Here</a>
                                            </slide>
                                            <slide :index="3">
                                                <span class="title">You know12</span>
                                                <a href="{{ URL::asset('public/img/slider-1.jpg') }}">Click Here</a>
                                            </slide>
                                            <slide :index="4">
                                                <span class="title">You know</span>
                                                <a href="https://www.youtube.com/channel/UCXTfDJ60DBmA932Du6B1ydg">Click Here</a>
                                            </slide>
                                        </carousel-3d>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Add smooth scrolling to all links in navbar + footer link
        $(".navbar a, footer a[href='#myPage']").on('click', function(event) {
            // Make sure this.hash has a value before overriding default behavior
            if (this.hash !== "") {
                // Prevent default anchor click behavior
                event.preventDefault();

                // Store hash
                var hash = this.hash;

                // Using jQuery's animate() method to add smooth page scroll
                // The optional number (900) specifies the number of milliseconds it takes to scroll to the specified area
                $('html, body').animate({
                    scrollTop: $(hash).offset().top
                }, 900, function() {

                    // Add hash (#) to URL when done scrolling (default click behavior)
                    window.location.hash = hash;
                });
            } // End if
        });

        $(window).scroll(function() {
            $(".slideanim").each(function() {
                var pos = $(this).offset().top;

                var winTop = $(window).scrollTop();
                if (pos < winTop + 600) {
                    $(this).addClass("slide");
                }
            });
        });
    })
</script>
<script src='//production-assets.codepen.io/assets/common/stopExecutionOnTimeout-b2a7b3fe212eaa732349046d8416e00a9dec26eb7fd347590fbced3ab38af52e.js'>
</script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/vue/2.1.7/vue.js'></script>
<script src='https://rawgit.com/Wlada/vue-carousel-3d/master/dist/vue-carousel-3d.min.js'></script>
<script>
    new Vue({
        el: '#carousel3d',
        data: {
            slides: 7
        },
        components: {
            'carousel-3d': Carousel3d.Carousel3d,
            'slide': Carousel3d.Slide
        }
    })
    //# sourceURL=pen.js
</script>
@endsection