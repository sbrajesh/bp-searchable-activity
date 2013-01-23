/* The following code was generously provided by @imath <http://imath.owni.fr/>
 * Please do visit his website <http://imath.owni.fr/> for some awesome BuddyPress/WordPress plugins and tutorials
 */
jQuery(document).ready(function($){
//check if the members/groups/activity etc drop down is available?
    if( $('form#search-form #search-which').length ) {
    
    //do we have some cookie set?
    if (  $.cookie('bp-activity-search-terms') ) {
        //select activity from dd only if we are on activity directory
        if($("body.activity div.activity").get(0)&&!$('body').hasClass('activity-permalink')){//is there a better way to know if we are on activity directory page?
            $('form#search-form #search-which option[value="activity"]').prop( 'selected', true );
            $('form#search-form #search-terms').val( $.cookie('bp-activity-search-terms') );
           
        }
        else{ 
            //clear cookie
            $.cookie( 'bp-activity-search-terms', '', {path: '/'} ); 
        }
    }
    //when the search submit is clicked
    $('#search-submit').click(function(){
        //get and set/remove the cookie with the search term
        if( $('form#search-form #search-which').val() == "activity" ) {
            var search_terms = $('form#search-form #search-terms').val();

            if(search_terms.length == 0)
                $.cookie( 'bp-activity-search-terms', '', {path: '/'} );

        else//let us keep the term
            $.cookie( 'bp-activity-search-terms', search_terms, {path: '/'} );

    } else {
        $.cookie( 'bp-activity-search-terms', '', {path: '/'} );
}

})

}

});