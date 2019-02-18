<template>
    <modal :name="name"
            transition="pop-out"
            :width="modalWidth"
            :height="'auto'"
            :pivotY="0.2"
            :draggable="'.title-bar'"
            v-bind:class="{'v--modal-minimize': minimize}"
            :reset="true"
            :adaptive="true"
            @closed="closed"
            @before-open="beforeOpen(name)"
    >
        <div class="modal inmodal in" role="dialog" style="z-index: 1040; display: block; padding-left: 17px;">
            <div class="modal-dialog">
                <div class="modal-content animated bounceInDown">
                    <div class="modal-header">
                        <h4 class="modal-title">{{ title }}</h4>
                        <div class="action-block" v-if="!hideCloseButton">
                            <a href="#" class="close" data-dismiss="modal" aria-label="Close" @click="close()">
                                <span aria-hidden="true">×</span>
                            </a>
                            <!--<button type="button" data-dismiss="modal" class="btn btn-default btn-sm" aria-hidden="true" @click="close()">×</button>-->
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <slot></slot>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </modal>
</template>

<script>
    let MODAL_WIDTH = 456;

    export default {
        name: "modal-template",
        props: {
            name: {
                type: String,
                default: () => 'modal'
            },
            title: {
                type: String,
                default: () => 'MODAL'
            },
            description: {
                type: String,
                default: () => ''
            },
            split: {
                type: Boolean,
                default: () => false
            },
            width: {
                type: Number,
                default: () => 456
            },
            onShow: {
                type: Function,
                default: () => {}
            },
            onHide: {
                type: Function,
                default: () => {}
            },
            hideCloseButton: {
                type: Boolean,
                default: () => false
            },
        },
        data () {
            return {
                modalWidth: MODAL_WIDTH,
                minimize: false,
                tmpActive: null,
            }
        },
        created () {
            MODAL_WIDTH = this.width;
            this.modalWidth = window.innerWidth < MODAL_WIDTH
                ? MODAL_WIDTH / 2
                : MODAL_WIDTH
        },
        methods: {
            close(name) {
                let self = this;
                let closeName = name !== undefined ? name : self.name;
                self.$modal.hide(closeName);
            },
            changeMinimize() {
                let self = this;
                self.minimize = !self.minimize;
            },
            closed() {
                let self = this;
                self.$root.options.modal.active = null;
                self.onHide();
                if (self.$root.options.modal.tmpActive !== null) {
                    self.$root.options.modal.active = self.$root.options.modal.tmpActive;
                    self.$root.options.modal.tmpActive = null;
                }
            },
            beforeOpen(name) {
                let self = this;
                let active = self.$root.options.modal.active;
                if (active !== null) {
                    self.close(active);
                    self.$root.options.modal.tmpActive = name;
                } else {
                    self.$root.options.modal.active = name;
                }
                self.onShow();
            }
        }
    }
</script>

<style scoped lang="scss">
    //@import '~vue/../../resources/sass/variables';
    .v--modal {
        .title-bar {
            button {
                width: 12px;
                min-width: 12px;
                height: 12px;
                border-radius: 50%;
                display: inline-block;
                margin: 3px 0 0 0;
                padding: 0;
                position: absolute;
                &:hover {
                    i {
                        display: block;
                    }
                }
                i {
                    display: none;
                    font-size: 8px;
                    position: absolute;
                    top: 1px;
                    left: 1px;
                }
                outline: none;
                left: 8px;
                &:nth-child(2) {
                    left: 25px;
                }
                &.close {
                    background: #ff5c5c;
                    border: 1px solid #e33e41;
                    &:hover {
                        background: #c14645;
                        border: 1px solid #b03537;
                    }
                }
                &.minimize {
                    background: #ffbd4c;
                    border: 1px solid #e09e3e;
                    &:hover {
                        background: #c08e38;
                        border: 1px solid #af7c33;
                    }
                }
            }
        }
    }
    .v--modal-minimize {
        .row-box-split {
            display: none;
        }
        .row-box {
            display: none;
        }
        .v--modal {

        }
    }
    .window-header {
        background-color: #113049;
        z-index: 14100;
        display: inline-block;
        width: 100%;
        padding: 0px 5px;
        cursor: move;
        color: #fff;
        text-align: center;
        /*font-weight: bold;*/
    }
    .title-bar {
        //background: linear-gradient(top, #ebebeb, #d5d5d5);
        color: #4d494d;
        font-size: 11pt;
        line-height: 20px;
        text-align: center;
        width: 100%;
        border-top: 1px solid #f3f1f3;
        //border-bottom: 1px solid #b1aeb1;
        border-top-left-radius: 6px;
        border-top-right-radius: 6px;
        user-select: none;
        cursor: default;
        padding-bottom: 3px;
        display: inline-block;
        padding-top: 3px;
    }
</style>
