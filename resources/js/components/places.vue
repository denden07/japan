<template>
    <div class="container-body">
        <!-- Search Bar -->
        <div class="search-bar">

            <input id="places-select-comp" v-model="places"  name="places"  type="text" placeholder="I'm looking for..." >

            <select v-model="city" class="city" id="city-select-comp" name="city" required>
                <option disabled selected>Top Cities</option>
                <option value="35.6762,139.6503">Tokyo</option>
                <option value="35.4437,139.6380">Yokohama</option>
                <option value="35.0116,135.7681">Kyoto</option>
                <option value="34.6937,135.5023">Osaka</option>
                <option value="43.0618,141.3545">Sapporo</option>
                <option value="35.1815,136.9066">Nagoya</option>
            </select>

            <input v-model="radius" id="radius-comp" type="number" placeholder="Radius" name="radius" >

            <button style="background: #1a1e21;color:white" class="btn " @click="fetchPlaces">Let's Go!</button>

            <div class="weather-container" >
            <p style="display: inline">{{weather.weather[0].description}}</p>
            <img :src=" 'http://openweathermap.org/img/w/' + weather.weather[0].icon +'.png'" alt="">
            </div>
        </div>



        <div style="width: 100%;display: flex">
        <div  class="places-list-container">
            <ul class="x">
            <li v-for="jap, key in information.results" :key="key">

            <div @click="fetchPlaceInfo(jap.fsq_id)" class="places-info-container">
                <img v-if="jap.photos[0] != undefined" :src=" jap.photos[0].prefix + '140x140' + jap.photos[0].suffix">
                <img v-else src="https://via.placeholder.com/140.png?text=No+image+available" alt="">
                <p>
                    <i class="fas fa-home" style="color:brown"></i> {{jap.name}}
                </p>
                <p><i class="fas fa-map-marker-alt" style="color:red"></i>{{jap.location.address}}</p>
                <p v-if="jap.rating"><i class="fas fa-star link-primary"></i>{{jap.rating}}</p>
                <p v-else style="color:red">No Rating</p>
            </div>

                <div @click="openPlaceModal(jap.fsq_id)" class="modal-clickable">

                    <img v-if="jap.photos[0] != undefined" :src=" jap.photos[0].prefix + '140x140' + jap.photos[0].suffix">
                    <img v-else src="https://via.placeholder.com/140.png?text=No+image+available" alt="">
                    <p>
                        <i class="fas fa-home" style="color:brown"></i> {{jap.name}}
                    </p>
                    <p><i class="fas fa-map-marker-alt" style="color:red"></i>{{jap.location.address}}</p>
                    <p v-if="jap.rating"><i class="fas fa-star link-primary"></i>{{jap.rating}}</p>
                    <p v-else style="color:red">No Rating</p>
                </div>

            </li>
            </ul>



            <!-- Modal Info -->
            <div class="modal fade" id="place-detail-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">  <i class="fas fa-home" style="color:brown"></i> {{desc.name}}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="closeModal">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">

                            <div v-if="descShow">

                                <div v-if="desc.photos.length>0"   id="carousel-1" class="carousel slide" data-ride="carousel">
                                    <div class="carousel-inner">
                                        <div class="carousel-item active">

                                            <img class="d-block w-100"  :src="desc.photos[1].prefix + '800x800' + desc.photos[1].suffix">

                                        </div>
                                        <div class="carousel-item" v-for="(img,index,key) in desc.photos.slice(2,desc.photos.length)" :key="key">

                                            <img class="d-block w-100" :src="img.prefix + '800x800' + img.suffix" >

                                        </div>
                                    </div>
                                    <a class="carousel-control-prev" href="#carousel-1" role="button" data-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                    <a class="carousel-control-next" href="#carousel-1" role="button" data-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </div>

                                <div v-else class="">

                                    <h2>No Image Avalible</h2>

                                </div>


                                <div  class="places-description" >
                                    <p><i class="fas fa-home" style="color:brown"></i>{{desc.name}}</p>
                                    <p><i class="fas fa-map-marker-alt" style="color:red"></i>{{desc.location.address}}</p>
                                    <p><i class="fas fa-calendar-week" style="color:blue"></i>{{day}}</p>
                                    <p v-if="desc.hours.open_now" class="link-success"><i class="fas fa-book-open"></i>Open Now</p>
                                    <p v-else class="link-danger"><i class="fas fa-book-open"></i>Closed</p>

                                    <div v-if="desc.hours.regular == undefined || desc.hours.regular.length<0 "><p></p></div>
                                    <div v-else>

                                        <i class="fas fa-clock" style="color:gray"></i> <span v-for="(hour,index) in desc.hours.regular.filter(d =>d.day == today)">
                               {{moment(hour.open,'Hm').format('h:mm a')}}- {{moment(hour.close,'Hm').format('h:mm a')}}
                               <span v-if="index+1 != desc.hours.regular.filter(d =>d.day == today).length">,</span>
                                 </span>

                                    </div>
                                </div>



                                <div v-if="desc.tips.length>0" class="container d-flex justify-content-center mt-100 mb-100">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card">
                                                <div class="card-body">

                                                    <h4 class="card-title">Top 5 tips</h4>

                                                </div>
                                                <div class="" style="overflow-y: scroll;">
                                                    <div v-for="tip in desc.tips" class="comment-widgets m-b-20">
                                                        <div class="d-flex flex-row comment-row">
                                                            <div class="p-2"><span class="round"><img src="https://picsum.photos/id/1/200/200" alt="user" width="50"></span></div>
                                                            <div class="comment-text w-100">
                                                                <div class="comment-footer"> <span class="date">{{moment(tip.created_at).format("MMM Do YY")}}</span></div>

                                                                <p class="">{{tip.text}}</p>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div v-else>
                                    <h2>No tips available</h2>
                                </div>

                            </div>


                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="closeModal">Close</button>

                        </div>
                    </div>
                </div>
            </div>

        </div>



            <!-- Description Section -->
            <div class="places-desc-container">
                <div v-if="descShow" style="width: 40%; padding: 15px">
                <div v-if="desc.photos.length>0"   id="carousel-2" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">

                            <img class="d-block w-100"  :src="desc.photos[1].prefix + '800x800' + desc.photos[1].suffix">

                        </div>
                        <div class="carousel-item" v-for="(img,index,key) in desc.photos.slice(2,desc.photos.length)" :key="key">
                            <img class="d-block w-100" :src="img.prefix + '800x800' + img.suffix" >
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#carousel-2" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carousel-2" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
                    <div v-else class="">
                        <h2>No Image Avalible</h2>
                    </div>

                    <div  class="places-description" >

                        <p><i class="fas fa-home" style="color:brown"></i>{{desc.name}}</p>
                        <p><i class="fas fa-map-marker-alt" style="color:red"></i>{{desc.location.address}}</p>
                        <p><i class="fas fa-calendar-week" style="color:blue"></i>{{day}}</p>
                        <p v-if="desc.hours.open_now" class="link-success"><i class="fas fa-book-open"></i>Open Now</p>
                        <p v-else class="link-danger"><i class="fas fa-book-open"></i>Closed</p>

                        <div v-if="desc.hours.regular == undefined || desc.hours.regular.length<0 "><p></p></div>
                        <div v-else>
                            <i class="fas fa-clock" style="color:gray"></i> <span v-for="(hour,index) in desc.hours.regular.filter(d =>d.day == today)">
                               {{moment(hour.open,'Hm').format('h:mm a')}}- {{moment(hour.close,'Hm').format('h:mm a')}}
                               <span v-if="index+1 != desc.hours.regular.filter(d =>d.day == today).length">,</span>
                           </span>
                        </div>
                    </div>
            </div>

                <!-- Tips Section -->
                <div v-if="descShow"  class="tips-container" >

                    <div v-if="desc.tips.length>0" class="container d-flex justify-content-center mt-100 mb-100">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">

                                        <h4 class="card-title">Top 5 tips</h4>

                                    </div>
                                    <div class="" style="overflow-y: scroll">
                                    <div v-for="tip in desc.tips" class="comment-widgets m-b-20">
                                        <div class="d-flex flex-row comment-row">
                                            <div class="p-2"><span class="round"><img src="https://picsum.photos/id/1/200/200" alt="user" width="50"></span></div>
                                            <div class="comment-text w-100">
                                                <div class="comment-footer"> <span class="date">{{moment(tip.created_at).format("MMM Do YY")}}</span>  </div>
                                                <p class="">{{tip.text}}</p>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div v-else>
                        <h2>No tips available</h2>
                    </div>

                </div>
            </div>
        </div>

    </div>
</template>

<script>

    export default {

        name: "places",
        props : ['placesData','placesDescription','radiusData','llData','weatherData'],

  data()
  {

    return{
        places:'',
        radius:'',
        city:'',
        information: this.placesData,
        desc:{},
        descShow:false,
        day:'',
        today: '',
        weather: this.weatherData
      }

  },

        methods:
            {
                /**
                 *Closes mobile enabled modal
                 */
                closeModal()
                {
                    $('#place-detail-modal').modal('hide');
                },

                /**
                 *Open mobile enabled modal
                 */
                openPlaceModal(e)
                {
                    $('#place-detail-modal').modal('show');
                    this.descShow = true;
                    this.fetchPlaceInfo(e);
                },

                /**
                 *Fetches API data from the backend
                 * Filters places according to ll, radius and type of place
                 */
                fetchPlaces()
                {

                    axios.get('/api/fetch-places',{
                        params:
                            {
                                'city':this.city,
                                'radius':this.radius,
                                'places':this.places,
                            }
                    }).then( res=>{
                        this.information = res.data.places_data;
                        this.weather = res.data.weather_data;

                        this.descShow = false


                    }).catch()

                },

                /**
                 *Fetches data from the api of an specific place
                 */
                fetchPlaceInfo(e)
                {
                    axios.get('/api/fetch-place-description',
                        {
                            params:
                                {
                                    'fsq_id':e,
                                }
                        }).then(({data})=>
                        {
                            this.desc = data;
                            this.descShow =true;
                        })
                },

                /**
                 *Day method for filtering day
                 */
                getDay()
                {
                    const d = new Date();
                    let day = d.getDay();

                    if(day == 0)
                    {
                        this.day = 'Sunday';
                        this.today = 7
                    }else if(day == 1)
                    {
                        this.day ='Monday';
                        this.today = 1

                    }else if(day == 2)
                    {
                        this.day ='Tuesday';
                        this.today = 2
                    }else if(day == 3)
                    {
                        this.day ='Wednesday';
                        this.today = 3
                    }else if(day == 4)
                    {
                        this.day = 'Thursday';
                        this.today = 4
                    }else if(day == 5)
                    {
                        this.day ='Friday';
                        this.today = 5
                    }else if(day == 6)
                    {
                        this.day ='Saturday';
                        this.today = 6
                    }

                }

            },

        computed()
        {
            /**
             *Renders carousel
             */
            carouselController()
            {
                $('#carousel-1').carousel({
                    interval: 4000,
                    wrap: true,
                    keyboard: true
                });
                $('#carousel-2').carousel({
                    interval: 4000,
                    wrap: true,
                    keyboard: true
                });

            }

        },

        mounted()
            {
                /**
                 *For passing v-model value from props
                 */
                this.places = this.placesDescription;
                this.city = this.llData;
                this.radius= this.radiusData;


                this.getDay()


            },

    }
</script>

<style scoped>


</style>