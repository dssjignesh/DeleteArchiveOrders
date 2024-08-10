/**
 * Digit Software Solutions.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 *
 * @category  Dss
 * @package   Dss_ArchiveOrders
 * @author    Extension Team
 * @copyright Copyright (c) 2024 Digit Software Solutions. ( https://digitsoftsol.com )
 */
define([
    'Magento_Ui/js/form/element/select',
    'uiRegistry',
    'underscore'
], function (Select, uiRegistry, _) {
    'use strict';

    return Select.extend({
        initialize: function () {
            this._super();
            this.actionSelect = uiRegistry.get('index = action');
            this.originalOptions = this.actionSelect.options();
            this.changeDependableFieldsStatus(this.value());
        },
        onUpdate: function (value) {
            this.changeDependableFieldsStatus(value);
            return this._super();
        },
        changeDependableFieldsStatus: function (value) {
            var options = [];
            for (var i = 0; i < this.originalOptions.length; i++) {
                options.push(this.originalOptions[i]);
            }
            if (value == '0') {
                options.splice(0, 1);//unset archive action
            }
            this.actionSelect.setOptions(options)
        }
    });
});