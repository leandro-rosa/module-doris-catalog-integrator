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
        'uiComponent',
        'LeandroRosa_DorisCatalogIntegrator/js/product-integrator/console',
        'LeandroRosa_DorisCatalogIntegrator/js/product-integrator/modal',
        'jquery',
        'ko',
        'mage/storage',
        'mage/translate',
    ], function (
        Component,
        dorisConsole,
        dorisModal,
        $,
        ko,
        storage,
        __
    ) {
        'use strict';

        return Component.extend({
            isLocked: ko.observable(false),
            dorisConsole: dorisConsole,

            initialize: function () {
                this._super();
            },

            openModalPipeline: function () {
                dorisModal.openModalPipeline(this.isLocked);
            },

            flushPipelines: function () {
                $.ajax({
                    url: `${window.adminAnalyticsMetadata.secure_base_url}${this.options.flush_pipelines_url}`,
                    method: 'DELETE',
                    beforeSend: function (xhr) {
                        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
                    },
                    headers: {
                        'doris-api-key': this.options.doris_api_key,
                        'doris-secret-key': this.options.doris_secret_key,
                        'website-id': this.options.website_id,
                    },

                    success: (response) => {
                        dorisConsole.addTextToConsole({
                            value: `Hello human! Doris product integration pipelines has been flushed.`,
                        })
                    },

                    error: (error) => {
                        dorisConsole.addTextToConsole({
                            value: `Error to flush pipelines - ${error.message}`,
                            cssClass: 'doris-error'
                        });
                    },
                });
            },

            startPipeline: function () {
                this.isLocked(true);
                dorisConsole.clearConsole();
                $.ajax({
                    url: `${window.adminAnalyticsMetadata.secure_base_url}${this.options.create_pipeline_url}`,
                    method: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify({
                        pipeline: {
                            run_by: `${this.options.user.username} <${this.options.user.email}>`
                        }
                    }),
                    beforeSend: function (xhr) {
                        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
                    },
                    headers: {
                        'doris-api-key': this.options.doris_api_key,
                        'doris-secret-key': this.options.doris_secret_key,
                        'website-id': this.options.website_id,
                    },

                    success: (response) => {
                        console.log(response)
                        const now = new Date()
                        dorisConsole.addTextToConsole({
                            value: `Hello human! Doris product integration pipeline has been created at ${now.toLocaleDateString()} ${now.toLocaleTimeString()}.`,
                        })

                        this.createDorisProduct(response.entity_id);
                    },

                    error: (error) => {
                        dorisConsole.addTextToConsole({
                            value: `Error to export product - ${error.message}`,
                            cssClass: 'doris-error'
                        });
                    },
                });
            },

            createDorisProduct: function (pipelineId) {
                $.ajax({
                    url: `${window.adminAnalyticsMetadata.secure_base_url}${this.options.create_doris_product_url}`,
                    method: 'POST',
                    contentType: 'application/json',
                    beforeSend: function (xhr) {
                        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
                    },
                    headers: {
                        'doris-api-key': this.options.doris_api_key,
                        'doris-secret-key': this.options.doris_secret_key,
                        'website-id': this.options.website_id,
                    },
                    data: JSON.stringify({pipelineId}),

                    success: (response) => {
                        if (!response || !response.length) {
                            const now = new Date();
                            dorisConsole.addTextToConsole({
                                value: `Good bye human! Doris product integration pipeline has been finished at ${now.toLocaleDateString()} ${now.toLocaleTimeString()}.`,
                                cssClass: 'doris-info'
                            });
                            this.isLocked(false);
                            return;
                        }

                        const items = {};
                        response.forEach(item => {
                            if (!item?.response?.identifier || !item?.response?.sku_id) return;
                            items[item.response.identifier] = items[item.response.identifier] || [];
                            items[item.response.identifier].push({
                                identifier: item.response.identifier,
                                sku: item.response.sku_id,
                                error_message: item?.response?.error_message ? JSON.parse(item?.response?.error_message) : null
                            });
                        });


                        for (let i = 0; i < Object.keys(items).length; i++) {
                            const identifier = Object.keys(items)[i];

                            dorisConsole.addTextToConsole({
                                value: `Identifier: ${identifier}`,
                                cssClass: 'doris-item'
                            });
                            for (let j = 0; j < items[identifier].length; j++) {
                                const item = items[identifier][j];
                                if (item?.error_message) {
                                    dorisConsole.addTextToConsole({
                                        value: ` * ${item.sku}: Error ${item.error_message.message}`,
                                        cssClass: 'doris-error'
                                    });
                                    continue;
                                }

                                dorisConsole.addTextToConsole({
                                    value: ` * ${item.sku}: has been exported successfully.`,
                                    cssClass: 'doris-item'
                                })
                            }
                        }

                        this.createDorisProduct(pipelineId)

                    },

                    error: (error) => {
                        console.error(error);
                        dorisConsole.addTextToConsole({
                            value: `Error to export product - ${error.message}`,
                            cssClass: 'doris-error'
                        });
                        this.createDorisProduct(pipelineId)


                    },
                });
            },

        });
    }
);
