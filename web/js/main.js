/**
 * Created by monika on 17.4.5.
 */

function deleteSkill() {
    var skill_id = $(this).data('id');

    var delete_skill_url = Routing.generate('delete_skill', {
        id: skill_id
    });

    $.ajax({
        url: delete_skill_url,
        method: 'delete',
        data: {
            'skill-id': skill_id
        },
        success: function (response) {
            $('#' + skill_id).remove();
        },
        fail: function (error) {
            console.log('Failed to delete skill');
            console.log(error);
        }
    });
}

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

        var added_skills = $('.added-skills');

        //Add all added skills to profile-edit form
        $('.all-skills').append(added_skills.html());

        //Remove added skills from pop-up
        added_skills.html('');

        //Delete skill after pop-up was closed
        $('.skill-delete').unbind().click(deleteSkill);

        e.preventDefault();
    });

    //Add skill on button click
    $('.add-skill').click(function(){
        var skills_input = $('.skills-input');
        var skill = skills_input.val();

        if(skill) {
            var user_id = $(this).data('id');
            var create_skill_url = Routing.generate('add_skill');

            $.ajax({
                url: create_skill_url,
                method: 'post',
                data: {
                    'skill': skill,
                    'user-id': user_id
                },
                success: function (response) {
                    var inserted_id = response.id;
                    skills_input.val('');
                    $('.added-skills').append('<div id="'+ inserted_id +'" class="skill-block"><span class="skill">' + skill +
                        '</span>' + '<i class="fa fa-times skill-delete" aria-hidden="true" data-id="'+ inserted_id +'"></i></div>');

                    // Delete skill after skill was added
                    $('.skill-delete').unbind().click(deleteSkill);
                },
                fail: function (error) {
                    console.log('Failed to add skill');
                    console.log(error);
                }
            });

        }
    });

    //Add skill, when enter key is pressed
    $('.skills-input').keydown(function(e){
        if(e.which === 13){
            $('.add-skill').click();
        }
    });

    //Delete skill
    $('.skill-delete').unbind().click(deleteSkill);

});
