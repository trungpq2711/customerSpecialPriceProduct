define([
    'jquery',
    'mage/translate',
    'underscore',
    'Magento_Catalog/js/price-utils',
    'jquery-ui-modules/widget'
], function ($, $t, _, priceUtils) {
    'use strict';

    $.widget('mage.customPrice', {

        /** @inheritdoc */
        _create: function () {
            var self = this;
            let elements = $(this.options.element);
            let params = [];
            let productIds = [];
            _.each(elements, function(e) {
                params[$(e).data('id')] = $(e);
                productIds.push($(e).data('id'));
            });

            $.ajax({
                url: self.options.url,
                data: {
                    productIds: productIds,
                },
                type: 'POST',
                dataType: 'json',
                success: function(data, status, xhr) {
                    _.each(data, function (priceData) {
                        params[priceData.product_id].html('<label>' + self.options.label + '</label> ' + priceUtils.formatPrice(priceData.price, self.options.formatPrice)
                        );
                    });
                },
                error: function (xhr, status, errorThrown) {
                    console.log(errorThrown);
                }
            });
        }
    });

    return $.mage.customPrice;
});
