function calculateTotalCost(obj) {
    var className = jQuery(obj).attr("class");
    var serial = jQuery(obj).index("input."+className);
    
    if(jQuery("input.pre_freight_cost").eq(serial).val() == "" && 
            jQuery("input.freight_cost").eq(serial).val() == "") return false;
    
    var pre_freight_cost = parseFloat(jQuery("input.pre_freight_cost").eq(serial).val());
    var freight_cost = parseFloat(jQuery("input.freight_cost").eq(serial).val());
    
    return jQuery(obj).val(pre_freight_cost + freight_cost);
}

function calculateCostPerUnit(obj) {
    var className = jQuery(obj).attr("class");
    var serial = jQuery(obj).index("input."+className);
    
    if(jQuery("input.amount_shipped").eq(serial).val() == "") return false;
    
    var total_cost = parseFloat(jQuery("input.pre_freight_cost").eq(serial).val()) +
            parseFloat(jQuery("input.freight_cost").eq(serial).val());
    var amount_shipped = parseFloat(jQuery("input.amount_shipped").eq(serial).val());
    
    return jQuery(obj).val(total_cost/amount_shipped);
}

jQuery(document).ready(function(e) {
    jQuery("button.target").on("click",function(e) {
        var obj = jQuery(this);
        var msg = "";
        
        if(obj.hasClass("confirm")) msg = obj.data("message");
        
        if(msg != "") {
            if(!confirm(msg)) return false;
        }
        
        window.location = obj.data("location");
    });
});
