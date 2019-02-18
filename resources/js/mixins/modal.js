let mixins = {
    data: function () {
        return {

        }
    },
    methods: {
        modalShow(name, skipRoute) {
            let self = this;
            self.$modal.show(name);
        },
        modalHide(name) {
            let self = this;
            self.$modal.hide(name);
        },
    }
};

export default mixins;
