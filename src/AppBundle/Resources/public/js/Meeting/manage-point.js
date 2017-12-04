let prototype = `<div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-10">
                        <div class="visible point-title">
                            <span class="align-middle">Nouveau point</span>
                        </div>
                        <div>
                            <input class="form-control point-input-title hidden" type="text"
                                   id="meeting_points___name___title"
                                   name="meeting[points][__name__][title]"
                                   required="required" value="Nouveau point">
                        </div>
                    </div>
                    <div class="col-2 text-right">
                     <a href="/reunions/ordre-du-jour/__id__" class="btn btn-outline-dark" title="Éditer le compte rendu officiel"><i class="fa fa-edit fa-lg" aria-hidden="true"></i></a>

                        <button type="button" class="remove-point btn btn-outline-dark"><i class="fa fa-times fa-lg" aria-hidden="true"></i></button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="visible point-report">
                    Entrez votre rapport ici.
                </div>
                <div>
                    <textarea id="meeting_points___name___report" class="form-control point-input-report hidden"
                              name="meeting[points][__name__][report]"
                              required="required">Entrez votre rapport ici.</textarea>
                </div>
            </div>
        </div>`;


/**
 * Ajoute un point au formulaire
 * @param $collectionHolder
 */
let addPointForm = function ($collectionHolder) {
    let index = $collectionHolder.data('index');

    let newForm = prototype;

    newForm = newForm.replace(/__name__/g, index);
    newForm = newForm.replace(/__id__/g, lastId);
    lastId++;
    $collectionHolder.data('index', index + 1);
    let $newFormLi = $('<li></li>').append(newForm);
    $collectionHolder.prepend($newFormLi);
};

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

$(document).ready(function () {
    let $addPointLink = $('#add-point-link');
    let $collectionHolder = $('ul.points');
    let $form = $('form');
    let action = $form.attr('action');
    let $body = $('body');

    $collectionHolder.data('index', $collectionHolder.find(':input').length);

    // Ajoute un nouveau point
    $addPointLink.on('click', function (e) {
        e.preventDefault();
        addPointForm($collectionHolder);
        let data = $form.serialize();
        // $form.submit();
        submit(action, data).then(function (data) {
            console.log(data)
        });

    });

    // Masque le titre et affiche l'input permettant la modification
    $body.on('click', '.point-title', function (e) {
        let $pointInputTitle = $(this).parent().find('.point-input-title');
        $pointInputTitle.toggleClass('hidden visible');
        $pointInputTitle.focus();
        $(this).toggleClass('visible hidden');
    });

    // Masque le champ input, affiche le titre (avec la nouvelle valeur)
    // et actualise la donnée côté serveur
    $body.on('focusout', '.point-input-title', function (e) {
        let data = $form.serialize();

        let $pointTitle = $(this).parent().parent().find('.point-title');
        $pointTitle.toggleClass('hidden visible');
        $pointTitle.text($(this).val());
        $(this).toggleClass('visible hidden');
        submit(action, data).then(function (data) {
            console.log(data);
        });
    });

    // Masque le compte rendu et affiche le textarea permettant de le modifier
    $body.on('click', '.point-report', function (e) {
        let $reportInput = $(this).parent().find('.point-input-report');
        $reportInput.toggleClass('hidden visible');
        $reportInput.focus();
        $(this).toggleClass('visible hidden');
    });

    $body.on('focusout', '.point-input-report', function (e) {
        let data = $form.serialize();

        let $report = $(this).parent().parent().find('.point-report');
        $report.toggleClass('hidden visible');
        $report.text($(this).val());
        $(this).toggleClass('visible hidden');

        submit(action, data).then(function (data) {
            console.log(data);
        })
    });

    $body.on('click', '.remove-point', function (e) {
        e.preventDefault();
        $(this).closest('li').remove();
        let data = $form.serialize();

        submit(action, data).then(function (data) {
            console.log(data);
        })
    });
});