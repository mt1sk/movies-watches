<template>
    <div class="container pt-2">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Your movies</div>

                    <div class="card-body">
                        <ul>
                            <li v-for="movie in movies">{{ movie.name }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "MoviesList",
        data() {
            return {
                movies: []
            }
        },

        mounted() {
            axios.get('/api/v1/movies').then((response)=>{
                this.movies = response.data.data;
            }).catch(error => {
                if (error.response.status === 401) {
                    location.reload();
                }
                if (typeof error.response.data === 'object') {
                    /*this.form.errors = _.flatten(_.toArray(error.response.data.errors));*/
                } else {
                    /*this.form.errors = ['Something went wrong. Please try again.'];*/
                }
            });
        }
    }
</script>

<style scoped>

</style>