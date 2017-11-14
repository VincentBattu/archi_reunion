/**
 * Formulaire d'ajout d'une point
 * @type {jQuery|HTMLElement}
 */
let form = $('#add-point-form');
let pointsList = $('#points-list');

function templater(strings, ...keys) {
    return function(data) {
        let temp = strings.slice();
        keys.forEach((key, i) => {
            temp[i] = temp[i] + data[key];
        });
        return temp.join('');
    }
}

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
 * Template pour l'ajout d'un point
 */
const pointCardTemplate = templater`
<div class="card">
    <div class="card-header">
       ${'title'}
        <small>
            <time class="timeago float-right" datetime="${'date'}"></time>
        </small>
    </div>
    <div class="card-body">
    </div>
</div>`;


/**
 * Actualisation des timestamp
 */
let updateTimestamp = function(){
    $('time.timeago').timeago();
};
updateTimestamp();

form.submit(function (e) {
    e.preventDefault();
    let action = form.attr('action');
    let data = form.serialize();
    submit(action, data).then(function (data) {
        let point = {
            title: data.title,
            date: data.date
        };
        pointsList.prepend(pointCardTemplate(point));
        updateTimestamp();
    });
});