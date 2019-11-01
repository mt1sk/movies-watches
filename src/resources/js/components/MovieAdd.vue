<template>
    <div>
        <a @click="isNewVisible = !isNewVisible" class="badge badge-info" href="javascript:;">Adding</a>
        <form v-show="isNewVisible" class="mt-2">
            <div class="alert alert-danger mt-3" v-if="form.errors.length > 0">
                <!--<p class="mb-0"><strong>Whoops!</strong> Something went wrong!</p>-->
                <ul>
                    <li v-for="error in form.errors">
                        {{ error }}
                    </li>
                </ul>
            </div>
            <div class="form-row">
                <div class="form-group col-sm-6">
                    <label for="movieName">Title</label>
                    <input v-model="form.name" type="text" name="name" class="form-control" id="movieName" placeholder="Title">
                </div>
                <div class="form-group col-sm-2">
                    <label for="movieCount">Watches</label>
                    <input v-model="form.count" type="text" name="count" class="form-control" id="movieCount" placeholder="Watches count">
                </div>
                <div class="form-group col-sm-4">
                    <label for="movieYear">Watch year</label>
                    <input v-model="form.year" type="text" name="year" class="form-control" id="movieYear" placeholder="Watch year">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-sm-4">
                    <label for="movieDuration">Movie duration</label>
                    <input v-model="form.duration" type="text" name="duration" class="form-control" id="movieDuration" placeholder="Movie duration">
                </div>
            </div>
            <button type="submit" class="btn btn-success" @click.prevent="addMovie">Add...</button>
        </form>
    </div>
</template>

<script>
    export default {
        name: "MovieAdd",
        data() {
            return {
                isNewVisible: false,
                form: {
                    name: '',
                    count: 1,
                    year: new Date().getFullYear().toString(),
                    duration: '',
                    errors: [],
                }
            }
        },

        methods: {
            addMovie() {
                axios.post('/api/v1/movies', this.form)
                    .then(response => {
                        this.isNewVisible = false;
                        this.form.errors = [];
                        this.$emit('updateMoviesList');
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