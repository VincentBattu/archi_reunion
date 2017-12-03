/**
 * Formulaire d'ajout d'une réunion
 * @type {jQuery|HTMLElement}
 */
let form = $('#add-meeting-form');

/**
 * Soumet le fomrulaire en AJAX
 * @param action
 * @param data
 * @param method
 * @returns Promise qui permet de définir les action à effectuer après la réponse
 * du serveur.
 */
let submit = function (action, data, method = 'POST') {
    return $.ajax({
        type: method,
        url: action,
        data: data,
        dataType: 'json'
    });
};

/**
 * Écoute de l'évènement de soumission du formulaire.
 */
form.submit(function (e) {
        e.preventDefault();
    let action = form.attr('action');
    let data = form.serialize();
    submit(action, data).then(function (data) {
        if (data.success) {
            $('#meeting-group').prepend(`<a href="${data.url}"
                                   class="list-group-item list-group-item-action">${data.date_formated}
                                   <h5><span class="badge badge-secondary">0</span></h5>
                                   </a>`);
            //TODO ajouter actualisation de la pagination en AJAX
        } else {
            let msg = '';
            Object.keys(data.errors).forEach(function (key) {
                msg += data.errors[key];
            });
            let alert = `<div class="alert alert-warning alert-dismissible fade show" role="alert" id="form-meeting-reunion-alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            ${msg}
                        </div>`;
            $('#alert-container').html(alert);
        }
    });
});