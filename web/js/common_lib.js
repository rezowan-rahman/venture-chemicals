/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

function confirmDel() {
    return confirm("Are you sure you want to delete this");
}

jQuery(document).on("click", "button.target", function(e) {
    var obj = jQuery(this);
    var url = obj.data("path");

    if(obj.hasClass('confirm')) {
        if(!confirm("Are you sure you want to delete ?")) {
            return false;
        }
    }

    window.location = url;
});

function delTHis(obj){
    if(!confirm("Are you sure you want to delete?")) return false;
    jQuery(obj).parent().remove();
    return true;
}

function addTagFormDeleteLink($tagFormLi) {
    var $removeFormA = jQuery('<div class="row"><div class="col-md-10"></div><div class="col-md-2"><a class="del_prop" href="#">Delete</a></div></div>');
    $tagFormLi.after($removeFormA);

    $removeFormA.on('click', function(e) {
        e.preventDefault();

        $tagFormLi.remove();
        $removeFormA.remove();
    });
}

function addTagForm($collectionHolder, $container) {
    var prototype = $collectionHolder.data('prototype');
    var index = jQuery("div."+$container).length;
    var newForm = prototype.replace(/__name__/g, index);
    var str = "<div class='row "+$container+"'></div>";
    var $newFormLi = jQuery(str).append(newForm);

    $collectionHolder.before($newFormLi);
    addTagFormDeleteLink($newFormLi);
}



