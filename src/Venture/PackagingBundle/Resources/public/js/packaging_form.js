function delTHis(obj){
    jQuery(obj).parent().remove();
    return false;
}

var $collectionHolder;

var $addTagLink = $('<button type="button" class="add_ship">Add Ordering Details</button> ');
var $newLinkLi = $('<li></li>').append($addTagLink);

jQuery(document).ready(function() {
    
    $collectionHolder = $('ul.shipping');
    $collectionHolder.append($newLinkLi);
    $collectionHolder.data('index', $collectionHolder.find(':input').length);

    $addTagLink.on('click', function(e) {
        e.preventDefault();
        addTagForm($collectionHolder, $newLinkLi);
    });
});

function addTagForm($collectionHolder, $newLinkLi) {
    var prototype = $collectionHolder.data('prototype');
    var index = $collectionHolder.data('index');

    var newForm = prototype.replace(/__name__/g, index);

    $collectionHolder.data('index', index + 1);

    var $newFormLi = $('<li></li>').append(newForm);
    $newLinkLi.before($newFormLi);
    addTagFormDeleteLink($newFormLi);
}

function addTagFormDeleteLink($tagFormLi) {
    var $removeFormA = $('<a href="#" class="del_prop">Delete</a>');
    $tagFormLi.append($removeFormA);

    $removeFormA.on('click', function(e) {
        e.preventDefault();
        $tagFormLi.remove();
    });
}

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