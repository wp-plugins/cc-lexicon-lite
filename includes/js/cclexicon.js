jQuery(document).ready(function(){
	jQuery(".cclexicon-description").hide();
	jQuery(".cclexicon-filter").not("#cclexicon-filter-all").removeClass("cclexicon-filter-selected");
	jQuery("#cclexicon-filter-all").addClass("cclexicon-filter-selected");
	
	// Show selected description, hide others
	jQuery(".cclexicon-term" ).click(function() {
		var parent = "#" + jQuery( this ).closest( '.cclexicon' ).attr("id");
				
		// hide all other descriptions
		jQuery( parent + " .cclexicon-term .cclexicon-description" ).not("#" + this.id + " .cclexicon-description").hide( "slow" );
		// show selected descriptions
		jQuery( "#" + this.id + " .cclexicon-description" ).show( "slow" );
		jQuery( parent + " .cclexicon-term .cclexicon-title" ).not("#" + this.id + " .cclexicon-title").removeClass("cclexicon-title-selected");
		jQuery( "#" + this.id + " .cclexicon-title").addClass("cclexicon-title-selected");
	});
	
	
	// Filters
	jQuery(".cclexicon-filter" ).click(function() {
		
		// work out class for items to show, based on ID
		var index_start = this.id.lastIndexOf('-');
		var lexiconclass = "cclexicon-index" + this.id.substring(index_start);
		
		// get ID of parent container so that we can prefix all jQuery calls
		// to work on this lexicon only - in case more than 1 is shown on the page
		var tmp_index = this.id.substring(0,index_start);
		index_start = tmp_index.lastIndexOf('-');
		var parent = "#cclexicon-container" + tmp_index.substring(index_start);
		
		// hide all but the items we want to show
		jQuery( parent + " .cclexicon-term" ).not("." + lexiconclass).hide( "slow" );
		
		// show the filtered items
		jQuery( parent + " ." + lexiconclass).show( "slow" );
		
		if ( lexiconclass == "cclexicon-index-all" ) {
			jQuery(parent + " .cclexicon-anchor-heading").show("slow");
		}
		else {
			jQuery(parent + " .cclexicon-anchor-heading").hide("slow");
		}
		
		// removed "selected" class from the filter list
		jQuery( parent + " .cclexicon-filter" ).not("#" + this.id).removeClass("cclexicon-filter-selected");
		// add "selected" class to the chosen filter
		jQuery( "#" + this.id ).addClass("cclexicon-filter-selected");
		
		// return false to stop click action
		return false;
	});
});