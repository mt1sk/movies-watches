<template>
    <div class="container pt-2">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Your movies</div>

                    <div class="card-body">
                        <movie-add @updateMoviesList="getMovieList"></movie-add>
                        <div class="alert alert-danger mt-3" v-if="form.errors.message">
                            <p class="mb-0"><strong>Whoops!</strong> Something went wrong!</p>
                            <p class="mb-0">{{ form.errors.message }}</p>
                        </div>
                        <ul class="list-group mt-3">
                            <li v-for="movie in movies" class="list-group-item d-flex justify-content-between align-items-center">
                                <router-link :to="{name: 'movie_edit', params: {id: movie.id}}">{{ movie.name }}</router-link>
                                <div>
                                    <span class="badge badge-primary badge-pill"> {{ movie.watches_total }}</span>
                                    <a href="javascript:;" class="badge badge-danger" @click="deleteMovie(movie.id)">Del</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-3 justify-content-center">
            <underline-pagination
                    :response="response"
                    :limit="2"
                    :show-disabled="true"
                    class="flex"
                    @pagination-change-page="handleChangePage"
            ></underline-pagination>
        </div>
    </div>
</template>

<script>
    import MovieAdd from "./MovieAdd";
    import UnderlinePagination from "./pagination/underline-pagination";
    import Form from "../classes/Form";
    export default {
        name: "MoviesList",
        components: {
            MovieAdd,
            UnderlinePagination,
        },
        data() {
            return {
                response: {},
                movies: [],
                form: new Form({
                    params: {
                        page: 1,
                    },
                }),
            }
        },

        mounted() {
            this.getMovieList();
        },

        methods: {
            getMovieList() {
                this.form.get('/api/v1/movies').then(response => {
                        this.movies = response.data.data;
                        this.response = response.data;
                    });
            },

            deleteMovie(id) {
                if (confirm('Are you sure ?!')) {
                    this.form.delete('/api/v1/movies/' + id).then(response => {
                        this.getMovieList();
                    });
                }
            },

            handleChangePage(page) {
                this.form.params.page = page;
                this.getMovieList()
            },
        },
    }
</script>

<style scoped>

</style>