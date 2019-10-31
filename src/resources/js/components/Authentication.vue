<template>
    <div class="container pt-2">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Authentication</div>

                    <div class="card-body">
                        <tabs>
                            <tab name="Sign in" :selected="true">
                                <div class="alert alert-danger" v-if="loginForm.errors.length > 0">
                                    <!--<p class="mb-0"><strong>Whoops!</strong> Something went wrong!</p>-->
                                    <ul>
                                        <li v-for="error in loginForm.errors">
                                            {{ error }}
                                        </li>
                                    </ul>
                                </div>

                                <div class="form-group">
                                    <label for="loginEmail">Email address</label>
                                    <input v-model="loginForm.email" type="email" class="form-control" id="loginEmail" aria-describedby="emailHelp" placeholder="Enter email">
                                    <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                                </div>
                                <div class="form-group">
                                    <label for="loginPassword">Password</label>
                                    <input v-model="loginForm.password" type="password" class="form-control" id="loginPassword" placeholder="Password">
                                </div>
                                <!--<div class="form-group form-check">
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                    <label class="form-check-label" for="exampleCheck1">Check me out</label>
                                </div>-->
                                <button type="submit" class="btn btn-primary" @click="login">Log in</button>
                            </tab>

                            <tab name="Registration">
                                <div class="alert alert-danger" v-if="registerForm.errors.length > 0">
                                    <!--<p class="mb-0"><strong>Whoops!</strong> Something went wrong!</p>-->
                                    <ul>
                                        <li v-for="error in registerForm.errors">
                                            {{ error }}
                                        </li>
                                    </ul>
                                </div>

                                <div class="form-group">
                                    <label for="registerEmail">Email address</label>
                                    <input v-model="registerForm.email" type="email" class="form-control" id="registerEmail" placeholder="Enter email">
                                </div>
                                <div class="form-group">
                                    <label for="registerName">Name</label>
                                    <input v-model="registerForm.name" type="text" class="form-control" id="registerName" placeholder="Enter name">
                                </div>

                                <div class="form-group">
                                    <label for="registerPassword">Password</label>
                                    <input v-model="registerForm.password" type="password" class="form-control" id="registerPassword" placeholder="Password">
                                </div>
                                <div class="form-group">
                                    <label for="registerPasswordConfirmation">Password confirmation</label>
                                    <input v-model="registerForm.password_confirmation" type="password" class="form-control" id="registerPasswordConfirmation" placeholder="Confirm your password">
                                </div>

                                <button type="submit" class="btn btn-primary" @click="register">Sign up</button>
                            </tab>
                        </tabs>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Tabs from './Tabs.vue';
    import Tab from './Tab.vue';
    export default {
        name: "Authentication",
        components: {
            Tabs,
            Tab
        },
        data() {
            return {
                loginForm: {
                    email: '',
                    password: '',
                    errors: [],
                },

                registerForm: {
                    email: '',
                    name: '',
                    password: '',
                    password_confirmation: '',
                    errors: [],
                },
            }
        },

        methods: {
            login() {
                axios.post('/api/v1/login', this.loginForm)
                    .then(response => {
                        this.onAuthSuccess(response);
                    })
                    .catch(error => {
                        EventVue.$emit('requestFailure', error, this.loginForm);
                    });
            },

            register() {
                axios.post('/api/v1/register', this.registerForm)
                    .then(response => {
                        this.onAuthSuccess(response);
                    })
                    .catch(error => {
                        EventVue.$emit('requestFailure', error, this.registerForm);
                    });
            },

            onAuthSuccess(response) {
                localStorage.accessToken = response.data.data.token.access_token;
                window.axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.accessToken;
                EventVue.$emit('resetGlobal');
            },
        },
    }
</script>

<style scoped>

</style>