This is my functions.php and the following works fine:

// ************************************************
// Your actions:
// ************************************************

add_action( ‘wp_ajax_questiondatahtml’, ‘questiondatahtml_update’ );
add_action( ‘wp_ajax_nopriv_questiondatahtml’, ‘questiondatahtml_update’ );

function questiondatahtml_update() {
if ( $_FILES ) {
require_once(ABSPATH . “wp-admin” . ‘/includes/image.php’);
require_once(ABSPATH . “wp-admin” . ‘/includes/file.php’);
require_once(ABSPATH . “wp-admin” . ‘/includes/media.php’);
$file_handler = ‘updoc’;

// ************************************************
// I have manually inserted the known parent $post_id (113) here
// ************************************************
$attach_id = media_handle_upload($file_handler,’113′ );

// ************************************************
// update parent post to use uploaded attachment as feat. img.
// ************************************************
update_post_meta(‘113′,’_thumbnail_id’,$attach_id);

}
echo “You are done!!”;
wp_die();
}

// ************************************************
// This is one of my actions which is called from an existing post:
// ************************************************

add_action( ‘edd-custom-action’, ‘render_edd_custom_action’, 10, 3 );

function render_edd_custom_action( $form_id, $post_id, $form_settings ) {
$value = ”;

if ( $post_id ) {
$value = get_post_meta( $post_id, ‘edd-custom-action’, true );
}

?>

// ************************************************
// i want to pass this parent $post_id to your upload function:
// I have tried using a hidden input with value of parent $post ID
// and appending to FormData() so i can retrieve the variable
// but i cannot get it to work. Any help very much appreciated.
// ************************************************

$(document).ready(function(){
$(“.default-btn”).click(function(event){
event.preventDefault();
var ajaxurl = “”;
var formData = new FormData();
formData.append(‘updoc’, $(‘input[type=file]’)[0].files[0]);
formData.append(‘action’, “questiondatahtml”);
$.ajax({
url: ajaxurl,
type: “POST”,
data:formData,cache: false,
processData: false, // Don’t process the files
contentType: false, // Set content type to false as jQuery will tell the server its a query string request
success:function(data) {
alert(data);

},

});

});
});
