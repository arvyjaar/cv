/**
 * Created by monika on 17.4.5.
 */

function deleteEntityFromDb(entity, id) {

    var delete_url = Routing.generate('delete_' + entity, {
        id: id
    });

    $.ajax({
        url: delete_url,
        method: 'delete',
        data: {
            'id': id
        },
        success: function (response) {
            $('#' + id).remove();
        },
        fail: function (error) {
            console.log('Failed to delete ' + entity);
            console.log(error);
        }
    });
}

function deleteRequirement() {
    var requirement_id = $(this).data('id');
    $('#' + requirement_id).remove();
}

function uniqueId() {
    return Math.round(new Date().getTime() + (Math.random() * 100));
}

$(document).ready(function() {
    //TODO refactor all methods
    var requirements = [];

    //Changes navbar padding and background color on main page
    var first_section = $('#some-content');
    if ( first_section && first_section.length ) {
        $('#nav').affix({
            offset: {
                top: first_section.offset().top
            }
        });
    }

    //Styles CV file upload field
    $("#appbundle_jobapply_imageFile_file").jfilestyle({
        buttonBefore: true,
        buttonText: '<i class="fa fa-upload" aria-hidden="true"></i>',
        placeholder: 'Įkelk savo CV'
    });

    //Styles profile image upload field
    $("#fos_user_profile_form_imageFile_file").jfilestyle({
        buttonBefore: true,
        buttonText: '<i class="fa fa-upload" aria-hidden="true"></i>',
        placeholder: 'Įkelk nuotrauką'
    });

    // Changes uploaded file delete label
    var delete_label = $('#fos_user_profile_form_imageFile_delete');
    delete_label.parent("label").html('<input type=' + '"checkbox"'
        + 'id="' + 'fos_user_profile_form_imageFile_delete" name="'
        + 'fos_user_profile_form[imageFile][delete]"' + 'value="1'
        + '" /> Ištrinti?');

    //Datepicker for user profile edit form
    $('.js-datepicker').datepicker({
        dateFormat: 'yy-mm-dd',
        changeMonth: true,
        changeYear: true,
        yearRange: "-70:+0"
    });

    $('#fos_user_profile_form_birthday').click(function () {
        jQuery(this).val('');
    });

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
        var added_requirements = $('.added-requirements');

        //Add all added skills to profile-edit form
        $('.all-skills').append(added_skills.html());

        //Remove added skills from pop-up
        added_skills.html('');

        //Add all added requirement to jobAd-edit form
        $('.all-requirements').append(added_requirements.html());

        //Remove added skills from pop-up
        added_requirements.html('');

        //Delete skill after pop-up was closed
        $('.skill-delete').unbind().click(function() {
            var id = $(this).data('id');
            deleteEntityFromDb('skill', id);
        });

        //Delete requirement after pop-up was closed
        $('.requirement-delete').unbind().click(deleteRequirement);

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
                    $('.added-skills').append('<div id="'+ inserted_id +'" class="skill-block"><span class="skill">'
                        + skill + '</span>' + '<i class="fa fa-times skill-delete" aria-hidden="true" data-id="'
                        + inserted_id +'"></i></div>');

                    $('.added-requirements').append('<div id="'+ inserted_id +'" class="skill-block"><span class="skill">'
                        + skill + '</span>' + '<i class="fa fa-times requirement-delete" aria-hidden="true" data-id="'
                        + inserted_id +'"></i></div>');

                    // Delete skill after skill was added
                    $('.skill-delete').unbind().click(function() {
                        var id = $(this).data('id');
                        deleteEntityFromDb('skill', id);
                    });
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
    $('.skill-delete').unbind().click(function() {
        var id = $(this).data('id');
        deleteEntityFromDb('skill', id);
    });

    //Add requirement on button click
    $('#jobad-create-btn').click(function(){
        var job_add_title = $('#job_ad_title').val();
        var job_add_assignment = $('#job_add_assignment').val();
        var job_add_description = $('#job_add_description').val();

        console.log(job_add_title);
        console.log(requirements);

        var send_data_url = Routing.generate('jobad_new');
        console.log(send_data_url);

        $.ajax({
            url: send_data_url,
            method: 'post',
            data: {
                'data': 'test'
            },
            success: function (response) {
                console.log('success');
                console.log(send_data_url);
            },
            fail: function (error) {
                console.log('Failed to add skill');
                console.log(error);
            }
        });
    });

    $('.add-requirement').click(function(){
        var requirements_input = $('.requirements-input');
        var requirement = requirements_input.val();

        if(requirement) {
            requirements_input.val('');
            requirements.push(requirement);

            $('#job_ad_requirements').val(requirements);

            var inserted_id = uniqueId();

            requirements_input.val('');

            $('.added-requirements').append('<div id="'+ inserted_id +'" class="skill-block"><span class="skill">' + requirement +
                '</span>' + '<i class="fa fa-times requirement-delete" aria-hidden="true" data-id="'+ inserted_id +'"></i></div>');
        }

        // Delete requirement after requirement was added
        $('.requirement-delete').unbind().click(deleteRequirement);
    });

    //Add requirement, when enter key is pressed
    $('.requirements-input').keydown(function(e){
        if(e.which === 13){
            $('.add-requirement').click();
        }
    });

    //Delete requirement
    $('.requirement-delete').unbind().click(deleteRequirement);

    // Delete requirement after requirement was added
    $('.requirement-delete-from-db').unbind().click(function() {
        var id = $(this).data('id');
        deleteEntityFromDb('requirement', id);
    });

});
