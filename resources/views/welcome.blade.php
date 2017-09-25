<!doctype html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Bus Finder</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
                /* Location of the image */
                  background-image: url(img/land.png);
                  
                  /* Image is centered vertically and horizontally at all times */
                  background-position: center center;
                  
                  /* Image doesn't repeat */
                  background-repeat: no-repeat;
                  
                  /* Makes the image fixed in the viewport so that it doesn't move when 
                     the content height is greater than the image height */
                  background-attachment: fixed;
                  
                  /* This is what makes the background image rescale based on its container's size */
                  background-size: cover;
                  
                  /* Pick a solid background color that will be displayed while the background image is loading */
                  background-color:#464646;
                  
                  /* SHORTHAND CSS NOTATION
                   * background: url(background-photo.jpg) center center cover no-repeat fixed;
                   */
                }

                /* For mobile devices */
            @media only screen and (max-width: 767px) {
              body {
                /* The file size of this background image is 93% smaller
                 * to improve page load speed on mobile internet connections */
                background-image: url(img/port.png);
              }
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
                z-index: 999;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }

            #particles-js {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @if (Auth::check())
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ url('/login') }}">Login</a>
                    @endif
                </div>
            @endif

            <div class="content">
                
            </div>
        </div>
        <div id="particles-js"></div>
        <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
        <script>
            /* particlesJS.load(@dom-id, @path-json, @callback (optional)); */
            particlesJS.load('particles-js', 'js/particlesjs-config.json', function() {
                console.log('callback - particles.js config loaded');
            });
        </script>
    </body>
</html>
