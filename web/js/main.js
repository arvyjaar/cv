/**
 * Created by monika on 17.4.5.
 */

$(document).ready(function() {
    //Datepicker for user profile edit form;
    $('.js-datepicker').datepicker({ dateFormat: 'yy-mm-dd' });

    //Open pop-up
    $('[data-popup-open]').on('click', function(e)  {
        var targeted_popup_class = jQuery(this).attr('data-popup-open');
        $('[data-popup="' + targeted_popup_class + '"]').fadeIn(350);
        e.preventDefault();
    });

    //Close pop-up
    $('[data-popup-close]').on('click', function(e)  {
        var targeted_popup_class = jQuery(this).attr('data-popup-close');
        $('[data-popup="' + targeted_popup_class + '"]').fadeOut(350);

        e.preventDefault();
    });

    //Add skill
    $(".add-skill").click(function(){
        var skills_input = $('.skills-input');
        var skill = '#' + skills_input.val();

        $('.added-skills').append('<span>' + skill + '</span> ');
        skills_input.val('');

        var create_skill_url = Routing.generate('add_skill');

        $.ajax({
             url: create_skill_url,
             method: "post",
             data: skill,
             datatype: 'json',
             success: function(response) {
                 console.log('success');
             },
             fail: function(error) {
                 console.log('Fail');
                 console.log(error);
             }
         });

    });





});
