
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example', require('./components/Example.vue'));

Vue.component('question-follow-button', require('./components/QuestionFollowButton.vue'));
Vue.component('user-follow-button', require('./components/UserFollowButton.vue'));
Vue.component('answer-vote-button', require('./components/AnswerVoteButton.vue'));
Vue.component('send-message', require('./components/SendMessage.vue'));
Vue.component('comment', require('./components/Comment.vue'));
Vue.component('avatar', require('./components/Avatar.vue'));
Vue.component('change-password', require('./components/ChangePassword.vue'));
Vue.component('edit-profile', require('./components/EditProfile.vue'));
Vue.component('has-error', require('vform').HasError);
Vue.component('alert-error', require('vform').AlertError);
Vue.component('alert-success', require('vform').AlertSuccess);


const app = new Vue({
    el: '#app'
});
