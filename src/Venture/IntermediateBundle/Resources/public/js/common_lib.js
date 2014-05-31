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

function askAndDelete(path){
    if(confirm("Are you sure to delete this?")) {
        window.location = path;
    } 
    return false;
}

jQuery(document).ready(function(e) {
    jQuery("button.target, input.target").on("click",function(e) {
        if(jQuery(this).hasClass("delete")) {
            if(!confirm("Are you sure to delete this?")) {
                return false;
            }
        }
        window.location = jQuery(this).data("location");
    });
    
    jQuery("a.deleteParentElement").on("click",function(e) {
        if(!confirm("Are you sure to delete this?")) {
            return false;
        }
        jQuery(this).parent().remove();
    });
});

