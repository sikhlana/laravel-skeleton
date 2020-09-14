<template>
    <div id="notification" :class="type + (hidden ? '' : ' show')">
        <p class="message">{{ message }}</p>
        <i class="close icon" @click="hide"></i>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                type: '',
                message: '',
                hidden: true,
            }
        },

        methods: {
            show() {
                if (!! this.$timeout) {
                    window.clearTimeout(this.$timeout);
                }

                this.hidden = false;
            },

            hide() {
                this.hidden = true;

                if (!! this.$timeout) {
                    window.clearTimeout(this.$timeout);
                }
            },
        },

        created() {
            this.$root.$on('notify', (type, message, timeout) => {
                this.type = type;
                this.message = message;

                this.show();

                if (typeof timeout === 'number') {
                    this.$timeout = window.setTimeout(() => {
                        this.hide();
                    }, timeout);
                }
            });

            this.$root.$on('notify.close', () => {
                this.hide();
            })
        }
    }
</script>
