<template>
    <div class="container pt-2">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Your movies</div>

                    <div class="card-body">
                        <movie-add @updateMoviesList="getMovieList"></movie-add>
                        <div class="alert alert-danger mt-3" v-if="form.errors.length > 0">
                            <!--<p class="mb-0"><strong>Whoops!</strong> Something went wrong!</p>-->
                            <ul>
                                <li v-for="error in form.errors">
                                    {{ error }}
                                </li>
                            </ul>
                        </div>
                        <ul class="list-group mt-3">
                            <li v-for="movie in movies" class="list-group-item d-flex justify-content-between align-items-center">
                                {{ movie.name }}
                                <!--<span class="badge badge-primary badge-pill">0</span>-->
                                <a href="javascript:;" class="badge badge-danger" @click="deleteMovie(movie.id)">Del</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import MovieAdd from "./MovieAdd";
    export default {
        name: "MoviesList",
        components: {MovieAdd},
        data() {
            return {
                movies: [],
                form: {
                    errors: [],
                },
            }
        },

        mounted() {
            this.getMovieList();
        },

        methods: {
            getMovieList() {
                axios.get('/api/v1/movies').then((response)=>{
                    this.movies = response.data.data;
                }).catch(error => {
                    EventVue.$emit('requestFailure', error, this.form);
                });
            },

            deleteMovie(id) {
                axios.delete('/api/v1/movies/' + id)
                    .then((response) => {
                        this.getMovieList();
                    })
                    .catch(error => {
                        EventVue.$emit('requestFailure', error, this.form);
                    });
            },
        },
    }
</script>

<style scoped>

</style>