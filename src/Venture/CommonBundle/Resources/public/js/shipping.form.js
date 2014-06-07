/**
 * Created by rezowan on 6/7/14.
 */

jQuery(document).on("focus","input.total_cost", function(e) {
    var index = jQuery("input.total_cost").index(jQuery(this));

    var value1 = parseFloat(jQuery("input.pre_freight_cost").eq(index).val());
    var value2 = parseFloat(jQuery("input.freight_cost").eq(index).val());

    return jQuery("input.total_cost").eq(index).val(value1+value2);
});

jQuery(document).on("focus","input.cost_per_unit", function(e) {
    var index = jQuery("input.cost_per_unit").index(jQuery(this));

    var value1 = parseFloat(jQuery("input.total_cost").eq(index).val());
    var value2 = parseFloat(jQuery("input.amount_shipped").eq(index).val());

    return jQuery("input.cost_per_unit").eq(index).val(value1/value2);
});
