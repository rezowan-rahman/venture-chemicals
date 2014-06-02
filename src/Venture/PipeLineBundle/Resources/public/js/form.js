jQuery(document).ready(function(e) {
    jQuery('select#venture_pipelinebundle_pipeline_customer').prop('selected', true).change(function(){
        var id =  jQuery(this).val();
        var url = Routing.generate('venture_customer_details_from_pipe_line');

        jQuery.post(url, {'customerId': id}, function(result){
            jQuery("input#venture_pipelinebundle_pipeline_contact").val(result.contact);
            jQuery("input#venture_pipelinebundle_pipeline_phone").val(result.phone);
            jQuery("input#venture_pipelinebundle_pipeline_email").val(result.email);
        });
    });
});