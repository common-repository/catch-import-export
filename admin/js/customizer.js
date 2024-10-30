( function( $ ) {

	var CIE = {
	
		init: function()
		{
			$( 'body' ).on( 'click', 'input[name=cie-export-button]', CIE._export ); 
			$( 'body' ).on( 'click', 'input[name=cie-import-button]', CIE._import );
		},
	
		_export: function()
		{	
			
			window.location.href = CIEConfig.customizerURL + '?cie-export=' + CIEConfig.exportNonce;
		},
	
		_import: function()

		{	
			var win			= $( window ),
				body		= $( 'body' ),
				form		= $( '<form class="cie-form" method="POST" enctype="multipart/form-data"></form>' ),
				controls	= $( '.cie-import-controls' ),
				file		= $( 'input[name=cie-import-file]' ),
				message		= $( '.cie-uploading' );
			
			if ( '' == file.val() ) {
				alert( CIEl10n.emptyImport );
			}
			else {
				win.off( 'beforeunload' );
				body.append( form );
				form.append( controls );
				message.show();
				form.submit();
			}
		}
	};
	
	$( CIE.init );
	
})( jQuery );