define(['jquery','library/helper', 'bootstrap'],function($,h,b){

    'use strict';

    // on deleting agent
    h.pageElement.on('change','[name=transferAgentID]', function(){

        // alert message
        var alert = 'Note: You are about to transfer the leads of this agent to other office/user.';

        // reset alert
        h.pageElement.find('.transfer-alert').remove();

        // check alert
        if($(this).find('option:selected').data('data-1') != h.pageElement.find('[name=hiddenField1]').val()){
            $('[name=transferAgentID]').before('<div class="transfer-alert alert alert-warning">'+alert+'</div>')
        }
    });
    
});
