// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue';

Vue.config.productionTip = false

/* eslint-disable no-new */
new Vue({

    el: '#app',

    data() {
        return {
            content: null,
            config: {
                height: 100,
                toolbar: [
                    // [groupName, [list of button]]
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['gxcode']], // plugin: summernote-ext-codewrapper
              ],
            },
        };
    },

    components: {
        'summernote' : require('./Summernote')
    }
})
