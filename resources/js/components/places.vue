<template>
    <div class="container-body">


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

            <button @click="fetchPlaces">Let's Go!</button>

        </div>



        <div style="width: 100%;display: flex">



        <div  class="places-list-container">
            <ul class="x" style="list-style: none;margin-top: 10px">



            <li v-for="jap, key in information.results" :key="key">

            <div @click="fetchPlaceInfo(jap.fsq_id)" class="places-info-container">
                <img v-if="jap.photos[0] != undefined" :src=" jap.photos[0].prefix + '140x140' + jap.photos[0].suffix">
                <img v-else src="https://via.placeholder.com/140.png?text=No+image+available" alt="">
                <p>
                    {{jap.name}}
                </p>

                <p>{{jap.location.address}}</p>

                <p v-if="jap.rating">{{jap.rating}}</p>
                <p v-else>no rating</p>

            </div>



            </li>

            </ul>
        </div>


            <div class="places-desc-container">


                <!--<div v-if="!descShow">-->
                    <!--<p>Select a place to visit</p>-->
                <!--</div>-->
                <!--<div v-else>-->
                    <!--<p>{{desc.rating}} </p>-->
                    <!--<p>{{desc.location.address}}</p>-->
                    <!--<p>{{desc.stats}}</p>-->
                    <!--<p>{{desc.tips}}</p>-->

                <!--</div>-->




                <div class="sliderContainer">
                    <div  class="sliderSlider" >

                        <div class="sliderImg" v-for="img in desc.photos">
                            <img  class="place-image-slide" :src=" img.prefix + '800x800' + img.suffix">

                        </div>

                    </div>
                    <div class="controllers">
                        <button class="btn prevBtn"><i class="fas fa-chevron-left"></i></button>
                        <button class="btn nextBtn"><i class="fas fa-chevron-right"></i></button>
                    </div>
                    <div class="navigator"></div>
                </div>


            </div>
        </div>

    </div>
</template>

<script>

    export default {

        name: "places",
        props : ['apiData','placesData','radiusData','llData'],
  data()
  {
    return{
        places:'',
        radius:'',
        city:'',
        information: this.apiData,
        desc:{},
        descShow:false,

      }
  },

        methods:
            {

                fetchPlaces()
                {



                    axios.get('/api/fetch-places',{
                        params:
                            {
                                'city':this.city,
                                'radius':this.radius,
                                'places':this.places,
                            }
                    }).then( ({data})=>{
                        this.information = data;
                        this.placesData = '';
                        this.radiusData ='';
                        this.llData ='';

                    }).catch()

                    // this.fetchPlaces();

                },

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
                }
            },



        mounted()
            {

                this.places = this.placesData;
                this.city = this.llData;
                this.radius= this.radiusData;
            },

    }
</script>

<style scoped>
    .sliderContainer {
        position: relative;
        width: 40%;

        overflow: hidden;
        background: #000;
        height:400px
    }

    .sliderSlider > * {
        flex-shrink: 0;
    }

    .sliderSlider {
        display: flex;
        width: 100%;
        height: 100vh;
        transition: all 0.3s ease-in-out;
    }

    .sliderImg {
        height: 100%;
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 10px 10px 235px;
    }

    .place-image-slide {
        height: 100%;
        width: 100%;

    }

    .btn {
        position: absolute;
        width: 60px;
        height: 60px;
        font-size: 20px;
        top: 50%;
        border-radius: 50%;
        border: none;
        outline: none;
        background-color: rgba(19, 19, 19, 0.39);
        color: #fff;
        transform: translateY(-50%);
        cursor: pointer;
        transition: background-color 0.2s ease;
    }

    .btn:hover {
        background-color: rgba(19, 19, 19, 0.829);
    }

    .nextBtn {
        right: 10px;
    }

    .prevBtn {
        left: 10px;
    }

    .navigator {
        position: absolute;
        z-index: 100;
        bottom: 20px;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        padding: 0 20px;
    }

    .navigatorChild {
        height: 12px;
        width: 12px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.479);
        margin: 0 10px;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .navigatorChild:hover {
        box-shadow: 0 0 5px #fff;
    }

    .navigatorChildActive {
        background: rgb(255, 255, 255);
    }

</style>