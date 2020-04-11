<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <title>ScreenSaver</title>
        <!-- Icons -->
        <script src="https://unpkg.com/feather-icons"></script>

        <!-- CSS -->
        <link
            rel="stylesheet"
            href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
            integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh"
            crossorigin="anonymous"
        />
        <link
            href="/css/app.css"
            rel="stylesheet"
        />
        <!-- Styles -->
        <style>
        </style>
    </head>
    <body>
        <div id="app">
            <div id="settings-menu">
                <settings-menu></settings-menu>
            </div>
            <div class="flex-center position-ref full-height">
                <div class="content">
                    <div class="title m-b-md text-white font-weight-bold">
                        Welcome User
                    </div>
                    <div class="h2 mb-3 text-white font-weight-bold">
                        What would you like to see today?
                    </div>
                    <form method="POST" action="/">
                        @csrf
                        <div class="form-group mb-2 d-flex justify-content-center">
                            <input
                                class="form-control w-50"
                                type="text"
                                name="image_topic"
                                id="image_topic"
                            />
                        </div>
                        <div><button class="btn btn-primary">Submit</button></div>
                    </form>
    
                    <div id="footer" class="fixed-bottom pb-2 text-light">
                        <div class="d-flex justify-content-between px-3">
                            <div>
                                <a class="d-flex align-items-center" style="cursor: pointer;">
                                    <i data-feather="settings"></i>
                                    <span class="pl-2"
                                        >Image name/location goes here</span
                                    >
                                </a>
                            </div>
                            <div>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
                                    Launch demo modal
                                  </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script
            src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
            integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
            crossorigin="anonymous"
        ></script>
        <script
            src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
            integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
            crossorigin="anonymous"
        ></script>
        <script
            src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
            integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
            crossorigin="anonymous"
        ></script>

        <script src="/js/app.js"></script>

        <script>
            feather.replace();
        </script>
        <script>
            function nextImage() {
                return db.get('images')[0];
            }

            function removeImage() {
                let updated_images = db.get('images').splice(0,1);
                db.set('images', updated_images);
            }

            $(function() {
                var body = $("body");
                body.css({
                    'background': 'url("/images/unsplash.jpg")',
                    "background-position": "50% 50%",
                                "background-repeat": "no-repeat",
                                "background-size": "cover",
                    });
            });
            
            // When we reload the pages, we will have an images array. If it's there store that to the db.
            const images = @json($images);
            if (images.length > 0) {
                // Store images to local
                db.set('images', images);

                // Switch backgound functionalities
                $(function() {
                    var body = $("body");
                    var backgrounds = images.map(image => {
                        return `url(${image.urls.regular})`;
                    });
                    var current = 0;

                    function nextBackground() {
                        body.css({
                            "background": backgrounds[current = ++current % backgrounds.length],
                            "background-position": "50% 50%",
                            "background-repeat": "no-repeat",
                            "background-size": "cover",
                        });
                        setTimeout(nextBackground, 5000);
                    }
                    setTimeout(nextBackground, 1000);
                });
            }
        </script>
    </body>
</html>
