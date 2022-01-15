
<div class="banner" >

    <!-- form for finding places -->
    <div class="city-form">
        <p class="city-form-title">
            <strong>Find the best places to visit</strong>
        </p>


        <form action="/redirect-search" method="post">
            @csrf
        <div class="city-form-select">




            <input id="places-select"  name="places"  type="text" placeholder="I'm looking for..." >



            <select class="" id="city-select" name="city" required>
                <option value="" disabled selected>Top Cities</option>
                <option value="35.6762,139.6503">Tokyo</option>
                <option value="35.4437,139.6380">Yokohama</option>
                <option value="35.0116,135.7681">Kyoto</option>
                <option value="34.6937,135.5023">Osaka</option>
                <option value="43.0618,141.3545">Sapporo</option>
                <option value="35.1815,136.9066">Nagoya</option>
            </select>

            <input id="radius" type="number" placeholder="Radius" name="radius" required>



        </div>


        <button class="city-form-button" type="submit">Let's Go!</button>
        </form>






    </div>
    <!-- end of form for finding places -->

</div>


<div class="japan-desc">

    <h2 class="japan-desc-header">
        Top Cities In Japan
    </h2>

    <div class="japan-desc-cards-row">

        <div class="japan-city-card">
            <div class="card">
                <img src="/images/tokyo.jpg">
                <h3>Tokyo</h3>
                <p>
                    Tokyo is Japan's capital and the world's most populous metropolis.
                    It is also one of Japan's 47 prefectures, consisting of 23 central city wards and multiple cities,
                    towns and villages west of the city center.
                    The Izu and Ogasawara Islands are also part of Tokyo. Prior to 1868, Tokyo was known as Edo.
                </p>
            </div>
        </div>

        <div class="japan-city-card">
            <div class="card">
                <img src="images/yokohama.jpg">
                <h3>Yokohama</h3>
                <p>
                    Yokohama, city and port, capital of Kanagawa ken (prefecture),
                    east-central Honshu, Japan. The second most populous city in the country,
                    it is a major component of the Tokyo-Yokohama metropolitan area,
                    the largest urban agglomeration in Japan.
                </p>
            </div>
        </div>

        <div class="japan-city-card">
            <div class="card">
                <img src="/images/kyoto.jpg">
                <h3>Kyoto</h3>
                <p>
                    Kyoto, located in the Kansai region of Japan, is the country's seventh largest city, with a population of 1.4 million people.
                    Steeped in history, Kyoto is home to roughly one quarter of Japan's national treasures,
                    countless shrines and temples, and seventeen sites recognized by UNESCO as World Heritage Sites.
                </p>
            </div>
        </div>


    </div>

    <div class="japan-desc-cards-row" style="margin-top: 4%">

        <div class="japan-city-card">
            <div class="card">
                <img src="/images/osaka.jpg" >
                <h3>Osaka</h3>
                <p>
                    Osaka is a charming, relaxed city best known for its food,
                    fun and nightlife—with some history and culture peeking through.
                    Osaka is only a short shinkansen ride from Tokyo, but has a very different personality to Japan's capital city.
                </p>
            </div>
        </div>

        <div class="japan-city-card">
            <div class="card">
                <img src="/images/sapporo.jpg" >
                <h3>Sapporo</h3>
                <p>
                    Sapporo became world famous in 1972 when the Olympic Winter Games were held there. Today,
                    the city is well known for its ramen, beer, and the annual snow festival held in February
                </p>
            </div>
        </div>

        <div class="japan-city-card">
            <div class="card">
                <img src="/images/nagoya.jpg">
                <h3>Nagoya</h3>
                <p>
                    Nagoya is the largest city in the Chūbu region,
                    the fourth-most populous city and third most populous urban area in Japan,
                    with a population of 2.3 million in 2020. ... Nagoya is an industrial and transport center of Japan.
                </p>
            </div>
        </div>


    </div>

</div>

<div class="lower-banner">
    <div class="lower-banner-description">
        <h2 class="lower-banner-header">Pick the best place for you!</h2>
        <p>
            We will help to find the best place for you! <br>
            Pick a city and search for bar,hotels and more on the top cities we picked for you!
        </p>
    </div>




</div>