function delTHis(obj){
    if(!confirm("Are you sure you want to delete?")) return false;
    jQuery(obj).parent().remove();
    return true;
}

function addTagForm($collectionHolder, $newLinkLi) {
    // Get the data-prototype explained earlier
    var prototype = $collectionHolder.data('prototype');

    // get the new index
    var index = $collectionHolder.data('index');

    // Replace '__name__' in the prototype's HTML to
    // instead be a number based on how many items we have
    var newForm = prototype.replace(/__name__/g, index);

    // increase the index with one for the next item
    $collectionHolder.data('index', index + 1);

    // Display the form in the page in an li, before the "Add a tag" link li
    var $newFormLi = $('<li></li>').append(newForm);
    $newLinkLi.before($newFormLi);
    addTagFormDeleteLink($newFormLi);
}

function addTagFormDeleteLink($tagFormLi) {
    var $removeFormA = $('<a href="#" class="del_prop">Delete</a>');
    $tagFormLi.append($removeFormA);

    $removeFormA.on('click', function(e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();

        // remove the li for the tag form
        $tagFormLi.remove();
    });
}


function getCustomerData() {
    jQuery('select#venture_pipelinebundle_pipeline_customer').prop('selected', true).change(function(){
        var id =  jQuery(this).val();
        var url = Routing.generate('venture_customer_details_from_pipe_line');

        jQuery.post(url, {'customerId': id}, function(result){
            jQuery("input#venture_pipelinebundle_pipeline_contact").val(result.contact);
            jQuery("input#venture_pipelinebundle_pipeline_phone").val(result.phone);
            jQuery("input#venture_pipelinebundle_pipeline_email").val(result.email);
        });
    });
}

function getStageData() {
    jQuery('select#venture_pipelinebundle_pipeline_stage').prop('selected', true).change(function(){
        var id =  jQuery(this).val();
        var url = Routing.generate('venture_stage_details_from_pipe_line');

        jQuery.post(url, {'stageId': id}, function(result){
            jQuery("input#venture_pipelinebundle_pipeline_probability").val(result.name);
        });
    });
}


var $collectionHolder;

// setup an "add a tag" link
var $addTagLink = $('<button type="button" class="add_prop">Add Note</button> ');
var $newLinkLi = $('<li></li>').append($addTagLink);

var $addTagLink2 = $('<button type="button" class="add_ship">Add sales year</button> ');
var $newLinkLi2 = $('<li></li>').append($addTagLink2);

jQuery(document).ready(function() {
    // Get the ul that holds the collection of tags

    $collectionHolder = $('ul.spec');
    $collectionHolder2 = $('ul.shipping');
    //$collectionHolder.find('li').each(function() {
    //addTagFormDeleteLink($(this));
    //});

    // add the "add a tag" anchor and li to the tags ul
    $collectionHolder.append($newLinkLi);
    $collectionHolder2.append($newLinkLi2);

    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    $collectionHolder.data('index', $collectionHolder.find(':input').length);
    $collectionHolder2.data('index', $collectionHolder2.find(':input').length);

    //addTagForm($collectionHolder, $newLinkLi);
    //addTagForm($collectionHolder2, $newLinkLi2);

    $addTagLink.on('click', function(e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();

        // add a new tag form (see next code block)
        addTagForm($collectionHolder, $newLinkLi);
    });

    $addTagLink2.on('click', function(e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();

        // add a new tag form (see next code block)
        addTagForm($collectionHolder2, $newLinkLi2);
    });

    getCustomerData();
    getStageData();
});

jQuery(document).on("focus","input.total", function(e) {
    var index = jQuery("input.total").index(jQuery(this));

    var value1 = parseFloat(jQuery("input.firstQt").eq(index).val());
    var value2 = parseFloat(jQuery("input.secondQt").eq(index).val());
    var value3 = parseFloat(jQuery("input.thirdQt").eq(index).val());
    var value4 = parseFloat(jQuery("input.fourthQt").eq(index).val());

    jQuery("input.total").eq(index).val(value1+value2+value3+value4);
});