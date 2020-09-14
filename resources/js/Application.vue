<script>
    import moment from "moment-timezone";
    import helper from "./services/helper";

    export default {
        created() {
            window.app = this.$root;
            this.$cookies.set('__timezone', moment.tz.guess());
        },

        mounted() {
            helper.activate(this.$el);
        },
    }
</script>
