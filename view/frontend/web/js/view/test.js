define([
    'ko',
    'uiComponent',
    'mage/url',
    'mage/storage',
    'jquery',
    'mage/translate'
], function (ko, Component, urlBuilder,storage, $) {
    'use strict';
    var id=1;

    return Component.extend({

        defaults: {
            template: 'Magenest_KnockoutJs/test',
        },

        productList: ko.observableArray([]),

        getProduct: function () {
            var self = this;
            var serviceUrl = urlBuilder.build('knockout/test/product?id='+id);
            id++;
            return storage.post(
                serviceUrl,
                ''
            ).done(
                function (response) {
                    if(!response)
                    {
                        alert($.mage.__("Product #"+id+" not found", '%1'));
                        alert($.mage.__('Test'));
                        return;
                    }
                    self.productList.push(JSON.parse(response));
                }
            ).fail(
                function (response) {
                    console.table(response);
                }
            );
        },

    });
});