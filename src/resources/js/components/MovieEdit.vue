<template>
    <!--<div>{{ movieForm.name }}</div>-->
    <div>
        <div class="container pt-2">
            <div class="row justify-content-center">
                <form class="mt-2" @keydown="movieForm.errors.clear($event.target.name)">
                    <div class="alert alert-danger mt-3" v-if="movieForm.errors.message">
                        <p class="mb-0"><strong>Whoops!</strong> Something went wrong!</p>
                        <p class="mb-0">{{ movieForm.errors.message }}</p>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-sm-12">
                            <label for="movieName">Title</label>
                            <input v-model="movieForm.name" type="text" name="name" class="form-control" id="movieName" placeholder="Title">
                            <small class="form-text text-danger" v-show="movieForm.errors.has('name')">{{ movieForm.errors.get('name') }}</small>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-sm-12">
                            <label for="movieDuration">Movie duration</label>
                            <input v-model="movieForm.duration" type="text" name="duration" class="form-control" id="movieDuration" placeholder="Movie duration">
                            <small class="form-text text-danger" v-show="movieForm.errors.has('duration')">{{ movieForm.errors.get('duration') }}</small>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success" :disabled="movieForm.errors.any()" @click.prevent="saveMovie">Save...</button>
                </form>
            </div>
        </div>

        <div class="container pt-4" v-if="watches.length > 0">
            <div class="row justify-content-center">
                <h3>Watches list</h3>
            </div>
            <movie-watch v-for="watch in watches" :key="watch.id" :watch="watch" @watchDeleted="removeWatch(watch.id)"></movie-watch>
        </div>
    </div>
</template>

<script>
    import Form from "../classes/Form";
    import MovieWatch from "./MovieWatch";

    export default {
        name: "MovieEdit",

        components: {
            MovieWatch,
        },

        data() {
            return {
                watches: [],
                movieForm: new Form({
                    name: '',
                    duration: 0,
                })
            }
        },

        mounted() {
            this.getMovie(this.$route.params.id);
        },

        beforeRouteUpdate (to, from, next) {
            this.getMovie(to.params.id);
            next();
        },

        methods: {
            getMovie(id) {
                this.movieForm.get('/api/v1/movies/' + id)
                    .then(response => {
                        let movie = response.data.data;
                        for (let field in this.movieForm.data()) {
                            this.movieForm[field] = movie[field];
                        }

                        this.watches = movie.watches;
                    });
            },

            saveMovie() {
                this.movieForm.patch('/api/v1/movies/' + this.$route.params.id)
                    .then(response => {
                        let movie = response.data.data;
                        for (let field in this.movieForm.data()) {
                            this.movieForm[field] = movie[field];
                        }
                    });
            },

            removeWatch(id) {
                const index = this.watches.findIndex(watch => watch.id == id);
                if (index === -1) return;
                this.watches.splice(index, 1);
            }
        },
    }
</script>

<style scoped>

</style>