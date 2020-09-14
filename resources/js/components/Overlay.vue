<template>
    <div :class="`ui ${size} modal`">
        <i class="close icon"></i>
        <div class="header" v-if="! hideHeader">{{ title }}</div>
        <div ref="contents" :class="`${bodyClass} content`">
            <!-- ajax html goes here. -->
        </div>
    </div>
</template>

<script>
    import Vue from 'vue';
    import api from '../services/api';
    import helper from '../services/helper';

    export default {
        data() {
            return {
                size: 'tiny',
                title: '',
                bodyClass: '',
                hideHeader: false,
            };
        },

        created() {
            this.$root.$on('overlay', (el, e) => {
                this.$refs.contents.innerHTML = '<div id="modal-contents-mount-point"></div>'

                api.get(el.dataset.href || el.getAttribute('href'))
                    .then(({ data }) => {
                        this.size = data.size || 'tiny';
                        this.title = data.title;
                        this.bodyClass = data.class;
                        this.hideHeader = data.hide_modal_header || false;

                        const contents = Vue.extend({
                            template: data.contents,
                        });

                        new contents().$mount('#modal-contents-mount-point');
                        window.$(this.$el).modal('refresh');

                        window.setTimeout(() => {
                            window.$(this.$el).modal('show');

                            window.setTimeout(() => {
                                helper.activate(this.$refs.contents);
                            }, 800);
                        }, 100);
                    });
            });
        },
    }
</script>
