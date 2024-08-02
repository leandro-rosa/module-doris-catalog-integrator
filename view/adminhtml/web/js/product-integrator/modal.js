/**
 * Leandro Rosa
 *
 * NOTICE OF LICENSE
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Doris Module to newer
 * versions in the future. If you wish to customize it for your
 * needs please refer to https://developer.adobe.com/commerce/docs/ for more information.
 *
 * @category LeandroRosa
 *
 * @copyright Copyright (c) 2024 Leandro Rosa (https:www.rosa-planet.com.br)
 *
 * @author Leandro Rosa <dev.leandrorosa@gmail.com>
 */
define(
    [
        'Magento_Ui/js/modal/modal',
        'jquery',
        'ko',
        'Magento_Ui/js/modal/confirm',
        'mage/translate',
    ], function (
        modal,
        $,
        ko,
        confirm,
        __
    ) {
        'use strict';

        return {
            isLocked: ko.observable(false),
            requestItems: ko.observableArray([]),
            modalPipeline: null,
            modalPipelineElement: null,

            modalPipelineOptions: {
                'type': 'slide',
                'responsive': true,
                'title': 'Doris Product Integrator Pipeline',
                'innerScroll': true,
                'buttons': [],
                'clickableOverlay': false,
            },

            openModalPipeline: function (isLocked = this.isLocked) {
                this.isLocked = isLocked;
                this.isLocked.subscribe(value => {
                    if (value) {
                        this.lockUnload();
                        return;
                    }
                    this.unlockUnload();
                })

                this.modalPipelineElement = $('#doris-pipeline-modal');
                this.modalPipeline = modal(this.modalPipelineOptions, this.modalPipelineElement);
                this.modalPipelineElement.modal().on('modalclosed', () => {
                    if (!this.isLocked()) return;

                    confirm({
                        content: __('Please don\'t close it until the pipeline has finished!'),
                        actions: {
                            confirm: () => {
                                this.openModalPipeline();
                                return false;
                            },
                            cancel: () => {
                                this.openModalPipeline();
                                return false;
                            }
                        }
                    });
                });
                this.modalPipelineElement.modal('openModal');
            },

            lockUnload: function () {
                window.addEventListener("beforeunload", function (event) {
                    event.preventDefault();
                });
            },

            unlockUnload: function () {
                this.isLocked(false);
            },
        };
    }
);
