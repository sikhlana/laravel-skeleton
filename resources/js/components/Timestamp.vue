<template>
    <time :datetime="timestamp">{{ str }}</time>
</template>

<script>
    import moment from 'moment-timezone';

    export default {
        props: {
            timestamp: {
                type: String,
                required: true,
            }
        },

        computed: {
            str() {
                return moment.tz(this.timestamp, 'UTC').clone().tz(this.$timezone).format('dddd, MMMM D');
            },
        },

        data() {
            return {
                $timezone: moment.tz.guess(),
            };
        }
    }
</script>
