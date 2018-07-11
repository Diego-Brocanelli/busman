
<div id="toast">
    <transition name="slide-fade">
        <div v-if="message" class="alert alert-dismissible" :class="'alert-' + type" style="position: absolute; right: 50px; top: 50px; z-index: 100000">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
            @{{ message }}
        </div>
    </transition>
</div>

<script>
    var toast = new Vue({
        el: '#toast',
        data: {
            message: "",
            type: "success"
        },

        methods: {

            success: function (message) {
                this.message = message;
                this.type = 'success';
                this.flush();
            },

            danger: function (message) {
                this.message = message;
                this.type = 'danger';
                this.flush();
            },

            warning: function (message) {
                this.message = message;
                this.type = 'warning';
                this.flush();
            },

            info: function (message) {
                this.message = message;
                this.type = 'info';
                this.flush();
            },


            flush: function () {
                let inst = this;

                setTimeout(function () {
                    inst.message = "";
                    inst.type = "";
                }, 3000);
            }
        }
    });
</script>
